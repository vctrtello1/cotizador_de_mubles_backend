<?php

namespace App\Models;

use App\Http\Resources\ModulosResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseResource(ModulosResource::class)]
class modulos extends Model
{
    /** @use HasFactory<\Database\Factories\ModulosFactory> */
    use HasFactory;
}
