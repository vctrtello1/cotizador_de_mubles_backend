<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorrederaResource extends JsonResource
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
            'capacidad_carga' => $this->capacidad_carga,
            'tipo' => $this->tipo,
            'incluye_varilla' => $this->incluye_varilla,
            'precio_base' => $this->precio_base,
            'precio_con_acoplamiento' => $this->precio_con_acoplamiento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
