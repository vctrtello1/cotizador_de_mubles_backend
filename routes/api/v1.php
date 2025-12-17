<?php

use App\Http\Controllers\AcabadoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\HerrajeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ManoDeObraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('materiales', MaterialController::class);
Route::apiResource('herrajes', HerrajeController::class);
Route::apiResource('acabados', AcabadoController::class);
Route::apiResource('mano-de-obra', ManoDeObraController::class);
Route::apiResource('componentes', ComponenteController::class);