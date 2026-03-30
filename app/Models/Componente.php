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
        'precio_unitario',
        'accesorios',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
    ];

    public function accesorios_por_componente()
    {
        return $this->hasMany(AccesoriosPorComponente::class);
    }

    public function estructuras_por_componente()
    {
        return $this->hasMany(EstructuraPorComponente::class);
    }

    public function acabado_tablero_por_componente()
    {
        return $this->hasMany(AcabadoTableroPorComponente::class);
    }

    public function acabado_cubre_canto_por_componente()
    {
        return $this->hasMany(AcabadoCubreCantoPorComponente::class);
    }

    public function puertas_por_componente()
    {
        return $this->hasMany(PuertasPorComponente::class);
    }

    public function gola_por_componente()
    {
        return $this->hasMany(GolaPorComponente::class);
    }

    public function getCostoTotalAttribute()
    {
        return (float) ($this->precio_unitario ?? 0);
    }
}
