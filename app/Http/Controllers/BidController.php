<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\Bid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

        $application = Application::find($request->input('application_id'));

        if ($application->status_id != 'Approved') {
            return response()->json(apiResponseHandler([], 'Bids are not allowed', 400), 400);
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

        /**
         * filter bids with score and decide win/lost
         */
        $updatedData = $this->bidFilter($application);

        $realTime = new RealtimeController();

        $allBids = Bid::where('application_id', $application->id)->select('id', 'status','amount','interest_rate','duration','user_id')->get();

        $pushData = [
            'min_bid_score' => $updatedData['min_bid_score'],
            'max_bid_score' => $updatedData['max_bid_score'],
            'avg_term' => round($updatedData['avg_term']),
            'avg_factor' => round($updatedData['avg_factor'], 3),
            'bids' => $allBids,
            'id' => $application->id,
            'latest_bid_by' => Auth::user()->id
        ];

        $realTime->pushFirebase('applications/application_' . $application->id, $pushData);

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
            Log::info($avgFactor);
            Log::info($avgTerm);
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
}
