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
            $table->foreignId('mano_de_obra_id')->constrained();
            $table->timestamps();
        });

        DB::table('componentes')->insert([
            [
                'nombre' => 'Silla Lucianica',
                'descripcion' => 'Silla Lucianica de Roble',
                'codigo' => 'COMP_SILLA_LUCIANICA',
                'mano_de_obra_id' => 1,
            ],
            [
                'nombre' => 'Mesa Lucianica',
                'descripcion' => 'Mesa Lucianica de Roble',
                'codigo' => 'COMP_MESA_LUCIANICA',
                'mano_de_obra_id' => 2,
            ],
            [
                'nombre' => 'Estante Moderno',
                'descripcion' => 'Estante Moderno de MDF',
                'codigo' => 'COMP_ESTANTE_MODERNO',
                'mano_de_obra_id' => 3,
            ],


            // Mesa de centro materiales
            [
                'nombre' => 'Mesa de Centro Purru',
                'descripcion' => 'Mesa de centro minimalista con estructura metálica y superficie de vidrio templado',
                'codigo' => 'COMP_MESA_CENTRO_MINIMALISTA',
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
