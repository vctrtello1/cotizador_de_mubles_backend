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
            'total' => number_format($this->calculateTotal(), 2),
            'modulos' => $this->whenLoaded('modulosPorCotizacion', function () {
                // Group modules by ID and sum quantities
                return $this->modulosPorCotizacion
                    ->groupBy('id')
                    ->map(function ($modulosGroup) {
                        // Get first module to get the basic info
                        $moduloPrimero = $modulosGroup->first();
                        
                        // Sum quantities
                        $cantidadTotal = $modulosGroup->sum('pivot.cantidad');
                        
                        // Get components from first module
                        $componentes = [];
                        if ($moduloPrimero->relationLoaded('componentes')) {
                            $componentes = $moduloPrimero->componentes->map(function ($componente) use ($cantidadTotal) {
                                // Calcular precio unitario (costo de acabado + costo de mano de obra)
                                $precioUnitario = 0;
                                if ($componente->relationLoaded('acabado') && $componente->acabado) {
                                    $precioUnitario += $componente->acabado->costo;
                                }
                                if ($componente->relationLoaded('mano_de_obra') && $componente->mano_de_obra) {
                                    $precioUnitario += $componente->mano_de_obra->costo_total;
                                }
                                
                                // Multiply component quantity by module quantity
                                $cantidadComponente = $componente->pivot->cantidad * $cantidadTotal;
                                $subtotal = $precioUnitario * $cantidadComponente;
                                
                                return [
                                    'id' => $componente->id,
                                    'nombre' => $componente->nombre,
                                    'descripcion' => $componente->descripcion,
                                    'codigo' => $componente->codigo,
                                    'cantidad' => $cantidadComponente,
                                    'acabado_id' => $componente->acabado_id,
                                    'mano_de_obra_id' => $componente->mano_de_obra_id,
                                    'precio_unitario' => number_format($precioUnitario, 2),
                                    'subtotal' => number_format($subtotal, 2),
                                ];
                            })->values()->all();
                        }
                        
                        return [
                            'id' => $moduloPrimero->id,
                            'nombre' => $moduloPrimero->nombre,
                            'descripcion' => $moduloPrimero->descripcion,
                            'codigo' => $moduloPrimero->codigo,
                            'cantidad' => $cantidadTotal,
                            'componentes' => $componentes,
                        ];
                    })
                    ->values();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
