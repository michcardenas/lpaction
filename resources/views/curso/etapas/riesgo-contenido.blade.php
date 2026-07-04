{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" --}}
<div class="riesgo">
    <h1 class="h-caso">Evaluación del riesgo cardiovascular</h1>

    <h2 class="h-sec riesgo-h">Al paciente no se le determinaron ApoB ni Lp(a)</h2>
    <p class="prueba-p riesgo-p">
        En la práctica clínica habitual esto es muy frecuente. Solo en un bajo porcentaje de la población se realiza
        determinación de Lp(a).
    </p>
    <p class="prueba-p riesgo-p" style="margin-top:16px;">
        El porcentaje de pacientes con SCA en quienes se determina la Lp(a) es muy bajo, generalmente
        &lt;2% en la práctica clínica real, a pesar de que las guías internacionales recomiendan su medición en este grupo de
        alto riesgo<sup>2,3</sup>. Estudios recientes en redes de atención primaria y cardiología muestran que solo el 1,55% de los
        pacientes que cumplen criterios de RCV, incluyendo SCA, tienen la Lp(a) medida, y la proporción es similar en
        pacientes con enfermedad cardiovascular establecida.
    </p>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo']])
</div>
