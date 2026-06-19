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

        // Resultados por etapa: { key: { verde, rojo } }. estado del sidebar = error si rojo>0.
        $resultados = $progreso->etapas ?? [];

        // Estados del sidebar: perfecta (check) / error (cruz) / activa (reloj) / bloqueada (candado).
        $etapasEstado = collect($etapas)->map(function ($e, $i) use ($etapaIndex, $viewIndex, $resultados) {
            if ($i > $etapaIndex) {
                $estado = 'bloqueada';
            } elseif ($i === $etapaIndex) {
                $estado = 'activa';
            } else {
                $estado = ((int) ($resultados[$e['key']]['rojo'] ?? 0) > 0) ? 'error' : 'perfecta';
            }
            return array_merge($e, ['estado' => $estado, 'viendo' => $i === $viewIndex]);
        })->all();

        // Score (contrapeso): verde = puntos de correctas, rojo = penalizaciones (NO se recupera).
        // EXP = verde - rojo. La base excluye la etapa que se ve (sus puntos se suman en vivo en el JS).
        $totalVerde = array_sum(array_map(fn ($r) => (int) ($r['verde'] ?? 0), $resultados));
        $totalRojo  = array_sum(array_map(fn ($r) => (int) ($r['rojo']  ?? 0), $resultados));
        $verdeBase  = $totalVerde - (int) ($resultados[$etapaActual]['verde'] ?? 0);
        $rojoBase   = $totalRojo  - (int) ($resultados[$etapaActual]['rojo']  ?? 0);
        $exp        = $verdeBase - $rojoBase;

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
            'exp', 'verdeBase', 'rojoBase', 'maxScore', 'score', 'medalla', 'mostrarResultado'
        ));
    }

    /** "Siguiente etapa": avanza desde la etapa que se está viendo. */
    public function avanzar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $etapas = config('curso.etapas');

        // Avanza desde la etapa indicada (la que se ve); si no llega, desde la actual.
        $desde = array_search($request->input('desde'), array_column($etapas, 'key'), true);
        if ($desde === false) {
            $desde = (int) ($progreso->etapa_index ?? 0);
        }

        // Guarda el resultado de la etapa que se deja: perfecta (sin errores) o error (eligió mal),
        // y los puntos obtenidos. Las etapas sin cuestionario no envían 'resultado' → perfecta/0.
        $resultados = $progreso->etapas ?? [];
        $resultados[$etapas[$desde]['key']] = [
            'verde' => max(0, (int) $request->input('verde', 0)),
            'rojo'  => max(0, (int) $request->input('rojo', 0)),
        ];

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

    /** "Reiniciar capítulo": reinicia todo el ingreso y vuelve a la Presentación. */
    public function reiniciar(Request $request, $ingreso)
    {
        $user = Auth::user();
        $progreso = $this->ingresoAbierto($user, $ingreso);

        $progreso->update([
            'etapa_index'  => 0,
            'status'       => 'in_progress',
            'percent'      => 0,
            'completed_at' => null,
            'etapas'       => null,
        ]);

        $etapas = config('curso.etapas');
        return redirect()->route('curso.etapa', [$ingreso, $etapas[0]['key']]);
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
