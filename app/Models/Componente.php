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

    public function getCostoTotalAttribute()
    {
        return 0;
    }
}
