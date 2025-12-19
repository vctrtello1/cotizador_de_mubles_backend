<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $table = 'materiales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'precio_unitario',
        'unidad_medida',
        'tipo_de_material_id',
        'alto',
        'ancho',
        'largo',
    ];

    public function tipo_de_material()
    {
        return $this->belongsTo(TipoDeMaterial::class, 'tipo_de_material_id');
    }
}
