<?php

namespace App\Http\Controllers;

use App\Models\HorasDeManoDeObraPorComponente;
use App\Http\Requests\HorasDeManoDeObraPorComponenteRequest;
use Illuminate\Http\Request;

class HorasDeManoDeObraPorComponenteController extends Controller
{
    public function index()
    {
        return HorasDeManoDeObraPorComponente::all();
    }

    public function store(HorasDeManoDeObraPorComponenteRequest $request)
    {
        $validated = $request->validated();
        
        // Establecer en 0 las horas de los otros tipos de mano de obra para este componente
        HorasDeManoDeObraPorComponente::where('componente_id', $validated['componente_id'])
            ->where('mano_de_obra_id', '!=', $validated['mano_de_obra_id'])
            ->update(['horas' => 0]);
        
        // Actualizar o crear el registro del tipo de mano de obra seleccionado
        $horas = HorasDeManoDeObraPorComponente::updateOrCreate(
            [
                'componente_id' => $validated['componente_id'],
                'mano_de_obra_id' => $validated['mano_de_obra_id'],
            ],
            [
                'horas' => $validated['horas'],
            ]
        );

        return response()->json($horas, 201);
    }

    public function show($id)
    {
        $horas = HorasDeManoDeObraPorComponente::find($id);

        if (!$horas) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return $horas;
    }

    public function update(HorasDeManoDeObraPorComponenteRequest $request, $id)
    {
        $horas = HorasDeManoDeObraPorComponente::find($id);

        if (!$horas) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $validated = $request->validated();
        
        // Si cambió el tipo de mano de obra, establecer en 0 los otros tipos
        if (isset($validated['mano_de_obra_id']) && $validated['mano_de_obra_id'] != $horas->mano_de_obra_id) {
            HorasDeManoDeObraPorComponente::where('componente_id', $horas->componente_id)
                ->where('mano_de_obra_id', '!=', $validated['mano_de_obra_id'])
                ->update(['horas' => 0]);
        }
        
        $horas->update($validated);

        return $horas;
    }

    public function destroy($id)
    {
        $horas = HorasDeManoDeObraPorComponente::find($id);

        if (!$horas) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $horas->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
