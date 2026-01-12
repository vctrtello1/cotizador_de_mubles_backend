<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cantidad_por_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id')->constrained('componentes');
            $table->foreignId('material_id')->constrained('materiales');
            $table->integer('cantidad');
            $table->timestamps();
        });

        DB::table('cantidad_por_material')->insert([


            // Silla Lucianica
            [
                'material_id' => 1,
                'cantidad' => 2,
                'componente_id' => 1,
            ],
            [
                'material_id' => 2,
                'cantidad' => 3,
                'componente_id' => 1,
            ],
            [
                'material_id' => 1,
                'cantidad' => 4,
                'componente_id' => 1,
            ],
            [
                'material_id' => 2,
                'cantidad' => 1,
                'componente_id' => 1,
            ],
            [
                'material_id' => 5,
                'cantidad' => 1,
                'componente_id' => 1,
            ],
            [
                'material_id' => 4,
                'cantidad' => 1,
                'componente_id' => 1,
            ],

            // Mesa Lucianica
            [
                'material_id' => 5,
                'cantidad' => 4,
                'componente_id' => 2,
            ],
            [
                'material_id' => 4,
                'cantidad' => 1,
                'componente_id' => 2,
            ],

            // Mesa de centro Purru
            [
                'material_id' => 6,
                'cantidad' => 4,
                'componente_id' => 4,
            ],
            [
                'material_id' => 7,
                'cantidad' => 1,
                'componente_id' => 4,
            ],

            // Repisa Purru
            [
                'material_id' => 3,
                'cantidad' => 1,
                'componente_id' => 3,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cantidad_por_material');
    }
};
