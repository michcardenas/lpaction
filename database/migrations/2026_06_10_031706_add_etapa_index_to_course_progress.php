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
            // Etapa actual (más lejana alcanzada) dentro del ingreso. 0 = primera.
            $table->unsignedTinyInteger('etapa_index')->default(0)->after('percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_progress', function (Blueprint $table) {
            $table->dropColumn('etapa_index');
        });
    }
};
