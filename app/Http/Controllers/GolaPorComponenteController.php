<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGolaPorComponenteRequest;
use App\Http\Requests\UpdateGolaPorComponenteRequest;
use App\Models\Componente;
use App\Models\Gola;
use App\Models\GolaPorComponente;

class GolaPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = GolaPorComponente::query()
            ->leftJoin('componentes as componentes', 'componentes.id', '=', 'gola_por_componente.componente_id')
            ->leftJoin('table_gola as golas', 'golas.id', '=', 'gola_por_componente.gola_id')
            ->select(
                'gola_por_componente.*',
                'componentes.nombre as componente_nombre',
                'golas.nombre as gola_nombre'
            );

        if (request()->has('componente_id')) {
            $query->where('gola_por_componente.componente_id', request('componente_id'));
        }

        if (request()->has('sort_by')) {
            $sortField = request('sort_by');
            $sortDirection = request('sort_order', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        $data = request()->has('per_page')
            ? $query->paginate(request('per_page'))
            : $query->get();

        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGolaPorComponenteRequest $request)
    {
        $golaPorComponente = GolaPorComponente::create($request->validated());
        $golaPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($golaPorComponente->componente_id)
        );
        $golaPorComponente->setAttribute(
            'gola_nombre',
            $this->golaNombre($golaPorComponente->gola_id)
        );

        return response()->json(['data' => $golaPorComponente], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GolaPorComponente $golaPorComponente)
    {
        $golaPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($golaPorComponente->componente_id)
        );
        $golaPorComponente->setAttribute(
            'gola_nombre',
            $this->golaNombre($golaPorComponente->gola_id)
        );

        return response()->json(['data' => $golaPorComponente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGolaPorComponenteRequest $request, GolaPorComponente $golaPorComponente)
    {
        $golaPorComponente->update($request->validated());
        $golaPorComponente->setAttribute(
            'componente_nombre',
            $this->componenteNombre($golaPorComponente->componente_id)
        );
        $golaPorComponente->setAttribute(
            'gola_nombre',
            $this->golaNombre($golaPorComponente->gola_id)
        );

        return response()->json(['data' => $golaPorComponente]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GolaPorComponente $golaPorComponente)
    {
        $golaPorComponente->delete();

        return response()->noContent();
    }

    private function golaNombre(int $golaId): ?string
    {
        return Gola::query()->whereKey($golaId)->value('nombre');
    }

    private function componenteNombre(int $componenteId): ?string
    {
        return Componente::query()->whereKey($componenteId)->value('nombre');
    }
}
