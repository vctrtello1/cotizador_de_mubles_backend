<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGolaRequest;
use App\Http\Requests\UpdateGolaRequest;
use App\Http\Resources\GolaResource;
use App\Models\Gola;


class GolaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GolaResource::collection(Gola::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGolaRequest $request)
    {
        $gola = Gola::create($request->validated());
        return new GolaResource($gola);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gola $gola)
    {
        return new GolaResource($gola);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGolaRequest $request, Gola $gola)
    {
        $gola->update($request->validated());
        return new GolaResource($gola);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gola $gola)
    {
        $gola->delete();
        return response()->noContent();
    }
}
