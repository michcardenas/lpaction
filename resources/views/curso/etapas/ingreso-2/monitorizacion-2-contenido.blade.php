{{-- Contenido de la etapa "Monitorización y seguimiento 2" — INGRESO 2
     ÚLTIMA pregunta del ingreso: al comprobar aparece el modal "Finalizar caso" con la medalla. --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Monitorización y seguimiento 2</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">{{ $d['inclisiran_intro'] }}</p>

    {{-- Pregunta 5 del Ingreso 2 (ventajas de inclisirán vs iPCSK9). 3 correctas. --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion2_2']])
</div>
