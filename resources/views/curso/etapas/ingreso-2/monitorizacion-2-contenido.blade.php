{{-- Contenido de la etapa "Monitorización y seguimiento 2" — INGRESO 2 (editable desde el panel, con Quill).
     En el módulo 2 este capítulo NO tiene cuestionario: recoge el perfil lipídico tras inclisirán,
     el cribado familiar y el cierre del caso. --}}
@php $k = 'curso.cont.ingreso-2.monitorizacion-2.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Monitorización y seguimiento 2') }}</h1>

    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 12px;">{!! cms($k.'p1') !!}</div>
    {!! cms($k.'lista') !!}

    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'comentario') !!}</div>

    {{-- Screening familiar --}}
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'screening1') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'screening2') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'screening3') !!}</div>

    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'cierre') !!}</div>
</div>
