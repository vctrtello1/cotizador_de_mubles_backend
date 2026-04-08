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
        Schema::create('conectores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('precio', 10, 2);
            $table->integer('unidades_por_metro')->default(2);
            $table->decimal('porcentaje_utilizacion', 5, 2)->default(0);
            $table->timestamps();
        });

        DB::table('conectores')->insert([
            [
                'nombre' => 'CONECTORES',
                'precio' => 60.00,
                'unidades_por_metro' => 2,
                'porcentaje_utilizacion' => 7.63,
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
        Schema::dropIfExists('conectores');
    }
};
