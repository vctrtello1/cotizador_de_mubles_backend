<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiraLedResource extends JsonResource
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
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'precio_unitario' => $this->when($canViewDetailedPrices, $this->precio_unitario),
            'unidades_por_metro' => $this->when($canViewDetailedPrices, $this->unidades_por_metro),
            'porcentaje_utilizacion' => $this->when($canViewDetailedPrices, $this->porcentaje_utilizacion),
            'cantidad_compra' => $this->when($canViewDetailedPrices, $this->cantidad_compra),
        ];
    }
}
