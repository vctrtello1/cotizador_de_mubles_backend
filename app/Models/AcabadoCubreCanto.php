<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcabadoCubreCanto extends Model
{
    /** @use HasFactory<\Database\Factories\AcabadoCubreCantoFactory> */
    use HasFactory;

    protected $table = 'acabado_cubre_cantos';

    protected $fillable = [
        'nombre',
        'costo_unitario',
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:2',
    ];
}
