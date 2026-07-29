{{-- Contenido de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 1 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-1.riesgo.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Evaluación del riesgo cardiovascular') }}</h1>

    <h2 class="h-sec riesgo-h">{{ cms($k.'h2', 'Al paciente no se le determinaron apoB ni Lp(a)') }}</h2>
    <p class="prueba-p riesgo-p">{{ cms($k.'p1', 'En la práctica clínica habitual esto es muy frecuente. Solo en un bajo porcentaje de la población se realiza determinación de Lp(a).') }}</p>
    <p class="prueba-p riesgo-p" style="margin-top:16px;">{!! cms($k.'p2', 'A pesar de que las guías internacionales recomiendan su medición en este grupo de alto riesgo, en la práctica clínica el porcentaje de pacientes con enfermedad cardiovascular en los que se determina Lp(a) es muy bajo (&lt;1%–14%)<sup>2,3</sup>. Estudios recientes en redes de Atención Primaria y Cardiología muestran que solo el 1,55% de los pacientes que cumplen criterios de RCV, incluyendo SCA, tienen la Lp(a) medida, y la proporción es similar en pacientes con enfermedad cardiovascular establecida.') !!}</p>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_riesgo']])
</div>
