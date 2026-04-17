<?php

use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\User\ProfileController;
use Illuminate\Support\Facades\Route;


    Route::controller(RegisterController::class)->group(function(){
        Route::post('register','register');
    });

    Route::controller(RegisterController::class)->group(function(){
        Route::post('register','register');
    });



    Route::middleware('auth:api')->group(function(){
        Route::controller(ProfileController::class)->group(function(){
            Route::get('profile','index');
            Route::post('logout','logout');
        });
    });


?>
