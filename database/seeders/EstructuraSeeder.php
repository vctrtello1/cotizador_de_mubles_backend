<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstructuraSeeder extends Seeder
{
    public function run(): void
    {
        $estructuras = [
            ['nombre' => 'BCO FROSTY', 'costo_unitario' => 800.00],
            ['nombre' => 'ARAURCO LINO CAIRO', 'costo_unitario' => 1200.00],
        ];

        foreach ($estructuras as $estructura) {
            DB::table('estructura')->updateOrInsert(['nombre' => $estructura['nombre']], $estructura);
        }
    }
}
