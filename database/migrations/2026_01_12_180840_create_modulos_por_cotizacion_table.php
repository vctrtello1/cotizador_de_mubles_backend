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
        Schema::create('modulos_por_cotizacion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('modulo_id')->constrained('modulos')->onDelete('cascade');
            $table->integer('cantidad');
        });


        DB::table('modulos_por_cotizacion')->insert([
            [
                'cotizacion_id' => 1,
                'modulo_id' => 1,
                'cantidad' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 2,
                'modulo_id' => 2,
                'cantidad' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 3,
                'modulo_id' => 1,
                'cantidad' => 2,
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
        Schema::dropIfExists('modulos_por_cotizacion');
    }
};
