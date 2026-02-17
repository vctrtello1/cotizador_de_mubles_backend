<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompasAbatible extends Model
{
    use HasFactory;

    protected $table = 'compases_abatibles';

    protected $fillable = [
        'nombre',
        'precio',
    ];
}
