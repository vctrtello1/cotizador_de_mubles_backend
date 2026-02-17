<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('table_gola', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });

        // Seed initial gola types
        DB::table('table_gola')->insert([
            [
                'nombre' => 'SUPERIOR',
                'descripcion' => 'Gola superior',
                'precio' => 701.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'INFERIOR',
                'descripcion' => 'Gola inferior',
                'precio' => 795.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'ESCUADRA',
                'descripcion' => 'Escuadra para gola',
                'precio' => 30.00,
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
        Schema::dropIfExists('table_gola');
    }
};
