<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesorioResource extends JsonResource
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
        ];
    }
}
