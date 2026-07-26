{{-- Contenido de la etapa "Pruebas complementarias" — INGRESO 2 --}}
@php
    $d = $curso['datos_ingreso_2'];
    $k = 'curso.cont.ingreso-2.pruebas.';
    $vsrc = function ($key, $def) { $ov = \App\Support\Cms::raw($key); return asset(($ov && file_exists(public_path($ov))) ? $ov : $def); };
    $ecg = cms_img($k.'img_ecg', 'images/ecg-2.png');
@endphp
<div class="pruebas tabs-scope">
    <h1 class="h-caso">Pruebas complementarias</h1>

    {{-- Tabs de pruebas (slider horizontal si no caben) --}}
    <div class="tabs">
        <button type="button" class="tab on" data-tab="ecg">Electrocardiograma (ECG)</button>
        <button type="button" class="tab" data-tab="cateterismo">Pruebas de imagen</button>
        <button type="button" class="tab" data-tab="eco">Ecocardiograma</button>
        <button type="button" class="tab" data-tab="itb">Índice tobillo brazo</button>
        <button type="button" class="tab" data-tab="analitica">Analítica sanguínea</button>
    </div>

    {{-- Panel ECG --}}
    <div class="tab-panel prueba-panel" data-panel="ecg">
        <div class="ecg-block">
            <h3 class="prueba-h">Electrocardiograma (ECG)</h3>
            <p class="prueba-p">{{ $d['ecg_texto'] }}</p>
            <div class="ecg-frame">
                <button type="button" class="ecg-icon ecg-expand" aria-label="Ampliar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                </button>
                <img src="{{ $ecg }}" onerror="this.onerror=null;this.src='{{ asset('images/ecg.png') }}'" alt="ECG SCASEST en ritmo sinusal">
                <a class="ecg-icon ecg-download" href="{{ $ecg }}" download aria-label="Descargar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
                </a>
            </div>
            <p class="ecg-caption">{{ $d['ecg_caption'] }}</p>
        </div>
    </div>

    {{-- Panel Cateterismo + Arteriografía femoral --}}
    <div class="tab-panel prueba-panel" data-panel="cateterismo" style="display:none">
        <div class="cat-block">
            <h3 class="prueba-h">Cateterismo cardíaco</h3>
            <p class="prueba-p">{{ $d['cateterismo_texto'] }}</p>
            <div class="videos-grid">
                <figure class="video-item">
                    <div class="video-player">
                        <video src="{{ $vsrc($k.'video1', 'videos/cateterismo-2-1.mp4') }}" preload="metadata" playsinline
                               onerror="this.onerror=null;this.src='{{ asset('videos/cateterismo-1.mp4') }}'"></video>
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
                    <figcaption class="video-cap">{{ $d['video4_caption'] }}</figcaption>
                </figure>
                <figure class="video-item">
                    <div class="video-player">
                        <video src="{{ $vsrc($k.'video2', 'videos/arteriografia-femoral.mp4') }}" preload="metadata" playsinline
                               onerror="this.onerror=null;this.src='{{ asset('videos/cateterismo-2.mp4') }}'"></video>
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
                    <figcaption class="video-cap">{{ $d['video5_caption'] }}</figcaption>
                </figure>
            </div>
        </div>
    </div>

    {{-- Panel Ecocardiograma --}}
    <div class="tab-panel prueba-panel" data-panel="eco" style="display:none">
        <div class="cat-block">
            <h3 class="prueba-h">Ecocardiograma transtorácico</h3>
            <p class="prueba-p">{{ $d['eco_texto'] }}</p>
        </div>
    </div>

    {{-- Panel Índice tobillo brazo --}}
    <div class="tab-panel prueba-panel" data-panel="itb" style="display:none">
        <div class="cat-block">
            <h3 class="prueba-h">Índice tobillo brazo (ITB)</h3>
            <p class="prueba-p">{{ $d['itb_texto'] }}</p>
        </div>
    </div>

    {{-- Panel Analítica --}}
    <div class="tab-panel prueba-panel" data-panel="analitica" style="display:none">
        <div class="analitica-block">
            <h3 class="prueba-h">Analítica sanguínea</h3>
            <p class="analitica-intro">Realizamos analítica en el servicio de Urgencias:</p>
            <ul class="analitica-list">
                @foreach ($d['analitica_urgencias'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Cuestionario (Pregunta 1 del Ingreso 2) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_pruebas_2']])
</div>
