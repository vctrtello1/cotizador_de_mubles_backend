<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModulosRequest;
use App\Http\Requests\UpdateModulosRequest;
use App\Models\Modulos;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Modulos::with('componentes')->get()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModulosRequest $request)
    {
        $validated = $request->validated();
        $componentes = $validated['componentes'] ?? [];
        unset($validated['componentes']);

        $modulo = Modulos::create($validated);

        // Sincronizar componentes
        if (!empty($componentes)) {
            $syncData = [];
            foreach ($componentes as $componente) {
                $syncData[$componente['id']] = ['cantidad' => $componente['cantidad']];
            }
            $modulo->componentes()->sync($syncData);
        }

        return $modulo->load('componentes')->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(modulos $modulo)
    {
        return $modulo->load('componentes')->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModulosRequest $request, modulos $modulo)
    {
        $validated = $request->validated();
        $componentes = $validated['componentes'] ?? [];
        unset($validated['componentes']);

        $modulo->update($validated);

        // Sincronizar componentes
        if (!empty($componentes)) {
            $syncData = [];
            foreach ($componentes as $componente) {
                $syncData[$componente['id']] = ['cantidad' => $componente['cantidad']];
            }
            $modulo->componentes()->sync($syncData);
        } else {
            // Si no hay componentes, limpiar la relación
            $modulo->componentes()->detach();
        }

        return $modulo->load('componentes')->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(modulos $modulo)
    {
        //
        $modulo->delete();
        return response()->noContent();
    }
}
