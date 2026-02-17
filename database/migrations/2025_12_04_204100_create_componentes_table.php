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
            $table->timestamps();
        });

        DB::table('componentes')->insert([
            [
                'nombre' => 'Silla Lucianica',
                'descripcion' => 'Silla Lucianica de Roble',
                'codigo' => 'COMP_SILLA_LUCIANICA',
            ],
            [
                'nombre' => 'Mesa Lucianica',
                'descripcion' => 'Mesa Lucianica de Roble',
                'codigo' => 'COMP_MESA_LUCIANICA',
            ],
            [
                'nombre' => 'Estante Moderno',
                'descripcion' => 'Estante Moderno de MDF',
                'codigo' => 'COMP_ESTANTE_MODERNO',
            ],


            // Mesa de centro materiales
            [
                'nombre' => 'Mesa de Centro Purru',
                'descripcion' => 'Mesa de centro minimalista con estructura metálica y superficie de vidrio templado',
                'codigo' => 'COMP_MESA_CENTRO_MINIMALISTA',
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
