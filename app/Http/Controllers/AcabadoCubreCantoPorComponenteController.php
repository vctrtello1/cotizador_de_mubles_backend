<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcabadoCubreCantoPorComponenteRequest;
use App\Http\Requests\UpdateAcabadoCubreCantoPorComponenteRequest;
use App\Http\Resources\AcabadoCubreCantoPorComponenteResource;
use App\Models\AcabadoCubreCanto;
use App\Models\AcabadoCubreCantoPorComponente;
use App\Models\Componente;

class AcabadoCubreCantoPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = AcabadoCubreCantoPorComponente::query()
            ->leftJoin('componentes as componentes', 'componentes.id', '=', 'acabado_cubre_canto_por_componente.componente_id')
            ->leftJoin('acabado_cubre_cantos as acabados', 'acabados.id', '=', 'acabado_cubre_canto_por_componente.acabado_cubre_canto_id')
            ->select(
                'acabado_cubre_canto_por_componente.*',
                'componentes.nombre as componente_nombre',
                'acabados.nombre as acabado_cubre_canto_nombre'
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
            return AcabadoCubreCantoPorComponenteResource::collection($query->paginate(request('per_page')));
        }

        return AcabadoCubreCantoPorComponenteResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcabadoCubreCantoPorComponenteRequest $request)
    {
        $acabadoCubreCantoPorComponente = AcabadoCubreCantoPorComponente::create($request->validated());
        $acabadoCubreCantoPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($acabadoCubreCantoPorComponente->componente_id)
        );
        $acabadoCubreCantoPorComponente->setAttribute(
            'acabado_cubre_canto_nombre',
            $this->acabadoNombre($acabadoCubreCantoPorComponente->acabado_cubre_canto_id)
        );

        return new AcabadoCubreCantoPorComponenteResource($acabadoCubreCantoPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcabadoCubreCantoPorComponente $acabadoCubreCantoPorComponente)
    {
        $acabadoCubreCantoPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($acabadoCubreCantoPorComponente->componente_id)
        );
        $acabadoCubreCantoPorComponente->setAttribute(
            'acabado_cubre_canto_nombre',
            $this->acabadoNombre($acabadoCubreCantoPorComponente->acabado_cubre_canto_id)
        );

        return new AcabadoCubreCantoPorComponenteResource($acabadoCubreCantoPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcabadoCubreCantoPorComponenteRequest $request, AcabadoCubreCantoPorComponente $acabadoCubreCantoPorComponente)
    {
        $acabadoCubreCantoPorComponente->update($request->validated());
        $acabadoCubreCantoPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($acabadoCubreCantoPorComponente->componente_id)
        );
        $acabadoCubreCantoPorComponente->setAttribute(
            'acabado_cubre_canto_nombre',
            $this->acabadoNombre($acabadoCubreCantoPorComponente->acabado_cubre_canto_id)
        );

        return new AcabadoCubreCantoPorComponenteResource($acabadoCubreCantoPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcabadoCubreCantoPorComponente $acabadoCubreCantoPorComponente)
    {
        $acabadoCubreCantoPorComponente->delete();

        return response()->noContent();
    }

    private function acabadoNombre(int $acabadoCubreCantoId): ?string
    {
        return AcabadoCubreCanto::query()->whereKey($acabadoCubreCantoId)->value('nombre');
    }

    private function componenteNombre(int $componenteId): ?string
    {
        return Componente::query()->whereKey($componenteId)->value('nombre');
    }
}
