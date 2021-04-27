<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\Bid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class BidController
 * @package App\Http\Controllers
 */
class BidController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'interest_rate' => 'required',
            'timeframe' => 'required',
            'bid_amount' => 'required',
            'application_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
        }

        $score = number_format($request->input('timeframe') / $request->input('interest_rate'), 2);
        Bid::updateOrCreate([
            'application_id' => $request->input('application_id'),
            'user_id' => Auth::user()->id
        ], [
            'application_id' => $request->input('application_id'),
            'user_id' => Auth::user()->id,
            'interest_rate' => $request->input('interest_rate'),
            'duration' => $request->input('timeframe'),
            'amount' => str_replace(',', '', $request->input('bid_amount')),
            'score' => $score
        ]);

        return response()->json(apiResponseHandler([], '', 200), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validateBidScore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'interest_rate' => 'required',
            'timeframe' => 'required',
            'bid_amount' => 'required',
            'application_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
        }

        $score = number_format($request->input('timeframe') / $request->input('interest_rate'), 2);

        $application = Application::find($request->input('application_id'));

        if ($score < $application->min_bid_score) {
            return response()->json(apiResponseHandler([], 'Your bid conditions for terms & factor are risky as per current scene. You\'re sure to proceed with these values?', 200), 200);
        }

        return response()->json(apiResponseHandler([], '', 200), 200);
    }
}
