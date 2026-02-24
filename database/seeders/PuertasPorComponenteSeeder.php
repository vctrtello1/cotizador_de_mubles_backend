<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuertasPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $componentes = DB::table('componentes')->pluck('id')->values();
        $puertas = DB::table('puertas')->pluck('id')->values();

        if ($componentes->isEmpty() || $puertas->isEmpty()) {
            return;
        }

        $puertaId = $puertas->first();
        $items = [
            ['componente_id' => $componentes->get(0), 'puerta_id' => $puertaId, 'cantidad' => 2],
            ['componente_id' => $componentes->get(1, $componentes->get(0)), 'puerta_id' => $puertaId, 'cantidad' => 1],
            ['componente_id' => $componentes->get(2, $componentes->get(0)), 'puerta_id' => $puertaId, 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('puertas_por_componente')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'puerta_id' => $item['puerta_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
