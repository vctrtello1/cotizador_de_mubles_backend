<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'precio_unitario' => $this->precio_unitario,
            'unidad_medida' => $this->unidad_medida,
            'tipo_de_material_id' => $this->tipo_de_material_id,
            'tipo_de_material' => $this->whenLoaded('tipo_de_material'),
            'alto' => $this->alto,
            'ancho' => $this->ancho,
            'largo' => $this->largo,
        ];
    }
}
