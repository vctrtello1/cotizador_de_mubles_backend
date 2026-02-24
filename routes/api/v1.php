<?php

use App\Http\Controllers\AcabadoCubreCantoController;
use App\Http\Controllers\AcabadoCubreCantoPorComponenteController;
use App\Http\Controllers\AcabadoTableroController;
use App\Http\Controllers\AcabadoTableroPorComponenteController;
use App\Http\Controllers\AccesorioController;
use App\Http\Controllers\AccesoriosPorComponenteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompasAbatibleController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\ComponentesPorCotizacionController;
use App\Http\Controllers\CorrederaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\EstructuraController;
use App\Http\Controllers\GolaController;
use App\Http\Controllers\GolaPorComponenteController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\PuertaController;
use App\Http\Controllers\PuertasPorComponenteController;
use App\Http\Controllers\CantidadPorComponenteController;
use App\Http\Controllers\EstructuraPorComponenteController;
use Illuminate\Support\Facades\Route;

Route::get('clientes/{cliente}/cotizaciones', [ClienteController::class, 'cotizaciones']);

Route::apiResource('acabado-tableros', AcabadoTableroController::class)->only(['index', 'show']);
Route::apiResource('acabado-tableros', AcabadoTableroController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('acabado-cubre-cantos', AcabadoCubreCantoController::class)->only(['index', 'show']);
Route::apiResource('acabado-cubre-cantos', AcabadoCubreCantoController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('accesorios', AccesorioController::class)->only(['index', 'show']);
Route::apiResource('accesorios', AccesorioController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('estructuras', EstructuraController::class)->only(['index', 'show']);
Route::apiResource('estructuras', EstructuraController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('golas', GolaController::class)->only(['index', 'show']);
Route::apiResource('golas', GolaController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('componentes', ComponenteController::class)->only(['index', 'show']);
Route::apiResource('componentes', ComponenteController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('modulos', ModulosController::class)->only(['index', 'show']);
Route::apiResource('modulos', ModulosController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('correderas', CorrederaController::class)->only(['index', 'show']);
Route::apiResource('correderas', CorrederaController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('compases-abatibles', CompasAbatibleController::class)
    ->only(['index', 'show'])
    ->parameters(['compases-abatibles' => 'compasAbatible']);
Route::apiResource('compases-abatibles', CompasAbatibleController::class)
    ->except(['index', 'show'])
    ->parameters(['compases-abatibles' => 'compasAbatible'])
    ->middleware('role:admin');

Route::apiResource('puertas', PuertaController::class)->only(['index', 'show']);
Route::apiResource('puertas', PuertaController::class)
    ->except(['index', 'show'])
    ->middleware('role:admin');

Route::apiResource('clientes', ClienteController::class);

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

Route::apiResource('cantidad-por-componentes', CantidadPorComponenteController::class)
    ->parameters(['cantidad-por-componentes' => 'cantidadPorComponente']);

Route::apiResource('accesorios-por-componente', AccesoriosPorComponenteController::class)
    ->parameters(['accesorios-por-componente' => 'accesoriosPorComponente']);

Route::apiResource('estructura-por-componente', EstructuraPorComponenteController::class)
    ->parameters(['estructura-por-componente' => 'estructuraPorComponente']);

Route::apiResource('acabado-cubre-canto-por-componente', AcabadoCubreCantoPorComponenteController::class)
    ->parameters(['acabado-cubre-canto-por-componente' => 'acabadoCubreCantoPorComponente']);

Route::apiResource('acabado-tablero-por-componente', AcabadoTableroPorComponenteController::class)
    ->parameters(['acabado-tablero-por-componente' => 'acabadoTableroPorComponente']);

Route::apiResource('puertas-por-componente', PuertasPorComponenteController::class)
    ->parameters(['puertas-por-componente' => 'puertasPorComponente']);

Route::apiResource('gola-por-componente', GolaPorComponenteController::class)
    ->parameters(['gola-por-componente' => 'golaPorComponente']);