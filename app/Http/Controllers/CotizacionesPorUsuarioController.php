<?php

namespace App\Http\Controllers;

use App\Models\CotizacionesPorUsuario;
use App\Http\Resources\CotizacionesPorUsuarioResource;
use App\Http\Requests\StoreCotizacionesPorUsuarioRequest;
use App\Http\Requests\UpdateCotizacionesPorUsuarioRequest;

class CotizacionesPorUsuarioController extends Controller
{
    public function index()
    {
        return CotizacionesPorUsuarioResource::collection(
            CotizacionesPorUsuario::with(['user', 'cotizacion'])->paginate(15)
        );
    }

    public function store(StoreCotizacionesPorUsuarioRequest $request)
    {
        $registro = CotizacionesPorUsuario::create($request->validated());
        $registro->load(['user', 'cotizacion']);

        return new CotizacionesPorUsuarioResource($registro);
    }

    public function show(CotizacionesPorUsuario $cotizacionesPorUsuario)
    {
        $cotizacionesPorUsuario->load(['user', 'cotizacion']);

        return new CotizacionesPorUsuarioResource($cotizacionesPorUsuario);
    }

    public function update(UpdateCotizacionesPorUsuarioRequest $request, CotizacionesPorUsuario $cotizacionesPorUsuario)
    {
        $cotizacionesPorUsuario->update($request->validated());

        return new CotizacionesPorUsuarioResource($cotizacionesPorUsuario);
    }

    public function destroy(CotizacionesPorUsuario $cotizacionesPorUsuario)
    {
        $cotizacionesPorUsuario->delete();

        return response()->noContent();
    }
}
