<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;


Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('password/request', 'showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('password/update', 'reset')->name('password.update');
});


Route::middleware('admin')->controller(HomeController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard');
    Route::post('logout', 'logout')->name('logout');
});
