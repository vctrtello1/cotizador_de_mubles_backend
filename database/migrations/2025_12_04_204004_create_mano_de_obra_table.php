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
        Schema::create('mano_de_obra', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('costo_hora', 10, 2);
            $table->decimal('tiempo', 10, 2);
            $table->decimal('costo_total', 10, 2);
            $table->timestamps();
        });

        DB::table('mano_de_obra')->insert([
            [
                'nombre' => 'Mano de Obra Estándar',
                'descripcion' => 'Mano de obra para ensamblaje y acabado estándar',
                'costo_hora' => 25.00,
                'tiempo' => 4.00,
                'costo_total' => 100.00,
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
        Schema::dropIfExists('mano_de_obra');
    }
};
