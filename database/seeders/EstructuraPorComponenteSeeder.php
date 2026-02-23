<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstructuraPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'estructura_id' => 1, 'cantidad' => 1],
            ['componente_id' => 1, 'estructura_id' => 2, 'cantidad' => 2],
            ['componente_id' => 2, 'estructura_id' => 2, 'cantidad' => 1],
            ['componente_id' => 3, 'estructura_id' => 1, 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('estructura_por_componente')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'estructura_id' => $item['estructura_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
