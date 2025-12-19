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
            $table->foreignId('modulo_id')->constrained('modulos')->onDelete('cascade');
            $table->decimal('costo_instalacion', 10, 2);
            $table->timestamps();
        });

        DB::table('cotizaciones')->insert([
            [
                'modulo_id' => 1,
                'costo_instalacion' => 500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ] 
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
