<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::post('/login',[LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
