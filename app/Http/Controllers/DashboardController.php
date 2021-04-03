<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $data = [];
        if(Auth::user()->user_type === 1 || Auth::user()->user_type === 3){
            $application = Application::with(['city', 'state'])
                ->where('user_id', Auth::user()->id)
                ->get();
            $data = ['applications' => $application];
        }
        if(Auth::user()->user_type === 2){
            $application = Application::with(['city', 'state', 'bid' => function ($query) {
                $query->where('user_id', Auth::user()->id);
            }])->get();
            $data = ['openApplications' => $application];
        }
        return view('dashboard.dashboard', $data);
    }
}
