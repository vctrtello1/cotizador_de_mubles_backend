<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcabadoCubreCantoPorComponente extends Model
{
    use HasFactory;

    protected $table = 'acabado_cubre_canto_por_componente';

    protected $fillable = [
        'componente_id',
        'acabado_cubre_canto_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function acabadoCubreCanto()
    {
        return $this->belongsTo(AcabadoCubreCanto::class, 'acabado_cubre_canto_id');
    }
}
