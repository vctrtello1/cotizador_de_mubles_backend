<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccesoriosPorComponenteRequest;
use App\Http\Requests\UpdateAccesoriosPorComponenteRequest;
use App\Http\Resources\AccesoriosPorComponenteResource;
use App\Models\AccesoriosPorComponente;

class AccesoriosPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AccesoriosPorComponenteResource::collection(AccesoriosPorComponente::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccesoriosPorComponenteRequest $request)
    {
        $accesoriosPorComponente = AccesoriosPorComponente::create($request->validated());

        return new AccesoriosPorComponenteResource($accesoriosPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(AccesoriosPorComponente $accesoriosPorComponente)
    {
        return new AccesoriosPorComponenteResource($accesoriosPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccesoriosPorComponenteRequest $request, AccesoriosPorComponente $accesoriosPorComponente)
    {
        $accesoriosPorComponente->update($request->validated());

        return new AccesoriosPorComponenteResource($accesoriosPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccesoriosPorComponente $accesoriosPorComponente)
    {
        $accesoriosPorComponente->delete();

        return response()->noContent();
    }
}
