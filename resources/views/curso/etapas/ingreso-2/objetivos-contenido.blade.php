{{-- Contenido de la etapa "Objetivos lipídicos adicionales" — INGRESO 2 (editable desde el panel).
     Aquí va la Pregunta 2 del módulo: objetivos de cLDL / colesterol no-HDL / apoB en riesgo extremo. --}}
@php $k = 'curso.cont.ingreso-2.objetivos.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Objetivos lipídicos adicionales') }}</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 16px;">{!! cms($k.'p1') !!}</p>

    {{-- Pregunta 2 del Ingreso 2 (objetivos cLDL / no-HDL / apoB en riesgo extremo) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_objetivos_2']])
</div>
