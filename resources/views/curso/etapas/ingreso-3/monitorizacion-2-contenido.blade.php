{{-- Contenido de la etapa "Monitorización y seguimiento 2" — INGRESO 3
     ÚLTIMA pregunta del ingreso: al comprobar aparece el modal "Finalizar caso" con la medalla. --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Estrategia de manejo tras el alta</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">
        Considerando el caso de Juan —ictus isquémico tras eventos coronarios previos, Lp(a) de 276 nmol/L,
        cLDL de 41 mg/dL y colesterol no-HDL de 70 mg/dL, con tratamiento máximo incluido inclisirán—
        corresponde definir la estrategia de manejo más adecuada tras el alta hospitalaria.
    </p>

    {{-- Pregunta 5 del Ingreso 3 (estrategia de manejo post-alta) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion2_3']])
</div>
