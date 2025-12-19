<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoDeObra extends Model
{
    /** @use HasFactory<\Database\Factories\ManoDeObraFactory> */
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'costo_hora',
        'tiempo',
        'costo_total',
    ];

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }
}
