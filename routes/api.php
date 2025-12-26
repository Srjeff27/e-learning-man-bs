<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Teacher Routes
    Route::middleware('role:guru')->prefix('teacher')->group(function () {
        Route::apiResource('classrooms', \App\Http\Controllers\Api\Teacher\ClassroomController::class);
    });

    // Student Routes
    Route::middleware('role:siswa')->prefix('student')->group(function () {
        Route::get('classrooms', [\App\Http\Controllers\Api\Student\ClassroomController::class, 'index']);
        Route::post('classrooms/join', [\App\Http\Controllers\Api\Student\ClassroomController::class, 'join']);
        Route::get('classrooms/{classroom}', [\App\Http\Controllers\Api\Student\ClassroomController::class, 'show']);
        Route::post('classrooms/{classroom}/leave', [\App\Http\Controllers\Api\Student\ClassroomController::class, 'leave']);
    });
});
