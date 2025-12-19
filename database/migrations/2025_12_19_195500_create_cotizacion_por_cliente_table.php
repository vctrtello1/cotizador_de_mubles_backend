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
        Schema::create('cotizacion_por_cliente', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->unique(['cliente_id', 'cotizacion_id']);
        });

        DB::table('cotizacion_por_cliente')->insert([
            [
                'cliente_id' => 1,
                'cotizacion_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        [
            'cliente_id' => 2,
            'cotizacion_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'cliente_id' => 3,
            'cotizacion_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'cliente_id' => 1,
            'cotizacion_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'cliente_id' => 3,
            'cotizacion_id' => 5,
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
        Schema::dropIfExists('cotizacion_por_cliente');
    }
};
