<?php

namespace App\Console\Commands;

use App\Models\Application\Application;
use App\Models\Application\Bid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CloseApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to close applications by time';

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
     * @return int
     */
    public function handle()
    {
        $applications = Application::where('status', 3)->where('closing_date', '<', date('Y-m-d H:i:s'))->get();
        if (count($applications) > 0) {
            foreach ($applications AS $application) {
                Application::where('id', $application->id)->update(['status' => 5]);
                $this->sendEmailtoWonUsers($application->id);
            }
        }
        return 0;
    }

    /**
     * @param int $applicationId
     * @return bool
     * Send email to lost users
     */
    public function sendEmailtoWonUsers(int $applicationId)
    {
        $lostBids = Bid::with(['user'])
            ->where('application_id', $applicationId)
            ->where('status', 1)
            ->get();

        $template = view('email-templates.won-bids')->render();
        foreach ($lostBids AS $bid) {
            sendEmail($template, 'kapil@qualwebs.com', 'Bid Won ' . $bid->user->email);
        }
        return true;
    }
}
