<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Marca si el usuario ya vio el modal de bienvenida al curso.
     * Sirve para mostrarlo SOLO UNA VEZ (en el registro o en el primer login con 0% de avance).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('welcome_seen')->default(false)->after('cert_icomem');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('welcome_seen');
        });
    }
};
