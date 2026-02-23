<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstructuraPorComponente extends Model
{
    use HasFactory;

    protected $table = 'estructura_por_componente';

    protected $fillable = [
        'componente_id',
        'estructura_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function estructura()
    {
        return $this->belongsTo(Estructura::class);
    }
}
