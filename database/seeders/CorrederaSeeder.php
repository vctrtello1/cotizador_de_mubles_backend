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
            // TANDEM PARCIAL BLUMOTION 30KG
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 350mm 550H3500B',
                'capacidad_carga' => 30,
                'tipo' => 'PARCIAL',
                'incluye_varilla' => false,
                'precio_base' => 344.40,
                'precio_con_acoplamiento' => 394.60
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 400mm 550H4000B',
                'capacidad_carga' => 30,
                'tipo' => 'PARCIAL',
                'incluye_varilla' => false,
                'precio_base' => 350.20,
                'precio_con_acoplamiento' => 400.40
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 450mm 550H4500B',
                'capacidad_carga' => 30,
                'tipo' => 'PARCIAL',
                'incluye_varilla' => false,
                'precio_base' => 354.90,
                'precio_con_acoplamiento' => 405.10
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 500mm 550H5000B',
                'capacidad_carga' => 30,
                'tipo' => 'PARCIAL',
                'incluye_varilla' => false,
                'precio_base' => 359.90,
                'precio_con_acoplamiento' => 410.10
            ],
            [
                'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 550mm 550H5500B',
                'capacidad_carga' => 30,
                'tipo' => 'PARCIAL',
                'incluye_varilla' => false,
                'precio_base' => 400.40,
                'precio_con_acoplamiento' => 450.60
            ],
            
            // TANDEM TOTAL BLUMOTION 30KG
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 270mm 560H2700B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 662.80,
                'precio_con_acoplamiento' => 713.00
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 300mm 560H3000B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 662.80,
                'precio_con_acoplamiento' => 713.00
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 350mm 560H3500B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 662.80,
                'precio_con_acoplamiento' => 713.00
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 400mm 560H4000B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 671.40,
                'precio_con_acoplamiento' => 721.60
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 450mm 560H4500B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 680.10,
                'precio_con_acoplamiento' => 730.30
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 500mm 560H5000B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 688.80,
                'precio_con_acoplamiento' => 739.00
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 550mm 560H5500B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 721.60,
                'precio_con_acoplamiento' => 771.80
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL BLUMOTION 30kgs 600mm 560H6000B',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 822.41,
                'precio_con_acoplamiento' => 872.61
            ],
            
            // TANDEM TOTAL TIP-ON BLUMOTION 30KG (incluye varilla de sincronización)
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 250mm 560H2500T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 719.70,
                'precio_con_acoplamiento' => 898.20
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 300mm 560H3000T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 719.70,
                'precio_con_acoplamiento' => 898.20
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 350mm 560H3500T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 719.70,
                'precio_con_acoplamiento' => 898.20
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 400mm 560H4000T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 728.40,
                'precio_con_acoplamiento' => 906.90
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 450mm 560H4500T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 736.99,
                'precio_con_acoplamiento' => 915.49
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 500mm 560H5000T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 745.69,
                'precio_con_acoplamiento' => 924.19
            ],
            [
                'nombre' => 'CORREDERA TANDEM TOTAL TIP-ON 30kgs 550mm 560H5500T',
                'capacidad_carga' => 30,
                'tipo' => 'TOTAL_TIP_ON',
                'incluye_varilla' => true,
                'precio_base' => 778.50,
                'precio_con_acoplamiento' => 957.00
            ],
            
            // MOVENTO BLUMOTION TOTAL 40KG
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 300mm 760H3000S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 793.90,
                'precio_con_acoplamiento' => 888.50
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 350mm 760H3500S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 793.90,
                'precio_con_acoplamiento' => 888.50
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 400mm 760H4000S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 802.60,
                'precio_con_acoplamiento' => 897.20
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 450mm 760H4500S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 812.30,
                'precio_con_acoplamiento' => 906.90
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 500mm 760H5000S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 821.25,
                'precio_con_acoplamiento' => 915.85
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 550mm 760H5500S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 869.30,
                'precio_con_acoplamiento' => 963.90
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 40kgs 600mm 760H6000S',
                'capacidad_carga' => 40,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 982.10,
                'precio_con_acoplamiento' => 1076.70
            ],
            
            // MOVENTO BLUMOTION TOTAL 70KG
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 500mm 766H5000S',
                'capacidad_carga' => 70,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 1095.90,
                'precio_con_acoplamiento' => 1190.50
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 550mm 766H5500S',
                'capacidad_carga' => 70,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 1149.90,
                'precio_con_acoplamiento' => 1244.50
            ],
            [
                'nombre' => 'CORREDERA MOVENTO BLUMOTION TOTAL 70kgs 650mm 766H6500S',
                'capacidad_carga' => 70,
                'tipo' => 'TOTAL',
                'incluye_varilla' => false,
                'precio_base' => 1311.00,
                'precio_con_acoplamiento' => 1405.60
            ],
        ];

        foreach ($correderas as $corredera) {
            Corredera::create($corredera);
        }
    }
}
