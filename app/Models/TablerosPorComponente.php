<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablerosPorComponente extends Model
{
    use HasFactory;

    protected $table = 'tableros_por_componente';

    protected $fillable = [
        'componente_id',
        'tablero_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function tablero()
    {
        return $this->belongsTo(Material::class, 'tablero_id');
    }
}
