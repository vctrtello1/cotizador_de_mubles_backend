<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PuertasPorComponenteResource extends JsonResource
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
            'componente_nombre' => $this->componente_nombre,
            'puerta_id' => $this->puerta_id,
            'puerta_nombre' => $this->puerta_nombre,
            'cantidad' => $this->cantidad,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
