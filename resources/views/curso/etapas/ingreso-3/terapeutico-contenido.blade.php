{{-- Contenido de la etapa "Planteamiento terapéutico" — INGRESO 3 (terapias para la Lp(a) elevada post-ictus) --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Planteamiento terapéutico</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">
        En el post-ictus de Juan, con una <b>Lp(a) que permanece elevada</b> pese al tratamiento hipolipemiante
        intensivo (incluido inclisirán) y un cLDL bien controlado, corresponde plantear el manejo terapéutico
        de la Lp(a): qué terapias hay disponibles hoy y cuáles están en desarrollo.
    </p>

    <h3 class="prueba-h" style="margin: 20px 0 12px;">Tratamiento actual</h3>
    <ul class="analitica-list">
        @foreach ($d['medicacion'] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    {{-- Pregunta 3 del Ingreso 3 (situación de las terapias para la Lp(a)) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico_3']])
</div>
