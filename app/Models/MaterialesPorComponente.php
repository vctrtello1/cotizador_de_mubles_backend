<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialesPorComponente extends Model
{
    use HasFactory;

    protected $table = 'materiales_por_componente';

    protected $fillable = [
        'componente_id',
        'material_id',
        'cantidad',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
