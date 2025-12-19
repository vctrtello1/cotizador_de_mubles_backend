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
        Schema::create('componentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('codigo')->unique();
            $table->string('accesorios')->nullable();
            $table->foreignId('acabado_id')->constrained();
            $table->foreignId('mano_de_obra_id')->constrained();
            $table->timestamps();
        });

        DB::table('componentes')->insert([
            [
                'nombre' => 'Silla Lucianica',
                'descripcion' => 'Silla Lucianica de Roble con acabados de alta calidad',
                'codigo' => 'COMP_SILLA_LUCIANICA',
                'acabado_id' => 1,
                'mano_de_obra_id' => 1,
            ],
        ]);

        DB::table('componentes')->insert([
            [
                'nombre' => 'Mesa Lucianica',
                'descripcion' => 'Mesa Lucianica de Roble con acabados de alta calidad',
                'codigo' => 'COMP_MESA_LUCIANICA',
                'acabado_id' => 1,
                'mano_de_obra_id' => 2,
            ],
        ]);

        DB::table('componentes')->insert([
            [
                'nombre' => 'Estante Moderno',
                'descripcion' => 'Estante Moderno de MDF con acabados elegantes',
                'codigo' => 'COMP_ESTANTE_MODERNO',
                'acabado_id' => 2,
                'mano_de_obra_id' => 3,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('componentes');
    }
};
