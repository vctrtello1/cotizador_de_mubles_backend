<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrederaPorComponente extends Model
{
    use HasFactory;

    protected $table = 'correderas_por_componente';

    protected $fillable = [
        'componente_id',
        'corredera_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function corredera()
    {
        return $this->belongsTo(Corredera::class);
    }
}
