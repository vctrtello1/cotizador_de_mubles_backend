<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PuertaResource extends JsonResource
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
            'precio_perfil_aluminio' => $this->precio_perfil_aluminio,
            'precio_escuadras' => $this->precio_escuadras,
            'precio_silicon' => $this->precio_silicon,
            'precio_cristal_m2' => $this->precio_cristal_m2,
            'precio_final' => $this->precio_final,
            'alto_maximo' => $this->alto_maximo,
            'ancho_maximo' => $this->ancho_maximo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
