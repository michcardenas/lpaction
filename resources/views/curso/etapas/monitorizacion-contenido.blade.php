{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 1 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-1.monitorizacion.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Monitorización y seguimiento') }}</h1>

    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 16px;">{!! cms($k.'p1') !!}</div>
    <p class="analitica-intro">{{ cms($k.'situacion_intro', 'Su situación 10 semanas después del evento isquémico es:') }}</p>
    {!! cms($k.'situacion_list') !!}

    <h3 class="prueba-h" style="margin: 26px 0 8px;">{{ cms($k.'h_pruebas', 'Pruebas complementarias') }}</h3>
    <p class="analitica-intro">{{ cms($k.'ana_intro', 'Analítica sanguínea:') }}</p>
    {!! cms($k.'ana_list') !!}

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion']])
</div>
