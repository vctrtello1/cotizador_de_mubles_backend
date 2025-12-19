<?php

use App\Http\Controllers\AcabadoController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\HerrajeController;
use App\Http\Controllers\ManoDeObraController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\TipoDeMaterialController;
use Illuminate\Support\Facades\Route;

Route::apiResource('materiales', MaterialController::class)
    ->parameters(['materiales' => 'material']);

Route::apiResource('tipo-de-materiales', TipoDeMaterialController::class)
    ->parameters(['tipo-de-materiales' => 'tipoDeMaterial']);

Route::apiResources([
    'herrajes'      => HerrajeController::class,
    'acabados'      => AcabadoController::class,
    'mano-de-obras' => ManoDeObraController::class,
    'componentes'   => ComponenteController::class,
    'modulos'       => ModulosController::class,
]);