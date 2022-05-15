<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application\Application;
use App\Models\Application\Bid;
use App\Models\Plaid\Account;
use App\Models\Plaid\Liability;
use App\Models\Plaid\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function applications(Request $request)
    {
        $applications = Application::with(['user']);
        if ($request->status && $request->status != '') {
            $applications = $applications->where('status', $request->status);
        }
        $applications = $applications->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.application.applications', compact('applications'));
    }

    public function applicationStatus(Request $request)
    {
        if ($request->status == '3') {
            Application::where('id', $request->application)->update(['status' => $request->status, 'reject_reason' => $request->reason, 'closing_date' => $request->closing_date]);

            $score = round($request->bid_term / $request->bid_factor, 2);
            Bid::create([
                'application_id' => $request->application,
                'user_id' => 0,
                'interest_rate' => $request->bid_factor,
                'duration' => $request->bid_term,
                'amount' => str_replace(',', '', $request->bid_amount),
                'score' => $score,
                'is_admin_bid' => 1
            ]);

            /**
             * filter bids with score and decide win/lost
             */
            $application = Application::find($request->application);
            $this->bidFilter($application);
        }
        if ($request->status == '4') {
            Application::where('id', $request->application)->update(['reject_reason' => $request->reason, 'status' => $request->status]);
        }
        return redirect()->back();
    }

    /**
     * @param $application
     * @return mixed
     */
    public function bidFilter($application)
    {

        $bids = Bid::with(['user'])
            ->where('application_id', $application->id)
            ->orderBy('score', 'DESC')
            ->orderBy('amount', 'DESC')
            ->orderBy('updated_at', 'ASC')
            ->get();
        if (count($bids)) {
            $targetAmount = floatval(preg_replace('/[^\d.]/', '', $application->loan_amount));;
            $bidsAmount = 0;
            $wonBids = [];
            $minScore = 0;
            $maxScore = $bids[0]->score;
            $totalTerms = 0;
            $totalFactor = 0;
            foreach ($bids AS $bid) {
                if (count($bids) > 0) {
                    if ($bidsAmount >= $targetAmount) {
                        break;
                    } else {
                        array_push($wonBids, $bid->id);
                        $totalTerms += $bid->duration;
                        $totalFactor += $bid->interest_rate;
                        $bidsAmount += floatval(preg_replace('/[^\d.]/', '', $bid->amount));
                    }
                    $minScore = $bid->score;
                }
            }

            // UPDATE WON BIDS
            DB::table('bids')->where('application_id', $application->id)
                ->whereIn('id', $wonBids)
                ->update([
                    'status' => 1
                ]);

            // UPDATE LOST BIDS
            DB::table('bids')->where('application_id', $application->id)
                ->whereNotIn('id', $wonBids)
                ->update([
                    'status' => 2
                ]);

            // UPDATE APPLICATION MIN/MAX SCORE AND AVG TERM/FACTOR
            $avgFactor = $totalFactor / count($wonBids);
            $avgTerm = $totalTerms / count($wonBids);
            $data = [
                'min_bid_score' => $minScore,
                'max_bid_score' => $maxScore,
                'avg_term' => $avgTerm,
                'avg_factor' => $avgFactor,
            ];
            Application::where('id', $application->id)
                ->update($data);
        }

        return $data;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewApplication($id)
    {
        $application = Application::with([
            'state',
            'stateOfIncorporation',
            'owner',
            'bankAccount'
        ])->where('id', $id)->first();

        $accounts = Account::where('application_id',$id)->get();
        $transactions = Transaction::where('application_id',$id)->get();
        $credits = Liability::where('application_id',$id)->where('type',1)->get();
        $mortgages = Liability::where('application_id',$id)->where('type',2)->get();
        $students = Liability::where('application_id',$id)->where('type',3)->get();

        $bids = Bid::with(['user'])
            ->where('application_id', $id)
            ->orderBy('score', 'DESC')
            ->orderBy('amount', 'DESC')
            ->orderBy('updated_at', 'ASC')
            ->get();

        $adminBid = Bid::where('application_id', $id)
            ->where('is_admin_bid',1)
            ->first();

        $bidCount = Bid::where('application_id', $id)->where('is_admin_bid',0)->count();
        return view('admin.application.application-view', compact('application', 'bids','accounts','transactions','credits','mortgages','students','bidCount','adminBid'));
    }

    public function updateBid(Request $request){
        $score = round($request->edit_bid_term / $request->edit_bid_factor, 2);
        Bid::where('application_id',$request->application)
            ->where('is_admin_bid',1)
            ->update([
            'interest_rate' => $request->edit_bid_factor,
            'duration' => $request->edit_bid_term,
            'amount' => str_replace(',', '', $request->edit_bid_amount),
            'score' => $score
        ]);

        /**
         * filter bids with score and decide win/lost
         */
        $application = Application::find($request->application);
        $this->bidFilter($application);
        return redirect()->back();
    }

    public function closeApplication($id){
        Application::where('id', $id)->update(['status' => 5]);
        return redirect()->back();
    }

    public function createAssetReport(Request $request)
    {
        //echo "hello";
        //echo $config_path = __DIR__.'/../config/settings.php';
        

        $fname = $request->firstName;
        $mname = $request->middleName;
        $lname = $request->lastName;
        $email = $request->email;
        $clientid = env('PLAID_CLIENT_ID');
        $secret = env('PLAID_SECRET');

        $ptoken = $this->createPublicToken($clientid,$secret);
        $atoken = $this->createAccessToken($clientid,$secret,$ptoken);
        $assetReportToken = $this->generateAssetReport($clientid,$secret,$atoken,$fname,$mname,$lname,$email);
        echo $assetReportPdf = $this->createAssetReportPdf($clientid,$secret,$assetReportToken,$atoken);

    }

    public function createPublicToken($client,$secret)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.plaid.com/sandbox/public_token/create',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "client_id": "'.$client.'",
        "secret": "'.$secret.'",
        "institution_id": "ins_3",
        "initial_products": ["auth","transactions","identity","assets","liabilities"],
        "options": {
            "webhook": "https://www.genericwebhookurl.com/webhook"
        }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $object = json_decode($response);
        return $object->public_token;        
       
    }

    public function createAccessToken($client,$secret,$ptoken)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.plaid.com/item/public_token/exchange',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "client_id": "'.$client.'",
            "secret": "'.$secret.'",
        "public_token": "'.$ptoken.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $object2 = json_decode($response);
        return $object2->access_token;
    }

    public function generateAssetReport($client,$secret,$atoken,$fname,$mname,$lname,$email)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sandbox.plaid.com/asset_report/create',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "client_id": "'.$client.'",
            "secret": "'.$secret.'",
           "access_tokens": ["'.$atoken.'"],
           "days_requested": 10,
           "options": {
              "client_report_id": "123456",
              "webhook": "https://www.wirelessciti.com/webhook",
              "user": {
                "client_user_id": "user123456",
                "first_name": "'.$fname.'",
                "middle_name": "'.$mname.'",
                "last_name": "'.$lname.'",
                "ssn": "111-22-1234",
                "phone_number": "1-415-867-5309",
                "email": "'.$email.'"
              }
           }
         }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);        
        curl_close($curl);        
        $object3 = json_decode($response);
        return $object3->asset_report_token;
    }

    public function createAssetReportPdf($client,$secret,$assetReportToken,$atoken)
    {
        $fileD = "assetReport".date('m-d-Y-His').".pdf";
        //echo $path = $_SERVER['DOCUMENT_ROOT'].'/assetreport/'.$fileD;
        $path = 'D:/xampp/htdocs/bidmca/public/assetreport/'.$fileD;

        //die;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.plaid.com/asset_report/pdf/get',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "client_id": "'.$client.'",
            "secret": "'.$secret.'",
        "asset_report_token": "'.$assetReportToken.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $object4 = json_decode($response);
        $err = $object4->error_code;
        $webhookResult = $this->fireWebhook($client,$secret,$atoken);

        if($err!='')
        {            
            return $err;
        }
        else{
            file_put_contents($path, $response);
            return $response;
        }

    }

    public function fireWebhook($client,$secret,$atoken)
    {
                
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.plaid.com/sandbox/item/fire_webhook',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "client_id": "'.$client.'",
            "secret": "'.$secret.'",
            "access_token": "'.$atoken.'",
            "webhook_code": "DEFAULT_UPDATE"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }




}
