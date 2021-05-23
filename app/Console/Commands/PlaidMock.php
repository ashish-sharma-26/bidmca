<?php

namespace App\Console\Commands;

use App\Http\Controllers\RealtimeController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use TomorrowIdeas\Plaid\Plaid;
use TomorrowIdeas\Plaid\PlaidRequestException;

class PlaidMock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plaid:mock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $client = new Plaid(env('PLAID_CLIENT_ID'),env('PLAID_SECRET'),env('PLAID_ENV'));
        try {
            $trx = $client->liabilities->list('access-sandbox-d3755b8f-ffe5-40fc-b0f3-d17be2e0c981');
            Log::debug((array) $trx);
        }
        catch (PlaidRequestException $exception){
            Log::debug($exception->getMessage());
        }
        return 0;
    }
}