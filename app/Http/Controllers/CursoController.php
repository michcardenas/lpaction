<?php

namespace App\Http\Controllers;

use App\Models\CourseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    /** Página del curso "La evolución de Juan". */
    public function index()
    {
        $user = Auth::user();

        // Red de seguridad: si por algún motivo no tiene progreso, se siembra.
        CourseProgress::seedFor($user);

        // module_key => CourseProgress
        $progress = $user->progress()->get()->keyBy('module_key');

        $curso = config('curso');

        // Paciente ACTIVO: el Juan cambia según en qué ingreso esté el usuario.
        // - En Ingreso 1 (in_progress o completed sin haber empezado el 2): Juan 52 años, fumador.
        // - En Ingreso 2 (disponible/in_progress/completed): Juan 53 años, exfumador.
        // - En Ingreso 3 (cuando exista): idem.
        $pacienteActivo = $this->pacienteActivo($curso, $progress);

        return view('curso.index', compact('user', 'curso', 'progress', 'pacienteActivo'));
    }

    /**
     * Determina qué paciente (imagen + datos) mostrar en el portal según el estado de los ingresos.
     * Refleja "La evolución de Juan": la imagen cambia conforme el usuario avanza.
     *
     * Reglas (confirmadas con el cliente):
     *  - Ingreso 1 activo                       → Juan polo oscuro    (paciente)
     *  - Ingreso 2 recién activado (0% avance)  → Juan polo a rayas   (paciente_2, imagen)
     *  - Ingreso 2 EN PROGRESO (>0% avance)     → Juan camisa gris    (paciente_2, imagen_progreso)
     *  - Ingreso 2 COMPLETADO/aprobado          → Juan sano           (paciente_2, imagen_completado)
     *
     * Devuelve la variante del ingreso más avanzado que ya esté al menos disponible.
     */
    private function pacienteActivo(array $curso, $progress): array
    {
        $ingresos = $curso['ingresos'] ?? [];
        $activo = $curso['paciente'];   // fallback: Ingreso 1

        foreach ($ingresos as $idx => $ing) {
            $p = $progress[$ing['key']] ?? null;
            if (! $p) continue;
            // Un ingreso "activa" su paciente cuando ya está disponible/en curso/completado.
            if (! in_array($p->status, ['available', 'in_progress', 'completed'])) continue;

            if ($idx === 0) {
                $activo = $curso['paciente'] ?? $activo;
                continue;
            }

            $key = 'paciente_'.($idx + 1);
            if (! isset($curso[$key])) continue;

            $variante = $curso[$key];
            // Juan evoluciona ENTRE ingresos, no dentro de uno: mientras estés en el ingreso 2
            // se ve el Juan del ingreso 2. Solo al COMPLETARLO pasa a su imagen final (y en cuanto
            // se desbloquea el siguiente ingreso, este bucle ya toma el paciente de ese ingreso).
            // Antes, a mitad del ingreso se mostraba `imagen_progreso`, que el cliente leía como
            // "el Juan del ingreso siguiente".
            if ($p->status === 'completed' && ! empty($variante['imagen_completado'])) {
                $variante['imagen'] = $variante['imagen_completado'];
            }
            $activo = $variante;
        }
        return $activo;
    }

    /**
     * Devuelve la config del paciente que corresponde a un ingreso concreto (por su posición).
     * Ingreso 1 → paciente base; Ingreso 2 → paciente_2 (Juan a rayas); Ingreso 3 → paciente_3; etc.
     * Se usa DENTRO de las etapas del caso, donde la imagen NO evoluciona con el progreso:
     * en el segundo ingreso siempre se ve al Juan del segundo ingreso.
     */
    private function pacienteDeIngreso(array $curso, string $ingreso): array
    {
        $idx = array_search($ingreso, array_column($curso['ingresos'] ?? [], 'key'), true);
        if ($idx === false || $idx === 0) return $curso['paciente'];
        $key = 'paciente_'.($idx + 1);
        return $curso[$key] ?? $curso['paciente'];
    }

    /** Pantalla de intro a la evaluación final (certificación). */
    public function evaluacion()
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);

        // La evaluación final exige TODOS los ingresos completados al 100% (incluido el 3).
        if (! $this->todosLosIngresosCompletados($user)) {
            return redirect()->route('curso');
        }

        $cfg = config('curso.evaluacion');
        $maxIntentos = (int) ($cfg['max_intentos'] ?? 2);

        $prog = $user->progress()->where('module_key', 'evaluacion')->first();
        $meta = $prog->etapas ?? [];
        $intentos = (int) ($meta['intentos'] ?? 0);
        $apto     = (bool) ($meta['apto'] ?? false);
        // Nota mostrada: "SN" (sin nota) si aún no se ha hecho; si no, la última nota sobre el total.
        $nota = isset($meta['ultima_nota'])
            ? $meta['ultima_nota'].' / '.($cfg['tomar'] ?? 10)
            : 'SN';

        // La evaluación SOLO se puede comenzar tras completar la encuesta de satisfacción.
        $encuestaProg  = $user->progress()->where('module_key', 'encuesta')->first();
        $encuestaHecha = $encuestaProg && $encuestaProg->status === 'completed';

        return view('curso.evaluacion', compact('user', 'intentos', 'maxIntentos', 'nota', 'apto', 'encuestaHecha'));
    }

    /** Inicia un intento del examen: escoge N preguntas al azar y guarda el estado en sesión. */
    public function evaluacionComenzar(Request $request)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);

        // Guard: no se puede empezar la evaluación sin tener TODOS los ingresos completados.
        if (! $this->todosLosIngresosCompletados($user)) {
            return redirect()->route('curso');
        }

        $cfg     = config('curso.evaluacion');
        $todas   = $cfg['preguntas'] ?? [];
        $tomar   = min((int) ($cfg['tomar'] ?? 10), count($todas));
        $maxInt  = (int) ($cfg['max_intentos'] ?? 2);

        // Guard: la encuesta de satisfacción es OBLIGATORIA antes de comenzar la evaluación.
        $encuestaProg = $user->progress()->where('module_key', 'encuesta')->first();
        if (! ($encuestaProg && $encuestaProg->status === 'completed')) {
            return redirect()->route('encuesta');
        }

        $prog = $user->progress()->where('module_key', 'evaluacion')->first();
        $meta = $prog->etapas ?? [];

        // Si ya aprobó o agotó los intentos, no se puede volver a empezar.
        if (! empty($meta['apto'])) {
            return redirect()->route('evaluacion.resultado');
        }
        if ((int) ($meta['intentos'] ?? 0) >= $maxInt) {
            return redirect()->route('evaluacion')->with('eval_error', 'Has agotado los intentos disponibles.');
        }

        // Escoge $tomar índices al azar del banco de preguntas.
        $indices = array_keys($todas);
        shuffle($indices);
        $sel = array_slice($indices, 0, $tomar);

        session()->put('eval', [
            'preguntas'  => $sel,   // índices en config.preguntas
            'pos'        => 0,
            'respuestas' => [],     // pos => letra elegida
        ]);

        return redirect()->route('evaluacion.pregunta');
    }

    /** Muestra la pregunta actual del intento en curso. */
    public function evaluacionPregunta()
    {
        $eval = session('eval');
        if (! $eval || empty($eval['preguntas'])) {
            return redirect()->route('evaluacion');
        }

        $cfg   = config('curso.evaluacion');
        $todas = $cfg['preguntas'] ?? [];
        $pos   = (int) $eval['pos'];
        $total = count($eval['preguntas']);

        if ($pos >= $total) {
            return redirect()->route('evaluacion.resultado');
        }

        $idx      = $eval['preguntas'][$pos];
        $pregunta = $todas[$idx] ?? null;
        if (! $pregunta) {
            return redirect()->route('evaluacion');
        }

        // Baraja el orden visual de las opciones (a-d) en cada carga, conservando la clave.
        $opciones = $pregunta['opciones'];
        $keys = array_keys($opciones);
        shuffle($keys);
        $opcionesBarajadas = [];
        foreach ($keys as $k) $opcionesBarajadas[$k] = $opciones[$k];

        $numero = $pos + 1;
        $seleccion = $eval['respuestas'][$pos] ?? null;

        return view('curso.evaluacion-pregunta', compact('pregunta', 'opcionesBarajadas', 'numero', 'total', 'seleccion'));
    }

    /** Guarda la respuesta de la pregunta actual y avanza (o califica si es la última). */
    public function evaluacionResponder(Request $request)
    {
        $eval = session('eval');
        if (! $eval || empty($eval['preguntas'])) {
            return redirect()->route('evaluacion');
        }

        $pos = (int) $eval['pos'];
        $sel = (string) $request->input('opcion', '');
        if (in_array($sel, ['a', 'b', 'c', 'd'], true)) {
            $eval['respuestas'][$pos] = $sel;
        }
        $eval['pos'] = $pos + 1;
        session()->put('eval', $eval);

        if ($eval['pos'] >= count($eval['preguntas'])) {
            return $this->calificarEvaluacion();
        }
        return redirect()->route('evaluacion.pregunta');
    }

    /** Califica el intento, persiste el resultado y desbloquea el diploma si es APTO. */
    private function calificarEvaluacion()
    {
        $user = Auth::user();
        $eval = session('eval');
        $cfg  = config('curso.evaluacion');
        $todas = $cfg['preguntas'] ?? [];
        $aprobarPct = (int) ($cfg['aprobar_pct'] ?? 80);
        $total = count($eval['preguntas']);

        $aciertos = 0;
        $detalle  = [];   // detalle por pregunta para la pantalla "Ver respuestas"
        foreach ($eval['preguntas'] as $pos => $idx) {
            $q = $todas[$idx];
            $correcta = $q['correcta'] ?? null;
            $elegida  = $eval['respuestas'][$pos] ?? null;
            if ($elegida === $correcta) $aciertos++;
            $detalle[] = [
                'enunciado' => $q['enunciado'],
                'opciones'  => $q['opciones'],
                'correcta'  => $correcta,
                'elegida'   => $elegida,
            ];
        }
        $pct  = $total > 0 ? round($aciertos / $total * 100) : 0;
        $apto = $pct >= $aprobarPct;

        // Persiste en la fila 'evaluacion' de course_progress.
        $prog = $user->progress()->where('module_key', 'evaluacion')->first();
        $meta = $prog->etapas ?? [];
        $meta['intentos']    = (int) ($meta['intentos'] ?? 0) + 1;
        $meta['ultima_nota'] = $aciertos;
        $meta['ultimo_pct']  = $pct;
        $meta['apto']        = (bool) ($meta['apto'] ?? false) || $apto;   // una vez APTO, se queda
        $prog->update([
            'etapas'       => $meta,
            'status'       => $meta['apto'] ? 'completed' : 'in_progress',
            'percent'      => $pct,
            'completed_at' => $meta['apto'] ? now() : null,
        ]);

        // APTO → desbloquea el diploma.
        if ($meta['apto']) {
            $diploma = $user->progress()->where('module_key', 'diploma')->first();
            if ($diploma && $diploma->status === 'locked') {
                $diploma->update(['status' => 'available']);
            }
        }

        // Guarda el resumen del intento para la pantalla de resultado y limpia el estado en curso.
        session()->put('eval_result', [
            'aciertos' => $aciertos, 'total' => $total, 'pct' => $pct,
            'apto' => $apto, 'intentos' => $meta['intentos'],
            'max_intentos' => (int) ($cfg['max_intentos'] ?? 2),
            'aprobar_pct' => $aprobarPct,
            'detalle' => $detalle,
        ]);
        session()->forget('eval');

        return redirect()->route('evaluacion.resultado');
    }

    /** Pantalla de resultado del examen (APTO / NO APTA). */
    public function evaluacionResultado()
    {
        $res = session('eval_result');
        if (! $res) {
            return redirect()->route('evaluacion');
        }
        return view('curso.evaluacion-resultado', compact('res'));
    }

    /** Encuesta de satisfacción (13 ítems con estrellas + observaciones). */
    public function encuesta()
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);
        $cfg = config('curso.encuesta');

        // Si ya la completó, se muestran sus valoraciones (solo lectura no obligatoria).
        $prog = $user->progress()->where('module_key', 'encuesta')->first();
        $respuestas = $prog->etapas['respuestas'] ?? [];

        return view('curso.encuesta', compact('cfg', 'respuestas'));
    }

    /** Guarda la encuesta de satisfacción. */
    public function encuestaGuardar(Request $request)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);
        $cfg = config('curso.encuesta');
        $total = count($cfg['items'] ?? []);

        $valoraciones = [];
        for ($i = 0; $i < $total; $i++) {
            $v = (int) $request->input('estrella_'.$i, 0);
            $valoraciones[$i] = max(0, min(5, $v));
        }
        $observaciones = trim((string) $request->input('observaciones', ''));

        $prog = $user->progress()->where('module_key', 'encuesta')->firstOrCreate(
            ['module_key' => 'encuesta'], ['status' => 'available', 'percent' => 0]
        );
        $prog->update([
            'status'       => 'completed',
            'percent'      => 100,
            'completed_at' => now(),
            'etapas'       => ['respuestas' => $valoraciones, 'observaciones' => $observaciones],
        ]);

        // Tras enviar la encuesta → a la evaluación final (flujo del cliente: encuesta habilita el examen).
        return redirect()->route('evaluacion')->with('encuesta_ok', true);
    }

    /**
     * Diploma / certificado UEMS-ICOMEN del curso. Se genera con los datos del alumno
     * y los datos de acreditación de config('curso.diploma'). Solo accesible cuando el
     * diploma está desbloqueado (evaluación final APTO). La descarga en PDF la hace el
     * navegador (window.print → "Guardar como PDF"), que respeta el @page A4 apaisado.
     */
    public function diploma()
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);

        // Guard: el diploma solo está disponible tras aprobar la evaluación (status ≠ locked).
        $prog = $user->progress()->where('module_key', 'diploma')->first();
        if (! $prog || $prog->status === 'locked') {
            return redirect()->route('curso')->with('diploma_error', 'Aún no has desbloqueado el diploma. Aprueba la evaluación final para obtenerlo.');
        }

        $cfg = config('curso.diploma', []);

        // Fecha de emisión: cuándo aprobó la evaluación (o, en su defecto, hoy).
        $eval = $user->progress()->where('module_key', 'evaluacion')->first();
        $emision = optional($eval)->completed_at ?? now();

        $diploma = [
            'nombre'             => trim((string) $user->name),
            'apellidos'          => trim((string) ($user->last_name ?? '')),
            'documento'          => trim((string) ($user->document_id ?? '')),
            'curso'              => 'Programa formativo Lp(a)ction',
            'fecha_inicio'       => $cfg['fecha_inicio'] ?? '',
            'fecha_fin'          => $cfg['fecha_fin'] ?? '',
            'horas'              => $cfg['horas'] ?? '',
            'creditos'           => $cfg['creditos'] ?? '',
            'registro_uems'      => $cfg['registro_uems'] ?? '',
            'registro_seaformec' => $cfg['registro_seaformec'] ?? '',
            'fecha_emision'      => $this->fechaLarga($emision),
        ];

        return view('curso.diploma', compact('diploma'));
    }

    /**
     * Resumen descargable del caso de un ingreso: enunciados, todas las opciones con la(s)
     * correcta(s) marcada(s) y la respuesta del alumno, más su puntuación y medalla.
     * Se abre como página imprimible (window.print → "Guardar como PDF").
     */
    /**
     * "Descargar caso": entrega el documento OFICIAL del caso (PDF/Word de la carpeta compartida),
     * no el resumen generado. Un archivo por ingreso en public/casos/ (caso-ingreso-N.pdf|docx).
     */
    public function descargarCaso($ingreso)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);
        $this->ingresoAbierto($user, $ingreso);   // 404 si el ingreso no está abierto para el usuario

        // Archivo subido desde el panel (override), si existe.
        $ov = \App\Support\Cms::raw('curso.cont.'.$ingreso.'.resumen.archivo');
        if ($ov && is_file(public_path($ov))) {
            $ruta = public_path($ov);
        } else {
            // Documento oficial por defecto (ingreso-3 es Word; 1 y 2, PDF).
            $mapa = [
                'ingreso-1' => 'caso-ingreso-1.pdf',
                'ingreso-2' => 'caso-ingreso-2.pdf',
                'ingreso-3' => 'caso-ingreso-3.docx',
            ];
            $archivo = $mapa[$ingreso] ?? null;
            abort_if($archivo === null, 404);
            $ruta = public_path('casos/'.$archivo);
            abort_unless(is_file($ruta), 404);
        }

        // Nombre amigable de descarga.
        $n = str_replace('ingreso-', '', $ingreso);
        $ext = pathinfo($ruta, PATHINFO_EXTENSION);
        return response()->download($ruta, 'Caso clinico - Ingreso '.$n.'.'.$ext);
    }

    public function resumenCaso($ingreso)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);
        $progreso = $this->ingresoAbierto($user, $ingreso);   // 404 si el ingreso no está abierto

        $curso      = config('curso');
        $etapas     = $this->etapasDe($ingreso);
        $resultados = $progreso->etapas ?? [];

        $ingresoData = collect($curso['ingresos'])->firstWhere('key', $ingreso);
        $paciente    = $this->pacienteDeIngreso($curso, $ingreso);

        // Preguntas del ingreso con sus opciones (correcta / elegida por el alumno).
        $preguntas = [];
        foreach ($this->etapasConPregunta($ingreso) as $st) {
            $pk = $this->preguntaKey($ingreso, $st);
            if (! $pk || empty($curso[$pk]['opciones'])) continue;

            $q   = $curso[$pk];
            $sel = $resultados[$st]['sel'] ?? [];
            $opciones = [];
            foreach ($q['opciones'] as $op) {
                $pts = (int) ($op['puntos'] ?? 0);
                $opciones[] = [
                    'texto'    => $op['texto'],
                    'correcta' => $pts > 0,
                    'elegida'  => in_array($op['key'], $sel, true),
                    'puntos'   => $pts,
                ];
            }
            $preguntas[] = [
                'etapa'     => collect($etapas)->firstWhere('key', $st)['titulo'] ?? $st,
                'enunciado' => $q['enunciado'],
                'opciones'  => $opciones,
            ];
        }

        // Puntuación total y medalla obtenida.
        $totalVerde = array_sum(array_map(fn ($r) => (int) ($r['verde'] ?? 0), $resultados));
        $totalRojo  = array_sum(array_map(fn ($r) => (int) ($r['rojo']  ?? 0), $resultados));
        $score = $totalVerde - $totalRojo;
        $maxScore = 0;
        foreach ($this->etapasConPregunta($ingreso) as $stage) {
            $pk = $this->preguntaKey($ingreso, $stage);
            foreach (($curso[$pk]['opciones'] ?? []) as $op) {
                if (($op['puntos'] ?? 0) > 0) $maxScore += (int) $op['puntos'];
            }
        }
        $medalla = $curso['medallas'][0];
        foreach ($curso['medallas'] as $m) {
            if ($score >= $m['min']) $medalla = $m;
        }

        $resumen = [
            'ingreso'   => $ingresoData,
            'paciente'  => $paciente,
            'preguntas' => $preguntas,
            'verde'     => $totalVerde,
            'rojo'      => $totalRojo,
            'score'     => $score,
            'maxScore'  => $maxScore,
            'medalla'   => $medalla,
            'completado'=> $progreso->status === 'completed',
            'alumno'    => trim($user->name.' '.($user->last_name ?? '')),
        ];

        return view('curso.resumen-caso', compact('resumen', 'ingreso'));
    }

    /** Formatea una fecha como "20 de julio de 2026" (es_ES) sin depender de locale del sistema. */
    private function fechaLarga($fecha): string
    {
        $meses = [1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                  'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        return $fecha->day.' de '.$meses[(int) $fecha->month].' de '.$fecha->year;
    }

    /** Etapa de un ingreso (Presentación, Pruebas complementarias, …). */
    public function etapa($ingreso, $etapa = null)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);
        // Aplica los textos editados desde el panel (preguntas). Lo estructural no cambia.
        $curso = \App\Support\CursoCms::aplicar(config('curso'));

        $progreso = $this->ingresoAbierto($user, $ingreso);
        $etapas   = $this->etapasDe($ingreso);
        $etapas   = \App\Support\CursoCms::aplicarEtapas($ingreso, $etapas);   // títulos de menú editados
        $etapaIndex = (int) ($progreso->etapa_index ?? 0);   // etapa más lejana alcanzada

        // Etapa que se ve: la pedida (si está desbloqueada) o la actual.
        $viewIndex = $etapaIndex;
        if ($etapa !== null) {
            $req = array_search($etapa, array_column($etapas, 'key'), true);
            if ($req === false) abort(404);
            if ($req > $etapaIndex) {
                return redirect()->route('curso.etapa', [$ingreso, $etapas[$etapaIndex]['key']]);
            }
            $viewIndex = $req;
        }
        $etapaActual = $etapas[$viewIndex]['key'];

        // Resultados por etapa: { key: { verde, rojo, sel } }. estado del sidebar = error si rojo>0.
        $resultados = $progreso->etapas ?? [];

        // Opciones ya marcadas en esta etapa (para re-pintarlas al volver: el rojo permanece).
        $preSel = $resultados[$etapaActual]['sel'] ?? [];

        // ¿Esta etapa tiene un fallo guardado? → se muestra "Reiniciar capítulo" (en perfecta queda bloqueado).
        $etapaTieneError = (int) ($resultados[$etapaActual]['rojo'] ?? 0) > 0;

        // Estados del sidebar: perfecta (check) / error (cruz) / activa (reloj) / bloqueada (candado).
        // La cruz (error) aparece en cuanto la etapa tiene rojo>0, AUNQUE siga siendo la activa
        // (el fallo se guarda al "Comprobar", no hace falta avanzar). El rojo es permanente.
        // Cuando el ingreso está COMPLETADO, ya no hay etapa "activa": todas las superadas
        // quedan con check verde (perfecta), incluida la última (Resumen del caso).
        $completado = $progreso->status === 'completed';
        $etapasEstado = collect($etapas)->map(function ($e, $i) use ($etapaIndex, $viewIndex, $resultados, $completado) {
            $tieneError = (int) ($resultados[$e['key']]['rojo'] ?? 0) > 0;
            // Etapa en RE-TRABAJO ("Repetir etapa" pulsado): mientras NO se haya respondido queda
            // SIN icono ('pendiente'). En cuanto se comprueba una respuesta, el icono refleja el
            // resultado igual que siempre: ✗ si falla (rojo>0) o ✓ si acierta. (La etapa sigue
            // editable hasta "Siguiente etapa" gracias a $enReTrabajo, no por el icono.)
            $repitiendo = ! empty($resultados[$e['key']]['repitiendo']);
            $tieneSel   = ! empty($resultados[$e['key']]['sel']);
            if ($i > $etapaIndex) {
                $estado = 'bloqueada';
            } elseif ($repitiendo && ! $tieneSel && ! $completado) {
                $estado = 'pendiente';   // repetida y aún SIN responder → sin icono
            } elseif ($tieneError) {
                $estado = 'error';       // respondió mal → ✗ (al comprobar, aunque siga en re-trabajo)
            } elseif ($i === $etapaIndex && ! $completado) {
                $estado = 'activa';
            } else {
                $estado = 'perfecta';    // respondió bien → ✓
            }
            return array_merge($e, ['estado' => $estado, 'viendo' => $i === $viewIndex]);
        })->all();

        // "Repetir etapa" solo al VOLVER a una etapa ya superada (no en el primer intento, aunque haya error).
        $reevaluando = $viewIndex < $etapaIndex;

        // Etapa en RE-TRABAJO (se pulsó "Repetir etapa" y aún no se confirmó con "Siguiente etapa"):
        // debe quedar EDITABLE (no modo revisión) aunque se haya navegado a otra etapa y vuelto.
        $enReTrabajo = ! empty($resultados[$etapaActual]['repitiendo']) && ! $completado;
        if ($enReTrabajo) {
            $reevaluando = false;   // sin modo revisión: se puede volver a comprobar
        }

        // Caso FINALIZADO: SOLO cuando el ingreso se cerró de verdad ("Finalizar ingreso" → status
        // completed). Mientras el caso siga abierto, las etapas con fallo pueden repetirse aunque
        // ya se haya pasado la última pregunta (antes se bloqueaba solo por pasar monitorizacion-2).
        $casoFinalizado = $completado;

        // Score (contrapeso): verde = puntos de correctas, rojo = penalizaciones (NO se recupera).
        // Score = verde - rojo. La base es el TOTAL completo (incluida la etapa que se ve si ya se respondió),
        // así devolverse a una etapa nunca baja el Score. El JS solo SUMA las opciones nuevas de esta visita.
        $totalVerde = array_sum(array_map(fn ($r) => (int) ($r['verde'] ?? 0), $resultados));
        $totalRojo  = array_sum(array_map(fn ($r) => (int) ($r['rojo']  ?? 0), $resultados));
        $verdeBase  = $totalVerde;
        $rojoBase   = $totalRojo;
        $exp        = $totalVerde - $totalRojo;

        // Máximo del score = suma de los puntos de TODAS las opciones correctas del ingreso.
        // Cada ingreso tiene su propio set de preguntas (sufijo _2 para ingreso-2, etc.).
        $maxScore = 0;
        foreach ($this->etapasConPregunta($ingreso) as $stage) {
            $pk = $this->preguntaKey($ingreso, $stage);
            foreach (($curso[$pk]['opciones'] ?? []) as $op) {
                if (($op['puntos'] ?? 0) > 0) $maxScore += (int) $op['puntos'];
            }
        }

        // Medalla según el Score total (para el pop-up de "finalizar caso", que va sobre la etapa).
        $score = $totalVerde - $totalRojo;
        $medalla = $curso['medallas'][0];
        foreach ($curso['medallas'] as $m) {
            if ($score >= $m['min']) $medalla = $m;
        }
        $mostrarResultado = request()->boolean('resultado');

        $ingresoData  = collect($curso['ingresos'])->firstWhere('key', $ingreso);
        $esUltimaEtapa = $viewIndex >= count($etapas) - 1;
        // Avance del caso: 100% cuando el ingreso está completado (pulsó "Finalizar ingreso").
        $avance = $completado ? 100 : (int) round($etapaIndex / max(count($etapas), 1) * 100);

        // Paciente del ingreso que se está viendo: dentro del Ingreso 2 se ve al Juan del Ingreso 2
        // (polo a rayas), en el 3 al del 3, etc. — independientemente del progreso.
        $pacienteIngreso = $this->pacienteDeIngreso($curso, $ingreso);

        // Última etapa CON pregunta de ESTE ingreso (dispara "Finalizar caso" y la medalla).
        $ultimaPreguntaKey = $this->ultimaPreguntaKey($ingreso);

        return view('curso.etapa', compact(
            'user', 'curso', 'ingreso', 'ingresoData', 'etapaActual', 'etapasEstado', 'esUltimaEtapa', 'avance',
            'exp', 'verdeBase', 'rojoBase', 'maxScore', 'score', 'medalla', 'mostrarResultado', 'preSel', 'reevaluando', 'etapaTieneError', 'casoFinalizado', 'pacienteIngreso', 'ultimaPreguntaKey', 'enReTrabajo'
        ));
    }

    /** "Siguiente etapa": avanza desde la etapa que se está viendo. */
    public function avanzar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $curso  = config('curso');
        $etapas = $this->etapasDe($ingreso);

        // Avanza desde la etapa indicada (la que se ve); si no llega, desde la actual.
        $desde = array_search($request->input('desde'), array_column($etapas, 'key'), true);
        if ($desde === false) {
            $desde = (int) ($progreso->etapa_index ?? 0);
        }

        // Guarda el resultado de la etapa que se deja. Las opciones marcadas se ACUMULAN (unión)
        // con las de intentos previos: así el rojo es permanente (mide lo errado) y al volver a una
        // pregunta y acertar se recuperan puntos (verde), pero la marca roja no desaparece.
        // El puntaje se calcula en el servidor desde la config (+50 correcta / -50 incorrecta).
        $resultados = $progreso->etapas ?? [];
        $stageKey   = $etapas[$desde]['key'];
        $prevSel    = $resultados[$stageKey]['sel'] ?? [];
        $rojoFloor  = (int) ($resultados[$stageKey]['rfloor'] ?? 0);   // rojo permanente de repeticiones previas
        $sentSel    = array_filter(array_map('trim', explode(',', (string) $request->input('sel', ''))));
        $union      = array_values(array_unique(array_merge($prevSel, $sentSel)));
        $resultado  = $this->puntuarEtapa($curso, $ingreso, $stageKey, $union, $rojoFloor);
        // Etapas sin cuestionario: no piso lo guardado si no llega selección.
        if ($resultado['sel'] || isset($resultados[$stageKey])) {
            $resultados[$stageKey] = $resultado;
        }

        // ÚLTIMA PREGUNTA (Monitorización 2): "Finalizar caso" MUESTRA la medalla; todavía NO avanza.
        // El avance real lo confirma el modal re-enviando con confirmar=1.
        // OJO: solo la PRIMERA vez. Si el usuario ya pasó de esta etapa y vuelve a ella a revisar,
        // "Finalizar caso" debe avanzar normalmente; si no, el modal se repetía en bucle y el
        // botón parecía bloqueado (error reportado por el cliente).
        $yaAvanzado = (int) ($progreso->etapa_index ?? 0) > $desde;
        $ultimaPregunta = $this->ultimaPreguntaKey($ingreso);   // varía por ingreso
        if ($stageKey === $ultimaPregunta && ! $request->boolean('confirmar') && ! $yaAvanzado) {
            $progreso->update(['etapas' => $resultados, 'status' => 'in_progress']);
            return redirect()->route('curso.etapa', [$ingreso, $stageKey, 'resultado' => 1]);
        }

        // "Volver al temario" del modal de medalla (sin/bronce): desbloquea los capítulos finales
        // y lleva al último. Sin esto, esas medallas no tenían NINGÚN botón que avanzara y el
        // usuario quedaba atrapado en la pregunta (el enlace al último capítulo rebotaba).
        if ($request->input('hasta') === 'fin') {
            $ultimo = count($etapas) - 1;
            $progreso->update([
                'etapas'      => $resultados,
                'status'      => 'in_progress',
                'etapa_index' => max((int) ($progreso->etapa_index ?? 0), $ultimo),
            ]);
            return redirect()->route('curso.etapa', [$ingreso, $etapas[$ultimo]['key']]);
        }

        // Última etapa ("Finalizar ingreso"): el ingreso queda completado y se desbloquea el siguiente.
        if ($desde >= count($etapas) - 1) {
            $progreso->update([
                'status' => 'completed', 'percent' => 100, 'completed_at' => now(), 'etapas' => $resultados,
            ]);
            $this->desbloquearSiguienteIngreso($user, $ingreso);
            return redirect()->route('curso');   // la medalla va en la última pregunta, no aquí
        }

        $next = min($desde + 1, count($etapas) - 1);
        $progreso->update([
            'etapa_index' => max((int) ($progreso->etapa_index ?? 0), $next),
            'status'      => 'in_progress',
            'etapas'      => $resultados,
        ]);

        return redirect()->route('curso.etapa', [$ingreso, $etapas[$next]['key']]);
    }

    /**
     * "Comprobar": guarda al instante la(s) opción(es) marcadas de una etapa, SIN avanzar.
     * Así el Score y la cruz (rojo permanente) persisten aunque el usuario navegue a otra etapa
     * por el menú sin pulsar "Siguiente etapa". Devuelve los totales para el front (AJAX).
     */
    public function marcar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $curso  = config('curso');
        $etapas = $this->etapasDe($ingreso);

        $stageKey = (string) $request->input('etapa');
        $idx = array_search($stageKey, array_column($etapas, 'key'), true);
        abort_if($idx === false, 404);
        // No se puede marcar una etapa todavía bloqueada (más allá del progreso alcanzado).
        abort_if($idx > (int) ($progreso->etapa_index ?? 0), 403);

        $resultados = $progreso->etapas ?? [];
        $prevSel    = $resultados[$stageKey]['sel'] ?? [];
        $rojoFloor  = (int) ($resultados[$stageKey]['rfloor'] ?? 0);   // rojo permanente de repeticiones previas
        $sentSel    = array_filter(array_map('trim', explode(',', (string) $request->input('sel', ''))));
        $union      = array_values(array_unique(array_merge($prevSel, $sentSel)));
        $resultado  = $this->puntuarEtapa($curso, $ingreso, $stageKey, $union, $rojoFloor);

        // Mantener el estado de RE-TRABAJO ("Repetir etapa" pulsado) hasta que se confirme con
        // "Siguiente etapa". Así, al responder y volver a la etapa por el menú, sigue ACTIVA
        // (reloj + editable), no en modo revisión/bloqueada (error reportado por el cliente).
        if (! empty($resultados[$stageKey]['repitiendo'])) {
            $resultado['repitiendo'] = true;
        }

        if ($resultado['sel'] || isset($resultados[$stageKey])) {
            $resultados[$stageKey] = $resultado;
            $progreso->update(['etapas' => $resultados, 'status' => 'in_progress']);
        }

        $totalVerde = array_sum(array_map(fn ($r) => (int) ($r['verde'] ?? 0), $resultados));
        $totalRojo  = array_sum(array_map(fn ($r) => (int) ($r['rojo']  ?? 0), $resultados));

        return response()->json([
            'verde' => $totalVerde,
            'rojo'  => $totalRojo,
            'score' => $totalVerde - $totalRojo,
            'etapaError' => ($resultado['rojo'] ?? 0) > 0,
        ]);
    }

    /**
     * "Repetir etapa": reinicia por COMPLETO la puntuación del capítulo (verde = 0 y rojo = 0)
     * y deja la pregunta limpia para responderla de nuevo. Si luego se responde perfecto, la
     * etapa vuelve a quedar en verde (check) y el Score global se recalcula. (Decisión del
     * cliente jul-2026: repetir reinicia la puntuación; se eliminó el "piso" de rojo permanente.)
     */
    public function reiniciar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $etapas   = $this->etapasDe($ingreso);
        $etapaKey = (string) $request->input('etapa');
        $idx = array_search($etapaKey, array_column($etapas, 'key'), true);
        abort_if($idx === false, 404);

        $resultados = $progreso->etapas ?? [];
        if (isset($resultados[$etapaKey])) {
            // Reinicio TOTAL del capítulo: verde y rojo a 0, pregunta limpia (sin "piso" de rojo).
            // Así, al re-responder, las opciones vuelven a puntuar; si se responde perfecto, la
            // etapa queda en verde (check) y el botón "Repetir" se bloquea de nuevo.
            // 'repitiendo' deja la etapa SIN icono en el menú (ni ✓ ni ✗) hasta responder de nuevo;
            // se borra solo al persistir la nueva respuesta (marcar reemplaza la entrada completa).
            $resultados[$etapaKey] = ['verde' => 0, 'rojo' => 0, 'sel' => [], 'repitiendo' => true];
            $progreso->update(['etapas' => $resultados]);
        }

        return redirect()->route('curso.etapa', [$ingreso, $etapaKey]);
    }

    /**
     * Resuelve la clave de config para la pregunta de una etapa en un ingreso concreto.
     * Ingreso 1 usa las claves originales (pregunta_pruebas, ...); ingresos posteriores
     * usan el mismo nombre con sufijo (_2, _3). Devuelve null si la etapa no tiene pregunta.
     */
    private function preguntaKey(string $ingreso, string $etapaKey): ?string
    {
        $base = [
            'pruebas'          => 'pregunta_pruebas',
            'objetivos'        => 'pregunta_objetivos',    // solo ingreso 2
            'riesgo'           => 'pregunta_riesgo',
            'terapeutico'      => 'pregunta_terapeutico',
            'monitorizacion'   => 'pregunta_monitorizacion',
            'monitorizacion-2' => 'pregunta_monitorizacion2',
        ];
        $pk = $base[$etapaKey] ?? null;
        if ($pk === null) return null;
        // ingreso-1 usa el nombre plano; ingreso-N usa sufijo _N.
        if ($ingreso === 'ingreso-1') return $pk;
        if (preg_match('/^ingreso-(\d+)$/', $ingreso, $m)) return $pk.'_'.$m[1];
        return $pk;
    }

    /**
     * ¿El alumno ha completado TODOS los ingresos (los 3 al 100%)?
     * Es el requisito para abrir la evaluación final.
     */
    private function todosLosIngresosCompletados($user): bool
    {
        $claves = array_column(config('curso.ingresos', []), 'key');
        if (! $claves) return false;

        $completados = $user->progress()
            ->whereIn('module_key', $claves)
            ->where('status', 'completed')
            ->count();

        return $completados === count($claves);
    }

    /**
     * Etapas de un ingreso. Cada ingreso puede tener su propia lista (config `etapas_N`);
     * si no la define, usa la general. El Ingreso 2 añade "Objetivos lipídicos adicionales".
     */
    private function etapasDe(string $ingreso): array
    {
        if (preg_match('/^ingreso-(\d+)$/', $ingreso, $m)) {
            $propias = config('curso.etapas_'.$m[1]);
            if (is_array($propias) && $propias) return $propias;
        }
        return config('curso.etapas', []);
    }

    /** Etapas de ese ingreso que TIENEN cuestionario (en orden). */
    private function etapasConPregunta(string $ingreso): array
    {
        $curso = config('curso');
        $keys  = [];
        foreach ($this->etapasDe($ingreso) as $e) {
            $pk = $this->preguntaKey($ingreso, $e['key']);
            if ($pk && ! empty($curso[$pk]['opciones'])) $keys[] = $e['key'];
        }
        return $keys;
    }

    /**
     * Última etapa CON pregunta del ingreso: es la que dispara "Finalizar caso" y la medalla.
     * (En el Ingreso 2 es "monitorizacion", porque "monitorizacion-2" quedó solo con contenido.)
     */
    private function ultimaPreguntaKey(string $ingreso): ?string
    {
        $conPregunta = $this->etapasConPregunta($ingreso);
        return $conPregunta ? end($conPregunta) : null;
    }

    /**
     * Puntúa una etapa a partir de las opciones marcadas (claves) según la config.
     * Cada opción correcta suma sus puntos (positivos) al verde; cada incorrecta suma al rojo
     * el valor absoluto de su penalización. Score = verde - rojo.
     */
    private function puntuarEtapa(array $curso, string $ingreso, string $etapaKey, array $selKeys, int $rojoFloor = 0): array
    {
        $pk = $this->preguntaKey($ingreso, $etapaKey);
        if (! $pk || empty($curso[$pk]['opciones'])) {
            return ['verde' => 0, 'rojo' => $rojoFloor, 'sel' => [], 'rfloor' => $rojoFloor];
        }

        $ops = collect($curso[$pk]['opciones'])->keyBy('key');
        $verde = 0;
        $rojo  = 0;
        $clean = [];
        foreach ($selKeys as $k) {
            if (! isset($ops[$k])) continue;
            $clean[] = $k;
            // Puntuación REAL por opción (definida en config/curso.php, según el documento del cliente):
            // las correctas suman su valor POSITIVO al verde; las incorrectas suman al rojo el valor
            // ABSOLUTO de su penalización. (Antes se hardcodeaba ±50 para todo — eso era incorrecto.)
            $pts = (int) ($ops[$k]['puntos'] ?? 0);
            if ($pts > 0) {
                $verde += $pts;
            } elseif ($pts < 0) {
                $rojo += -$pts;
            }
        }

        // El rojo de intentos previos (rfloor) es PERMANENTE: se suma al de este intento.
        return ['verde' => $verde, 'rojo' => $rojoFloor + $rojo, 'sel' => array_values($clean), 'rfloor' => $rojoFloor];
    }

    /**
     * Desbloquea el siguiente ingreso en la secuencia (locked → available) cuando el usuario
     * completa el actual. Si es el último ingreso, no hay nada que desbloquear.
     */
    private function desbloquearSiguienteIngreso($user, string $ingresoActual): void
    {
        $ingresos = config('curso.ingresos', []);
        $idx = array_search($ingresoActual, array_column($ingresos, 'key'), true);
        if ($idx === false || $idx >= count($ingresos) - 1) return;

        $siguienteKey = $ingresos[$idx + 1]['key'];
        $sig = $user->progress()->where('module_key', $siguienteKey)->first();
        if ($sig && $sig->status === 'locked') {
            $sig->update(['status' => 'available']);
        }
    }

    /** Devuelve el progreso del ingreso si está desbloqueado; si no, 404. */
    private function ingresoAbierto($user, $ingreso): CourseProgress
    {
        $progreso = $user->progress()->where('module_key', $ingreso)->first();
        abort_unless(
            $progreso && in_array($progreso->status, ['available', 'in_progress', 'completed']),
            404
        );
        return $progreso;
    }
}
