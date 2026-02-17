<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corredera extends Model
{
    protected $fillable = [
        'nombre',
        'precio_base',
        'precio_con_acoplamiento',
    ];
}
