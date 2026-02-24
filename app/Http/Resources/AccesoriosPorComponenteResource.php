<?php

namespace App\Http\Resources;

use App\Models\Accesorio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccesoriosPorComponenteResource extends JsonResource
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
            'accesorio' => $this->accesorio,
            'costo' => $this->costoAccesorio(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function costoAccesorio(): ?string
    {
        $precio = Accesorio::query()
            ->where('nombre', $this->accesorio)
            ->value('precio');

        return $precio === null ? null : number_format((float) $precio, 2, '.', '');
    }
}
