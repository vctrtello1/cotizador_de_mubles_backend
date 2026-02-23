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
        return Componente::with(['accesorios_por_componente'])->get()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponenteRequest $request)
    {
        $componente = Componente::create($request->validated());
        $this->syncRelations($componente, $request);
        return $componente->load(['accesorios_por_componente'])->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(Componente $componente)
    {
        return $componente->load(['accesorios_por_componente'])->toResource();
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
        return $componente->load(['accesorios_por_componente'])->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Componente $componente)
    {
        $componente->accesorios_por_componente()->delete();
        $componente->delete();
        
        return response()->noContent();
    }

    /**
    * Sync component relations (accesorios)
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
    }
}
