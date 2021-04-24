<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application\Application;
use App\Models\Application\Bid;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        $totalUsers = User::count();
        $totalBorrower = User::where('user_type', 3)->count();
        $totalLender = User::where('user_type', 2)->count();
        $totalBroker = User::where('user_type', 1)->count();

        $totalApplications = Application::count();
        $totalBids = Bid::count();

        return view('admin.index', compact('totalUsers','totalBorrower','totalLender','totalBroker','totalApplications','totalBids'));
    }
}
