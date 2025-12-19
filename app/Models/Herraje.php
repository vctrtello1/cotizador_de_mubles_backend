<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herraje extends Model
{
    /** @use HasFactory<\Database\Factories\HerrajeFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'medida',
        'unidad_medida',
        'codigo',
        'costo_unitario',
    ];
}
