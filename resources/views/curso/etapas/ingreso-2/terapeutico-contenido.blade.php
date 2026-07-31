{{-- Contenido de la etapa "Planteamiento terapéutico" — INGRESO 2 (editable desde el panel).
     En el Ingreso 2 este es el bloque de "unidades de medición de la Lp(a)" (nmol/L vs mg/dL). --}}
@php $k = 'curso.cont.ingreso-2.terapeutico.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Planteamiento terapéutico') }}</h1>

    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 16px;">{!! cms($k.'p1') !!}</div>

    {{-- Label de la lista de fármacos: mismo tamaño que el texto de alrededor (16px), en negrita (petición del cliente). --}}
    <h3 class="prueba-h" style="font-size: 16px; line-height: 150%; letter-spacing: 0.02em; margin: 0 0 8px;">{{ cms($k.'h_trat', 'Tratamiento farmacológico:') }}</h3>
    {!! cms($k.'lista') !!}

    {{-- Pregunta 4 del Ingreso 2 (optimizar tratamiento con Lp(a) elevada) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico_2']])
</div>
