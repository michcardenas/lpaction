<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Recoloca `course_progress.etapa_index` para los alumnos que ya iban a medias,
 * tras dos cambios de estructura:
 *   - INGRESO 1: se añade "Introducción" (solo vídeo) en la posición 0
 *     -> todos los índices del ingreso-1 suben +1.
 *   - INGRESO 2: se añade "Objetivos lipídicos adicionales" en la posición 2
 *     (entre "Pruebas complementarias" y "Evaluación del riesgo")
 *     -> los índices del ingreso-2 >= 2 suben +1.
 *   - INGRESO 3: sin cambios (usa la lista general, 9 etapas).
 *
 * La introducción va SOLO en el Ingreso 1 (no en el 2 ni en el 3).
 * Las respuestas se guardan por CLAVE de etapa, así que no se pierde ninguna.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Ingreso 1: +1 a todos (Introducción en la posición 0). Máx 9 (10 etapas -> idx 0..9).
        DB::table('course_progress')
            ->where('module_key', 'ingreso-1')
            ->whereIn('status', ['in_progress', 'completed'])
            ->update(['etapa_index' => DB::raw('LEAST(etapa_index + 1, 9)')]);

        // Ingreso 2: +1 solo a partir de "Objetivos" (posición 2). Máx 9 (10 etapas -> idx 0..9).
        DB::table('course_progress')
            ->where('module_key', 'ingreso-2')
            ->whereIn('status', ['in_progress', 'completed'])
            ->where('etapa_index', '>=', 2)
            ->update(['etapa_index' => DB::raw('LEAST(etapa_index + 1, 9)')]);
    }

    public function down(): void
    {
        DB::table('course_progress')
            ->where('module_key', 'ingreso-1')
            ->whereIn('status', ['in_progress', 'completed'])
            ->update(['etapa_index' => DB::raw('GREATEST(etapa_index - 1, 0)')]);

        DB::table('course_progress')
            ->where('module_key', 'ingreso-2')
            ->whereIn('status', ['in_progress', 'completed'])
            ->where('etapa_index', '>=', 3)
            ->update(['etapa_index' => DB::raw('GREATEST(etapa_index - 1, 0)')]);
    }
};
