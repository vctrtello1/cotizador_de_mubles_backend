<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    /** @use HasFactory<\Database\Factories\ComponenteFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'accesorios',
        'acabado_id',
        'mano_de_obra_id',
    ];

    public function acabado()
    {
        return $this->belongsTo(Acabado::class);
    }

    public function mano_de_obra()
    {
        return $this->belongsTo(ManoDeObra::class);
    }

    public function accesorios_por_componente()
    {
        return $this->hasMany(AccesoriosPorComponente::class);
    }
}
