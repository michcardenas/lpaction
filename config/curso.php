<?php

/*
|--------------------------------------------------------------------------
| Estructura del curso "La evolución de Juan"
|--------------------------------------------------------------------------
| Contenido editable del curso. El progreso de cada usuario se guarda en la
| tabla course_progress; aquí solo viven los textos/estructura del curso.
*/

return [
    'titulo'           => 'La evolución de Juan',
    'subtitulo_1'      => 'Tres ingresos,',
    'subtitulo_2'      => 'tres decisiones clave',
    'disponible_hasta' => '15/01/2027',

    'paciente' => [
        'nombre' => 'Juan',
        'imagen' => 'images/paciente_pantalla_1.png',
        'datos'  => [
            ['icon' => 'edad',  'texto' => '52 años'],
            ['icon' => 'fuma',  'texto' => 'Fumador'],
            ['icon' => 'salud', 'texto' => 'Vida sedentaria y alto nivel de estrés'],
        ],
    ],

    // Módulos secuenciales. El primero queda desbloqueado al registrarse.
    'ingresos' => [
        [
            'key'    => 'ingreso-1',
            'label'  => 'Ingreso 1',
            'titulo' => 'Lp(a): una lipoproteína única y distinta, heredada y conductora causal de enfermedad cardiovascular',
        ],
        [
            'key'    => 'ingreso-2',
            'label'  => 'Ingreso 2',
            'titulo' => 'Manejo de pacientes con enfermedad cardiovascular y elevada Lp(a)',
        ],
        [
            'key'    => 'ingreso-3',
            'label'  => 'Ingreso 3',
            'titulo' => 'Terapias dirigidas a la Lp(a): panorama actual de su desarrollo',
        ],
    ],

    // Módulos finales (se desbloquean al completar los ingresos).
    'finales' => [
        ['key' => 'evaluacion', 'titulo' => 'Evaluación final'],
        ['key' => 'diploma',    'titulo' => 'Diploma'],
    ],

    // Etapas (barra lateral) dentro de cada ingreso. La primera queda activa.
    'etapas' => [
        ['key' => 'presentacion',     'titulo' => 'Presentación'],
        ['key' => 'pruebas',          'titulo' => 'Pruebas complementarias'],
        ['key' => 'riesgo',           'titulo' => 'Evaluación del riesgo cardiovascular'],
        ['key' => 'terapeutico',      'titulo' => 'Planteamiento terapéutico'],
        ['key' => 'monitorizacion',   'titulo' => 'Monitorización y seguimiento'],
        ['key' => 'monitorizacion-2', 'titulo' => 'Monitorización y seguimiento 2'],
        ['key' => 'mantenimiento',    'titulo' => 'Terapia de mantenimiento al alta de rehabilitación cardiaca'],
        ['key' => 'puntos-clave',     'titulo' => 'Puntos clave'],
        ['key' => 'resumen',          'titulo' => 'Resumen del caso'],
    ],
];
