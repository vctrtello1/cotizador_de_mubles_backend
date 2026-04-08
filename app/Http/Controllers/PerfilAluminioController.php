<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerfilAluminioRequest;
use App\Http\Requests\UpdatePerfilAluminioRequest;
use App\Http\Resources\PerfilAluminioResource;
use App\Models\PerfilAluminio;

class PerfilAluminioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PerfilAluminioResource::collection(PerfilAluminio::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerfilAluminioRequest $request)
    {
        $perfil = PerfilAluminio::create($request->validated());

        return new PerfilAluminioResource($perfil);
    }

    /**
     * Display the specified resource.
     */
    public function show(PerfilAluminio $perfilAluminio)
    {
        return new PerfilAluminioResource($perfilAluminio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerfilAluminioRequest $request, PerfilAluminio $perfilAluminio)
    {
        $perfilAluminio->update($request->validated());

        return new PerfilAluminioResource($perfilAluminio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerfilAluminio $perfilAluminio)
    {
        $perfilAluminio->delete();

        return response()->noContent();
    }
}
