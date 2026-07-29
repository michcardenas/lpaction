{{-- Contenido de la etapa "Monitorización y seguimiento 2" — INGRESO 1 (solo cuestionario) --}}
@php $k = 'curso.cont.ingreso-1.monitorizacion-2.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Monitorización y seguimiento 2') }}</h1>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion2']])
</div>
