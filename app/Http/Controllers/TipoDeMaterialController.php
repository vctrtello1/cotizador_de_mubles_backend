<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoDeMaterialRequest;
use App\Http\Requests\UpdateTipoDeMaterialRequest;
use App\Http\Resources\TipoDeMaterialResource;
use App\Models\TipoDeMaterial;

class TipoDeMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TipoDeMaterialResource::collection(TipoDeMaterial::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoDeMaterialRequest $request)
    {
        $tipoDeMaterial = TipoDeMaterial::create($request->validated());
        return new TipoDeMaterialResource($tipoDeMaterial);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoDeMaterial $tipoDeMaterial)
    {
        if (request()->query('include') === 'materiales') {
            $tipoDeMaterial->load('materiales');
        }
        return new TipoDeMaterialResource($tipoDeMaterial);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoDeMaterialRequest $request, TipoDeMaterial $tipoDeMaterial)
    {
        $tipoDeMaterial->update($request->validated());
        return new TipoDeMaterialResource($tipoDeMaterial);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoDeMaterial $tipoDeMaterial)
    {
        $tipoDeMaterial->delete();
        return response()->noContent();
    }
}
