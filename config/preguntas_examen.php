<?php

return [

    // ============================================================
    // PRESENTACIÓN (4 preguntas, sin explicación → correcta por
    // conocimiento médico, marcadas para verificación humana)
    // ============================================================

    [
        'seccion'   => 'presentacion',
        'enunciado' => '¿Cuál de estos mecanismos se ha relacionado con la lipoproteína (a) [Lp(a)]?',
        'opciones'  => [
            'a' => 'Acción proinflamatoria.',
            'b' => 'Acción proaterosclerotica.',
            'c' => 'Acción proosteogenica.',
            'd' => 'Todas son correctas.',
        ],
        'correcta'      => 'd', // PRESENTACION-verificar
        'justificacion' => '',
    ],

    [
        'seccion'   => 'presentacion',
        'enunciado' => '¿Qué prevalencia tiene la elevación de la Lp(a) en la población?',
        'opciones'  => [
            'a' => 'Se estima que 1,5 millones de personas tienen la Lp(a) elevada.',
            'b' => 'Se estima que 1,5 billones de personas tienen la Lp(a) elevada.',
            'c' => 'La Lp(a) elevada es menos prevalente que la hipercolesterolemia familiar.',
            'd' => 'B y C son correctas.',
        ],
        'correcta'      => 'd', // PRESENTACION-verificar
        'justificacion' => '',
    ],

    [
        'seccion'   => 'presentacion',
        'enunciado' => '¿Cuándo debe medirse la Lp(a)?',
        'opciones'  => [
            'a' => 'Solo en los enfermos con calificación aórtica.',
            'b' => 'Solo en los enfermos con alta probabilidad de aterosclerosis.',
            'c' => 'Solo en los enfermos con alta probabilidad de aterosclerosis y estenosis aórtica.',
            'd' => 'En todos al menos una vez en la vida.',
        ],
        'correcta'      => 'd', // PRESENTACION-verificar
        'justificacion' => '',
    ],

    [
        'seccion'   => 'presentacion',
        'enunciado' => 'Los valores normales de Lp(a) son:',
        'opciones'  => [
            'a' => '<30 mg/dL.',
            'b' => '<50 mg/dL.',
            'c' => '<30 nmol/L.',
            'd' => '<100 mg/dL.',
        ],
        'correcta'      => 'b', // PRESENTACION-verificar
        'justificacion' => '',
    ],

    // ============================================================
    // MÓDULO 1 (11 preguntas)
    // ============================================================

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Cuál es la composición bioquímica fundamental de la lipoproteína (a) [Lp(a)]?',
        'opciones'  => [
            'a' => 'Una partícula de lipoproteína de alta densidad (HDL) unida a apolipoproteína(a) [apo(a)].',
            'b' => 'Triglicéridos en exceso y apolipoproteína B-48 (apoB-48).',
            'c' => 'Una partícula tipo lipoproteína de baja intensidad (LDL) (apolipoproteína B-100 [apoB-100]) unida covalentemente a la apo(a).',
            'd' => 'Colesterol libre y quilomicrones.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'La Lp(a) se distingue de otras lipoproteínas por tener una partícula similar a la LDL (que contiene apoB-100) unida a una glicoproteína específica llamada apolipoproteína(a) mediante un puente disulfuro. Esta estructura le confiere propiedades tanto aterogénicas (por la LDL) como protrombóticas (por la apo(a)).',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Qué porcentaje de la variación de los niveles plasmáticos de Lp(a) se explica por factores genéticos (gen LPA)?',
        'opciones'  => [
            'a' => 'Aproximadamente el 30%.',
            'b' => 'Alrededor del 50%.',
            'c' => 'Entre el 80% y el 90%.',
            'd' => 'Es puramente dietético, 0% genético.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'Los niveles de Lp(a) están determinados casi totalmente por la genética. Las variaciones en el gen LPA explican el 80–90% de los niveles plasmáticos, lo que significa que la dieta y el estilo de vida tienen un impacto mínimo. Esto sustenta el uso de la aleatorización mendeliana para demostrar la causalidad.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Cuántas personas a nivel mundial se estima que tienen niveles elevados de Lp(a) (>50 mg/dL)?',
        'opciones'  => [
            'a' => '100 millones (2%).',
            'b' => '1400 millones (20%).',
            'c' => '3500 millones (50%).',
            'd' => 'Es una enfermedad rara (0,1%).',
        ],
        'correcta'      => 'b',
        'justificacion' => 'La Lp(a) elevada no es un hallazgo raro. Se estima que el 20% de la población mundial (1 de cada 5 personas) tiene niveles por encima de 50 mg/dL (125 nmol/L), lo que la convierte en el trastorno lipídico heredado más común.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Qué evidencia científica ha sido clave para establecer que la Lp(a) es un conductor «causal» de enfermedad cardiovascular?',
        'opciones'  => [
            'a' => 'Estudios de aleatorización mendeliana.',
            'b' => 'Estudios observacionales de consumo de grasa.',
            'c' => 'Respuesta a las estatinas.',
            'd' => 'Estudios de niveles de glucosa.',
        ],
        'correcta'      => 'a',
        'justificacion' => 'La aleatorización mendeliana utiliza variantes genéticas (determinadas al nacer) como variables instrumentales. Dado que los niveles de Lp(a) se mantienen constantes de por vida, la asociación genética con el riesgo de infarto elimina la causalidad reversa, confirmando que la Lp(a) causa la enfermedad.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Cuáles son los tres componentes de la «tríada de riesgo» de la Lp(a)?',
        'opciones'  => [
            'a' => 'Hipertensión, diabetes y obesidad.',
            'b' => 'Aterogénica, proinflamatoria y protrombótica.',
            'c' => 'Oxidación, glicación y hemólisis.',
            'd' => 'Isquemia, arritmia y necrosis.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'La Lp(a) es única por: aterogénica, se deposita en la pared arterial; proinflamatoria, transporta fosfolípidos oxidados (OxPL); y protrombótica, su apo(a) inhibe la fibrinólisis.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => 'En el estudio Women\'s Health, ¿qué tratamiento pareció beneficiar más a los portadores de variantes genéticas de Lp(a) elevada?',
        'opciones'  => [
            'a' => 'Estatinas potentes.',
            'b' => 'Aspirina en dosis bajas.',
            'c' => 'Vitamina E y antioxidantes.',
            'd' => 'Terapia de reemplazo hormonal.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'Debido al componente protrombótico de la Lp(a), los portadores de alelos de alto riesgo mostraron una reducción significativa de eventos cardiovasculares al tomar aspirina en comparación con los no portadores, sugiriendo un rol protector específico por su efecto antiplaquetario.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => 'En términos de potencia aterogénica, ¿cuántas veces es más potente una partícula de Lp(a) que una de LDL?',
        'opciones'  => [
            'a' => 'Tienen la misma potencia.',
            'b' => 'La LDL es 2 veces más potente.',
            'c' => 'La Lp(a) es aproximadamente 6 veces más potente.',
            'd' => 'La Lp(a) es 100 veces más potente.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'Estudios recientes (Björnson et al., JACC 2024) indican que la Lp(a) es aproximadamente 6 veces más aterogénica que la LDL por unidad de masa. Esto se debe a su mayor retención en la pared arterial y a su carga de OxPL.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => 'Aunque es mayormente heredada, ¿qué alteración hormonal se asocia con un incremento significativo (de hasta un 25%) de la Lp(a)?',
        'opciones'  => [
            'a' => 'El embarazo.',
            'b' => 'La menopausia.',
            'c' => 'El uso de anticonceptivos orales.',
            'd' => 'El hipertiroidismo.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'La caída de los estrógenos durante la menopausia provoca un aumento de la síntesis hepática de apo(a). Esto explica por qué el riesgo cardiovascular aumenta de forma desproporcionada en mujeres tras la transición menopáusica.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿En qué grupo de pacientes la medición de la Lp(a) permite la mayor reclasificación a una categoría de riesgo superior?',
        'opciones'  => [
            'a' => 'Pacientes con riesgo muy alto (>30%).',
            'b' => 'Pacientes de bajo riesgo (<5%).',
            'c' => 'Pacientes de riesgo intermedio.',
            'd' => 'No reclasifica a nadie.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'La medición de la Lp(a) proporciona una mejora neta del 40% en la precisión de la clasificación de riesgo. Los pacientes de riesgo intermedio son los que más se benefician, ya que permite decidir si se inician terapias preventivas más agresivas (como estatinas o aspirina).',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Por qué la apo(a) interfiere con la disolución de los coágulos sanguíneos?',
        'opciones'  => [
            'a' => 'Porque destruye las plaquetas.',
            'b' => 'Porque aumenta los niveles de vitamina K.',
            'c' => 'Por su homología estructural con el plasminógeno.',
            'd' => 'Porque reduce el fibrinógeno.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'La apo(a) evolucionó a partir del gen del plasminógeno y contiene estructuras llamadas dominios kringle. Al ser tan parecida al plasminógeno, compite por los sitios de unión en la fibrina, bloqueando la activación del plasminógeno en plasmina y haciendo que los coágulos sean resistentes a la lisis.',
    ],

    [
        'seccion'   => 'modulo-1',
        'enunciado' => '¿Qué reveló el estudio PROSPECT II (Erlinge D. et al., 2025) sobre los niveles elevados de Lp(a)?',
        'opciones'  => [
            'a' => 'No hay relación con el tipo de placa coronaria.',
            'b' => 'La Lp(a) solo aumenta el riesgo si el LDL es bajo.',
            'c' => 'Se asocia con mayor presencia de placas de alto riesgo (HRP) y mayor severidad de la enfermedad coronaria.',
            'd' => 'La Lp(a) previene la ruptura de placa.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'El estudio PROSPECT II demostró que unos niveles elevados de Lp(a) se asocian significativamente con la presencia de placas vulnerables o HRP y con una presentación más severa de la enfermedad arterial coronaria (incluyendo enfermedad multivaso).',
    ],

    // ============================================================
    // MÓDULO 2 (11 preguntas)
    // ============================================================

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Cuál es la estructura que distingue a la lipoproteína (a) [Lp(a)] de otras lipoproteínas, como las lipoproteínas de baja intensidad (LDL)?',
        'opciones'  => [
            'a' => 'La presencia de dos moléculas de apolipoproteína B-100 (apoB-100) unidas por puente disulfuro.',
            'b' => 'La unión covalente de la apolipoproteína(a) [apo(a)] a una partícula similar al LDL mediante un único puente disulfuro.',
            'c' => 'La ausencia de colesterol en su núcleo lipídico.',
            'd' => 'La presencia de triglicéridos en lugar de ésteres de colesterol como lípido central.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'La Lp(a) se compone de una partícula similar a la LDL (con una molécula de apoB-100) unida covalentemente por un único puente disulfuro a la glucoproteína apo(a). Esta unión es lo que la distingue estructuralmente de la LDL y de otras lipoproteínas.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Aproximadamente qué porcentaje de los fosfolípidos oxidados (OxPL) presentes en el plasma humano se encuentran asociados con la Lp(a)?',
        'opciones'  => [
            'a' => 'Menos del 30%.',
            'b' => 'Alrededor del 50%.',
            'c' => 'Más del 85%.',
            'd' => 'Prácticamente el 100%.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'Estudios bioquímicos han demostrado que más del 85% de los OxPL detectables en plasma humano pueden inmunoprecipitarse con un anticuerpo anti-apo(a), lo que convierte a la Lp(a) en el transportador preferente de OxPL, a pesar de que las partículas de LDL son mucho más abundantes.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Cuál de los siguientes procesos patológicos NO ha sido directamente atribuido a los fosfolípidos oxidados (OxPL) asociados a la Lp(a)?',
        'opciones'  => [
            'a' => 'Disfunción endotelial y aumento de la permeabilidad vascular.',
            'b' => 'Diferenciación osteogénica de células intersticiales valvulares.',
            'c' => 'Reducción de la síntesis hepática de colesterol.',
            'd' => 'Activación proinflamatoria de monocitos y macrófagos.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'Los OxPL de la Lp(a) han sido relacionados con disfunción endotelial, inflamación, depósito lipídico y diferenciación osteogénica (calcificación). Sin embargo, la reducción de la síntesis hepática de colesterol es un mecanismo asociado a las estatinas, no a los OxPL de la Lp(a).',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿En qué dominio específico de la apo(a) se producen preferentemente la unión y acumulación de los OxPL?',
        'opciones'  => [
            'a' => 'Dominio proteasa inactivo.',
            'b' => 'Dominio kringle KIV2, responsable del polimorfismo de tamaño.',
            'c' => 'Dominio kringle KIV10, a través de su sitio de unión fuerte a lisina.',
            'd' => 'Dominio kringle KV.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'El sitio de unión fuerte a lisina del dominio KIV10 de la apo(a) es esencial para la adición covalente de los OxPL. Los mutantes que eliminan este sitio de unión carecen de OxPL detectables y pierden la capacidad de inducir respuestas proinflamatorias como la producción de interleucina 8 (IL-8).',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => 'La aterogenicidad de la Lp(a) comparada con el LDL, expresada en términos de riesgo de cardiopatía coronaria por partícula, se estima en:',
        'opciones'  => [
            'a' => 'Similar a la del LDL, aproximadamente 1:1.',
            'b' => 'Unas 2 veces mayor que la del LDL.',
            'c' => 'Aproximadamente 6 veces mayor que la del LDL.',
            'd' => 'Más de 15 veces mayor que la del LDL.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'Los estudios de aleatorización mendeliana estiman que, por partícula apoB, la Lp(a) confiere aproximadamente un riesgo unas 6 veces superior al del LDL.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Por qué la Lp(a) elevada se asocia principalmente con infarto agudo de miocardio con elevación del segmento ST (IAMCEST) y no con infarto agudo de miocardio sin elevación del segmento ST (IAMSEST)?',
        'opciones'  => [
            'a' => 'Porque la Lp(a) reduce la capacidad fibrinolítica, favoreciendo trombos exclusivamente oclusivos típicos del IAMCEST.',
            'b' => 'Porque la Lp(a) promueve placas vulnerables propensas a la rotura aguda, mecanismo principal del IAMCEST, mientras que el IAMSEST se relaciona más con erosión de placa u otros mecanismos.',
            'c' => 'Porque la Lp(a) actúa únicamente sobre las arterias coronarias principales y no sobre las ramas secundarias.',
            'd' => 'Porque el IAMSEST ocurre predominantemente en pacientes con LDL bajo, en quienes la Lp(a) no tiene efecto.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'La Lp(a) promueve la formación de placas inestables (necrosis lipídica, inflamación pericoronaria, morfología de alto riesgo) más propensas a la rotura aguda, que es el mecanismo subyacente del IAMCEST. El IAMSEST se atribuye con más frecuencia a erosión de placa u otros mecanismos de desequilibrio oferta-demanda, menos directamente influenciados por la Lp(a).',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Cuál de los siguientes hallazgos en la coronariografía por tomografía computarizada (CCTA) se asocia de forma significativa con niveles elevados de Lp(a)?',
        'opciones'  => [
            'a' => 'Menor volumen total de placa y mayor fracción de eyección ventricular izquierda.',
            'b' => 'Mayor volumen total de placa, mayor índice de atenuación pericoronaria (FAI) y menor gradiente de presión de retroceso (pullback pressure gradient, PPG) de la reserva fraccional de flujo por tomografía computarizada (FFR-CT).',
            'c' => 'Mayor calcificación coronaria sin cambios en la composición de la placa.',
            'd' => 'Reducción del área luminal mínima sin cambios en el índice de remodelado positivo.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'Los niveles de Lp(a) se asocian de forma significativa con mayor volumen total de placa, mayor FAI como marcador de inflamación pericoronaria y menor PPG de FFR-CT que refleja enfermedad difusa, indicando que la Lp(a) influye sobre las características morfológicas, inflamatorias y fisiológicas de la placa coronaria.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Cuál de las siguientes enfermedades cardiovasculares tiene una relación causal con la Lp(a) elevada, más allá de la enfermedad coronaria aterosclerótica?',
        'opciones'  => [
            'a' => 'Insuficiencia cardíaca de origen hipertensivo exclusivamente.',
            'b' => 'Enfermedad valvular aórtica calcificante (CAVD) y estenosis aórtica.',
            'c' => 'Fibrilación auricular de origen idiopático.',
            'd' => 'Hipertensión arterial pulmonar.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'Estudios genéticos mediante aleatorización mendeliana han demostrado que la Lp(a) elevada tiene un papel causal en la CAVD y la estenosis aórtica, adicional a su papel en la enfermedad aterosclerótica. Los OxPL de la Lp(a) promueven la diferenciación osteogénica de las células intersticiales valvulares, contribuyendo a la calcificación.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Cuál es el principal determinante de los niveles plasmáticos de Lp(a)?',
        'opciones'  => [
            'a' => 'La dieta rica en grasas saturadas y el estilo de vida sedentario.',
            'b' => 'La variación genética en el locus LPA, que controla principalmente la tasa de producción hepática.',
            'c' => 'El grado de resistencia a la insulina y la presencia de síndrome metabólico.',
            'd' => 'La actividad de la lipoproteína lipasa y la tasa de catabolismo de las lipoproteínas ricas en triglicéridos.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'Más del 90% de la variabilidad en los niveles plasmáticos de Lp(a) está determinada genéticamente, principalmente por el locus LPA. Las concentraciones se controlan sobre todo a nivel de producción hepática, con una correlación inversa entre el tamaño del alelo LPA (número de repeticiones KIV2) y los niveles plasmáticos.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Qué característica de la placa coronaria se asocia de forma específica con la Lp(a) elevada, distinguiéndola del efecto del colesterol unido a lipoproteínas de baja densidad (cLDL)?',
        'opciones'  => [
            'a' => 'Mayor volumen total de placa y mayor carga de lípidos en todos los segmentos coronarios.',
            'b' => 'Presencia de placas focales vulnerables (necrosis lipídica, remodelado positivo, baja atenuación), sin un aumento proporcional de la carga lipídica global.',
            'c' => 'Mayor calcificación coronaria estable con menor riesgo de rotura.',
            'd' => 'Estenosis luminal más grave y difusa sin cambios en la composición de la placa.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'A diferencia del cLDL, que se asocia con mayor volumen de placa y depósito lipídico global, la Lp(a) se vincula específicamente con la presencia de placas focales vulnerables (necrosis lipídica, remodelado positivo, signo del anillo de servilleta [napkin-ring sign]) más propensas a la rotura, sin un aumento proporcional en la carga total de placa.',
    ],

    [
        'seccion'   => 'modulo-2',
        'enunciado' => '¿Cuál de las siguientes estrategias terapéuticas en desarrollo tiene como objetivo reducir específicamente los niveles de Lp(a) de forma potente (>85%), actuando sobre la síntesis hepática de apo(a)?',
        'opciones'  => [
            'a' => 'Estatinas de alta intensidad combinadas con ezetimiba.',
            'b' => 'Oligonucleótidos antisentido (ASO) e interferencia por ARN (ARNi) dirigidos al ARNm de LPA.',
            'c' => 'Inhibidores de PCSK9 (iPCSK9) en monoterapia.',
            'd' => 'Fibratos y ácidos grasos omega-3.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'Los agentes basados en ARN, como los ASO (pelacarsen) y los ARNi (olpasiran), actúan suprimiendo la síntesis de la proteína apo(a) en el hígado, con lo que llegan a lograr reducciones de Lp(a) superiores al 85–95%. Las estatinas no reducen la Lp(a) (pueden aumentarla ligeramente), y los iPCSK9 la reducen solo un 25–30%.',
    ],

    // ============================================================
    // MÓDULO 3 (5 preguntas)
    // ============================================================

    [
        'seccion'   => 'modulo-3',
        'enunciado' => '¿Cuál es la relación entre la lipoproteína(a) [Lp(a)] elevada y el ictus isquémico?',
        'opciones'  => [
            'a' => 'La Lp(a) elevada es un factor causal e independiente de riesgo de ictus isquémico aterosclerótico.',
            'b' => 'La Lp(a) solo aumenta el riesgo de ictus cuando el colesterol unido a lipoproteínas de baja densidad (cLDL) es >100 mg/dL.',
            'c' => 'La Lp(a) se asocia exclusivamente con ictus hemorrágico.',
            'd' => 'La Lp(a) no tiene relación causal demostrada con enfermedad cerebrovascular.',
        ],
        'correcta'      => 'a',
        'justificacion' => 'La Lp(a) elevada se considera un factor de riesgo causal e independiente para enfermedad cardiovascular aterosclerótica, incluido el ictus isquémico. Su efecto no depende exclusivamente del cLDL y se relaciona con mecanismos proaterogénicos, protrombóticos e inflamatorios.',
    ],

    [
        'seccion'   => 'modulo-3',
        'enunciado' => '¿Qué umbral de Lp(a) se acepta habitualmente como indicativo de riesgo cardiovascular elevado?',
        'opciones'  => [
            'a' => '10 mg/dL.',
            'b' => '30 mg/dL.',
            'c' => '50 mg/dL, aproximadamente 125 nmol/L.',
            'd' => '200 mg/dL.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'El texto señala que el umbral más ampliamente aceptado para definir Lp(a) elevada es 50 mg/dL, equivalente aproximadamente a 125 nmol/L. A partir de este nivel se identifica una población con mayor riesgo de eventos cardiovasculares, incluyendo ictus isquémico.',
    ],

    [
        'seccion'   => 'modulo-3',
        'enunciado' => '¿Cuál de los siguientes mecanismos contribuye al riesgo aterotrombótico asociado a Lp(a)?',
        'opciones'  => [
            'a' => 'Disminución de la inflamación vascular.',
            'b' => 'Transporte de fosfolípidos oxidados (OxPL), acción protrombótica e inflamación vascular.',
            'c' => 'Aumento directo del colesterol unido a lipoproteínas de alta densidad (cHDL).',
            'd' => 'Reducción de la adhesión de monocitos al endotelio.',
        ],
        'correcta'      => 'b',
        'justificacion' => 'La Lp(a) favorece la aterotrombosis por varios mecanismos: transporte de OxPL a la pared vascular, posible interferencia con la fibrinólisis por su similitud con el plasminógeno, activación inflamatoria y aumento de moléculas de adhesión vascular.',
    ],

    [
        'seccion'   => 'modulo-3',
        'enunciado' => '¿Cuál es la situación actual de las terapias dirigidas específicamente a reducir Lp(a)?',
        'opciones'  => [
            'a' => 'Ya existe una terapia aprobada de primera línea para reducir Lp(a) en prevención secundaria.',
            'b' => 'Las estatinas son el tratamiento específico más eficaz para reducir Lp(a).',
            'c' => 'No hay terapias aprobadas específicamente para reducir Lp(a), aunque existen fármacos en desarrollo con reducciones muy marcadas en estudios clínicos.',
            'd' => 'Ezetimiba reduce la Lp(a) en más del 90%.',
        ],
        'correcta'      => 'c',
        'justificacion' => 'Según el documento, actualmente no existe una terapia aprobada específicamente para reducir la Lp(a). Sin embargo, terapias emergentes como pelacarsen, olpasiran y lepodisiran han mostrado reducciones importantes de Lp(a) en ensayos clínicos.',
    ],

    [
        'seccion'   => 'modulo-3',
        'enunciado' => '¿Cuál es el objetivo principal del ensayo Lp(a)HORIZON con pelacarsen?',
        'opciones'  => [
            'a' => 'Evaluar si la reducción farmacológica de Lp(a) disminuye eventos cardiovasculares mayores.',
            'b' => 'Determinar si pelacarsen reduce únicamente el cLDL.',
            'c' => 'Comparar estatinas frente a ezetimiba en pacientes con ictus.',
            'd' => 'Analizar solo el cambio de Lp(a) a las 4 semanas como objetivo primario.',
        ],
        'correcta'      => 'a',
        'justificacion' => 'El ensayo Lp(a)HORIZON es un estudio de fase III diseñado para evaluar si la reducción de Lp(a) con pelacarsen se traduce en una reducción de eventos cardiovasculares mayores, como muerte cardiovascular, infarto, ictus no fatal o revascularización coronaria urgente.',
    ],

];
