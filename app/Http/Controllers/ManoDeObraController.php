<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManoDeObraRequest;
use App\Http\Requests\UpdateManoDeObraRequest;
use App\Http\Resources\ManoDeObraResource;
use App\Models\ManoDeObra;
use App\Models\HorasDeManoDeObraPorComponente;

class ManoDeObraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ManoDeObraResource::collection(ManoDeObra::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManoDeObraRequest $request)
    {
        $manoDeObra = ManoDeObra::create($request->validated());
        return new ManoDeObraResource($manoDeObra);
    }

    /**
     * Display the specified resource.
     */
    public function show(ManoDeObra $manoDeObra)
    {
        if (request()->query('include') === 'componentes') {
            $manoDeObra->load('componentes');
        }
        return new ManoDeObraResource($manoDeObra);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManoDeObraRequest $request, ManoDeObra $manoDeObra)
    {
        $manoDeObra->update($request->validated());
        
        // Verificar si hay componentes que usan esta mano de obra
        $componentes = $manoDeObra->componentes;
        
        foreach ($componentes as $componente) {
            // Verificar si existe un registro en horas_de_mano_de_obra_por_componente
            $horasRegistro = HorasDeManoDeObraPorComponente::where('componente_id', $componente->id)
                ->where('mano_de_obra_id', $manoDeObra->id)
                ->first();
            
            // Si no existe, crear uno con valor de 1 hora
            if (!$horasRegistro) {
                HorasDeManoDeObraPorComponente::create([
                    'componente_id' => $componente->id,
                    'mano_de_obra_id' => $manoDeObra->id,
                    'horas' => 1,
                ]);
            }
        }
        
        return new ManoDeObraResource($manoDeObra);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManoDeObra $manoDeObra)
    {
        $manoDeObra->delete();
        return response()->noContent();
    }
}
