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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('empresa')->nullable();
            $table->string('notas')->nullable();

            // direccion


            $table->timestamps();
        });

        DB::table('clientes')->insert([
            [
                'nombre' => 'victor Tello',
                'email' => 'victor.tello@example.com',
                'telefono' => '1234567890',
                'direccion' => 'Calle Falsa 123',
                'empresa' => 'Empresa Ejemplo',
                'notas' => 'Notas del cliente ejemplo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana Perez',
                'email' => 'ana.perez@example.com',
                'telefono' => '0987654321',
                'direccion' => 'Avenida Siempre Viva 456',
                'empresa' => 'Otra Empresa',
                'notas' => 'Notas del cliente Ana Perez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis Gomez',
                'email' => 'luis.gomez@example.com',
                'telefono' => '1122334455',
                'direccion' => 'Calle Principal 789',
                'empresa' => 'Empresa XYZ',
                'notas' => 'Notas del cliente Luis Gomez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Maria Rodriguez',
                'email' => 'maria.rodriguez@example.com',
                'telefono' => '5544332211',
                'direccion' => 'Boulevard Central 101',
                'empresa' => 'Diseños Maria',
                'notas' => 'Cliente frecuente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos Lopez',
                'email' => 'carlos.lopez@example.com',
                'telefono' => '6677889900',
                'direccion' => 'Callejon del Beso 22',
                'empresa' => 'Constructora Lopez',
                'notas' => 'Proyecto grande en puerta',
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
        Schema::dropIfExists('clientes');
    }
};
