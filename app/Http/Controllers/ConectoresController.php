<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConectoresRequest;
use App\Http\Requests\UpdateConectoresRequest;
use App\Http\Resources\ConectoresResource;
use App\Models\Conectores;

class ConectoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ConectoresResource::collection(Conectores::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConectoresRequest $request)
    {
        $conector = Conectores::create($request->validated());

        return new ConectoresResource($conector);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conectores $conectore)
    {
        return new ConectoresResource($conectore);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConectoresRequest $request, Conectores $conectore)
    {
        $conectore->update($request->validated());

        return new ConectoresResource($conectore);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conectores $conectore)
    {
        $conectore->delete();

        return response()->noContent();
    }
}
