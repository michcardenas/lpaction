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

    // Medallas según el Score final (verde − rojo). Escala sobre el máximo del ingreso (500).
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
            'botones' => [
                ['texto' => 'Volver al temario', 'estilo' => 'ghost', 'accion' => 'temario'],
            ],
        ],
        [
            'key' => 'plata', 'min' => 350, 'label' => 'Medalla de plata', 'color' => '#c4ccd2',
            'titulo' => 'Buen nivel de concordancia clínica',
            'texto'  => 'El caso se ha resuelto de forma adecuada, aunque existe margen de mejora. Puedes finalizar o revisar las etapas marcadas para intentar alcanzar el nivel oro.',
            'botones' => [
                ['texto' => 'Finalizar caso', 'estilo' => 'ghost', 'accion' => 'finalizar'],
                ['texto' => 'Mejorar puntuación', 'estilo' => 'cyan', 'accion' => 'mejorar'],
            ],
        ],
        [
            'key' => 'oro', 'min' => 450, 'label' => 'Medalla de oro', 'color' => '#f2c14e',
            'titulo' => 'Manejo clínico excelente',
            'texto'  => 'Has completado el caso con un desempeño óptimo en las decisiones clave. Resultado alineado con el abordaje clínico recomendado en el recorrido.',
            'botones' => [
                ['texto' => 'Finalizar caso', 'estilo' => 'ghost', 'accion' => 'finalizar'],
                ['texto' => 'Mejorar puntuación', 'estilo' => 'cyan', 'accion' => 'mejorar'],
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
];
