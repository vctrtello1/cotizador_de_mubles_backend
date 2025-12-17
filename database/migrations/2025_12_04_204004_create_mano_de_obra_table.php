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
        Schema::create('mano_de_obras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('costo_hora', 10, 2);
            $table->decimal('tiempo', 10, 2);
            $table->decimal('costo_total', 10, 2);
            $table->timestamps();
        });


        // manao de obra Silla Lucianica
        DB::table('mano_de_obras')->insert([
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

        // manao de obra Mesa Lucianica
        DB::table('mano_de_obras')->insert([
            [
                'nombre' => 'Mano de Obra Premium',
                'descripcion' => 'Mano de obra para ensamblaje y acabado premium',
                'costo_hora' => 35.00,
                'tiempo' => 6.00,
                'costo_total' => 210.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]); 

        // Mano de obra Estante Moderno
        DB::table('mano_de_obras')->insert([
            [
                'nombre' => 'Mano de Obra Especializada',
                'descripcion' => 'Mano de obra para ensamblaje y acabado especializado',
                'costo_hora' => 30.00,
                'tiempo' => 5.00,
                'costo_total' => 150.00,
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
        Schema::dropIfExists('mano_de_obras');
    }
};
