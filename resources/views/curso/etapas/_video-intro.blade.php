{{-- Vídeo de la etapa "Introducción" (reutilizable por ingreso). Recibe $ingresoNum.
     Usa videos/introduccion-{N}.mp4 cuando el cliente lo suba; mientras tanto muestra
     el marco con la imagen de respaldo, igual que "Puntos clave". --}}
@php
    $introVideo = 'videos/introduccion-'.$ingresoNum.'.mp4';
    $hayVideo   = file_exists(public_path($introVideo));
@endphp
<div class="riesgo">
    <h1 class="h-caso">Introducción</h1>

    <figure class="video-full">
        <div class="video-player">
            @if ($hayVideo)
                <video src="{{ asset($introVideo) }}" preload="metadata" playsinline></video>
            @else
                <img src="{{ asset('images/puntos-clave.png') }}" alt="Vídeo de introducción del módulo">
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
        <figcaption class="video-cap">Vídeo de introducción del módulo.</figcaption>
    </figure>
</div>
