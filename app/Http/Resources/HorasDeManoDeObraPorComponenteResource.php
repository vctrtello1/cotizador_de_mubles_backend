<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HorasDeManoDeObraPorComponenteResource extends JsonResource
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
            'mano_de_obra_id' => $this->mano_de_obra_id,
            'horas' => $this->horas,
            'componente' => new ComponenteResource($this->whenLoaded('componente')),
            'mano_de_obra' => new ManoDeObraResource($this->whenLoaded('manoDeObra')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
