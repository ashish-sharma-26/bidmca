<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ApplicationController;

Route::get('/login', function () {
    return view('admin.login');
})->name('admin_login');
Route::get('/settings', function () {
    return view('admin.account.account-settings');
})->name('settings');

Route::post('/login', [AdminAuthController::class, 'adminLogin'])->name('admin_login_action');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');
    Route::get('/users', [UserController::class, 'users'])->name('admin_users');
    Route::get('/user-status/{id}/{status}', [UserController::class, 'userStatus']);
    Route::get('/applications', [ApplicationController::class, 'applications'])->name('admin_applications');
    Route::get('/application/{id}', [ApplicationController::class, 'viewApplication'])->name('admin_application');
    Route::get('/application-status/{status}', [ApplicationController::class, 'applicationStatus']);

    Route::post('/update-password', [AdminAuthController::class, 'updatePassword'])->name('update_password');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin_logout');
});
