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
        Schema::create('cantidad_por_componente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modulo_id');
            $table->unsignedBigInteger('componente_id');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
        });

        DB::table('cantidad_por_componente')->insert([
            [
                'modulo_id' => 1,
                'componente_id' => 1,
                'cantidad' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modulo_id' => 1,
                'componente_id' => 2,
                'cantidad' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'modulo_id' => 1,
                'componente_id' => 3,
                'cantidad' => 1,
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
        //
        Schema::dropIfExists('cantidad_por_componente');
    }
};
