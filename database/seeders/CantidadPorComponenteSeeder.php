<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CantidadPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['modulo_id' => 1, 'componente_id' => 1, 'cantidad' => 4],
            ['modulo_id' => 1, 'componente_id' => 2, 'cantidad' => 1],
            ['modulo_id' => 1, 'componente_id' => 3, 'cantidad' => 1],
            ['modulo_id' => 2, 'componente_id' => 4, 'cantidad' => 4],
            ['modulo_id' => 2, 'componente_id' => 1, 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('cantidad_por_componente')->updateOrInsert(
                [
                    'modulo_id' => $item['modulo_id'],
                    'componente_id' => $item['componente_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
