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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('codigo')->unique();
            $table->float('precio_unitario');
            $table->string('unidad_medida');
            $table->foreignId('tipo_de_material_id')->constrained('table_tipo_de_material');
            $table->float('alto');
            $table->float('ancho');
            $table->float('largo');
            $table->timestamps();
        });

        // Silla Lucianica Materials

        DB::table('materiales')->insert([
            [
                'nombre' => 'Pata de silla Lucianica',
                'descripcion' => 'Patas de silla de madera de roble maciza con acabado natural',
                'codigo' => 'PAT-LUC-001',
                'precio_unitario' => 15.75,
                'unidad_medida' => 'cm',
                'tipo_de_material_id' => 1, // Madera de roble
                'alto' => 47,
                'ancho' => 2.7,
                'largo' => 2.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('materiales')->insert([
            [
                'nombre' => 'Base de silla Lucianica',
                'descripcion' => 'Base de silla de madera de roble maciza con acabado natural',
                'codigo' => 'TAB-LUC-001',
                'precio_unitario' => 500,
                'unidad_medida' => 'cm',
                'tipo_de_material_id' => 1, // Madera de roble
                'alto' => 2.7,
                'ancho' => 42,
                'largo' => 42,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('materiales')->insert([
            [
                'nombre' => 'Respaldo de silla Lucianica',
                'descripcion' => 'Respaldo de silla de madera de roble maciza con acabado natural',
                'codigo' => 'BCK-LUC-001',
                'precio_unitario' => 200,
                'unidad_medida' => 'cm',
                'tipo_de_material_id' => 1, // Madera de roble
                'alto' => 42,
                'ancho' => 42,
                'largo' => 2.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('materiales')->insert([
            [
                'nombre' => 'Asiento de silla Lucianica',
                'descripcion' => 'Asiento de silla algodon de 500 hilos con espuma de alta densidad',
                'codigo' => 'SEA-LUC-001',
                'precio_unitario' => 250,
                'unidad_medida' => 'cm',
                'tipo_de_material_id' => 5, // Algodón orgánico
                'alto' => 2.7,
                'ancho' => 42,
                'largo' => 42,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Mesa Lucianica Materials
        DB::table('materiales')->insert([
            [
                'nombre' => 'Pata de mesa Lucianica',
                'descripcion' => 'Patas de mesa de madera de roble maciza con acabado natural',
                'codigo' => 'PAT-MES-001',
                'precio_unitario' => 25.50,
                'unidad_medida' => 'cm',
                'tipo_de_material_id' => 1, // Madera de roble
                'alto' => 75,
                'ancho' => 5,
                'largo' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('materiales')->insert([
            [
                'nombre' => 'Tabla de mesa Lucianica',
                'descripcion' => 'Tabla de mesa de madera de roble maciza con acabado natural',
                'codigo' => 'TAB-MES-001',
                'precio_unitario' => 800,
                'unidad_medida' => 'cm',
                'tipo_de_material_id' => 1, // Madera de roble
                'alto' => 4,
                'ancho' => 120,
                'largo' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
