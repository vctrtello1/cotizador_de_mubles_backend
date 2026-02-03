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
        Schema::create('estructura', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('costo_unitario', 10, 2);
            $table->timestamps();
        });

        DB::table('estructura')->insert([
            [
                'nombre' => 'BCO FROSTY',
                'costo_unitario' => 800.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'ARAURCO LINO CAIRO',
                'costo_unitario' => 1200.00,
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
        Schema::dropIfExists('estructura');
    }
};
