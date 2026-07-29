<?php

namespace App\Support;

/**
 * Contenido editable de los INGRESOS (por ahora: preguntas del Ingreso 1).
 *
 * Solo se editan TEXTOS (enunciado, instrucción, texto y justificación de cada
 * opción). Lo estructural —qué opción es correcta, los puntos, el orden— NO se
 * toca, para no alterar el motor de puntuación.
 *
 * Reutiliza la misma tabla site_contents y el helper Cms. Los valores por
 * defecto son los de config/curso.php.
 */
class CursoCms
{
    /**
     * Preguntas editables por ingreso: [ingreso => [preguntaKey => etiqueta de etapa]].
     * Para extender a los ingresos 2 y 3 basta con añadir sus claves aquí.
     */
    public static function preguntasPorIngreso(): array
    {
        return [
            'ingreso-1' => [
                'pregunta_pruebas'         => 'Pruebas complementarias',
                'pregunta_riesgo'          => 'Evaluación del riesgo cardiovascular',
                'pregunta_terapeutico'     => 'Planteamiento terapéutico',
                'pregunta_monitorizacion'  => 'Monitorización y seguimiento',
                'pregunta_monitorizacion2' => 'Monitorización y seguimiento 2',
            ],
            'ingreso-2' => [
                'pregunta_pruebas_2'        => 'Pruebas complementarias',
                'pregunta_objetivos_2'      => 'Objetivos lipídicos adicionales',
                'pregunta_riesgo_2'         => 'Evaluación del riesgo cardiovascular',
                'pregunta_terapeutico_2'    => 'Planteamiento terapéutico',
                'pregunta_monitorizacion_2' => 'Monitorización y seguimiento',
            ],
            'ingreso-3' => [
                'pregunta_pruebas_3'         => 'Pruebas complementarias',
                'pregunta_riesgo_3'          => 'Evaluación del riesgo cardiovascular',
                'pregunta_terapeutico_3'     => 'Planteamiento terapéutico',
                'pregunta_monitorizacion_3'  => 'Terapias emergentes anti-Lp(a): pelacarsen y ensayo HORIZON',
                'pregunta_monitorizacion2_3' => 'Evolución',
            ],
        ];
    }

    /** Campos editables de UNA pregunta: [cmsKey => ['label','type','default']].
     *  $richJustif = true → las justificaciones usan editor con formato (Quill). */
    public static function camposDe(string $pk, bool $richJustif = false): array
    {
        $q = config('curso.' . $pk);
        if (! is_array($q)) {
            return [];
        }

        $fields = [];
        if (isset($q['enunciado'])) {
            $fields['curso.' . $pk . '.enunciado'] = ['label' => 'Enunciado', 'type' => 'textarea', 'default' => $q['enunciado']];
        }
        if (isset($q['instruccion'])) {
            $fields['curso.' . $pk . '.instruccion'] = ['label' => 'Instrucción', 'type' => 'text', 'default' => $q['instruccion']];
        }

        $n = 0;
        foreach ($q['opciones'] ?? [] as $op) {
            $n++;
            $ok = $op['key'] ?? (string) $n;
            $marca = ! empty($op['correcta']) ? ' · correcta' : '';
            $fields['curso.' . $pk . '.op.' . $ok . '.texto'] = [
                'label' => "Opción {$n}{$marca} — texto", 'type' => 'text', 'default' => $op['texto'] ?? '',
            ];
            if (isset($op['justificacion'])) {
                $fields['curso.' . $pk . '.op.' . $ok . '.justificacion'] = [
                    'label' => "Opción {$n}{$marca} — justificación", 'type' => $richJustif ? 'richtext' : 'textarea', 'default' => $op['justificacion'],
                ];
            }
        }

        return $fields;
    }

    /** Etapas de un ingreso: [etapaKey => 'Título por defecto'] (desde config/curso.php). */
    public static function stagesDe(string $ingreso): array
    {
        $n = preg_match('/(\d+)/', $ingreso, $m) ? $m[1] : '1';
        $etapas = config('curso.etapas_' . $n);
        if (! is_array($etapas) || ! $etapas) {
            $etapas = config('curso.etapas', []);
        }
        $out = [];
        foreach ($etapas as $e) {
            if (isset($e['key'])) {
                $out[$e['key']] = $e['titulo'] ?? $e['key'];
            }
        }
        return $out;
    }

    /** Clave de pregunta de una etapa (mismo mapeo que el controlador), o null. */
    protected static function preguntaKeyDe(string $ingreso, string $etapa): ?string
    {
        $base = [
            'pruebas' => 'pregunta_pruebas', 'objetivos' => 'pregunta_objetivos', 'riesgo' => 'pregunta_riesgo',
            'terapeutico' => 'pregunta_terapeutico', 'monitorizacion' => 'pregunta_monitorizacion', 'monitorizacion-2' => 'pregunta_monitorizacion2',
        ];
        $pk = $base[$etapa] ?? null;
        if ($pk === null) {
            return null;
        }
        if ($ingreso === 'ingreso-1') {
            return $pk;
        }
        if (preg_match('/^ingreso-(\d+)$/', $ingreso, $m)) {
            return $pk . '_' . $m[1];
        }
        return $pk;
    }

    /** Campos de contenido clínico de una etapa (config/contenido.php), con claves cms completas. */
    public static function contenidoCampos(string $ingreso, string $etapa): array
    {
        $fields = [];
        foreach (config('contenido.' . $ingreso . '.' . $etapa, []) as $short => $def) {
            $fields['curso.cont.' . $ingreso . '.' . $etapa . '.' . $short] = $def;
        }
        return $fields;
    }

    /** Todos los campos editables del curso, aplanados (para el registry unificado y update()). */
    public static function registryFields(): array
    {
        $flat = [];
        foreach (array_keys(self::ingresosEditables()) as $ingreso) {
            foreach (self::seccionesDe($ingreso) as $sec) {
                foreach ($sec['fields'] as $key => $def) {
                    $flat[$key] = $def;
                }
            }
        }
        return $flat;
    }

    /** Ingresos con editor disponible: [ingreso => 'Ingreso N']. */
    public static function ingresosEditables(): array
    {
        $out = [];
        foreach (self::preguntasPorIngreso() as $ingreso => $preguntas) {
            $n = preg_match('/(\d+)/', $ingreso, $m) ? $m[1] : '';
            $out[$ingreso] = 'Ingreso ' . $n;
        }
        return $out;
    }

    /**
     * Secciones del editor de UN ingreso.
     * - Si el ingreso tiene contenido clínico registrado (config/contenido.php) → una
     *   sección POR ETAPA (título de menú + contenido + preguntas).
     * - Si no → una sección POR PREGUNTA (comportamiento anterior).
     */
    public static function seccionesDe(string $ingreso): array
    {
        return config('contenido.' . $ingreso)
            ? self::seccionesPorEtapa($ingreso)
            : self::seccionesPorPregunta($ingreso);
    }

    protected static function seccionesPorEtapa(string $ingreso): array
    {
        $editables = self::preguntasPorIngreso()[$ingreso] ?? [];
        $secciones = [];
        foreach (self::stagesDe($ingreso) as $etapa => $tituloDefault) {
            $fields = ['curso.menu.' . $ingreso . '.' . $etapa => ['label' => 'Título en el menú', 'type' => 'text', 'default' => $tituloDefault]];
            foreach (self::contenidoCampos($ingreso, $etapa) as $k => $d) {
                $fields[$k] = $d;
            }
            $pk = self::preguntaKeyDe($ingreso, $etapa);
            if ($pk && isset($editables[$pk])) {
                // Justificaciones siempre con editor Quill (formato + superíndices) en los 3 ingresos.
                foreach (self::camposDe($pk, true) as $k => $d) {
                    $fields[$k] = $d;
                }
            }
            // Etiqueta de la sección = título actual (override o defecto). Con default => no toca el registry.
            $secciones[$etapa] = ['label' => Cms::text('curso.menu.' . $ingreso . '.' . $etapa, $tituloDefault), 'fields' => $fields];
        }
        return $secciones;
    }

    protected static function seccionesPorPregunta(string $ingreso): array
    {
        $preguntas = self::preguntasPorIngreso()[$ingreso] ?? [];
        $secciones = [];
        foreach ($preguntas as $pk => $etapaLabel) {
            $campos = self::camposDe($pk);
            if ($campos) {
                $secciones[$pk] = ['label' => $etapaLabel, 'fields' => $campos];
            }
        }
        return $secciones;
    }

    /** Aplica los overrides de TÍTULO de menú a la lista de etapas (para el sidebar). */
    public static function aplicarEtapas(string $ingreso, array $etapas): array
    {
        foreach ($etapas as $i => $e) {
            if (! isset($e['key'])) {
                continue;
            }
            $etapas[$i]['titulo'] = Cms::text('curso.menu.' . $ingreso . '.' . $e['key'], $e['titulo'] ?? $e['key']);
        }
        return $etapas;
    }

    /** Aplica los overrides de texto sobre el array $curso (config), sin tocar lo estructural. */
    public static function aplicar(array $curso): array
    {
        foreach (self::preguntasPorIngreso() as $preguntas) {
            foreach ($preguntas as $pk => $label) {
                if (! isset($curso[$pk]) || ! is_array($curso[$pk])) {
                    continue;
                }
                $curso[$pk] = self::aplicarPregunta($pk, $curso[$pk]);
            }
        }
        return $curso;
    }

    protected static function aplicarPregunta(string $pk, array $q): array
    {
        if (isset($q['enunciado'])) {
            $q['enunciado'] = Cms::text('curso.' . $pk . '.enunciado', $q['enunciado']);
        }
        if (isset($q['instruccion'])) {
            $q['instruccion'] = Cms::text('curso.' . $pk . '.instruccion', $q['instruccion']);
        }
        foreach ($q['opciones'] ?? [] as $i => $op) {
            $ok = $op['key'] ?? (string) $i;
            if (isset($op['texto'])) {
                $q['opciones'][$i]['texto'] = Cms::text('curso.' . $pk . '.op.' . $ok . '.texto', $op['texto']);
            }
            if (isset($op['justificacion'])) {
                $q['opciones'][$i]['justificacion'] = Cms::text('curso.' . $pk . '.op.' . $ok . '.justificacion', $op['justificacion']);
            }
        }
        return $q;
    }
}
