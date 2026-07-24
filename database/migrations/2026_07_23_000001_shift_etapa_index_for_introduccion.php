<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Se añadió la etapa "Introducción" como PRIMERA de cada ingreso, así que todos los
 * índices posteriores se desplazan una posición. Los alumnos que ya habían empezado
 * deben avanzar su `etapa_index` en 1 para seguir en la MISMA etapa de contenido.
 * (Las respuestas se guardan por CLAVE de etapa, no por índice: no se pierde nada.)
 *
 * A quien todavía no ha empezado (status available/locked) se le deja en 0, que ahora
 * es justamente la nueva "Introducción".
 */
return new class extends Migration
{
    /** Número de etapas DESPUÉS del cambio (índice máximo = 9). */
    private const ULTIMO_INDICE = 9;

    public function up(): void
    {
        DB::table('course_progress')
            ->where('module_key', 'like', 'ingreso-%')
            ->whereIn('status', ['in_progress', 'completed'])
            ->update([
                'etapa_index' => DB::raw('LEAST(etapa_index + 1, '.self::ULTIMO_INDICE.')'),
            ]);
    }

    public function down(): void
    {
        DB::table('course_progress')
            ->where('module_key', 'like', 'ingreso-%')
            ->whereIn('status', ['in_progress', 'completed'])
            ->update([
                'etapa_index' => DB::raw('GREATEST(etapa_index - 1, 0)'),
            ]);
    }
};
