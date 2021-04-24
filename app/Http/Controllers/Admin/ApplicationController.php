<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function applications(Request $request){
        $applications = Application::with(['user']);
        if($request->status && $request->status != ''){
            $applications = $applications->where('status', $request->status);
        }
        $applications = $applications->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.application.applications', compact('applications'));
    }

    public function applicationStatus(Request $request, $status){
        if($status == 3){
            Application::where('id', $request->application)->update(['status' => $status]);
        }
        if($status == 4){
            Application::where('id', $request->application)->update(['reject_reason' => $request->reason,'status' => $status]);
        }
        return redirect()->back();
    }

    public function viewApplication($id){
        $application = Application::with([
            'state',
            'stateOfIncorporation',
            'owner',
            'bankAccount',
            'bids' => function($query){
                $query->with(['user']);
            }]
        )->where('id',$id)->first();
        return view('admin.application.application-view', compact('application'));
    }
}
