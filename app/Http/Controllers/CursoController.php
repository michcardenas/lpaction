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

        // Estados del sidebar según el progreso.
        $etapasEstado = collect($etapas)->map(function ($e, $i) use ($etapaIndex, $viewIndex) {
            $estado = $i < $etapaIndex ? 'completada' : ($i === $etapaIndex ? 'activa' : 'bloqueada');
            return array_merge($e, ['estado' => $estado, 'viendo' => $i === $viewIndex]);
        })->all();

        $ingresoData  = collect($curso['ingresos'])->firstWhere('key', $ingreso);
        $esUltimaEtapa = $viewIndex >= count($etapas) - 1;
        $avance = (int) round($etapaIndex / max(count($etapas), 1) * 100);

        return view('curso.etapa', compact(
            'user', 'curso', 'ingreso', 'ingresoData', 'etapaActual', 'etapasEstado', 'esUltimaEtapa', 'avance'
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

        // Última etapa: finaliza el ingreso y va a la evaluación final.
        if ($desde >= count($etapas) - 1) {
            $progreso->update(['status' => 'completed', 'percent' => 100, 'completed_at' => now()]);
            return redirect()->route('evaluacion');
        }

        $next = min($desde + 1, count($etapas) - 1);
        $progreso->update([
            'etapa_index' => max((int) ($progreso->etapa_index ?? 0), $next),
            'status'      => 'in_progress',
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
