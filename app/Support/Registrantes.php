<?php

namespace App\Support;

use App\Models\AuthorizedRegistrant;
use Illuminate\Support\Facades\Schema;

/**
 * Fuente ÚNICA de los inscritos AUTORIZADOS a registrarse.
 * Combina dos orígenes:
 *   1) config/registrantes.php  (lista base, se sube por Git)
 *   2) tabla authorized_registrants  (carga por Excel/CSV desde /admin, sin tocar código)
 *
 * La usan: Auth\RegisterController (puerta de registro), AdminController (panel) y
 * CourseReport (informe), para que todos vean exactamente la misma lista.
 */
class Registrantes
{
    /** Normaliza un documento para comparar: MAYÚSCULAS y solo alfanumérico. '' = sin documento. */
    public static function normalizarDoc($doc): string
    {
        return preg_replace('/[^A-Z0-9]/', '', strtoupper(trim((string) $doc)));
    }

    /** Correo normalizado (minúsculas, sin espacios) para usar como clave. */
    public static function normalizarEmail($email): string
    {
        return mb_strtolower(trim((string) $email));
    }

    /**
     * Mapa de autorizados: 'correo' => 'DOCUMENTO_NORMALIZADO' ('' = basta el correo).
     * La tabla (Excel) gana sobre el config si se repite el correo.
     */
    public static function autorizados(): array
    {
        $map = [];
        foreach ((array) config('registrantes.autorizados', []) as $email => $doc) {
            $map[self::normalizarEmail($email)] = self::normalizarDoc($doc);
        }
        foreach (self::deBaseDeDatos() as $r) {
            $map[self::normalizarEmail($r->email)] = self::normalizarDoc($r->document);
        }
        return $map;
    }

    /** Nombres de los inscritos cargados por Excel: 'correo' => 'Nombre' (para mostrar pendientes). */
    public static function nombres(): array
    {
        $map = [];
        foreach (self::deBaseDeDatos() as $r) {
            $n = trim((string) $r->name);
            if ($n !== '') {
                $map[self::normalizarEmail($r->email)] = $n;
            }
        }
        return $map;
    }

    /** Filas de la tabla, tolerante a que aún no exista (entre el git pull y el artisan migrate). */
    private static function deBaseDeDatos()
    {
        try {
            if (! Schema::hasTable('authorized_registrants')) {
                return collect();
            }
            return AuthorizedRegistrant::all();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}
