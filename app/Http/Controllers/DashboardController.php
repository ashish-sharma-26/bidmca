<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $data = [];
        if(Auth::user()->user_type === 1){
            $application = Application::with(['city', 'state'])
                ->where('user_id', Auth::user()->id)
                ->get();
            $data = ['applications' => $application];
        }
        if(Auth::user()->user_type === 2){
            $application = Application::with(['city', 'state', 'bid'])
                ->where('status', 3)
                ->get();
            $data = ['openApplications' => $application];
        }
        return view('dashboard.dashboard', $data);
    }
}
