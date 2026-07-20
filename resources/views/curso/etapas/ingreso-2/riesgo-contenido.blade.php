{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 2 --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Evaluación del riesgo cardiovascular</h1>

    <h2 class="h-sec riesgo-h">Tras la reevaluación se solicita la determinación de Lp(a)</h2>
    <p class="prueba-p riesgo-p">{{ $d['lpa_intro'] }}</p>
    <ul class="analitica-list" style="margin-top:16px;">
        @foreach ($d['analitica_lpa'] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    {{-- Pregunta 2 del Ingreso 2 (objetivos cLDL/no-HDL/apoB en riesgo extremo) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo_2']])
</div>
