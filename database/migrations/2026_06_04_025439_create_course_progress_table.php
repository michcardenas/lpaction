<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Progreso del curso por usuario.
     * Cada fila = un módulo del curso (ingreso-1/2/3, evaluación, diploma) para un usuario.
     */
    public function up(): void
    {
        Schema::create('course_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module_key');                 // ingreso-1, ingreso-2, ingreso-3, evaluacion, diploma
            $table->string('status')->default('locked');  // locked | available | in_progress | completed
            $table->unsignedTinyInteger('percent')->default(0); // 0-100
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'module_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_progress');
    }
};
