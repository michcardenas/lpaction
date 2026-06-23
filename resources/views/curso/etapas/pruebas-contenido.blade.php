{{-- Contenido de la etapa "Pruebas complementarias" --}}
<div class="pruebas tabs-scope">
    <h1 class="h-caso">Pruebas complementarias</h1>

    {{-- Tabs de pruebas --}}
    <div class="tabs">
        <button type="button" class="tab on" data-tab="ecg">Electrocardiograma (ECG)</button>
        <button type="button" class="tab" data-tab="cateterismo">Cateterismo cardiaco</button>
        <button type="button" class="tab" data-tab="analitica">Analítica sanguínea</button>
    </div>

    {{-- Panel ECG --}}
    <div class="tab-panel prueba-panel" data-panel="ecg">
        <div class="ecg-block">
            <h3 class="prueba-h">Electrocardiograma (ECG)</h3>
            <p class="prueba-p">
                Los servicios de emergencias extrahospitalarias realizan un ECG donde se evidencia
                una elevación del segmento ST en la cara inferoposterior (Figura 1), por lo que proceden
                a la administración inmediata de doble antiagregación.
            </p>

            <div class="ecg-frame">
                <button type="button" class="ecg-icon ecg-expand" aria-label="Ampliar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                </button>
                <img src="{{ asset('images/ecg.png') }}" alt="Electrocardiograma con elevación del segmento ST">
                <a class="ecg-icon ecg-download" href="{{ asset('images/ecg.png') }}" download aria-label="Descargar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
                </a>
            </div>
            <p class="ecg-caption">Figura 1. Electrocardiograma con elevación del segmento ST en la cara inferoposterior.</p>
        </div>
    </div>

    {{-- Panel Cateterismo --}}
    <div class="tab-panel prueba-panel" data-panel="cateterismo" style="display:none">
        <div class="cat-block">
        <h3 class="prueba-h">Cateterismo cardiaco</h3>

        @php
            $cateterismoVideos = [
                ['file' => 'cateterismo-1', 'cap' => 'Vídeo 1. Coronariografía. Arteria coronaria derecha con oclusión en segmento medio.'],
                ['file' => 'cateterismo-2', 'cap' => 'Vídeo 2. Coronariografía. Estenosis significativa en descendente anterior.'],
                ['file' => 'cateterismo-3', 'cap' => 'Vídeo 3. Ecocardiograma (plano 4 cámaras). Fracción de eyección del ventrículo izquierdo conservada.'],
            ];
        @endphp
        <div class="videos-grid">
            @foreach ($cateterismoVideos as $v)
                <figure class="video-item">
                    <div class="video-player">
                        <video src="{{ asset('videos/' . $v['file'] . '.mp4') }}" preload="metadata" playsinline></video>
                        <div class="video-controls">
                            <button type="button" class="vid-btn vid-play" aria-label="Reproducir/Pausar">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                            <div class="vid-bar"><i></i></div>
                            <button type="button" class="vid-btn vid-expand" aria-label="Pantalla completa">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                            </button>
                        </div>
                    </div>
                    <figcaption class="video-cap">{{ $v['cap'] }}</figcaption>
                </figure>
            @endforeach
        </div>

        <p class="prueba-p">
            Tras su llegada a Urgencias, el paciente es trasladado inmediatamente al área de Hemodinámica para la realización
            de una coronariografía urgente. <span style="opacity:.5">(Resto del texto pendiente.)</span>
        </p>
        </div>{{-- /cat-block --}}
    </div>

    {{-- Panel Analítica --}}
    <div class="tab-panel prueba-panel" data-panel="analitica" style="display:none">
        <div class="analitica-block">
            <h3 class="prueba-h">Analítica sanguínea</h3>
            <p class="analitica-intro">Se realiza analítica en las primeras 24 h de ingreso que incluye los siguientes valores:</p>
            <ul class="analitica-list">
                <li>Hemoglobina (Hb): 14,7 g/dL.</li>
                <li>Glucosa plasmática (GLU): 110 mg/dL.</li>
                <li>Hemoglobina glicada (HbA1c): 5,7%.</li>
                <li>Creatinina: 0,68 mg/dL (tasa de filtrado glomerular [TFG] &gt;60 mL/min/1,73 m²).</li>
                <li>Colesterol total (CT): 155 mg/dL.</li>
                <li>Triglicéridos (TG): 78 mg/dL.</li>
                <li>Colesterol unido a lipoproteínas de alta densidad (cHDL): 36 mg/dL.</li>
                <li>Colesterol unido a lipoproteínas de baja densidad (cLDL): 104 mg/dL.</li>
                <li>Colesterol remanente: 15 mg/dL.</li>
                <li>Colesterol unido a lipoproteínas de muy baja densidad (cVLDL): 15,6 mg/dL.</li>
                <li>TG/HDL: 2,16.</li>
                <li>Hormona estimulante del tiroides (TSH) y tiroxina (T4): en rango.</li>
                <li>Proteína C reactiva (PCR): 8,9 mg/L.</li>
            </ul>
        </div>
    </div>

    {{-- Cuestionario (respuesta única) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_pruebas']])
</div>
