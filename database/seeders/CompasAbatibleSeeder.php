<?php

namespace Database\Seeders;

use App\Models\CompasAbatible;
use Illuminate\Database\Seeder;

class CompasAbatibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compases = [
            [
                'nombre' => 'AVENTOS HK-XS',
                'precio' => 3775.80,
            ],
            [
                'nombre' => 'AVENTOS HK-S',
                'precio' => 1087.50,
            ],
            [
                'nombre' => 'AVENTOS HK-TOP',
                'precio' => 2271.89,
            ],
            [
                'nombre' => 'AVENTOS HL-TOP',
                'precio' => 4314.20,
            ],
            [
                'nombre' => 'AVENTOS HF-TOP',
                'precio' => 3925.30,
            ],
        ];

        foreach ($compases as $compas) {
            CompasAbatible::create($compas);
        }
    }
}
