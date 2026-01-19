<?php

use App\Http\Controllers\AcabadoController;
use App\Http\Controllers\AccesoriosPorComponenteController;
use App\Http\Controllers\CantidadPorHerrajeController;
use App\Http\Controllers\CantidadPorMaterialController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\MaterialesPorComponenteController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\ComponentesPorCotizacionController;
use App\Http\Controllers\HerrajeController;
use App\Http\Controllers\ManoDeObraController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\ModulosPorCotizacionController;
use App\Http\Controllers\TipoDeMaterialController;
use App\Http\Controllers\HorasDeManoDeObraPorComponenteController;
use Illuminate\Support\Facades\Route;

Route::apiResource('materiales', MaterialController::class)
    ->parameters(['materiales' => 'material']);

Route::apiResource('tipo-de-materiales', TipoDeMaterialController::class)
    ->parameters(['tipo-de-materiales' => 'tipoDeMaterial']);

Route::get('clientes/{cliente}/cotizaciones', [ClienteController::class, 'cotizaciones']);

Route::apiResources([
    'herrajes'      => HerrajeController::class,
    'acabados'      => AcabadoController::class,
    'mano-de-obras' => ManoDeObraController::class,
    'componentes'   => ComponenteController::class,
    'modulos'       => ModulosController::class,
    'clientes'      => ClienteController::class,
]);

Route::get('cotizaciones/modulos', [CotizacionController::class, 'modulosPorCotizacion']);
Route::get('cotizaciones/modulos/{cotizacion}', [CotizacionController::class, 'modulosPorCotizacionId']);
Route::post('cotizaciones/{cotizacion}/sync-modulos', [CotizacionController::class, 'syncModulos']);

Route::apiResource('cotizaciones', CotizacionController::class)
    ->parameters(['cotizaciones' => 'cotizacion']);

Route::get('cotizaciones/{cotizacion}/componentes', [ComponentesPorCotizacionController::class, 'componentesPorCotizacionId']);
Route::post('cotizaciones/{cotizacion}/sync-componentes', [ComponentesPorCotizacionController::class, 'syncComponentes']);

Route::apiResource('componentes-por-cotizacion', ComponentesPorCotizacionController::class)
    ->parameters(['componentes-por-cotizacion' => 'componentesPorCotizacion']);

Route::get('cotizaciones/{cotizacion}/modulos-relation', [ModulosPorCotizacionController::class, 'modulosPorCotizacionId']);
Route::post('cotizaciones/{cotizacion}/sync-modulos-relation', [ModulosPorCotizacionController::class, 'syncModulos']);

Route::apiResource('modulos-por-cotizacion', ModulosPorCotizacionController::class)
    ->parameters(['modulos-por-cotizacion' => 'modulosPorCotizacion']);

Route::apiResource('cantidad-por-materiales', CantidadPorMaterialController::class)
    ->parameters(['cantidad-por-materiales' => 'cantidadPorMaterial']);

Route::apiResource('cantidad-por-herrajes', CantidadPorHerrajeController::class)
    ->parameters(['cantidad-por-herrajes' => 'cantidadPorHerraje']);

use App\Http\Controllers\CantidadPorComponenteController;

Route::apiResource('cantidad-por-componentes', CantidadPorComponenteController::class)
    ->parameters(['cantidad-por-componentes' => 'cantidadPorComponente']);

Route::apiResource('horas-de-mano-de-obra-por-componentes', HorasDeManoDeObraPorComponenteController::class)
    ->parameters(['horas-de-mano-de-obra-por-componentes' => 'horasDeManoDeObraPorComponente']);

Route::apiResource('accesorios-por-componente', AccesoriosPorComponenteController::class)
    ->parameters(['accesorios-por-componente' => 'accesoriosPorComponente']);

Route::apiResource('materiales-por-componente', MaterialesPorComponenteController::class)
    ->parameters(['materiales-por-componente' => 'materialesPorComponente']);