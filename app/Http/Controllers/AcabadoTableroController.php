<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcabadoTableroRequest;
use App\Http\Resources\AcabadoTableroResource;
use App\Models\AcabadoTablero;

class AcabadoTableroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AcabadoTableroResource::collection(AcabadoTablero::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcabadoTableroRequest $request)
    {
        $acabadoTablero = AcabadoTablero::create($request->validated());
        return new AcabadoTableroResource($acabadoTablero);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcabadoTablero $acabadoTablero)
    {
        return new AcabadoTableroResource($acabadoTablero);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcabadoTableroRequest $request, AcabadoTablero $acabadoTablero)
    {
        $acabadoTablero->update($request->validated());
        return new AcabadoTableroResource($acabadoTablero);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcabadoTablero $acabadoTablero)
    {
        $acabadoTablero->delete();
        return response()->noContent();
    }
}
