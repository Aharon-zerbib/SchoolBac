<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    // Routes de l'école
    Route::post('/school/setup', [\App\Http\Controllers\SchoolController::class, 'store']);
    Route::get('/school', [\App\Http\Controllers\SchoolController::class, 'show']);
    Route::put('/school/update', [\App\Http\Controllers\SchoolController::class, 'update']);
});
