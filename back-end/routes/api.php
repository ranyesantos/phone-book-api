<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function (){

    Route::post('/register', 'store')->name('user-store');
    Route::post('/login', 'login')->name('user-login');

});


