<?php

namespace App\Http\Controllers;

use App\Models\ModulosPorCotizacion;
use App\Models\Cotizacion;
use App\Models\Modulos;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ModulosPorCotizacionController extends Controller
{
    /**
     * Display a listing of all modules per quotation.
     */
    public function index(): JsonResponse
    {
        $modulosPorCotizacion = ModulosPorCotizacion::with(['cotizacion', 'modulo'])
            ->get();

        return response()->json($modulosPorCotizacion);
    }

    /**
     * Store a newly created module-quotation relationship.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cotizacion_id' => 'required|integer|exists:cotizaciones,id',
            'modulo_id' => 'required|integer|exists:modulos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $moduloPorCotizacion = ModulosPorCotizacion::create($validated);

        return response()->json(
            $moduloPorCotizacion->load(['cotizacion', 'modulo']),
            201
        );
    }

    /**
     * Display the specified module-quotation relationship.
     */
    public function show(ModulosPorCotizacion $modulosPorCotizacion): JsonResponse
    {
        return response()->json(
            $modulosPorCotizacion->load(['cotizacion', 'modulo'])
        );
    }

    /**
     * Update the specified module-quotation relationship.
     */
    public function update(Request $request, ModulosPorCotizacion $modulosPorCotizacion): JsonResponse
    {
        $validated = $request->validate([
            'cotizacion_id' => 'sometimes|integer|exists:cotizaciones,id',
            'modulo_id' => 'sometimes|integer|exists:modulos,id',
            'cantidad' => 'sometimes|integer|min:1',
        ]);

        $modulosPorCotizacion->update($validated);

        return response()->json(
            $modulosPorCotizacion->load(['cotizacion', 'modulo'])
        );
    }

    /**
     * Remove the specified module-quotation relationship.
     */
    public function destroy(ModulosPorCotizacion $modulosPorCotizacion): JsonResponse
    {
        $modulosPorCotizacion->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all modules for a specific quotation.
     */
    public function modulosPorCotizacionId(Cotizacion $cotizacion): JsonResponse
    {
        $modulos = ModulosPorCotizacion::where('cotizacion_id', $cotizacion->id)
            ->with(['modulo.componentes'])
            ->get();

        return response()->json($modulos);
    }

    /**
     * Sync modules for a specific quotation.
     */
    public function syncModulos(Request $request, Cotizacion $cotizacion): JsonResponse
    {
        $validated = $request->validate([
            'modulos' => 'required|array',
            'modulos.*.id' => 'required|integer|exists:modulos,id',
            'modulos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Delete existing relationships
        ModulosPorCotizacion::where('cotizacion_id', $cotizacion->id)->delete();

        // Create new relationships
        foreach ($validated['modulos'] as $modulo) {
            ModulosPorCotizacion::create([
                'cotizacion_id' => $cotizacion->id,
                'modulo_id' => $modulo['id'],
                'cantidad' => $modulo['cantidad'],
            ]);
        }

        $modulos = ModulosPorCotizacion::where('cotizacion_id', $cotizacion->id)
            ->with(['modulo.componentes'])
            ->get();

        return response()->json($modulos);
    }
}
