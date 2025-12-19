<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcabadoRequest;
use App\Http\Requests\UpdateAcabadoRequest;
use App\Http\Resources\AcabadoResource;
use App\Models\Acabado;

class AcabadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return AcabadoResource::collection(Acabado::all());
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcabadoRequest $request)
    {
        //
        $acabado = Acabado::create($request->validated());
        return new AcabadoResource($acabado);
    }

    /**
     * Display the specified resource.
     */
    public function show(Acabado $acabado)
    {
        if (request()->query('include') === 'componentes') {
            $acabado->load('componentes');
        }
        return new AcabadoResource($acabado);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcabadoRequest $request, Acabado $acabado)
    {
        //
        $acabado->update($request->validated());
        return new AcabadoResource($acabado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acabado $acabado)
    {
        //
        $acabado->delete();
        return response()->noContent();
    }
}
