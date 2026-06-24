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

        return view('curso.index', compact('user', 'curso', 'progress'));
    }

    /** Pantalla de intro a la evaluación final (certificación). */
    public function evaluacion()
    {
        $user = Auth::user();
        $intentos    = 0;
        $maxIntentos = 2;
        $nota        = 'SN';

        return view('curso.evaluacion', compact('user', 'intentos', 'maxIntentos', 'nota'));
    }

    /** Etapa de un ingreso (Presentación, Pruebas complementarias, …). */
    public function etapa($ingreso, $etapa = null)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);
        $curso = config('curso');

        $progreso = $this->ingresoAbierto($user, $ingreso);
        $etapas   = $curso['etapas'];
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
        $etapasEstado = collect($etapas)->map(function ($e, $i) use ($etapaIndex, $viewIndex, $resultados) {
            $tieneError = (int) ($resultados[$e['key']]['rojo'] ?? 0) > 0;
            if ($i > $etapaIndex) {
                $estado = 'bloqueada';
            } elseif ($tieneError) {
                $estado = 'error';
            } elseif ($i === $etapaIndex) {
                $estado = 'activa';
            } else {
                $estado = 'perfecta';
            }
            return array_merge($e, ['estado' => $estado, 'viendo' => $i === $viewIndex]);
        })->all();

        // "Repetir etapa" solo al VOLVER a una etapa ya superada (no en el primer intento, aunque haya error).
        $reevaluando = $viewIndex < $etapaIndex;

        // Score (contrapeso): verde = puntos de correctas, rojo = penalizaciones (NO se recupera).
        // Score = verde - rojo. La base es el TOTAL completo (incluida la etapa que se ve si ya se respondió),
        // así devolverse a una etapa nunca baja el Score. El JS solo SUMA las opciones nuevas de esta visita.
        $totalVerde = array_sum(array_map(fn ($r) => (int) ($r['verde'] ?? 0), $resultados));
        $totalRojo  = array_sum(array_map(fn ($r) => (int) ($r['rojo']  ?? 0), $resultados));
        $verdeBase  = $totalVerde;
        $rojoBase   = $totalRojo;
        $exp        = $totalVerde - $totalRojo;

        // Máximo del score = suma de los puntos de TODAS las opciones correctas del ingreso.
        $maxScore = 0;
        foreach (['pregunta_pruebas', 'pregunta_riesgo', 'pregunta_terapeutico', 'pregunta_monitorizacion', 'pregunta_monitorizacion2'] as $pk) {
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
        $avance = (int) round($etapaIndex / max(count($etapas), 1) * 100);

        return view('curso.etapa', compact(
            'user', 'curso', 'ingreso', 'ingresoData', 'etapaActual', 'etapasEstado', 'esUltimaEtapa', 'avance',
            'exp', 'verdeBase', 'rojoBase', 'maxScore', 'score', 'medalla', 'mostrarResultado', 'preSel', 'reevaluando', 'etapaTieneError'
        ));
    }

    /** "Siguiente etapa": avanza desde la etapa que se está viendo. */
    public function avanzar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $curso  = config('curso');
        $etapas = $curso['etapas'];

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
        $sentSel    = array_filter(array_map('trim', explode(',', (string) $request->input('sel', ''))));
        $union      = array_values(array_unique(array_merge($prevSel, $sentSel)));
        $resultado  = $this->puntuarEtapa($curso, $stageKey, $union);
        // Etapas sin cuestionario: no piso lo guardado si no llega selección.
        if ($resultado['sel'] || isset($resultados[$stageKey])) {
            $resultados[$stageKey] = $resultado;
        }

        // Última etapa: finaliza el ingreso y va a la evaluación final.
        if ($desde >= count($etapas) - 1) {
            $progreso->update([
                'status' => 'completed', 'percent' => 100, 'completed_at' => now(), 'etapas' => $resultados,
            ]);
            return redirect()->route('curso.etapa', [$ingreso, $etapas[count($etapas) - 1]['key'], 'resultado' => 1]);
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
        $etapas = $curso['etapas'];

        $stageKey = (string) $request->input('etapa');
        $idx = array_search($stageKey, array_column($etapas, 'key'), true);
        abort_if($idx === false, 404);
        // No se puede marcar una etapa todavía bloqueada (más allá del progreso alcanzado).
        abort_if($idx > (int) ($progreso->etapa_index ?? 0), 403);

        $resultados = $progreso->etapas ?? [];
        $prevSel    = $resultados[$stageKey]['sel'] ?? [];
        $sentSel    = array_filter(array_map('trim', explode(',', (string) $request->input('sel', ''))));
        $union      = array_values(array_unique(array_merge($prevSel, $sentSel)));
        $resultado  = $this->puntuarEtapa($curso, $stageKey, $union);

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
     * "Repetir etapa": reabre el capítulo para repasarlo o seguir respondiendo.
     * NO borra nada: el verde y el rojo ya acumulados se conservan (el rojo no se
     * recupera) y el score acumulado no cambia. Solo se vuelve a la etapa.
     */
    public function reiniciar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $etapas   = config('curso.etapas');
        $etapaKey = (string) $request->input('etapa');
        $idx = array_search($etapaKey, array_column($etapas, 'key'), true);
        abort_if($idx === false, 404);

        // Sin cambios en los puntos: solo se reabre la etapa (no se quita nada de lo ya hecho).
        return redirect()->route('curso.etapa', [$ingreso, $etapaKey]);
    }

    /**
     * Puntúa una etapa a partir de las opciones marcadas (claves) según la config.
     * Cada opción correcta suma 50 al verde; cada incorrecta suma 50 al rojo (Score = verde - rojo).
     * Devuelve también el set normalizado de opciones válidas, para persistir la marca.
     */
    private function puntuarEtapa(array $curso, string $etapaKey, array $selKeys): array
    {
        $map = [
            'pruebas'          => 'pregunta_pruebas',
            'riesgo'           => 'pregunta_riesgo',
            'terapeutico'      => 'pregunta_terapeutico',
            'monitorizacion'   => 'pregunta_monitorizacion',
            'monitorizacion-2' => 'pregunta_monitorizacion2',
        ];

        $pk = $map[$etapaKey] ?? null;
        if (! $pk || empty($curso[$pk]['opciones'])) {
            return ['verde' => 0, 'rojo' => 0, 'sel' => []];
        }

        $ops = collect($curso[$pk]['opciones'])->keyBy('key');
        $verde = 0;
        $rojo  = 0;
        $clean = [];
        foreach ($selKeys as $k) {
            if (! isset($ops[$k])) continue;
            $clean[] = $k;
            if (! empty($ops[$k]['correcta'])) {
                $verde += 50;
            } else {
                $rojo += 50;
            }
        }

        return ['verde' => $verde, 'rojo' => $rojo, 'sel' => array_values($clean)];
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
