<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstructuraRequest;
use App\Http\Resources\EstructuraResource;
use App\Models\Estructura;
use Illuminate\Database\QueryException;

class EstructuraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EstructuraResource::collection(Estructura::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstructuraRequest $request)
    {
        $estructura = Estructura::create($request->validated());
        return new EstructuraResource($estructura);
    }

    /**
     * Display the specified resource.
     */
    public function show(Estructura $estructura)
    {
        return new EstructuraResource($estructura);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstructuraRequest $request, Estructura $estructura)
    {
        $estructura->update($request->validated());
        return new EstructuraResource($estructura);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estructura $estructura)
    {
        try {
            $estructura->delete();
        } catch (QueryException $e) {
            if (str_starts_with($e->getCode(), '23')) {
                return response()->json([
                    'message' => 'No se puede eliminar la estructura porque está siendo utilizada por uno o más componentes.',
                ], 409);
            }
            throw $e;
        }

        return response()->noContent();
    }
}
