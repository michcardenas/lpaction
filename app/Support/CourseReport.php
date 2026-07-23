<?php

namespace App\Support;

use App\Models\User;

/**
 * Calcula, a partir de los datos REALES de la plataforma, todos los indicadores
 * del "Informe final · Resultados del curso" (versión dinámica del PDF maqueta).
 * Todo se computa sobre alumnos (usuarios NO administradores).
 */
class CourseReport
{
    /** Orden de etapas con pregunta dentro de cada ingreso → código P1..P5. */
    private const STAGES = ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2'];

    public static function build(): array
    {
        $curso = config('curso');
        $items = $curso['encuesta']['items'] ?? [];
        $dimNames = array_map(fn ($it) => $it['titulo'], $items);
        $nDim = count($dimNames);

        // Alumnos reales: sin administradores ni cuentas de prueba (is_test).
        $students = User::where('is_admin', false)->where('is_test', false)->with('progress')->get();
        $registrados = $students->count();
        $plazas = (int) ($curso['plazas'] ?? 0);

        // Perfiles por experiencia profesional.
        $perfilLabels = ['0-7' => 'En consolidación', '8-15' => 'Consolidado', '16+' => 'Experto'];
        $perfiles = ['0-7' => [], '8-15' => [], '16+' => []];   // encuestas por perfil
        $perfilRegistrados = ['0-7' => 0, '8-15' => 0, '16+' => 0];

        // Acumuladores.
        $inician = $m1 = $m2 = $m3 = $evaluados = $aptos = $diplomas = 0;
        $notas = [];
        $intento1 = $intento2 = 0;
        $b9 = $b8 = $bl = 0;                       // buckets de nota (≥9 / 8 / <8)
        $dimSum = array_fill(0, $nDim, 0.0);
        $dimPos = array_fill(0, $nDim, 0);
        $dimN   = array_fill(0, $nDim, 0);
        $encuestas = 0;
        // Heatmap: dimensión × perfil → [suma, n].
        $heat = [];
        foreach (array_keys($perfiles) as $pf) $heat[$pf] = ['sum' => array_fill(0, $nDim, 0.0), 'n' => array_fill(0, $nDim, 0)];
        // Dificultad por pregunta: clave "iN:stage" → [intentos, aciertos].
        $preg = [];

        // Máximo verde por pregunta (para definir "acierto" = respuesta perfecta).
        $maxVerde = self::maxVerdePorPregunta($curso);

        foreach ($students as $u) {
            $byKey = $u->progress->keyBy('module_key');
            $exp = in_array($u->experience_level, ['0-7', '8-15', '16+'], true) ? $u->experience_level : null;
            if ($exp) $perfilRegistrados[$exp]++;

            $st = fn ($m) => optional($byKey->get($m))->status;

            if (in_array($st('ingreso-1'), ['in_progress', 'completed'], true)) $inician++;
            if ($st('ingreso-1') === 'completed') $m1++;
            if ($st('ingreso-2') === 'completed') $m2++;
            if ($st('ingreso-3') === 'completed') $m3++;
            if (in_array($st('diploma'), ['available', 'completed'], true)) $diplomas++;

            // Evaluación.
            $evMeta = optional($byKey->get('evaluacion'))->etapas ?? [];
            $intentos = (int) ($evMeta['intentos'] ?? 0);
            if ($intentos > 0 || isset($evMeta['ultima_nota'])) {
                $evaluados++;
                $nota = (float) ($evMeta['ultima_nota'] ?? 0);
                $notas[] = $nota;
                if ($nota >= 9) $b9++;
                elseif ($nota >= 8) $b8++;
                else $bl++;
                if (! empty($evMeta['apto'])) {
                    $aptos++;
                    if ($intentos <= 1) $intento1++;
                    else $intento2++;
                }
            }

            // Encuesta de satisfacción.
            $enc = optional($byKey->get('encuesta'))->etapas['respuestas'] ?? null;
            if (is_array($enc) && optional($byKey->get('encuesta'))->status === 'completed') {
                $encuestas++;
                if ($exp) $perfiles[$exp][] = $enc;
                for ($i = 0; $i < $nDim; $i++) {
                    $v = (int) ($enc[$i] ?? 0);
                    if ($v <= 0) continue;
                    $dimSum[$i] += $v; $dimN[$i]++;
                    if ($v >= 4) $dimPos[$i]++;
                    if ($exp) { $heat[$exp]['sum'][$i] += $v; $heat[$exp]['n'][$i]++; }
                }
            }

            // Dificultad de las preguntas de los ingresos (desde las opciones marcadas).
            foreach (['ingreso-1' => 1, 'ingreso-2' => 2, 'ingreso-3' => 3] as $ing => $n) {
                $res = optional($byKey->get($ing))->etapas ?? [];
                foreach (self::STAGES as $stage) {
                    $r = $res[$stage] ?? null;
                    if (! $r || empty($r['sel'])) continue;
                    $k = "i{$n}:{$stage}";
                    $preg[$k] ??= ['intentos' => 0, 'aciertos' => 0];
                    $preg[$k]['intentos']++;
                    $mv = $maxVerde["{$ing}:{$stage}"] ?? 0;
                    if ((int) ($r['rojo'] ?? 0) === 0 && (int) ($r['verde'] ?? 0) >= $mv && $mv > 0) {
                        $preg[$k]['aciertos']++;
                    }
                }
            }
        }

        // --- Derivados ---
        $pct = fn ($x, $base) => $base > 0 ? round($x / $base * 100, 1) : 0.0;

        $notaMedia = count($notas) ? round(array_sum($notas) / count($notas), 1) : null;
        $noEvaluados = max(0, $registrados - $evaluados);

        // Dimensiones de la encuesta.
        $dimensiones = [];
        for ($i = 0; $i < $nDim; $i++) {
            $dimensiones[] = [
                'nombre' => $dimNames[$i],
                'media'  => $dimN[$i] ? round($dimSum[$i] / $dimN[$i], 1) : null,
                'pos'    => $dimN[$i] ? round($dimPos[$i] / $dimN[$i] * 100) : 0,
                'n'      => $dimN[$i],
            ];
        }
        $totalSum = array_sum($dimSum); $totalN = array_sum($dimN);
        $satisfaccion = $totalN ? round($totalSum / $totalN, 1) : null;
        $dimMasBaja = null;
        foreach ($dimensiones as $d) {
            if ($d['media'] === null) continue;
            if ($dimMasBaja === null || $d['media'] < $dimMasBaja['media']) $dimMasBaja = $d;
        }

        // Participación por perfil.
        $porPerfil = [];
        foreach ($perfiles as $pf => $lista) {
            $vals = [];
            foreach ($lista as $enc) foreach ($enc as $v) if ((int) $v > 0) $vals[] = (int) $v;
            $porPerfil[$pf] = [
                'label'       => $perfilLabels[$pf],
                'respuestas'  => count($lista),
                'registrados' => $perfilRegistrados[$pf],
                'media'       => count($vals) ? round(array_sum($vals) / count($vals), 1) : null,
                'pos'         => count($vals) ? round(count(array_filter($vals, fn ($v) => $v >= 4)) / count($vals) * 100) : 0,
                'peso'        => $encuestas > 0 ? round(count($lista) / $encuestas * 100, 1) : 0,
            ];
        }

        // Heatmap dimensión × perfil.
        $heatmap = [];
        for ($i = 0; $i < $nDim; $i++) {
            $fila = ['nombre' => $dimNames[$i]];
            foreach (array_keys($perfiles) as $pf) {
                $fila[$pf] = $heat[$pf]['n'][$i] ? round($heat[$pf]['sum'][$i] / $heat[$pf]['n'][$i], 1) : null;
            }
            $heatmap[] = $fila;
        }

        // Top 5 preguntas más difíciles (menor % de acierto).
        $stageLabel = ['pruebas' => 'P1', 'riesgo' => 'P2', 'terapeutico' => 'P3', 'monitorizacion' => 'P4', 'monitorizacion-2' => 'P5'];
        $dificiles = [];
        foreach ($preg as $k => $v) {
            [$mod, $stage] = explode(':', $k);
            $pk = self::preguntaKey('ingreso-'.substr($mod, 1), $stage);
            $enun = $curso[$pk]['enunciado'] ?? '';
            $dificiles[] = [
                'codigo'    => strtoupper($mod).' · '.$stageLabel[$stage],
                'enunciado' => mb_strlen($enun) > 90 ? mb_substr($enun, 0, 90).'…' : $enun,
                'acierto'   => $v['intentos'] ? round($v['aciertos'] / $v['intentos'] * 100) : 0,
                'n'         => $v['intentos'],
            ];
        }
        usort($dificiles, fn ($a, $b) => $a['acierto'] <=> $b['acierto']);
        $dificiles = array_slice($dificiles, 0, 5);

        return [
            'generado'    => now(),
            'registrados' => $registrados,
            'plazas'      => $plazas,
            'inician'     => $inician,
            'm1' => $m1, 'm2' => $m2, 'm3' => $m3,
            'evaluados'   => $evaluados,
            'aptos'       => $aptos,
            'diplomas'    => $diplomas,
            'noEvaluados' => $noEvaluados,
            'notaMedia'   => $notaMedia,
            'pctAptos'    => $pct($aptos, $evaluados),
            'pctCompletan'=> $pct($m3, $registrados),
            'pctActivacion' => $pct($inician, $registrados),
            'buckets'     => ['b9' => $b9, 'b8' => $b8, 'bl' => $bl, 'ne' => $noEvaluados],
            'intento1'    => $intento1,
            'intento2'    => $intento2,
            'satisfaccion'=> $satisfaccion,
            'encuestas'   => $encuestas,
            'tasaRespuesta' => $pct($encuestas, $registrados),
            'dimMasBaja'  => $dimMasBaja,
            'dimensiones' => $dimensiones,
            'porPerfil'   => $porPerfil,
            'heatmap'     => $heatmap,
            'dificiles'   => $dificiles,
            'funnel'      => [
                ['etapa' => 'Registrados',        'n' => $registrados],
                ['etapa' => 'Inician actividad',  'n' => $inician],
                ['etapa' => 'Completan Módulo 1', 'n' => $m1],
                ['etapa' => 'Completan Módulo 2', 'n' => $m2],
                ['etapa' => 'Completan Módulo 3', 'n' => $m3],
                ['etapa' => 'Realizan evaluación','n' => $evaluados],
                ['etapa' => 'Resultan APTOS',     'n' => $aptos],
            ],
        ];
    }

    /** Suma de puntos positivos por pregunta → clave "ingreso:stage". */
    private static function maxVerdePorPregunta(array $curso): array
    {
        $out = [];
        foreach (['ingreso-1', 'ingreso-2', 'ingreso-3'] as $ing) {
            foreach (self::STAGES as $stage) {
                $pk = self::preguntaKey($ing, $stage);
                $max = 0;
                foreach (($curso[$pk]['opciones'] ?? []) as $op) {
                    if (($op['puntos'] ?? 0) > 0) $max += (int) $op['puntos'];
                }
                $out["{$ing}:{$stage}"] = $max;
            }
        }
        return $out;
    }

    /** Igual que CursoController::preguntaKey (ingreso-1 plano, resto con sufijo _N). */
    private static function preguntaKey(string $ingreso, string $stage): string
    {
        $base = [
            'pruebas' => 'pregunta_pruebas', 'riesgo' => 'pregunta_riesgo',
            'terapeutico' => 'pregunta_terapeutico', 'monitorizacion' => 'pregunta_monitorizacion',
            'monitorizacion-2' => 'pregunta_monitorizacion2',
        ];
        $pk = $base[$stage];
        if ($ingreso === 'ingreso-1') return $pk;
        if (preg_match('/^ingreso-(\d+)$/', $ingreso, $m)) return $pk.'_'.$m[1];
        return $pk;
    }
}
