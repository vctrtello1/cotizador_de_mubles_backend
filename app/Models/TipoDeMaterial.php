<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeMaterial extends Model
{
    use HasFactory;

    protected $table = 'tipo_de_material';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
    ];

    public function materiales()
    {
        return $this->hasMany(Material::class, 'tipo_de_material_id');
    }
}
