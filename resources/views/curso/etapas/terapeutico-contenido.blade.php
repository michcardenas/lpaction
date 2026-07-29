{{-- Contenido de la etapa "Planteamiento terapéutico" — INGRESO 1 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-1.terapeutico.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Planteamiento terapéutico') }}</h1>

    {{-- Texto introductorio (editable con Quill) --}}
    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 24px;">{!! cms($k.'p1') !!}</div>

    <h3 class="prueba-h" style="margin: 0 0 12px;">{{ cms($k.'h_trat', 'Tratamiento al alta:') }}</h3>
    {!! cms($k.'lista') !!}

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico']])
</div>
