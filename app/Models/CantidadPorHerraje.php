<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CantidadPorHerraje extends Model
{
    use HasFactory;

    protected $table = 'cantidad_por_herraje';

    protected $fillable = [
        'componente_id',
        'herraje_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function herraje()
    {
        return $this->belongsTo(Herraje::class);
    }
}
