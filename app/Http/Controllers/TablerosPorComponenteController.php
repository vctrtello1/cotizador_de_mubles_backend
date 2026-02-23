<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTablerosPorComponenteRequest;
use App\Http\Requests\UpdateTablerosPorComponenteRequest;
use App\Http\Resources\TablerosPorComponenteResource;
use App\Models\TablerosPorComponente;

class TablerosPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = TablerosPorComponente::query();

        if (request()->has('componente_id')) {
            $query->where('componente_id', request('componente_id'));
        }

        if (request()->has('sort_by')) {
            $sortField = request('sort_by');
            $sortDirection = request('sort_order', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        if (request()->has('per_page')) {
            return TablerosPorComponenteResource::collection($query->paginate(request('per_page')));
        }

        return TablerosPorComponenteResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTablerosPorComponenteRequest $request)
    {
        $tablerosPorComponente = TablerosPorComponente::create($request->validated());

        return new TablerosPorComponenteResource($tablerosPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(TablerosPorComponente $tablerosPorComponente)
    {
        return new TablerosPorComponenteResource($tablerosPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTablerosPorComponenteRequest $request, TablerosPorComponente $tablerosPorComponente)
    {
        $tablerosPorComponente->update($request->validated());

        return new TablerosPorComponenteResource($tablerosPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TablerosPorComponente $tablerosPorComponente)
    {
        $tablerosPorComponente->delete();

        return response()->noContent();
    }
}
