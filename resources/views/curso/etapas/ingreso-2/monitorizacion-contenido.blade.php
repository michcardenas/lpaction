{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 2
     (En este ingreso: optimización del tratamiento con Lp(a) elevada.) --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Monitorización y seguimiento</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">
        Tras el diagnóstico y determinación de <b>Lp(a) 315 nmol/L</b>, se revisa el tratamiento hipolipemiante
        del paciente. El paciente presenta cLDL 76 mg/dL y ApoB 86 mg/dL, ambos por encima de los objetivos
        para su categoría de riesgo extremo (cLDL &lt;40, ApoB &lt;55).
    </p>

    <h3 class="prueba-h" style="margin: 26px 0 8px;">Tratamiento actual</h3>
    <ul class="analitica-list">
        @foreach ($d['tratamiento_alta'] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    {{-- Pregunta 4 del Ingreso 2 (optimizar tratamiento con Lp(a) elevada) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion_2']])
</div>
