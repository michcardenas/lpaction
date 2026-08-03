<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "Descargar caso" es el gate del cierre de cada ingreso: hasta que el alumno lo pulsa,
 * el módulo NO llega al 100% y "Finalizar ingreso" queda bloqueado. Este flag lo registra
 * por ingreso (una fila de course_progress por módulo).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_progress', function (Blueprint $table) {
            $table->boolean('caso_descargado')->default(false)->after('etapa_index');
        });
    }

    public function down(): void
    {
        Schema::table('course_progress', function (Blueprint $table) {
            $table->dropColumn('caso_descargado');
        });
    }
};
