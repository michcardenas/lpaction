{{-- Contenido de la etapa "Objetivos lipídicos adicionales" — INGRESO 2 (capítulo pedido por el cliente).
     Aquí va la Pregunta 2 del módulo: objetivos de cLDL / colesterol no-HDL / apoB en riesgo extremo. --}}
<div class="riesgo">
    <h1 class="h-caso">Objetivos lipídicos adicionales</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 16px;">
        Más allá del cLDL, el <b>colesterol no-HDL</b> y la <b>apoB</b> reflejan mejor la carga aterogénica
        total y el riesgo residual. En un paciente con evento recurrente y enfermedad polivascular
        (<b>riesgo extremo</b>), los objetivos son más exigentes que los habituales.
    </p>

    {{-- Pregunta 2 del Ingreso 2 (objetivos cLDL / no-HDL / apoB en riesgo extremo) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_objetivos_2']])
</div>
