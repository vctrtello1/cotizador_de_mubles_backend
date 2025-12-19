<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCantidadPorHerrajeRequest;
use App\Http\Requests\UpdateCantidadPorHerrajeRequest;
use App\Http\Resources\CantidadPorHerrajeResource;
use App\Models\CantidadPorHerraje;

class CantidadPorHerrajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CantidadPorHerrajeResource::collection(CantidadPorHerraje::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCantidadPorHerrajeRequest $request)
    {
        $cantidadPorHerraje = CantidadPorHerraje::create($request->validated());

        return new CantidadPorHerrajeResource($cantidadPorHerraje);
    }

    /**
     * Display the specified resource.
     */
    public function show(CantidadPorHerraje $cantidadPorHerraje)
    {
        if (request()->query('include') === 'herraje') {
            $cantidadPorHerraje->load('herraje');
        }
        return new CantidadPorHerrajeResource($cantidadPorHerraje);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCantidadPorHerrajeRequest $request, CantidadPorHerraje $cantidadPorHerraje)
    {
        $cantidadPorHerraje->update($request->validated());

        return new CantidadPorHerrajeResource($cantidadPorHerraje);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CantidadPorHerraje $cantidadPorHerraje)
    {
        $cantidadPorHerraje->delete();

        return response()->noContent();
    }
}
