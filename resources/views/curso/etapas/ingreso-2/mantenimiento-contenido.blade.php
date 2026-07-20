{{-- Etapa "Terapia de mantenimiento" — INGRESO 2
     (Perfil lipídico tras 1 mes de inclisirán + screening familiar + cierre narrativo) --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Terapia de mantenimiento al alta de rehabilitación cardiaca</h1>

    <h2 class="h-sec riesgo-h">Perfil lipídico tras 1 mes de inclisirán (1.ª dosis)</h2>
    <p class="analitica-intro">{{ $d['perfil_post_inclisiran_intro'] }}</p>
    <ul class="analitica-list">
        @foreach ($d['perfil_post_inclisiran'] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
    <p class="prueba-p" style="margin-top:16px;">{{ $d['perfil_post_inclisiran_comentario'] }}</p>

    <h2 class="h-sec riesgo-h" style="margin-top:26px;">Recomendaciones y screening familiar</h2>
    <p class="prueba-p" style="margin-top:8px;">{{ $d['screening']['texto_1'] }}</p>
    <p class="prueba-p" style="margin-top:12px;">{{ $d['screening']['texto_2'] }}</p>
    <p class="prueba-p" style="margin-top:12px;"><b>Screening familiar:</b> {{ substr($d['screening']['texto_3'], 20) }}</p>

    <p class="prueba-p" style="margin-top:22px; font-style:italic; opacity:0.9;">{{ $d['cierre'] }}</p>
</div>
