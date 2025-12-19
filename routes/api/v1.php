<?php

use App\Http\Controllers\AcabadoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\HerrajeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ManoDeObraController;
use App\Http\Controllers\ModulosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('materiales', MaterialController::class)->parameters(['materiales' => 'material']);
Route::apiResource('tipo-de-materiales', \App\Http\Controllers\TipoDeMaterialController::class)->parameters(['tipo-de-materiales' => 'tipoDeMaterial']);
Route::apiResource('herrajes', HerrajeController::class);
Route::apiResource('acabados', AcabadoController::class);
Route::apiResource('mano-de-obras', ManoDeObraController::class);
Route::apiResource('componentes', ComponenteController::class);
Route::apiResource('modulos', ModulosController::class);