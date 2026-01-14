<?php

namespace App\Http\Controllers;

use App\Models\CantidadPorComponente;
use App\Http\Resources\CantidadPorComponenteResource;
use Illuminate\Http\Request;

class CantidadPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cantidadPorComponentes = CantidadPorComponente::all();
        return CantidadPorComponenteResource::collection($cantidadPorComponentes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'componente_id' => 'required|integer|exists:componentes,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $cantidadPorComponente = CantidadPorComponente::create($validated);
        return new CantidadPorComponenteResource($cantidadPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(CantidadPorComponente $cantidadPorComponente)
    {
        if (request()->has('include')) {
            $includes = explode(',', request('include'));
            if (in_array('componente', $includes)) {
                $cantidadPorComponente->load('componente');
            }
        }
        return new CantidadPorComponenteResource($cantidadPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CantidadPorComponente $cantidadPorComponente)
    {
        $validated = $request->validate([
            'componente_id' => 'integer|exists:componentes,id',
            'cantidad' => 'integer|min:1',
        ]);

        $cantidadPorComponente->update($validated);
        return new CantidadPorComponenteResource($cantidadPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CantidadPorComponente $cantidadPorComponente)
    {
        $cantidadPorComponente->delete();
        return response()->noContent();
    }
}
