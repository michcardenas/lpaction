{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 3 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-3.riesgo.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Evaluación del riesgo cardiovascular') }}</h1>

    {{-- El documento del Módulo 3 no incluye texto introductorio en esta sección:
         va directa a la pregunta (el enunciado ya da el contexto "Tras el ictus..."). --}}

    {{-- Pregunta 2 del Ingreso 3 (umbral de alto riesgo de Lp(a)) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo_3']])
</div>
