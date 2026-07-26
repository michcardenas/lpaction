{{-- Contenido de la etapa "Pruebas complementarias" — INGRESO 1 (editable desde el panel) --}}
@php
    $k = 'curso.cont.ingreso-1.pruebas.';
    // Vídeo: usa el subido (override) si existe; si no, el de disco por defecto.
    $vsrc = function ($key, $def) {
        $ov = \App\Support\Cms::raw($key);
        return asset(($ov && file_exists(public_path($ov))) ? $ov : $def);
    };
    $ecgImg = cms_img($k.'img_ecg', 'images/ecg.png');
@endphp
<div class="pruebas tabs-scope">
    <h1 class="h-caso">{{ cms($k.'h1', 'Pruebas complementarias') }}</h1>

    {{-- Tabs de pruebas --}}
    <div class="tabs">
        <button type="button" class="tab on" data-tab="ecg">{{ cms($k.'tab_ecg', 'Electrocardiograma (ECG)') }}</button>
        <button type="button" class="tab" data-tab="cateterismo">{{ cms($k.'tab_imagen', 'Pruebas de imagen') }}</button>
        <button type="button" class="tab" data-tab="analitica">{{ cms($k.'tab_analitica', 'Analítica sanguínea') }}</button>
    </div>

    {{-- Panel ECG --}}
    <div class="tab-panel prueba-panel" data-panel="ecg">
        <div class="ecg-block">
            <h3 class="prueba-h">{{ cms($k.'ecg_h', 'Electrocardiograma (ECG)') }}</h3>
            <p class="prueba-p">{{ cms($k.'ecg_p', 'Los servicios de emergencias extrahospitalarias realizan un ECG donde se evidencia una elevación del segmento ST en la cara inferoposterior (Figura 1), por lo que proceden a la administración inmediata de doble antiagregación.') }}</p>

            <div class="ecg-frame">
                <button type="button" class="ecg-icon ecg-expand" aria-label="Ampliar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                </button>
                <img src="{{ $ecgImg }}" alt="Electrocardiograma con elevación del segmento ST">
                <a class="ecg-icon ecg-download" href="{{ $ecgImg }}" download aria-label="Descargar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
                </a>
            </div>
            <p class="ecg-caption">{{ cms($k.'ecg_cap', 'Figura 1. Electrocardiograma con elevación del segmento ST en la cara inferoposterior.') }}</p>
        </div>
    </div>

    {{-- Panel Cateterismo / Pruebas de imagen --}}
    <div class="tab-panel prueba-panel" data-panel="cateterismo" style="display:none">
        <div class="cat-block">

            <h3 class="prueba-h">{{ cms($k.'cat_h', 'Cateterismo cardíaco') }}</h3>
            <div class="videos-grid">
                @foreach ([['cat1_video','videos/cateterismo-1.mp4','cat1_cap','Vídeo 1. Coronariografía. Arteria coronaria derecha con oclusión en segmento medio.'], ['cat2_video','videos/cateterismo-2.mp4','cat2_cap','Vídeo 2. Coronariografía. Estenosis significativa en descendente anterior.']] as $v)
                    <figure class="video-item">
                        <div class="video-player">
                            <video src="{{ $vsrc($k.$v[0], $v[1]) }}" preload="metadata" playsinline></video>
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
                        <figcaption class="video-cap">{{ cms($k.$v[2], $v[3]) }}</figcaption>
                    </figure>
                @endforeach
            </div>

            <h3 class="prueba-h">{{ cms($k.'eco_h', 'Ecocardiograma') }}</h3>
            <div class="videos-grid">
                <figure class="video-item">
                    <div class="video-player">
                        <video src="{{ $vsrc($k.'cat3_video', 'videos/cateterismo-3.mp4') }}" preload="metadata" playsinline></video>
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
                    <figcaption class="video-cap">{{ cms($k.'cat3_cap', 'Video 3. Ecocardiograma (plano 4 cámaras). Fracción de eyección del ventrículo izquierdo conservada.') }}</figcaption>
                </figure>
            </div>
            {!! cms($k.'nota', '<p class="prueba-p">Tras su llegada a Urgencias, el paciente es trasladado inmediatamente al área de Hemodinámica para la realización de una angioplastia primaria. En el cateterismo cardiaco los hallazgos son los siguientes: oclusión coronaria derecha y lesión moderada (50%) en descendente anterior. Se procede a angioplastia coronaria transluminal percutánea (ACTP) e implante de 2 stents farmacoactivos (DES) en coronaria derecha con éxito y sin complicaciones. Flujo final TIMI 3 (flujo coronario normal).</p><p class="prueba-p">En evaluación ecocardiográfica tras angioplastia, se objetiva fracción de eyección del ventrículo izquierdo (FEVI) conservada del 55%, con hipocinesia inferior.</p>') !!}
        </div>{{-- /cat-block --}}
    </div>

    {{-- Panel Analítica --}}
    <div class="tab-panel prueba-panel" data-panel="analitica" style="display:none">
        <div class="analitica-block">
            <h3 class="prueba-h">{{ cms($k.'ana_h', 'Analítica sanguínea') }}</h3>
            <p class="analitica-intro">{{ cms($k.'ana_intro', 'Se realiza analítica en las primeras 24 h de ingreso que incluye los siguientes valores:') }}</p>
            {!! cms($k.'ana_list', '<ul class="analitica-list"><li>Hemoglobina (Hb): 14,7 g/dL.</li><li>Glucosa plasmática (GLU): 110 mg/dL.</li><li>Hemoglobina glicada (HbA1c): 5,7%.</li><li>Creatinina: 0,68 mg/dL (tasa de filtrado glomerular [TFG CKD-EPI] 106 mL/min/1,73 m²).</li><li>Colesterol total (CT): 155 mg/dL.</li><li>Triglicéridos (TG): 78 mg/dL.</li><li>Colesterol unido a lipoproteínas de alta densidad (cHDL): 36 mg/dL.</li><li>Colesterol unido a lipoproteínas de baja densidad (cLDL): 104 mg/dL.</li><li>Colesterol remanente: 15 mg/dL.</li><li>Colesterol unido a lipoproteínas de muy baja densidad (cVLDL): 15,6 mg/dL.</li><li>TG/HDL: 2,16.</li><li>Hormona estimulante del tiroides (TSH) y tiroxina (T4): en rango.</li><li>Proteína C reactiva (PCR): 8,9 mg/L.</li></ul>') !!}
        </div>
    </div>

    {{-- Cuestionario (respuesta única) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_pruebas']])
</div>
