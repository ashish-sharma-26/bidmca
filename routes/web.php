<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
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

Auth::routes();

Route::post('/api/send-otp', [\App\Http\Controllers\Common\CommonController::class, 'sendOtp'])->name('sendOtp');
Route::post('/api/verify-otp', [\App\Http\Controllers\Common\CommonController::class, 'verifyOTP'])->name('verifyOTP');
Route::get('/api/common/get-cities/{stateId}', [\App\Http\Controllers\Common\CommonController::class, 'getCities'])->name('getCities');
Route::post('/api/common/file-upload', [\App\Http\Controllers\Common\CommonController::class, 'uploadFile'])->name('uploadFile');
Route::get('/check-email', [\App\Http\Controllers\Common\CommonController::class, 'checkEmail'])->name('checkEmail');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/application', [App\Http\Controllers\ApplicationController::class, 'index'])->name('application');
    Route::post('/api/application/store', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applicationStore');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/application/{id}', [App\Http\Controllers\ApplicationController::class, 'view'])->name('app_view');
    Route::post('/api/application/bid', [App\Http\Controllers\BidController::class, 'store'])->name('app_bid');
    Route::post('/api/application/validate-bid-score', [App\Http\Controllers\BidController::class, 'validateBidScore'])->name('app_bid');
    Route::get('/logout', [App\Http\Controllers\UsersController::class, 'logout'])->name('logout');
});
