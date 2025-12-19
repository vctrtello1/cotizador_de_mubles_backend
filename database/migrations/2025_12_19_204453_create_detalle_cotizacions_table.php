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
        Schema::create('detalle_cotizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });


        DB::table('detalle_cotizacions')->insert([
            [
                'cotizacion_id' => 1,
                'descripcion' => 'Silla Lucianica',
                'cantidad' => 4,
                'precio_unitario' => 150.00,
                'subtotal' => 600.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 1,
                'descripcion' => 'Mesa Lucianica',
                'cantidad' => 1,
                'precio_unitario' => 900.00,
                'subtotal' => 900.00,
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
        Schema::dropIfExists('detalle_cotizacions');
    }
};
