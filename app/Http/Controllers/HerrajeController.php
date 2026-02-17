<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHerrajeRequest;
use App\Http\Requests\UpdateHerrajeRequest;
use App\Http\Resources\HerrajeResource;
use App\Models\Herraje;

class HerrajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HerrajeResource::collection(Herraje::paginate(15));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHerrajeRequest $request)
    {
        $herraje = Herraje::create($request->validated());
        return new HerrajeResource($herraje);
    }

    /**
     * Display the specified resource.
     */
    public function show(Herraje $herraje)
    {
        return new HerrajeResource($herraje);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHerrajeRequest $request, Herraje $herraje)
    {
        $herraje->update($request->validated());
        return new HerrajeResource($herraje);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Herraje $herraje)
    {
        $herraje->delete();
        return response()->noContent();
    }
}
