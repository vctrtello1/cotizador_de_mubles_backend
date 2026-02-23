<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablerosPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'tablero_id' => 1, 'cantidad' => 2],
            ['componente_id' => 1, 'tablero_id' => 3, 'cantidad' => 1],
            ['componente_id' => 2, 'tablero_id' => 2, 'cantidad' => 4],
            ['componente_id' => 3, 'tablero_id' => 5, 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('tableros_por_componente')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'tablero_id' => $item['tablero_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
