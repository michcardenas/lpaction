<?php

/*
|--------------------------------------------------------------------------
| Contenido editable de la landing (home)
|--------------------------------------------------------------------------
| Registro ÚNICO de todos los textos e imágenes que el cliente puede editar
| desde el panel (/admin/contenido).
|
| - 'default' es el valor ACTUAL de la web: mientras no exista un override en
|   la tabla site_contents, la landing se ve exactamente igual que ahora.
| - 'type': 'text' (input), 'textarea' (multilínea) o 'image' (subida).
| - En 'image', 'default' es la ruta del asset por defecto (public/...).
| - 'html' => true marca los textos que admiten etiquetas simples (p. ej. <em>).
|
| La vista welcome.blade.php llama a cms('clave') / cms_img('clave').
*/

return [

    'hero' => [
        'label' => 'Portada (Hero)',
        'fields' => [
            'hero.eyebrow'      => ['label' => 'Texto superior (pregunta)', 'type' => 'text',     'default' => '¿Qué cambia en tu práctica cuando la Lp(a) está elevada?'],
            'hero.titulo_1'     => ['label' => 'Título — línea 1',           'type' => 'text',     'default' => 'Juan ingresa tres veces.'],
            'hero.titulo_2'     => ['label' => 'Título — línea 2',           'type' => 'textarea', 'default' => 'El tratamiento parece <em class="italic">correcto. La</em> evolución, no.', 'html' => true],
            'hero.barra_texto'  => ['label' => 'Texto de la barra inferior', 'type' => 'textarea', 'default' => 'Solicitada la acreditación del Consejo Profesional Médico Español para el DPC/FMC (SEAFORMEC-EACCME).'],
            'hero.cta'          => ['label' => 'Botón (llamada a la acción)', 'type' => 'text',     'default' => 'Accede al curso'],
            'hero.img_molecula' => ['label' => 'Imagen de la molécula',      'type' => 'image',    'default' => 'images/molecula-lpa.png'],
            'hero.img_sello'    => ['label' => 'Sello de créditos (SEC)',    'type' => 'image',    'default' => 'images/sello-15-creditos.png'],
        ],
    ],

    'banda' => [
        'label' => 'Banda intermedia',
        'fields' => [
            'banda.texto' => ['label' => 'Texto de la banda', 'type' => 'textarea', 'default' => 'Este curso online acreditado te sitúa ante el recorrido clínico de Juan para identificar cuándo la Lp(a) modifica la interpretación del riesgo residual y condiciona su pronóstico.'],
        ],
    ],

    'caso' => [
        'label' => 'Caso clínico (No es un caso teórico)',
        'fields' => [
            'caso.eyebrow'     => ['label' => 'Etiqueta',                 'type' => 'text',     'default' => 'Caso clínico'],
            'caso.titulo_1'    => ['label' => 'Título — línea 1',         'type' => 'text',     'default' => 'No es un caso teórico.'],
            'caso.titulo_2'    => ['label' => 'Título — línea 2 (azul)',  'type' => 'text',     'default' => 'Es un paciente que vuelve.'],
            'caso.parrafo_1'   => ['label' => 'Párrafo 1',               'type' => 'textarea', 'default' => 'A lo largo de tres ingresos hospitalarios, seguirás la evolución de Juan en distintos momentos clave.'],
            'caso.parrafo_2'   => ['label' => 'Párrafo 2',               'type' => 'textarea', 'default' => 'En cada contacto clínico con el paciente tendrás la oportunidad de tomar decisiones que impacten en su pronóstico.'],
            'caso.img_juan'    => ['label' => 'Imagen de Juan',          'type' => 'image',    'default' => 'images/juan.png'],
            'caso.dato_edad'   => ['label' => 'Ficha — Edad',            'type' => 'text',     'default' => '52'],
            'caso.dato_peso'   => ['label' => 'Ficha — Peso',            'type' => 'text',     'default' => '82 kg'],
            'caso.dato_indice' => ['label' => 'Ficha — Índice paquetes-año', 'type' => 'text', 'default' => '42'],
            'caso.dato_estilo' => ['label' => 'Ficha — Estilo de vida',  'type' => 'text',     'default' => 'Vida sedentaria, alto nivel de estrés'],
        ],
    ],

    'metodologia' => [
        'label' => 'Metodología (Cómo trabajarás el caso)',
        'fields' => [
            'metodologia.eyebrow'       => ['label' => 'Etiqueta', 'type' => 'text', 'default' => 'Metodología'],
            'metodologia.titulo'        => ['label' => 'Título',   'type' => 'text', 'default' => 'Cómo trabajarás el caso'],
            'metodologia.paso_1_titulo' => ['label' => 'Paso I — título',      'type' => 'text',     'default' => 'Evolución clínica'],
            'metodologia.paso_1_desc'   => ['label' => 'Paso I — descripción', 'type' => 'textarea', 'default' => 'Accedes a cada episodio con los datos relevantes del paciente.'],
            'metodologia.paso_2_titulo' => ['label' => 'Paso II — título',      'type' => 'text',     'default' => 'Toma de decisiones'],
            'metodologia.paso_2_desc'   => ['label' => 'Paso II — descripción', 'type' => 'textarea', 'default' => 'Seleccionas la opción que consideras más adecuada en cada escenario.'],
            'metodologia.paso_3_titulo' => ['label' => 'Paso III — título',      'type' => 'text',     'default' => 'Validación experta'],
            'metodologia.paso_3_desc'   => ['label' => 'Paso III — descripción', 'type' => 'textarea', 'default' => 'Contrastas tu decisión con el análisis en vídeo de especialistas.'],
            'metodologia.paso_4_titulo' => ['label' => 'Paso IV — título',      'type' => 'text',     'default' => 'Recursos complementarios'],
            'metodologia.paso_4_desc'   => ['label' => 'Paso IV — descripción', 'type' => 'textarea', 'default' => 'Consultas materiales descargables y contenidos de apoyo actualizados.'],
            'metodologia.paso_5_titulo' => ['label' => 'Paso V — título',      'type' => 'text',     'default' => 'Cierre'],
            'metodologia.paso_5_desc'   => ['label' => 'Paso V — descripción', 'type' => 'textarea', 'default' => 'El avance en el caso depende de tus decisiones y de la validación de los aspectos clave del manejo clínico.'],
        ],
    ],

    'decisiones' => [
        'label' => 'Qué decisiones podrás mejorar',
        'fields' => [
            'decisiones.titulo'    => ['label' => 'Título',    'type' => 'text',     'default' => 'Qué decisiones podrás mejorar'],
            'decisiones.subtitulo' => ['label' => 'Subtítulo', 'type' => 'textarea', 'default' => 'El curso se organiza en tres bloques con un recorrido progresivo, desde la base clínica de la Lp(a) hasta la actualización en terapias dirigidas.'],
            'decisiones.item_1' => ['label' => 'Punto 1', 'type' => 'text', 'default' => 'Identificar cuándo medir Lp(a) en práctica real'],
            'decisiones.item_2' => ['label' => 'Punto 2', 'type' => 'text', 'default' => 'Interpretar resultados (mg/dL vs. nmol/L) en contexto clínico'],
            'decisiones.item_3' => ['label' => 'Punto 3', 'type' => 'text', 'default' => 'Reconocer riesgo vascular residual no explicado'],
            'decisiones.item_4' => ['label' => 'Punto 4', 'type' => 'text', 'default' => 'Ajustar el manejo en pacientes con eventos recurrentes'],
            'decisiones.item_5' => ['label' => 'Punto 5', 'type' => 'text', 'default' => 'Integrar la Lp(a) en la estratificación del riesgo'],
            'decisiones.item_6' => ['label' => 'Punto 6', 'type' => 'text', 'default' => 'Anticipar el impacto de terapias dirigidas'],
        ],
    ],

    'contenidos' => [
        'label' => 'Contenidos formativos',
        'fields' => [
            'contenidos.eyebrow'     => ['label' => 'Etiqueta', 'type' => 'text',     'default' => 'Contenidos'],
            'contenidos.titulo'      => ['label' => 'Título',   'type' => 'text',     'default' => 'Contenidos formativos'],
            'contenidos.copete'      => ['label' => 'Copete',   'type' => 'textarea', 'default' => 'Mantén una visión completa de la evolución clínica del paciente.'],
            'contenidos.mod_1_titulo' => ['label' => 'Módulo 1 — título',      'type' => 'text',     'default' => 'Módulo 1'],
            'contenidos.mod_1_desc'   => ['label' => 'Módulo 1 — descripción', 'type' => 'textarea', 'default' => 'Lp(a): una lipoproteína única y distinta, heredada y conductora causal de enfermedad cardiovascular'],
            'contenidos.mod_2_titulo' => ['label' => 'Módulo 2 — título',      'type' => 'text',     'default' => 'Módulo 2'],
            'contenidos.mod_2_desc'   => ['label' => 'Módulo 2 — descripción', 'type' => 'textarea', 'default' => 'Manejo de pacientes con enfermedad cardiovascular y elevada Lp(a)'],
            'contenidos.mod_3_titulo' => ['label' => 'Módulo 3 — título',      'type' => 'text',     'default' => 'Módulo 3'],
            'contenidos.mod_3_desc'   => ['label' => 'Módulo 3 — descripción', 'type' => 'textarea', 'default' => 'Terapias dirigidas a la Lp(a): panorama actual de su desarrollo'],
        ],
    ],

    'comite' => [
        'label' => 'Comité científico',
        'fields' => [
            'comite.titulo'    => ['label' => 'Título',    'type' => 'text',     'default' => 'Comité científico'],
            'comite.subtitulo' => ['label' => 'Subtítulo', 'type' => 'textarea', 'default' => 'Dirección y contenido avalados por especialistas en riesgo cardiovascular'],
            'comite.miembro_1_nombre' => ['label' => 'Miembro 1 — nombre', 'type' => 'text', 'default' => 'Dra. Almudena Castro Conde'],
            'comite.miembro_1_org'    => ['label' => 'Miembro 1 — centro', 'type' => 'text', 'default' => 'Hospital Universitario La Paz, Madrid'],
            'comite.miembro_2_nombre' => ['label' => 'Miembro 2 — nombre', 'type' => 'text', 'default' => 'Dr. David Crémer Luengos'],
            'comite.miembro_2_org'    => ['label' => 'Miembro 2 — centro', 'type' => 'text', 'default' => 'Hospital Universitario Son Llàtzer, Palma de Mallorca'],
            'comite.miembro_3_nombre' => ['label' => 'Miembro 3 — nombre', 'type' => 'text', 'default' => 'Dr. Abel García del Egido'],
            'comite.miembro_3_org'    => ['label' => 'Miembro 3 — centro', 'type' => 'text', 'default' => 'Complejo Asistencial Universitario de León'],
            'comite.miembro_4_nombre' => ['label' => 'Miembro 4 — nombre', 'type' => 'text', 'default' => 'Dr. José Luis Zamorano Gómez'],
            'comite.miembro_4_org'    => ['label' => 'Miembro 4 — centro', 'type' => 'text', 'default' => 'Hospital Universitario Ramón y Cajal, Madrid'],
            'comite.miembro_5_nombre' => ['label' => 'Miembro 5 — nombre', 'type' => 'text', 'default' => 'Dr. José López Miranda'],
            'comite.miembro_5_org'    => ['label' => 'Miembro 5 — centro', 'type' => 'text', 'default' => 'Hospital Universitario Reina Sofía, Córdoba'],
            'comite.miembro_6_nombre' => ['label' => 'Miembro 6 — nombre', 'type' => 'text', 'default' => 'Dr. José Ramón González Juanatey'],
            'comite.miembro_6_org'    => ['label' => 'Miembro 6 — centro', 'type' => 'text', 'default' => 'Universidad de Santiago de Compostela'],
        ],
    ],

];
