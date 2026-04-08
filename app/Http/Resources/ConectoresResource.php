<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConectoresResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $canViewDetailedPrices = ! $request->user() || $request->user()->hasPermission('catalogs.write');

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->when($canViewDetailedPrices, $this->precio),
            'unidades_por_metro' => $this->unidades_por_metro,
            'porcentaje_utilizacion' => $this->porcentaje_utilizacion,
        ];
    }
}
