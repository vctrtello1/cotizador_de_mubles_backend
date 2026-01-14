<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasDeManoDeObraPorComponente extends Model
{
    use HasFactory;

    protected $table = 'horas_de_mano_de_obra_por_componente';

    protected $fillable = [
        'componente_id',
        'mano_de_obra_id',
        'horas',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function manoDeObra()
    {
        return $this->belongsTo(ManoDeObra::class, 'mano_de_obra_id');
    }
}
