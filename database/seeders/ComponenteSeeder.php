<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $componentes = [
            ['nombre' => 'Silla Lucianica', 'descripcion' => 'Silla Lucianica de Roble', 'codigo' => 'COMP_SILLA_LUCIANICA', 'precio_unitario' => 1299.00],
            ['nombre' => 'Mesa Lucianica', 'descripcion' => 'Mesa Lucianica de Roble', 'codigo' => 'COMP_MESA_LUCIANICA', 'precio_unitario' => 2399.00],
            ['nombre' => 'Estante Moderno', 'descripcion' => 'Estante Moderno de MDF', 'codigo' => 'COMP_ESTANTE_MODERNO', 'precio_unitario' => 999.00],
            ['nombre' => 'Mesa de Centro Purru', 'descripcion' => 'Mesa de centro minimalista con estructura metálica y superficie de vidrio templado', 'codigo' => 'COMP_MESA_CENTRO_MINIMALISTA', 'precio_unitario' => 1799.00],
        ];

        DB::table('componentes')->upsert($componentes, ['codigo'], ['nombre', 'descripcion', 'precio_unitario']);
    }
}
