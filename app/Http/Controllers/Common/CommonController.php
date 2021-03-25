<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Auth\otpVerification;
use App\Models\Common\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function getCities($stateId){
        $cities = City::where('state_id', $stateId)->get();
        $cityHtml = '<option value="">Please select state</option>';
        if(count($cities) > 0){
            $cityHtml = '<option value="">Please select city</option>';

            foreach ($cities AS $city){
                $cityHtml .= '<option value="'.$city->id.'">'.$city->city_name.'</option>';
            }
        }

        return response()->json(apiResponseHandler(['cityHtml' => $cityHtml], '',200), 200);
    }

    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,jpg,png,pdf|max:5000000'
        ]);

        if ($validator->fails()) {
            return response()->json(apiResponseHandler([], 'Please upload less than 5MB (File type accepted: JPG, JPEG, PNG)'), 400);
        }

        $path = $this->uploadFileAction($request, 'public/documents');
        $path = str_replace('public/', '', $path);

        return Response()->json(apiResponseHandler(['path' => $path], 'Uploaded Successfully', 200), 200);
    }

    public function uploadFileAction($request, $path)
    {
        $image = $request->file('file');
        $newImage = $image->getClientOriginalName();
        $newImage = str_replace(" ", "_", $newImage);

        Storage::makeDirectory($path, 0777);

        $save_local = Storage::put($path, $image);

        return $save_local;
    }

    public function checkEmail(){
        return view('email-templates.authorize');
    }
}
