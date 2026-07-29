{{-- Contenido de la etapa "Terapia de mantenimiento al alta de rehabilitación cardiaca" — INGRESO 1 (editable) --}}
@php $k = 'curso.cont.ingreso-1.mantenimiento.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Terapia de mantenimiento al alta de rehabilitación cardiaca') }}</h1>

    <div class="analitica-intro rich-p">{!! cms($k.'p1') !!}</div>
    {!! cms($k.'lista') !!}

    <div class="prueba-p riesgo-p rich-p" style="margin-top:20px;">{!! cms($k.'reflexion1') !!}</div>
    <div class="prueba-p riesgo-p rich-p" style="margin-top:14px;">{!! cms($k.'reflexion2') !!}</div>
    <p class="prueba-p riesgo-p" style="margin-top:14px; font-weight:600; color:#fff;">{{ cms($k.'pregunta_final', '¿Podemos asegurarles que hemos estudiado todo lo que importa?') }}</p>
</div>
