<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompasAbatiblePorComponente extends Model
{
    use HasFactory;

    protected $table = 'compases_abatibles_por_componente';

    protected $fillable = [
        'componente_id',
        'compas_abatible_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function compasAbatible()
    {
        return $this->belongsTo(CompasAbatible::class);
    }
}
