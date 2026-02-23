<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcabadoTableroPorComponenteRequest;
use App\Http\Requests\UpdateAcabadoTableroPorComponenteRequest;
use App\Http\Resources\AcabadoTableroPorComponenteResource;
use App\Models\AcabadoTablero;
use App\Models\AcabadoTableroPorComponente;
use App\Models\Componente;

class AcabadoTableroPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = AcabadoTableroPorComponente::query()
            ->leftJoin('componentes as componentes', 'componentes.id', '=', 'acabado_tablero_por_componente.componente_id')
            ->leftJoin('acabado_tableros as acabados', 'acabados.id', '=', 'acabado_tablero_por_componente.acabado_tablero_id')
            ->select(
                'acabado_tablero_por_componente.*',
                'componentes.nombre as componente_nombre',
                'acabados.nombre as acabado_tablero_nombre'
            );

        if (request()->has('componente_id')) {
            $query->where('componente_id', request('componente_id'));
        }

        if (request()->has('sort_by')) {
            $sortField = request('sort_by');
            $sortDirection = request('sort_order', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        if (request()->has('per_page')) {
            return AcabadoTableroPorComponenteResource::collection($query->paginate(request('per_page')));
        }

        return AcabadoTableroPorComponenteResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcabadoTableroPorComponenteRequest $request)
    {
        $acabadoTableroPorComponente = AcabadoTableroPorComponente::create($request->validated());
        $acabadoTableroPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($acabadoTableroPorComponente->componente_id)
        );
        $acabadoTableroPorComponente->setAttribute(
            'acabado_tablero_nombre',
            $this->acabadoNombre($acabadoTableroPorComponente->acabado_tablero_id)
        );

        return new AcabadoTableroPorComponenteResource($acabadoTableroPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcabadoTableroPorComponente $acabadoTableroPorComponente)
    {
        $acabadoTableroPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($acabadoTableroPorComponente->componente_id)
        );
        $acabadoTableroPorComponente->setAttribute(
            'acabado_tablero_nombre',
            $this->acabadoNombre($acabadoTableroPorComponente->acabado_tablero_id)
        );

        return new AcabadoTableroPorComponenteResource($acabadoTableroPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcabadoTableroPorComponenteRequest $request, AcabadoTableroPorComponente $acabadoTableroPorComponente)
    {
        $acabadoTableroPorComponente->update($request->validated());
        $acabadoTableroPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($acabadoTableroPorComponente->componente_id)
        );
        $acabadoTableroPorComponente->setAttribute(
            'acabado_tablero_nombre',
            $this->acabadoNombre($acabadoTableroPorComponente->acabado_tablero_id)
        );

        return new AcabadoTableroPorComponenteResource($acabadoTableroPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcabadoTableroPorComponente $acabadoTableroPorComponente)
    {
        $acabadoTableroPorComponente->delete();

        return response()->noContent();
    }

    private function acabadoNombre(int $acabadoTableroId): ?string
    {
        return AcabadoTablero::query()->whereKey($acabadoTableroId)->value('nombre');
    }

    private function componenteNombre(int $componenteId): ?string
    {
        return Componente::query()->whereKey($componenteId)->value('nombre');
    }
}
