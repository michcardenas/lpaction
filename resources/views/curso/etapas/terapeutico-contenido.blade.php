{{-- Contenido de la etapa "Planteamiento terapéutico" --}}
<div class="riesgo">
    <h1 class="h-caso">Planteamiento terapéutico</h1>

    {{-- Texto introductorio (es TEXTO, no título) --}}
    <p class="prueba-p riesgo-p" style="margin: 0 0 24px;">El paciente es dado de alta con el siguiente tratamiento farmacológico y se realiza derivación al programa de rehabilitación cardíaca.</p>

    {{-- Subtítulo + tratamiento como bullet points --}}
    <h3 class="prueba-h" style="margin: 0 0 12px;">Tratamiento al alta:</h3>
    <ul class="analitica-list">
        <li>Ácido acetilsalicílico (AAS): 100 mg/24 h.</li>
        <li>Prasugrel: 10 mg/24 h.</li>
        <li>Carvedilol: 6,25 mg/12 h.</li>
        <li>Ramipril: 5 mg/24 h.</li>
        <li>Atorvastatina/ezetimiba: 80/10 mg/24 h.</li>
    </ul>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_terapeutico']])
</div>
