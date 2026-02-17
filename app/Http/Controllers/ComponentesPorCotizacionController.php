<?php

namespace App\Http\Controllers;

use App\Models\ComponentesPorCotizacion;
use App\Models\Cotizacion;
use App\Models\Componente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ComponentesPorCotizacionController extends Controller
{
    /**
     * Display a listing of all components per quotation.
     */
    public function index(): JsonResponse
    {
        $componentesPorCotizacion = ComponentesPorCotizacion::with(['cotizacion', 'componente'])
            ->get();

        return response()->json($componentesPorCotizacion);
    }

    /**
     * Store a newly created component-quotation relationship.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cotizacion_id' => 'required|integer|exists:cotizaciones,id',
            'componente_id' => 'required|integer|exists:componentes,id',
            'modulo_id' => 'nullable|integer|exists:modulos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $componentePorCotizacion = ComponentesPorCotizacion::create($validated);

        return response()->json(
            $componentePorCotizacion->load(['cotizacion', 'componente']),
            201
        );
    }

    /**
     * Display all components for a specific quotation (grouped and summed).
     */
    public function show(Cotizacion $cotizacion): JsonResponse
    {
        return $this->componentesPorCotizacionId($cotizacion);
    }

    /**
     * Update the specified component-quotation relationship.
     */
    public function update(Request $request, ComponentesPorCotizacion $componentesPorCotizacion): JsonResponse
    {
        $validated = $request->validate([
            'cotizacion_id' => 'sometimes|integer|exists:cotizaciones,id',
            'componente_id' => 'sometimes|integer|exists:componentes,id',
            'modulo_id' => 'nullable|integer|exists:modulos,id',
            'cantidad' => 'sometimes|integer|min:1',
        ]);

        $componentesPorCotizacion->update($validated);

        return response()->json(
            $componentesPorCotizacion->load(['cotizacion', 'componente'])
        );
    }

    /**
     * Remove the specified component-quotation relationship.
     */
    public function destroy(ComponentesPorCotizacion $componentesPorCotizacion): JsonResponse
    {
        $componentesPorCotizacion->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all components for a specific quotation.
     * Returns components grouped by component_id with summed quantities.
     */
    public function componentesPorCotizacionId(Cotizacion $cotizacion): JsonResponse
    {
        $componentesAgrupados = [];
        
        // Get direct component assignments with all necessary relationships for cost calculation
        $directComponents = ComponentesPorCotizacion::where('cotizacion_id', $cotizacion->id)
            ->with([
                'componente.materiales',
                'componente.herrajes',
                'componente.mano_de_obra'
            ])
            ->get();

        // Add direct assignments
        foreach ($directComponents as $item) {
            $componenteId = $item->componente_id;
            
            if (!isset($componentesAgrupados[$componenteId])) {
                $componentesAgrupados[$componenteId] = [
                    'componente' => [
                        'id' => $item->componente->id,
                        'nombre' => $item->componente->nombre,
                        'descripcion' => $item->componente->descripcion,
                        'codigo' => $item->componente->codigo,
                        'costo_total' => $item->componente->costo_total,
                    ],
                    'cantidad' => 0,
                    'subtotal' => 0
                ];
            }
            
            $componentesAgrupados[$componenteId]['cantidad'] += $item->cantidad;
        }

        // Calculate subtotals after aggregating quantities
        foreach ($componentesAgrupados as &$componente) {
            $componente['subtotal'] = $componente['componente']['costo_total'] * $componente['cantidad'];
        }

        return response()->json(array_values($componentesAgrupados));
    }

    /**
     * Sync components for a specific quotation.
     */
    public function syncComponentes(Request $request, Cotizacion $cotizacion): JsonResponse
    {
        $validated = $request->validate([
            'componentes' => 'required|array',
            'componentes.*.id' => 'required|integer|exists:componentes,id',
            'componentes.*.cantidad' => 'required|integer|min:1',
        ]);

        // Delete existing relationships
        ComponentesPorCotizacion::where('cotizacion_id', $cotizacion->id)->delete();

        // Create new relationships
        foreach ($validated['componentes'] as $componente) {
            ComponentesPorCotizacion::create([
                'cotizacion_id' => $cotizacion->id,
                'componente_id' => $componente['id'],
                'cantidad' => $componente['cantidad'],
            ]);
        }

        $componentes = ComponentesPorCotizacion::where('cotizacion_id', $cotizacion->id)
            ->with(['componente.mano_de_obra'])
            ->get();

        return response()->json($componentes);
    }
}
