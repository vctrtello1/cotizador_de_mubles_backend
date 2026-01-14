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
        Schema::create('horas_de_mano_de_obra_por_componente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('componente_id');
            $table->unsignedBigInteger('mano_de_obra_id');
            $table->integer('horas');
            $table->timestamps();

            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
            $table->foreign('mano_de_obra_id')->references('id')->on('mano_de_obras')->onDelete('cascade');
            $table->unique(['componente_id', 'mano_de_obra_id'], 'horas_comp_mano_unique');
        });

        DB::table('horas_de_mano_de_obra_por_componente')->insert([
            [
                'componente_id' => 1,
                'mano_de_obra_id' => 1,
                'horas' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'componente_id' => 1,
                'mano_de_obra_id' => 2,
                'horas' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'componente_id' => 2,
                'mano_de_obra_id' => 1,
                'horas' => 3,
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
        Schema::dropIfExists('horas_de_mano_de_obra_por_componente');
    }
};
