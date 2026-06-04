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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // 1. Datos personales
            $table->string('name');                          // Nombre
            $table->string('last_name')->nullable();         // Apellidos
            $table->string('document_id')->nullable();       // Documento (DNI/NIE)
            $table->string('country')->nullable();           // País
            $table->string('province')->nullable();          // Provincia
            $table->string('city')->nullable();              // Población
            $table->string('email')->unique();               // Correo electrónico
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');                      // Contraseña
            // 2. Datos profesionales
            $table->string('specialty')->nullable();         // Especialidad
            $table->string('hospital')->nullable();          // Hospital
            $table->string('center_type')->nullable();       // privado | publico | ambos
            // 3. Perfil profesional
            $table->string('experience_level')->nullable();  // 0-7 | 8-15 | 16+
            // Consentimientos
            $table->boolean('accepted_privacy')->default(false);
            $table->boolean('accepted_novartis')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
