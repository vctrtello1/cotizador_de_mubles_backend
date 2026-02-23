<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcabadoTableroPorComponenteResource extends JsonResource
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
            'acabado_tablero_id' => $this->acabado_tablero_id,
            'acabado_tablero_nombre' => $this->acabado_tablero_nombre,
            'cantidad' => $this->cantidad,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
