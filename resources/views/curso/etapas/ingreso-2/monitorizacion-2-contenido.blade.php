{{-- Contenido de la etapa "Monitorización y seguimiento 2" — INGRESO 2 (editable desde el panel).
     En el módulo 2 este capítulo NO tiene cuestionario: recoge el perfil lipídico tras inclisirán,
     el cribado familiar y el cierre del caso. --}}
@php $k = 'curso.cont.ingreso-2.monitorizacion-2.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Monitorización y seguimiento 2') }}</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">{{ cms($k.'p1') }}</p>
    {!! cms($k.'lista') !!}

    <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ cms($k.'comentario') }}</p>

    {{-- Screening familiar --}}
    <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ cms($k.'screening1') }}</p>
    <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ cms($k.'screening2') }}</p>
    <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ cms($k.'screening3') }}</p>

    <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ cms($k.'cierre') }}</p>
</div>
