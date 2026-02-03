<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estructura extends Model
{
    /** @use HasFactory<\Database\Factories\EstructuraFactory> */
    use HasFactory;

    protected $table = 'estructura';

    protected $fillable = [
        'nombre',
        'costo_unitario',
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:2',
    ];
}
