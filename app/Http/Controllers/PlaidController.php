<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\Owner;
use App\Models\Plaid\Account;
use App\Models\Plaid\Liability;
use App\Models\Plaid\Transaction;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TomorrowIdeas\Plaid\Plaid;
use TomorrowIdeas\Plaid\Entities\User;
use Illuminate\Support\Facades\Auth;
use TomorrowIdeas\Plaid\PlaidRequestException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class PlaidController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateLinkToken()
    {
        // INIT PLAID CLIENT
        $plaid = $this->getPlaidClient();

        // USER ENTITY PLAID
        $name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $tokenUser = new User(Auth::id(), $name);

        try {
            // GENERATING TOKEN
            $token = $plaid->tokens->create(
                'bidmca plaid',
                'en',
                ['US'],
                $tokenUser,
                ["auth", "transactions"]
            );
            return response()->json(apiResponseHandler($token, '', 200), 200);
        } catch (PlaidRequestException $exception) {
            return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateLinkTokenGuest($appId)
    {
        // INIT PLAID CLIENT
        $plaid = $this->getPlaidClient();

        // APPLICATION
        $application = Application::where('unique_id', $appId)->first();

        if ($application->plaid_access_token) {
            return response()->json(apiResponseHandler([], 'Application already authorized.', 400), 400);
        }

        // APP Owners
        $owners = Owner::where('application_id', $application->id)->first();
        if (!$owners) {
            return response()->json(apiResponseHandler([], 'Application not completed.', 400), 400);
        }
        // USER ENTITY PLAID
        $name = $owners->first_name . ' ' . $owners->last_name;
        $tokenUser = new User($owners->id, $name);

        try {
            // GENERATING TOKEN
            $token = $plaid->tokens->create(
                'bidmca plaid',
                'en',
                ['US'],
                $tokenUser,
                ["auth", "transactions"]
            );
            return response()->json(apiResponseHandler($token, '', 200), 200);
        } catch (PlaidRequestException $exception) {
            return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
        }
    }

    /**
     * @param Request $request
     */
    public function storePublicToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'public_token' => 'required',
            'metadata' => 'required|array',
            'application_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
        }

        $plaid = $this->getPlaidClient();

        try {
            $accessToken = $plaid->items->exchangeToken($request->input('public_token'));
            $metaData = $request->input('metadata');
            Application::where('unique_id', $request->input('application_id'))->update([
                'plaid_access_token' => $accessToken->access_token,
                'authorized_bank' => $metaData['institution']['name']
            ]);
            return response()->json(apiResponseHandler([], '', 200), 200);
        } catch (PlaidRequestException $exception) {
            return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAccountData($id)
    {
        $application = Application::find($id);
        if ($application) {
            $accessToken = $application->plaid_access_token;

            $plaid = $this->getPlaidClient();

            try {
                $accounts = $plaid->accounts->getBalance($accessToken);
                $html = '';
                if ($accounts->accounts) {
                    $accounts = $accounts->accounts;
                    if (count($accounts)) {
                        foreach ($accounts as $account) {
                            $limit = $account->balances->limit ? $account->balances->limit : "N/A";
                            $avilableBalance = $account->balances->available ? $account->balances->iso_currency_code . ' ' . $account->balances->available : 'N/A';
                            $currentBalance = $account->balances->current ? $account->balances->iso_currency_code . ' ' . $account->balances->current : 'N/A';
                            $html .= '<tr>';
                            $html .= '<td><p>' . $account->name . ' ' . '<i class="fa fa-info" data-toggle="tooltip" data-placement="top" title="' . $account->official_name . '"></i></p></td>';
                            $html .= '<td><label class="badge badge-primary">' . $account->type . '</label></td>';
                            $html .= '<td><label class="badge badge-info">' . $account->subtype . '</label></td>';
                            $html .= '<td>' . $avilableBalance . '</td>';
                            $html .= '<td>' . $currentBalance . '</td>';
                            $html .= '<td>' . $limit . '</td>';
                            $html .= '</tr>';

                            Account::create([
                                'application_id' => $id,
                                'account_name' => customEncrypt($account->name),
                                'account_name_alias' => customEncrypt($account->official_name),
                                'account_type' => customEncrypt($account->type),
                                'account_subtype' => customEncrypt($account->subtype),
                                'account_available_balance' => customEncrypt($avilableBalance),
                                'account_current_balance' => customEncrypt($currentBalance),
                                'account_limit' => customEncrypt($limit),
                            ]);
                        }
                    }
                } else {
                    $html = '<p class="text-center">No data found!</p>';
                }
                return response()->json(apiResponseHandler(['data' => $html], '', 200), 200);
            } catch (PlaidRequestException $exception) {
                return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTransactionData($id, Request $request)
    {
        $application = Application::find($id);
        if ($application) {
            $accessToken = $application->plaid_access_token;

            $plaid = $this->getPlaidClient();

            try {
                $start = $request->start;
                $end = $request->end;
                $trxData = $plaid->transactions->list($accessToken, new \DateTime($start), new \DateTime($end));
                $html = '';
                if ($trxData->transactions) {
                    $accounts = $trxData->accounts;
                    $transactions = $trxData->transactions;
                    $accountArray = [];
                    if (count($accounts)) {
                        foreach ($accounts as $account) {
                            $accountArray[$account->account_id] = $account->name;
                        }
                    }
                    if (count($transactions)) {
                        foreach ($transactions as $transaction) {
                            $merchantName = $transaction->merchant_name ? '<p>' . $transaction->merchant_name . ' ' . '<i class="fa fa-info" data-toggle="tooltip" data-placement="top" title="' . $transaction->name . '"></i></p>' : 'N/A';
                            $merchantNamePlain = $transaction->merchant_name ? $transaction->merchant_name : 'N/A';
                            $merchantNameAlias = $transaction->merchant_name ? $transaction->name : 'N/A';
                            $html .= '<tr>';
                            $html .= '<td>' . $accountArray[$transaction->account_id] . '</td>';
                            $html .= '<td>' . $transaction->iso_currency_code . ' ' . $transaction->amount . '</td>';
                            $html .= '<td>' . $merchantName . '</td>';
                            $html .= '<td>' . implode(',', $transaction->category) . '</td>';
                            $html .= '<td>' . $transaction->date . '</td>';
                            $html .= '</tr>';

                            Transaction::create([
                                'application_id' => $id,
                                'account_name' => customEncrypt($accountArray[$transaction->account_id]),
                                'amount' => customEncrypt($transaction->iso_currency_code . ' ' . $transaction->amount),
                                'merchant_name' => customEncrypt($merchantNamePlain),
                                'merchant_name_alias' => customEncrypt($merchantNameAlias),
                                'category' => customEncrypt(implode(',', $transaction->category)),
                                'date' => customEncrypt($transaction->date ),
                            ]);
                        }
                    }
                } else {
                    $html = '<p class="text-center">No data found!</p>';
                }
                return response()->json(apiResponseHandler(['data' => $html], '', 200), 200);
            } catch (PlaidRequestException $exception) {
                return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
            }
        }
    }

    public function fetchLiabilityData($id)
    {
        $application = Application::find($id);
        if ($application) {
            $accessToken = $application->plaid_access_token;

            $plaid = $this->getPlaidClient();

            try {
                $liability = $plaid->liabilities->list($accessToken);

                $credit = '';
                $mortgage = '';
                $student = '';

                if ($liability->liabilities) {
                    if ($liability->accounts) {
                        $accounts = $liability->accounts;
                        $accountArray = [];
                        if (count($accounts)) {
                            foreach ($accounts as $account) {
                                $accountArray[$account->account_id] = $account->name;
                            }
                        }
                    }

                    if ($liability->liabilities->credit) {
                        $credits = $liability->liabilities->credit;
                        if (count($credits)) {
                            foreach ($credits AS $item) {
                                $overdue = $item->is_overdue ? 'Yes' : 'No';
                                $credit .= '<td>' . $accountArray[$item->account_id] . '</td>';
                                $credit .= '<td>' . $overdue . '</td>';
                                $credit .= '<td>USD ' . $item->last_payment_amount . '</td>';
                                $credit .= '<td>' . $item->last_payment_date . '</td>';
                                $credit .= '<td>USD ' . $item->last_statement_balance . '</td>';
                                $credit .= '<td>' . $item->last_statement_issue_date . '</td>';

                                $data = [
                                    'application_id' => $application->id,
                                    'type' => 1,
                                    'account_name' => customEncrypt($accountArray[$item->account_id]),
                                    'overdue' => customEncrypt($overdue),
                                    'last_payment' => customEncrypt('USD '.$item->last_payment_amount),
                                    'last_payment_date' => customEncrypt($item->last_payment_date),
                                    'last_statement' => customEncrypt('USD '.$item->last_statement_balance),
                                    'last_statement_date' => customEncrypt($item->last_statement_issue_date),
                                ];

                                $this->storeLiabilityData($data);
                            }
                        }
                    }

                    if ($liability->liabilities->mortgage) {
                        $mortgages = $liability->liabilities->mortgage;
                        if (count($mortgages)) {
                            foreach ($mortgages AS $item) {
                                $mortgage .= '<td>' . $accountArray[$item->account_id] . '</td>';
                                $mortgage .= '<td>USD ' . $item->origination_principal_amount . '</td>';
                                $mortgage .= '<td>' . $item->origination_date . '</td>';
                                $mortgage .= '<td>' . $item->maturity_date . '</td>';
                                $mortgage .= '<td>' . $item->interest_rate->percentage . '% (' . $item->interest_rate->type . ')' . '</td>';
                                $mortgage .= '<td>USD ' . $item->last_payment_amount . '</td>';
                                $mortgage .= '<td>' . $item->last_payment_date . '</td>';

                                $data = [
                                    'application_id' => $application->id,
                                    'type' => 2,
                                    'account_name' => customEncrypt($accountArray[$item->account_id]),
                                    'principal_amount' => customEncrypt('USD '.$item->origination_principal_amount),
                                    'originate_date' => customEncrypt($item->origination_date),
                                    'maturity_date' => customEncrypt($item->maturity_date),
                                    'ir' => customEncrypt($item->interest_rate->percentage . '% (' . $item->interest_rate->type . ')'),
                                    'last_payment' => customEncrypt('USD '.$item->last_payment_amount),
                                    'last_payment_date' => customEncrypt($item->last_payment_date),
                                ];

                                $this->storeLiabilityData($data);
                            }
                        }
                    }

                    if ($liability->liabilities->student) {
                        $students = $liability->liabilities->student;
                        if (count($students)) {
                            foreach ($students AS $item) {
                                $overdue = $item->is_overdue ? 'Yes' : 'No';
                                $student .= '<td>' . $accountArray[$item->account_id] . '</td>';
                                $student .= '<td>' . $overdue . '</td>';
                                $student .= '<td>' . $item->guarantor . '</td>';
                                $student .= '<td>USD ' . $item->origination_principal_amount . '</td>';
                                $student .= '<td>' . $item->origination_date . '</td>';
                                $student .= '<td>' . $item->loan_status->end_date . '</td>';
                                $student .= '<td>' . $item->interest_rate_percentage . '%' . '</td>';
                                $student .= '<td>USD ' . $item->last_payment_amount . '</td>';
                                $student .= '<td>' . $item->last_payment_date . '</td>';

                                $data = [
                                    'application_id' => $application->id,
                                    'type' => 3,
                                    'account_name' => customEncrypt($accountArray[$item->account_id]),
                                    'overdue' => customEncrypt($overdue),
                                    'guarantor' => customEncrypt($item->guarantor),
                                    'principal_amount' => customEncrypt('USD '.$item->origination_principal_amount),
                                    'originate_date' => customEncrypt($item->origination_date),
                                    'maturity_date' => customEncrypt($item->loan_status->end_date),
                                    'ir' => customEncrypt($item->interest_rate_percentage),
                                    'last_payment' => customEncrypt('USD '.$item->last_payment_amount),
                                    'last_payment_date' => customEncrypt($item->last_payment_date),
                                ];

                                $this->storeLiabilityData($data);
                            }
                        }
                    }
                }
                return response()->json(apiResponseHandler(['credit' => $credit, 'mortgage' => $mortgage, 'student' => $student], '', 200), 200);
            } catch (PlaidRequestException $exception) {
                return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
            }
        }
    }

    public function appBankAuthorize($key)
    {
        try {
            $application = Crypt::decryptString($key);
            $application = Application::where('unique_id', $application)->first();
            return view('application.plaid-auth', compact('application'));
        } catch (DecryptException $e) {
            return redirect()->route('index');
        }
    }

    public function storeLiabilityData($data){
        Liability::create($data);
        return true;
    }

    /**
     * @return Plaid
     */
    public function getPlaidClient()
    {
        return new Plaid(env('PLAID_CLIENT_ID'), env('PLAID_SECRET'), env('PLAID_ENV'));
    }
}
