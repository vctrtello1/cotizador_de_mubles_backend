<?php

namespace App\Models;

use App\Http\Resources\ModulosResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseResource(ModulosResource::class)]
class Modulos extends Model
{
    /** @use HasFactory<\Database\Factories\ModulosFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
    ];

    public function componentes()
    {
        return $this->belongsToMany(componente::class, 'cantidad_por_componente', 'modulo_id', 'componente_id')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function getCostoTotalAttribute()
    {
        return $this->componentes->sum(function ($componente) {
            return $componente->costo_total * $componente->pivot->cantidad;
        });
    }
}
