<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCantidadPorMaterialRequest;
use App\Http\Requests\UpdateCantidadPorMaterialRequest;
use App\Http\Resources\CantidadPorMaterialResource;
use App\Models\CantidadPorMaterial;

class CantidadPorMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CantidadPorMaterialResource::collection(CantidadPorMaterial::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCantidadPorMaterialRequest $request)
    {
        $cantidadPorMaterial = CantidadPorMaterial::create($request->validated());

        return new CantidadPorMaterialResource($cantidadPorMaterial);
    }

    /**
     * Display the specified resource.
     */
    public function show(CantidadPorMaterial $cantidadPorMaterial)
    {
        if (request()->query('include') === 'material') {
            $cantidadPorMaterial->load('material');
        }
        return new CantidadPorMaterialResource($cantidadPorMaterial);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCantidadPorMaterialRequest $request, CantidadPorMaterial $cantidadPorMaterial)
    {
        $cantidadPorMaterial->update($request->validated());

        return new CantidadPorMaterialResource($cantidadPorMaterial);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CantidadPorMaterial $cantidadPorMaterial)
    {
        $cantidadPorMaterial->delete();

        return response()->noContent();
    }
}
