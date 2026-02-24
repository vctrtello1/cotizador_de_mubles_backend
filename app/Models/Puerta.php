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
        'precio_final',
        'alto_maximo',
        'ancho_maximo',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $puerta): void {
            $puerta->precio_final = round(
                (float) $puerta->precio_perfil_aluminio
                + (float) $puerta->precio_escuadras
                + (float) $puerta->precio_silicon
                + (float) $puerta->precio_cristal_m2,
                2
            );
        });
    }
}
