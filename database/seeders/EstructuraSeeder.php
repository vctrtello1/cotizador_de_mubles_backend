<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstructuraSeeder extends Seeder
{
    public function run(): void
    {
        $estructuras = [
            ['nombre' => 'BCO FROSTY'],
            ['nombre' => 'ARAURCO LINO CAIRO'],
        ];

        foreach ($estructuras as $estructura) {
            DB::table('estructura')->updateOrInsert(['nombre' => $estructura['nombre']], $estructura);
        }
    }
}
