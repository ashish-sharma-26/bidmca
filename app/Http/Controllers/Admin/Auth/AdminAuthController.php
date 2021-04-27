<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return view('admin.login', compact('error'));
        }
        if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            return redirect()->route('admin_dashboard');
        } else {
            $error = "Unauthenticated";
            return view('admin.login', compact('error'));
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin_login');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            /** Returns error if validation fails **/
            $error = $validator->errors()->first();
            return redirect()->back()->withErrors([$error]);
        }
        $user = auth()->guard('admin')->user();
        $result = Hash::check($request->input('current_password'), $user->password);
        /** Condition check if entered password matched with current password **/
        if ($result == true) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            $success = "Password updated successfully";
            return redirect()->back()->with(['success' => $success]);
            /** Returns error if password not match with current password **/
        } else {
            $error = "Current password not match";
            return redirect()->back()->withErrors([$error]);
        }
    }
}
