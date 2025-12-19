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
            // Cotizacion 2
            [
                'cotizacion_id' => 2,
                'descripcion' => 'Mesa Lucianica',
                'cantidad' => 1,
                'precio_unitario' => 900.00,
                'subtotal' => 900.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 2,
                'descripcion' => 'Silla Lucianica',
                'cantidad' => 10,
                'precio_unitario' => 150.00,
                'subtotal' => 1500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 2,
                'descripcion' => 'Transporte',
                'cantidad' => 1,
                'precio_unitario' => 100.00,
                'subtotal' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cotizacion 3
            [
                'cotizacion_id' => 3,
                'descripcion' => 'Mesa Lucianica',
                'cantidad' => 2,
                'precio_unitario' => 900.00,
                'subtotal' => 1800.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 3,
                'descripcion' => 'Silla Lucianica',
                'cantidad' => 8,
                'precio_unitario' => 150.00,
                'subtotal' => 1200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cotizacion 4
            [
                'cotizacion_id' => 4,
                'descripcion' => 'Mesa Lucianica',
                'cantidad' => 3,
                'precio_unitario' => 900.00,
                'subtotal' => 2700.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => 4,
                'descripcion' => 'Silla Lucianica',
                'cantidad' => 12,
                'precio_unitario' => 150.00,
                'subtotal' => 1800.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Cotizacion 5
            [
                'cotizacion_id' => 5,
                'descripcion' => 'Estante Moderno',
                'cantidad' => 2,
                'precio_unitario' => 600.00,
                'subtotal' => 1200.00,
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
