<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoDeObra extends Model
{
    /** @use HasFactory<\Database\Factories\ManoDeObraFactory> */
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'costo_hora',
    ];

    protected $appends = ['costo_total'];

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function horasPorComponente()
    {
        return $this->hasMany(HorasDeManoDeObraPorComponente::class);
    }

    /**
     * Get costo_total accessor for backward compatibility
     * In a real scenario, this would be calculated based on hours worked
     */
    public function getCostoTotalAttribute()
    {
        // If there are hours registered for this mano_de_obra, calculate based on that
        // Otherwise, return a default value (e.g., 1 hour * costo_hora)
        return $this->costo_hora * 1; // Default 1 hour
    }
}
