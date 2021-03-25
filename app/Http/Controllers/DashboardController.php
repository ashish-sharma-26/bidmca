<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $application = Application::with(['city', 'state'])->where('user_id', Auth::user()->id)->get();
        return view('dashboard.broker', ['applications' => $application]);
    }
}
