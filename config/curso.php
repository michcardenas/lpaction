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

    // Medallas según el Score final (verde − rojo). Escala sobre el máximo del ingreso (450 = 9 correctas × 50).
    // Botones por nivel: sin/bronce → solo "Volver al temario"; plata/oro → "Finalizar caso" + "Mejorar puntuación".
    // Acciones: 'temario'/'finalizar' → portal del curso; 'mejorar' → vuelve a la etapa (cierra el modal) a repasar.
    'medallas' => [
        [
            'key' => 'sin', 'min' => 0, 'label' => 'Sin medalla', 'color' => '#9aa0a6',
            'titulo' => 'Resultado insuficiente',
            'texto'  => 'No se ha alcanzado el nivel de concordancia clínica necesario para completar el caso. Revisa los contenidos asociados y repite las etapas señaladas.',
            'botones' => [
                ['texto' => 'Volver al temario', 'estilo' => 'ghost', 'accion' => 'temario'],
            ],
        ],
        [
            'key' => 'bronce', 'min' => 200, 'label' => 'Medalla de bronce', 'color' => '#cd7f32',
            'titulo' => 'Requiere refuerzo',
            'texto'  => 'El resultado muestra una concordancia clínica parcial. Para mejorar la puntuación, repite las evaluaciones señaladas y revisa los criterios del caso.',
            // Texto del pop-up que aparece al ALCANZAR la medalla durante el curso (más corto que el final).
            'unlock' => [
                'titulo' => '¡Medalla de bronce alcanzada!',
                'texto'  => 'Concordancia clínica parcial. Hay decisiones correctas, pero aún quedan criterios clave por reforzar.',
            ],
            'botones' => [
                ['texto' => 'Volver al temario', 'estilo' => 'ghost', 'accion' => 'temario'],
            ],
        ],
        [
            'key' => 'plata', 'min' => 300, 'label' => 'Medalla de plata', 'color' => '#c4ccd2',
            'titulo' => 'Buen nivel de concordancia clínica',
            'texto'  => 'El caso se ha resuelto de forma adecuada, aunque existe margen de mejora. Puedes finalizar o revisar las etapas marcadas para intentar alcanzar el nivel oro.',
            'unlock' => [
                'titulo' => '¡Medalla de plata alcanzada!',
                'texto'  => 'Has demostrado un manejo adecuado del caso. Algunas decisiones podrían optimizarse para mejorar el nivel de concordancia clínica.',
            ],
            'botones' => [
                ['texto' => 'Finalizar caso', 'estilo' => 'cyan', 'accion' => 'continuar'],
                ['texto' => 'Mejorar puntuación', 'estilo' => 'ghost', 'accion' => 'mejorar'],
            ],
        ],
        [
            'key' => 'oro', 'min' => 400, 'label' => 'Medalla de oro', 'color' => '#f2c14e',
            'titulo' => 'Manejo clínico excelente',
            'texto'  => 'Has completado el caso con un desempeño óptimo en las decisiones clave. Resultado alineado con el abordaje clínico recomendado en el recorrido.',
            'unlock' => [
                'titulo' => '¡Medalla de oro alcanzada!',
                'texto'  => 'Excelente. Has completado el caso con un manejo óptimo y alta concordancia con los criterios clínicos del recorrido.',
            ],
            'botones' => [
                ['texto' => 'Finalizar caso', 'estilo' => 'cyan', 'accion' => 'continuar'],
                ['texto' => 'Mejorar puntuación', 'estilo' => 'ghost', 'accion' => 'mejorar'],
            ],
        ],
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

    // Bibliografía del módulo (34 referencias, se numera sola en la vista).
    'bibliografia' => [
        'Mehta A, Shapiro MD. Apolipoproteins in vascular biology and atherosclerotic disease. Nat Rev Cardiol. 2022;19(3):168-79. doi: 10.1038/s41569-021-00613-5.',
        'Panza GA, Blazek O, Tortora J, Saucier S, Fernandez AB. Prevalence of lipoprotein(a) measurement in patients with or at risk of cardiovascular disease. J Clin Lipidol. 2023;17(6):748-55. doi: 10.1016/j.jacl.2023.09.016.',
        'Nissen SE, Wolski K., Cho L. et al, Lipoprotein(a) levels in a global population with established atherosclerotic cardiovascular disease. Open Heart. 2022;9(2):e002060. doi: 10.1136/openhrt-2022-002060.',
        'Mach F, Koskinas KC, Roeters van Lennep JE, Tokgözoğlu L, Badimon L, Baigent C, et al. 2025 focused update of the 2019 ESC/EAS guidelines for the management of dyslipidaemias. Eur Heart J. 2025;46(42):4359-78. doi: 10.1093/eurheartj/ehaf190.',
        'Michos ED, Saucier S, Mehran R, Koschinsky ML. Lipoprotein(a) and women´s cardiovascular health. A review. JACC Adv. 2026;102744. doi: 10.1016/j.jacadv.2026.102744.',
        'Kronenberg F, Mora S, Stroes ESG, Ference BA, Arsenault BJ, Berglund L, et al. Lipoprotein(a) in atherosclerotic cardiovascular disease and aortic stenosis: a European Atherosclerosis Society consensus statement. Eur Heart J. 2022;43(39):3925-46. doi: 10.1093/eurheartj/ehac361.',
        'Satała J, Witkowska A, Pawlos A, et al. Changes in lipoprotein(a) concentrations in patients with acute coronary syndrome. Pol Arch Intern Med. 2025;135:16959. doi: 10.20452/pamw.16959.',
        'Glavinovic T, Thanassoulis G, de Graaf J, Sniderman AD. Physiological bases for the superiority of apolipoprotein B over low-density lipoprotein cholesterol and non–high-density lipoprotein cholesterol as a marker of cardiovascular risk. J Am Heart Assoc. 2022;11(20):e025858. doi: 10.1161/JAHA.122.025858.',
        'Galimberti F, Casula M, Olmastroni E. Apolipoprotein B compared with low-density lipoprotein cholesterol in the atherosclerotic cardiovascular diseases risk assessment. Pharmacol Res. 2023;195:106873. doi: 10.1016/j.phrs.2023.106873.',
        'Johannesen CDL, Langsted A, Nordestgaard BG, Mortensen MB. Excess apolipoprotein B and cardiovascular risk in women and men. J Am Coll Cardiol. 2024;83(23):2262-73. doi: 10.1016/j.jacc.2024.03.423.',
        'Mudd JO, Borlaug BA, Johnston PV, Kral BG, Rouf R, Blumenthal RS, et al. Beyond low-density lipoprotein cholesterol: defining the role of low-density lipoprotein heterogeneity in coronary artery disease. J Am Coll Cardiol. 2007;50(18):1735-41. doi: 10.1016/j.jacc.2007.07.045.',
        'Sniderman AD, Dufresne L, Pencina KM, Bilgic S, Thanassoulis G, Pencina MJ. Discordance among apoB, non-HDL cholesterol, and triglycerides: implications for cardiovascular prevention. Eur Heart J. 2024;45(27):2410-18. doi: 10.1093/eurheartj/ehae258.',
        'Johannesen CDL, Mortensen MB, Langsted A, Nordestgaard BG. Apolipoprotein B and non-HDL cholesterol better reflect residual risk than LDL cholesterol in statin-treated patients. J Am Coll Cardiol. 2021;77(11):1439-50. doi: 10.1016/j.jacc.2021.01.027.',
        'Carr SS, Hooper AJ, Sullivan DR, Burnett JR. Non-HDL-cholesterol and apolipoprotein B compared with LDL-cholesterol in atherosclerotic cardiovascular disease risk assessment. Pathology. 2019;51(2):148-54. doi: 10.1016/j.pathol.2018.11.006.',
        'Tsimikas S, Gordts PLSM, Nora C, Yeang C, Witztum JL. Statin therapy increases lipoprotein(a) levels. Eur Heart J. 2020;41(24):2275-84. doi: 10.1093/eurheartj/ehz310.',
        'Yndigegn T, Lindahl B, Mars K, Alfredsson J, Benatar J, Brandin L, et al. Beta-blockers after myocardial infarction and preserved ejection fraction. N Engl J Med. 2024;390(15):1372-81. doi: 10.1056/NEJMoa2401479.',
        'Kristensen AMD, Rossello X, Atar D, Yndigegn T, Kimura T, Latini R, et al. Beta-blockers after myocardial infarction with normal ejection fraction. N Engl J Med. 2026;394(6):540-50. doi: 10.1056/NEJMoa2512686.',
        'Rossello X, Prescott EIB, Kristensen AMD, Latini R, Fuster V, Fagerland MW, et al. β-blockers after myocardial infarction with mildly reduced ejection fraction: an individual patient data meta-analysis of randomised controlled trials. Lancet. 2025;406(10508):1128-37. doi: 10.1016/S0140-6736(25)01592-2.',
        'Ibanez B, Latini R, Rossello X, Dominguez-Rodriguez A, Fernández-Vazquez F, Pelizzoni V, et al. Beta-blockers after myocardial infarction without reduced ejection fraction. N Engl J Med. 2025;393(19):1889-900. doi: 10.1056/NEJMoa2504735.',
        'Carberry J, Marquis-Gravel G, O\'Meara E, Docherty KF. Where are we with treatment and prevention of heart failure in patients post-myocardial infarction? JACC Heart Fail. 2024;12(7):1157-65. doi: 10.1016/j.jchf.2024.04.025.',
        'Cannon CP, Blazing MA, Giugliano RP, McCagg A, White JA, Theroux P, et al.; IMPROVE-IT Investigators. Ezetimibe added to statin therapy after acute coronary syndromes. N Engl J Med. 2015;372(25):2387-97. doi: 10.1056/NEJMoa1410489.',
        'Leosdottir M, Schubert J, Brandts J, Gustafsson S, Cars T, Sundström J, et al. Early ezetimibe initiation after myocardial infarction protects against later cardiovascular outcomes in the SWEDEHEART registry. J Am Coll Cardiol. 2025;85(15):1550-64. doi: 10.1016/j.jacc.2025.02.007.',
        'Rao SV, O\'Donoghue ML, Ruel M, Rab T, Tamis-Holland JE, Alexander JH, et al. 2025 ACC/AHA/ACEP/NAEMSP/SCAI guideline for the management of patients with acute coronary syndromes: a report of the American College of Cardiology/American Heart Association Joint Committee on Clinical Practice Guidelines. Circulation. 2025;151(13):e771-862. doi: 10.1161/CIR.0000000000001309.',
        'Lincoff AM, Brown-Frandsen K, Colhoun HM, Deanfield J, Emerson SS, Esbjerg S, et al. Semaglutide and cardiovascular outcomes in obesity without diabetes. N Engl J Med. 2023;389(24):2221-32. doi: 10.1056/NEJMoa2307563.',
        'Ferrari R, Gowdak LHW, Padilla F, Quek DKL, Ray S, Rosano G, et al. The European Society of Cardiology 2024 guidelines on chronic coronary syndromes: a critical appraisal. J Clin Med. 2025;14(4):1161. doi: 10.3390/jcm14041161.',
        'Vrints C, Andreotti F, Koskinas KC, Rossello X, Adamo M, Ainslie J, et al.; ESC Scientific Document Group. 2024 ESC Guidelines for the management of chronic coronary syndromes. Eur Heart J. 2024;45(36):3415-3537. doi: 10.1093/eurheartj/ehae177. Erratum in: Eur Heart J. 2025;46(16):1565. doi: 10.1093/eurheartj/ehaf079.',
        'Goldberg AC, Leiter LA, Stroes ESG, Baum SJ, Hanselman JC, Bloedon LT, et al. Effect of bempedoic acid vs placebo added to maximally tolerated statins on low-density lipoprotein cholesterol in patients at high risk for cardiovascular disease: the CLEAR Wisdom randomized clinical trial. JAMA. 2019;322(18):1780-8. doi: 10.1001/jama.2019.16585.',
        'Raposeiras-Roubín S, Abu-Assi E, Jiménez Méndez C, Mínguez de la Guía E, Pérez Rivera JÁ, Marcos Mangas M, et al. Triple versus dual lipid-lowering therapy in acute coronary syndrome: the ES-BempedACS randomized clinical trial. Circulation. 2026;153(3):140-9. doi: 10.1161/CIRCULATIONAHA.125.075388.',
        'Ray KK, Bays HE, Catapano AL, Lalwani ND, Bloedon LT, Sterling LR, et al.; CLEAR Harmony Trial. Safety and efficacy of bempedoic acid to reduce LDL cholesterol. N Engl J Med. 2019;380(11):1022-32. doi: 10.1056/NEJMoa1803917.',
        'Bhatt DL, Steg PG, Miller M, Brinton EA, Jacobson TA, Ketchum SB, et al. Cardiovascular risk reduction with icosapent ethyl for hypertriglyceridemia. N Engl J Med. 2019;380(1):11-22. doi: 10.1056/NEJMoa1812792.',
        'Miller M, Bhatt DL, Brinton EA, Jacobson TA, Steg PG, Pineda AL, et al. Effectiveness of icosapent ethyl on first and total cardiovascular events in patients with metabolic syndrome, but without diabetes: REDUCE-IT MetSyn. Eur Heart J Open. 2023;3(6):oead114. doi: 10.1093/ehjopen/oead114.',
        'Arnold N, Blaum C, Goßling A, Brunner FJ, Bay B, Zeller T, et al. Impact of lipoprotein(a) level on low-density lipoprotein cholesterol- or apolipoprotein B-related risk of coronary heart disease. J Am Coll Cardiol. 2024;84(2):165-77. doi: 10.1016/j.jacc.2024.04.050.',
        'Khunti K, Danese MD, Kutikova L, Catterick D, Sorio-Vilela F, Gleeson M, et al. Association of a combined measure of adherence and treatment intensity with cardiovascular outcomes in patients with atherosclerosis or other cardiovascular risk factors treated with statins and/or ezetimibe. JAMA Netw Open. 2018;1(8):e185554. doi: 10.1001/jamanetworkopen.2018.5554.',
        'Preiss D, Tobert JA, Hovingh GK, Reith C. Lipid-modifying agents, from statins to PCSK9 inhibitors: JACC focus seminar. J Am Coll Cardiol. 2020;75(16):1945-55. doi: 10.1016/j.jacc.2019.11.072.',
    ],

    // Cuestionario de la etapa "Pruebas complementarias" (respuesta única).
    'pregunta_pruebas' => [
        'enunciado'   => '¿Qué determinación del perfil lipídico añadirías en esta analítica?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 50,
        'opciones'    => [
            [
                'key' => 'apoa', 'texto' => 'Apolipoproteína A (ApoA).', 'correcta' => false, 'puntos' => -50,
                'justificacion' => 'La ApoA es un marcador útil del riesgo cardiovascular (RCV). Sin embargo, no aporta tanta información como la Apo B o la Lp(a) sobre el riesgo aterogénico del paciente. La ApoA-I es el principal componente de HDL y favorece el transporte reverso de colesterol, con efecto protector vascular. Unos niveles altos se asocian a menor RCV por su acción antiaterogénica y antiinflamatoria. En cambio, un desequilibrio con ApoB (partículas aterogénicas) aumenta el riesgo. El cociente ApoB/ApoA-I refleja este balance y es un mejor predictor que los lípidos convencionales: los valores elevados se relacionan con mayor riesgo de eventos cardiovasculares, incluso con LDL normal1.',
            ],
            [
                'key' => 'lpa', 'texto' => 'Lipoproteína (a) [Lp(a)].', 'correcta' => true, 'puntos' => 50,
                'justificacion' => 'La Lp(a) debe medirse al menos una vez en adultos y se recomienda incluirla en la estratificación del riesgo, especialmente en pacientes con enfermedad cardiovascular establecida o SCA. Aunque sus niveles están determinados en gran medida por la genética, pueden variar en el contexto del SCA; por ello, si se mide durante el evento agudo, es razonable repetirla a los 1–3 meses en situación clínica estable para confirmar el valor, especialmente si el resultado condiciona decisiones de riesgo o tratamiento. En seguimiento, no se recomiendan determinaciones seriadas sistemáticas, salvo cambios clínicos relevantes o inicio de tratamiento específico2-7.',
            ],
            [
                'key' => 'apob', 'texto' => 'Apolipoproteína B (ApoB).', 'correcta' => true, 'puntos' => 50,
                'justificacion' => 'La apoB es recomendable junto al cLDL para evaluar el riesgo aterogénico, ya que refleja el número total de partículas aterogénicas [LDL, VLDL, lipoproteínas de densidad intermedia (IDL) y Lp(a)], a diferencia del LDL, que solo mide su contenido en colesterol. Es especialmente útil en situaciones de discordancia (diabetes, hipertrigliceridemia, estatinas). Además, es una medida precisa, estandarizada y sin necesidad de ayuno. Permite identificar mejor el riesgo residual y optimizar el tratamiento, con mejor rendimiento que el cLDL8-14.',
            ],
            [
                'key' => 'cthdl', 'texto' => 'CT/HDL.', 'correcta' => false, 'puntos' => -50,
                'justificacion' => 'El cociente CT/HDL se ha empleado tradicionalmente como marcador del RCV. Sin embargo, presenta limitaciones relevantes frente a parámetros más actuales como la apoB o la Lp(a). Este cociente ofrece una estimación indirecta del equilibrio entre lipoproteínas aterogénicas y antiaterogénicas, sin reflejar el número real de partículas aterogénicas ni su heterogeneidad. En situaciones frecuentes como la diabetes, el síndrome metabólico o la hipertrigliceridemia, puede infraestimar el riesgo. En cambio, la apoB cuantifica directamente el número de partículas aterogénicas y la Lp(a) identifica el riesgo residual independiente, proporcionando una estratificación más precisa del RCV.',
            ],
        ],
    ],

    // Cuestionario de la etapa "Evaluación del riesgo cardiovascular" (respuesta única).
    'pregunta_riesgo' => [
        'enunciado'   => 'En el caso de nuestro paciente, si quisiéramos realizar una estratificación de riesgo cardiovascular de alta precisión, ¿cuál sería el criterio más adecuado sobre el número de determinaciones de Lp(a) que deben realizarse a un paciente?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 100,
        'opciones'    => [
            [
                'key' => 'unica', 'texto' => 'Una única determinación basal en la juventud.', 'correcta' => false, 'puntos' => -20,
                'justificacion' => 'Aunque esta ha sido la recomendación clásica de las guías y la práctica habitual, la evidencia reciente en pacientes con SCA apoya considerar una segunda determinación en situación estable, especialmente si la medición se realizó durante el evento agudo y el resultado condiciona la estratificación del riesgo o decisiones terapéuticas6,7.',
            ],
            [
                'key' => 'semestral', 'texto' => 'Mediciones semestrales/anuales sistemáticas para monitorizar la eficacia del tratamiento hipolipemiante.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'A diferencia del cLDL o los TG, la Lp(a) apenas varía con los hipolipemiantes convencionales, ya que sus niveles están determinados principalmente por la expresión del gen LPA y no se modifican de forma relevante con la dieta, el ejercicio o las estatinas, y pueden incluso aumentar15. No obstante, algunas estrategias terapéuticas específicas, como la terapia dirigida frente a la proproteína convertasa subtilisina/kexina tipo 9 (TD a PCSK9), han demostrado capacidad para reducir sus niveles, aunque de forma limitada.',
            ],
            [
                'key' => 'tres', 'texto' => 'Tres determinaciones anuales, calculando una media aritmética entre las tres que compense las oscilaciones de la Lp(a).', 'correcta' => false, 'puntos' => -50,
                'justificacion' => 'La Lp(a) presenta una determinación genética superior al 90%, con escasa variabilidad fisiológica en ausencia de cambios metabólicos relevantes (como enfermedad renal crónica o menopausia) o eventos cardiovasculares como el SCA. Por ello, su medición repetida en pacientes metabólicamente estables resulta poco eficiente, ya que no aporta cambios en la estratificación del riesgo ni en la toma de decisiones terapéuticas.',
            ],
            [
                'key' => 'dos', 'texto' => 'Realizar al menos dos mediciones: una inicial de cribado y una segunda 1–3 meses después, o bien tras cambios metabólicos mayores o eventos cardiovasculares.', 'correcta' => true, 'puntos' => 100,
                'justificacion' => 'La Lp(a) puede mostrar variación en el contexto de un evento cardiovascular agudo, por lo que conviene medirla durante el ingreso junto al perfil lipídico y repetir su determinación a los 1–3 meses, cuando el paciente se encuentre clínicamente estable, para confirmar un valor basal más representativo si este condiciona decisiones clínicas. Tras un infarto agudo de miocardio (IAM), se han descrito diferencias entre los niveles medidos en fase aguda y los obtenidos posteriormente. Existe también la recomendación de repetir la medición en situaciones de cambios metabólicos mayores, como tras la menopausia en mujeres con una determinación previa de riesgo intermedio, en los que un valor elevado posterior pueda determinar cambios de la estrategia de seguimiento5. En seguimiento estable, no se recomiendan mediciones seriadas sistemáticas, salvo cambios clínicos relevantes o tratamientos específicos dirigidos a la Lp(a)5-7.',
            ],
        ],
    ],

    // Cuestionario de la etapa "Planteamiento terapéutico" (respuesta única).
    'pregunta_terapeutico' => [
        'enunciado'   => 'En cuanto al tratamiento al alta, ¿qué harías diferente?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 100,
        'opciones'    => [
            [
                'key' => 'betabloqueantes', 'texto' => 'No pautaría betabloqueantes.', 'correcta' => true, 'puntos' => 100,
                'justificacion' => 'No se aconseja el uso rutinario de betabloqueantes tras un infarto de miocardio en pacientes revascularizados con fracción de eyección ≥50% si no existen otras indicaciones. La evidencia actual muestra que no reducen la mortalidad, el reinfarto ni la insuficiencia cardiaca en este grupo16,17. A pesar de que las guías del American College of Cardiology (ACC) y la American Heart Association (AHA) los recomiendan, esta directriz se basa en estudios previos a la era actual, y la evidencia reciente ha confirmado la ausencia de beneficio en FEVI preservada17-20. Su perfil de seguridad es similar al placebo16. Por tanto, en un paciente con IAM y FEVI ≥50% no se recomienda su uso sistemático, en ausencia de otras indicaciones específicas.',
            ],
            [
                'key' => 'estatina', 'texto' => 'Pautaría de inicio solo estatina de alta potencia.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'En pacientes con SCA, se prefiere la terapia combinada con estatina de alta potencia y ezetimiba, debido a que conduce a una reducción más rápida e intensa del cLDL, con lo que se incrementa el porcentaje de pacientes que alcanzan objetivos (especialmente en pacientes de muy alto riesgo) y reduce el riesgo de desarrollar eventos cardiovasculares, en comparación con la monoterapia5. La combinación aporta una reducción adicional del 20–25% de cLDL y ha demostrado beneficio clínico (IMPROVE-IT)21. Las guías de la European Society of Cardiology (ESC) 2025 recomiendan iniciar esta estrategia antes del alta, evitando retrasos terapéuticos, así como considerar TD a PCSK9 si no se alcanzan objetivos5,22,23.',
            ],
            [
                'key' => 'nada', 'texto' => 'No haría nada diferente.', 'correcta' => false, 'puntos' => -20,
                'justificacion' => 'Tras la evidencia del ensayo REBOOT y de metaanálisis contemporáneos, no se recomienda el uso rutinario de betabloqueantes tras un IAM en pacientes revascularizados de forma completa y con FEVI conservada (>50%), ya que no han demostrado que reduzcan la mortalidad, el reinfarto ni la insuficiencia cardiaca. En este contexto, la estrategia más adecuada es optimizar el tratamiento de prevención secundaria (antiagregación, control lipídico intensivo, inhibidores de la enzima convertidora de la angiotensina [IECA] o antagonistas de los receptores de la angiotensina II [ARA-II] si están indicados, y control intensivo de los factores de riesgo). Los betabloqueantes quedarían reservados para indicaciones específicas como arritmias, angina o hipertensión no controlada19.',
            ],
            [
                'key' => 'antiagregacion', 'texto' => 'No pautaría doble antiagregación.', 'correcta' => false, 'puntos' => -50,
                'justificacion' => 'La doble antiagregación plaquetaria con aspirina y un inhibidor del receptor P2Y12 es un pilar fundamental tras un infarto con implante de stents DES. En general, tras un SCA se recomienda mantenerla durante 12 meses, con posibilidad de acortarla o individualizarla en función del riesgo isquémico y hemorrágico. El uso de AAS en monoterapia desde el inicio en este contexto se asocia a un mayor riesgo de eventos isquémicos, especialmente trombosis aguda y subaguda del stent23.',
            ],
        ],
    ],

    // Cuestionario de la etapa "Monitorización y seguimiento" (respuesta única).
    'pregunta_monitorizacion' => [
        'enunciado'   => 'En cuanto al tratamiento al alta del programa de rehabilitación cardiaca, ¿qué añadirías ahora?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 50,
        'opciones'    => [
            [
                'key' => 'semaglutida', 'texto' => 'Semaglutida.', 'correcta' => true, 'puntos' => 50,
                'justificacion' => 'Un paciente tras un IAM, con un IMC ≥27 kg/m² y sin diabetes cumple los criterios del estudio SELECT para tratamiento con semaglutida, con evidencia de beneficio cardiovascular. La Guía ESC 2024 sobre el diagnóstico y el tratamiento de los síndromes coronarios crónicos recomienda considerar su uso en prevención secundaria en este perfil de pacientes, ya que el estudio SELECT demostró una reducción significativa de los eventos cardiovasculares mayores con semaglutida 2,4 mg/semanal en pacientes con enfermedad cardiovascular establecida, sobrepeso u obesidad y sin diabetes, independientemente del valor de HbA1c. No obstante, su indicación depende de la aprobación regulatoria y su implementación local24-26.',
            ],
            [
                'key' => 'bempedoico', 'texto' => 'Ácido bempedoico es una opción por considerar.', 'correcta' => true, 'puntos' => 50,
                'justificacion' => 'El ácido bempedoico añadido a estatinas de alta potencia reduce el cLDL en aproximadamente un 15–18%, como demostraron los estudios CLEAR Harmony y CLEAR Wisdom en pacientes con enfermedad cardiovascular aterosclerótica o hipercolesterolemia familiar, con resultados consistentes independientemente de la intensidad de la estatina. Sin embargo, la evidencia en contexto de triple terapia es limitada. El ensayo ES-BempeDACS mostró que añadir ácido bempedoico a estatina y ezetimiba en SCA no mejora el control de cLDL ni reduce eventos cardiovasculares a corto plazo, aunque es seguro. Por ello, las guías ESC 2025 lo recomiendan en pacientes que no alcanzan objetivos con estatina y ezetimiba o con intolerancia a estatinas5,27-29.',
            ],
            [
                'key' => 'mantener', 'texto' => 'Mantener tratamiento y control analítico a los 3 meses.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'La inercia terapéutica en estos pacientes es frecuente y se asocia a un peor control del RCV, favoreciendo la aparición de eventos adversos. Existe un claro beneficio tiempo-dependiente en la optimización precoz del tratamiento, por lo que el ajuste activo e intensivo de la terapia resulta clave para mejorar el pronóstico5,22.',
            ],
            [
                'key' => 'icosapento', 'texto' => 'Icosapento de etilo.', 'correcta' => false, 'puntos' => -70,
                'justificacion' => 'El icosapento de etilo no está indicado en este caso, ya que se reserva para pacientes con enfermedad cardiovascular aterosclerótica establecida, en tratamiento con estatinas, que presenten cifras de TG persistentemente elevadas (150–499 mg/dL) y cLDL comprendido entre 40 y 100 mg/dL. Su uso está orientado a reducir el riesgo cardiovascular residual, como demuestran las recomendaciones y el ensayo REDUCE-IT, con dosis de 4 g/día. Fuera de este perfil, no ha demostrado beneficio clínico30,31.',
            ],
        ],
    ],

    // Cuestionario de la etapa "Monitorización y seguimiento 2" (respuesta única).
    'pregunta_monitorizacion2' => [
        'enunciado'   => '¿A qué se puede atribuir la pobre respuesta al tratamiento hipolipemiante?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 30,
        'opciones'    => [
            [
                'key' => 'lpa', 'texto' => 'Elevación de Lp(a).', 'correcta' => true, 'puntos' => 30,
                'justificacion' => 'El colesterol contenido en la Lp(a) [Lp(a)-C] se incluye dentro de la medición estándar del cLDL, mientras que la Lp(a) no responde de forma significativa a estatinas, ezetimiba, ácido bempedoico ni a la mayoría de hipolipemiantes convencionales. En pacientes con Lp(a) elevada, una proporción relevante del cLDL medido corresponde a Lp(a)-C, que no se reduce con estos tratamientos, lo que puede aparentar una respuesta subóptima, pese a que el cLDL «real» [excluyendo Lp(a)-C] haya disminuido adecuadamente5,15,32.',
            ],
            [
                'key' => 'adherencia', 'texto' => 'Falta de adherencia terapéutica.', 'correcta' => true, 'puntos' => 50,
                'justificacion' => 'La falta de adherencia terapéutica es la causa más frecuente de respuesta insuficiente al tratamiento hipolipemiante. Puede deberse a efectos adversos, olvidos o falta de comprensión del beneficio. Su impacto supera al de otros factores y explica que una proporción significativa de pacientes no alcance los objetivos de cLDL33.',
            ],
            [
                'key' => 'pcsk9', 'texto' => 'Sobreexpresión o mutaciones de ganancia de función en PCSK9.', 'correcta' => true, 'puntos' => 20,
                'justificacion' => 'Una sobreexpresión de PCSK9 puede contribuir a una menor reducción de cLDL en pacientes tratados con hipolipemiantes de alta intensidad. La proteína PCSK9 favorece la degradación de los receptores LDL hepáticos, limitando la depuración del cLDL. Las estatinas aumentan la expresión de estos receptores; sin embargo, también incrementan la producción de PCSK9, lo cual atenúa parcialmente su efecto, especialmente en pacientes con sobreexpresión o mutaciones de ganancia de función en PCSK934.',
            ],
            [
                'key' => 'tiempo', 'texto' => 'Al poco tiempo transcurrido desde el inicio del tratamiento.', 'correcta' => false, 'puntos' => -100,
                'justificacion' => 'La mejoría del perfil lipídico tras la optimización terapéutica debería evidenciarse en un plazo de 4–12 semanas, y las guías recomiendan reevaluar el cLDL a las 4–6 semanas tras iniciar o intensificar el tratamiento hipolipemiante en el contexto de SCA. Ante un control subóptimo, resulta fundamental adoptar una actitud proactiva que evite la inercia terapéutica y permita una intensificación adecuada del tratamiento5.',
            ],
        ],
    ],

    // ================================================================
    // =====================  INGRESO 2  ==============================
    // ================================================================
    // Datos del paciente en el Ingreso 2 (Juan, 53 años, exfumador).
    // La imagen EVOLUCIONA con el avance (concepto "La evolución de Juan"):
    //   - activado 0%           → polo a rayas    (imagen)
    //   - en progreso >0%       → camisa gris      (imagen_progreso)
    //   - completado/aprobado   → Juan sano        (imagen_completado, se queda así)
    'paciente_2' => [
        'nombre' => 'Juan',
        'imagen'            => 'images/paciente_pantalla_2.png',    // Ingreso 2 recién activado (polo a rayas)
        'imagen_progreso'   => 'images/paciente_pantalla_2b.png',   // Ingreso 2 en progreso (camisa gris)
        'imagen_completado' => 'images/paciente_pantalla_2c.png',   // Ingreso 2 aprobado (Juan sano, brazos cruzados)
        'datos'  => [
            ['icon' => 'edad',  'texto' => '53 años'],
            ['icon' => 'fuma',  'texto' => 'Exfumador'],
            ['icon' => 'salud', 'texto' => 'Adherente a tratamiento y estilo de vida'],
        ],
    ],

    // Contenido narrativo del Ingreso 2 (textos, valores clínicos, medicación).
    'datos_ingreso_2' => [
        'perfil' => [
            'edad_sexo' => 'varón, 53 años',
            'peso_estatura' => '76 kg, 167 cm (índice de masa corporal [IMC]: 27,3 kg/m²; sobrepeso).',
            'habitos' => 'exfumador.',
            'ocupacion' => 'empresario.',
            'estilo_vida' => 'el paciente había sido adherente a la medicación y al estilo de vida.',
        ],
        'historia' => [
            'Hipertensión arterial (HTA).',
            'Infarto agudo de miocardio con elevación del segmento ST (IAMCEST) inferoposterior 10 meses antes, con dos stents farmacoactivos (stents DES) y lesión moderada 50% en la arteria descendente anterior (DA).',
        ],
        'medicacion' => [
            'Ácido acetilsalicílico (AAS): 100 mg/24 h.',
            'Prasugrel: 10 mg/24 h.',
            'Ramipril: 5 mg/24 h.',
            'Atorvastatina/ezetimiba: 80/10 mg/24 h.',
            'Ácido bempedoico: 180 mg/24 h.',
            'Semaglutida: 2,4 mg/semana.',
        ],
        'alergias' => 'Sin alergias medicamentosas conocidas.',
        'motivo_consulta' => 'El paciente vuelve a acudir al servicio de Urgencias de nuestro hospital, 10 meses después del primer evento, por un cuadro de dolor retroesternal opresivo y sensación de ahogo asociada a pequeños esfuerzos rápidamente progresivos hasta alcanzar el reposo de 15 días de evolución.',
        // ECG al ingreso
        'ecg_texto' => 'A su llegada al servicio de Urgencias, se le realiza ECG en ritmo sinusal y se orienta como síndrome coronario agudo sin elevación del segmento ST (SCASEST).',
        'ecg_caption' => 'Figura 1. Electrocardiograma al ingreso en ritmo sinusal, orientativo de síndrome coronario agudo sin elevación del segmento ST.',
        // Cateterismo cardíaco
        'cateterismo_texto' => 'Se realiza coronariografía emergente observando stents permeables en arteria coronaria derecha (CD) y progresión de lesión en DA, revascularizada con stent DES en DA media/D1. Además, en acceso femoral se aprecian placas de ateroma con estenosis arterial.',
        'video4_caption' => 'Vídeo 4. Cateterismo cardíaco. Se puede apreciar revascularización DAm-D1.',
        'video5_caption' => 'Vídeo 5. Arteriografía femoral. Placas de ateroma que condicionan estenosis.',
        // Ecocardiograma + ITB
        'eco_texto' => 'Ecocardiograma transtorácico: fracción de eyección del ventrículo izquierdo (FEVI) conservada: 56%. Hipocinesia ligera inferobasal.',
        'itb_texto' => 'Índice tobillo brazo (ITB) <0,9 = enfermedad arterial periférica.',
        // Analítica en urgencias (antes de Lp(a))
        'analitica_urgencias' => [
            'Troponina US: normal.',
            'Glucosa plasmática (GLU): 104 mg/dL.',
            'Hemoglobina glicada (HbA1c): 5,9%.',
            'Colesterol total (CT): 125 mg/dL.',
            'Triglicéridos (TG): 70 mg/dL.',
            'Colesterol unido a lipoproteínas de alta densidad (cHDL): 35 mg/dL.',
            'Colesterol unido a lipoproteínas de baja densidad (cLDL): 76 mg/dL.',
            'Colesterol no HDL: 90 mg/dL.',
            'Apolipoproteína B (ApoB): 86 mg/dL.',
            'Colesterol remanente: 14 mg/dL.',
            'Colesterol unido a lipoproteínas de muy baja densidad (cVLDL): 14 mg/dL.',
            'TG/HDL: 2.',
            'TG/Glucosa: 4,45.',
            'Proteína C reactiva (PCR): 1,5 mg/L.',
        ],
        // Analítica con Lp(a) — tras determinación
        'lpa_intro' => 'Tras el diagnóstico de SCASEST tipo angina inestable y revascularización, por fin se solicitó determinación de lipoproteína (a) [Lp(a)]:',
        'analitica_lpa' => [
            'GLU: 104 mg/dL.',
            'HbA1c: 5,9%.',
            'CT: 125 mg/dL.',
            'TG: 70 mg/dL.',
            'cHDL: 35 mg/dL.',
            'cLDL: 76 mg/dL.',
            'Colesterol no-HDL: 90 mg/dL.',
            'ApoB: 86 mg/dL.',
            'Colesterol remanente: 14 mg/dL.',
            'cVLDL: 14 mg/dL.',
            'TG/HDL: 2.',
            'TG/Glucosa: 4,45.',
            'PCR: 1,5 mg/L.',
            'Lp(a): 315 nmol/L.',
        ],
        // Tratamiento farmacológico tras alta
        'tratamiento_alta_intro' => 'Tras buena evolución clínica, Juan fue dado de alta para seguimiento estricto en consultas.',
        'tratamiento_alta' => [
            'AAS: 100 mg/24 h.',
            'Prasugrel: 10 mg/24 h.',
            'Ramipril: 5 mg/24 h.',
            'Atorvastatina/ezetimiba: 80/10 mg/24 h.',
            'Ácido bempedoico: 180 mg/24 h.',
            'Semaglutida: 2,4 mg/semana.',
        ],
        // Optimización con inclisirán
        'inclisiran_intro' => 'Tras la reevaluación del paciente y obtener el valor de Lp(a), se solicitó a farmacia tratamiento con inclisirán por evento recurrente en paciente polivascular con terapia hipolipemiante óptima, que fue aceptado por parte de la farmacia hospitalaria.',
        // Perfil lipídico tras 1 mes de inclisirán
        'perfil_post_inclisiran_intro' => 'Una vez optimizado el tratamiento con inclisirán, al mes se repite la analítica. Perfil lipídico completo (tras 1 mes de inclisirán, 1.ª dosis):',
        'perfil_post_inclisiran' => [
            'CT: 103 mg/dL.',
            'cHDL: 42 mg/dL.',
            'cLDL: 38 mg/dL.',
            'TG: 115 mg/dL.',
            'Colesterol no-HDL: 71 mg/dL.',
            'ApoB: 45 mg/dL (0–100).',
            'cVLDL calculado: 23 mg/dL (0–30).',
            'TG/HDL: 2,7.',
            'Partículas remanentes: 24 mg/dL.',
            'Lp(a): 276 nmol/L.',
            'HbA1c: 5,9%.',
            'GLU: 91 mg/dL.',
        ],
        'perfil_post_inclisiran_comentario' => 'Ha alcanzado el objetivo de cLDL y ApoB tras inclisirán; el colesterol no-HDL queda en 71 mg/dL, ligeramente por encima del objetivo <70 mg/dL de la categoría de riesgo extremo. La Lp(a) disminuye modestamente, pero permanece marcadamente elevada.',
        // Screening familiar
        'screening' => [
            'texto_1' => 'Juan es consciente de que su riesgo cardiovascular es excepcionalmente alto y de que es portador de un factor sobre el que el tratamiento actual solo tiene un efecto parcial. Asume que debe extremar su autocuidado y la cumplimentación farmacológica.',
            'texto_2' => 'De acuerdo con sus resultados, se recomienda screening familiar.',
            'texto_3' => 'Screening familiar: dado que se determina Lp(a) >90% por factores genéticos, los hijos de Juan tienen una probabilidad del 50% de heredar niveles elevados. Se recomienda medir la Lp(a) al menos una vez en la vida a todos los familiares de primer grado (hijos, hermanos) a partir de los 18 años.',
        ],
        'cierre' => 'Aquí es donde surge la verdadera incógnita: ¿hemos hecho todo lo posible... o solo hemos tratado una parte del problema? Tal vez la respuesta pueda estar más cerca de lo que pensamos, marcando el siguiente capítulo en el manejo del riesgo cardiovascular residual.',
    ],

    // Bibliografía del Ingreso 2 (34 referencias del PDF oficial).
    'bibliografia_2' => [
        'Sud M, Han L, Koh M, Abdel-Qadir H, Austin PC, Farkouh ME, et al. Low-Density Lipoprotein Cholesterol and Adverse Cardiovascular Events After Percutaneous Coronary Intervention. J Am Coll Cardiol. 2020 Sep 22;76(12):1440-1450. doi: 10.1016/j.jacc.2020.07.033.',
        'Johannesen CDL, Langsted A, Nordestgaard BG, Mortensen MB. Excess Apolipoprotein B and Cardiovascular Risk in Women and Men. J Am Coll Cardiol. 2024 Jun 11;83(23):2262-2273. doi: 10.1016/j.jacc.2024.03.423.',
        'Takahashi D, Wada H, Ogita M, Yasuda K, Nishio R, Takeuchi M, et al. Impact of Lipoprotein(a) as a Residual Risk Factor in Long-Term Cardiovascular Outcomes in Patients With Acute Coronary Syndrome Treated With Statins. Am J Cardiol. 2022 Apr 1;168:11-16. doi: 10.1016/j.amjcard.2021.12.014.',
        'Berman AN, Biery DW, Besser SA, Singh A, Shiyovich A, Weber BN, et al. Lipoprotein(a) and Major Adverse Cardiovascular Events in Patients With or Without Baseline Atherosclerotic Cardiovascular Disease. J Am Coll Cardiol. 2024 Mar 5;83(9):873-886. doi: 10.1016/j.jacc.2023.12.031.',
        'Liu L, Ma H, Yang S, Yu C, Liu T, Liu M, et al. The Role of Lipoprotein(a) in Cardiovascular Risk Stratification: Integrating Low-density Lipoprotein Cholesterol and Polygenic Risk Scores. Am J Cardiol. 2026 Jan 15;259:116-122. doi: 10.1016/j.amjcard.2025.09.012.',
        'MacDougall DE, Tybjaerg-Hansen A, Knowles JW et al. Lipoprotein(a) and recurrent atherosclerotic cardiovascular events: the US Family Heart Database. European Heart Journal 2025; 46:4762-4775.',
        'Romeo FJ, Golino M, Morello M, Di Muro FM, Moroni F, Del Buono MG, et al. Residual inflammatory risk and clinical outcomes after contemporary percutaneous coronary intervention: a systematic review and meta-analysis. Sci Rep. 2026 Feb 12;16(1):8584. doi: 10.1038/s41598-026-39691-1.',
        'Liao J, Qiu M, Su X, Qi Z, Xu Y, Liu H, et al. The residual risk of inflammation and remnant cholesterol in acute coronary syndrome patients on statin treatment undergoing percutaneous coronary intervention. Lipids Health Dis. 2024 Jun 7;23(1):172. doi: 10.1186/s12944-024-02156-3.',
        'Imbesi A, Greco A, Spagnolo M, Laudani C, Raffo C, Finocchiaro S, et al. Targeting Inflammation After Acute Myocardial Infarction. J Am Coll Cardiol. 2025 Oct 14;86(15):1146-1169. doi: 10.1016/j.jacc.2025.07.064.',
        'Sullivan AE, Nanna MG, Wang TY, Bhatt DL, Angiolillo DJ, Mehran R, et al. Bridging Antiplatelet Therapy After Percutaneous Coronary Intervention: JACC Review Topic of the Week. J Am Coll Cardiol. 2021 Oct 12;78(15):1550-1563. doi: 10.1016/j.jacc.2021.08.013.',
        'Rodriguez F, Harrington RA. Management of Antithrombotic Therapy after Acute Coronary Syndromes. N Engl J Med. 2021 Feb 4;384(5):452-460. doi: 10.1056/NEJMra1607714.',
        'Cuisset T, Verheugt FWA, Mauri L. Update on antithrombotic therapy after percutaneous coronary revascularisation. Lancet. 2017 Aug 19;390(10096):810-820. doi: 10.1016/S0140-6736(17)31936-0.',
        'Kamran H, Jneid H, Kayani WT, Virani SS, Levine GN, Nambi V, et al. Oral Antiplatelet Therapy After Acute Coronary Syndrome: A Review. JAMA. 2021 Apr 20;325(15):1545-1555. doi: 10.1001/jama.2021.0716. Erratum in: JAMA. 2021 Jul 13;326(2):190. doi: 10.1001/jama.2021.9484.',
        'Sidhu MS, Lyubarova R, Bangalore S, Bonaca MP. Challenges of long-term dual antiplatelet therapy use following acute coronary syndromes. Am Heart J. 2022 Apr;246:44-64. doi: 10.1016/j.ahj.2021.12.005.',
        'Acharjee S, Boden WE, Hartigan PM, Teo KK, Maron DJ, Sedlis SP, et al. Low levels of high-density lipoprotein cholesterol and increased risk of cardiovascular events in stable ischemic heart disease patients: a post-hoc analysis from the COURAGE Trial (Clinical Outcomes Utilizing Revascularization and Aggressive Drug Evaluation). J Am Coll Cardiol. 2013 Nov 12;62(20):1826-1833. doi: 10.1016/j.jacc.2013.07.051.',
        'Nakazawa M, Arashi H, Yamaguchi J, Ogawa H, Hagiwara N. Lower levels of high-density lipoprotein cholesterol are associated with increased cardiovascular events in patients with acute coronary syndrome. Atherosclerosis. 2020 Jun;303:21-28. doi: 10.1016/j.atherosclerosis.2020.05.005.',
        'Vivas D, Escobar C, Cordero A, Fernández-Olmo R, Oterino A, Blanco-Echevarría A, et al. Uso de nuevas terapias hipolipemiantes en la práctica clínica. Consenso SEC/SEA/SEEN/SEMFYC/SEMERGEN/SEMG/SEN/SEACV/S.E.N. REC CardioClinics. 2024 Oct-Dec;59(4):310-321. doi: 10.1016/j.rccl.2024.06.002.',
        'Reyes-Soffer G, Ginsberg HN, Berglund L, Duell PB, Heffron SP, Kamstrup PR, et al. Lipoprotein(a): A Genetically Determined, Causal, and Prevalent Risk Factor for Atherosclerotic Cardiovascular Disease: A Scientific Statement From the American Heart Association. Arterioscler Thromb Vasc Biol. 2022 Jan;42(1):e48-e60. doi: 10.1161/ATV.0000000000000147.',
        'Tsimikas S, Fazio S, Ferdinand KC, Ginsberg HN, Koschinsky ML, Marcovina SM, et al. NHLBI Working Group recommendations to reduce lipoprotein(a)-mediated risk of cardiovascular disease and aortic stenosis. J Am Coll Cardiol. 2018 Jan 16;71(2):177-192. doi: 10.1016/j.jacc.2017.11.014.',
        'Duarte Lau F, Giugliano RP. Lipoprotein(a) and its Significance in Cardiovascular Disease: A Review. JAMA Cardiol. 2022 Jul 1;7(7):760-769. doi: 10.1001/jamacardio.2022.0987. Erratum in: JAMA Cardiol. 2022 Jul 1;7(7):776. doi: 10.1001/jamacardio.2022.2074.',
        'Tsimikas S, Fazio S, Viney NJ, Xia S, Witztum JL, Marcovina SM. Relationship of lipoprotein(a) molar concentrations and mass according to lipoprotein(a) thresholds and apolipoprotein(a) isoform size. J Clin Lipidol. 2018 Sep-Oct;12(5):1313-1323. doi: 10.1016/j.jacl.2018.07.003.',
        'Ruhaak LR, Cobbaert CM. Quantifying apolipoprotein(a) in the era of proteoforms and precision medicine. Clin Chim Acta. 2020 Dec;511:260-268. doi: 10.1016/j.cca.2020.10.010.',
        'Kronenberg F. Lipoprotein(a) measurement issues: Are we making a mountain out of a molehill? Atherosclerosis. 2022 May;349:123-135. doi: 10.1016/j.atherosclerosis.2022.04.008.',
        'Gianos E, Duell PB, Toth PP, Moriarty PM, Thompson GR, Brinton EA, et al. Lipoprotein Apheresis: Utility, Outcomes, and Implementation in Clinical Practice: A Scientific Statement From the American Heart Association. Arterioscler Thromb Vasc Biol. 2024 Dec;44(12):e304-e321. doi: 10.1161/ATV.0000000000000177.',
        'Safarova MS, Moriarty PM. Lipoprotein Apheresis: Current Recommendations for Treating Familial Hypercholesterolemia and Elevated Lipoprotein(a). Curr Atheroscler Rep. 2023 Jul;25(7):391-404. doi: 10.1007/s11883-023-01113-2.',
        'Béliard S, Saheb S, Litzler-Renault S, Vimont A, Valero R, Bruckert É, et al. Evinacumab and Cardiovascular Outcome in Patients With Homozygous Familial Hypercholesterolemia. Arterioscler Thromb Vasc Biol. 2024 Jun;44(6):1447-1454. doi: 10.1161/ATVBAHA.123.320609.',
        'Parhofer KG, Julius U, Herzog AL, Krüger T, Weinmann-Menke J, Heine GH, Cao H, Schorr J, Ferber P, Wang J, Cristante E, Müller-Edenborn B, Vogt A, Schettler V, Steinhagen-Thiessen E. Pelacarsen and lipoprotein(a) apheresis in secondary prevention: the Lp(a)FRONTIERS APHERESIS trial. Eur Heart J. 2026 Feb 21:ehag073. doi: 10.1093/eurheartj/ehag073.',
        'Wright RS, Ray KK, Raal FJ, Kallend DG, Jaros M, Koenig W, et al. Pooled Patient-Level Analysis of Inclisiran Trials in Patients With Familial Hypercholesterolemia or Atherosclerosis. J Am Coll Cardiol. 2021 Mar 9;77(9):1182-1193. doi: 10.1016/j.jacc.2020.12.058.',
        'Ray KK, Raal FJ, Kallend DG, Jaros MJ, Koenig W, Leiter LA, et al. Inclisiran and cardiovascular events: a patient-level analysis of phase III trials. Eur Heart J. 2023 Jan 7;44(2):129-138. doi: 10.1093/eurheartj/ehac594.',
        'Ray KK, Wright RS, Kallend D, Koenig W, Leiter LA, Raal FJ, et al. Two Phase 3 Trials of Inclisiran in Patients with Elevated LDL Cholesterol. N Engl J Med. 2020 Apr 16;382(16):1507-1519. doi: 10.1056/NEJMoa1912387.',
        'López-Miranda J. Efficacy, benefit and safety of inclisiran. Clin Investig Arterioscler. 2024 Dec;36 Suppl 1:S24-S30. doi: 10.1016/j.arteri.2024.07.003.',
        'Ference BA, Ginsberg HN, Graham I, Ray KK, Packard CJ, Bruckert E, et al. Low-density lipoproteins cause atherosclerotic cardiovascular disease. 1. Evidence from genetic, epidemiologic, and clinical studies. A consensus statement from the European Atherosclerosis Society Consensus Panel. Eur Heart J. 2017 Aug 21;38(32):2459-2472. doi: 10.1093/eurheartj/ehx144.',
        'Michos ED, McEvoy JW, Blumenthal RS. Lipid Management for the Prevention of Atherosclerotic Cardiovascular Disease. N Engl J Med. 2019 Oct 17;381(16):1557-1567. doi: 10.1056/NEJMra1806939.',
        'Packard C, Chapman MJ, Sibartie M, Laufs U, Masana L. Intensive low-density lipoprotein cholesterol lowering in cardiovascular disease prevention: opportunities and challenges. Heart. 2021 Sep;107(17):1369-1375. doi: 10.1136/heartjnl-2020-318760.',
    ],

    // Pregunta 1 del Ingreso 2 — etapa "pruebas" (parámetros analíticos que explican el nuevo evento).
    'pregunta_pruebas_2' => [
        'enunciado'   => 'De los parámetros analíticos, ¿cuáles nos explican con mayor probabilidad el nuevo evento?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 100,
        'opciones' => [
            [
                'key' => 'lipidico', 'texto' => 'Riesgo lipídico: no conocemos el dato de lipoproteína (a) [Lp(a)] y no cumple objetivos de ApoB ni cLDL.', 'correcta' => true, 'puntos' => 100,
                'justificacion' => 'Tras un síndrome coronario agudo (SCA), unos niveles de cLDL >55 mg/dL o de apoB >65 mg/dL se asocian a un aumento significativo del riesgo de eventos cardiovasculares recurrentes, con incrementos relativos del 25–90%, según el grado de elevación. El riesgo es continuo y dependiente de la concentración. El valor plasmático de apoB refleja mejor la carga aterogénica total. La Lp(a) elevada es un factor de riesgo independiente y aditivo, no mitigado completamente por la reducción de cLDL, con hazard ratio (HR) de 1,21–1,66 incluso con cLDL controlado. La coexistencia de ambos factores incrementa el riesgo de forma sinérgica, lo que refuerza la necesidad de un abordaje conjunto1-6.',
            ],
            [
                'key' => 'inflamatorio', 'texto' => 'Riesgo residual inflamatorio.', 'correcta' => false, 'puntos' => -40,
                'justificacion' => 'En este caso, el riesgo residual inflamatorio (RIR) no parece ser el principal determinante del segundo evento, dado que el paciente presenta proteína C reactiva de alta sensibilidad (hsCRP) <2 mg/L y otros marcadores inflamatorios bajos. El RIR se define por inflamación persistente (hsCRP 2 mg/L) tras un SCA y se asocia a mayor riesgo de MACE, con un odds ratio (OR) de 1,71 en formas persistentes7-9. Los metaanálisis confirman incrementos de eventos cardiovasculares adversos mayores (MACE), mortalidad e infarto incluso con cLDL controlado. La coexistencia de RIR y riesgo lipídico residual tiene un efecto sinérgico, duplicando el riesgo absoluto de eventos.',
            ],
            [
                'key' => 'trombotico', 'texto' => 'Riesgo trombótico.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'En este caso, el riesgo trombótico no parece el principal responsable del segundo evento. Por las características clínicas y los hallazgos angiográficos, es más probable que se deba a progresión de una placa previamente moderada que a trombosis sobre placa vulnerable, especialmente considerando que el paciente mantenía doble antiagregación plaquetaria (DAPT). El riesgo trombótico tras un SCA, incluso bajo DAPT, se asocia a factores como inflamación persistente y activación de la coagulación, comorbilidades (diabetes, insuficiencia renal, disfunción ventricular), complejidad anatómica o del procedimiento, alta reactividad plaquetaria residual y retirada precoz del tratamiento. También influyen la neoaterosclerosis y la progresión de enfermedad en segmentos no tratados. En ausencia de estos condicionantes predominantes, su papel es menos relevante en la recurrencia del evento10-14.',
            ],
            [
                'key' => 'chdl', 'texto' => 'cHDL bajo.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'Aunque un nivel bajo de cHDL se asocia de forma independiente con mayor riesgo de eventos cardiovasculares recurrentes tras un SCA, no es el principal determinante frente a otros factores de riesgo residual. El riesgo es inversamente proporcional a sus niveles, aumentando un 2–3% por cada descenso de 1 mg/dL, y se mantiene incluso con cLDL controlado. Los pacientes con cHDL bajo presentan mayor incidencia de muerte, infarto o ictus, aunque actualmente no existen terapias específicas con impacto demostrado en eventos; en este contexto, fármacos en investigación como el obicetrapib podrían modificar este escenario en el futuro15-17.',
            ],
        ],
    ],

    // Pregunta 2 del Ingreso 2 — etapa "riesgo" (objetivos de cLDL/no-HDL/apoB en riesgo extremo).
    'pregunta_riesgo_2' => [
        'enunciado'   => 'Ya conocemos la importancia de alcanzar objetivos de cLDL en este tipo de pacientes. Sin embargo, debemos vigilar más parámetros. Si buscamos objetivos de colesterol no-HDL y apoB, ¿qué opción de las siguientes define correctamente los objetivos en este caso?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 100,
        'opciones' => [
            [
                'key' => 'obj_a', 'texto' => 'cLDL <40 mg/dL, colesterol no-HDL <85 mg/dL, apoB <65 mg/dL.', 'correcta' => false, 'puntos' => -40,
                'justificacion' => 'Estos no son los objetivos según las guías de práctica clínica para evento recurrente y enfermedad polivascular (paciente de riesgo extremo).',
            ],
            [
                'key' => 'obj_b', 'texto' => 'cLDL <40 mg/dL, colesterol no-HDL <70 mg/dL, apoB <55 mg/dL.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'Estos no son los objetivos según las guías de práctica clínica para evento recurrente y enfermedad polivascular (paciente de riesgo extremo).',
            ],
            [
                'key' => 'obj_c', 'texto' => 'cLDL <40 mg/dL, colesterol no-HDL <65 mg/dL, apoB <85 mg/dL.', 'correcta' => false, 'puntos' => -30,
                'justificacion' => 'Estos no son los objetivos según las guías de práctica clínica para evento recurrente y enfermedad polivascular (paciente de riesgo extremo).',
            ],
            [
                'key' => 'obj_d', 'texto' => 'cLDL <40 mg/dL, colesterol no-HDL <65 mg/dL, apoB <55 mg/dL.', 'correcta' => true, 'puntos' => 100,
                'justificacion' => 'Estos valores definen adecuadamente los objetivos terapéuticos según el riesgo cardiovascular, de acuerdo con el consenso actual de las principales guías internacionales17. En pacientes con enfermedad coronaria y eventos recurrentes (riesgo extremo), se recomiendan objetivos más intensivos: cLDL <40 mg/dL, colesterol no-HDL <65 mg/dL y apoB <55 mg/dL. ApoB y colesterol no-HDL son mejores marcadores de riesgo residual y su reducción se asocia a menor incidencia de eventos cardiovasculares2,17.',
            ],
        ],
    ],

    // Pregunta 3 del Ingreso 2 — etapa "terapeutico" (unidades de medición Lp(a): nmol/L vs mg/dL).
    'pregunta_terapeutico_2' => [
        'enunciado'   => 'El valor de la Lp(a) de nuestro paciente viene expresado en nmol/L. Sobre la medición de la Lp(a), señala la verdadera:',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 100,
        'opciones' => [
            [
                'key' => 'unidad_mgdl', 'texto' => 'Es más recomendable la medición en mg/dL.', 'correcta' => false, 'puntos' => -50,
                'justificacion' => 'La unidad preferida para medir la Lp(a) es nmol/L, ya que refleja el número de partículas y no se ve afectada por la variabilidad del tamaño de la apo(a), lo que permite una mayor precisión y estandarización. A diferencia de mg/dL, que mide masa y puede ser imprecisa por la heterogeneidad de las partículas, nmol/L está alineada con los estándares internacionales de la Federación Internacional de Química Clínica y Medicina de Laboratorio (IFCC) y la Organización Mundial de la Salud (OMS), y facilita una mejor interpretación clínica. Por ello, es la unidad recomendada en las guías actuales18-22.',
            ],
            [
                'key' => 'isoforma', 'texto' => 'La conversión depende de la isoforma de apolipoproteína (a) [apo(a)].', 'correcta' => true, 'puntos' => 100,
                'justificacion' => 'La conversión entre mg/dL y nmol/L en la Lp(a) no es directa ni universal, ya que depende del tamaño de la isoforma de apo(a). La masa (mg/dL) está influida por el número variable de repeticiones de kringle IV, que modifica el peso molecular de cada partícula. Por ello, la relación entre ambas unidades varía según el método analítico y las características individuales, lo que limita la fiabilidad de conversiones estándar21,23.',
            ],
            [
                'key' => 'conversion_valida', 'texto' => 'Existe una conversión válida entre mg/dL y nmol/L.', 'correcta' => false, 'puntos' => -25,
                'justificacion' => 'No existe una conversión válida y universal entre mg/dL y nmol/L para la Lp(a), debido a la variabilidad en el tamaño de las isoformas de la apo(a). La relación entre ambas unidades depende del número de repeticiones de kringle IV, del método analítico y del calibrador utilizado, lo que impide aplicar un único factor de conversión. Aunque existen fórmulas aproximadas para ensayos concretos, no son generalizables. Por ello, se recomienda reportar Lp(a) en nmol/L, ya que refleja el número de partículas y permite una interpretación más precisa y estandarizada21,23.',
            ],
            [
                'key' => 'convertir_siempre', 'texto' => 'Las guías recomiendan convertir siempre los valores.', 'correcta' => false, 'puntos' => -25,
                'justificacion' => 'En este paciente, la Lp(a) se ha determinado en nmol/L (315 nmol/L), unidad actualmente preferida. Las guías no recomiendan convertir sistemáticamente a mg/dL, ya que la relación entre ambas depende del tamaño de las isoformas de apo(a) y del método analítico, lo que impide un factor de conversión universal. Por ello, debe interpretarse en la unidad reportada, y nmol/L es más adecuada, puesto que refleja el número de partículas y permite una valoración más precisa del riesgo cardiovascular18,21,23.',
            ],
        ],
    ],

    // Pregunta 4 del Ingreso 2 — etapa "monitorizacion" (optimizar tratamiento con Lp(a) elevada).
    'pregunta_monitorizacion_2' => [
        'enunciado'   => '¿Podrías optimizar el tratamiento de este paciente con evento recurrente con cLDL y ApoB fuera de objetivos a pesar de tratamiento hipolipemiante óptimo y con Lp(a) elevada?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 100,
        'opciones' => [
            [
                'key' => 'no_farmacos', 'texto' => 'No, en la actualidad no hay fármacos que reduzcan la Lp(a).', 'correcta' => false, 'puntos' => -50,
                'justificacion' => 'El manejo del paciente con enfermedad cardiovascular y Lp(a) elevada se basa actualmente en la optimización intensiva de factores de riesgo, especialmente la reducción agresiva del cLDL. Las guías recomiendan estatinas de alta intensidad como primera línea, asociando ezetimiba y, si no se alcanzan objetivos (<55 mg/dL en prevención secundaria), terapia dirigida frente a PCSK9, que además puede reducir Lp(a) hasta un 20–25%. En caso de intolerancia, el ácido bempedoico es una alternativa. Aunque hay en desarrollo fármacos dirigidos contra Lp(a) (siRNA y oligonucleótidos antisentido) que han demostrado reducciones muy significativas, su impacto en la disminución de eventos aún está en investigación, por lo que la estrategia actual consiste en identificar a estos pacientes y optimizar de forma intensiva tanto el tratamiento hipolipemiante como el resto de los factores para conseguir la máxima reducción de su riesgo cardiovascular global17,18,20.',
            ],
            [
                'key' => 'pcsk9', 'texto' => 'Sí, la terapia dirigida frente a la proproteína convertasa subtilisina/kexina tipo 9 (TD a PCSK9) permite reducir cLDL y apoB, con un efecto modesto sobre la Lp(a).', 'correcta' => true, 'puntos' => 100,
                'justificacion' => 'El manejo del paciente con enfermedad cardiovascular y Lp(a) elevada se basa en la optimización intensiva del riesgo cardiovascular, especialmente mediante la reducción agresiva del cLDL. Las guías recomiendan estatinas de alta intensidad como primera línea, asociando ezetimiba y, si no se alcanzan objetivos (<55 mg/dL), TD a PCSK9, que reduce el cLDL hasta un 60% y Lp(a) alrededor de un 20–25%. En caso de intolerancia, el ácido bempedoico es una alternativa. Actualmente no existen terapias específicas aprobadas para reducir Lp(a) con impacto demostrado en eventos, por lo que el abordaje se centra en el control global del riesgo (presión arterial, diabetes, peso, antiagregación). Las terapias dirigidas contra Lp(a) (siRNA y oligonucleótidos antisentido) han mostrado reducciones muy significativas, pero aún están en desarrollo. Por ello, es clave identificar a estos pacientes y optimizar de forma precoz e intensiva el tratamiento17,18,20.',
            ],
            [
                'key' => 'aferesis', 'texto' => 'El único tratamiento posible en este punto es la aféresis.', 'correcta' => false, 'puntos' => -40,
                'justificacion' => 'La aféresis de lipoproteínas puede reducir de forma significativa la Lp(a); sin embargo, su uso está muy limitado en la práctica clínica. Se reserva para pacientes con enfermedad cardiovascular progresiva y Lp(a) muy elevada, pese a tratamiento óptimo, según recomiendan las guías. Su indicación debe individualizarse. En España, su disponibilidad está restringida a centros altamente especializados y se utiliza fundamentalmente en hipercolesterolemia familiar grave. En el contexto de Lp(a) elevada, su uso es excepcional, condicionado por el coste, la necesidad de sesiones repetidas, el impacto en la calidad de vida y la falta de evidencia robusta en reducción de eventos cardiovasculares24,25. Existen datos prometedores de fármacos en desarrollo que podrían tener efectividad equiparable, a la espera de conocer su impacto en reducción de eventos26.',
            ],
            [
                'key' => 'evinacumab', 'texto' => 'Puedo solicitar a farmacia hospitalaria evinacumab.', 'correcta' => false, 'puntos' => -10,
                'justificacion' => 'No existe evidencia clínica de que evinacumab reduzca eventos cardiovasculares recurrentes tras un SCA. Este anticuerpo monoclonal dirigido frente a la proteína similar a la angiopoyetina tipo 3 (ANGPTL3) ha demostrado reducciones significativas de cLDL (>50%) en pacientes con hipercolesterolemia refractaria, especialmente en hipercolesterolemia familiar homocigota, pero los ensayos disponibles se han centrado en parámetros lipídicos y seguridad, sin evaluar eventos clínicos en población pos-SCA. Debido a la ausencia de evidencias disponibles en la actualidad, evinacumab no está indicado ni aprobado en este contexto clínico27.',
            ],
        ],
    ],

    // Pregunta 5 del Ingreso 2 — etapa "monitorizacion-2" (ventajas de inclisirán vs iPCSK9).
    // ÚLTIMA pregunta del ingreso 2 → activa el modal "Finalizar caso".
    // Tiene 3 opciones CORRECTAS (30 + 40 + 30 = 100) y una INCORRECTA (-100).
    'pregunta_monitorizacion2_2' => [
        'enunciado'   => 'En este paciente, ¿qué ventajas encuentras en inclisirán frente a los iPCSK9 a la espera de los resultados de ensayos de eventos cardiovasculares (CVOT)?',
        'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
        'xp'          => 30,
        'opciones' => [
            [
                'key' => 'pauta_semestral', 'texto' => 'Pauta dos veces al año.', 'correcta' => true, 'puntos' => 30,
                'justificacion' => 'Inclisirán se administra con una pauta semestral (tras dosis inicial y a los 3 meses), lo que supone una ventaja frente a los iPCSK9, que requieren administración cada 2–4 semanas. Esta dosificación reduce la carga terapéutica y puede mejorar la adherencia, un aspecto clave en pacientes cardiovasculares de alto riesgo27,30.',
            ],
            [
                'key' => 'adherencia', 'texto' => 'Adaptar las revisiones a la administración del fármaco para facilitar la adherencia y los desplazamientos del paciente y me aseguro de que no haya pérdida de seguimiento en un paciente de tan alto riesgo.', 'correcta' => true, 'puntos' => 40,
                'justificacion' => 'Facilita la adherencia y el seguimiento clínico. Permite sincronizar las revisiones médicas con la administración del fármaco. Disminuye los desplazamientos del paciente. Reduce el riesgo de pérdida de seguimiento. Favorece un control más estrecho en pacientes de muy alto riesgo cardiovascular. Es especialmente relevante en la práctica real, donde la adherencia a tratamientos inyectables autoadministrados puede ser subóptima.',
            ],
            [
                'key' => 'teoria_lipidica', 'texto' => 'Aunque no tenga aún los resultados de CVOT, creo en la teoría lipídica del cLDL y hay evidencia de reducción potente del cLDL con inclisirán.', 'correcta' => true, 'puntos' => 30,
                'justificacion' => 'La utilización de inclisirán se fundamenta en el principio fisiopatológico de «cuanto más bajo, mejor», ya que la reducción del cLDL se asocia de forma log-lineal con una disminución del riesgo cardiovascular, sin un umbral inferior conocido. Aunque aún no se dispone de resultados definitivos de ensayos de eventos cardiovasculares (CVOT), su mecanismo de acción permite una reducción sostenida de aproximadamente el 50% del cLDL. Los estudios fase 3 ORION-9, ORION-10 y ORION-11 han demostrado esta eficacia en pacientes con hipercolesterolemia, incluyendo aquellos con enfermedad cardiovascular aterosclerótica bajo tratamiento con estatinas. Su administración subcutánea en pauta semestral (día 1, día 90 y posteriormente cada 6 meses) mantiene reducciones estables en el tiempo, con un perfil de seguridad comparable a placebo, destacando únicamente reacciones locales leves. Los análisis exploratorios sugieren un posible beneficio en la reducción de eventos cardiovasculares, pendiente de confirmación en estudios específicos28-34.',
            ],
            [
                'key' => 'potencia_superior', 'texto' => 'Ha demostrado una potencia de reducción del cLDL significativamente superior a iPCSK9.', 'correcta' => false, 'puntos' => -100,
                'justificacion' => 'Aunque inclisirán reduce de forma significativa el cLDL, su potencia es similar a la de los anticuerpos monoclonales anti-PCSK9 (alirocumab/evolocumab), con reducciones aproximadas del 50–60% sobre el tratamiento basal con estatinas y/o ezetimiba, sin demostrar una superioridad clara frente a estos28-31.',
            ],
        ],
    ],

    // ================================================================
    // ==============  ENCUESTA DE SATISFACCIÓN  ======================
    // ================================================================
    // 13 ítems con valoración de estrellas (1-5) + 1 campo de observaciones (texto libre).
    'encuesta' => [
        'items' => [
            ['titulo' => 'Adecuación científica',                  'texto' => 'Los contenidos presentan un nivel científico riguroso, actualizado y adecuado para profesionales sanitarios.'],
            ['titulo' => 'Pertinencia clínica',                    'texto' => 'El curso aborda una necesidad relevante en la estratificación del riesgo cardiovascular y el manejo de la Lp(a).'],
            ['titulo' => 'Aplicabilidad asistencial',              'texto' => 'Los contenidos son útiles para identificar pacientes con riesgo residual, enfermedad cardiovascular recurrente o alto riesgo heredado.'],
            ['titulo' => 'Claridad de los contenidos',            'texto' => 'La información se presenta de forma clara, ordenada y comprensible.'],
            ['titulo' => 'Estructura del caso clínico',           'texto' => 'La evolución del paciente a lo largo de los ingresos facilita el aprendizaje y la toma de decisiones clínicas.'],
            ['titulo' => 'Metodología docente',                   'texto' => 'La metodología basada en casos clínicos, decisiones interactivas, puntuación y feedback favorece la participación activa.'],
            ['titulo' => 'Medios didácticos',                     'texto' => 'Los recursos empleados —vídeos, pruebas complementarias, analíticas, imágenes clínicas y materiales descargables— ayudan a comprender mejor el caso.'],
            ['titulo' => 'Actualización terapéutica',             'texto' => 'El curso contribuye a actualizar mis conocimientos sobre objetivos lipídicos, optimización terapéutica y manejo del riesgo residual.'],
            ['titulo' => 'Tutoría académica',                     'texto' => 'La tutoría del curso ha sido adecuada en disponibilidad, claridad de las respuestas y apoyo al aprendizaje.'],
            ['titulo' => 'Objetividad y ausencia de sesgo comercial', 'texto' => 'La información recibida se presenta de forma objetiva, equilibrada y sin sesgo comercial ni otro tipo de parcialidad. 1 estrella = percibo mucho sesgo · 5 estrellas = no percibo sesgo.'],
            ['titulo' => 'Calidad de la actividad',               'texto' => 'La actividad formativa presenta una calidad adecuada en cuanto a contenidos, desarrollo y recursos empleados.'],
            ['titulo' => 'Relevancia de la actividad',            'texto' => 'La actividad resulta relevante para mi práctica clínica y para la actualización de mis conocimientos.'],
            ['titulo' => 'Valor global del curso',                'texto' => 'En conjunto, el curso ha cumplido mis expectativas por su calidad científica, utilidad clínica y enfoque práctico.'],
        ],
        // El ítem 14 es el campo de observaciones (texto libre).
        'observaciones' => [
            'titulo' => 'Observaciones',
            'texto'  => 'Agradeceríamos cualquier observación o sugerencia que estimes oportuna para mejorar la actividad.',
            'placeholder' => 'Escribe aquí tus comentarios o sugerencias.',
        ],
    ],

    // ================================================================
    // ==============  EVALUACIÓN FINAL (nivel CURSO)  ================
    // ================================================================
    // Se toman `tomar` preguntas AL AZAR del banco `preguntas`. Se aprueba (APTO) con
    // `aprobar_pct`% de aciertos. `max_intentos` intentos. Al aprobar se desbloquea el diploma.
    // Banco cargado del PDF oficial "REV_CLEAN_Cuestionario Lpaction" (31 preguntas).
    'evaluacion' => [
        'tomar'        => 10,
        'aprobar_pct'  => 80,
        'max_intentos' => 2,
        // Las 31 preguntas se cargan desde un archivo aparte para mantener el config legible.
        'preguntas'    => require __DIR__.'/preguntas_examen.php',
    ],

    // ================================================================
    // =====================  INGRESO 3 (ictus + HORIZON)  ============
    // ================================================================


'paciente_3' => [
    'nombre' => 'Juan',
    'imagen'            => 'images/paciente_pantalla_3.png',
    'imagen_progreso'   => 'images/paciente_pantalla_3b.png',
    'imagen_completado' => 'images/paciente_pantalla_3c.png',
    'datos'  => [
        ['icon' => 'edad',  'texto' => '55 años'],
        ['icon' => 'fuma',  'texto' => 'Exfumador (3 años)'],
        ['icon' => 'salud', 'texto' => 'Adherente a hábitos saludables'],
    ],
],

'datos_ingreso_3' => [
    'perfil' => [
        'edad_sexo' => 'varón, 55 años',
        'peso_estatura' => '74 kg, 167 cm (índice de masa corporal [IMC]: 26,5 kg/m²; sobrepeso)',
        'habitos' => 'Exfumador desde hace 3 años',
        'ocupacion' => 'Empresario',
        'estilo_vida' => 'Adherente a medicación y hábitos saludables, rehabilitación cardiaca completada',
    ],
    'historia' => [
        'Hipertensión arterial (HTA).',
        'Infarto agudo de miocardio con elevación del segmento ST (IAMCEST) inferoposterior a los 52 años, con dos stents farmacoactivos en coronaria derecha y lesión moderada (50%) en arteria descendente anterior.',
        'Síndrome coronario agudo sin elevación del segmento ST (SCASEST) a los 53 años, con revascularización de descendente anterior media y de la primera rama diagonal (D1).',
        'Enfermedad arterial periférica (EAP) documentada hace 2 años (índice tobillo-brazo [ITB] <0,9).',
        'Dislipidemia con lipoproteína(a) [Lp(a)] elevada (315 nmol/L en determinación basal).',
    ],
    'medicacion' => [
        'Ácido acetilsalicílico (AAS): 100 mg/24 h.',
        'Ramipril: 5 mg/24 h.',
        'Atorvastatina/ezetimiba: 80/10 mg/24 h.',
        'Semaglutida: 2,4 mg/semana.',
        'Inclisirán: dosis semestral (última dosis hace 3 meses) con buena tolerancia.',
    ],
    'alergias' => 'Sin alergias medicamentosas conocidas.',
    'motivo_consulta' => 'Juan acude al servicio de Urgencias del hospital acompañado por su esposa tras presentar, 3 horas antes, un cuadro de aparición brusca de debilidad en hemicuerpo izquierdo con inestabilidad y leve confusión. Los síntomas se han mantenido estables desde el inicio. No refiere cefalea, pérdida de conocimiento ni convulsiones. Se le realiza un electrocardiograma (ECG) en el que se observa taquicardia sinusal. Dado su historial de enfermedad cardiovascular (ECV) polivascular y Lp(a) elevada, la sospecha de ictus isquémico es alta.',
    'tc_texto' => 'TC craneal sin contraste: ausencia de hemorragia intracraneal y de signos de infarto agudo en territorio arterial definido.',
    'angiotc_texto' => 'Lesión grave (90%) de la arteria carótida interna derecha. Placas de ateroma en bulbo carotídeo izquierdo con estenosis <50%. Signos de enfermedad aterosclerótica difusa en arco aórtico y arterias supraaórticas.',
    'rm_texto' => 'Resonancia magnética (RM) cerebral a las 48 horas: infarto isquémico agudo hemisférico derecho de localización subinsular y capsular que se extiende a corona radiada. Sin transformación hemorrágica. Leucoaraiosis periventricular ligera.',
    'revascularizacion_texto' => 'Se realiza endarterectomía carotídea derecha emergente con buen resultado y sin complicaciones.',
    'analitica' => [
        'Glucosa plasmática (GLU): 98 mg/dL.',
        'Hemoglobina glicada (HbA1c): 5,8%.',
        'Colesterol total (CT): 101 mg/dL.',
        'Triglicéridos (TG): 95 mg/dL.',
        'Colesterol unido a lipoproteínas de alta densidad (cHDL): 40 mg/dL.',
        'Colesterol unido a lipoproteínas de baja densidad (cLDL): 41 mg/dL.',
        'Colesterol no-HDL: 70 mg/dL.',
        'Apolipoproteína B (apoB): 46 mg/dL.',
        'TG/HDL: 2,3.',
        'Proteína C reactiva (PCR) ultrasensible: 1,2 mg/L.',
        'Creatinina: 0,72 mg/dL (tasa de filtrado glomerular [TFG] estimada mediante la ecuación Chronic Kidney Disease Epidemiology Collaboration [CKD-EPI]: 98 mL/min/1,73 m²).',
        'Hemograma, coagulación, función hepática, ferrocinética y perfil tiroideo: normales.',
        'Lp(a) previa tras 1 mes de tratamiento con inclisirán: 276 nmol/L.',
    ],
    'evolucion' => [
        'Juan evoluciona favorablemente durante su estancia en el hospital, iniciando neurorrehabilitación precoz en la Unidad de Ictus con recuperación progresiva de la paresia.',
        'Atribuye su último evento a transgresiones dietéticas muy ocasionales y a una reducción reciente de su nivel de ejercicio aeróbico. Es extremadamente consciente de que la dieta, el ejercicio y el cumplimiento estricto de su tratamiento son claves a partir de ahora para minimizar su riesgo cardiovascular y añadir cantidad y calidad de vida.',
        'El mayor de sus tres hijos se ha realizado una revisión cardiovascular completa con hallazgo de un cLDL de 135 mg/dL y una Lp(a) de 269 nmol/L. Ha dejado de fumar y comenzado a modificar sus hábitos con dieta cardiosaludable y ejercicio físico aeróbico, combinado con un programa específico de fuerza (en total >300 minutos por semana), pendiente de evolución y analítica para valorar la necesidad de tratamiento farmacológico. Ni él ni Juan quieren que se repita su historia.',
    ],
    'puntos_clave' => [
        'La Lp(a) elevada es un factor de riesgo causal e independiente para el ictus isquémico aterotrombótico, incluyendo recurrencias, independientemente de los niveles de cLDL.',
        'El ictus aterotrombótico es una de las manifestaciones cardiovasculares de la enfermedad aterosclerótica promovida por la Lp(a), junto con el IAM y la EAP.',
        'No existe ninguna terapia aprobada específicamente para reducir la Lp(a), pero el pelacarsen (ASO), el olpasiran y el lepodisiran (ambos siRNA) han demostrado reducciones >80–95% en estudios de fase II.',
        'El ensayo Lp(a)HORIZON (NCT04023552) es el primer estudio de fase III diseñado para evaluar si la reducción de Lp(a) con pelacarsen (80 mg en administración subcutánea mensual) disminuye los eventos cardiovasculares en 8323 pacientes con ECV establecida y Lp(a) ≥70 mg/dL.',
        'En los pacientes con ictus isquémico, Lp(a) elevada y buen control de cLDL, deben considerarse el acceso precoz al tratamiento o su inclusión en ensayos clínicos en fase III.',
        'Adicionalmente, la estrategia debe centrarse en la reducción máxima de todos los factores de riesgo modificables y en el cribado familiar de Lp(a) en familiares de primer grado.',
    ],
],

'bibliografia_3' => [
    'Tsimikas S, Fazio S, Ferdinand KC, Ginsberg HN, Koschinsky ML, Marcovina SM, et al. NHLBI Working Group recommendations to reduce lipoprotein(a)-mediated risk of cardiovascular disease and aortic stenosis. J Am Coll Cardiol. 2018;71(2):177-192. doi: 10.1016/j.jacc.2017.11.014.',
    'Reyes-Soffer G, Ginsberg HN, Berglund L, Duell PB, Heffron SP, Kamstrup PR, et al. Lipoprotein(a): A Genetically Determined, Causal, and Prevalent Risk Factor for Atherosclerotic Cardiovascular Disease: A Scientific Statement From the American Heart Association. Arterioscler Thromb Vasc Biol. 2022;42(1):e48-e60. doi: 10.1161/ATV.0000000000000147.',
    'Kronenberg F, Mora S, Stroes ESG, Ference BA, Arsenault BJ, Berglund L, et al. Lipoprotein(a) in atherosclerotic cardiovascular disease and aortic stenosis: a European Atherosclerosis Society consensus statement. Eur Heart J. 2022;43(39):3925-3946. doi: 10.1093/eurheartj/ehac361.',
    'Kosmas CE, Bousvarou MD, Papakonstantinou EJ, Zoumi EA, Rallidis LS. Lipoprotein (a) and cerebrovascular disease. J Int Med Res. 2024;52(7):3000605241264182. doi: 10.1177/03000605241264182.',
    'Chen R, Liu Y, Zhang L, et al. Lipoprotein(a) as a Risk Factor for Recurrent Ischemic Stroke in Type 2 Diabetes. J Clin Med. 2025;14(9):2990. doi: 10.3390/jcm14092990.',
    'Lange KS, Nave AH, Liman TG, Grittner U, Endres M, Ebinger M. Lipoprotein (a) levels and recurrent vascular events after first ischemic stroke. Stroke. 2017;48(1):36-42. doi: 10.1161/STROKEAHA.116.014436.',
    'Cho L, Rocco M, Colquhoun D, et al. Design and Rationale of Lp(a)HORIZON Trial: Assessing the Effect of Lipoprotein(a) Lowering With Pelacarsen on Major Cardiovascular Events in Patients With CVD and Elevated Lp(a). Am Heart J. 2025. doi: 10.1016/j.ahj.2025.03.019.',
    'Tsimikas S, Karwatowska-Prokopczuk E, Gouni-Berthold I, Tardif JC, Baum SJ, Steinhagen-Thiessen E, et al. Lipoprotein(a) Reduction in Persons with Cardiovascular Disease. N Engl J Med. 2020;382(3):244-255. doi: 10.1056/NEJMoa1905239.',
    'O\'Donoghue ML, Rosenson RS, Gencer B, López JAG, Lepor NE, Baum SJ, et al. Small Interfering RNA to Reduce Lipoprotein(a) in Cardiovascular Disease. N Engl J Med. 2022;387(20):1855-1864. doi: 10.1056/NEJMoa2211023.',
    'O\'Donoghue ML, Rosenson RS, López JAG, et al. The Off-Treatment Effects of Olpasiran on Lipoprotein(a) Lowering: OCEAN(a)-DOSE Extension Period Results. J Am Coll Cardiol. 2024;84(9):790-797. doi: 10.1016/j.jacc.2024.05.058.',
    'Nissen SE, Linnebjerg H, Shen X, Wolski K, Ma X, Ose L, et al. Lepodisiran, an Extended-Duration Small Interfering RNA Targeting Lipoprotein(a): A Randomized Clinical Trial. JAMA. 2023;330(21):2075-2083. doi: 10.1001/jama.2023.21835.',
    'Nissen SE, Kahn P, Lincoff AM, et al. Lepodisiran -- A Long-Duration Small Interfering RNA Targeting Lipoprotein(a). N Engl J Med. 2025. doi: 10.1056/NEJMoa2415818.',
    'Parhofer KG, Julius U, Herzog AL, et al. Pelacarsen and lipoprotein(a) apheresis in secondary prevention: the Lp(a)FRONTIERS APHERESIS trial. Eur Heart J. 2026 Feb 21:ehag073. doi: 10.1093/eurheartj/ehag073.',
    'Yan JH, Baker BF, Hantash FM, et al. Pharmacokinetics and Safety of Pelacarsen, a GalNAc3-Conjugated Antisense Oligonucleotide, in Individuals With Mild Hepatic Impairment. Clin Pharmacol Ther. 2025. doi: 10.1002/cpt.3566.',
    'Powers WJ, Rabinstein AA, Ackerson T, et al. Guidelines for the Early Management of Patients With Acute Ischemic Stroke: 2019 Update to the 2018 Guidelines for the Early Management of Acute Ischemic Stroke. Stroke. 2019;50(12):e344-e418. doi: 10.1161/STR.0000000000000211.',
    'Berge E, Whiteley W, Audebert H, et al. European Stroke Organisation (ESO) guidelines on intravenous thrombolysis for acute ischaemic stroke. Eur Stroke J. 2021;6(1):I-LXII. doi: 10.1177/2396987321989865.',
    'Mach F, Koskinas KC, Roeters van Lennep JE, Tokgözolu L, Badimon L, Baigent C, et al. 2025 focused update of the 2019 ESC/EAS guidelines for the management of dyslipidaemias. Eur Heart J. 2025;46(42):4359-4378. doi: 10.1093/eurheartj/ehaf190.',
],

'pregunta_pruebas_3' => [
    'enunciado' => 'Juan presenta un ictus isquémico hemisférico derecho. Dado que su Lp(a) fue de 316 nmol/L en situación basal y, tras el tratamiento, descendió a 276 nmol/L (todavía muy elevada), ¿cuál es la relación más precisa entre la Lp(a) elevada y el riesgo de ictus isquémico?',
    'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
    'xp' => 100,
    'opciones' => [
        [
            'key' => 'lpa_causal',
            'texto' => 'La Lp(a) elevada aumenta el riesgo de ictus aterotrombótico a través de mecanismos proaterogénicos y protrombóticos independientes del cLDL, con evidencia de causalidad respaldada por estudios de aleatorización mendeliana.',
            'correcta' => true,
            'puntos' => 100,
            'justificacion' => 'La Lp(a) es un factor de riesgo causal e independiente para el ictus isquémico aterotrombótico1-3. Los mecanismos implicados incluyen: 1) aterogénesis acelerada por transporte de fosfolípidos oxidados (OxPL) a la pared vascular; 2) inhibición competitiva de la activación del plasminógeno, con efecto protrombótico; 3) inflamación vascular mediada por citoquinas proinflamatorias (IL-1, TNF-α); y 4) expresión de moléculas de adhesión (ICAM-1, VCAM-1), que facilitan la infiltración de monocitos2,4. Los estudios de aleatorización mendeliana confirman la relación causal entre variantes del gen LPA y el ictus isquémico, independientemente de los niveles de cLDL1,2. Un metaanálisis de 2024 demostró que por cada descenso de 50 nmol/L en Lp(a) genéticamente predicha, el riesgo de ictus isquémico se reduce un 8–10%5,6.',
        ],
        [
            'key' => 'marcador',
            'texto' => 'La Lp(a) elevada es un marcador de riesgo, pero no ha demostrado ser un factor causal de ictus; el riesgo real viene determinado exclusivamente por los niveles de cLDL y la presencia añadida de HTA.',
            'correcta' => false,
            'puntos' => -42,
            'justificacion' => 'Esta afirmación es incorrecta. La Lp(a) es un factor causal independiente, no un mero marcador.1,2 Los estudios de aleatorización mendeliana han demostrado que las variantes genéticas que elevan Lp(a) se asocian de forma causal con mayor riesgo de ictus isquémico, independientemente de otros factores de riesgo.2 El gen LPA está ubicado en el cromosoma 6q26-27 y las variaciones en el número de repeticiones del dominio kringle IV determinan >90% de la variabilidad interindividual de Lp(a).1',
        ],
        [
            'key' => 'hf_ldl',
            'texto' => 'La relación entre Lp(a) e ictus solo existe en pacientes con hipercolesterolemia familiar o niveles residuales de cLDL >100 mg/dL.',
            'correcta' => false,
            'puntos' => -33,
            'justificacion' => 'El riesgo atribuible a Lp(a) es independiente de los niveles de cLDL1,3. Pacientes como Juan, con el cLDL bien controlado (42 mg/dL), siguen teniendo riesgo residual significativo por su Lp(a) elevada. La Lp(a) es un factor genéticamente determinado sin correlación con los niveles de cLDL1. De hecho, aproximadamente el 20% de la población mundial presenta una Lp(a) elevada (>125 nmol/L), independientemente de su perfil lipídico convencional1,3.',
        ],
        [
            'key' => 'cardioembolico',
            'texto' => 'La Lp(a) se asocia con ictus cardioembólico por su similitud estructural con el plasminógeno, independientemente de su relación con la enfermedad aterosclerótica intracraneal.',
            'correcta' => false,
            'puntos' => -25,
            'justificacion' => 'Aunque la similitud estructural entre la apolipoproteína(a) [apo(a)] y el plasminógeno confiere propiedades antifibrinolíticas a la Lp(a), la principal asociación de Lp(a) con ictus es de tipo aterosclerótico, no cardioembólico. Los estudios muestran que la Lp(a) se asocia específicamente con ictus isquémico de gran vaso aterotrombótico y con enfermedad carotídea (como en el caso de Juan) 4,6. La evidencia genética no sugiere un papel causal en la fibrilación auricular ni en el ictus cardioembólico.',
        ],
    ],
],

'pregunta_riesgo_3' => [
    'enunciado' => 'Tras el ictus, ¿qué valor de Lp(a) debería considerarse umbral de alto riesgo en la estratificación de este paciente para prevención secundaria, de acuerdo con la evidencia más reciente?',
    'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
    'xp' => 100,
    'opciones' => [
        [
            'key' => 'umbral_125',
            'texto' => 'El umbral de riesgo es Lp(a) ≥50 mg/dL (125 nmol/L), que identifica aproximadamente al 20% de la población con mayor riesgo relativo de eventos cardiovasculares, incluyendo ictus.',
            'correcta' => true,
            'puntos' => 100,
            'justificacion' => 'El umbral de Lp(a) ≥50 mg/dL (125 nmol/L) es el criterio ampliamente aceptado para definir riesgo elevado2,3. La declaración científica de la American Heart Association de 2022 y el consenso de la European Atherosclerosis Society definen Lp(a) ≥50 mg/dL como el umbral por encima del cual el riesgo cardiovascular aumenta significativamente1-3. Aproximadamente el 20% de la población mundial supera este valor. Pacientes con Lp(a) 70-90 mg/dL (como Juan, con 316 nmol/L ≈130 mg/dL) tienen un riesgo particularmente alto y son precisamente los incluidos en los ensayos clínicos de terapias específicas anti-Lp(a) 7.',
        ],
        [
            'key' => 'umbral_30',
            'texto' => 'Una Lp(a) ≥30 mg/dL ya constituye un factor de riesgo elevado, por lo que cualquier valor a partir de este umbral requiere intensificación terapéutica.',
            'correcta' => false,
            'puntos' => -18,
            'justificacion' => 'El umbral de 30 mg/dL es demasiado bajo y no está respaldado por la evidencia. Los grandes metaanálisis (como los de Emerging Risk Factors Collaboration) demuestran que el riesgo cardiovascular comienza a aumentar significativamente a partir de una Lp(a) ≥50 mg/dL (percentil 80 de la población). El uso de umbrales más bajos podría llevar a una medicalización innecesaria de población de bajo riesgo, dado que aún no existen terapias aprobadas específicamente para reducir la Lp(a).',
        ],
        [
            'key' => 'umbral_200',
            'texto' => 'Solo los valores >200 nmol/L (>80 mg/dL) se consideran de alto riesgo; por debajo de este nivel la Lp(a) no tiene relevancia clínica.',
            'correcta' => false,
            'puntos' => -23,
            'justificacion' => 'El riesgo asociado a la Lp(a) es continuo y log-lineal; no existe un umbral único de riesgo a partir del cual la Lp(a) «comience a importar». Los valores >125 nmol/L ya se asocian con mayor riesgo, y cada incremento adicional se traduce en mayor riesgo absoluto1,3. El criterio de inclusión del ensayo HORIZON con pelacarsen (Lp(a) ≥70 mg/dL) precisamente refleja que incluso valores intermedios-elevados se consideran relevantes en población de alto riesgo con ECV establecida7. El riesgo relativo para ictus isquémico es de aproximadamente 1,15–1,25 por cada cuartil de incremento de Lp(a)4.',
        ],
        [
            'key' => 'no_relevante',
            'texto' => 'El valor de Lp(a) deja de ser relevante para el riesgo de ictus tras la revascularización exitosa y solo importa la prevención del ictus hemorrágico.',
            'correcta' => false,
            'puntos' => -59,
            'justificacion' => 'El riesgo de recurrencia de ictus isquémico tras un primer evento es sustancial: hasta 10–15% en el primer año. La Lp(a) elevada es un determinante independiente de recurrencia, especialmente en pacientes con enfermedad arteriosclerótica de grandes vasos. Los estudios han demostrado que pacientes con Lp(a) en el percentil 90 (>90–100 mg/dL) tienen un odds ratio de 1,7–2,1 para recurrencia de ictus isquémico en comparación con aquellos con Lp(a) <50 mg/dL. La prevención secundaria debe ser integral: control de todos los factores de riesgo modificables más evaluación de elegibilidad para terapias emergentes anti-Lp(a).',
        ],
    ],
],

'pregunta_terapeutico_3' => [
    'enunciado' => 'En cuanto al manejo terapéutico de la Lp(a) elevada en el post-ictus de Juan, ¿qué opción describe mejor la situación actual de las terapias disponibles y en desarrollo?',
    'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
    'xp' => 100,
    'opciones' => [
        [
            'key' => 'emergentes',
            'texto' => 'Actualmente no existe ninguna terapia aprobada específicamente para reducir la Lp(a), pero la inhibición con muvalaplin o la interferencia sobre su expresión genética con pelacarsen (oligonucleótido antisentido [ASO] anti-LPA) o los siRNA olpasiran y lepodisiran han demostrado, en estudios en fase II, reducciones >80–95% de Lp(a) y se encuentran en ensayos de resultados cardiovasculares de fase III.',
            'correcta' => true,
            'puntos' => 100,
            'justificacion' => 'A fecha de 2026, no hay ninguna terapia aprobada específicamente para reducir la Lp(a)1,3. Los iPCSK9 reducen la Lp(a) solo un 20–25% de forma indirecta. Muvalaplin es un inhibidor oral de la síntesis de la Lp(a) que impide la unión entre apo(a) y apoB-100 y, en el ensayo fase II KRAKEN, demostró una reducción del 70% con dosis de 240 mg/día. En la modulación de la expresividad genética existen tres grandes candidatos en desarrollo con ensayos en fase III de reducción de eventos cardiovasculares: 1. Pelacarsen: ASO ligado a N-acetilgalactosamina (GalNAc) que se une de forma altamente selectiva al mRNA de LPA en el hepatocito y lo degrada mediante la ribonucleasa H1 (RNasa H1). En fase II redujo la Lp(a) un 80% con dosis de 20 mg de administración subcutánea semanal8 (equivalente a 80 mg/mes, que corresponde a la dosis evaluada en el ensayo fase III HORIZON (NCT04023552), actualmente en marcha7. 2. Olpasiran: siRNA-GalNAc que silencia la expresión de LPA degradando el mRNA mediante el complejo de silenciamiento inducido por ARN (RISC). En fase II (OCEAN(a)-DOSE) logró una reducción de la Lp(a) >95% con una dosis de 225 mg cada 12 semanas9,10. 3. Lepodisiran: siRNA no canónico que, en su ensayo fase II (ALPACA), redujo la Lp(a) un 93,9% con dos dosis semestrales de 400 mg y un efecto duradero hasta 12 meses después11,12.',
        ],
        [
            'key' => 'estatinas',
            'texto' => 'Las estatinas de alta potencia combinadas con ezetimiba son el tratamiento de elección para reducir la Lp(a) elevada tras un ictus.',
            'correcta' => false,
            'puntos' => -42,
            'justificacion' => 'Las estatinas NO reducen la Lp(a); de hecho, pueden aumentarla ligeramente (en un 10–20% en algunos estudios). La ezetimiba tampoco tiene un efecto significativo sobre la Lp(a). La indicación de estatinas + ezetimiba en este paciente es para alcanzar objetivos de cLDL y apoB, no para tratar la Lp(a) elevada. El manejo actual de la Lp(a) elevada se basa en la reducción intensiva de los factores de riesgo modificables convencionales (cLDL, TA, glucemia), pendiente de terapias específicas.',
        ],
        [
            'key' => 'ipcsk9',
            'texto' => 'Los inhibidores de PCSK9 (iPCSK9), como evolocumab o alirocumab, reducen la Lp(a) hasta en un 60–70% y están indicados como primera línea para Lp(a) elevada post-ictus.',
            'correcta' => false,
            'puntos' => -33,
            'justificacion' => 'Los iPCSK9 reducen la Lp(a) solo un 20–25% (no un 60–70%), y esta reducción es un efecto colateral de su mecanismo de acción (aumento de los receptores LDL hepáticos), no el objetivo primario. Su indicación actual es la hipercolesterolemia refractaria y la prevención vascular, no específicamente la Lp(a) elevada. Como en el caso de Juan, la reducción del 20–25% puede no ser suficiente para mitigar el riesgo residual atribuible a la Lp(a), que requiere reducciones >50% según los modelos epidemiológicos.',
        ],
        [
            'key' => 'aferesis',
            'texto' => 'La aféresis de lipoproteínas es el tratamiento estándar para Lp(a) elevada post-ictus en Europa, incluyendo España.',
            'correcta' => false,
            'puntos' => -25,
            'justificacion' => 'La aféresis de lipoproteínas solo está aprobada en Alemania para pacientes con una Lp(a) elevada y una ECV progresiva pese a tratamiento máximo. En España, su disponibilidad está limitada a casos excepcionales de hipercolesterolemia familiar homocigota y se realiza en muy pocos centros. No es un tratamiento estándar para la Lp(a) elevada post-ictus. El acceso a la aféresis requiere autorización excepcional y su impacto en la calidad de vida es considerable por la necesidad de sesiones quincenales o semanales. Recientemente se ha documentado la eficacia de pelacarsen para reducir la necesidad de sesiones de aféresis de forma segura13.',
        ],
    ],
],

'pregunta_monitorizacion_3' => [
    'enunciado' => 'Respecto al ensayo clínico HORIZON con pelacarsen, señala la afirmación correcta:',
    'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
    'xp' => 100,
    'opciones' => [
        [
            'key' => 'horizon_ok',
            'texto' => 'El ensayo HORIZON (NCT04023552) es un estudio de fase III, doble ciego, aleatorizado, controlado con placebo, que evalúa pelacarsen 80 mg con administración subcutánea mensual frente a placebo en 8323 pacientes con ECV establecida e Lp(a) ≥70 mg/dL, con un criterio de valoración principal compuesto de muerte cardiovascular, infarto agudo de miocardio (IAM) no fatal, ictus no fatal o revascularización coronaria urgente.',
            'correcta' => true,
            'puntos' => 100,
            'justificacion' => 'El ensayo Lp(a) HORIZON es el primer estudio de fase III diseñado para demostrar si la reducción farmacológica de Lp(a) disminuye eventos cardiovasculares7. Características clave: - Diseño: multicéntrico, doble ciego, asignación 1:1 (pelacarsen 80 mg con administración subcutánea mensual vs. placebo). Seguimiento mínimo 2,5 años. - Población: 8323 pacientes con ECV establecida (IAM, ictus isquémico o EAP sintomática) y Lp(a) ≥70 mg/dL (149 nmol/L) en el cribado. - Criterios de inclusión: clínica cardiovascular índice entre 3 meses y 10 años previos al cribado. - Criterio de valoración principal: MACE (eventos cardiovasculares mayores) expandido (muerte cardiovascular, IAM no fatal, ictus no fatal, revascularización coronaria urgente con hospitalización). - Criterio de valoración preespecificado en subgrupo Lp(a) ≥90 mg/dL (192 nmol/L). - Reclutamiento completado en 2022 con resultados pendientes de eventos acumulados. Juan cumple los criterios de inclusión del ensayo (ictus isquémico/IAM + Lp(a) elevada)7,14.',
        ],
        [
            'key' => 'horizon_hf',
            'texto' => 'El ensayo HORIZON evalúa pelacarsen a dosis semanales de 20 mg en pacientes con hipercolesterolemia familiar sin antecedentes cardiovasculares.',
            'correcta' => false,
            'puntos' => -18,
            'justificacion' => 'La dosis de pelacarsen en HORIZON es de 80 mg una vez al mes (no 20 mg semanales). Aunque 20 mg semanales fue la dosis evaluada en fase II, los modelos farmacodinámicos demostraron que 80 mg en administración mensual proporciona una reducción media acumulada equivalente (~80%)7,8. Además, HORIZON incluye a pacientes con ECV establecida (IAM, ictus o EAP), no a pacientes sin antecedentes. Los pacientes deben tener una Lp(a) ≥70 mg/dL en el cribado, medida en un laboratorio central7.',
        ],
        [
            'key' => 'horizon_endpoint_lpa',
            'texto' => 'El criterio de valoración principal de HORIZON es el cambio en los niveles de Lp(a) a las 52 semanas.',
            'correcta' => false,
            'puntos' => -23,
            'justificacion' => 'El criterio de valoración principal de HORIZON es clínico: MACE expandido (muerte cardiovascular, IAM no fatal, ictus no fatal y revascularización coronaria urgente). El cambio en Lp(a) es un criterio de valoración principal secundario/exploratorio. HORIZON es un ensayo de resultados cardiovasculares, no un ensayo de eficacia analítica. Este aspecto es fundamental porque la pregunta que busca responder es si reducir la Lp(a) se traduce en un beneficio clínico, y no solo si el fármaco reduce los niveles de Lp(a)7.',
        ],
        [
            'key' => 'horizon_excluye_ictus',
            'texto' => 'El ensayo HORIZON excluye a pacientes con antecedentes de ictus isquémico, por lo que Juan no sería elegible para este tratamiento.',
            'correcta' => false,
            'puntos' => -59,
            'justificacion' => 'El ictus isquémico es uno de los tres criterios de inclusión de ECV establecida en HORIZON (junto con IAM y EAP sintomática). Los pacientes deben haber tenido un evento cardiovascular entre 3 meses y 10 años antes del cribado. Juan, con su ictus isquémico reciente, sería potencialmente elegible para el tratamiento tras cumplir el período de estabilización de 3 meses post-evento. La inclusión de pacientes con ictus es fundamental porque representan una población de alto riesgo residual en la que la Lp(a) juega un papel patogénico importante.',
        ],
    ],
],

'pregunta_monitorizacion2_3' => [
    'enunciado' => 'Considerando el caso de Juan (ictus isquémico tras eventos coronarios previos, Lp(a) de 276 nmol/L, cLDL de 41 mg/dL, colesterol no-HDL de 70 mg/dL, con tratamiento máximo incluyendo inclisirán), ¿cuál sería la estrategia de manejo más adecuada tras el alta hospitalaria?',
    'instruccion' => "Selecciona los ítems que creas convenientes y presiona 'Comprobar'.",
    'xp' => 100,
    'opciones' => [
        [
            'key' => 'mantener_optimizar',
            'texto' => 'Mantener la terapia hipolipemiante actual (incluyendo inclisirán), asegurar adherencia, evaluar elegibilidad para el uso precoz de pelacarsen en función de los resultados del ensayo HORIZON o valorar la inclusión en otro ensayo de fase III con terapia anti-Lp(a).',
            'correcta' => true,
            'puntos' => 100,
            'justificacion' => 'Esta es la estrategia más completa y correcta. Los componentes clave son: - Mantener la terapia actual: con un cLDL de 41 mg/dL y una apoB de 46 mg/dL, el control lipídico es límite a pesar de la triple terapia hipolipemiante, que incluye inclisirán administrado semestralmente. En el ensayo HORIZON, 897 pacientes (un 10,8%) incluyen tratamiento con iPCSK9. - Optimizar el resto de la prevención secundaria post-ictus: antiagregación y control estricto de la HTA (objetivo <130/80 mmHg)15,16. - Evaluar la elegibilidad para un uso precoz del tratamiento anti-Lp(a): a los 3 meses del ictus, Juan cumpliría criterios para uso de pelacarsen de acuerdo con el ensayo HORIZON (ictus isquémico entre 3 meses y 10 años + Lp(a) ≥70 mg/dL)7. La participación en otros ensayos de fase III podría ser otra opción para acceder a terapia específica anti-Lp(a).',
        ],
        [
            'key' => 'retirar_inclisiran',
            'texto' => 'Retirar inclisirán y sustituirlo por pelacarsen de forma inmediata al alta, ya que el ensayo HORIZON ya ha demostrado resultados positivos.',
            'correcta' => false,
            'puntos' => -40,
            'justificacion' => '- Los resultados del ensayo HORIZON confirmando la reducción de eventos aún no se han publicado7. - El acceso al tratamiento con pelacarsen está restringido a ensayos clínicos1,3. - No existe indicación de retirar inclisirán, que está proporcionando un excelente control del cLDL y la apoB; ambas terapias (siRNA anti-PCSK9 y ASO/siRNA anti-LPA) tienen mecanismos complementarios y son potencialmente coadministrables. - La sustitución inmediata, post-ictus agudo, no está justificada sin evidencia de resultados clínicos.',
        ],
        [
            'key' => 'suspender_hipolip',
            'texto' => 'Suspender todas las terapias hipolipemiantes excepto la estatina por su papel neuroprotector, ya que tras un ictus la prioridad es la rehabilitación neurológica, no el control lipídico.',
            'correcta' => false,
            'puntos' => -40,
            'justificacion' => 'El período post-ictus agudo es crítico para la prevención secundaria. La suspensión de terapias hipolipemiantes se asocia con un aumento significativo del riesgo de recurrencia. Las guías de manejo del ictus isquémico de 2024–2025 (AHA/ASA, ESO/ESMINT) mantienen la indicación de estatinas de alta intensidad y, si es necesario, el uso de terapia combinada para alcanzar objetivos15-17. El cLDL <55–70 mg/dL post-ictus constituye un objetivo con una recomendación de clase I. La rehabilitación neurológica y el control lipídico no son mutuamente excluyentes; deben implementarse de forma simultánea e integral.',
        ],
        [
            'key' => 'solo_antiagregacion',
            'texto' => 'Solo es necesario ajustar la antiagregación y el control de la HTA; la Lp(a) elevada no requiere acciones adicionales, dado que no hay terapias disponibles.',
            'correcta' => false,
            'puntos' => -20,
            'justificacion' => 'Aunque es cierto que no hay terapias aprobadas específicamente anti-Lp(a), esta actitud de inercia terapéutica ignora la importancia de la reducción máxima de todos los factores de riesgo modificables (cLDL, presión arterial, glucemia, peso) como estrategia indirecta para mitigar el riesgo atribuible a la Lp(a)1,3, la posibilidad de un tratamiento precoz (pelacarsen de acuerdo con el ensayo Horizon) o la inclusión en ensayos clínicos de fase III como terapias potencialmente revolucionarias7, y la monitorización de la Lp(a) tras iniciar terapia específica, que será relevante en el próximo futuro.',
        ],
    ],
],

];
