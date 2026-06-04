<?php

namespace App\Http\Controllers;

use App\Models\CourseProgress;
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

    /** Etapa de un ingreso (p. ej. "Presentación del caso"). */
    public function etapa($ingreso)
    {
        $user = Auth::user();
        CourseProgress::seedFor($user);

        $curso  = config('curso');

        // Validar que el ingreso exista y esté desbloqueado para el usuario.
        $progreso = $user->progress()->where('module_key', $ingreso)->first();
        $abierto  = $progreso && in_array($progreso->status, ['available', 'in_progress', 'completed']);
        abort_unless($abierto, 404);

        // Datos del ingreso (label/título) desde el config.
        $ingresoData = collect($curso['ingresos'])->firstWhere('key', $ingreso);

        return view('curso.etapa', compact('user', 'curso', 'ingreso', 'ingresoData'));
    }
}
