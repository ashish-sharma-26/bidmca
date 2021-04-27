<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\BankAccount;
use App\Models\Application\Owner;
use App\Models\Common\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(){
        $states = State::all();
        return view('application.create', ['states' => $states]);
    }

    public function store(Request $request){
        $inputData = $request->all();
        if(!$inputData['unique_id']){
            $inputData['unique_id'] = Uuid::uuid4();
        }
        $inputData['loan_amount'] = str_replace(',', '',$inputData['loan_amount']);
        $inputData['due_amount'] = str_replace(',', '',$inputData['due_amount']);
        $inputData['amount_per_year'] = str_replace(',', '',$inputData['amount_per_year']);
        $inputData['status'] = 1;
        $inputData['user_id'] = Auth::user()->id;

        $inputData['loan_amount'] = $inputData['loan_amount'] ? $inputData['loan_amount'] : 0;
        $inputData['due_amount'] = $inputData['due_amount'] ? $inputData['due_amount'] : 0;
        $inputData['amount_per_year'] = $inputData['amount_per_year'] ? $inputData['amount_per_year'] : 0;
        $inputData['status'] = 1;
        unset($inputData['authCheck']);
        if($request->input('action') === 'draft'){
            $application = $this->storeAction($inputData);
            if($inputData['unique_id']){
                $this->storeOwners($inputData);
                $this->storeBank($inputData);
            }
        }

        if($request->input('action') === 'step1'){
            $validator = Validator::make($request->all(), [
                'business_name' => 'required',
                'state_incorporation_id' => 'required',
                'fed_tax_id' => 'required',
                'industry_type' => 'required',
                'loan_amount' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
            }

            if($request->input('due_status') == 1) {
                $validator = Validator::make($request->all(), [
                    'due_amount' => 'required',
                    'lender_names' => 'required'
                ]);

                if ($validator->fails()) {
                    return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
                }
            }
            $application = $this->storeAction($inputData);
        }

        if($request->input('action') === 'step2'){
            $validator = Validator::make($request->all(), [
                'billing_street_address' => 'required',
                'billing_city_id' => 'required',
                'billing_state_id' => 'required',
                'billing_zipcode' => 'required',
                'billing_phone' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
            }

            if($request->input('mode') == 'Rented') {
                $validator = Validator::make($request->all(), [
                    'amount_per_year' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
                }
            }
            $application = $this->storeAction($inputData);
        }

        if($request->input('action') === 'step3'){
            $validator = Validator::make($request->all(), [
                'owner' => 'required',
                'ownership_percent' => 'required',
                'title' => 'required',
                'last_name' => 'required',
                'first_name' => 'required',
                'dob' => 'required',
                'ssn' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
            }

            $application = $this->storeOwners($inputData);
        }

        if($request->input('action') === 'step4'){
            $validator = Validator::make($request->all(), [
                'bank' => 'required',
                'account_number' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
            }

            if(Auth::user()->user_type === 'Broker')
            {
                $validator = Validator::make($request->all(), [
                    'account_email' => 'required|email'
                ]);

                if ($validator->fails()) {
                    return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
                }

                $message = view('email-templates.authorize')->render();

                sendEmail($message, $request->input('account_email'), 'BIDMCA Application');

            }

            $application = $this->storeBank($inputData);
        }

        if($request->input('action') === 'step5'){
            $inputData['status'] = 4;
            $validator = Validator::make($request->all(), [
                'signature_file' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
            }
            $inputData['status'] = 2;
            $application = $this->storeAction($inputData);
        }

        return response()->json(apiResponseHandler($application, '',200), 200);
    }

    public function storeAction($data){
        $application = Application::updateOrCreate(['unique_id' => $data['unique_id']],$data);

        return $application;
    }

    public function storeOwners($data){
        $appId = Application::where('unique_id',$data['unique_id'])->first();

        Owner::where('application_id',$appId->id)->delete();

        Owner::create([
            'application_id' => $appId->id,
            'owner' => $data['owner'],
            'ownership_percent' => $data['ownership_percent'],
            'title' => $data['title'],
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'dob' => $data['dob'],
            'ssn' => $data['ssn'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        return $appId;
    }

    public function storeBank($data){
        $appId = Application::where('unique_id',$data['unique_id'])->first();

        BankAccount::where('application_id',$appId->id)->delete();

        BankAccount::create([
            'application_id' => $appId->id,
            'bank' => $data['bank'],
            'account_number' => $data['account_number'],
        ]);

        return $appId;
    }

    public function view($id){
        $application = Application::with([
            'state',
            'stateOfIncorporation',
            'owner',
            'bankAccount',
            'bid' => function ($query) {
                $query->where('user_id', Auth::user()->id);
            }
        ])->where('unique_id',$id)->first();
//        dd($application);
        return view('application.single',['application' => $application]);
    }
}
