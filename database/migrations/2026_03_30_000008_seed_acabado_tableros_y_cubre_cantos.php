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
        DB::table('acabado_tableros')->insert([
            ['nombre' => 'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'NINGUNO', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('acabado_cubre_cantos')->insert([
            ['nombre' => 'EGGER (ALTO BRILLO) 18 MM', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ARAUCO 15 MM', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('acabado_tableros')->whereIn('nombre', [
            'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm',
            'NINGUNO',
        ])->delete();

        DB::table('acabado_cubre_cantos')->whereIn('nombre', [
            'EGGER (ALTO BRILLO) 18 MM',
            'ARAUCO 15 MM',
        ])->delete();
    }
};
