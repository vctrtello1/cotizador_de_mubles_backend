<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Http\Resources\CotizacionResource;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        return CotizacionResource::collection(Cotizacion::with(['cliente', 'modulosPorCotizacion'])->get());
    }

    public function store(StoreCotizacionRequest $request)
    {
        $data = $request->validated();
        $cotizacion = Cotizacion::create($data);

        if (isset($data['detalles'])) {
            $detalles = collect($data['detalles'])->map(function ($detalle) {
                if (!isset($detalle['subtotal'])) {
                    $detalle['subtotal'] = $detalle['cantidad'] * $detalle['precio_unitario'];
                }
                return $detalle;
            });
            $cotizacion->detalles()->createMany($detalles);
        }

        $cotizacion->load('detalles');
        return new CotizacionResource($cotizacion);
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['modulosPorCotizacion', 'cliente']);
        return new CotizacionResource($cotizacion);
    }

    public function update(UpdateCotizacionRequest $request, Cotizacion $cotizacion)
    {
        $cotizacion->update($request->validated());
        return new CotizacionResource($cotizacion);
    }

    public function modulosPorCotizacion()
    {
        $modulosPorCotizacion = Cotizacion::with('detalles.modulo')
            ->get()
            ->mapWithKeys(function ($cotizacion) {
                return [$cotizacion->id => $cotizacion->detalles->map(function ($detalle) {
                    return $detalle->modulo;
                })->unique('id')->values()];
            });

        return response()->json($modulosPorCotizacion);
    }

    public function modulosPorCotizacionId(Cotizacion $cotizacion)
    {
        $cotizacion->load('detalles.modulo');
        $modulos = $cotizacion->detalles->map(function ($detalle) {
            return $detalle->modulo;
        })->unique('id')->values();

        return response()->json($modulos);
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return response()->noContent();
    }
}
