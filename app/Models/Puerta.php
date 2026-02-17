<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puerta extends Model
{
    use HasFactory;

    protected $table = 'puertas';

    protected $fillable = [
        'nombre',
        'precio_perfil_aluminio',
        'precio_escuadras',
        'precio_silicon',
        'precio_cristal_m2',
        'alto_maximo',
        'ancho_maximo',
    ];
}
