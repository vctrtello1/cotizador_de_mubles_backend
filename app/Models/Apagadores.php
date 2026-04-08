<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apagadores extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'unidades_por_metro',
        'porcentaje_utilizacion',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'unidades_por_metro' => 'integer',
        'porcentaje_utilizacion' => 'decimal:2',
    ];
}
