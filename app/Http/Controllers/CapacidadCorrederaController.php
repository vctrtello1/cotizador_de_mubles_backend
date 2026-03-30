<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCapacidadCorrederaRequest;
use App\Http\Requests\UpdateCapacidadCorrederaRequest;
use App\Http\Resources\CapacidadCorrederaResource;
use App\Models\CapacidadCorredera;

class CapacidadCorrederaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CapacidadCorrederaResource::collection(CapacidadCorredera::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCapacidadCorrederaRequest $request)
    {
        $capacidadCorredera = CapacidadCorredera::create($request->validated());
        return new CapacidadCorrederaResource($capacidadCorredera);
    }

    /**
     * Display the specified resource.
     */
    public function show(CapacidadCorredera $capacidadCorredera)
    {
        return new CapacidadCorrederaResource($capacidadCorredera);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCapacidadCorrederaRequest $request, CapacidadCorredera $capacidadCorredera)
    {
        $capacidadCorredera->update($request->validated());
        return new CapacidadCorrederaResource($capacidadCorredera);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CapacidadCorredera $capacidadCorredera)
    {
        $capacidadCorredera->delete();
        return response()->noContent();
    }
}
