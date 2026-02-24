<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolaPorComponente extends Model
{
    use HasFactory;

    protected $table = 'gola_por_componente';

    protected $fillable = [
        'componente_id',
        'gola_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function gola()
    {
        return $this->belongsTo(Gola::class);
    }
}
