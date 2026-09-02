{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 2 (editable desde el panel).
     Es la ÚLTIMA pregunta del ingreso (al comprobar aparece el modal "Finalizar caso" con la medalla). --}}
@php $k = 'curso.cont.ingreso-2.monitorizacion.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Optimización de control lipídico tras evento recurrente') }}</h1>

    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 12px;">{!! cms($k.'p1') !!}</div>

    {{-- Pregunta 5 del Ingreso 2 (ventajas de inclisirán vs iPCSK9). 3 correctas. --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion_2']])

    {{-- El bloque "Perfil lipídico tras 1 mes de inclisirán" se trasladó al capítulo de repaso
         "Monitorización y seguimiento" (etapa monitorizacion-2), petición del cliente. --}}

    <h3 class="prueba-h" style="margin: 30px 0 10px;">{{ cms($k.'h_reco', 'Recomendaciones y screening familiar') }}</h3>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:12px;">{!! cms($k.'reco1') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:12px;">{!! cms($k.'reco2') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:12px;">{!! cms($k.'screening') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'cierre') !!}</div>
</div>
