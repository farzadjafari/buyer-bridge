<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CapsuleMessagesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PastMessagesController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('messages', MessagesController::class)->only(['store', 'show', 'update']);

    Route::get('capsule/messages', CapsuleMessagesController::class);

    Route::get('past/messages', PastMessagesController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});
