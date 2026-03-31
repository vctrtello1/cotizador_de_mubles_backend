<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcabadoTableroRequest;
use App\Http\Resources\AcabadoTableroResource;
use App\Models\AcabadoTablero;
use Illuminate\Database\QueryException;

class AcabadoTableroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AcabadoTableroResource::collection(AcabadoTablero::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcabadoTableroRequest $request)
    {
        $acabadoTablero = AcabadoTablero::create($request->validated());
        return new AcabadoTableroResource($acabadoTablero);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcabadoTablero $acabadoTablero)
    {
        return new AcabadoTableroResource($acabadoTablero);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcabadoTableroRequest $request, AcabadoTablero $acabadoTablero)
    {
        $acabadoTablero->update($request->validated());
        return new AcabadoTableroResource($acabadoTablero);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcabadoTablero $acabadoTablero)
    {
        try {
            $acabadoTablero->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'No se puede eliminar el acabado tablero porque está siendo utilizado por uno o más componentes.',
                ], 409);
            }
            throw $e;
        }

        return response()->noContent();
    }
}
