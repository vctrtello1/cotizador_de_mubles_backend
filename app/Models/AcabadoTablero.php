<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcabadoTablero extends Model
{
    /** @use HasFactory<\Database\Factories\AcabadoTableroFactory> */
    use HasFactory;

    protected $table = 'acabado_tableros';

    protected $fillable = [
        'nombre',
        'costo_unitario',
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:2',
    ];
}
