<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;



return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crea el cliente "Público en general" si no existe, usando solo columnas existentes
        DB::table('clientes')->updateOrInsert(
            [ 'nombre' => 'Público en general' ],
            [
                'nombre' => 'Público en general',
                'direccion' => 'N/A',
                'telefono' => 'N/A',
                'email' => 'publico@cotizador.com',
                'empresa' => 'N/A',
                'notas' => 'Cliente genérico para ventas públicas',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina el cliente "Público en general"
        DB::table('clientes')->where('nombre', 'Público en general')->delete();
    }
};
