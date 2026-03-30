<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionesPorUsuario extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones_por_usuario';

    protected $fillable = [
        'user_id',
        'cotizacion_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
}
