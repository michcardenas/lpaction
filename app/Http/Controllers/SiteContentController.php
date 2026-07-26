<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use App\Support\Cms;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    /** Editor de contenido, separado por pestañas: Página de inicio / Ingreso 1 / Ingreso 2 / … */
    public function edit($area = 'landing')
    {
        // Pestañas disponibles (cada ingreso es independiente).
        $tabs = ['landing' => 'Página de inicio'];
        foreach (\App\Support\CursoCms::ingresosEditables() as $key => $label) {
            $tabs[$key] = $label;
        }
        if (! isset($tabs[$area])) {
            $area = 'landing';
        }

        // Secciones SOLO del área seleccionada.
        $secciones = $area === 'landing'
            ? config('landing', [])
            : \App\Support\CursoCms::seccionesDe($area);

        return view('admin.contenido', compact('tabs', 'area', 'secciones'));
    }

    /** Guarda textos e imágenes; restaura un campo puntual al original. */
    public function update(Request $request)
    {
        $registry = Cms::registry();
        $area = $request->input('area', 'landing');   // pestaña a la que volver

        // Restaurar UN campo a su valor original (botón "Restaurar original").
        if ($key = $request->input('restore')) {
            if (isset($registry[$key])) {
                $this->borrarOverride($key);
                Cms::forget();
                return redirect()->route('admin.contenido', $area)
                    ->with('cms_ok', 'Campo restaurado al valor original.')
                    ->withFragment($this->seccionDe($key));
            }
            return redirect()->route('admin.contenido', $area);
        }

        // --- Textos ---
        foreach ((array) $request->input('text', []) as $key => $val) {
            if (! isset($registry[$key]) || in_array($registry[$key]['type'] ?? 'text', ['image', 'video', 'doc'], true)) {
                continue;
            }
            $val = is_string($val) ? trim($val) : '';
            $default = (string) ($registry[$key]['default'] ?? '');

            // Si queda vacío o igual al original → sin override (usa el default).
            if ($val === '' || $val === trim($default)) {
                SiteContent::where('key', $key)->delete();
            } else {
                SiteContent::updateOrCreate(['key' => $key], ['type' => 'text', 'value' => $val]);
            }
        }

        // --- Imágenes ---
        $request->validate(
            collect($request->file('img', []))->mapWithKeys(fn ($f, $k) => ["img.$k" => 'nullable|image|max:5120'])->all(),
            [],
            ['img.*' => 'imagen']
        );

        $dir = public_path('uploads/landing');
        foreach ((array) $request->file('img', []) as $key => $file) {
            if (! isset($registry[$key]) || $registry[$key]['type'] !== 'image' || ! $file) {
                continue;
            }
            if (! is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            // Borra la imagen anterior si era un override subido.
            $this->borrarArchivoOverride($key);

            $ext  = strtolower($file->getClientOriginalExtension() ?: 'png');
            $name = str_replace('.', '_', $key) . '-' . substr(md5(uniqid('', true)), 0, 8) . '.' . $ext;
            $file->move($dir, $name);

            SiteContent::updateOrCreate(['key' => $key], ['type' => 'image', 'value' => 'uploads/landing/' . $name]);
        }

        // --- Vídeos ---
        $request->validate(
            collect($request->file('video', []))->mapWithKeys(fn ($f, $k) => ["video.$k" => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg,video/quicktime|max:40960'])->all(),
            [],
            ['video.*' => 'vídeo']
        );

        $dirV = public_path('uploads/videos');
        foreach ((array) $request->file('video', []) as $key => $file) {
            if (! isset($registry[$key]) || ($registry[$key]['type'] ?? null) !== 'video' || ! $file) {
                continue;
            }
            if (! is_dir($dirV)) {
                @mkdir($dirV, 0755, true);
            }
            $this->borrarArchivoOverride($key);
            $ext  = strtolower($file->getClientOriginalExtension() ?: 'mp4');
            $name = str_replace('.', '_', $key) . '-' . substr(md5(uniqid('', true)), 0, 8) . '.' . $ext;
            $file->move($dirV, $name);
            SiteContent::updateOrCreate(['key' => $key], ['type' => 'video', 'value' => 'uploads/videos/' . $name]);
        }

        // --- Documentos (archivo de "Descargar caso") ---
        $request->validate(
            collect($request->file('doc', []))->mapWithKeys(fn ($f, $k) => ["doc.$k" => 'nullable|file|mimes:pdf,doc,docx|max:40960'])->all(),
            [],
            ['doc.*' => 'documento']
        );

        $dirD = public_path('uploads/casos');
        foreach ((array) $request->file('doc', []) as $key => $file) {
            if (! isset($registry[$key]) || ($registry[$key]['type'] ?? null) !== 'doc' || ! $file) {
                continue;
            }
            if (! is_dir($dirD)) {
                @mkdir($dirD, 0755, true);
            }
            $this->borrarArchivoOverride($key);
            $ext  = strtolower($file->getClientOriginalExtension() ?: 'pdf');
            $name = str_replace('.', '_', $key) . '-' . substr(md5(uniqid('', true)), 0, 8) . '.' . $ext;
            $file->move($dirD, $name);
            SiteContent::updateOrCreate(['key' => $key], ['type' => 'doc', 'value' => 'uploads/casos/' . $name]);
        }

        Cms::forget();
        return redirect()->route('admin.contenido', $area)
            ->with('cms_ok', 'Cambios guardados. La web ya muestra el contenido actualizado.');
    }

    /** Elimina el override (y el archivo, si era imagen subida). */
    protected function borrarOverride(string $key): void
    {
        $this->borrarArchivoOverride($key);
        SiteContent::where('key', $key)->delete();
    }

    protected function borrarArchivoOverride(string $key): void
    {
        $row = SiteContent::where('key', $key)->first();
        if ($row && $row->value && in_array($row->type, ['image', 'video', 'doc'], true)
            && (str_starts_with($row->value, 'uploads/landing/') || str_starts_with($row->value, 'uploads/videos/') || str_starts_with($row->value, 'uploads/casos/'))) {
            @unlink(public_path($row->value));
        }
    }

    /** Devuelve el prefijo de sección de una clave (para el ancla al volver). */
    protected function seccionDe(string $key): string
    {
        $parts = explode('.', $key);
        // curso.cont|menu.<ingreso>.<etapa>.* -> sección = etapa
        // curso.<preguntaKey>.*                -> sección = preguntaKey
        // landing (hero.*)                     -> hero
        if (str_starts_with($key, 'curso.cont.') || str_starts_with($key, 'curso.menu.')) {
            $sec = $parts[3] ?? 'top';
        } elseif (str_starts_with($key, 'curso.')) {
            $sec = $parts[1] ?? 'curso';
        } else {
            $sec = $parts[0];
        }
        return 'sec-' . $sec;
    }
}
