<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilAluminio extends Model
{
    /** @use HasFactory<\Database\Factories\PerfilAluminioFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'porcentaje_utilizacion',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'porcentaje_utilizacion' => 'decimal:2',
    ];
}
