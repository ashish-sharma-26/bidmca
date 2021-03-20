<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Auth\otpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    public function sendOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required',
            'tnc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], $validator->errors()->first()), 400);
        }

        // DELETE OLD REQUESTS
        otpVerification::where('phone',$request->input('phone'))->delete();

        // GENERATE NEW
        $otp = generateOtp(4);

        otpVerification::create([
            'phone' => $request->input('phone'),
            'otp' => $otp
        ]);

        sendSMS($request->input('phone'),'Your bidmca verification code is '.$otp);

        return response()->json(apiResponseHandler(['otp'=>$otp], 'OTP sent Successfully.',200),200);
    }

    public function verifyOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], $validator->errors()->first()), 400);
        }

        $verify = otpVerification::where('phone',$request->input('phone'))->where('otp',$request->input('otp'))->count();

        if($verify == 1){
            // DELETE VERIFIED REQUESTS
            otpVerification::where('phone',$request->input('phone'))->delete();
            return response()->json(apiResponseHandler([], 'OTP verified Successfully.',200),200);
        }

        return response()->json(apiResponseHandler([], 'Invalid OTP',400), 400);
    }
}
