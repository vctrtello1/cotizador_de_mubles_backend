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
        Schema::create('accesorios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });

        DB::table('accesorios')->insert([
            [
                'nombre' => 'MENSULA REPISA',
                'descripcion' => null,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'ZOCLO',
                'descripcion' => null,
                'precio' => 450.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'CLIPS ZOCLO',
                'descripcion' => null,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'PATAS NIVELADORAS',
                'descripcion' => null,
                'precio' => 20.00,
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
        Schema::dropIfExists('accesorios');
    }
};
