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
        'estado',
    ];

    protected $attributes = [
        'estado' => 'activa',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCotizacion::class);
    }

    // Método para calcular el total (no accessor) 
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

        // Fallback: return the total from the database
        return $this->total ?? 0;
    }
}

           