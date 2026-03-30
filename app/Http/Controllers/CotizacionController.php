<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionesPorUsuario;
use App\Http\Resources\CotizacionResource;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Cotizacion::with(['cliente']);

        if ($user->rol === 'vendedor') {
            $query->where(function ($q) use ($user) {
                $q->where('created_by_user_id', $user->id)
                  ->orWhereHas('usuariosAsignados', function ($q2) use ($user) {
                      $q2->where('user_id', $user->id);
                  });
            });
        }

        return CotizacionResource::collection($query->paginate(15));
    }

    public function store(StoreCotizacionRequest $request)
    {
        $data    = $request->validated();
        $user    = $request->user();
        $data['created_by_user_id'] = $user->id;

        $cotizacion = DB::transaction(function () use ($data, $user) {
            $cotizacion = Cotizacion::create($data);

            if (isset($data['detalles'])) {
                $detalles = collect($data['detalles'])->map(function ($detalle) {
                    if (!isset($detalle['subtotal'])) {
                        $detalle['subtotal'] = $detalle['cantidad'] * $detalle['precio_unitario'];
                    }
                    return $detalle;
                });
                $cotizacion->detalles()->createMany($detalles);
            }

            if ($user->rol === 'vendedor') {
                CotizacionesPorUsuario::create([
                    'user_id'       => $user->id,
                    'cotizacion_id' => $cotizacion->id,
                ]);
            }

            return $cotizacion;
        });

        $cotizacion->load(['detalles', 'cliente']);
        return new CotizacionResource($cotizacion);
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['detalles', 'cliente']);
        return new CotizacionResource($cotizacion);
    }

    public function update(UpdateCotizacionRequest $request, Cotizacion $cotizacion)
    {
        $cotizacion->update($request->validated());
        return new CotizacionResource($cotizacion);
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->componentesPorCotizacion()->delete();
        $cotizacion->delete();
        
        return response()->noContent();
    }

    /**
     * Update the estado (status) of a quotation.
     */
    public function updateEstado(Request $request, Cotizacion $cotizacion)
    {
        $validated = $request->validate([
            'estado' => 'required|string|in:activa,pendiente,completada,rechazada,cancelada',
        ]);

        $cotizacion->update(['estado' => $validated['estado']]);
        
        return new CotizacionResource($cotizacion);
    }
}
