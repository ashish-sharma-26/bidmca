<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('static.home');
});

Route::get('/how-it-work', function () {
    return view('static.how-it-work');
})->name('howItWork');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/api/send-otp', [\App\Http\Controllers\Common\CommonController::class, 'sendOtp'])->name('sendOtp');
Route::post('/api/verify-otp', [\App\Http\Controllers\Common\CommonController::class, 'verifyOTP'])->name('verifyOTP');
