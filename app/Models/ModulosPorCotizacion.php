<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulosPorCotizacion extends Model
{
    use HasFactory;

    protected $table = 'modulos_por_cotizacion';

    protected $fillable = [
        'cotizacion_id',
        'modulo_id',
        'cantidad',
    ];

    /**
     * Get the cotizacion that owns the ModulosPorCotizacion.
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    /**
     * Get the modulo that owns the ModulosPorCotizacion.
     */
    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo_id');
    }

    /**
     * Get the subtotal for this module in the quotation.
     */
    public function getSubtotalAttribute()
    {
        if ($this->modulo) {
            return $this->cantidad * $this->modulo->costo_total;
        }
        return 0;
    }
}
