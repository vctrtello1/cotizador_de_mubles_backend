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
        Schema::create('perfil_aluminios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('precio', 10, 2);
            $table->decimal('porcentaje_utilizacion', 5, 2)->default(0);
            $table->timestamps();
        });

        DB::table('perfil_aluminios')->insert([
            [
                'nombre' => 'PERFIL ALUMINIO EMPOTRADO',
                'precio' => 150.00,
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
        Schema::dropIfExists('perfil_aluminios');
    }
};
