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

        try{
            $accessToken = $plaid->items->exchangeToken($request->input('public_token'));
            $metaData = $request->input('metadata');
            Application::where('unique_id', $request->input('application_id'))->update([
                'plaid_access_token' => $accessToken->access_token,
                'authorized_bank' => $metaData['institution']['name']
            ]);
            return response()->json(apiResponseHandler([], '', 200), 200);
        }catch (PlaidRequestException $exception){
            return response()->json(apiResponseHandler([], $exception->getMessage(), 400), 400);
        }
    }

    /**
     * @return Plaid
     */
    public function getPlaidClient()
    {
        return new Plaid(env('PLAID_CLIENT_ID'), env('PLAID_SECRET'), env('PLAID_ENV'));
    }
}
