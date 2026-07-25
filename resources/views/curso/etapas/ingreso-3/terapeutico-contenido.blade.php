{{-- Contenido de la etapa "Planteamiento terapéutico" — INGRESO 3 (terapias para la Lp(a) elevada post-ictus) --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Planteamiento terapéutico</h1>

    {{-- El documento va directo a la pregunta (sin texto introductorio). --}}

    {{-- Pregunta 3 del Ingreso 3 (situación de las terapias para la Lp(a)) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico_3']])
</div>
