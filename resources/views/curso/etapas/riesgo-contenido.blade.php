{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 1 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-1.riesgo.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Evaluación del riesgo cardiovascular') }}</h1>

    <h2 class="h-sec riesgo-h">{{ cms($k.'h2', 'Al paciente no se le determinaron apoB ni Lp(a)') }}</h2>
    <div class="prueba-p riesgo-p rich-p">{!! cms($k.'p1') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'p2') !!}</div>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo']])
</div>
