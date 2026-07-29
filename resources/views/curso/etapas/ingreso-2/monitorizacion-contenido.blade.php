{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 2 (editable desde el panel).
     Es la ÚLTIMA pregunta del ingreso (al comprobar aparece el modal "Finalizar caso" con la medalla). --}}
@php $k = 'curso.cont.ingreso-2.monitorizacion.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Monitorización y seguimiento') }}</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">{{ cms($k.'p1') }}</p>

    {{-- Pregunta 5 del Ingreso 2 (ventajas de inclisirán vs iPCSK9). 3 correctas. --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion_2']])
</div>
