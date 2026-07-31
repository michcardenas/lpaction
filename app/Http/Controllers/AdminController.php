<?php

namespace App\Http\Controllers;

use App\Models\CourseProgress;
use App\Models\User;

class AdminController extends Controller
{
    /** Panel de administración: métricas de progreso de los alumnos. */
    public function dashboard()
    {
        // Alumnos = usuarios NO administradores. Los marcados como TEST no cuentan en las métricas.
        $studentIds = User::where('is_admin', false)->where('is_test', false)->pluck('id');
        $totalAlumnos = $studentIds->count();

        // Progreso de todos los alumnos, agrupado por usuario.
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

        // Registros recientes (últimos 7 días).
        $nuevos7d = User::where('is_admin', false)->where('is_test', false)
            ->where('created_at', '>=', now()->subDays(7))->count();

        // Tabla de alumnos con su estado por ingreso (los TEST sí se listan, marcados, pero
        // su progreso no está en $progresos así que se consulta aparte).
        $progresosTest = CourseProgress::whereIn(
            'user_id',
            User::where('is_admin', false)->where('is_test', true)->pluck('id')
        )->get()->groupBy('user_id');

        $alumnos = User::where('is_admin', false)->orderByDesc('id')->get()->map(function ($u) use ($progresos, $progresosTest) {
            $filas = $progresos->get($u->id) ?? $progresosTest->get($u->id) ?? collect();
            $estado = function ($m) use ($filas) {
                $f = $filas->firstWhere('module_key', $m);
                return $f->status ?? 'locked';
            };
            $ev = $filas->firstWhere('module_key', 'evaluacion');
            $evMeta = $ev->etapas ?? [];
            return [
                'id'         => $u->id,
                'nombre'     => trim($u->name.' '.($u->last_name ?? '')) ?: '—',
                'email'      => $u->email,
                'i1'         => $estado('ingreso-1'),
                'i2'         => $estado('ingreso-2'),
                'i3'         => $estado('ingreso-3'),
                'apto'       => ! empty($evMeta['apto']),
                'nota'       => $evMeta['ultima_nota'] ?? null,
                'registro'   => $u->created_at,
                'is_test'    => (bool) $u->is_test,
                'cert_icomem'=> (bool) $u->cert_icomem,
            ];
        });

        // ¿Existe el informe final para ofrecer su descarga?
        $informeDisponible = is_file($this->informePath());

        return view('admin.dashboard', compact(
            'totalAlumnos', 'stats', 'aptos', 'mediaNota', 'cursoCompleto', 'nuevos7d', 'alumnos', 'informeDisponible'
        ));
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
