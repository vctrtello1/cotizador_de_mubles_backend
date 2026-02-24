<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComponenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $canViewDetailedPrices = ! $request->user() || $request->user()->hasPermission('catalogs.write');

        return [ 
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'codigo' => $this->codigo,
            'precio_unitario' => $this->precio_unitario,
            'accesorios' => AccesoriosPorComponenteResource::collection($this->whenLoaded('accesorios_por_componente')),
            'cantidad' => $this->whenPivotLoaded('cantidad_por_componente', function () {
                return $this->pivot->cantidad;
            }),
            'costo_total' => $this->when($canViewDetailedPrices, $this->costo_total),
        ];
    }
}
