<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApagadoresRequest;
use App\Http\Requests\UpdateApagadoresRequest;
use App\Http\Resources\ApagadoresResource;
use App\Models\Apagadores;

class ApagadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApagadoresResource::collection(Apagadores::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApagadoresRequest $request)
    {
        $apagador = Apagadores::create($request->validated());

        return new ApagadoresResource($apagador);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apagadores $apagadore)
    {
        return new ApagadoresResource($apagadore);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApagadoresRequest $request, Apagadores $apagadore)
    {
        $apagadore->update($request->validated());

        return new ApagadoresResource($apagadore);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apagadores $apagadore)
    {
        $apagadore->delete();

        return response()->noContent();
    }
}
