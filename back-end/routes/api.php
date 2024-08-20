<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function (){
    Route::post('/register', 'store');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::controller(ContactController::class)->middleware("auth:sanctum")->group(function (){
    Route::get('/contacts', 'index'); //method: GET, URL example:api/contacts
    Route::get('/contacts/{contact}', 'show'); //method: GET, URL example: api/contacts/3
    Route::post('/contacts', 'store'); //method: POST, URL example: api/contacts/
    Route::put('/contacts/{contact}', 'update'); //method: PUT, URL example: api/contacts/3
    Route::delete('/contacts/{contact}', 'destroy'); //method: DELETE, URL example: api/contacts/3
});
