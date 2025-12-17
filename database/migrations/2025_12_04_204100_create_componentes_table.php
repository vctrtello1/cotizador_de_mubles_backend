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
            $table->string('cantidad_por_material');
            $table->string('herrajes');
            $table->string('cantidad_por_herraje');
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
                'cantidad_por_material' => '2,3|',
                'herrajes' => '1|',
                'cantidad_por_herraje' => '4|1|',
                'accesorios' => 'Mantel antideslizante|',
                'acabado_id' => 1,
                'mano_de_obra_id' => 1,
            ],
        ]);

        DB::table('componentes')->insert([
            [
                'nombre' => 'Mesa Lucianica',
                'descripcion' => 'Mesa Lucianica de Roble con acabados de alta calidad',
                'codigo' => 'COMP_MESA_LUCIANICA',
                'materiales' => '3,4|',
                'cantidad_por_material' => '1.5,2|',
                'herrajes' => '2|',
                'cantidad_por_herraje' => '8|1|',
                'accesorios' => 'Protector de esquinas|',
                'acabado_id' => 1,
                'mano_de_obra_id' => 2,
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
