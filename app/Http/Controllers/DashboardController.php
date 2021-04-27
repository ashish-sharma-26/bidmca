<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $data = ['openApplications' => $application];
        }
        return view('dashboard.dashboard', $data);
    }
}
