<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::get('/auth/users', [AuthController::class, 'users']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::patch('/auth/users/{user}/rol', [UserRoleController::class, 'update']);

        require base_path('routes/api/v1.php');
    });
});