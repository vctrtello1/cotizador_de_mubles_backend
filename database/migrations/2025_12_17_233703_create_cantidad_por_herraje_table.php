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
        Schema::create('cantidad_por_herraje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id')->constrained('componentes');
            $table->foreignId('herraje_id')->constrained('herrajes');
            $table->integer('cantidad');
            $table->timestamps();
        });

        DB::table('cantidad_por_herraje')->insert([
            // Silla Lucianica
            [
                'herraje_id' => 1,
                'cantidad' => 4,
                'componente_id' => 1,
            ],
            [
                'herraje_id' => 2,
                'cantidad' => 8,
                'componente_id' => 1,
            ],

            // Mesa Lucianica
            [
                'herraje_id' => 3,
                'cantidad' => 6,
                'componente_id' => 2,
            ],
            [
                'herraje_id' => 4,
                'cantidad' => 12,
                'componente_id' => 2,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cantidad_por_herraje');
    }
};
