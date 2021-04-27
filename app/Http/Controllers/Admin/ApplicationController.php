<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application\Application;
use App\Models\Application\Bid;
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

    public function applicationStatus(Request $request){
        if($request->status == '3'){
            Application::where('id', $request->application)->update(['status' => $request->status, 'closing_date' => $request->closing_date]);
        }
        if($request->status == '4'){
            Application::where('id', $request->application)->update(['reject_reason' => $request->reason,'status' => $request->status]);
        }
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewApplication($id){
        $application = Application::with([
            'state',
            'stateOfIncorporation',
            'owner',
            'bankAccount'
        ])->where('id',$id)->first();

        $bids = Bid::with(['user'])
            ->where('application_id', $id)
            ->orderBy('score', 'DESC')
            ->orderBy('amount', 'DESC')
            ->orderBy('updated_at', 'ASC')
            ->get();
        return view('admin.application.application-view', compact('application','bids'));
    }
}
