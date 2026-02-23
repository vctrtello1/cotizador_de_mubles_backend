<?php

namespace App\Http\Controllers;

use App\Models\ComponentesPorCotizacion;
use App\Models\Cotizacion;
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
        $validated = $this->validateComponentesPorCotizacion($request, true);

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
        $validated = $this->validateComponentesPorCotizacion($request, false);

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
                'componente.materiales'
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

        // Create new relationships using bulk insert for better performance
        $insertData = collect($validated['componentes'])->map(function ($componente) use ($cotizacion) {
            return [
                'cotizacion_id' => $cotizacion->id,
                'componente_id' => $componente['id'],
                'cantidad' => $componente['cantidad'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        ComponentesPorCotizacion::insert($insertData);

        $componentes = ComponentesPorCotizacion::where('cotizacion_id', $cotizacion->id)
            ->with(['componente'])
            ->get();

        return response()->json($componentes);
    }

    /**
     * Validate component-quotation data
     */
    private function validateComponentesPorCotizacion(Request $request, bool $required): array
    {
        $rule = $required ? 'required' : 'sometimes';
        
        return $request->validate([
            'cotizacion_id' => "{$rule}|integer|exists:cotizaciones,id",
            'componente_id' => "{$rule}|integer|exists:componentes,id",
            'modulo_id' => 'nullable|integer|exists:modulos,id',
            'cantidad' => "{$rule}|integer|min:1",
        ]);
    }
}
