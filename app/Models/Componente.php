<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    /** @use HasFactory<\Database\Factories\ComponenteFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'accesorios',
    ];

    public function accesorios_por_componente()
    {
        return $this->hasMany(AccesoriosPorComponente::class);
    }

    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'materiales_por_componente')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function getCostoTotalAttribute()
    {
        $costoMateriales = $this->materiales->sum(function ($material) {
            return $material->precio_unitario * $material->pivot->cantidad;
        });

        return $costoMateriales;
    }
}
