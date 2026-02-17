<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corredera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'capacidad_carga',
        'precio_base',
        'precio_con_acoplamiento',
    ];
}
