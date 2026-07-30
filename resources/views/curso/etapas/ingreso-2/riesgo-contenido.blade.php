{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 2 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-2.riesgo.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Evaluación del riesgo cardiovascular') }}</h1>

    <div class="prueba-p riesgo-p rich-p">{!! cms($k.'p1') !!}</div>
    <div style="margin-top:16px;">{!! cms($k.'lista') !!}</div>

    {{-- Pregunta 3 del Ingreso 2 (unidades de medición de Lp(a): nmol/L vs mg/dL) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo_2']])
</div>
