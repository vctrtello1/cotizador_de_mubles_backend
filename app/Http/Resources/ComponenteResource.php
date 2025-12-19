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
            'accesorios' => AccesoriosPorComponenteResource::collection($this->whenLoaded('accesorios_por_componente')),
            'materiales' => $this->whenLoaded('materiales', function () {
                return $this->materiales->map(function ($material) {
                    return [
                        'id' => $material->id,
                        'nombre' => $material->nombre,
                        'codigo' => $material->codigo,
                        'precio_unitario' => $material->precio_unitario,
                        'unidad_medida' => $material->unidad_medida,
                        'cantidad' => $material->pivot->cantidad,
                    ];
                });
            }),
            'herrajes' => $this->whenLoaded('herrajes', function () {
                return $this->herrajes->map(function ($herraje) {
                    return [
                        'id' => $herraje->id,
                        'nombre' => $herraje->nombre,
                        'codigo' => $herraje->codigo,
                        'precio_unitario' => $herraje->precio_unitario,
                        'unidad_medida' => $herraje->unidad_medida,
                        'cantidad' => $herraje->pivot->cantidad,
                    ];
                });
            }),
            'cantidad' => $this->whenPivotLoaded('cantidad_por_componente', function () {
                return $this->pivot->cantidad;
            }),
            'acabado_id' => new AcabadoResource($this->whenLoaded('acabado')),
            'mano_de_obra_id' => new ManoDeObraResource($this->whenLoaded('mano_de_obra')),
        ];
    }
}
