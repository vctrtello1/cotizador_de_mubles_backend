<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiraLed extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'precio_unitario',
        'unidades_por_metro',
        'porcentaje_utilizacion',
        'cantidad_compra',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'porcentaje_utilizacion' => 'decimal:3',
    ];
}
