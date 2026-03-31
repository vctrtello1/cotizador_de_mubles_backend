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

    public function correderas_por_componente()
    {
        return $this->hasMany(CorrederaPorComponente::class);
    }

    public function compases_abatibles_por_componente()
    {
        return $this->hasMany(CompasAbatiblePorComponente::class);
    }

    public function getCostoTotalAttribute()
    {
        $total = 0;

        // Estructuras
        foreach ($this->estructuras_por_componente as $rel) {
            $total += ($rel->estructura->costo_unitario ?? 0) * $rel->cantidad;
        }

        // Acabado tablero
        foreach ($this->acabado_tablero_por_componente as $rel) {
            $total += ($rel->acabadoTablero->costo_unitario ?? 0) * $rel->cantidad;
        }

        // Acabado cubre canto
        foreach ($this->acabado_cubre_canto_por_componente as $rel) {
            $total += ($rel->acabadoCubreCanto->costo_unitario ?? 0) * $rel->cantidad;
        }

        // Puertas
        foreach ($this->puertas_por_componente as $rel) {
            $total += ($rel->puerta->precio_final ?? 0) * $rel->cantidad;
        }

        // Gola
        foreach ($this->gola_por_componente as $rel) {
            $total += ($rel->gola->precio ?? 0) * $rel->cantidad;
        }

        // Accesorios (lookup by nombre)
        foreach ($this->accesorios_por_componente as $rel) {
            $precio = Accesorio::where('nombre', $rel->accesorio)->value('precio') ?? 0;
            $total += $precio * $rel->cantidad;
        }

        // Correderas
        foreach ($this->correderas_por_componente as $rel) {
            $total += ($rel->corredera->precio_base ?? 0) * $rel->cantidad;
        }

        // Compases abatibles
        foreach ($this->compases_abatibles_por_componente as $rel) {
            $total += ($rel->compasAbatible->precio ?? 0) * $rel->cantidad;
        }

        return round($total, 2);
    }
}
