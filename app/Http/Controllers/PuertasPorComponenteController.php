<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePuertasPorComponenteRequest;
use App\Http\Requests\UpdatePuertasPorComponenteRequest;
use App\Http\Resources\PuertasPorComponenteResource;
use App\Models\Componente;
use App\Models\Puerta;
use App\Models\PuertasPorComponente;

class PuertasPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = PuertasPorComponente::query()
            ->leftJoin('componentes as componentes', 'componentes.id', '=', 'puertas_por_componente.componente_id')
            ->leftJoin('puertas as puertas', 'puertas.id', '=', 'puertas_por_componente.puerta_id')
            ->select(
                'puertas_por_componente.*',
                'componentes.nombre as componente_nombre',
                'puertas.nombre as puerta_nombre'
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
            return PuertasPorComponenteResource::collection($query->paginate(request('per_page')));
        }

        return PuertasPorComponenteResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePuertasPorComponenteRequest $request)
    {
        $puertasPorComponente = PuertasPorComponente::create($request->validated());
        $puertasPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($puertasPorComponente->componente_id)
        );
        $puertasPorComponente->setAttribute(
            'puerta_nombre',
            $this->puertaNombre($puertasPorComponente->puerta_id)
        );

        return new PuertasPorComponenteResource($puertasPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(PuertasPorComponente $puertasPorComponente)
    {
        $puertasPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($puertasPorComponente->componente_id)
        );
        $puertasPorComponente->setAttribute(
            'puerta_nombre',
            $this->puertaNombre($puertasPorComponente->puerta_id)
        );

        return new PuertasPorComponenteResource($puertasPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePuertasPorComponenteRequest $request, PuertasPorComponente $puertasPorComponente)
    {
        $puertasPorComponente->update($request->validated());
        $puertasPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($puertasPorComponente->componente_id)
        );
        $puertasPorComponente->setAttribute(
            'puerta_nombre',
            $this->puertaNombre($puertasPorComponente->puerta_id)
        );

        return new PuertasPorComponenteResource($puertasPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PuertasPorComponente $puertasPorComponente)
    {
        $puertasPorComponente->delete();

        return response()->noContent();
    }

    private function puertaNombre(int $puertaId): ?string
    {
        return Puerta::query()->whereKey($puertaId)->value('nombre');
    }

    private function componenteNombre(int $componenteId): ?string
    {
        return Componente::query()->whereKey($componenteId)->value('nombre');
    }
}
