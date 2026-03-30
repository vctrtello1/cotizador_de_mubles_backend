<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Inserta en cotizaciones_por_usuario todas las cotizaciones cuyo
        // created_by_user_id sea un vendedor y que aún no tengan registro
        // para ese mismo usuario en la tabla de asignaciones.
        $now = now();

        DB::table('cotizaciones as c')
            ->join('users as u', 'u.id', '=', 'c.created_by_user_id')
            ->where('u.rol', 'vendedor')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('cotizaciones_por_usuario as cpu')
                    ->whereColumn('cpu.cotizacion_id', 'c.id')
                    ->whereColumn('cpu.user_id', 'c.created_by_user_id');
            })
            ->orderBy('c.id')
            ->select('c.created_by_user_id as user_id', 'c.id as cotizacion_id')
            ->chunk(200, function ($rows) use ($now) {
                $insert = $rows->map(fn($r) => [
                    'user_id'       => $r->user_id,
                    'cotizacion_id' => $r->cotizacion_id,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ])->all();

                DB::table('cotizaciones_por_usuario')->insertOrIgnore($insert);
            });
    }

    public function down(): void
    {
        // Elimina sólo los registros que coinciden con created_by_user_id
        // (no los creados manualmente por otros administradores)
        DB::statement('
            DELETE cpu FROM cotizaciones_por_usuario cpu
            INNER JOIN cotizaciones c ON c.id = cpu.cotizacion_id
            WHERE c.created_by_user_id = cpu.user_id
        ');
    }
};
