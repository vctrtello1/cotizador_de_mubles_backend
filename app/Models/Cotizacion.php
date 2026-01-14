<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'cliente_id',
        'fecha',
        'total',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCotizacion::class);
    }

    public function modulosPorCotizacion()
    {
        return $this->belongsToMany(
            Modulos::class,
            'modulos_por_cotizacion',
            'cotizacion_id',
            'modulo_id'
        )->withPivot('cantidad')->withTimestamps();
    }

    public function getTotalAttribute($value)
    {
        // If modules are loaded, calculate from modules and components
        if ($this->relationLoaded('modulosPorCotizacion')) {
            $total = 0;
            foreach ($this->modulosPorCotizacion as $modulo) {
                if ($modulo->relationLoaded('componentes')) {
                    foreach ($modulo->componentes as $componente) {
                        // Calculate component price
                        $precioComponente = 0;
                        if ($componente->relationLoaded('acabado') && $componente->acabado) {
                            $precioComponente += $componente->acabado->costo;
                        }
                        if ($componente->relationLoaded('mano_de_obra') && $componente->mano_de_obra) {
                            $precioComponente += $componente->mano_de_obra->costo_total;
                        }
                        $total += $precioComponente * $componente->pivot->cantidad;
                    }
                }
            }
            if ($total > 0) {
                return $total;
            }
        }

        // If details are loaded, calculate from details
        if ($this->relationLoaded('detalles')) {
            if ($this->detalles->isNotEmpty()) {
                $total = $this->detalles->sum(function ($detalle) {
                    return $detalle->cantidad * $detalle->precio_unitario;
                });
                if ($total > 0) {
                    return $total;
                }
            }
        }

        // Fallback: Calculate from DB if not loaded
        $calculated = $this->detalles()->sum(DB::raw('cantidad * precio_unitario'));
        return $calculated > 0 ? $calculated : $value;
    }

    public function calculateTotal()
    {
        // First, try to calculate from detalles
        if ($this->relationLoaded('detalles') && $this->detalles->isNotEmpty()) {
            return $this->detalles->sum(function ($detalle) {
                return $detalle->cantidad * $detalle->precio_unitario;
            });
        }

        // If not loaded, try to fetch from DB
        $detallesTotal = $this->detalles()->sum(DB::raw('cantidad * precio_unitario'));
        if ($detallesTotal > 0) {
            return $detallesTotal;
        }

        // Load required relations if not already loaded
        if (!$this->relationLoaded('modulosPorCotizacion')) {
            $this->load('modulosPorCotizacion.componentes.acabado', 'modulosPorCotizacion.componentes.mano_de_obra');
        }

        $total = 0;
        if ($this->modulosPorCotizacion->isNotEmpty()) {
            foreach ($this->modulosPorCotizacion as $modulo) {
                foreach ($modulo->componentes as $componente) {
                    $precioComponente = 0;
                    if ($componente->acabado) {
                        $precioComponente += $componente->acabado->costo;
                    }
                    if ($componente->mano_de_obra) {
                        $precioComponente += $componente->mano_de_obra->costo_total;
                    }
                    $total += $precioComponente * $componente->pivot->cantidad;
                }
            }
        }
        
        // If we have a calculated total, return it
        if ($total > 0) {
            return $total;
        }

        // Fallback: return the total from the database
        return $this->total ?? 0;
    }
}
