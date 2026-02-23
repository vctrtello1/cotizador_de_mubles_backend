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
        return [ 
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'codigo' => $this->codigo,
            'accesorios' => AccesoriosPorComponenteResource::collection($this->whenLoaded('accesorios_por_componente')),
            'cantidad' => $this->whenPivotLoaded('cantidad_por_componente', function () {
                return $this->pivot->cantidad;
            }),
            'costo_total' => $this->costo_total,
        ];
    }
}
