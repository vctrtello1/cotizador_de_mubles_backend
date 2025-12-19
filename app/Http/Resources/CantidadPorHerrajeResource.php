<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\HerrajeResource;

class CantidadPorHerrajeResource extends JsonResource
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
            'herraje_id' => $this->herraje_id,
            'herraje' => new HerrajeResource($this->whenLoaded('herraje')),
            'cantidad' => $this->cantidad,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
