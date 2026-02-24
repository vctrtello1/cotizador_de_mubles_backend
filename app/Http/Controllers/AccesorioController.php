<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccesorioRequest;
use App\Http\Requests\UpdateAccesorioRequest;
use App\Http\Resources\AccesorioResource;
use App\Models\Accesorio;

class AccesorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AccesorioResource::collection(Accesorio::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccesorioRequest $request)
    {
        $accesorio = Accesorio::create($request->validated());

        return new AccesorioResource($accesorio);
    }

    /**
     * Display the specified resource.
     */
    public function show(Accesorio $accesorio)
    {
        return new AccesorioResource($accesorio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccesorioRequest $request, Accesorio $accesorio)
    {
        $accesorio->update($request->validated());

        return new AccesorioResource($accesorio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accesorio $accesorio)
    {
        $accesorio->delete();

        return response()->noContent();
    }
}
