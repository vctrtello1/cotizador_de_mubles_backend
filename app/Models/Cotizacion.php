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

    public function getTotalAttribute($value)
    {
        // If details are loaded, calculate from details
        if ($this->relationLoaded('detalles')) {
            if ($this->detalles->isNotEmpty()) {
                return $this->detalles->sum(function ($detalle) {
                    return $detalle->cantidad * $detalle->precio_unitario;
                });
            }
            return $value;
        }

        // Fallback: Calculate from DB if not loaded
        $calculated = $this->detalles()->sum(DB::raw('cantidad * precio_unitario'));
        return $calculated > 0 ? $calculated : $value;
    }
}
