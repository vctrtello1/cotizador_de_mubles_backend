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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        DB::table('cotizaciones')->insert([
            [
                'cliente_id' => 1,
                'fecha' => '2025-12-19',
                'total' => 1500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 2,
                'fecha' => '2025-12-18',
                'total' => 2500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'cliente_id' => 3,
                'fecha' => '2025-12-17',
                'total' => 3500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'cliente_id' => 1,
                'fecha' => '2025-12-16',
                'total' => 4500.00,
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
        Schema::dropIfExists('cotizaciones');
    }
};
