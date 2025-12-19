<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'cotizacion_id',
        'modulo_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo_id');
    }
}
