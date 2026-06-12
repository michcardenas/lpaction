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

    // Bibliografía de la etapa "Presentación del caso" (se numera sola en la vista).
    'bibliografia' => [
        'Mehta A, Shapiro MD. Apolipoproteins in vascular biology and atherosclerotic disease. Nat Rev Cardiol. 2022;19(3):168-79. doi: 10.1038/s41569-021-00613-5.',
        'Panza GA, Blazek O, Tortora J, Saucier S, Fernandez AB. Prevalence of lipoprotein(a) measurement in patients with or at risk of cardiovascular disease. J Clin Lipidol. 2023;17(6):748-55. doi: 10.1016/j.jacl.2023.09.016.',
        'Mach F, Koskinas KC, Roeters van Lennep JE, Tokgözoğlu L, Badimon L, Baigent C, et al. 2025 focused update of the 2019 ESC/EAS guidelines for the management of dyslipidaemias. Eur Heart J. 2025;46(42):4359-78. doi: 10.1093/eurheartj/ehaf190.',
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
                'key' => 'apoa', 'texto' => 'Apolipoproteína A (ApoA).', 'correcta' => false,
                'justificacion' => 'La ApoA es un marcador útil del riesgo cardiovascular (RCV). Sin embargo, no aporta tanta información como la Apo B o la Lp(a) sobre el riesgo aterogénico del paciente. La ApoA-I es el principal componente de HDL y favorece el transporte reverso de colesterol, con efecto protector vascular. Unos niveles altos se asocian a menor RCV por su acción antiaterogénica y antiinflamatoria. En cambio, un desequilibrio con ApoB (partículas aterogénicas) aumenta el riesgo. El cociente ApoB/ApoA-I refleja este balance y es un mejor predictor que los lípidos convencionales: los valores elevados se relacionan con mayor riesgo de eventos cardiovasculares, incluso con LDL normal1.',
            ],
            [
                'key' => 'lpa', 'texto' => 'Lipoproteína (a) [Lp(a)].', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'apob', 'texto' => 'Apolipoproteína B (ApoB).', 'correcta' => true,
                'justificacion' => 'La apoB es recomendable junto al cLDL para evaluar el riesgo aterogénico, ya que refleja el número total de partículas aterogénicas [LDL, VLDL, lipoproteínas de densidad intermedia (IDL), Lp(a)], a diferencia del LDL, que solo mide su contenido en colesterol. Es especialmente útil en situaciones de discordancia (diabetes, hipertrigliceridemia, estatinas). Además, es una medida precisa, estandarizada y sin necesidad de ayuno. Permite identificar mejor el riesgo residual y optimizar el tratamiento, con mejor rendimiento que el cLDL6-12.',
            ],
            [
                'key' => 'cthdl', 'texto' => 'CT/HDL.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
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
                'key' => 'unica', 'texto' => 'Una única determinación basal en la juventud.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'semestral', 'texto' => 'Mediciones semestrales/anuales sistemáticas para monitorizar la eficacia del tratamiento hipolipemiante.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'tres', 'texto' => 'Tres determinaciones anuales, calculando una media aritmética entre las tres que compense las oscilaciones de la Lp(a).', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'dos', 'texto' => 'Realizar al menos dos mediciones: una inicial de cribado y una segunda 1–3 meses después, o bien tras cambios metabólicos mayores o eventos cardiovasculares.', 'correcta' => true,
                'justificacion' => 'La Lp(a) puede mostrar variación en el contexto de un SCA, por lo que puede medirse durante el ingreso junto al perfil lipídico y repetirse a los 1-3 meses, cuando el paciente se encuentre clínicamente estable, para confirmar un valor basal más representativo si este condiciona decisiones clínicas. Tras un IAM, se han descrito diferencias entre los niveles medidos en fase aguda y los obtenidos posteriormente. En seguimiento estable, no se recomiendan mediciones seriadas sistemáticas, salvo cambios clínicos relevantes o tratamientos específicos dirigidos a la Lp(a)3-5.',
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
                'key' => 'betabloqueantes', 'texto' => 'No pautaría betabloqueantes.', 'correcta' => true,
                'justificacion' => 'No se aconseja el uso rutinario de betabloqueantes tras un infarto de miocardio en pacientes con fracción de eyección ≥50% si no existen otras indicaciones. La evidencia actual muestra que no reducen la mortalidad, el reinfarto ni la insuficiencia cardíaca en este grupo14,15. A pesar de que las guías del American College of Cardiology (ACC) y la American Heart Association (AHA) los recomiendan, esta directriz se basa en estudios previos a la era actual, y la evidencia reciente cuestiona su beneficio en FEVI preservada15-18. Su perfil de seguridad es similar al placebo14. Por tanto, en un paciente con IAM y FEVI ≥50% no se recomienda su uso sistemático, en ausencia de otras indicaciones específicas.',
            ],
            [
                'key' => 'estatina', 'texto' => 'Pautaría de inicio solo estatina de alta potencia.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'nada', 'texto' => 'No haría nada diferente.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'antiagregacion', 'texto' => 'No pautaría doble antiagregación.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
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
                'key' => 'semaglutida', 'texto' => 'Semaglutida.', 'correcta' => true,
                'justificacion' => 'Un paciente tras un IAM, con un IMC ≥27 kg/m² y sin diabetes cumple los criterios del estudio SELECT para tratamiento con semaglutida, con evidencia de beneficio cardiovascular. La Guía ESC 2024 sobre el diagnóstico y el tratamiento de los síndromes coronarios crónicos recomienda considerar su uso en prevención secundaria en este perfil de pacientes, ya que el estudio SELECT demostró una reducción significativa de los eventos cardiovasculares mayores con semaglutida 2,4 mg/semanal en pacientes con enfermedad cardiovascular establecida, sobrepeso u obesidad y sin diabetes, independientemente del valor de HbA1c. No obstante, su indicación depende de la aprobación regulatoria y su implementación local22-24.',
            ],
            [
                'key' => 'bempedoico', 'texto' => 'Ácido bempedoico es una opción por considerar.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'mantener', 'texto' => 'Mantener tratamiento y control analítico a los 3 meses.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'icosapento', 'texto' => 'Icosapento de etilo.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
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
                'key' => 'lpa', 'texto' => 'Elevación de Lp(a).', 'correcta' => true,
                'justificacion' => 'El colesterol contenido en la Lp(a) [Lp(a)-C] se incluye dentro de la medición estándar del cLDL, mientras que la Lp(a) no responde de forma significativa a estatinas, ezetimiba, ácido bempedoico ni a la mayoría de hipolipemiantes convencionales. En pacientes con Lp(a) elevada, una proporción relevante del cLDL medido corresponde a Lp(a)-C, que no se reduce con estos tratamientos, lo que puede aparentar una respuesta subóptima, pese a que el cLDL "real" [excluyendo Lp(a)-C] haya disminuido adecuadamente3,13,30.',
            ],
            [
                'key' => 'adherencia', 'texto' => 'Falta de adherencia terapéutica.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'pcsk9', 'texto' => 'Sobreexpresión o mutaciones de ganancia de función en PCSK9.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
            [
                'key' => 'tiempo', 'texto' => 'Al poco tiempo transcurrido desde el inicio del tratamiento.', 'correcta' => false,
                'justificacion' => 'Justificación pendiente.',
            ],
        ],
    ],
];
