<?php

namespace App\Support;

use App\Models\SiteContent;

/**
 * Resuelve el contenido editable de la landing.
 *
 * Devuelve el override guardado en site_contents si existe; si no, el valor
 * por defecto definido en config/landing.php. Así la web se ve idéntica hasta
 * que el cliente edita algo desde el panel.
 */
class Cms
{
    /** Overrides cargados una sola vez por request: [key => value]. */
    protected static ?array $overrides = null;

    /** Defaults aplanados del registry: [key => ['type','default',...]]. */
    protected static ?array $registry = null;

    protected static function overrides(): array
    {
        if (self::$overrides !== null) {
            return self::$overrides;
        }
        try {
            self::$overrides = SiteContent::query()->pluck('value', 'key')->all();
        } catch (\Throwable $e) {
            // La tabla puede no existir todavía (antes de migrar): no romper la web.
            self::$overrides = [];
        }
        return self::$overrides;
    }

    public static function registry(): array
    {
        if (self::$registry !== null) {
            return self::$registry;
        }
        $flat = [];
        foreach (config('landing', []) as $section) {
            foreach ($section['fields'] ?? [] as $key => $def) {
                $flat[$key] = $def;
            }
        }
        // Campos editables de los ingresos (preguntas): misma tabla, mismas reglas.
        foreach (CursoCms::registryFields() as $key => $def) {
            $flat[$key] = $def;
        }
        return self::$registry = $flat;
    }

    protected static function defaultOf(string $key): string
    {
        return (string) (self::registry()[$key]['default'] ?? '');
    }

    /** Texto: override o, en su defecto, el valor original. */
    public static function text(string $key, ?string $default = null): string
    {
        $ov = self::overrides()[$key] ?? null;
        if ($ov !== null && $ov !== '') {
            return $ov;
        }
        return $default ?? self::defaultOf($key);
    }

    /** Imagen: URL (asset) del override subido o, en su defecto, la imagen original. */
    public static function img(string $key, ?string $default = null): string
    {
        $ov = self::overrides()[$key] ?? null;
        $path = ($ov !== null && $ov !== '') ? $ov : ($default ?? self::defaultOf($key));
        return asset($path);
    }

    /** ¿Hay un override guardado para esta clave? (para marcar "editado" en el panel). */
    public static function isOverridden(string $key): bool
    {
        $ov = self::overrides()[$key] ?? null;
        return $ov !== null && $ov !== '';
    }

    /** Valor crudo guardado (o null). Útil en el editor. */
    public static function raw(string $key): ?string
    {
        return self::overrides()[$key] ?? null;
    }

    /** Limpia la caché en memoria tras guardar cambios. */
    public static function forget(): void
    {
        self::$overrides = null;
    }
}
