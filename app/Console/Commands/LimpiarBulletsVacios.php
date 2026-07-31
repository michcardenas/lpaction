<?php

namespace App\Console\Commands;

use App\Models\SiteContent;
use Illuminate\Console\Command;

/**
 * Elimina los <li> vacíos (basura que deja el editor Quill) de los overrides de
 * contenido del curso guardados en site_contents. Seguro: solo borra elementos de
 * lista SIN texto; respeta listas anidadas y todo el contenido real.
 *
 *   php artisan cms:limpiar-bullets
 */
class LimpiarBulletsVacios extends Command
{
    protected $signature = 'cms:limpiar-bullets';

    protected $description = 'Elimina los <li> vacíos (Quill) de los overrides de contenido del curso.';

    public function handle(): int
    {
        $n = 0;

        foreach (SiteContent::where('key', 'like', 'curso.cont.%')->get() as $r) {
            $v = $r->value;
            if (! is_string($v)) {
                continue;
            }

            // Solo <li> HOJA (sin li/ul dentro) cuyo texto quede vacío tras quitar tags/espacios.
            $c = preg_replace_callback('#<li\b[^>]*>((?:(?!</?(?:li|ul)\b).)*?)</li>#is', function ($m) {
                $inner = trim(preg_replace('/&nbsp;|\s+/u', '', strip_tags($m[1])));
                return $inner === '' ? '' : $m[0];
            }, $v);

            if ($c !== $v) {
                $r->value = $c;
                $r->save();
                $n++;
                $this->line('  limpiado: ' . $r->key);
            }
        }

        $this->info("Overrides limpiados: {$n}");

        return self::SUCCESS;
    }
}
