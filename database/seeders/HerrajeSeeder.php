<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HerrajeSeeder extends Seeder
{
    public function run(): void
    {
        $herrajes = [
            ['nombre' => 'Tornillo Estándar de 2.5 cm', 'descripcion' => 'Tornillo de alta resistencia para muebles', 'codigo' => 'TOR_ESTANDAR', 'medida' => 2.5, 'unidad_medida' => 'cm', 'costo_unitario' => 15.00],
            ['nombre' => 'Bisagra Oculta', 'descripcion' => 'Bisagra oculta para puertas de gabinetes', 'codigo' => 'BIS_OCULTA', 'medida' => 3.5, 'unidad_medida' => 'cm', 'costo_unitario' => 25.00],
            ['nombre' => 'Manija de Acero', 'descripcion' => 'Manija de acero inoxidable', 'codigo' => 'MAN_ACERO', 'medida' => 10.0, 'unidad_medida' => 'cm', 'costo_unitario' => 45.00],
            ['nombre' => 'Rueda Giratoria', 'descripcion' => 'Rueda giratoria para muebles móviles', 'codigo' => 'RUE_GIRATORIA', 'medida' => 5.0, 'unidad_medida' => 'cm', 'costo_unitario' => 30.00],
        ];

        DB::table('herrajes')->upsert($herrajes, ['codigo'], ['nombre', 'descripcion', 'medida', 'unidad_medida', 'costo_unitario']);
    }
}
