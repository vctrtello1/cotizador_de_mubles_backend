<?php

use App\Http\Controllers\AcabadoCubreCantoController;
use App\Http\Controllers\AcabadoTableroController;
use App\Http\Controllers\AccesoriosPorComponenteController;
use App\Http\Controllers\CantidadPorMaterialController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompasAbatibleController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\ComponentesPorCotizacionController;
use App\Http\Controllers\CorrederaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\EstructuraController;
use App\Http\Controllers\GolaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialesPorComponenteController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\PuertaController;
use App\Http\Controllers\CantidadPorComponenteController;
use App\Http\Controllers\EstructuraPorComponenteController;
use App\Http\Controllers\TablerosPorComponenteController;
use Illuminate\Support\Facades\Route;

Route::apiResource('materiales', MaterialController::class)
    ->parameters(['materiales' => 'material']);

Route::get('clientes/{cliente}/cotizaciones', [ClienteController::class, 'cotizaciones']);

Route::apiResources([
    'acabado-tableros'      => AcabadoTableroController::class,
    'acabado-cubre-cantos'  => AcabadoCubreCantoController::class,
    'estructuras'           => EstructuraController::class,
    'golas'                 => GolaController::class,
    'componentes'           => ComponenteController::class,
    'modulos'               => ModulosController::class,
    'clientes'              => ClienteController::class,
    'correderas'            => CorrederaController::class,
], ['parameters' => [
    'compases-abatibles' => 'compasAbatible'
]]);

Route::apiResource('compases-abatibles', CompasAbatibleController::class)
    ->parameters(['compases-abatibles' => 'compasAbatible']);

Route::apiResource('puertas', PuertaController::class);

Route::apiResource('cotizaciones', CotizacionController::class)
    ->parameters(['cotizaciones' => 'cotizacion']);

Route::put('cotizaciones/{cotizacion}/estado', [CotizacionController::class, 'updateEstado']);
Route::get('cotizaciones/{cotizacion}/componentes', [ComponentesPorCotizacionController::class, 'componentesPorCotizacionId']);
Route::post('cotizaciones/{cotizacion}/sync-componentes', [ComponentesPorCotizacionController::class, 'syncComponentes']);

Route::apiResource('componentes-por-cotizacion', ComponentesPorCotizacionController::class)
    ->parameters(['componentes-por-cotizacion' => 'componentesPorCotizacion'])
    ->except(['show']);

// Custom show route using cotizacion_id
Route::get('componentes-por-cotizacion/{cotizacion}', [ComponentesPorCotizacionController::class, 'show']);

// Alternative route pattern that frontend expects
Route::get('componentes-por-cotizacion/cotizacion/{cotizacion}', [ComponentesPorCotizacionController::class, 'componentesPorCotizacionId']);

Route::apiResource('cantidad-por-materiales', CantidadPorMaterialController::class)
    ->parameters(['cantidad-por-materiales' => 'cantidadPorMaterial']);

Route::apiResource('cantidad-por-componentes', CantidadPorComponenteController::class)
    ->parameters(['cantidad-por-componentes' => 'cantidadPorComponente']);

Route::apiResource('accesorios-por-componente', AccesoriosPorComponenteController::class)
    ->parameters(['accesorios-por-componente' => 'accesoriosPorComponente']);

Route::apiResource('materiales-por-componente', MaterialesPorComponenteController::class)
    ->parameters(['materiales-por-componente' => 'materialesPorComponente']);

Route::apiResource('tableros-por-componente', TablerosPorComponenteController::class)
    ->parameters(['tableros-por-componente' => 'tablerosPorComponente']);

Route::apiResource('estructura-por-componente', EstructuraPorComponenteController::class)
    ->parameters(['estructura-por-componente' => 'estructuraPorComponente']);