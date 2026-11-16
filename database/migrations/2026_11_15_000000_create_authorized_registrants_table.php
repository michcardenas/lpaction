<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Inscritos autorizados cargados por Excel/CSV desde el panel /admin.
 * Se SUMAN a los de config/registrantes.php (fuente combinada en App\Support\Registrantes).
 * Vivir en BD permite al admin añadir inscritos sin tocar el código ni hacer push.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorized_registrants', function (Blueprint $t) {
            $t->id();
            $t->string('email')->unique();      // correo normalizado (minúsculas)
            $t->string('document')->default(''); // documento normalizado ('' = solo correo)
            $t->string('name')->nullable();     // nombre (para mostrar los pendientes)
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorized_registrants');
    }
};
