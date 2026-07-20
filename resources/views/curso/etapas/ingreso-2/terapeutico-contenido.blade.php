{{-- Contenido de la etapa "Planteamiento terapéutico" — INGRESO 2
     En el Ingreso 2 este es el bloque de "unidades de medición de la Lp(a)" (nmol/L vs mg/dL). --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Planteamiento terapéutico</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 16px;">{{ $d['tratamiento_alta_intro'] }}</p>

    <h3 class="prueba-h" style="margin: 0 0 12px;">Tratamiento farmacológico:</h3>
    <ul class="analitica-list">
        @foreach ($d['tratamiento_alta'] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    {{-- Pregunta 3 del Ingreso 2 (unidad de medición de Lp(a): nmol/L vs mg/dL) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico_2']])
</div>
