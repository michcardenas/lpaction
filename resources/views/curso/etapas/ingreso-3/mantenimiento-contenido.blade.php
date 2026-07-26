{{-- Etapa "Terapia de mantenimiento…" — INGRESO 3: vídeo explicativo (petición del cliente). --}}
@php
    $k   = 'curso.cont.ingreso-3.mantenimiento.';
    $ov  = \App\Support\Cms::raw($k.'video');
    $def = 'videos/mantenimiento-3.mp4';
    $vid = ($ov && file_exists(public_path($ov))) ? $ov : $def;
    $hayVid = file_exists(public_path($vid));
@endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Terapia de mantenimiento al alta de rehabilitación cardiaca') }}</h1>

    <figure class="video-full">
        <div class="video-player">
            @if ($hayVid)
                <video src="{{ asset($vid) }}" preload="metadata" playsinline></video>
            @else
                <img src="{{ asset('images/mantenimiento-3.png') }}" onerror="this.onerror=null;this.src='{{ asset('images/puntos-clave.png') }}'" alt="Vídeo explicativo del caso">
            @endif
            <div class="video-controls">
                <button type="button" class="vid-btn vid-play" aria-label="Reproducir/Pausar">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                </button>
                <div class="vid-bar"><i></i></div>
                <button type="button" class="vid-btn vid-expand" aria-label="Pantalla completa">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                </button>
            </div>
        </div>
        <figcaption class="video-cap">{{ cms($k.'video_cap', 'Vídeo explicativo del caso.') }}</figcaption>
    </figure>
</div>
