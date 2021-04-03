<?php

namespace App\Http\Controllers;

use App\Models\Application\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'interest_rate' => 'required',
            'timeframe' => 'required',
            'bid_amount' => 'required',
            'application_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], $validator->errors()->first(), 400), 400);
        }

        Bid::updateOrCreate([
            'application_id' => $request->input('application_id'),
            'user_id' => Auth::user()->id
        ],[
            'application_id' => $request->input('application_id'),
            'user_id' => Auth::user()->id,
            'interest_rate' => $request->input('interest_rate'),
            'duration' => $request->input('timeframe'),
            'amount' => str_replace(',', '',$request->input('bid_amount'))
        ]);

        return response()->json(apiResponseHandler([], '',200), 200);
    }
}
