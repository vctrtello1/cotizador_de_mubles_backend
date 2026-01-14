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
        $horas = HorasDeManoDeObraPorComponente::create($validated);

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
