<?php

namespace App\Http\Controllers;

use App\Models\AuthorizedRegistrant;
use App\Models\CourseProgress;
use App\Models\User;
use App\Support\Registrantes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    /** Panel de administración: métricas de progreso + lista de inscritos. */
    public function dashboard()
    {
        // Alumnos REALES del curso = inscritos AUTORIZADOS que YA tienen cuenta real (is_test=false).
        // Las métricas excluyen las cuentas de prueba (is_test=true) Y las cuentas antiguas que NO
        // están en la lista de inscritos (p. ej. demos con progreso completo que inflaban el avance,
        // como "19 completados" del Ingreso 3 que está No disponible).
        $autorizados      = Registrantes::autorizados();
        $nombresPend      = Registrantes::nombres(); // nombres de los cargados por Excel (pendientes)
        $totalAutorizados = count($autorizados);
        $realesEmail = User::where('is_admin', false)->where('is_test', false)->get()
            ->keyBy(fn ($u) => mb_strtolower(trim((string) $u->email)));
        $testCol = User::where('is_admin', false)->where('is_test', true)->get();
        $alumnosReales = collect($autorizados)->keys()
            ->map(fn ($e) => $realesEmail->get(mb_strtolower(trim((string) $e))))
            ->filter()->values();
        $studentIds   = $alumnosReales->pluck('id');
        $totalAlumnos = $studentIds->count();

        // Progreso de los alumnos reales, agrupado por usuario.
        $progresos = CourseProgress::whereIn('user_id', $studentIds)->get()->groupBy('user_id');

        // Cuenta de estados por módulo (completado / en curso).
        $modulos = ['ingreso-1', 'ingreso-2', 'ingreso-3', 'evaluacion', 'encuesta', 'diploma'];
        $stats = [];
        foreach ($modulos as $m) {
            $completados = 0;
            $enCurso = 0;
            foreach ($progresos as $filas) {
                $fila = $filas->firstWhere('module_key', $m);
                if (! $fila) continue;
                if ($fila->status === 'completed') $completados++;
                elseif ($fila->status === 'in_progress') $enCurso++;
            }
            $stats[$m] = [
                'completados' => $completados,
                'en_curso'    => $enCurso,
                'pct'         => $totalAlumnos > 0 ? round($completados / $totalAlumnos * 100) : 0,
            ];
        }

        // Aprobados de la evaluación final (APTO) y media de nota.
        $aptos = 0;
        $notas = [];
        foreach ($progresos as $filas) {
            $ev = $filas->firstWhere('module_key', 'evaluacion');
            $meta = $ev->etapas ?? [];
            if (! empty($meta['apto'])) $aptos++;
            if (isset($meta['ultima_nota'])) $notas[] = (int) $meta['ultima_nota'];
        }
        $mediaNota = count($notas) ? round(array_sum($notas) / count($notas), 1) : null;

        // Curso completo = aprobó la evaluación (desbloquea diploma).
        $cursoCompleto = $aptos;

        // Registros recientes (últimos 7 días) entre los alumnos reales.
        $nuevos7d = $alumnosReales->filter(fn ($u) => $u->created_at >= now()->subDays(7))->count();

        // Progreso de las cuentas de prueba (para su pestaña).
        $progresosTest = CourseProgress::whereIn('user_id', $testCol->pluck('id'))->get()->groupBy('user_id');

        // Especialidades acreditadas (diploma UEMS) → "Acreditación: SÍ". Comparación INSENSIBLE a
        // tildes y mayúsculas, para que "Cardiologia"/"CARDIOLOGIA" cuenten igual que "Cardiología".
        $maxIntentos = (int) (config('curso.evaluacion.max_intentos') ?? 2);
        $norm = fn ($s) => strtr(mb_strtolower(trim((string) $s)),
            ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n']);
        $acreditadas = array_map($norm, config('curso.diploma_uems_especialidades', []));
        // Mapa (sin tildes) → nombre canónico, para MOSTRAR bien la especialidad (p. ej. un dato
        // importado como "Cardiologia" se muestra "Cardiología").
        $canon = [];
        foreach (config('curso.diploma_uems_especialidades', []) as $e) { $canon[$norm($e)] = $e; }

        // ===== Lista de INSCRITOS: los 352 AUTORIZADOS con su estado + datos de registro =====
        $tab     = request()->query('tab') === 'test' ? 'test' : 'alumnos';
        $q       = trim((string) request()->query('q', ''));
        $perPage = 50;

        // Fila completa de un alumno YA registrado (usuario + su progreso).
        $fila = function ($u, $filas) use ($maxIntentos, $acreditadas, $norm, $canon) {
            $estado = fn ($m) => optional($filas->firstWhere('module_key', $m))->status ?? 'locked';
            $evMeta = optional($filas->firstWhere('module_key', 'evaluacion'))->etapas ?? [];
            $apto = ! empty($evMeta['apto']);
            $intentos = (int) ($evMeta['intentos'] ?? 0);
            $estadoEval = $apto ? 'apto' : ($intentos >= $maxIntentos ? 'no_apto' : 'en_curso');
            $diplomaDescargado = ! empty((optional($filas->firstWhere('module_key', 'diploma'))->etapas ?? [])['descargado']);
            $espec = trim((string) ($u->specialty ?? ''));

            return [
                'registrado'  => true,
                'id'          => $u->id,
                'nombre'      => trim($u->name.' '.($u->last_name ?? '')) ?: '—',
                'email'       => $u->email,
                'especialidad'=> $espec !== '' ? ($canon[$norm($espec)] ?? $espec) : '—',
                'dni'         => trim((string) $u->document_id) ?: '—',
                'provincia'   => trim((string) $u->province) ?: '—',
                'poblacion'   => trim((string) $u->city) ?: '—',
                'perfil'      => trim((string) $u->experience_level) ?: '—',
                'acreditada'  => $espec !== '' && in_array($norm($espec), $acreditadas, true),
                'i1' => $estado('ingreso-1'), 'i2' => $estado('ingreso-2'), 'i3' => $estado('ingreso-3'),
                'estado_eval' => $estadoEval,
                'nota1' => $evMeta['nota_intento1'] ?? null, 'nota2' => $evMeta['nota_intento2'] ?? null,
                'diploma'     => $diplomaDescargado,
                'registro'    => $u->created_at,
                'is_test'     => (bool) $u->is_test,
                'cert_icomem' => (bool) $u->cert_icomem,
            ];
        };

        // Fila de un autorizado AÚN NO registrado (solo correo + documento + nombre si vino por Excel).
        $filaPendiente = fn ($email, $doc) => [
            'registrado' => false, 'id' => null,
            'nombre' => $nombresPend[mb_strtolower(trim((string) $email))] ?? '—', 'email' => $email,
            'especialidad' => '—', 'dni' => $doc ?: '—', 'provincia' => '—', 'poblacion' => '—',
            'perfil' => '—', 'acreditada' => false, 'i1' => 'locked', 'i2' => 'locked', 'i3' => 'locked',
            'estado_eval' => null, 'nota1' => null, 'nota2' => null, 'diploma' => false,
            'registro' => null, 'is_test' => false, 'cert_icomem' => false,
        ];

        // La lista reusa los datos ya cargados arriba. "Registrado" = alumno real (autorizado con
        // cuenta is_test=false); por eso registrados = totalAlumnos.
        $reales       = $realesEmail;
        $registradosN = $totalAlumnos;
        $pendientesN  = $totalAutorizados - $registradosN;
        $testN        = $testCol->count();

        if ($tab === 'test') {
            $base = $testCol->map(fn ($u) => $fila($u, $progresosTest->get($u->id) ?? collect()))->values();
        } else {
            $base = collect($autorizados)->map(function ($doc, $email) use ($reales, $progresos, $fila, $filaPendiente) {
                $u = $reales->get(mb_strtolower(trim((string) $email)));
                return $u ? $fila($u, $progresos->get($u->id) ?? collect()) : $filaPendiente($email, $doc);
            })->values()->sortByDesc('registrado')->values();
        }

        if ($q !== '') {
            $needle = mb_strtolower($q);
            $base = $base->filter(fn ($r) =>
                str_contains(mb_strtolower((string) $r['email']), $needle)
                || str_contains(mb_strtolower((string) $r['nombre']), $needle)
                || str_contains(mb_strtolower((string) $r['dni']), $needle)
                || str_contains(mb_strtolower((string) $r['especialidad']), $needle)
            )->values();
        }

        $page  = max(1, (int) request()->query('page', 1));
        $items = (new LengthAwarePaginator(
            $base->forPage($page, $perPage)->values(), $base->count(), $perPage, $page,
            ['path' => request()->url()]
        ))->appends(request()->except('page'));

        // ¿Existe el informe final para ofrecer su descarga?
        $informeDisponible = is_file($this->informePath());

        return view('admin.dashboard', compact(
            'totalAlumnos', 'stats', 'aptos', 'mediaNota', 'cursoCompleto', 'nuevos7d', 'informeDisponible',
            'items', 'tab', 'q', 'totalAutorizados', 'registradosN', 'pendientesN', 'testN'
        ));
    }

    /** Descarga la plantilla CSV (correo; documento; nombre) para cargar inscritos. */
    public function plantillaRegistrantes()
    {
        $sep = ';'; // ';' abre en columnas en Excel en español
        $filas = [
            ['correo', 'documento', 'nombre'],
            ['ejemplo1@correo.com', '12345678A', 'Nombre Apellidos'],
            ['ejemplo2@correo.com', '', 'Sin documento (basta el correo)'],
        ];
        $csv = "\xEF\xBB\xBF"; // BOM UTF-8 para que Excel muestre bien las tildes
        foreach ($filas as $f) {
            $csv .= implode($sep, array_map(fn ($c) => '"' . str_replace('"', '""', $c) . '"', $f)) . "\r\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="plantilla_inscritos_lpaction.csv"',
        ]);
    }

    /** Carga inscritos autorizados desde un CSV (correo + documento opcional + nombre opcional). */
    public function importarRegistrantes(Request $request)
    {
        $request->validate(
            ['archivo' => ['required', 'file', 'max:5120']],
            [
                'archivo.required' => 'Selecciona un archivo CSV.',
                'archivo.file'     => 'El archivo no es válido.',
                'archivo.max'      => 'El archivo no puede superar 5 MB.',
            ]
        );

        $ext = strtolower($request->file('archivo')->getClientOriginalExtension());
        if (! in_array($ext, ['csv', 'txt'], true)) {
            return back()->with('error', 'El archivo debe ser CSV. En Excel usa «Guardar como → CSV UTF-8».');
        }

        $raw = file_get_contents($request->file('archivo')->getRealPath());
        if ($raw === false || trim($raw) === '') {
            return back()->with('error', 'El archivo está vacío o no se pudo leer.');
        }

        $raw    = preg_replace('/^\xEF\xBB\xBF/', '', $raw);   // quitar BOM
        $lineas = preg_split('/\r\n|\r|\n/', $raw);

        // Detectar el separador (coma, punto y coma o tabulador) por la primera línea con contenido.
        $sep = ',';
        foreach ($lineas as $l) {
            if (trim($l) === '') continue;
            $pc = substr_count($l, ';'); $co = substr_count($l, ','); $tb = substr_count($l, "\t");
            $sep = ($pc >= $co && $pc >= $tb) ? ';' : (($tb > $co) ? "\t" : ',');
            break;
        }

        $agregados = $actualizados = $invalidos = $duplicados = 0;
        $vistos    = [];
        $primera   = true;

        foreach ($lineas as $linea) {
            if (trim($linea) === '') continue;
            $cols   = str_getcsv($linea, $sep);
            $correo = Registrantes::normalizarEmail($cols[0] ?? '');
            $doc    = Registrantes::normalizarDoc($cols[1] ?? '');
            $nombre = trim((string) ($cols[2] ?? ''));

            // La primera fila con contenido puede ser la cabecera (correo/email): si no es un correo
            // válido, se salta como encabezado; si lo es, se procesa como dato.
            if ($primera) {
                $primera = false;
                if (! filter_var($correo, FILTER_VALIDATE_EMAIL)) continue;
            }

            if (! filter_var($correo, FILTER_VALIDATE_EMAIL)) { $invalidos++; continue; }
            if (isset($vistos[$correo])) { $duplicados++; continue; }
            $vistos[$correo] = true;

            $fila = AuthorizedRegistrant::firstOrNew(['email' => $correo]);
            if ($fila->exists) {
                $fila->document = $doc;
                if ($nombre !== '') $fila->name = $nombre;
                $fila->save();
                $actualizados++;
            } else {
                $fila->document = $doc;
                $fila->name     = $nombre !== '' ? $nombre : null;
                $fila->save();
                $agregados++;
            }
        }

        if ($agregados === 0 && $actualizados === 0) {
            return back()->with('error', 'No se cargó ningún inscrito. Revisa que la 1ª columna sea el correo.'
                . ($invalidos ? " ({$invalidos} filas sin correo válido)." : ''));
        }

        $msg = "Carga completada: {$agregados} nuevos, {$actualizados} actualizados"
            . ($duplicados ? ", {$duplicados} repetidos en el archivo" : '')
            . ($invalidos ? ", {$invalidos} filas sin correo válido (ignoradas)" : '') . '.';

        return back()->with('status', $msg);
    }

    /** Visor de la ENCUESTA de satisfacción: puntuación por dimensión + comentario de cada alumno. */
    public function encuestas()
    {
        $dims = array_map(fn ($it) => $it['titulo'], config('curso.encuesta.items', []));

        $rows = User::where('is_admin', false)
            ->whereHas('progress', fn ($q) => $q->where('module_key', 'encuesta')->where('status', 'completed'))
            ->with(['progress' => fn ($q) => $q->where('module_key', 'encuesta')])
            ->orderByDesc('id')->get()
            ->map(function ($u) {
                $enc = optional($u->progress->firstWhere('module_key', 'encuesta'))->etapas ?? [];
                $vals = array_values(array_filter(array_map('intval', $enc['respuestas'] ?? []), fn ($v) => $v > 0));
                return [
                    'nombre'        => trim($u->name.' '.($u->last_name ?? '')) ?: '—',
                    'email'         => $u->email,
                    'is_test'       => (bool) $u->is_test,
                    'valoraciones'  => $enc['respuestas'] ?? [],
                    'observaciones' => trim((string) ($enc['observaciones'] ?? '')),
                    'media'         => count($vals) ? round(array_sum($vals) / count($vals), 1) : null,
                    'completada'    => optional(optional($u->progress->firstWhere('module_key', 'encuesta'))->completed_at),
                ];
            });

        return view('admin.encuestas', compact('dims', 'rows'));
    }

    /** Apartado con TODAS las preguntas de los ingresos: % de acierto y nº de respuestas. */
    public function preguntas()
    {
        $r = \App\Support\CourseReport::build();
        $preguntas = $r['todasPreguntas'] ?? [];

        return view('admin.preguntas', compact('preguntas'));
    }

    /**
     * Catálogo de correos automáticos de la plataforma (para revisión del cliente).
     * Cada entrada enlaza a una vista previa renderizada con imágenes y datos de ejemplo.
     */
    public function correos()
    {
        $correos = self::catalogoCorreos();

        return view('admin.correos', compact('correos'));
    }

    /** Vista previa de un correo concreto (HTML final, con imágenes y datos de ejemplo). */
    public function correoPreview(string $plantilla)
    {
        $catalogo = self::catalogoCorreos();
        abort_unless(isset($catalogo[$plantilla]), 404);

        $html = \App\Mail\CorreoPlantilla::construirHtml($plantilla, [
            'nombre'       => 'María',
            'cta_url'      => url('/login'),
            'fecha_cierre' => config('curso.correos.fecha_cierre'),
        ]);

        return response($html);
    }

    /** Definición de los 6 correos automáticos (clave de plantilla => metadatos). */
    private static function catalogoCorreos(): array
    {
        return [
            '01-bienvenida'       => ['asunto' => 'Tu inscripción en Lp(a)ction está confirmada', 'cuando' => 'Al registrarse un nuevo usuario.'],
            '02-password-reset'   => ['asunto' => 'Restablece tu contraseña de Lp(a)ction', 'cuando' => 'Al solicitar "Recuperar contraseña".'],
            '03-completa-curso'   => ['asunto' => 'Te esperamos para que completes el curso', 'cuando' => 'Recordatorio a quienes empezaron y no han terminado.'],
            '04-modulo3'          => ['asunto' => '¡Ya está disponible el módulo 3!', 'cuando' => 'Al liberar el módulo 3 (envío manual).'],
            '05-faltan-2-semanas' => ['asunto' => 'Faltan 2 semanas para finalizar Lp(a)ction', 'cuando' => '2 semanas antes del cierre del curso.'],
            '06-faltan-48h'       => ['asunto' => 'Faltan 48 horas para finalizar Lp(a)ction', 'cuando' => '48 horas antes del cierre del curso.'],
        ];
    }

    /** Marca/desmarca a un alumno como cuenta de PRUEBA (excluida de las métricas). */
    public function toggleTest(User $user)
    {
        abort_if($user->is_admin, 404); // los admins no aparecen en la tabla

        $user->is_test = ! $user->is_test;
        $user->save();

        return redirect()->route('admin');
    }

    /** Marca/desmarca a un alumno como médico SELECCIONADO → recibe el certificado ICOMEM
     *  (los no marcados reciben el certificado CASEC de la SEC, que es el de por defecto). */
    public function toggleCertIcomem(User $user)
    {
        abort_if($user->is_admin, 404); // los admins no aparecen en la tabla

        $user->cert_icomem = ! $user->cert_icomem;
        $user->save();

        return redirect()->route('admin');
    }

    /** Des-registra a un alumno: BORRA su cuenta (y su progreso) para que vuelva a figurar como
     *  PENDIENTE y pueda inscribirse de nuevo. Solo administradores. */
    public function desregistrar(User $user)
    {
        abort_if($user->is_admin, 404);

        $email = $user->email;
        $user->progress()->delete();
        $user->delete();

        return back()->with('status', "Se des-registró a {$email}: ahora figura como pendiente y puede volver a inscribirse.");
    }

    /** Descarga del informe final del curso (PDF maqueta con datos simulados). Solo administradores. */
    public function informe()
    {
        $path = $this->informePath();
        abort_unless(is_file($path), 404);

        return response()->download($path, 'Informe_final_LPaction.pdf');
    }

    /** Informe final DINÁMICO: mismos indicadores del PDF pero con los datos reales de la plataforma. */
    public function informeDinamico()
    {
        $r = \App\Support\CourseReport::build();

        return view('admin.informe', compact('r'));
    }

    /** Ruta en disco del PDF del informe final. */
    private function informePath(): string
    {
        return storage_path('app/informes/informe-final-lpaction.pdf');
    }
}
