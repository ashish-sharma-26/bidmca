<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TomorrowIdeas\Plaid\Plaid;
use TomorrowIdeas\Plaid\Entities\User;
use Illuminate\Support\Facades\Auth;
use TomorrowIdeas\Plaid\PlaidRequestException;
use Illuminate\Support\Facades\Validator;

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
                            $html .= '<tr>';
                            $html .= '<td>' . $accountArray[$transaction->account_id] . '</td>';
                            $html .= '<td>' . $transaction->iso_currency_code . ' ' . $transaction->amount . '</td>';
                            $html .= '<td>' . $merchantName . '</td>';
                            $html .= '<td>' . implode(',', $transaction->category) . '</td>';
                            $html .= '<td>' . $transaction->date . '</td>';
                            $html .= '</tr>';
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

                if($liability->liabilities){
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

    /**
     * @return Plaid
     */
    public
    function getPlaidClient()
    {
        return new Plaid(env('PLAID_CLIENT_ID'), env('PLAID_SECRET'), env('PLAID_ENV'));
    }
}
