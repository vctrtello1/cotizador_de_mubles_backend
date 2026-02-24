<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuertasPorComponente extends Model
{
    use HasFactory;

    protected $table = 'puertas_por_componente';

    protected $fillable = [
        'componente_id',
        'puerta_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function puerta()
    {
        return $this->belongsTo(Puerta::class);
    }
}
