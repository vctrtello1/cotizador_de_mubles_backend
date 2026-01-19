<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentesPorCotizacion extends Model
{
    use HasFactory;

    protected $table = 'componentes_por_cotizacion';

    protected $fillable = [
        'cotizacion_id',
        'componente_id',
        'cantidad',
    ];

    /**
     * Get the cotizacion that owns the ComponentesPorCotizacion.
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    /**
     * Get the componente that owns the ComponentesPorCotizacion.
     */
    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    /**
     * Get the subtotal for this component in the quotation.
     */
    public function getSubtotalAttribute()
    {
        if ($this->componente) {
            return $this->cantidad * $this->componente->costo_total;
        }
        return 0;
    }
}
