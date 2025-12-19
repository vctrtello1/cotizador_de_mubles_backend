<?php

use App\Http\Controllers\AcabadoController;
use App\Http\Controllers\AccesoriosPorComponenteController;
use App\Http\Controllers\CantidadPorHerrajeController;
use App\Http\Controllers\CantidadPorMaterialController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MaterialesPorComponenteController;
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
    'clientes'      => ClienteController::class,
]);

Route::apiResource('cantidad-por-materiales', CantidadPorMaterialController::class)
    ->parameters(['cantidad-por-materiales' => 'cantidadPorMaterial']);

Route::apiResource('cantidad-por-herrajes', CantidadPorHerrajeController::class)
    ->parameters(['cantidad-por-herrajes' => 'cantidadPorHerraje']);

Route::apiResource('accesorios-por-componente', AccesoriosPorComponenteController::class)
    ->parameters(['accesorios-por-componente' => 'accesoriosPorComponente']);

Route::apiResource('materiales-por-componente', MaterialesPorComponenteController::class)
    ->parameters(['materiales-por-componente' => 'materialesPorComponente']);