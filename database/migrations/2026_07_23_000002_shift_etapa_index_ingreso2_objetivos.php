<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * El INGRESO 2 gana el capítulo "Objetivos lipídicos adicionales" en la posición 3
 * (índice 3, justo después de "Pruebas complementarias"). Los alumnos que ya habían
 * pasado de ahí deben desplazar su `etapa_index` en 1 para seguir en la MISMA etapa.
 *
 * Quien iba por Introducción/Presentación/Pruebas (índices 0-2) no se toca: esas
 * etapas no cambian de posición.
 *
 * Las respuestas se guardan por CLAVE de etapa, así que no se pierde ninguna.
 */
return new class extends Migration
{
    /** Índice del capítulo nuevo y último índice del ingreso 2 tras el cambio. */
    private const NUEVO_INDICE  = 3;
    private const ULTIMO_INDICE = 10;

    public function up(): void
    {
        DB::table('course_progress')
            ->where('module_key', 'ingreso-2')
            ->where('etapa_index', '>=', self::NUEVO_INDICE)
            ->update([
                'etapa_index' => DB::raw('LEAST(etapa_index + 1, '.self::ULTIMO_INDICE.')'),
            ]);
    }

    public function down(): void
    {
        DB::table('course_progress')
            ->where('module_key', 'ingreso-2')
            ->where('etapa_index', '>', self::NUEVO_INDICE)
            ->update([
                'etapa_index' => DB::raw('GREATEST(etapa_index - 1, 0)'),
            ]);
    }
};
