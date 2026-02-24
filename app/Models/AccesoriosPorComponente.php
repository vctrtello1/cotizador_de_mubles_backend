<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccesoriosPorComponente extends Model
{
    use HasFactory;

    protected $table = 'accesorios_por_componente';

    protected $fillable = [
        'componente_id',
        'accesorio',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}
