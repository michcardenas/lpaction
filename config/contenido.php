<?php

/*
|--------------------------------------------------------------------------
| Contenido clínico editable por etapa (además de los títulos y preguntas)
|--------------------------------------------------------------------------
| Estructura:  [ingreso => [etapa => [ claveCorta => ['label','type','default','html'?] ]]]
| La clave cms real es:  curso.cont.{ingreso}.{etapa}.{claveCorta}
|
| 'default' es el TEXTO ACTUAL de la web (la base del cliente). Mientras no se
| edite, la web se ve idéntica. 'html' => true para textos con etiquetas simples
| (p. ej. <b>…</b>), que se renderizan con {!! !!}.
|
| Se va completando etapa por etapa. Las etapas sin entrada aquí solo exponen su
| título de menú como editable.
*/

return [

    'ingreso-1' => [

        'introduccion' => [
            'h1'        => ['label' => 'Título de la sección', 'type' => 'text',  'default' => 'Introducción'],
            'video'     => ['label' => 'Vídeo de la introducción (MP4/WebM)', 'type' => 'video', 'default' => 'videos/introduccion-1.mp4'],
            'video_cap' => ['label' => 'Pie del vídeo',        'type' => 'text',  'default' => 'Vídeo de introducción del módulo.'],
        ],

        'presentacion' => [
            'h1'          => ['label' => 'Título de la sección',         'type' => 'text',  'default' => 'Presentación del caso'],
            'img_paciente' => ['label' => 'Imagen del paciente (Ingreso 1)', 'type' => 'image', 'default' => 'images/paciente_pantalla_1.png'],
            'h_historia'  => ['label' => 'Subtítulo — Historia clínica', 'type' => 'text',  'default' => 'Historia clínica'],

            'tab_perfil'     => ['label' => 'Pestaña 1 (nombre)', 'type' => 'text', 'default' => 'Perfil del paciente'],
            'tab_historia'   => ['label' => 'Pestaña 2 (nombre)', 'type' => 'text', 'default' => 'Historia médica'],
            'tab_medicacion' => ['label' => 'Pestaña 3 (nombre)', 'type' => 'text', 'default' => 'Medicación'],
            'tab_alergias'   => ['label' => 'Pestaña 4 (nombre)', 'type' => 'text', 'default' => 'Alergias'],

            'perfil' => ['label' => 'Perfil del paciente (contenido)', 'type' => 'richtext', 'default' =>
                '<p><b>Edad y sexo:</b> varón, 52 años</p>'
                . '<p><b>Peso, estatura:</b> 82 kg, 167 cm (índice de masa corporal [IMC]: 29,4 kg/m² ; sobrepeso).</p>'
                . '<p><b>Hábitos:</b> fumador desde los 15 años; índice paquetes-año (IPA): 42.</p>'
                . '<p><b>Ocupación:</b> empresario.</p>'
                . '<p><b>Estilo de vida:</b> vida sedentaria, alto nivel de estrés.</p>'],

            'historia_p'   => ['label' => 'Historia médica (texto)', 'type' => 'textarea', 'default' => 'Hipertensión arterial (HTA) ligera de 7 años de evolución.'],
            'medicacion'   => ['label' => 'Medicación (contenido)',  'type' => 'richtext', 'default' => '<p><b>Telmisartán:</b> 80 mg/24 h.</p>'],
            'alergias_p'   => ['label' => 'Alergias (texto)',        'type' => 'textarea', 'default' => 'Sin alergias medicamentosas conocidas.'],

            'h_motivo' => ['label' => 'Subtítulo — Motivo de consulta', 'type' => 'text',     'default' => 'Motivo de consulta'],
            'motivo'   => ['label' => 'Motivo de consulta (texto)',     'type' => 'textarea', 'default' => 'Paciente que es traído a Urgencias de nuestro hospital por los servicios de emergencias debido a un cuadro de 2 h de evolución de dolor torácico retroesternal muy intenso que irradia hacia región epigástrica y base del cuello. El paciente refiere clínica acompañante de sudoración profusa y náuseas asociadas, aunque no ha presentado ningún vómito.'],
        ],

        'pruebas' => [
            'h1'            => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Pruebas complementarias'],
            'tab_ecg'       => ['label' => 'Pestaña 1 (nombre)', 'type' => 'text', 'default' => 'Electrocardiograma (ECG)'],
            'tab_imagen'    => ['label' => 'Pestaña 2 (nombre)', 'type' => 'text', 'default' => 'Pruebas de imagen'],
            'tab_analitica' => ['label' => 'Pestaña 3 (nombre)', 'type' => 'text', 'default' => 'Analítica sanguínea'],

            'ecg_h'   => ['label' => 'ECG — subtítulo', 'type' => 'text',     'default' => 'Electrocardiograma (ECG)'],
            'ecg_p'   => ['label' => 'ECG — texto',     'type' => 'textarea', 'default' => 'Los servicios de emergencias extrahospitalarias realizan un ECG donde se evidencia una elevación del segmento ST en la cara inferoposterior (Figura 1), por lo que proceden a la administración inmediata de doble antiagregación.'],
            'img_ecg' => ['label' => 'ECG — imagen',    'type' => 'image',    'default' => 'images/ecg.png'],
            'ecg_cap' => ['label' => 'ECG — pie de figura', 'type' => 'text', 'default' => 'Figura 1. Electrocardiograma con elevación del segmento ST en la cara inferoposterior.'],

            'cat_h'      => ['label' => 'Cateterismo — subtítulo',  'type' => 'text',  'default' => 'Cateterismo cardíaco'],
            'cat1_video' => ['label' => 'Cateterismo — vídeo 1',    'type' => 'video', 'default' => 'videos/cateterismo-1.mp4'],
            'cat1_cap'   => ['label' => 'Cateterismo — pie vídeo 1', 'type' => 'text', 'default' => 'Vídeo 1. Coronariografía. Arteria coronaria derecha con oclusión en segmento medio.'],
            'cat2_video' => ['label' => 'Cateterismo — vídeo 2',    'type' => 'video', 'default' => 'videos/cateterismo-2.mp4'],
            'cat2_cap'   => ['label' => 'Cateterismo — pie vídeo 2', 'type' => 'text', 'default' => 'Vídeo 2. Coronariografía. Estenosis significativa en descendente anterior.'],

            'eco_h'      => ['label' => 'Ecocardiograma — subtítulo', 'type' => 'text',  'default' => 'Ecocardiograma'],
            'cat3_video' => ['label' => 'Ecocardiograma — vídeo',     'type' => 'video', 'default' => 'videos/cateterismo-3.mp4'],
            'cat3_cap'   => ['label' => 'Ecocardiograma — pie vídeo', 'type' => 'text',  'default' => 'Video 3. Ecocardiograma (plano 4 cámaras). Fracción de eyección del ventrículo izquierdo conservada.'],
            'nota'       => ['label' => 'Ecocardiograma — texto (con formato)', 'type' => 'richtext', 'default' => '<p class="prueba-p">Tras su llegada a Urgencias, el paciente es trasladado inmediatamente al área de Hemodinámica para la realización de una angioplastia primaria. En el cateterismo cardiaco los hallazgos son los siguientes: oclusión coronaria derecha y lesión moderada (50%) en descendente anterior. Se procede a angioplastia coronaria transluminal percutánea (ACTP) e implante de 2 stents farmacoactivos (DES) en coronaria derecha con éxito y sin complicaciones. Flujo final TIMI 3 (flujo coronario normal).</p><p class="prueba-p">En evaluación ecocardiográfica tras angioplastia, se objetiva fracción de eyección del ventrículo izquierdo (FEVI) conservada del 55%, con hipocinesia inferior.</p>'],

            'ana_h'     => ['label' => 'Analítica — subtítulo', 'type' => 'text', 'default' => 'Analítica sanguínea'],
            'ana_intro' => ['label' => 'Analítica — intro',     'type' => 'text', 'default' => 'Se realiza analítica en las primeras 24 h de ingreso que incluye los siguientes valores:'],
            'ana_list'  => ['label' => 'Analítica — valores (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>Hemoglobina (Hb): 14,7 g/dL.</li>'
                . '<li>Glucosa plasmática (GLU): 110 mg/dL.</li>'
                . '<li>Hemoglobina glicada (HbA1c): 5,7%.</li>'
                . '<li>Creatinina: 0,68 mg/dL (tasa de filtrado glomerular [TFG CKD-EPI] 106 mL/min/1,73 m²).</li>'
                . '<li>Colesterol total (CT): 155 mg/dL.</li>'
                . '<li>Triglicéridos (TG): 78 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de alta densidad (cHDL): 36 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de baja densidad (cLDL): 104 mg/dL.</li>'
                . '<li>Colesterol remanente: 15 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de muy baja densidad (cVLDL): 15,6 mg/dL.</li>'
                . '<li>TG/HDL: 2,16.</li>'
                . '<li>Hormona estimulante del tiroides (TSH) y tiroxina (T4): en rango.</li>'
                . '<li>Proteína C reactiva (PCR): 8,9 mg/L.</li>'
                . '</ul>'],
        ],

        'riesgo' => [
            'h1' => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Evaluación del riesgo cardiovascular'],
            'h2' => ['label' => 'Subtítulo',            'type' => 'text', 'default' => 'Al paciente no se le determinaron apoB ni Lp(a)'],
            'p1' => ['label' => 'Párrafo 1',            'type' => 'textarea', 'default' => 'En la práctica clínica habitual esto es muy frecuente. Solo en un bajo porcentaje de la población se realiza determinación de Lp(a).'],
            'p2' => ['label' => 'Párrafo 2 (admite <sup>… para citas)', 'type' => 'textarea', 'html' => true, 'default' => 'A pesar de que las guías internacionales recomiendan su medición en este grupo de alto riesgo, en la práctica clínica el porcentaje de pacientes con enfermedad cardiovascular en los que se determina Lp(a) es muy bajo (&lt;1%–14%)<sup>2,3</sup>. Estudios recientes en redes de Atención Primaria y Cardiología muestran que solo el 1,55% de los pacientes que cumplen criterios de RCV, incluyendo SCA, tienen la Lp(a) medida, y la proporción es similar en pacientes con enfermedad cardiovascular establecida.'],
        ],

        'puntos-clave' => [
            'h1'        => ['label' => 'Título de la sección', 'type' => 'text',  'default' => 'Puntos clave'],
            'video'     => ['label' => 'Vídeo de puntos clave (MP4/WebM)', 'type' => 'video', 'default' => 'videos/puntos-clave-1.mp4'],
            'video_cap' => ['label' => 'Pie del vídeo',        'type' => 'text',  'default' => 'Video del Dr. José López Miranda.'],
        ],

        'resumen' => [
            'archivo' => ['label' => 'Archivo de “Descargar caso” (PDF/Word)', 'type' => 'doc', 'default' => 'casos/caso-ingreso-1.pdf'],
        ],

    ],

    'ingreso-2' => [
        'pruebas' => [
            'img_ecg' => ['label' => 'ECG — imagen',              'type' => 'image', 'default' => 'images/ecg-2.png'],
            'video1'  => ['label' => 'Cateterismo — vídeo',       'type' => 'video', 'default' => 'videos/cateterismo-2-1.mp4'],
            'video2'  => ['label' => 'Arteriografía femoral — vídeo', 'type' => 'video', 'default' => 'videos/arteriografia-femoral.mp4'],
        ],
        'puntos-clave' => [
            'video'     => ['label' => 'Vídeo de puntos clave (MP4/WebM)', 'type' => 'video', 'default' => 'videos/puntos-clave-2.mp4'],
            'video_cap' => ['label' => 'Pie del vídeo',           'type' => 'text',  'default' => 'Video de la Dra. Almudena Castro Conde.'],
        ],
        'resumen' => [
            'archivo' => ['label' => 'Archivo de “Descargar caso” (PDF/Word)', 'type' => 'doc', 'default' => 'casos/caso-ingreso-2.pdf'],
        ],
    ],

    'ingreso-3' => [
        'pruebas' => [
            'img_tc' => ['label' => 'TC craneal — imagen', 'type' => 'image', 'default' => 'images/tc-craneal-ingreso3.jpg'],
        ],
        'mantenimiento' => [
            'video'     => ['label' => 'Vídeo explicativo (MP4/WebM)', 'type' => 'video', 'default' => 'videos/mantenimiento-3.mp4'],
            'video_cap' => ['label' => 'Pie del vídeo',              'type' => 'text',  'default' => 'Vídeo explicativo del caso.'],
        ],
        'resumen' => [
            'archivo' => ['label' => 'Archivo de “Descargar caso” (PDF/Word)', 'type' => 'doc', 'default' => 'casos/caso-ingreso-3.docx'],
        ],
    ],

];
