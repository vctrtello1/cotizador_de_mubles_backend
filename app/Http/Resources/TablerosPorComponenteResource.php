<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TablerosPorComponenteResource extends JsonResource
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
            'componente_id' => $this->componente_id,
            'tablero_id' => $this->tablero_id,
            'tablero_nombre' => $this->tablero_nombre
                ?? ($this->relationLoaded('tablero') ? $this->tablero?->nombre : null),
            'cantidad' => $this->cantidad,
            'componente' => $this->whenLoaded('componente', function () {
                return new ComponenteResource($this->componente);
            }),
            'tablero' => $this->whenLoaded('tablero', function () {
                return new MaterialResource($this->tablero);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
