<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $curso['titulo'] }} — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @view-transition { navigation: auto; } /* Dissolve suave al navegar entre páginas */
        body { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; }
        .curso-bg { background: #26383F; }
        /* ===== Nav ===== */
        .curso-nav { background: linear-gradient(90deg, #0a0f11 0%, #16201f 50%, #0a0f11 100%); }
        .nav-link {
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px;
            color: #E7ECEE; letter-spacing: .01em; white-space: nowrap;
            display: inline-flex; align-items: center; gap: 8px;
            height: 34px; padding: 8px 16px; border-radius: 4px;
            background: transparent; transition: background .25s ease, color .2s ease;
        }
        /* Hover = recuadro azul muy tenue (no cambia el color de la letra) */
        .nav-link:hover { background: rgba(100, 162, 196, 0.20); }
        .nav-link.active { color: #05BAEE; }
        .nav-org-txt { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; color: rgba(255,255,255,0.75); }

        /* Globos blancos pequeños y difuminados (detrás de Juan y esquina superior) */
        .curso-blob {
            position: absolute; width: 400px; height: 250px;
            background: #FFFFFF; opacity: 0.45; border-radius: 50%;
            filter: blur(180px); pointer-events: none; z-index: 0;
        }
        /* ===== Escala uniforme → mismo aspecto en cualquier PC ===== */
        .curso-stage { width: 1440px; padding: 0 78px; transform-origin: top center; position: relative; z-index: 1; }
        @media (max-width: 1023px) {
            .curso-stage { width: 100%; padding: 0 20px; transform: none !important; }
            .curso-scale-outer { height: auto !important; }
        }

        /* ===== Títulos ===== */
        .curso-title { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 38px; line-height: 130%; color: #FFFFFF; letter-spacing: 0; }
        .curso-subtitle { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 38px; line-height: 130%; letter-spacing: 0; text-align: right; }
        .curso-subtitle .rojo { color: #A23D33; }
        .curso-subtitle .cyan { color: #05BAEE; }

        /* ===== Juan ===== */
        .curso-row { position: relative; display: flex; justify-content: flex-end; margin-top: 140px; }
        .juan-col { position: absolute; left: 0; bottom: -28px; width: 297px; z-index: 2; }
        .juan-img { height: 690px; width: auto; max-width: none; display: block; margin-left: -105px; filter: drop-shadow(0 22px 38px rgba(0,0,0,0.45)); }
        .juan-cards {
            position: absolute; left: -40px; bottom: 100px;
            width: 285px;
            padding: 8px 0;                       /* padding-top/bottom 8px [Figma] */
            border-radius: 12px; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.16);
            background: linear-gradient(180deg, rgba(255,255,255,0.13) 0%, rgba(255,255,255,0.05) 100%);
            -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px);
            z-index: 2;
        }
        .juan-card {
            display: flex; align-items: center; gap: 14px;
            padding: 16px 18px;
            color: #E5ECEE;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; line-height: 130%;
        }
        .juan-card + .juan-card { border-top: 1px solid rgba(255,255,255,0.14); }
        .juan-card svg { flex-shrink: 0; width: 20px; height: 20px; color: #a6bcc3; }

        /* ===== Panel de ingresos ===== */
        .curso-panel {
            flex: none; width: 923px; min-width: 0;
            position: relative; top: -24px;   /* sube un poco la tabla (sin mover a Juan) */
            background: rgba(255,255,255,0.045);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 6px;
            -webkit-backdrop-filter: blur(14px); backdrop-filter: blur(14px);
            padding: 16px;
        }
        .ing-row {
            display: grid;
            grid-template-columns: 150px 1fr 70px 150px;
            align-items: center;
            gap: 28px;
            padding: 25px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.10);
        }
        .ing-label { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 22px; color: #05BAEE; }
        .ing-row.locked .ing-label { color: #5f7d86; }
        .ing-title { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #EAF0F2; padding-left: 28px; border-left: 1px solid rgba(255,255,255,0.12); }
        .ing-row.locked .ing-title { color: #8aa1a9; }
        .ing-pct { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; color: rgba(255,255,255,0.78); white-space: nowrap; }
        .ing-row.locked .ing-pct { color: #5f7d86; }
        .btn-iniciar {
            display: inline-flex; align-items: center; justify-content: center;
            width: 150px; height: 46px; border-radius: 8px;
            background: #05BAEE; color: #fff;
            font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px;
            transition: background .2s;
        }
        .btn-iniciar:hover { background: #04a3d1; }
        .btn-locked {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            width: 150px; height: 46px; border-radius: 8px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: #7c949c;
            font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px;
            cursor: not-allowed;
        }

        /* ===== Detalle del curso ===== */
        .detalle-head {
            display: grid; grid-template-columns: 150px 1fr auto; align-items: center; gap: 28px;
            padding: 26px 16px 18px;
        }
        .detalle-label { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 16px; color: rgba(255,255,255,0.55); }
        .detalle-estado { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; color: #05BAEE; padding-left: 28px; border-left: 1px solid rgba(255,255,255,0.12); }
        .detalle-hasta { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; color: rgba(255,255,255,0.62); white-space: nowrap; }
        .finales-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding-bottom: 8px; padding-left: 194px; padding-right: 16px; }
        .final-card {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px; border-radius: 10px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; color: #D6E0E3;
        }
        .final-card svg { color: #7c949c; }

        /* ===== Footer ===== */
        .curso-footer { background: #000000; }
        .footer-txt { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; line-height: 150%; color: #FFFFFF; }
        .footer-link { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; color: #FFFFFF; transition: color .2s; }
        .footer-link:hover { color: #05BAEE; }
    </style>
</head>
<body class="curso-bg h-screen flex flex-col text-white">

    {{-- ===== NAV ===== --}}
    <header class="curso-nav">
        <div class="mx-auto px-6 lg:px-12 h-16 flex items-center justify-between" style="max-width:1600px;">
            <div class="flex items-center" style="gap:30px;">
                <a href="{{ route('curso') }}" class="shrink-0 flex items-center" style="margin-right:4px;">
                    <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
                </a>
                <nav class="hidden md:flex items-center" style="gap:8px;">
                    <a href="{{ route('curso') }}" class="nav-link active">Inicio</a>
                    <a href="#" class="nav-link">Tutoría</a>
                    <a href="#" class="nav-link">Autores</a>
                    <button type="button" class="nav-link">
                        Perfil
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                </nav>
            </div>
            <div class="hidden md:flex items-center" style="gap:10px;">
                <span class="nav-org-txt">Organizado por</span>
                <img src="{{ asset('images/sec-logo.png') }}" alt="Sociedad Española de Cardiología" class="h-9 w-auto">
            </div>
        </div>
    </header>

    {{-- ===== CONTENIDO (escalado uniforme) ===== --}}
    <main class="flex-1 min-h-0 relative overflow-hidden curso-scale-outer">
        {{-- Globos blancos pequeños: detrás de Juan y en la esquina superior --}}
        <div class="curso-blob" style="left:1%; bottom:4%;"></div>
        <div class="curso-blob" style="right:3%; top:2%;"></div>

        <div class="curso-stage mx-auto pt-10 pb-10">

            {{-- Títulos --}}
            <div class="flex items-end justify-between" style="gap:32px; margin-top:34px; margin-bottom:40px;">
                <h1 class="curso-title">{{ $curso['titulo'] }}</h1>
                <p class="curso-subtitle">
                    <span class="rojo">{{ $curso['subtitulo_1'] }}</span>
                    <span class="cyan">{{ $curso['subtitulo_2'] }}</span>
                </p>
            </div>

            {{-- Fila: Juan + Panel (Juan absoluto → no infla la altura) --}}
            <div class="curso-row">

                {{-- Juan + tarjetas --}}
                <div class="juan-col">
                    <img class="juan-img" src="{{ asset($curso['paciente']['imagen']) }}" alt="{{ $curso['paciente']['nombre'] }}">
                    <div class="juan-cards">
                        @foreach ($curso['paciente']['datos'] as $dato)
                            <div class="juan-card">
                                @if ($dato['icon'] === 'edad')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v4M16 3v4"/></svg>
                                @elseif ($dato['icon'] === 'fuma')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="13" width="14" height="5" rx="1"/><path d="M12 13v5M7 13v5"/><path d="M18 5c1.2.7 1.2 2 .7 3M21 7c.6 1 .3 2.2-.5 2.8"/><path d="M19 13v5h3v-5z"/></svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.5 8.6c0-2.3-1.9-4.1-4.1-4.1-1.6 0-3 .9-3.7 2.3-.7-1.4-2.1-2.3-3.7-2.3C6.8 4.5 5 6.3 5 8.6c0 4.6 7.7 9.2 7.7 9.2s7.8-4.6 7.8-9.2Z"/></svg>
                                @endif
                                <span>{{ $dato['texto'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Panel de ingresos --}}
                <div class="curso-panel">

                    @foreach ($curso['ingresos'] as $ing)
                        @php
                            $p = $progress->get($ing['key']);
                            $status = $p->status ?? 'locked';
                            $percent = $p->percent ?? 0;
                            $abierto = in_array($status, ['available', 'in_progress', 'completed']);
                        @endphp
                        <div class="ing-row {{ $abierto ? '' : 'locked' }}">
                            <div class="ing-label">{{ $ing['label'] }}</div>
                            <div class="ing-title">{{ $ing['titulo'] }}</div>
                            <div class="ing-pct">{{ str_pad($percent, 2, '0', STR_PAD_LEFT) }} %</div>
                            <div>
                                @if ($abierto)
                                    <a href="#" class="btn-iniciar">Iniciar</a>
                                @else
                                    <span class="btn-locked">
                                        Iniciar
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Detalle del curso --}}
                    <div class="detalle-head">
                        <div class="detalle-label">Detalle del curso</div>
                        <div class="detalle-estado">No iniciado</div>
                        <div class="detalle-hasta">Disponible hasta: {{ $curso['disponible_hasta'] }}</div>
                    </div>
                    <div class="finales-grid">
                        @foreach ($curso['finales'] as $fin)
                            <div class="final-card">
                                <span>{{ $fin['titulo'] }}</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="curso-footer relative z-10">
        <div class="mx-auto px-6 lg:px-12 py-4 flex flex-col md:flex-row items-center justify-between gap-3" style="max-width:1600px;">
            <p class="footer-txt text-center md:text-left">
                El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. 2026 © Qualimed Ediciones S.L.
            </p>
            <div class="flex items-center gap-8">
                <a href="#" class="footer-link">Aviso legal</a>
                <a href="#" class="footer-link">Política de privacidad</a>
                <a href="#" class="footer-link">Política de cookies</a>
            </div>
        </div>
    </footer>

    <script>
        // Escala uniforme del curso → mismo aspecto en cualquier PC
        (function () {
            function scaleCurso() {
                var stage = document.querySelector('.curso-stage');
                if (!stage) return;
                if (window.innerWidth < 1024) { stage.style.transform = ''; return; }
                var designW = 1440;
                var designContentH = 780;                       // área de contenido del diseño (900 − nav 64 − footer 56)
                var contentH = window.innerHeight - 64 - 56;    // área de contenido real
                // Escala respecto al DISEÑO (no al alto del contenido) → el margen inferior
                // se mantiene proporcional en cualquier pantalla; nunca queda "pegado abajo".
                var s = Math.min(window.innerWidth / designW, contentH / designContentH);
                s = Math.min(s, 1.35);
                stage.style.transform = 'scale(' + s + ')';
            }
            window.addEventListener('resize', scaleCurso);
            window.addEventListener('load', scaleCurso);
            if (document.readyState !== 'loading') scaleCurso();
            else document.addEventListener('DOMContentLoaded', scaleCurso);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleCurso);
        })();
    </script>
</body>
</html>
