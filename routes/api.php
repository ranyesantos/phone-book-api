<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TrashBinController;
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
    Route::post('/contacts/{contact}', 'update'); //method: PUT, URL example: api/contacts/3
    Route::delete('/contacts/{contact}', 'destroy'); //method: DELETE, URL example: api/contacts/3

});

Route::controller(TrashBinController::class)->middleware("auth:sanctum")->group(function (){

    Route::get('/trash-bin', 'index'); //method: GET, URL example:api/trash-bin
    Route::get('/trash-bin/{contact}', 'show')->withTrashed(); //method: GET, URL example: api/trash-bin/3
    Route::put('/trash-bin/{contact}', 'restore')->withTrashed(); //method: GET, URL example: api/trash-bin/3
    Route::delete('/trash-bin/{contact}', 'destroy')->withTrashed(); //method: GET, URL example: api/trash-bin/3

});
