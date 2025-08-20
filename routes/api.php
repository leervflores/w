<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerUserApiController;

Route::post('/register', [CustomerUserApiController::class, 'register']);
Route::post('/login', [CustomerUserApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer_user', [CustomerUserApiController::class, 'index']); // if needed
    Route::get('/profile', [CustomerUserApiController::class, 'profile']);
    Route::put('/profile', [CustomerUserApiController::class, 'update']);
    Route::post('/logout', [CustomerUserApiController::class, 'logout']);
});
