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
            'modulos' => $this->whenLoaded('detalles', function () {
                return $this->detalles->groupBy('modulo_id')->map(function ($detalles) {
                    $modulo = $detalles->first()->modulo;
                    return [
                        'id' => $modulo->id,
                        'nombre' => $modulo->nombre,
                        'descripcion' => $modulo->descripcion,
                        'codigo' => $modulo->codigo,
                        'detalles' => $detalles->map(function ($detalle) {
                            return [
                                'id' => $detalle->id,
                                'descripcion' => $detalle->descripcion,
                                'cantidad' => $detalle->cantidad,
                                'precio_unitario' => $detalle->precio_unitario,
                                'subtotal' => $detalle->subtotal,
                                'created_at' => $detalle->created_at,
                                'updated_at' => $detalle->updated_at,
                            ];
                        })->values()
                    ];
                })->values();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
