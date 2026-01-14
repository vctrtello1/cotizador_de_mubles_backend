<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CantidadPorComponente extends Model
{
    use HasFactory;

    protected $table = 'cantidad_por_componentes';

    protected $fillable = [
        'componente_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}
