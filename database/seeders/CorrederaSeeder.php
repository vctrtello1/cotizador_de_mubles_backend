<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Corredera;

class CorrederaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $correderas = [
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 350mm 550H3500B',
                'precio_base' => 344.40,
                'precio_con_acoplamiento' => 394.60
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 400mm 550H4000B',
                'precio_base' => 350.20,
                'precio_con_acoplamiento' => 400.40
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 450mm 550H4500B',
                'precio_base' => 354.90,
                'precio_con_acoplamiento' => 405.10
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 500mm 550H5000B',
                'precio_base' => 359.90,
                'precio_con_acoplamiento' => 410.10
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 550mm 550H5500B',
                'precio_base' => 400.40,
                'precio_con_acoplamiento' => 450.60
            ],
        ];

        foreach ($correderas as $corredera) {
            Corredera::create($corredera);
        }
    }
}
