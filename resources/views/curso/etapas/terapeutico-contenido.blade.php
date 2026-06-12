{{-- Contenido de la etapa "Planteamiento terapéutico" --}}
<div class="riesgo">
    <h1 class="h-caso">Planteamiento terapéutico</h1>

    <h2 class="h-sec riesgo-h">El paciente es dado de alta con el siguiente tratamiento farmacológico y se realiza derivación al programa de rehabilitación cardíaca.</h2>
    <p class="prueba-p riesgo-p">
        Tratamiento al alta: • Ácido acetilsalicílico (AAS): 100 mg/24 h. • Prasugrel: 10 mg/24 h. • Carvedilol: 6,25 mg/12 h. • Ramipril: 5 mg/24 h. • Atorvastatina/ezetimiba: 80/10 mg/24 h.
    </p>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico']])
</div>
