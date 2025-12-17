<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\AcabadoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\HerrajeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ManoDeObraController;

Route::prefix('v1')->group(base_path('routes/api/v1.php'));