<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModulosRequest;
use App\Http\Requests\UpdateModulosRequest;
use App\Models\modulos;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return modulos::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModulosRequest $request)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(modulos $modulo)
    {
        //
    }
}
