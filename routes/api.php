<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class,'index']);

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('users', UserController::class);
    Route::resource('company', CompanyController::class);
});
