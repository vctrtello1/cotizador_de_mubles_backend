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
            'cantidad' => 'required|integer|min:1',
        ]);

        $componentePorCotizacion = ComponentesPorCotizacion::create($validated);

        return response()->json(
            $componentePorCotizacion->load(['cotizacion', 'componente']),
            201
        );
    }

    /**
     * Display the specified component-quotation relationship.
     */
    public function show(ComponentesPorCotizacion $componentesPorCotizacion): JsonResponse
    {
        return response()->json(
            $componentesPorCotizacion->load(['cotizacion', 'componente'])
        );
    }

    /**
     * Update the specified component-quotation relationship.
     */
    public function update(Request $request, ComponentesPorCotizacion $componentesPorCotizacion): JsonResponse
    {
        $validated = $request->validate([
            'cotizacion_id' => 'sometimes|integer|exists:cotizaciones,id',
            'componente_id' => 'sometimes|integer|exists:componentes,id',
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
     */
    public function componentesPorCotizacionId(Cotizacion $cotizacion): JsonResponse
    {
        $componentes = ComponentesPorCotizacion::where('cotizacion_id', $cotizacion->id)
            ->with(['componente.acabado', 'componente.mano_de_obra', 'componente.materiales', 'componente.herrajes'])
            ->get();

        return response()->json($componentes);
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
            ->with(['componente.acabado', 'componente.mano_de_obra'])
            ->get();

        return response()->json($componentes);
    }
}
