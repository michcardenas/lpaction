{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 2 (editable desde el panel).
     Es la ÚLTIMA pregunta del ingreso (al comprobar aparece el modal "Finalizar caso" con la medalla). --}}
@php $k = 'curso.cont.ingreso-2.monitorizacion.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Optimización de control lipídico tras evento recurrente') }}</h1>

    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 12px;">{!! cms($k.'p1') !!}</div>

    {{-- Pregunta 5 del Ingreso 2 (ventajas de inclisirán vs iPCSK9). 3 correctas. --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion_2']])

    {{-- Continuación de la sección 6 del Módulo 2: analítica de control tras inclisirán,
         recomendaciones y screening familiar, y cierre del caso (antes en el capítulo inventado). --}}
    <h3 class="prueba-h" style="margin: 30px 0 10px;">{{ cms($k.'h_perfil', 'Perfil lipídico tras 1 mes de inclisirán (1.ª dosis)') }}</h3>
    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 12px;">{!! cms($k.'perfil_intro') !!}</div>
    {!! cms($k.'lista') !!}
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'comentario') !!}</div>

    <h3 class="prueba-h" style="margin: 24px 0 10px;">{{ cms($k.'h_reco', 'Recomendaciones y screening familiar') }}</h3>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:12px;">{!! cms($k.'reco1') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:12px;">{!! cms($k.'reco2') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:12px;">{!! cms($k.'screening') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'cierre') !!}</div>
</div>
