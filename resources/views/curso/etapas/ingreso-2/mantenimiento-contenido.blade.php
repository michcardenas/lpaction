{{-- Etapa "Terapia de mantenimiento" — INGRESO 2 (editable desde el panel, con Quill).
     Perfil lipídico tras 1 mes de inclisirán + screening familiar + cierre narrativo. --}}
@php $k = 'curso.cont.ingreso-2.mantenimiento.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Terapia de mantenimiento al alta de rehabilitación cardiaca') }}</h1>

    <h2 class="h-sec riesgo-h">{{ cms($k.'h_perfil', 'Perfil lipídico tras 1 mes de inclisirán (1.ª dosis)') }}</h2>
    <div class="analitica-intro rich-p">{!! cms($k.'p1') !!}</div>
    {!! cms($k.'lista') !!}
    <div class="prueba-p rich-p" style="margin-top:16px;">{!! cms($k.'comentario') !!}</div>

    <h2 class="h-sec riesgo-h" style="margin-top:26px;">{{ cms($k.'h_reco', 'Recomendaciones y screening familiar') }}</h2>
    <div class="prueba-p rich-p" style="margin-top:8px;">{!! cms($k.'reco1') !!}</div>
    <div class="prueba-p rich-p" style="margin-top:12px;">{!! cms($k.'reco2') !!}</div>
    <div class="prueba-p rich-p" style="margin-top:12px;">{!! cms($k.'screening') !!}</div>

    <div class="prueba-p rich-p" style="margin-top:22px; font-style:italic; opacity:0.9;">{!! cms($k.'cierre') !!}</div>
</div>
