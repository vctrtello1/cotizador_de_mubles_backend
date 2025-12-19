<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialesPorComponenteRequest;
use App\Http\Requests\UpdateMaterialesPorComponenteRequest;
use App\Http\Resources\MaterialesPorComponenteResource;
use App\Models\MaterialesPorComponente;

class MaterialesPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = MaterialesPorComponente::query();

        if (request()->has('componente_id')) {
            $query->where('componente_id', request('componente_id'));
        }

        if (request()->has('sort_by')) {
            $sortField = request('sort_by');
            $sortDirection = request('sort_order', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        if (request()->has('per_page')) {
            return MaterialesPorComponenteResource::collection($query->paginate(request('per_page')));
        }

        return MaterialesPorComponenteResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialesPorComponenteRequest $request)
    {
        $materialesPorComponente = MaterialesPorComponente::create($request->validated());

        return new MaterialesPorComponenteResource($materialesPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialesPorComponente $materialesPorComponente)
    {
        return new MaterialesPorComponenteResource($materialesPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialesPorComponenteRequest $request, MaterialesPorComponente $materialesPorComponente)
    {
        $materialesPorComponente->update($request->validated());

        return new MaterialesPorComponenteResource($materialesPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialesPorComponente $materialesPorComponente)
    {
        $materialesPorComponente->delete();

        return response()->noContent();
    }
}
