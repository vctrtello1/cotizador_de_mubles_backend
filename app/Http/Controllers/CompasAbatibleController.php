<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompasAbatibleRequest;
use App\Http\Requests\UpdateCompasAbatibleRequest;
use App\Http\Resources\CompasAbatibleResource;
use App\Models\CompasAbatible;

class CompasAbatibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compasesAbatibles = CompasAbatible::all();
        return CompasAbatibleResource::collection($compasesAbatibles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompasAbatibleRequest $request)
    {
        $compasAbatible = CompasAbatible::create($request->validated());
        return new CompasAbatibleResource($compasAbatible);
    }

    /**
     * Display the specified resource.
     */
    public function show(CompasAbatible $compasAbatible)
    {
        return new CompasAbatibleResource($compasAbatible);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompasAbatibleRequest $request, CompasAbatible $compasAbatible)
    {
        $compasAbatible->update($request->validated());
        return new CompasAbatibleResource($compasAbatible);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompasAbatible $compasAbatible)
    {
        $compasAbatible->delete();
        return response()->noContent();
    }
}
