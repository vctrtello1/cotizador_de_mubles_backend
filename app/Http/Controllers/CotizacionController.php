<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Http\Resources\CotizacionResource;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        return CotizacionResource::collection(Cotizacion::with(['cliente', 'modulosPorCotizacion.componentes.acabado', 'modulosPorCotizacion.componentes.mano_de_obra'])->get());
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
            
            // También guardar la relación con módulos para acceso estructurado
            $modulosCantidadArray = $data['modulos_cantidad'] ?? [];
            
            // Convertir array de objetos a un mapa donde cada modulo_id mapea a un array de cantidades
            $modulosCantidad = [];
            foreach ($modulosCantidadArray as $item) {
                if (is_array($item) && isset($item['modulo_id'], $item['cantidad'])) {
                    if (!isset($modulosCantidad[$item['modulo_id']])) {
                        $modulosCantidad[$item['modulo_id']] = [];
                    }
                    $modulosCantidad[$item['modulo_id']][] = $item['cantidad'];
                }
            }
            
            $detallesPorModulo = collect($data['detalles'])->groupBy('modulo_id');
            
            foreach ($detallesPorModulo as $moduloId => $detallesDelModulo) {
                if ($moduloId) {
                    if (isset($modulosCantidad[$moduloId])) {
                        // Múltiples instancias del mismo módulo con diferentes cantidades
                        foreach ($modulosCantidad[$moduloId] as $cantidad) {
                            $cotizacion->modulosPorCotizacion()->attach($moduloId, [
                                'cantidad' => $cantidad
                            ]);
                        }
                    } else {
                        // Fallback a cantidad 1 si no hay cantidad especificada
                        $cotizacion->modulosPorCotizacion()->attach($moduloId, [
                            'cantidad' => 1
                        ]);
                    }
                }
            }
        }

        $cotizacion->load(['detalles', 'cliente', 'modulosPorCotizacion.componentes']);
        return new CotizacionResource($cotizacion);
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['modulosPorCotizacion.componentes.acabado', 'modulosPorCotizacion.componentes.mano_de_obra', 'detalles', 'cliente']);
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

    public function syncModulos(Request $request, Cotizacion $cotizacion)
    {
        $validated = $request->validate([
            'modulos' => 'required|array',
            'modulos.*.id' => 'required|integer|exists:modulos,id',
            'modulos.*.cantidad' => 'sometimes|integer|min:1',
        ]);

        $modulos = collect($validated['modulos'])->mapWithKeys(function ($modulo) {
            return [
                $modulo['id'] => ['cantidad' => $modulo['cantidad'] ?? 1]
            ];
        });

        $cotizacion->modulosPorCotizacion()->sync($modulos);
        
        $cotizacion->load(['modulosPorCotizacion.componentes.acabado', 'modulosPorCotizacion.componentes.mano_de_obra', 'cliente']);
        return new CotizacionResource($cotizacion);
    }
}
