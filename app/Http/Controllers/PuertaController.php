<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePuertaRequest;
use App\Http\Requests\UpdatePuertaRequest;
use App\Http\Resources\PuertaResource;
use App\Models\Puerta;

class PuertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $puertas = Puerta::all();
        return PuertaResource::collection($puertas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePuertaRequest $request)
    {
        $puerta = Puerta::create($request->validated());
        return new PuertaResource($puerta);
    }

    /**
     * Display the specified resource.
     */
    public function show(Puerta $puerta)
    {
        return new PuertaResource($puerta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePuertaRequest $request, Puerta $puerta)
    {
        $puerta->update($request->validated());
        return new PuertaResource($puerta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Puerta $puerta)
    {
        $puerta->delete();
        return response()->noContent();
    }
}
