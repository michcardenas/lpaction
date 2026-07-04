{{-- Contenido de la etapa "Monitorización y seguimiento" --}}
<div class="riesgo">
    <h1 class="h-caso">Monitorización y seguimiento</h1>

    {{-- Es TEXTO, no título --}}
    <p class="prueba-p riesgo-p" style="margin: 0 0 16px;">El paciente realiza el programa de rehabilitación cardiaca con buena adherencia y presenta una mejoría de los parámetros antropométricos.</p>
    <p class="analitica-intro">Su situación 10 semanas después del evento isquémico es:</p>
    <ul class="analitica-list">
        <li><b>Peso:</b> inicial: 82 kg; final: 77 kg.</li>
        <li><b>Talla:</b> 167 cm.</li>
        <li><b>IMC:</b> inicial: 29,4 kg/m²; final: 27,6 kg/m².</li>
        <li>
            <b>Composición corporal:</b>
            <ul class="analitica-sublist">
                <li>Grasa total (inicial: 32%; final: 24%);</li>
                <li>Masa muscular (inicial: 31%; final: 36%);</li>
                <li>Grasa visceral (inicial: 16%; final: 14,5%).</li>
            </ul>
        </li>
        <li><b>Hábitos:</b> deshabituación tabáquica; realización de ejercicio físico (aeróbico + fuerza).</li>
        <li><b>Exploración:</b> presión arterial (PA): 120/76 mmHg; frecuencia cardiaca (FC): 65 lpm.</li>
    </ul>

    <h3 class="prueba-h" style="margin: 26px 0 8px;">Pruebas complementarias</h3>
    <p class="analitica-intro">Analítica sanguínea:</p>
    <ul class="analitica-list">
        <li>CT: 136 mg/dL.</li>
        <li>cHDL: 31 mg/dL.</li>
        <li>cLDL: 83 mg/dL.</li>
        <li>TG: 107 mg/dL.</li>
        <li>TG/cHDL: 3,45.</li>
        <li>Colesterol remanente: 22 mg/dL.</li>
        <li>cVLDL: 21,4 mg/dL.</li>
        <li>GLU: 109 mg/dL.</li>
        <li>Índice TyG: 4,68.</li>
        <li>PCR ultrasensible: 2,1 mg/L.</li>
    </ul>

    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion']])
</div>
