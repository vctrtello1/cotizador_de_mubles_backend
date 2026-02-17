<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gola extends Model
{
    use HasFactory;

    protected $table = 'table_gola';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];
}
