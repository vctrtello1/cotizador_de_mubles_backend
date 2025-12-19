<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'empresa',
        'notas',
    ];

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
