<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModulosRequest;
use App\Http\Requests\UpdateModulosRequest;
use App\Models\Modulos;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Modulos::with('componentes')->get()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModulosRequest $request)
    {
        $modulo = Modulos::create($request->validated());
        return $modulo->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(modulos $modulo)
    {
        return $modulo-> toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModulosRequest $request, modulos $modulo)
    {
        //
        $modulo->update($request->validated());
        return $modulo->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(modulos $modulo)
    {
        //
        $modulo->delete();
        return response()->noContent();
    }
}
