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
        Route::get('/auth/permissions', [AuthController::class, 'permissions'])->middleware('permission:users.read');
        Route::get('/auth/users', [AuthController::class, 'users'])->middleware('permission:users.read');
        Route::get('/auth/users/{userId}', [AuthController::class, 'showUser'])->middleware('permission:users.read');
        Route::put('/auth/users/{userId}', [AuthController::class, 'updateUser'])->middleware('permission:users.update-role');
        Route::get('/auth/users/{userId}/permissions', [AuthController::class, 'userPermissions'])->middleware('permission:users.read');
        Route::put('/auth/users/{userId}/permissions', [AuthController::class, 'updateUserPermissions'])->middleware('permission:users.update-role');
        Route::delete('/auth/users/{userId}', [AuthController::class, 'destroyUser'])->middleware('permission:users.delete');
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::patch('/auth/users/{user}/rol', [UserRoleController::class, 'update'])->middleware('permission:users.update-role');

        require base_path('routes/api/v1.php');
    });
});