<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcabadoCubreCantoResource extends JsonResource
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
            'costo_unitario' => $this->when($canViewDetailedPrices, $this->costo_unitario),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
