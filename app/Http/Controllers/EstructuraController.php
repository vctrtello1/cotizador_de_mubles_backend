<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstructuraRequest;
use App\Http\Resources\EstructuraResource;
use App\Models\Estructura;

class EstructuraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EstructuraResource::collection(Estructura::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstructuraRequest $request)
    {
        $estructura = Estructura::create($request->validated());
        return new EstructuraResource($estructura);
    }

    /**
     * Display the specified resource.
     */
    public function show(Estructura $estructura)
    {
        return new EstructuraResource($estructura);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstructuraRequest $request, Estructura $estructura)
    {
        $estructura->update($request->validated());
        return new EstructuraResource($estructura);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estructura $estructura)
    {
        $estructura->delete();
        return response()->noContent();
    }
}
