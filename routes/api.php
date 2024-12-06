<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
});
Route::middleware('auth:api')->prefix('auth')->as('auth.')->group(function () {
    Route::resource('user-data', UserController::class);
});
