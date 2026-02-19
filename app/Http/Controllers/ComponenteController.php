<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComponenteRequest;
use App\Http\Requests\UpdateComponenteRequest;
use App\Models\Componente;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Componente::with(['accesorios_por_componente', 'materiales', 'herrajes'])->get()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponenteRequest $request)
    {
        $componente = Componente::create($request->validated());
        $this->syncRelations($componente, $request);
        return $componente->load(['accesorios_por_componente', 'materiales', 'herrajes'])->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(Componente $componente)
    {
        return $componente->load(['accesorios_por_componente', 'materiales', 'herrajes'])->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponenteRequest $request, Componente $componente)
    {
        $componente->update($request->validated());
        
        if ($request->has('accesorios')) {
            $componente->accesorios_por_componente()->delete();
        }
        
        $this->syncRelations($componente, $request);
        return $componente->load(['accesorios_por_componente', 'materiales', 'herrajes'])->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Componente $componente)
    {
        $componente->accesorios_por_componente()->delete();
        $componente->materiales()->detach();
        $componente->herrajes()->detach();
        $componente->delete();
        
        return response()->noContent();
    }

    /**
     * Sync component relations (accesorios, materiales, herrajes)
     */
    private function syncRelations(Componente $componente, $request): void
    {
        if ($request->has('accesorios')) {
            $accesorios = explode(',', $request->accesorios);
            foreach ($accesorios as $accesorio) {
                $componente->accesorios_por_componente()->create([
                    'accesorio' => trim($accesorio),
                ]);
            }
        }

        if ($request->has('materiales')) {
            $materiales = collect($request->materiales)->mapWithKeys(function ($material) {
                return [$material['id'] => ['cantidad' => $material['cantidad']]];
            })->toArray();
            $componente->materiales()->sync($materiales);
        }

        if ($request->has('herrajes')) {
            $herrajes = collect($request->herrajes)->mapWithKeys(function ($herraje) {
                return [$herraje['id'] => ['cantidad' => $herraje['cantidad']]];
            })->toArray();
            $componente->herrajes()->sync($herrajes);
        }
    }
}
