<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MaterialResource;

class CantidadPorMaterialResource extends JsonResource
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
            'material_id' => $this->material_id,
            'cantidad' => $this->cantidad,
            'material' => new MaterialResource($this->whenLoaded('material')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
