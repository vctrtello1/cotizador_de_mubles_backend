<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcabadoTableroPorComponente extends Model
{
    use HasFactory;

    protected $table = 'acabado_tablero_por_componente';

    protected $fillable = [
        'componente_id',
        'acabado_tablero_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function acabadoTablero()
    {
        return $this->belongsTo(AcabadoTablero::class, 'acabado_tablero_id');
    }
}
