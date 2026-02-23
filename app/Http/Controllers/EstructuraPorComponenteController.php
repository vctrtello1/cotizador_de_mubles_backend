<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstructuraPorComponenteRequest;
use App\Http\Requests\UpdateEstructuraPorComponenteRequest;
use App\Http\Resources\EstructuraPorComponenteResource;
use App\Models\Estructura;
use App\Models\EstructuraPorComponente;

class EstructuraPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = EstructuraPorComponente::query()
            ->leftJoin('estructura as estructuras', 'estructuras.id', '=', 'estructura_por_componente.estructura_id')
            ->select('estructura_por_componente.*', 'estructuras.nombre as estructura_nombre');

        if (request()->has('componente_id')) {
            $query->where('componente_id', request('componente_id'));
        }

        if (request()->has('sort_by')) {
            $sortField = request('sort_by');
            $sortDirection = request('sort_order', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        if (request()->has('per_page')) {
            return EstructuraPorComponenteResource::collection($query->paginate(request('per_page')));
        }

        return EstructuraPorComponenteResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstructuraPorComponenteRequest $request)
    {
        $estructuraPorComponente = EstructuraPorComponente::create($request->validated());
        $estructuraPorComponente->setAttribute(
            'estructura_nombre',
            $this->estructuraNombre($estructuraPorComponente->estructura_id)
        );

        return new EstructuraPorComponenteResource($estructuraPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(EstructuraPorComponente $estructuraPorComponente)
    {
        $estructuraPorComponente->setAttribute(
            'estructura_nombre',
            $this->estructuraNombre($estructuraPorComponente->estructura_id)
        );

        return new EstructuraPorComponenteResource($estructuraPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstructuraPorComponenteRequest $request, EstructuraPorComponente $estructuraPorComponente)
    {
        $estructuraPorComponente->update($request->validated());
        $estructuraPorComponente->setAttribute(
            'estructura_nombre',
            $this->estructuraNombre($estructuraPorComponente->estructura_id)
        );

        return new EstructuraPorComponenteResource($estructuraPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstructuraPorComponente $estructuraPorComponente)
    {
        $estructuraPorComponente->delete();

        return response()->noContent();
    }

    private function estructuraNombre(int $estructuraId): ?string
    {
        return Estructura::query()->whereKey($estructuraId)->value('nombre');
    }
}
