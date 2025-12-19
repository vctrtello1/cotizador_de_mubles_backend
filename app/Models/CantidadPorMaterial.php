<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CantidadPorMaterial extends Model
{
    use HasFactory;

    protected $table = 'cantidad_por_material';

    protected $fillable = [
        'componente_id',
        'material_id',
        'cantidad',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}
