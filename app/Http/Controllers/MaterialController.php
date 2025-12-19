<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return MaterialResource::collection(Material::with('tipo_de_material')->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialRequest $request)
    {
        //
        $material = Material::create($request->validated());
        $material->load('tipo_de_material');
        return new MaterialResource($material);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
        $material->load('tipo_de_material');
        return new MaterialResource($material);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        //
        $material->update($request->validated());
        $material->load('tipo_de_material');
        return new MaterialResource($material);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        //
        $material->delete();
        return response()->noContent();
    }
}
