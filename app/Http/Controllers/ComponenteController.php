<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComponenteRequest;
use App\Http\Requests\UpdateComponenteRequest;
use App\Models\Componente;
use Illuminate\Support\Facades\DB;

class ComponenteController extends Controller
{
    private const COST_RELATIONS = [
        'accesorios_por_componente',
        'estructuras_por_componente.estructura',
        'acabado_tablero_por_componente.acabadoTablero',
        'acabado_cubre_canto_por_componente.acabadoCubreCanto',
        'puertas_por_componente.puerta',
        'gola_por_componente.gola',
        'correderas_por_componente.corredera',
        'compases_abatibles_por_componente.compasAbatible',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Componente::with(self::COST_RELATIONS)->get()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponenteRequest $request)
    {
        $componente = Componente::create($request->validated());
        $this->syncRelations($componente, $request);
        return $componente->load(self::COST_RELATIONS)->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(Componente $componente)
    {
        return $componente->load(self::COST_RELATIONS)->toResource();
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
        return $componente->load(self::COST_RELATIONS)->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Componente $componente)
    {
        $componente->accesorios_por_componente()->delete();
        $componente->estructuras_por_componente()->delete();
        $componente->acabado_tablero_por_componente()->delete();
        $componente->acabado_cubre_canto_por_componente()->delete();
        $componente->puertas_por_componente()->delete();
        $componente->gola_por_componente()->delete();
        $componente->correderas_por_componente()->delete();
        $componente->compases_abatibles_por_componente()->delete();
        $componente->delete();
        
        return response()->noContent();
    }

    /**
     * Duplicate the specified component including all its relations.
     */
    public function duplicate(Componente $componente)
    {
        $nuevo = DB::transaction(function () use ($componente) {
            $componente->loadMissing([
                'accesorios_por_componente',
                'estructuras_por_componente',
                'acabado_tablero_por_componente',
                'acabado_cubre_canto_por_componente',
                'puertas_por_componente',
                'gola_por_componente',
                'correderas_por_componente',
                'compases_abatibles_por_componente',
            ]);

            $nuevo = $componente->replicate();
            $nuevo->nombre = 'Copia de ' . $componente->nombre;
            $nuevo->codigo = $componente->codigo . '-' . strtolower(substr(md5(uniqid()), 0, 6));
            $nuevo->save();

            foreach ($componente->accesorios_por_componente as $rel) {
                $nuevo->accesorios_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->estructuras_por_componente as $rel) {
                $nuevo->estructuras_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->acabado_tablero_por_componente as $rel) {
                $nuevo->acabado_tablero_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->acabado_cubre_canto_por_componente as $rel) {
                $nuevo->acabado_cubre_canto_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->puertas_por_componente as $rel) {
                $nuevo->puertas_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->gola_por_componente as $rel) {
                $nuevo->gola_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->correderas_por_componente as $rel) {
                $nuevo->correderas_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            foreach ($componente->compases_abatibles_por_componente as $rel) {
                $nuevo->compases_abatibles_por_componente()->create(
                    collect($rel->toArray())->except(['id', 'componente_id', 'created_at', 'updated_at'])->toArray()
                );
            }

            return $nuevo;
        });

        return $nuevo->load(self::COST_RELATIONS)->toResource();
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
