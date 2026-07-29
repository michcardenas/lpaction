{{-- Contenido de la etapa "Planteamiento terapéutico" — INGRESO 3 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-3.terapeutico.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Planteamiento terapéutico') }}</h1>

    {{-- El documento va directo a la pregunta (sin texto introductorio). --}}

    {{-- Pregunta 3 del Ingreso 3 (situación de las terapias para la Lp(a)) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico_3']])
</div>
