<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolaPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $componentes = DB::table('componentes')->pluck('id')->values();
        $golas = DB::table('table_gola')->pluck('id')->values();

        if ($componentes->isEmpty() || $golas->isEmpty()) {
            return;
        }

        $golaId = $golas->first();
        $items = [
            ['componente_id' => $componentes->get(0), 'gola_id' => $golaId, 'cantidad' => 2],
            ['componente_id' => $componentes->get(1, $componentes->get(0)), 'gola_id' => $golaId, 'cantidad' => 1],
            ['componente_id' => $componentes->get(2, $componentes->get(0)), 'gola_id' => $golaId, 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('gola_por_componente')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'gola_id' => $item['gola_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
