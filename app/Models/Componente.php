<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    /** @use HasFactory<\Database\Factories\ComponenteFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'accesorios',
        'mano_de_obra_id',
    ];

    public function mano_de_obra()
    {
        return $this->belongsTo(ManoDeObra::class);
    }

    public function accesorios_por_componente()
    {
        return $this->hasMany(AccesoriosPorComponente::class);
    }

    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'materiales_por_componente')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function herrajes()
    {
        return $this->belongsToMany(Herraje::class, 'cantidad_por_herraje')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function getCostoTotalAttribute()
    {
        $costoMateriales = $this->materiales->sum(function ($material) {
            return $material->precio_unitario * $material->pivot->cantidad;
        });

        $costoHerrajes = $this->herrajes->sum(function ($herraje) {
            return $herraje->costo_unitario * $herraje->pivot->cantidad;
        });

        $costoManoDeObra = $this->mano_de_obra ? $this->mano_de_obra->costo_total : 0;

        return $costoMateriales + $costoHerrajes + $costoManoDeObra;
    }
}
