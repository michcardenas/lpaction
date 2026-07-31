<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Médico SELECCIONADO: recibe el certificado ICOMEM/SEAFORMEC (el actual).
            // Por defecto (false) TODOS reciben el certificado CASEC de la SEC.
            $table->boolean('cert_icomem')->default(false)->after('is_test');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cert_icomem');
        });
    }
};
