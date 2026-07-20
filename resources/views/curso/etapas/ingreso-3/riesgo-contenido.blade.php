{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 3 (umbral de Lp(a)) --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Evaluación del riesgo cardiovascular</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">
        Juan presenta un <b>ictus isquémico hemisférico derecho</b> en el contexto de una enfermedad
        cardiovascular polivascular establecida. Su <b>Lp(a) basal fue de 316 nmol/L</b> y, tras el tratamiento,
        descendió a <b>276 nmol/L</b> (todavía muy elevada), con un cLDL bien controlado (41 mg/dL).
    </p>
    <p class="prueba-p riesgo-p" style="margin-top:8px;">
        Corresponde estratificar su riesgo para la prevención secundaria de acuerdo con la evidencia más reciente.
    </p>

    {{-- Pregunta 2 del Ingreso 3 (umbral de alto riesgo de Lp(a)) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo_3']])
</div>
