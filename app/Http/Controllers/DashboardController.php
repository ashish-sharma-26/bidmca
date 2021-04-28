<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use App\Models\Application\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data = [];
        if(Auth::user()->user_type === 'Broker' || Auth::user()->user_type === 'Borrower'){
            $application = Application::with(['state'])
                ->where('user_id', Auth::user()->id)
                ->get();
            $data = ['applications' => $application];
        }
        if(Auth::user()->user_type === 'Lender'){
            $application = Application::with(['state', 'bid' => function ($query) {
                $query->where('user_id', Auth::user()->id);
            }])->where('status', 3)->get();

            $wonBid = Bid::leftJoin('applications','applications.id','bids.application_id')
                ->where('applications.status', 5)
                ->where('bids.status', 1)
                ->where('bids.user_id', Auth::user()->id)
                ->sum('bids.amount');

            $runningBid = Bid::leftJoin('applications','applications.id','bids.application_id')
                ->where('applications.status', 3)
                ->where('bids.status', 1)
                ->where('bids.user_id', Auth::user()->id)
                ->sum('bids.amount');
            $data = ['openApplications' => $application,'wonBid'=>$wonBid, 'runningBid' => $runningBid];
        }
        return view('dashboard.dashboard', $data);
    }
}
