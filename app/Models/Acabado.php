<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acabado extends Model
{
    /** @use HasFactory<\Database\Factories\AcabadoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
    ];

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }
}
