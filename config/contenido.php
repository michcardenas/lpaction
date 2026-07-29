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

        'presentacion' => [
            'h1'         => ['label' => 'Título de la sección',         'type' => 'text', 'default' => 'Presentación del caso'],
            'h_historia' => ['label' => 'Subtítulo — Historia clínica', 'type' => 'text', 'default' => 'Historia clínica'],
            'tab_perfil'     => ['label' => 'Pestaña 1 (nombre)', 'type' => 'text', 'default' => 'Perfil del paciente'],
            'tab_historia'   => ['label' => 'Pestaña 2 (nombre)', 'type' => 'text', 'default' => 'Historia médica'],
            'tab_medicacion' => ['label' => 'Pestaña 3 (nombre)', 'type' => 'text', 'default' => 'Medicación'],
            'tab_alergias'   => ['label' => 'Pestaña 4 (nombre)', 'type' => 'text', 'default' => 'Alergias'],
            'perfil' => ['label' => 'Perfil del paciente (contenido)', 'type' => 'richtext', 'default' =>
                '<p><b>Edad y sexo:</b> varón, 53 años</p>'
                . '<p><b>Peso, estatura:</b> 76 kg, 167 cm (índice de masa corporal [IMC]: 27,3 kg/m²; sobrepeso).</p>'
                . '<p><b>Hábitos:</b> exfumador.</p>'
                . '<p><b>Ocupación:</b> empresario.</p>'
                . '<p><b>Estilo de vida:</b> el paciente había sido adherente a la medicación y al estilo de vida.</p>'],
            'historia' => ['label' => 'Historia médica (contenido)', 'type' => 'richtext', 'default' =>
                '<p>Hipertensión arterial (HTA).</p>'
                . '<p>Infarto agudo de miocardio con elevación del segmento ST (IAMCEST) inferoposterior 10 meses antes, con dos stents farmacoactivos (stents DES) y lesión moderada 50% en la arteria descendente anterior (DA).</p>'],
            'medicacion' => ['label' => 'Medicación (contenido)', 'type' => 'richtext', 'default' =>
                '<p>Ácido acetilsalicílico (AAS): 100 mg/24 h.</p>'
                . '<p>Prasugrel: 10 mg/24 h.</p>'
                . '<p>Ramipril: 5 mg/24 h.</p>'
                . '<p>Atorvastatina/ezetimiba: 80/10 mg/24 h.</p>'
                . '<p>Ácido bempedoico: 180 mg/24 h.</p>'
                . '<p>Semaglutida: 2,4 mg/semana.</p>'],
            'alergias_p' => ['label' => 'Alergias (texto)', 'type' => 'textarea', 'default' => 'Sin alergias medicamentosas conocidas.'],
            'h_motivo'   => ['label' => 'Subtítulo — Motivo de consulta', 'type' => 'text',     'default' => 'Motivo de consulta'],
            'motivo'     => ['label' => 'Motivo de consulta (texto)',     'type' => 'textarea', 'default' => 'El paciente vuelve a acudir al servicio de Urgencias de nuestro hospital, 10 meses después del primer evento, por un cuadro de dolor retroesternal opresivo y sensación de ahogo asociada a pequeños esfuerzos rápidamente progresivos hasta alcanzar el reposo de 15 días de evolución.'],
        ],

        'pruebas' => [
            'h1'            => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Pruebas complementarias'],
            'tab_ecg'       => ['label' => 'Pestaña 1 (nombre)', 'type' => 'text', 'default' => 'Electrocardiograma (ECG)'],
            'tab_imagen'    => ['label' => 'Pestaña 2 (nombre)', 'type' => 'text', 'default' => 'Pruebas de imagen'],
            'tab_eco'       => ['label' => 'Pestaña 3 (nombre)', 'type' => 'text', 'default' => 'Ecocardiograma'],
            'tab_itb'       => ['label' => 'Pestaña 4 (nombre)', 'type' => 'text', 'default' => 'Índice tobillo brazo'],
            'tab_analitica' => ['label' => 'Pestaña 5 (nombre)', 'type' => 'text', 'default' => 'Analítica sanguínea'],

            'ecg_h'   => ['label' => 'ECG — subtítulo', 'type' => 'text',     'default' => 'Electrocardiograma (ECG)'],
            'ecg_p'   => ['label' => 'ECG — texto',     'type' => 'textarea', 'default' => 'A su llegada al servicio de Urgencias, se le realiza ECG en ritmo sinusal y se orienta como síndrome coronario agudo sin elevación del segmento ST (SCASEST).'],
            'img_ecg' => ['label' => 'ECG — imagen',    'type' => 'image',    'default' => 'images/ecg-2.png'],
            'ecg_cap' => ['label' => 'ECG — pie de figura', 'type' => 'text', 'default' => 'Figura 1. Electrocardiograma al ingreso en ritmo sinusal, orientativo de síndrome coronario agudo sin elevación del segmento ST.'],

            'cat_h'    => ['label' => 'Cateterismo — subtítulo', 'type' => 'text',     'default' => 'Cateterismo cardíaco'],
            'cat_p'    => ['label' => 'Cateterismo — texto',     'type' => 'textarea', 'default' => 'Se realiza coronariografía emergente observando stents permeables en arteria coronaria derecha (CD) y progresión de lesión en DA, revascularizada con stent DES en DA media/D1. Además, en acceso femoral se aprecian placas de ateroma con estenosis arterial.'],
            'video1'     => ['label' => 'Cateterismo — vídeo',       'type' => 'video', 'default' => 'videos/cateterismo-2-1.mp4'],
            'video1_cap' => ['label' => 'Cateterismo — pie vídeo',   'type' => 'text',  'default' => 'Vídeo 4. Cateterismo cardíaco. Se puede apreciar revascularización DAm-D1.'],
            'video2'     => ['label' => 'Arteriografía femoral — vídeo',     'type' => 'video', 'default' => 'videos/arteriografia-femoral.mp4'],
            'video2_cap' => ['label' => 'Arteriografía femoral — pie vídeo', 'type' => 'text',  'default' => 'Vídeo 5. Arteriografía femoral. Placas de ateroma que condicionan estenosis.'],

            'eco_h' => ['label' => 'Ecocardiograma — subtítulo', 'type' => 'text',     'default' => 'Ecocardiograma transtorácico'],
            'eco_p' => ['label' => 'Ecocardiograma — texto',     'type' => 'textarea', 'default' => 'Ecocardiograma transtorácico: fracción de eyección del ventrículo izquierdo (FEVI) conservada: 56%. Hipocinesia ligera inferobasal.'],

            'itb_h' => ['label' => 'ITB — subtítulo', 'type' => 'text',     'default' => 'Índice tobillo brazo (ITB)'],
            'itb_p' => ['label' => 'ITB — texto',     'type' => 'textarea', 'default' => 'Índice tobillo brazo (ITB) <0,9 = enfermedad arterial periférica.'],

            'ana_h'     => ['label' => 'Analítica — subtítulo', 'type' => 'text', 'default' => 'Analítica sanguínea'],
            'ana_intro' => ['label' => 'Analítica — intro',     'type' => 'text', 'default' => 'Realizamos analítica en el servicio de Urgencias:'],
            'ana_list'  => ['label' => 'Analítica — valores (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>Troponina US: normal.</li>'
                . '<li>Glucosa plasmática (GLU): 104 mg/dL.</li>'
                . '<li>Hemoglobina glicada (HbA1c): 5,9%.</li>'
                . '<li>Colesterol total (CT): 125 mg/dL.</li>'
                . '<li>Triglicéridos (TG): 70 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de alta densidad (cHDL): 35 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de baja densidad (cLDL): 76 mg/dL.</li>'
                . '<li>Colesterol no HDL: 90 mg/dL.</li>'
                . '<li>Apolipoproteína B (ApoB): 86 mg/dL.</li>'
                . '<li>Colesterol remanente: 14 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de muy baja densidad (cVLDL): 14 mg/dL.</li>'
                . '<li>TG/HDL: 2.</li>'
                . '<li>TG/Glucosa: 4,45.</li>'
                . '<li>Proteína C reactiva (PCR): 1,5 mg/L.</li>'
                . '</ul>'],
        ],

        'objetivos' => [
            'h1' => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Objetivos lipídicos adicionales'],
            'p1' => ['label' => 'Párrafo introductorio (con formato)', 'type' => 'richtext', 'default' =>
                'Más allá del cLDL, el <b>colesterol no-HDL</b> y la <b>apoB</b> reflejan mejor la carga aterogénica total y el riesgo residual. En un paciente con evento recurrente y enfermedad polivascular (<b>riesgo extremo</b>), los objetivos son más exigentes que los habituales.'],
        ],

        'riesgo' => [
            'h1'    => ['label' => 'Título de la sección', 'type' => 'text',     'default' => 'Evaluación del riesgo cardiovascular'],
            'h2'    => ['label' => 'Subtítulo',            'type' => 'text',     'default' => 'Tras la reevaluación se solicita la determinación de Lp(a)'],
            'p1'    => ['label' => 'Texto introductorio',  'type' => 'textarea', 'default' => 'Tras el diagnóstico de SCASEST tipo angina inestable y revascularización, por fin se solicitó determinación de lipoproteína (a) [Lp(a)]:'],
            'lista' => ['label' => 'Analítica con Lp(a) (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>GLU: 104 mg/dL.</li>'
                . '<li>HbA1c: 5,9%.</li>'
                . '<li>CT: 125 mg/dL.</li>'
                . '<li>TG: 70 mg/dL.</li>'
                . '<li>cHDL: 35 mg/dL.</li>'
                . '<li>cLDL: 76 mg/dL.</li>'
                . '<li>Colesterol no-HDL: 90 mg/dL.</li>'
                . '<li>ApoB: 86 mg/dL.</li>'
                . '<li>Colesterol remanente: 14 mg/dL.</li>'
                . '<li>cVLDL: 14 mg/dL.</li>'
                . '<li>TG/HDL: 2.</li>'
                . '<li>TG/Glucosa: 4,45.</li>'
                . '<li>PCR: 1,5 mg/L.</li>'
                . '<li>Lp(a): 315 nmol/L.</li>'
                . '</ul>'],
        ],

        'terapeutico' => [
            'h1'     => ['label' => 'Título de la sección', 'type' => 'text',     'default' => 'Planteamiento terapéutico'],
            'p1'     => ['label' => 'Texto introductorio',  'type' => 'textarea', 'default' => 'Tras buena evolución clínica, Juan fue dado de alta para seguimiento estricto en consultas.'],
            'h_trat' => ['label' => 'Subtítulo — tratamiento', 'type' => 'text',  'default' => 'Tratamiento farmacológico:'],
            'lista'  => ['label' => 'Tratamiento (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>AAS: 100 mg/24 h.</li>'
                . '<li>Prasugrel: 10 mg/24 h.</li>'
                . '<li>Ramipril: 5 mg/24 h.</li>'
                . '<li>Atorvastatina/ezetimiba: 80/10 mg/24 h.</li>'
                . '<li>Ácido bempedoico: 180 mg/24 h.</li>'
                . '<li>Semaglutida: 2,4 mg/semana.</li>'
                . '</ul>'],
        ],

        'monitorizacion' => [
            'h1' => ['label' => 'Título de la sección', 'type' => 'text',     'default' => 'Monitorización y seguimiento'],
            'p1' => ['label' => 'Texto introductorio',  'type' => 'textarea', 'default' => 'Tras la reevaluación del paciente y obtener el valor de Lp(a), se solicitó a farmacia tratamiento con inclisirán por evento recurrente en paciente polivascular con terapia hipolipemiante óptima, que fue aceptado por parte de la farmacia hospitalaria.'],
        ],

        'monitorizacion-2' => [
            'h1'         => ['label' => 'Título de la sección', 'type' => 'text',     'default' => 'Monitorización y seguimiento 2'],
            'p1'         => ['label' => 'Texto introductorio',  'type' => 'textarea', 'default' => 'Una vez optimizado el tratamiento con inclisirán, al mes se repite la analítica. Perfil lipídico completo (tras 1 mes de inclisirán, 1.ª dosis):'],
            'lista'      => ['label' => 'Perfil lipídico tras inclisirán (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>CT: 103 mg/dL.</li>'
                . '<li>cHDL: 42 mg/dL.</li>'
                . '<li>cLDL: 38 mg/dL.</li>'
                . '<li>TG: 115 mg/dL.</li>'
                . '<li>Colesterol no-HDL: 71 mg/dL.</li>'
                . '<li>ApoB: 45 mg/dL (0–100).</li>'
                . '<li>cVLDL calculado: 23 mg/dL (0–30).</li>'
                . '<li>TG/HDL: 2,7.</li>'
                . '<li>Partículas remanentes: 24 mg/dL.</li>'
                . '<li>Lp(a): 276 nmol/L.</li>'
                . '<li>HbA1c: 5,9%.</li>'
                . '<li>GLU: 91 mg/dL.</li>'
                . '</ul>'],
            'comentario' => ['label' => 'Comentario del perfil', 'type' => 'textarea', 'default' => 'Ha alcanzado el objetivo de cLDL y ApoB tras inclisirán; el colesterol no-HDL queda en 71 mg/dL, ligeramente por encima del objetivo <70 mg/dL de la categoría de riesgo extremo. La Lp(a) disminuye modestamente, pero permanece marcadamente elevada.'],
            'screening1' => ['label' => 'Screening — párrafo 1', 'type' => 'textarea', 'default' => 'Juan es consciente de que su riesgo cardiovascular es excepcionalmente alto y de que es portador de un factor sobre el que el tratamiento actual solo tiene un efecto parcial. Asume que debe extremar su autocuidado y la cumplimentación farmacológica.'],
            'screening2' => ['label' => 'Screening — párrafo 2', 'type' => 'textarea', 'default' => 'De acuerdo con sus resultados, se recomienda screening familiar.'],
            'screening3' => ['label' => 'Screening — párrafo 3', 'type' => 'textarea', 'default' => 'Screening familiar: dado que se determina Lp(a) >90% por factores genéticos, los hijos de Juan tienen una probabilidad del 50% de heredar niveles elevados. Se recomienda medir la Lp(a) al menos una vez en la vida a todos los familiares de primer grado (hijos, hermanos) a partir de los 18 años.'],
            'cierre'     => ['label' => 'Texto de cierre', 'type' => 'textarea', 'default' => 'Aquí es donde surge la verdadera incógnita: ¿hemos hecho todo lo posible... o solo hemos tratado una parte del problema? Tal vez la respuesta pueda estar más cerca de lo que pensamos, marcando el siguiente capítulo en el manejo del riesgo cardiovascular residual.'],
        ],

        'mantenimiento' => [
            'h1'         => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Terapia de mantenimiento al alta de rehabilitación cardiaca'],
            'h_perfil'   => ['label' => 'Subtítulo — perfil lipídico', 'type' => 'text',     'default' => 'Perfil lipídico tras 1 mes de inclisirán (1.ª dosis)'],
            'p1'         => ['label' => 'Intro del perfil', 'type' => 'textarea', 'default' => 'Una vez optimizado el tratamiento con inclisirán, al mes se repite la analítica. Perfil lipídico completo (tras 1 mes de inclisirán, 1.ª dosis):'],
            'lista'      => ['label' => 'Perfil lipídico (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>CT: 103 mg/dL.</li>'
                . '<li>cHDL: 42 mg/dL.</li>'
                . '<li>cLDL: 38 mg/dL.</li>'
                . '<li>TG: 115 mg/dL.</li>'
                . '<li>Colesterol no-HDL: 71 mg/dL.</li>'
                . '<li>ApoB: 45 mg/dL (0–100).</li>'
                . '<li>cVLDL calculado: 23 mg/dL (0–30).</li>'
                . '<li>TG/HDL: 2,7.</li>'
                . '<li>Partículas remanentes: 24 mg/dL.</li>'
                . '<li>Lp(a): 276 nmol/L.</li>'
                . '<li>HbA1c: 5,9%.</li>'
                . '<li>GLU: 91 mg/dL.</li>'
                . '</ul>'],
            'comentario' => ['label' => 'Comentario del perfil', 'type' => 'textarea', 'default' => 'Ha alcanzado el objetivo de cLDL y ApoB tras inclisirán; el colesterol no-HDL queda en 71 mg/dL, ligeramente por encima del objetivo <70 mg/dL de la categoría de riesgo extremo. La Lp(a) disminuye modestamente, pero permanece marcadamente elevada.'],
            'h_reco'     => ['label' => 'Subtítulo — recomendaciones', 'type' => 'text', 'default' => 'Recomendaciones y screening familiar'],
            'reco1'      => ['label' => 'Recomendaciones — párrafo 1', 'type' => 'textarea', 'default' => 'Juan es consciente de que su riesgo cardiovascular es excepcionalmente alto y de que es portador de un factor sobre el que el tratamiento actual solo tiene un efecto parcial. Asume que debe extremar su autocuidado y la cumplimentación farmacológica.'],
            'reco2'      => ['label' => 'Recomendaciones — párrafo 2', 'type' => 'textarea', 'default' => 'De acuerdo con sus resultados, se recomienda screening familiar.'],
            'screening'  => ['label' => 'Screening familiar (texto tras la negrita)', 'type' => 'textarea', 'default' => 'dado que se determina Lp(a) >90% por factores genéticos, los hijos de Juan tienen una probabilidad del 50% de heredar niveles elevados. Se recomienda medir la Lp(a) al menos una vez en la vida a todos los familiares de primer grado (hijos, hermanos) a partir de los 18 años.'],
            'cierre'     => ['label' => 'Texto de cierre', 'type' => 'textarea', 'default' => 'Aquí es donde surge la verdadera incógnita: ¿hemos hecho todo lo posible... o solo hemos tratado una parte del problema? Tal vez la respuesta pueda estar más cerca de lo que pensamos, marcando el siguiente capítulo en el manejo del riesgo cardiovascular residual.'],
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

        'presentacion' => [
            'h1'         => ['label' => 'Título de la sección',         'type' => 'text', 'default' => 'Presentación del caso'],
            'h_historia' => ['label' => 'Subtítulo — Historia clínica', 'type' => 'text', 'default' => 'Historia clínica'],
            'tab_perfil'     => ['label' => 'Pestaña 1 (nombre)', 'type' => 'text', 'default' => 'Perfil del paciente'],
            'tab_historia'   => ['label' => 'Pestaña 2 (nombre)', 'type' => 'text', 'default' => 'Historia médica'],
            'tab_medicacion' => ['label' => 'Pestaña 3 (nombre)', 'type' => 'text', 'default' => 'Medicación'],
            'tab_alergias'   => ['label' => 'Pestaña 4 (nombre)', 'type' => 'text', 'default' => 'Alergias'],
            'perfil' => ['label' => 'Perfil del paciente (contenido)', 'type' => 'richtext', 'default' =>
                '<p><b>Edad y sexo:</b> varón, 55 años</p>'
                . '<p><b>Peso, estatura:</b> 74 kg, 167 cm (índice de masa corporal [IMC]: 26,5 kg/m²; sobrepeso)</p>'
                . '<p><b>Hábitos:</b> Exfumador desde hace 3 años</p>'
                . '<p><b>Ocupación:</b> Empresario</p>'
                . '<p><b>Estilo de vida:</b> Adherente a medicación y hábitos saludables, rehabilitación cardiaca completada</p>'],
            'historia' => ['label' => 'Historia médica (contenido)', 'type' => 'richtext', 'default' =>
                '<p>Hipertensión arterial (HTA).</p>'
                . '<p>Infarto agudo de miocardio con elevación del segmento ST (IAMCEST) inferoposterior a los 52 años, con dos stents farmacoactivos en coronaria derecha y lesión moderada (50%) en arteria descendente anterior.</p>'
                . '<p>Síndrome coronario agudo sin elevación del segmento ST (SCASEST) a los 53 años, con revascularización de descendente anterior media y de la primera rama diagonal (D1).</p>'
                . '<p>Enfermedad arterial periférica (EAP) documentada hace 2 años (índice tobillo-brazo [ITB] &lt;0,9).</p>'
                . '<p>Dislipidemia con lipoproteína(a) [Lp(a)] elevada (315 nmol/L en determinación basal).</p>'],
            'medicacion' => ['label' => 'Medicación (contenido)', 'type' => 'richtext', 'default' =>
                '<p>Ácido acetilsalicílico (AAS): 100 mg/24 h.</p>'
                . '<p>Ramipril: 5 mg/24 h.</p>'
                . '<p>Atorvastatina/ezetimiba: 80/10 mg/24 h.</p>'
                . '<p>Semaglutida: 2,4 mg/semana.</p>'
                . '<p>Inclisirán: dosis semestral (última dosis hace 3 meses) con buena tolerancia.</p>'],
            'alergias_p' => ['label' => 'Alergias (texto)', 'type' => 'textarea', 'default' => 'Sin alergias medicamentosas conocidas.'],
            'h_motivo'   => ['label' => 'Subtítulo — Motivo de consulta', 'type' => 'text',     'default' => 'Motivo de consulta'],
            'motivo'     => ['label' => 'Motivo de consulta (texto)',     'type' => 'textarea', 'default' => 'Juan acude al servicio de Urgencias del hospital acompañado por su esposa tras presentar, 3 horas antes, un cuadro de aparición brusca de debilidad en hemicuerpo izquierdo con inestabilidad y leve confusión. Los síntomas se han mantenido estables desde el inicio. No refiere cefalea, pérdida de conocimiento ni convulsiones. Se le realiza un electrocardiograma (ECG) en el que se observa taquicardia sinusal. Dado su historial de enfermedad cardiovascular (ECV) polivascular y Lp(a) elevada, la sospecha de ictus isquémico es alta.'],
        ],

        'pruebas' => [
            'h1'            => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Pruebas complementarias'],
            'tab_tc'        => ['label' => 'Pestaña 1 (nombre)', 'type' => 'text', 'default' => 'TC craneal'],
            'tab_angiotc'   => ['label' => 'Pestaña 2 (nombre)', 'type' => 'text', 'default' => 'Angio-TC'],
            'tab_rm'        => ['label' => 'Pestaña 3 (nombre)', 'type' => 'text', 'default' => 'RM cerebral'],
            'tab_revasc'    => ['label' => 'Pestaña 4 (nombre)', 'type' => 'text', 'default' => 'Revascularización'],
            'tab_analitica' => ['label' => 'Pestaña 5 (nombre)', 'type' => 'text', 'default' => 'Analítica sanguínea'],

            'tc_h'   => ['label' => 'TC craneal — subtítulo', 'type' => 'text',  'default' => 'Tomografía computarizada (TC) craneal'],
            'img_tc' => ['label' => 'TC craneal — imagen',    'type' => 'image', 'default' => 'images/tc-craneal-ingreso3.jpg'],
            'tc_cap' => ['label' => 'TC craneal — pie de figura', 'type' => 'text', 'default' => 'Figura 1. TC craneal sin contraste: ausencia de hemorragia intracraneal y de signos de infarto agudo en territorio arterial definido.'],

            'angiotc_h' => ['label' => 'Angio-TC — subtítulo', 'type' => 'text',     'default' => 'Angio-TC de vasos intracraneales y supraaórticos'],
            'angiotc_p' => ['label' => 'Angio-TC — texto',     'type' => 'textarea', 'default' => 'Lesión grave (90%) de la arteria carótida interna derecha. Placas de ateroma en bulbo carotídeo izquierdo con estenosis <50%. Signos de enfermedad aterosclerótica difusa en arco aórtico y arterias supraaórticas.'],

            'rm_h' => ['label' => 'RM cerebral — subtítulo', 'type' => 'text',     'default' => 'Resonancia magnética (RM) cerebral a las 48 horas'],
            'rm_p' => ['label' => 'RM cerebral — texto',     'type' => 'textarea', 'default' => 'Infarto isquémico agudo hemisférico derecho de localización subinsular y capsular que se extiende a corona radiada. Sin transformación hemorrágica. Leucoaraiosis periventricular ligera.'],

            'revasc_h' => ['label' => 'Revascularización — subtítulo', 'type' => 'text',     'default' => 'Revascularización'],
            'revasc_p' => ['label' => 'Revascularización — texto',     'type' => 'textarea', 'default' => 'Se realiza endarterectomía carotídea derecha emergente con buen resultado y sin complicaciones.'],

            'ana_h'    => ['label' => 'Analítica — subtítulo', 'type' => 'text', 'default' => 'Analítica sanguínea'],
            'ana_list' => ['label' => 'Analítica — valores (lista con formato)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list">'
                . '<li>Glucosa plasmática (GLU): 98 mg/dL.</li>'
                . '<li>Hemoglobina glicada (HbA1c): 5,8%.</li>'
                . '<li>Colesterol total (CT): 101 mg/dL.</li>'
                . '<li>Triglicéridos (TG): 95 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de alta densidad (cHDL): 40 mg/dL.</li>'
                . '<li>Colesterol unido a lipoproteínas de baja densidad (cLDL): 41 mg/dL.</li>'
                . '<li>Colesterol no-HDL: 70 mg/dL.</li>'
                . '<li>Apolipoproteína B (apoB): 46 mg/dL.</li>'
                . '<li>TG/HDL: 2,3.</li>'
                . '<li>Proteína C reactiva (PCR) ultrasensible: 1,2 mg/L.</li>'
                . '<li>Creatinina: 0,72 mg/dL (tasa de filtrado glomerular [TFG] estimada mediante la ecuación Chronic Kidney Disease Epidemiology Collaboration [CKD-EPI]: 98 mL/min/1,73 m²).</li>'
                . '<li>Hemograma, coagulación, función hepática, ferrocinética y perfil tiroideo: normales.</li>'
                . '<li>Lp(a) previa tras 1 mes de tratamiento con inclisirán: 276 nmol/L.</li>'
                . '</ul>'],
        ],

        'riesgo' => [
            'h1' => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Evaluación del riesgo cardiovascular'],
        ],

        'terapeutico' => [
            'h1' => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Planteamiento terapéutico'],
        ],

        'monitorizacion' => [
            'h1' => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Terapias emergentes anti-Lp(a): pelacarsen y ensayo HORIZON'],
        ],

        'monitorizacion-2' => [
            'h1'   => ['label' => 'Título de la sección',   'type' => 'text',     'default' => 'Evolución'],
            'evo1' => ['label' => 'Evolución — párrafo 1', 'type' => 'textarea', 'default' => 'Juan evoluciona favorablemente durante su estancia en el hospital, iniciando neurorrehabilitación precoz en la Unidad de Ictus con recuperación progresiva de la paresia.'],
            'evo2' => ['label' => 'Evolución — párrafo 2', 'type' => 'textarea', 'default' => 'Atribuye su último evento a transgresiones dietéticas muy ocasionales y a una reducción reciente de su nivel de ejercicio aeróbico. Es extremadamente consciente de que la dieta, el ejercicio y el cumplimiento estricto de su tratamiento son claves a partir de ahora para minimizar su riesgo cardiovascular y añadir cantidad y calidad de vida.'],
            'evo3' => ['label' => 'Evolución — párrafo 3', 'type' => 'textarea', 'default' => 'El mayor de sus tres hijos se ha realizado una revisión cardiovascular completa con hallazgo de un cLDL de 135 mg/dL y una Lp(a) de 269 nmol/L. Ha dejado de fumar y comenzado a modificar sus hábitos con dieta cardiosaludable y ejercicio físico aeróbico, combinado con un programa específico de fuerza (en total >300 minutos por semana), pendiente de evolución y analítica para valorar la necesidad de tratamiento farmacológico. Ni él ni Juan quieren que se repita su historia.'],
        ],

        'mantenimiento' => [
            'h1'        => ['label' => 'Título de la sección',    'type' => 'text',  'default' => 'Terapia de mantenimiento al alta de rehabilitación cardiaca'],
            'video'     => ['label' => 'Vídeo explicativo (MP4/WebM)', 'type' => 'video', 'default' => 'videos/mantenimiento-3.mp4'],
            'video_cap' => ['label' => 'Pie del vídeo',              'type' => 'text',  'default' => 'Vídeo explicativo del caso.'],
        ],

        'puntos-clave' => [
            'h1'    => ['label' => 'Título de la sección', 'type' => 'text', 'default' => 'Puntos clave'],
            'lista' => ['label' => 'Puntos clave (lista con formato y citas)', 'type' => 'richtext', 'default' =>
                '<ul class="analitica-list"><li style="margin-bottom:12px;">La Lp(a) elevada es un factor de riesgo causal e independiente para el ictus isquémico aterotrombótico, incluyendo recurrencias, independientemente de los niveles de cLDL<sup>1-4,6</sup>.</li><li style="margin-bottom:12px;">El ictus aterotrombótico es una de las manifestaciones cardiovasculares de la enfermedad aterosclerótica promovida por la Lp(a), junto con el IAM y la EAP<sup>1,3,4</sup>.</li><li style="margin-bottom:12px;">No existe ninguna terapia aprobada específicamente para reducir la Lp(a), pero el pelacarsen (ASO), el olpasiran y el lepodisiran (ambos siRNA) han demostrado reducciones &gt;80–95% en estudios de fase II<sup>8,9,11,12</sup>.</li><li style="margin-bottom:12px;">El ensayo Lp(a)HORIZON (NCT04023552) es el primer estudio de fase III diseñado para evaluar si la reducción de Lp(a) con pelacarsen (80 mg en administración subcutánea mensual) disminuye los eventos cardiovasculares en 8323 pacientes con ECV establecida y Lp(a) ≥70 mg/dL<sup>7,14</sup>.</li><li style="margin-bottom:12px;">En los pacientes con ictus isquémico, Lp(a) elevada y buen control de cLDL, deben considerarse el acceso precoz al tratamiento o su inclusión en ensayos clínicos en fase III<sup>1,7</sup>.</li><li style="margin-bottom:12px;">Adicionalmente, la estrategia debe centrarse en la reducción máxima de todos los factores de riesgo modificables y en el cribado familiar de Lp(a) en familiares de primer grado<sup>1-3</sup>.</li></ul>'],
        ],

        'resumen' => [
            'archivo' => ['label' => 'Archivo de “Descargar caso” (PDF/Word)', 'type' => 'doc', 'default' => 'casos/caso-ingreso-3.docx'],
        ],
    ],

];
