<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFuentesDeAlimentacionRequest;
use App\Http\Requests\UpdateFuentesDeAlimentacionRequest;
use App\Http\Resources\FuentesDeAlimentacionResource;
use App\Models\FuentesDeAlimentacion;

class FuentesDeAlimentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FuentesDeAlimentacionResource::collection(FuentesDeAlimentacion::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuentesDeAlimentacionRequest $request)
    {
        $fuente = FuentesDeAlimentacion::create($request->validated());

        return new FuentesDeAlimentacionResource($fuente);
    }

    /**
     * Display the specified resource.
     */
    public function show(FuentesDeAlimentacion $fuentesDeAlimentacion)
    {
        return new FuentesDeAlimentacionResource($fuentesDeAlimentacion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuentesDeAlimentacionRequest $request, FuentesDeAlimentacion $fuentesDeAlimentacion)
    {
        $fuentesDeAlimentacion->update($request->validated());

        return new FuentesDeAlimentacionResource($fuentesDeAlimentacion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuentesDeAlimentacion $fuentesDeAlimentacion)
    {
        $fuentesDeAlimentacion->delete();

        return response()->noContent();
    }
}
