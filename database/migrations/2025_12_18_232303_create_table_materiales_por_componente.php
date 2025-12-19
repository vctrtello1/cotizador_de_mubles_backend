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
        //
        Schema::create('materiales_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id')->constrained('componentes');
            $table->foreignId('material_id')->constrained('materiales');
            $table->integer('cantidad');
            $table->timestamps();
        });

        DB::table('materiales_por_componente')->insert([
            ['componente_id' => 1, 'material_id' => 1, 'cantidad' => 2],
            ['componente_id' => 1, 'material_id' => 2, 'cantidad' => 3],
            ['componente_id' => 2, 'material_id' => 3, 'cantidad' => 8],
            ['componente_id' => 2, 'material_id' => 4, 'cantidad' => 1],
            ['componente_id' => 3, 'material_id' => 5, 'cantidad' => 5],
            ['componente_id' => 3, 'material_id' => 6, 'cantidad' => 2],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('materiales_por_componente');
    }
};
