<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whats_por_metro', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('precio', 10, 2);
            $table->integer('unidades_por_metro')->default(7);
            $table->decimal('porcentaje_utilizacion', 5, 2)->default(0);
            $table->timestamps();
        });

        DB::table('whats_por_metro')->insert([
            [
                'nombre' => 'W X METRO',
                'precio' => 107.00,
                'unidades_por_metro' => 7,
                'porcentaje_utilizacion' => 5.00,
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
        Schema::dropIfExists('whats_por_metro');
    }
};
