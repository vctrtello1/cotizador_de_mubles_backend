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
        //
        return Componente::with(['mano_de_obra', 'accesorios_por_componente', 'materiales', 'herrajes'])->get()->toResourceCollection();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponenteRequest $request)
    {
        //
        $componente = Componente::create($request->validated());

        if ($request->has('accesorios')) {
            $accesorios = explode(',', $request->accesorios);
            foreach ($accesorios as $accesorio) {
                $componente->accesorios_por_componente()->create([
                    'accesorio' => trim($accesorio),
                ]);
            }
        }

        if ($request->has('materiales')) {
            $materiales = [];
            foreach ($request->materiales as $material) {
                $materiales[$material['id']] = ['cantidad' => $material['cantidad']];
            }
            $componente->materiales()->sync($materiales);
        }

        if ($request->has('herrajes')) {
            $herrajes = [];
            foreach ($request->herrajes as $herraje) {
                $herrajes[$herraje['id']] = ['cantidad' => $herraje['cantidad']];
            }
            $componente->herrajes()->sync($herrajes);
        }

        return $componente->load(['mano_de_obra', 'accesorios_por_componente', 'materiales', 'herrajes'])->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(Componente $componente)
    {
        //
        return $componente->load(['mano_de_obra', 'accesorios_por_componente', 'materiales', 'herrajes'])->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponenteRequest $request, Componente $componente)
    {
        //
        $componente->update($request->validated());

        if ($request->has('accesorios')) {
            $componente->accesorios_por_componente()->delete();
            $accesorios = explode(',', $request->accesorios);
            foreach ($accesorios as $accesorio) {
                $componente->accesorios_por_componente()->create([
                    'accesorio' => trim($accesorio),
                ]);
            }
        }

        if ($request->has('materiales')) {
            $materiales = [];
            foreach ($request->materiales as $material) {
                $materiales[$material['id']] = ['cantidad' => $material['cantidad']];
            }
            $componente->materiales()->sync($materiales);
        }

        if ($request->has('herrajes')) {
            $herrajes = [];
            foreach ($request->herrajes as $herraje) {
                $herrajes[$herraje['id']] = ['cantidad' => $herraje['cantidad']];
            }
            $componente->herrajes()->sync($herrajes);
        }

        return $componente->load(['mano_de_obra', 'accesorios_por_componente', 'materiales', 'herrajes'])->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Componente $componente)
    {
        // Delete related records first to avoid foreign key constraint violations
        $componente->accesorios_por_componente()->delete();
        $componente->materiales()->detach();
        $componente->herrajes()->detach();
        
        $componente->delete();
        return response()->noContent();
    }
}
