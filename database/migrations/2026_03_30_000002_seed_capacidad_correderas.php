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
        $capacidades = [30, 40, 70];
        
        // Obtener todas las correderas existentes
        $correderas = DB::table('correderas')->get();
        
        foreach ($correderas as $corredera) {
            foreach ($capacidades as $capacidad) {
                // Insertar solo si no existe la combinación
                DB::table('capacidad_correderas')->insertOrIgnore([
                    'capacidad' => $capacidad,
                    'corredera_id' => $corredera->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar las capacidades específicas (30, 40, 70 KG)
        DB::table('capacidad_correderas')
            ->whereIn('capacidad', [30, 40, 70])
            ->delete();
    }
};
