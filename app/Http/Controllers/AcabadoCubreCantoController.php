<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcabadoCubreCantoRequest;
use App\Http\Resources\AcabadoCubreCantoResource;
use App\Models\AcabadoCubreCanto;

class AcabadoCubreCantoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AcabadoCubreCantoResource::collection(AcabadoCubreCanto::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcabadoCubreCantoRequest $request)
    {
        $acabadoCubreCanto = AcabadoCubreCanto::create($request->validated());
        return new AcabadoCubreCantoResource($acabadoCubreCanto);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcabadoCubreCanto $acabadoCubreCanto)
    {
        return new AcabadoCubreCantoResource($acabadoCubreCanto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcabadoCubreCantoRequest $request, AcabadoCubreCanto $acabadoCubreCanto)
    {
        $acabadoCubreCanto->update($request->validated());
        return new AcabadoCubreCantoResource($acabadoCubreCanto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcabadoCubreCanto $acabadoCubreCanto)
    {
        $acabadoCubreCanto->delete();
        return response()->noContent();
    }
}
