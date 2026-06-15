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
        Schema::table('course_progress', function (Blueprint $table) {
            // Resultado por etapa: { "<etapa_key>": { "estado": "perfecta"|"error", "puntos": N } }.
            // Sirve para los estados del sidebar (check/cruz, regla #168) y para persistir el XP.
            $table->json('etapas')->nullable()->after('etapa_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_progress', function (Blueprint $table) {
            $table->dropColumn('etapas');
        });
    }
};
