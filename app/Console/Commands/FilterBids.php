<?php

namespace App\Console\Commands;

use App\Models\Application\Application;
use App\Models\Application\Bid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FilterBids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bid:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to notify the kickout bids and users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return boolean
     */
    public function handle()
    {
        $applications = Application::where('status', 3)->get();
        if(count($applications)){
            foreach ($applications AS $application) {
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
                    foreach ($bids AS $bid) {
                        if (count($bids) > 0) {
                            if ($bidsAmount >= $targetAmount) {
                                break;
                            } else {
                                array_push($wonBids, $bid->id);
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

                    // UPDATE APPLICATION MIN/MAX SCORE
                    Application::where('id', $application->id)
                        ->update(['min_bid_score' => $minScore, 'max_bid_score' => $maxScore]);

                    // SEND EMAIL TO LOST USERS
                    $this->sendEmailtoLostUsers($application->id);
                }
            }
        }
        return true;
    }

    /**
     * @param int $applicationId
     * @return bool
     * Send email to lost users
     */
    public function sendEmailtoLostUsers(int $applicationId)
    {
        $lostBids = Bid::with(['user'])
            ->where('application_id', $applicationId)
            ->where('status', 2)
            ->get();

        $template = view('email-templates.lost-bids')->render();
        foreach ($lostBids AS $bid) {
            sendEmail($template, $bid->user->email, 'Alert: Bid Lost ');
        }
        return true;
    }
}
