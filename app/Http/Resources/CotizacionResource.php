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
            'total' => number_format($this->total, 2),
            'modulos' => $this->whenLoaded('modulosPorCotizacion', function () {
                return $this->modulosPorCotizacion->map(function ($modulo) {
                    $componentes = [];
                    if ($modulo->relationLoaded('componentes')) {
                        $componentes = $modulo->componentes->map(function ($componente) {
                            // Calcular precio unitario (costo de acabado + costo de mano de obra)
                            $precioUnitario = 0;
                            if ($componente->relationLoaded('acabado') && $componente->acabado) {
                                $precioUnitario += $componente->acabado->costo;
                            }
                            if ($componente->relationLoaded('mano_de_obra') && $componente->mano_de_obra) {
                                $precioUnitario += $componente->mano_de_obra->costo_total;
                            }
                            
                            $subtotal = $precioUnitario * $componente->pivot->cantidad;
                            
                            return [
                                'id' => $componente->id,
                                'nombre' => $componente->nombre,
                                'descripcion' => $componente->descripcion,
                                'codigo' => $componente->codigo,
                                'cantidad' => $componente->pivot->cantidad,
                                'acabado_id' => $componente->acabado_id,
                                'mano_de_obra_id' => $componente->mano_de_obra_id,
                                'precio_unitario' => number_format($precioUnitario, 2),
                                'subtotal' => number_format($subtotal, 2),
                            ];
                        })->values()->all();
                    }
                    
                    return [
                        'id' => $modulo->id,
                        'nombre' => $modulo->nombre,
                        'descripcion' => $modulo->descripcion,
                        'codigo' => $modulo->codigo,
                        'cantidad' => $modulo->pivot->cantidad,
                        'componentes' => $componentes,
                    ];
                })->values();
            }),
            'detalles' => $this->whenLoaded('detalles', function () {
                return $this->detalles->map(function ($detalle) {
                    return [
                        'id' => $detalle->id,
                        'descripcion' => $detalle->descripcion,
                        'cantidad' => $detalle->cantidad,
                        'precio_unitario' => $detalle->precio_unitario,
                        'subtotal' => $detalle->subtotal,
                        'created_at' => $detalle->created_at,
                        'updated_at' => $detalle->updated_at,
                    ];
                })->values();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
