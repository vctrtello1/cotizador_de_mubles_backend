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
            $table->string('materiales');
            $table->string('herrajes');
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
                'materiales' => '1,2|',
                'herrajes' => '1|',
                'accesorios' => 'Mantel antideslizante|',
                'acabado_id' => 1,
                'mano_de_obra_id' => 1,
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
