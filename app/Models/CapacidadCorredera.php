<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacidadCorredera extends Model
{
    use HasFactory;
    
    protected $table = 'capacidad_correderas';
    
    protected $fillable = [
        'capacidad',
        'corredera_id',
    ];

    /**
     * Relación con el modelo Corredera
     */
    public function corredera()
    {
        return $this->belongsTo(Corredera::class);
    }
}
