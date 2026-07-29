{{-- Etapa "Terapia de mantenimiento" — INGRESO 2 (editable desde el panel).
     Perfil lipídico tras 1 mes de inclisirán + screening familiar + cierre narrativo. --}}
@php $k = 'curso.cont.ingreso-2.mantenimiento.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Terapia de mantenimiento al alta de rehabilitación cardiaca') }}</h1>

    <h2 class="h-sec riesgo-h">{{ cms($k.'h_perfil', 'Perfil lipídico tras 1 mes de inclisirán (1.ª dosis)') }}</h2>
    <p class="analitica-intro">{{ cms($k.'p1') }}</p>
    {!! cms($k.'lista') !!}
    <p class="prueba-p" style="margin-top:16px;">{{ cms($k.'comentario') }}</p>

    <h2 class="h-sec riesgo-h" style="margin-top:26px;">{{ cms($k.'h_reco', 'Recomendaciones y screening familiar') }}</h2>
    <p class="prueba-p" style="margin-top:8px;">{{ cms($k.'reco1') }}</p>
    <p class="prueba-p" style="margin-top:12px;">{{ cms($k.'reco2') }}</p>
    <p class="prueba-p" style="margin-top:12px;"><b>Screening familiar:</b> {{ cms($k.'screening') }}</p>

    <p class="prueba-p" style="margin-top:22px; font-style:italic; opacity:0.9;">{{ cms($k.'cierre') }}</p>
</div>
