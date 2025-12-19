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
            'acabado_id' => new AcabadoResource($this->whenLoaded('acabado')),
            'mano_de_obra_id' => new ManoDeObraResource($this->whenLoaded('mano_de_obra')),
        ];
    }
}
