<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/create-account', [AuthController::class, 'createAccount']);
Route::post('/validate-account', [AuthController::class, 'validateAccount']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-profile', [UserController::class, 'getProfile']);
});
