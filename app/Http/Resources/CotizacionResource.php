<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CotizacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'cliente' => new ClienteResource($this->whenLoaded('cliente')),
            'fecha' => $this->fecha,
            'total' => $this->getRawOriginal('total'),
            'modulos' => $this->whenLoaded('modulosPorCotizacion', function () {
                return $this->modulosPorCotizacion->map(function ($modulo) {
                    return [
                        'id' => $modulo->id,
                        'nombre' => $modulo->nombre,
                        'descripcion' => $modulo->descripcion,
                        'codigo' => $modulo->codigo,
                        'cantidad' => $modulo->pivot->cantidad,
                    ];
                })->values();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
