<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCorrederaRequest;
use App\Http\Requests\UpdateCorrederaRequest;
use App\Http\Resources\CorrederaResource;
use App\Models\Corredera;

class CorrederaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CorrederaResource::collection(Corredera::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCorrederaRequest $request)
    {
        $corredera = Corredera::create($request->validated());
        return new CorrederaResource($corredera);
    }

    /**
     * Display the specified resource.
     */
    public function show(Corredera $corredera)
    {
        return new CorrederaResource($corredera);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCorrederaRequest $request, Corredera $corredera)
    {
        $corredera->update($request->validated());
        return new CorrederaResource($corredera);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Corredera $corredera)
    {
        $corredera->delete();
        return response()->noContent();
    }
}
