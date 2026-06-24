<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- En celulares: bloquea el diseño a 390px y deja que el navegador lo escale → se ve idéntico
         (como una imagen) en cualquier ancho de teléfono, sin romperse. Tablets quedan para después. --}}
    <script>
        (function () {
            var vp = document.querySelector('meta[name="viewport"]');
            if (!vp) return;
            function apply() {
                var phone = Math.min(screen.width || 9999, screen.height || 9999) < 768;
                vp.setAttribute('content', phone ? 'width=390' : 'width=device-width, initial-scale=1.0');
            }
            apply();
            window.addEventListener('orientationchange', apply);
        })();
    </script>
    <title>Lp(a)ction — ¿Qué cambia en tu práctica cuando la Lp(a) está elevada?</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        html { scroll-behavior: smooth; }

        /* ── Header / Nav (exacto al Figma) ──────────────────────── */
        .header-bar {
            background: linear-gradient(90deg, #060606 0%, #181818 50%, #060606 100%);
        }
        .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;             /* Medium */
            font-size: 12px;
            line-height: 150%;
            letter-spacing: 0.01em;       /* 1% */
            color: #ffffff;
            transition: opacity .2s ease;
            opacity: .9;
        }
        .nav-link:hover { opacity: 1; }
        .logo-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            letter-spacing: -0.01em;
        }
        .org-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 12px;
            letter-spacing: 0.01em;
        }
        .btn-acceder {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.01em;
            background: #05BAEE;
            color: #ffffff;
            padding: 9px 24px;
            border-radius: 7px;
            transition: background .2s ease;
            white-space: nowrap;
        }
        .btn-acceder:hover { background: #04a3d1; }
        .hero-gradient {
            background:
                radial-gradient(ellipse at 100% 0%, #e8f0f5 0%, transparent 50%),
                radial-gradient(ellipse at 0% 100%, #f5e8e8 0%, transparent 50%),
                #F9F9F8;
        }

        /* ── Reveal-on-scroll (subtle, accessible) ───────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity .8s cubic-bezier(.16,1,.3,1), transform .8s cubic-bezier(.16,1,.3,1);
            will-change: opacity, transform;
        }
        .reveal.is-visible { opacity: 1; transform: none; }
        .reveal-stagger > * {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1);
        }
        .reveal-stagger.is-visible > * { opacity: 1; transform: none; }
        .reveal-stagger.is-visible > *:nth-child(1){ transition-delay:.05s }
        .reveal-stagger.is-visible > *:nth-child(2){ transition-delay:.15s }
        .reveal-stagger.is-visible > *:nth-child(3){ transition-delay:.25s }
        .reveal-stagger.is-visible > *:nth-child(4){ transition-delay:.35s }
        .reveal-stagger.is-visible > *:nth-child(5){ transition-delay:.45s }

        /* ── Dark cellular band background ───────────────────────── */
        .band-dark {
            background-color: #16323b;
            background-image:
                radial-gradient(circle at 18% 25%, rgba(120,170,185,.18) 0, transparent 9%),
                radial-gradient(circle at 72% 60%, rgba(150,190,205,.14) 0, transparent 8%),
                radial-gradient(circle at 40% 80%, rgba(100,150,170,.12) 0, transparent 10%),
                radial-gradient(circle at 90% 20%, rgba(34,211,238,.10) 0, transparent 12%),
                radial-gradient(ellipse at 50% 50%, #1d3d47 0%, #122a32 100%);
        }
        .band-deep {
            background:
                radial-gradient(ellipse at 75% 30%, rgba(34,211,238,.10) 0%, transparent 45%),
                radial-gradient(ellipse at 15% 90%, rgba(80,130,150,.18) 0%, transparent 50%),
                linear-gradient(160deg, #1b3a44 0%, #16323b 45%, #102229 100%);
        }
        /* "No es un caso teórico" — bg #26383F */
        .band-caso { background-color: #26383F; }
        /* Globos blancos (Figma): 543×308 · white · opacity .5 · blur 400px */
        .caso-blob {
            position: absolute;
            width: 543px;
            height: 308px;
            background: #FFFFFF;
            opacity: 0.62;
            border-radius: 50%;
            filter: blur(380px);
            pointer-events: none;
            z-index: 0;
        }
        /* Texto del caso: ancho fijo en laptop → distribución de líneas idéntica siempre */
        .caso-text { width: 100%; }
        @media (min-width: 1024px) {
            .caso-text { width: 558px; flex-shrink: 0; }
            /* Tarjeta anclada abajo, alineada con el final de "Juan" (18px desde abajo) */
            .caso-card {
                position: absolute;
                right: -58px;
                bottom: 18px;
                top: auto;
                transform: none;
                margin-top: 0;
            }
        }
        /* Tipografía de la tarjeta de datos */
        .card-txt {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 14px;
            line-height: 150%;
            letter-spacing: 0.02em;
        }
        .card-estilo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 16px;
            line-height: 150%;
            letter-spacing: 0;
        }
        .card-row { padding: 17px 16px; }
        /* Escala uniforme de la sección Juan (laptop) → se ve idéntica en cualquier ancho */
        .caso-scale-outer { position: relative; z-index: 10; width: 100%; overflow: hidden; }
        .caso-scale-inner { width: 1340px; position: relative; left: 50%; margin-left: -670px; transform-origin: top center; }
        @media (max-width: 1023px) {
            .caso-scale-inner { width: 100%; left: 0; margin-left: 0; transform: none !important; }
            .caso-scale-outer { height: auto !important; }
        }
        /* "Contenidos formativos" — dark heading band + light module cards */
        .contenidos-band {
            background:
                radial-gradient(ellipse 60% 95% at 62% 35%, rgba(192,210,218,.16) 0%, transparent 58%),
                linear-gradient(165deg, #38484f 0%, #2d3c43 55%, #283740 100%);
        }
        .contenidos-cards {
            background:
                radial-gradient(ellipse 46% 62% at 50% 42%, rgba(255,255,255,.55) 0%, transparent 66%),
                linear-gradient(180deg, #c2d3d9 0%, #dce8eb 50%, #eef5f7 100%);
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .reveal, .reveal-stagger > * {
                opacity: 1 !important; transform: none !important; transition: none !important;
            }
        }
        /* Unified scaling — everything in the hero proportional to the same unit.
           Uses min(vh, vw) so the layout looks identical at any PC resolution. */
        /* ── Hero con escala uniforme ────────────────────────────────
           --u = "pixel de diseño" que se ajusta al viewport (min ancho/alto).
           Base: 1440px ancho × 760px alto de hero → a 1440px, --u = 1px = px exacto Figma.
           En cualquier otra pantalla todo escala junto → se ve IDÉNTICO. */
        .hero {
            --u: min(calc(100vw / 1440), calc((100vh - 4rem) / 760));
            min-height: calc(100vh - 4rem);
            display: flex;
            align-items: center;
        }
        .hero-inner {
            width: 100%;
            height: calc(var(--u) * 760);
            max-width: calc(var(--u) * 1340);
            padding-left: calc(var(--u) * 24);
            padding-right: calc(var(--u) * 24);
        }
        .hero-eyebrow {
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;                       /* Regular */
            font-size: calc(var(--u) * 20);
            line-height: 150%;
            letter-spacing: 0;
            color: #913029;
        }
        .hero-title-1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;                       /* Light */
            font-size: calc(var(--u) * 48);
            line-height: 120%;
            letter-spacing: 0;
            color: #111111;
        }
        .hero-title-2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;                       /* Bold */
            font-size: calc(var(--u) * 48);
            line-height: 120%;
            letter-spacing: 0;
            color: #111111;
            white-space: nowrap;
        }
        .hero-pad-top      { padding-top: calc(var(--u) * 40); }
        .hero-pad-bottom   { padding-bottom: calc(var(--u) * 36); }
        .hero-eyebrow-mb   { margin-bottom: calc(var(--u) * 14); }
        .hero-title-gap    { margin-top: calc(var(--u) * 6); }
        .hero-bar-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;                       /* Regular */
            font-size: calc(var(--u) * 16);
            line-height: 150%;
            letter-spacing: 0;
        }
        .hero-bar-cta      { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: calc(var(--u) * 16); padding: calc(var(--u) * 16) calc(var(--u) * 28); background: #05BAEE; color: #fff; }
        .hero-bar-cta:hover { background: #04a3d1; }
        .hero-bar {
            padding: calc(var(--u) * 16) calc(var(--u) * 16) calc(var(--u) * 16) calc(var(--u) * 32);
            gap: calc(var(--u) * 32);
            min-height: calc(var(--u) * 100);
            border-radius: calc(var(--u) * 8);
            background: rgba(255, 255, 255, 0.10);        /* #FFFFFF1A */
            border: 1px solid rgba(191, 191, 191, 0.30);  /* #BFBFBF4D */
            -webkit-backdrop-filter: blur(40px);
            backdrop-filter: blur(40px);
        }
        .hero-mol {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: calc(var(--u) * 184);
            z-index: 20;
            width: calc(var(--u) * 560);
            pointer-events: none;
        }
        .hero-mol img { width: 100%; height: auto; object-fit: contain; display: block; }
        @media (max-width: 767px) {
            /* ── Resetear sistema de escala desktop ──────────────────── */
            .hero {
                --u: 1px;
                min-height: auto;
                display: block;          /* sale del flex centrador desktop */
            }
            .hero-inner {
                height: auto !important;
                max-width: 100%;
                padding-left: 5vw;
                padding-right: 5vw;
                display: flex;
                flex-direction: column;
            }
            /* Ocultar el spacer desktop que empuja el bar al fondo */
            .hero-inner > .flex-1 { display: none !important; }

            /* ── Tipografía fija (spec Figma) ───────────────────────── */
            .hero-eyebrow  {
                font-family: 'Montserrat', sans-serif;
                font-weight: 500;
                font-size: 20px;
                line-height: 150%;
                letter-spacing: 0.02em;
                text-align: center;
                color: #913029;
                width: 358px;
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
            }
            .hero-title-1  { font-family: 'Montserrat', sans-serif; font-weight: 300; font-size: 32px; line-height: 120%; letter-spacing: 0; text-align: center; }
            .hero-title-2  { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 32px; line-height: 120%; letter-spacing: 0; text-align: center; white-space: normal; }

            /* ── Espaciados compactos ────────────────────────────────── */
            .hero-pad-top    { padding-top: 5vw; padding-bottom: 0; position: relative; z-index: 5; }
            .hero-pad-bottom { padding-top: 0; padding-bottom: 5vw; margin-top: -12px; }
            .hero-eyebrow-mb { margin-bottom: 2vw; }
            .hero-title-gap  { margin-top: 1vw; }

            /* ── Molécula: spec Figma exacto ────────────────────────── */
            .hero-mol {
                position: relative;
                left: -8px;
                top: 10px;
                transform: none;
                width: 373px;
                height: 335px;
                max-width: calc(100% + 8px);
                margin-top: -36px;
                z-index: 10;
                flex-shrink: 0;
            }
            .hero-mol img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                filter: drop-shadow(0px 4px 4px rgba(0,0,0,0.50));
            }

            /* ── Bar inferior (spec Figma exacto) ───────────────────── */
            .hero-bar {
                width: 358px;
                max-width: calc(100% - 10vw);
                min-height: 149px;
                padding: 8px;
                gap: 2px;
                border-radius: 8px;
                border: 1px solid rgba(191,191,191,0.30);
                background: rgba(255,255,255,0.10);
                -webkit-backdrop-filter: blur(40px);
                backdrop-filter: blur(40px);
                flex-direction: column !important;
                align-items: stretch !important;
                margin-left: auto;
                margin-right: auto;
            }
            .hero-bar-text {
                font-size: 13px;
                line-height: 150%;
                width: 100%;
                min-height: auto;
            }
            .hero-bar-cta  {
                width: 100%;
                height: 45px;
                padding: 12px 24px;
                border-radius: 4px;
                font-size: 15px;
                justify-content: center;
                gap: 12px;
                margin-top: 0;
            }
        }
    </style>
</head>
<body class="antialiased text-neutral-900">

    {{-- Header --}}
    <header class="header-bar text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8 xl:gap-12">
                {{-- Logo --}}
                <a href="/" class="shrink-0 flex items-center">
                    <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto"
                         onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='inline-block';">
                    <span class="logo-text text-[22px] leading-none" style="display:none;">Lp<span class="text-[#22d3ee]">(a)</span>ction</span>
                </a>
                {{-- Nav --}}
                <nav class="hidden lg:flex items-center gap-8 xl:gap-9">
                    <a href="#caso" class="nav-link">Caso clínico</a>
                    <a href="#metodologia" class="nav-link">Metodología</a>
                    <a href="#contenidos" class="nav-link">Contenidos</a>
                    <a href="#comite" class="nav-link">Comité científico</a>
                </nav>
            </div>

            <div class="flex items-center gap-4 lg:gap-5">
                {{-- Organizado por + SEC logo --}}
                <div class="hidden md:flex items-center gap-2.5">
                    <span class="org-text text-white/80">Organizado por:</span>
                    <img src="{{ asset('images/sec-logo.png') }}" alt="Sociedad Española de Cardiología" class="h-9 w-auto"
                         onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
                    {{-- Fallback SEC --}}
                    <div class="items-center gap-2" style="display:none;">
                        <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                            <path d="M12 20s-7-4.6-9.2-9C1.4 8 3.2 4.8 6.4 4.8c2 0 3.4 1.3 4.6 3 1.2-1.7 2.6-3 4.6-3 3.2 0 5 3.2 3.6 6.2C19 15.4 12 20 12 20Z"/>
                            <path d="M6 12h3l1.5-3 2.5 6 1.5-3H18" stroke-width="1.1"/>
                        </svg>
                        <span class="text-white text-[7px] leading-[1.25] font-semibold tracking-wide uppercase">Sociedad Española<br>de Cardiología</span>
                    </div>
                </div>
                {{-- Acceder --}}
                <a href="{{ route('login') }}" class="btn-acceder">Acceder</a>
                {{-- Mobile menu button --}}
                <button id="mob-open" class="lg:hidden text-white" aria-label="Abrir menú">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile nav overlay --}}
    {{-- Fondo NEGRO; gris solo arriba (degradado) tras el logo y los 2 botones; sin líneas --}}
    <div id="mob-menu" style="display:none; position:fixed; inset:0; z-index:9999; background:linear-gradient(180deg, #2b2b2d 0%, #000000 30%); flex-direction:column;">
        {{-- Top bar --}}
        <div style="height:64px; flex-shrink:0; display:flex; align-items:center; justify-content:space-between; padding:0 24px;">
            <a href="/" style="display:flex; align-items:center;">
                {{-- Logo: 113×24 (spec Figma) --}}
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" style="width:113px; height:24px; object-fit:contain; object-position:left;"
                     onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='inline';">
                <span style="display:none; font-family:'Montserrat',sans-serif; font-size:20px; font-weight:600; color:#fff;">Lp<span style="color:#05BAEE;">(a)</span>ction</span>
            </a>
            <div style="display:flex; align-items:center; gap:12px;">
                {{-- Botón Acceder: #05BAEE · radius 4 · padding 12/16 · texto Montserrat Medium 12/150%/ls1%/blanco --}}
                <a href="{{ route('login') }}" style="font-family:'Montserrat',sans-serif; font-size:12px; font-weight:500; letter-spacing:0.01em; line-height:150%; color:#FFFFFF; background:#05BAEE; padding:12px 16px; border-radius:4px; text-decoration:none;">Acceder</a>
                {{-- Cerrar: X glyph 7.5px en frame 18px · blanco (spec) --}}
                <button id="mob-close" aria-label="Cerrar menú" style="background:none; border:none; cursor:pointer; padding:4px; display:flex; align-items:center; justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round"><path d="M5.25 5.25 L12.75 12.75"/><path d="M12.75 5.25 L5.25 12.75"/></svg>
                </button>
            </div>
        </div>
        {{-- Nav links --}}
        <nav style="flex:1; display:flex; flex-direction:column; justify-content:center; padding:0 32px; gap:8px; text-align:center;">
            <a href="#caso"       class="mob-link" onclick="closeMobMenu()">Caso clínico</a>
            <a href="#metodologia" class="mob-link" onclick="closeMobMenu()">Metodología</a>
            <a href="#contenidos" class="mob-link" onclick="closeMobMenu()">Contenidos</a>
            <a href="#comite"     class="mob-link" onclick="closeMobMenu()">Comité científico</a>
        </nav>
        {{-- Footer SEC --}}
        <div style="padding:40px 32px 12px; display:flex; flex-direction:column; align-items:center; gap:24px;">
            {{-- "Organizado por:" Montserrat Medium 12 / 150% / ls 2% / blanco --}}
            <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; line-height:150%; letter-spacing:0.02em; color:#FFFFFF;">Organizado por:</span>
            {{-- Logo SEC: 148×77 (spec) · archivo HD para que no se vea borroso --}}
            <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" style="width:148px; height:77px; object-fit:contain;"
                 onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div style="display:none; align-items:center; gap:10px;">
                <svg style="width:36px;height:36px;color:#fff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                    <path d="M12 20s-7-4.6-9.2-9C1.4 8 3.2 4.8 6.4 4.8c2 0 3.4 1.3 4.6 3 1.2-1.7 2.6-3 4.6-3 3.2 0 5 3.2 3.6 6.2C19 15.4 12 20 12 20Z"/>
                    <path d="M6 12h3l1.5-3 2.5 6 1.5-3H18" stroke-width="1.1"/>
                </svg>
                <span style="font-family:'Montserrat',sans-serif; font-size:11px; font-weight:600; color:#fff; line-height:1.4; text-transform:uppercase; letter-spacing:.05em;">Sociedad Española<br>de Cardiología</span>
            </div>
        </div>
    </div>
    <style>
        .mob-link {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: 500;          /* Medium */
            line-height: 150%;
            letter-spacing: 0.01em;    /* 1% */
            color: #FFFFFF;
            text-decoration: none;
            padding: 14px 0;
            transition: color .2s;
        }
        .mob-link:hover { color: #05BAEE; }
    </style>
    <script>
        var mobMenu = document.getElementById('mob-menu');
        document.getElementById('mob-open').addEventListener('click', function () {
            mobMenu.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        document.getElementById('mob-close').addEventListener('click', closeMobMenu);
        function closeMobMenu() {
            mobMenu.style.display = 'none';
            document.body.style.overflow = '';
        }
    </script>

    {{-- Hero --}}
    <section class="relative overflow-hidden hero-gradient hero">
        <div class="hero-inner mx-auto flex flex-col relative">

            {{-- Top: eyebrow + title --}}
            <div class="text-center hero-pad-top relative z-10">
                <p class="hero-eyebrow hero-eyebrow-mb">
                    ¿Qué cambia en tu práctica cuando la Lp(a) está elevada?
                </p>

                <h1>
                    <span class="block hero-title-1">Juan ingresa tres veces.</span>
                    <span class="block hero-title-gap hero-title-2">
                        El tratamiento parece <em class="italic">correcto. La</em> evolución, no.</em>
                    </span>
                </h1>
            </div>

            {{-- Molecule (in front of text, slightly overlapping title bottom and bar top) --}}
            <div class="hero-mol">
                <img
                    src="{{ asset('images/molecula-lpa.png') }}"
                    alt="Representación 3D de Lipoproteína(a)"
                >
            </div>

            {{-- Spacer to push bar to bottom --}}
            <div class="flex-1"></div>

            {{-- Bottom: SEAFORMEC bar (ON TOP of the molecule) --}}
            <div class="hero-pad-bottom relative" style="z-index: 30;">
                <div class="hero-bar flex flex-col md:flex-row items-start md:items-center justify-between">
                    <p class="text-neutral-600 max-w-2xl leading-relaxed hero-bar-text">
                        Solicitada la acreditación al Sistema Español de Acreditación de la Formación Médica Continuada (SEAFORMEC).
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-3 font-medium rounded-lg transition whitespace-nowrap hero-bar-cta">
                        Accede al curso
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M7 17L17 7M17 7H8M17 7V16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Band: intro statement (bg #5E8B97 + cell texture) ──────── --}}
    <section class="relative overflow-hidden" style="background-color:#5E8B97;">
        {{-- Real microscopic texture --}}
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image:url('{{ asset('images/fondo_hero_intermedio.png') }}');"></div>
        {{-- #5E8B97 multiply: recolora la textura clara al tono teal del diseño --}}
        <div class="absolute inset-0" style="background:#5E8B97; mix-blend-mode:multiply;"></div>

        {{-- Banda desktop 1440×160 / móvil 390×208 --}}
        <div class="intro-band-inner relative mx-auto flex items-center" style="max-width:1332px;">
            <div class="reveal w-full" style="border-left:1px solid #FFFFFF; padding:8px 16px;">
                <p class="intro-band-p" style="font-family:'Montserrat',sans-serif; font-weight:600; font-size:16px; line-height:150%; letter-spacing:0; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,.35);">
                    Este curso online acreditado te sitúa ante el recorrido clínico de Juan para identificar cuándo la Lp(a) cambia la interpretación del riesgo residual y su pronóstico.
                </p>
            </div>
        </div>
    </section>
    <style>
        @media (max-width: 767px) {
            /* Caso section: padding 16px para que texto quede a 358px en 390px */
            #caso .relative.px-6 { padding-left: 16px !important; padding-right: 16px !important; }

            .intro-band-inner {
                min-height: 208px;
                padding: 24px 16px;
                align-items: center;
            }
            .intro-band-inner > .reveal {
                border-left: 1px solid #FFFFFF !important;
                padding: 8px 8px 8px 12px !important;
            }
            .intro-band-p {
                width: 100%;
                max-width: 100%;
                font-size: 16px !important;
                line-height: 150% !important;
                font-weight: 600 !important;
                letter-spacing: -0.01em !important;
            }

            /* FIX: el wrapper .reveal mantiene will-change:transform tras animar, lo que lo
               convierte en "backdrop root" y anula el backdrop-filter de la card. Lo liberamos
               una vez visible para que el efecto vidrio esmerilado funcione. */
            #caso .reveal.is-visible { will-change: auto !important; }

            /* Glassmorphism layered effect: top highlight + center vertical reflection */
            .caso-card-glass {
                position: relative;
            }
            .caso-card-glass::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0));
                pointer-events: none;
                z-index: 1;
            }
            .caso-card-glass > * {
                position: relative;
                z-index: 2;
            }
        }
    </style>

    {{-- ── Section: No es un caso teórico ─────────────────────────── --}}
    <section id="caso" class="band-caso relative overflow-hidden">
        {{-- Globos blancos: 543×308 · white · opacity .5 · blur(400px) [Figma] --}}
        <div class="caso-blob" style="left:3%; bottom:2%;"></div>
        <div class="caso-blob" style="right:7%; top:4%;"></div>

        <div class="caso-scale-outer">
        <div class="caso-scale-inner">
        <div class="relative px-6 lg:px-10 py-16 lg:py-20">
            <div class="flex flex-col lg:flex-row gap-3 lg:gap-12 items-center">

                {{-- Left: text (fixed width on laptop) --}}
                <div class="reveal-stagger order-1 caso-text">
                    <div class="flex items-center gap-3 mb-6">
                        <span style="display:inline-block; width:32px; height:0; border-top:0.5px solid #05BAEE; flex-shrink:0;"></span>
                        <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; line-height:150%; letter-spacing:0.02em; color:#05BAEE;">Caso clínico</span>
                    </div>

                    <h2 class="mb-7 caso-titulo" style="font-family:'Montserrat',sans-serif; font-weight:600; font-size:22px; line-height:140%; letter-spacing:0; width:358px; max-width:100%;">
                        <span class="block" style="color:#FFFFFF;">No es un caso teórico.</span>
                        <span class="block" style="color:#05BAEE;">Es un paciente que vuelve.</span>
                    </h2>

                    <div style="font-family:'Montserrat',sans-serif; font-weight:400; font-size:13px; line-height:150%; letter-spacing:0; color:#FFFFFF; width:358px; max-width:100%;">
                        <p class="mb-4">A lo largo de tres ingresos hospitalarios, seguirás la evolución de Juan en distintos momentos clave de su trayectoria cardiovascular.</p>
                        <p>En cada contacto clínico con el paciente tendrás la oportunidad de tomar decisiones que impacten en su pronóstico.</p>
                    </div>
                </div>

                {{-- Right: Juan + data card --}}
                <div class="reveal order-2 lg:order-2 w-full lg:flex-1 relative lg:min-h-[500px] lg:block">

                    {{-- Concentric ripple rings at Juan's feet --}}
                    <svg class="hidden lg:block absolute left-[33%] bottom-[6%] -translate-x-1/2 w-[480px] h-[160px] opacity-60 pointer-events-none" viewBox="0 0 480 160" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 5; $r++)
                            <ellipse cx="240" cy="145" rx="{{ $r * 46 }}" ry="{{ $r * 14 }}"
                                     stroke="#84b0bd" stroke-width="1" opacity="{{ 0.5 - $r * 0.08 }}"/>
                        @endfor
                    </svg>

                    {{-- Mobile: Juan + card stacked with card overlapping --}}
                    <div class="lg:hidden relative w-full" style="margin-top:-120px;">
                        {{-- Juan image --}}
                        <div class="relative" style="width:160%; margin-left:-30%; margin-right:-30%; height:auto;">
                            <img src="{{ asset('images/juan.png') }}" alt="Juan, paciente del caso clínico"
                                 style="width:100%; height:auto; aspect-ratio:358/480; object-fit:contain; display:block; opacity:0.95;">
                            <span class="absolute" style="left:18%; bottom:38%; color:#05BAEE; font-family:'Montserrat',sans-serif; font-weight:700; font-size:24px; line-height:34px; letter-spacing:0; text-align:left; display:inline-block; z-index:5;">Juan</span>
                        </div>
                        {{-- Data card overlapping Juan's lower body --}}
                        <div class="caso-card caso-card-glass relative z-20"
                             style="margin-top:-74%; margin-left:auto; margin-right:auto; width:358px; max-width:calc(100% - 8px); display:flex; flex-direction:column; border-radius:0; overflow:hidden; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.18); -webkit-backdrop-filter:blur(16px) saturate(120%); backdrop-filter:blur(16px) saturate(120%); box-shadow:inset 0 1px 0 rgba(255,255,255,0.20), 0 8px 30px rgba(0,0,0,0.12);">
                            {{-- Edad --}}
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; border-bottom:1px solid rgba(255,255,255,0.08);">
                                <span style="display:flex; align-items:center; gap:10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.6"><rect x="2.5" y="6" width="19" height="13" rx="2"/><path d="M7 6V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/></svg>
                                    <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; color:rgba(255,255,255,0.85); letter-spacing:0.02em;">Edad</span>
                                </span>
                                <span style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:16px; color:#FFFFFF;">52</span>
                            </div>
                            {{-- Peso --}}
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; border-bottom:1px solid rgba(255,255,255,0.08);">
                                <span style="display:flex; align-items:center; gap:10px;">
                                    <svg width="16" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="3"/><rect x="7" y="6" width="10" height="6" rx="1.5"/><line x1="8" y1="16" x2="16" y2="16"/></svg>
                                    <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; color:rgba(255,255,255,0.85); letter-spacing:0.02em;">Peso</span>
                                </span>
                                <span style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:16px; color:#FFFFFF;">82 kg</span>
                            </div>
                            {{-- Índice paquetes-año --}}
                            <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; border-bottom:1px solid rgba(255,255,255,0.08);">
                                <span style="display:flex; align-items:center; gap:10px;">
                                    <svg width="18" height="15" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.6"><rect x="2" y="11" width="15" height="5" rx="1"/><path d="M13 11v5M6 11v5"/><path d="M20 5.5c1 .6 1 1.6.6 2.4M17 4.5c1.2.7 1.2 2 .7 3"/><path d="M19 11v5h3v-5z"/></svg>
                                    <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; color:rgba(255,255,255,0.85); letter-spacing:0.02em;">Índice paquetes-año</span>
                                </span>
                                <span style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:16px; color:#FFFFFF;">42</span>
                            </div>
                            {{-- Estilo de vida --}}
                            <div style="padding:10px 14px;">
                                <span style="display:flex; align-items:center; gap:10px; margin-bottom:4px;">
                                    <svg width="18" height="16" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.6"><path d="M20.5 8.5c0-2.2-1.8-4-4-4-1.6 0-3 .9-3.7 2.3C12.1 5.4 10.7 4.5 9 4.5c-2.2 0-4 1.8-4 4 0 4.5 7.5 9 7.5 9s8-4.5 8-9Z"/><polyline points="7,12 10,9 13,13 16,10"/></svg>
                                    <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; color:rgba(255,255,255,0.85); letter-spacing:0.02em;">Estilo de vida</span>
                                </span>
                                <span style="font-family:'Montserrat',sans-serif; font-weight:700; font-size:16px; color:#FFFFFF; display:block;">Vida sedentaria, alto nivel de estrés</span>
                            </div>
                        </div>
                    </div>

                    {{-- Desktop: Juan figure --}}
                    <div class="hidden lg:flex relative z-10 justify-start pl-[4%]">
                        <div class="relative">
                            <img src="{{ asset('images/juan.png') }}" alt="Juan, paciente del caso clínico"
                                 class="h-[520px] w-auto object-contain">
                            <span class="absolute" style="left:16px; transform:none; bottom:35%; color:#05BAEE; font-family:'Montserrat',sans-serif; font-weight:700; font-size:24px; line-height:34px; letter-spacing:0; width:66px; text-align:left; display:inline-block;">Juan</span>
                        </div>
                    </div>

                    {{-- Desktop: Data card --}}
                    <div class="caso-card hidden lg:flex relative z-20 overflow-hidden"
                         style="flex-direction:column; border-radius:12px; background:rgba(0,0,0,0.18); -webkit-backdrop-filter:blur(16px); backdrop-filter:blur(16px);">
                        {{-- Edad --}}
                        <div class="flex items-center justify-between card-row" style="background:rgba(255,255,255,0.08); padding:9px 12px; height:36px; box-sizing:border-box;">
                            <span class="flex items-center gap-3 text-slate-300 card-txt">
                                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2.5" y="6" width="19" height="13" rx="2"/><path d="M7 6V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/></svg>
                                Edad
                            </span>
                            <span class="text-white card-txt font-semibold">52</span>
                        </div>
                        {{-- Peso --}}
                        <div class="flex items-center justify-between card-row" style="background:rgba(255,255,255,0.08); padding:9px 12px; height:36px; box-sizing:border-box;">
                            <span class="flex items-center gap-3 text-slate-300 card-txt">
                                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="3"/><rect x="7" y="6" width="10" height="6" rx="1.5"/><line x1="8" y1="16" x2="16" y2="16"/></svg>
                                Peso
                            </span>
                            <span class="text-white card-txt font-semibold">82 kg</span>
                        </div>
                        {{-- Índice paquetes-año --}}
                        <div class="flex items-center justify-between card-row" style="background:rgba(255,255,255,0.08); padding:9px 12px; height:36px; box-sizing:border-box;">
                            <span class="flex items-center gap-3 text-slate-300 card-txt">
                                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="11" width="15" height="5" rx="1"/><path d="M13 11v5M6 11v5"/><path d="M20 5.5c1 .6 1 1.6.6 2.4M17 4.5c1.2.7 1.2 2 .7 3"/><path d="M19 11v5h3v-5z"/></svg>
                                Índice paquetes-año
                            </span>
                            <span class="text-white card-txt font-semibold">42</span>
                        </div>
                        {{-- Estilo de vida --}}
                        <div class="card-row" style="background:rgba(255,255,255,0.08); padding:9px 12px;">
                            <span class="flex items-center gap-3 text-slate-300 card-txt mb-1">
                                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.5 8.5c0-2.2-1.8-4-4-4-1.6 0-3 .9-3.7 2.3C12.1 5.4 10.7 4.5 9 4.5c-2.2 0-4 1.8-4 4 0 4.5 7.5 9 7.5 9s8-4.5 8-9Z"/><polyline points="7,12 10,9 13,13 16,10"/></svg>
                                Estilo de vida
                            </span>
                            <span class="block text-white card-estilo leading-snug pl-[30px]">Vida sedentaria, alto nivel de estrés</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>{{-- /caso-scale-inner --}}
        </div>{{-- /caso-scale-outer --}}
    </section>

    {{-- ── Section: Cómo trabajarás el caso (Metodología) ─────────── --}}
    <style>
        @media (max-width: 767px) {
            #metodologia { padding-top: 56px; padding-bottom: 56px; }
            #metodologia > .max-w-7xl { padding-left: 16px; padding-right: 16px; }
            /* Título — spec Figma exacto: Montserrat SemiBold 26 / 130% / ls 0 / 358×34 (1 línea) */
            .metod-title {
                font-family: 'Montserrat', sans-serif;
                font-weight: 600;            /* SemiBold */
                font-size: 26px;
                line-height: 130%;
                letter-spacing: 0;
                color: #FFFFFF;
                width: 358px;
                max-width: 100%;
                margin-top: -12px;           /* subir el título un poquito (acercar al eyebrow) */
                margin-bottom: 32px;
            }

            /* ── Tabla I–V (spec Figma móvil) ────────────────────────────
               Tabla = 358 ancho. Fila: padding 16 lados → 326 interno.
               Col numeral 32 + col texto 294 = 326 → texto exacto a 294px. */
            .metod-row {
                /* tabla 358 − 2 borde − 32 padding − 30 numeral = 294 texto exacto */
                grid-template-columns: 30px 1fr !important;
                column-gap: 0 !important;
                align-items: start !important;
                padding: 16px !important;     /* (no en spec) alto de fila */
            }
            .metod-num {
                grid-row: 1 / 3 !important;          /* abarca título + descripción */
                align-self: center !important;       /* numeral centrado vertical en la fila */
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;         /* Regular */
                font-size: 16px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                text-align: center !important;
                color: #FFFFFF !important;
            }
            .metod-step-title {
                grid-column: 2 !important;
                grid-row: 1 !important;
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;         /* Regular (antes medium) */
                font-size: 16px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
            }
            .metod-step-desc {
                grid-column: 2 !important;
                grid-row: 2 !important;
                padding-left: 0 !important;          /* ya alineado bajo el título (col 2) */
                margin-top: 4px !important;          /* (no en spec) separación título↔descripción */
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;
                font-size: 14px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                /* color gris (#aeb8bd) se mantiene según imagen objetivo */
            }
        }
    </style>
    <section id="metodologia" class="bg-black py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">

            {{-- Eyebrow --}}
            <div class="reveal flex items-center gap-3 mb-7">
                <span class="h-px w-12 bg-gradient-to-r from-transparent via-[#22d3ee]/50 to-[#22d3ee]"></span>
                <span class="text-[#22d3ee] text-sm tracking-wide">Metodología</span>
            </div>

            {{-- Title --}}
            <h2 class="reveal metod-title text-white text-4xl md:text-5xl font-normal tracking-tight mb-12 lg:mb-16">
                Cómo trabajarás el caso
            </h2>

            {{-- Table I–V --}}
            <div class="reveal-stagger border border-white/20">
                @php
                    $steps = [
                        ['n' => 'I',   't' => 'Evolución clínica',        'd' => 'Accedes a cada episodio con los datos relevantes del paciente.'],
                        ['n' => 'II',  't' => 'Toma de decisiones',       'd' => 'Seleccionas la opción que consideras más adecuada en cada escenario.'],
                        ['n' => 'III', 't' => 'Validación experta',       'd' => 'Contrastas tu decisión con el análisis en vídeo de especialistas.'],
                        ['n' => 'IV',  't' => 'Recursos complementarios', 'd' => 'Consultas materiales descargables y contenidos de apoyo actualizados.'],
                        ['n' => 'V',   't' => 'Cierre',                   'd' => 'El avance en el caso depende de tus decisiones y de la validación de los aspectos clave del manejo clínico.'],
                    ];
                @endphp

                @foreach ($steps as $i => $s)
                    <div class="metod-row grid grid-cols-[44px_1fr] lg:grid-cols-[96px_1fr_1.15fr] items-start lg:items-center
                                px-2 lg:px-6 py-6 lg:py-7 {{ $i < count($steps) - 1 ? 'border-b border-white/20' : '' }}">
                        <div class="metod-num text-white/90 text-lg lg:text-xl text-center">{{ $s['n'] }}</div>
                        <div class="metod-step-title text-white text-lg lg:text-xl font-medium">{{ $s['t'] }}</div>
                        <div class="metod-step-desc col-span-2 lg:col-span-1 mt-2 lg:mt-0 pl-[44px] lg:pl-0 lg:pr-8
                                    text-[#aeb8bd] text-sm lg:text-[1.02rem] leading-relaxed">
                            {{ $s['d'] }}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── Section: Qué decisiones podrás mejorar ─────────────────── --}}
    <style>
        /* Chulito verde por defecto (desktop, aún sin Figma); blanco en móvil (spec) */
        .dec-check path { stroke: #6fb33f; }
        @media (max-width: 767px) {
            /* Frame de la sección (spec Figma): 390×668 · padding 64/16 · fondo teal+overlay */
            #decisiones .max-w-7xl {
                padding-left: 16px; padding-right: 16px;
                padding-top: 64px; padding-bottom: 64px;
            }
            /* Fondo CLARO (como el original): textura visible + tinte teal sutil.
               El negro 50% apagaba todo → quitado. Solo tinte teal ligero. PERILLAS abajo. */
            #decisiones .dec-bg-texture {
                background-color: transparent;
                background-blend-mode: normal;
            }
            #decisiones .dec-bg-overlay {
                background: linear-gradient(rgba(0,64,82,0.18), rgba(0,64,82,0.18)) !important;  /* tinte teal 18% (provisional) */
            }
            /* Título — Montserrat SemiBold 26 / 130% / ls0 / 358×68 (2 líneas) */
            .dec-title {
                font-family: 'Montserrat', sans-serif;
                font-weight: 600;
                font-size: 26px;
                line-height: 130%;
                letter-spacing: 0;
                color: #FFFFFF;
                width: 358px;
                max-width: 100%;
                margin-bottom: 8px;          /* gap título↔subtítulo (frame 668) */
            }
            /* Subtítulo — Montserrat Regular 14 / 150% / ls0 / 358×63 (3 líneas) */
            .dec-subtitle {
                font-family: 'Montserrat', sans-serif;
                font-weight: 400;
                font-size: 14px;
                line-height: 150%;
                letter-spacing: 0;
                color: #FFFFFF;
                width: 358px;
                max-width: 100%;
                margin-bottom: 32px;         /* gap subtítulo↔tarjetas (frame 668) */
            }
            /* Contenedor (spec Figma): 358 · gap 8 · borde 1px #BFBFBF4D (inner) · padding 1px.
               Borde como box-shadow inset → no suma al layout (igual que el inner-align de Figma)
               → tarjetas miden 356 (=358−2 padding) y el alto da 369 exacto. */
            #decisiones .reveal-stagger {
                gap: 8px !important;
                box-shadow: inset 0 0 0 1px rgba(191,191,191,0.30);   /* #BFBFBF4D */
                border: none !important;
                padding: 1px !important;
                border-radius: 5px;
            }
            /* Tarjeta glass (spec Figma): fill #FFFFFF 40% · background blur 40 · borde 0.5px #FFFFFF (inner)
               · radius 4 · padding 8/12 · gap 8 · width 356 · alto 2-líneas 58.
               356 − 24 padding − 18 check − 8 gap = 306 texto exacto. */
            .dec-card {
                gap: 8px !important;
                padding: 8px 12px !important;
                border-radius: 4px !important;
                background: rgba(255,255,255,0.40) !important;        /* #FFFFFF 40% — frosted blanco */
                -webkit-backdrop-filter: blur(40px) !important;
                backdrop-filter: blur(40px) !important;               /* background blur 40 */
                border: none !important;
                box-shadow: inset 0 0 0 0.5px #FFFFFF;                 /* borde 0.5px blanco (inner) */
            }
            .dec-check path { stroke: #FFFFFF; }   /* chulito blanco (spec) */
            .dec-card-text {
                flex: 1 1 auto;
                min-width: 0;
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;       /* Regular */
                font-size: 14px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
            }
        }
    </style>
    <section id="decisiones" class="relative overflow-hidden">
        {{-- Background cell texture (placeholder = intermediate texture; swap with section-specific export) --}}
        <div class="dec-bg-texture absolute inset-0 bg-cover bg-center"
             style="background-image:url('{{ asset('images/fondo_decisiones.png') }}'), url('{{ asset('images/fondo_hero_intermedio.png') }}');"></div>
        {{-- Legibility overlay: darker top-left (title), lighter toward texture --}}
        <div class="dec-bg-overlay absolute inset-0"
             style="background:linear-gradient(125deg, rgba(18,28,38,.66) 0%, rgba(18,28,38,.34) 45%, rgba(18,28,38,.18) 100%);"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-20">
            <h2 class="reveal dec-title text-white text-4xl md:text-5xl font-normal tracking-tight mb-4"
                style="text-shadow:0 2px 14px rgba(0,0,0,.4);">
                Qué decisiones podrás mejorar
            </h2>
            <p class="reveal dec-subtitle text-white/90 text-base lg:text-lg max-w-2xl mb-10 leading-relaxed"
               style="text-shadow:0 1px 10px rgba(0,0,0,.35);">
                El curso se organiza en tres bloques con un recorrido progresivo, desde la base
                clínica de la Lp(a) hasta la actualización en terapias dirigidas.
            </p>

            {{-- Orden = lectura por filas del desktop (col-izq, col-der) → coincide con móvil --}}
            @php
                $decisiones = [
                    'Identificar cuándo medir Lp(a) en práctica real',
                    'Interpretar resultados (mg/dL vs. nmol/L) en contexto clínico',
                    'Reconocer riesgo cardiovascular residual no explicado',
                    'Ajustar el manejo en pacientes con eventos recurrentes',
                    'Integrar la Lp(a) en la estratificación del riesgo',
                    'Anticipar el impacto de terapias dirigidas',
                ];
            @endphp
            <div class="reveal-stagger grid grid-cols-1 lg:grid-cols-2 gap-3.5">
                @foreach ($decisiones as $d)
                    <div class="dec-card flex items-center gap-3 rounded-lg border border-white/25
                                bg-gradient-to-r from-white/[0.13] to-white/[0.03] backdrop-blur-sm
                                px-5 py-4">
                        {{-- Chulito: glyph 9.37×7.87 @ (left 4.7, top 5.06) en frame 18×18 · blanco en móvil --}}
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" class="dec-check shrink-0">
                            <path d="M4.7 9.4 L7.6 12.93 L14.07 5.06" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="dec-card-text text-white text-[0.98rem] lg:text-base font-medium">{{ $d }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Section: Contenidos formativos ─────────────────────────── --}}
    <style>
        @media (max-width: 767px) {
            #contenidos .cont-band-inner {
                padding-left: 16px; padding-right: 16px;
            }
            /* Línea eyebrow (Figma "Vector 5"): 64×0 · borde 0.5px #FFFFFF */
            #contenidos .cont-eyebrow-line {
                width: 64px !important;
                height: 0 !important;
                border-top: 0.5px solid #FFFFFF;
                background: none !important;
            }
            /* Texto eyebrow "Contenidos": Montserrat Medium 12 / 150% / ls 2% / blanco */
            .cont-eyebrow-text {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 500 !important;
                font-size: 12px !important;
                line-height: 150% !important;
                letter-spacing: 0.02em !important;   /* 2% */
                color: #FFFFFF !important;
            }
            /* Título "Contenidos formativos": Montserrat Medium 38 / 130% / ls 0 / 358×98 (2 líneas) */
            .cont-title {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 500 !important;          /* Medium */
                font-size: 38px !important;
                line-height: 130% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
                width: 358px;
                max-width: 100%;
            }
            /* Copete: Montserrat Medium 16 / 150% / ls 2% / 358×48 (2 líneas) */
            .cont-copete {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 500 !important;
                font-size: 16px !important;
                line-height: 150% !important;
                letter-spacing: 0.02em !important;   /* 2% */
                color: #FFFFFF !important;
                width: 358px;
                max-width: 100%;
            }

            /* ── Cards de Módulos (spec Figma): full-width 390 · padding 48/16 · gap 32
               · borde izq 1px · sombra 0 4 4 #000 10% · gradiente radial pale-blue/blanco ── */
            #contenidos .contenidos-cards { background: none !important; }
            .cont-mod-card {
                min-height: 0 !important;
                padding: 48px 16px !important;
                gap: 8px !important;          /* interno título↔desc (el 32 era entre cards) → Hug 177 */
                justify-content: flex-start !important;
                border: none !important;
                border-left: 1px solid #82E1FC !important;   /* acento (color del borde no fijado en spec) */
                box-shadow: 0 4px 4px rgba(0,0,0,0.10);
                /* gradiente radial — blanco al CENTRO → pale-blue a los bordes (stops aprox; falta CSS exacto) */
                background: radial-gradient(ellipse 100% 100% at 50% 50%, #FFFFFF 0%, #F4F8F9 50%, #B2CED9 100%) !important;
            }
            /* Título "Módulo X": Montserrat SemiBold 22 / 140% / ls0 / #2F728C */
            .cont-mod-title {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 600 !important;
                font-size: 22px !important;
                line-height: 140% !important;
                letter-spacing: 0 !important;
                color: #2F728C !important;
                margin-bottom: 0 !important;   /* el gap 32 controla la separación */
            }
            /* Descripción: Montserrat Regular 14 / 150% / ls0 / #575757 / w358 */
            .cont-mod-desc {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;
                font-size: 14px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                color: #575757 !important;
                max-width: 358px !important;
            }
        }
    </style>
    <section id="contenidos" class="relative">
        {{-- Dark heading band --}}
        <div class="contenidos-band">
            <div class="cont-band-inner max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-20">
                <div class="reveal flex items-center gap-3 mb-7">
                    <span class="cont-eyebrow-line h-px w-12 bg-gradient-to-r from-transparent to-white/50"></span>
                    <span class="cont-eyebrow-text text-slate-300 text-sm tracking-wide">Contenidos</span>
                </div>
                <h2 class="reveal cont-title text-white text-4xl md:text-5xl font-normal tracking-tight mb-4">
                    Contenidos formativos
                </h2>
                <p class="reveal cont-copete text-slate-200/90 text-base lg:text-lg max-w-md">
                    Mantén una visión completa de la evolución clínica del paciente.
                </p>
            </div>
        </div>

        {{-- 3 module cards --}}
        @php
            $modules = [
                ['title' => 'Módulo 1', 'desc' => 'Lp(a): una lipoproteína única y distinta, heredada y conductora causal de enfermedad cardiovascular'],
                ['title' => 'Módulo 2', 'desc' => 'Manejo de pacientes con enfermedad cardiovascular y elevada Lp(a)'],
                ['title' => 'Módulo 3', 'desc' => 'Terapias dirigidas a la Lp(a): panorama actual de su desarrollo'],
            ];
        @endphp
        <div class="reveal-stagger contenidos-cards grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-white/40">
            @foreach ($modules as $mod)
                <div class="cont-mod-card min-h-[280px] lg:min-h-[340px] flex flex-col justify-end p-8 lg:p-10">
                    <h3 class="cont-mod-title text-[#2e6f80] text-2xl lg:text-[1.6rem] font-bold mb-3.5">{{ $mod['title'] }}</h3>
                    <p class="cont-mod-desc text-[#45545b] text-[0.98rem] lg:text-base leading-relaxed max-w-xs">{{ $mod['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ── Section: Comité científico ─────────────────────────────── --}}
    <style>
        @media (max-width: 767px) {
            /* Frame (spec Figma): 390 · padding 64/16 · bg #000000 */
            #comite { padding-top: 64px !important; padding-bottom: 64px !important; }
            #comite .comite-inner { padding-left: 16px; padding-right: 16px; }
            #comite .comite-eyebrow { margin-bottom: 8px !important; }  /* eyebrow↔título (provisional) */
            /* Línea eyebrow (Figma "Vector 5"): 32×0 · borde 0.5px #FFFFFF */
            #comite .comite-eyebrow-line {
                width: 32px !important;
                height: 0 !important;
                border-top: 0.5px solid #FFFFFF;
                background: none !important;
            }
            /* Texto eyebrow "Comité científico": Montserrat Medium 12 / 150% / ls 2% / blanco */
            .comite-eyebrow-text {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 500 !important;
                font-size: 12px !important;
                line-height: 150% !important;
                letter-spacing: 0.02em !important;   /* 2% */
                color: #FFFFFF !important;
            }
            /* Título "Comité científico": Montserrat SemiBold 26 / 130% / ls 0 / 358×34 (1 línea) */
            .comite-title {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 600 !important;          /* SemiBold */
                font-size: 26px !important;
                line-height: 130% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
                width: 358px;
                max-width: 100%;
            }

            /* ── Cards de miembros (spec Figma): 358 × 209 fijo · borde 1px #FFFFFF40 · padding 24/16 · gap 12 ── */
            /* Tabla de 1 columna: borde exterior + divisores 1px (filas pegadas, sin gaps) */
            #comite .comite-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 0 !important;
                border: 1px solid rgba(255,255,255,0.40) !important;   /* borde exterior tabla */
                border-radius: 0 !important;
                overflow: hidden !important;
                margin-top: 0 !important;
            }
            .comite-card {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;              /* hug (spec decía 209 fijo — confirmar) */
                min-height: 0 !important;
                padding: 24px 16px !important;
                border: none !important;
                border-bottom: 1px solid rgba(255,255,255,0.40) !important;   /* divisor entre filas */
                border-radius: 0 !important;
                /* fila más clara (gris glass) — nivel provisional, ajustable */
                background: linear-gradient(180deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.09) 100%) !important;
                margin: 0 !important;
            }
            #comite .comite-card:last-child { border-bottom: none !important; }
            .comite-card-inner {
                height: auto;
                display: flex;
                flex-direction: column;
                gap: 8px;                             /* reducido: menos espacio fila-icono ↔ nombre */
            }
            /* Fila superior: círculo del icono + caja del label, SEPARADOS (NO una sola pastilla) */
            .comite-card-top {
                align-self: flex-start;
                display: inline-flex;
                align-items: center;
                gap: 8px;                 /* separación círculo ↔ caja */
            }
            /* Círculo del icono (elemento aparte) */
            .comite-icon {
                width: 36px; height: 36px;
                border-radius: 999px;
                border: 1px solid rgba(255,255,255,0.40);
                display: inline-flex; align-items: center; justify-content: center;
                flex-shrink: 0;
                color: #FFFFFF;
            }
            .comite-icon svg { width: 18px !important; height: 18px !important; color: #FFFFFF !important; }
            /* Caja del label: rectángulo redondeado APARTE con "coordinador y autor"/"Autor" */
            .comite-label {
                display: inline-flex !important;
                align-items: center !important;
                padding: 6px 12px !important;
                border: 1px solid rgba(255,255,255,0.40) !important;
                border-radius: 8px !important;
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;
                font-size: 14px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
                white-space: nowrap !important;
            }
            /* Nombre: Montserrat SemiBold 22 / 140% / ls0 / blanco */
            .comite-name {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 600 !important;
                font-size: 22px !important;
                line-height: 140% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
                margin-bottom: 4px !important;
            }
            /* Hospital: Montserrat Regular 14 / 150% / ls0 / #FFFFFF 40% */
            .comite-org {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;
                font-size: 14px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                color: rgba(255,255,255,0.40) !important;
            }
        }
    </style>
    <section id="comite" class="bg-black py-20 lg:py-28">
        <div class="comite-inner max-w-7xl mx-auto px-6 lg:px-12">

            {{-- Eyebrow --}}
            <div class="comite-eyebrow reveal flex items-center gap-3 mb-7">
                <span class="comite-eyebrow-line h-px w-12 bg-gradient-to-r from-transparent to-white/50"></span>
                <span class="comite-eyebrow-text text-slate-300 text-sm tracking-wide">Comité científico</span>
            </div>

            {{-- Title + subtitle --}}
            <h2 class="reveal comite-title text-white text-4xl md:text-5xl font-normal tracking-tight mb-4">
                Comité científico
            </h2>
            <p class="reveal text-slate-200/90 text-base lg:text-lg mb-12 lg:mb-16">
                Dirección y contenido avalados por especialistas en riesgo cardiovascular
            </p>

            {{-- Members grid --}}
            @php
                $members = [
                    ['name' => 'Dra. Almudena Castro Conde',        'org' => 'Hospital Universitario La Paz, Madrid',                'role' => 'coordinador y autor'],
                    ['name' => 'Dr. David Crémer Luengos',          'org' => 'Hospital Universitario Son Llàtzer, Palma de Mallorca', 'role' => 'coordinador y autor'],
                    ['name' => 'Dr. Abel García del Egido',         'org' => 'Complejo Asistencial Universitario de León',           'role' => 'coordinador y autor'],
                    ['name' => 'Dr. José Luis Zamorano Gómez',      'org' => 'Hospital Universitario Ramón y Cajal, Madrid',         'role' => 'Autor'],
                    ['name' => 'Dr. José López Miranda',            'org' => 'Hospital Universitario Reina Sofía, Córdoba',          'role' => 'Autor'],
                    ['name' => 'Dr. José Ramón González Juanatey',  'org' => 'Universidad de Santiago de Compostela',                'role' => 'Autor'],
                ];
            @endphp

            <div class="reveal-stagger comite-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-white/15">
                @foreach ($members as $m)
                    <div class="comite-card group relative border-r border-b border-white/15 p-7 lg:p-8 min-h-[200px] cursor-pointer
                                overflow-hidden transition-colors duration-300 hover:bg-[#22d3ee]/[0.035]">

                        {{-- Hover radial glow --}}
                        <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                             style="background:radial-gradient(circle at 28% 0%, rgba(34,211,238,.10), transparent 65%);"></div>
                        {{-- Hover inset highlight border --}}
                        <div class="pointer-events-none absolute inset-0 ring-1 ring-inset ring-[#22d3ee]/0 group-hover:ring-[#22d3ee]/50 transition-all duration-300"></div>

                        <div class="comite-card-inner relative">
                            {{-- Icon + role pill --}}
                            <div class="comite-card-top">
                                <span class="comite-icon">
                                    <svg class="w-5 h-5 text-white/70 group-hover:text-[#22d3ee] transition-colors duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6 6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.3.3 0 1 0 .2.3"/>
                                        <path d="M8 15v1a6 6 0 0 0 12 0v-4"/>
                                        <circle cx="20" cy="10" r="2"/>
                                    </svg>
                                </span>
                                <span class="comite-label">{{ $m['role'] }}</span>
                            </div>

                            <div class="comite-card-text">
                                <h3 class="comite-name text-white text-lg lg:text-xl font-bold leading-tight mb-2.5 group-hover:text-white">
                                    {{ $m['name'] }}
                                </h3>
                                <p class="comite-org text-slate-400 text-sm lg:text-[0.95rem] leading-relaxed group-hover:text-slate-300 transition-colors duration-300">
                                    {{ $m['org'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── Footer ──────────────────────────────────────────────────── --}}
    {{-- Frame Figma: 390 · padding 32/16 · gap 32 · bg #000000 · Hug 463 --}}
    <style>
        .ft-caption { font-family:'Montserrat',sans-serif; font-weight:400; font-size:14px; line-height:150%; color:rgba(255,255,255,0.70); text-align:center; }
        .ft-partner { display:flex; align-items:center; gap:5px; }
        .ft-qualimed { font-family:'Montserrat',sans-serif; font-weight:400; font-size:14px; color:#fff; display:inline-flex; align-items:center; gap:4px; }
        .ft-bottom { display:flex; flex-direction:column; align-items:center; gap:14px; width:100%; }
        .ft-divider { width:358px; max-width:100%; height:0; border-top:0.5px solid #FFFFFF; }
        .ft-legal { font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; line-height:150%; letter-spacing:0.01em; color:#FFFFFF; text-align:center; width:358px; max-width:100%; margin:20px 0 0; }
        .ft-separator { width:358px; max-width:100%; height:0; border-top:0.5px solid rgba(255,255,255,0.40); }
        .ft-links { display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:0 6px; }
        .ft-link { font-family:'Montserrat',sans-serif; font-weight:400; font-size:12px; line-height:150%; color:rgba(255,255,255,0.70); text-decoration:none; padding:16px 2px; }
        .ft-link:hover { color:#fff; }
    </style>
    <footer style="background:#000; padding:32px 16px; display:flex; flex-direction:column; align-items:center; gap:32px;">
        {{-- Novartis + Patrocinado por --}}
        <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
            <img src="{{ asset('images/g14.png') }}" alt="Novartis" style="height:26px; width:auto;"
                 onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='block';">
            <span style="display:none;color:#fff;font-family:'Montserrat',sans-serif;font-size:22px;font-weight:700;letter-spacing:.08em;">NOVARTIS</span>
            <span class="ft-caption">Patrocinado por</span>
        </div>
        {{-- Lp(a)ction + Partner formativo --}}
        <div style="display:flex; flex-direction:column; align-items:center; gap:14px;">
            <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" style="height:34px; width:auto;"
                 onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='inline-block';">
            <span style="display:none;font-family:'Montserrat',sans-serif;font-size:26px;font-weight:700;color:#fff;">Lp<span style="color:#05BAEE;">(a)</span>ction</span>
            <div class="ft-partner">
                <span class="ft-caption">Partner formativo</span>
                <span class="ft-qualimed"><img src="{{ asset('images/Group.png') }}" alt="Qualimed" style="width:16.83px;height:16.74px;object-fit:contain;display:inline-block;">Qualimed</span>
            </div>
        </div>
        {{-- Bloque inferior: divisor + legal + separador + links --}}
        <div class="ft-bottom">
            <div class="ft-divider"></div>
            <p class="ft-legal">El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. {{ date('Y') }} © Qualimed Ediciones S.L.</p>
            <div class="ft-separator"></div>
            <div class="ft-links">
                <a href="#" class="ft-link">Aviso legal</a>
                <a href="#" class="ft-link">Política de privacidad</a>
                <a href="#" class="ft-link">Política de cookies</a>
            </div>
        </div>
    </footer>

    {{-- ── Escala uniforme de la sección Juan (laptop) ───────────────── --}}
    <script>
        (function () {
            function scaleCaso() {
                var outer = document.querySelector('.caso-scale-outer');
                var inner = document.querySelector('.caso-scale-inner');
                if (!outer || !inner) return;
                if (window.innerWidth < 1024) {
                    inner.style.transform = '';
                    outer.style.height = '';
                    return;
                }
                var s = Math.min(1, window.innerWidth / 1440);
                inner.style.transform = 'scale(' + s + ')';
                outer.style.height = (inner.offsetHeight * s) + 'px';
            }
            window.addEventListener('resize', scaleCaso);
            window.addEventListener('load', scaleCaso);
            if (document.readyState !== 'loading') scaleCaso();
            else document.addEventListener('DOMContentLoaded', scaleCaso);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleCaso);
        })();
    </script>

    {{-- ── Reveal-on-scroll observer ──────────────────────────────── --}}
    <script>
        (function () {
            var els = document.querySelectorAll('.reveal, .reveal-stagger');
            if (!('IntersectionObserver' in window)) {
                els.forEach(function (el) { el.classList.add('is-visible'); });
                return;
            }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) {
                        e.target.classList.add('is-visible');
                        io.unobserve(e.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
            els.forEach(function (el) { io.observe(el); });
        })();
    </script>

    {{-- Botón flotante scroll-to-top (solo móvil, aparece al bajar) --}}
    <style>
        #scroll-fab {
            display: none;
            position: fixed;
            bottom: 28px;
            right: 16px;
            z-index: 8000;
            width: 68px;
            height: 68px;
            border-radius: 4px;
            padding: 16px;
            cursor: pointer;
            background: rgba(255,255,255,0.40);
            border: none;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }
        #scroll-fab::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 4px;
            padding: 1px;
            background: radial-gradient(81.28% 782.58% at 18.72% 50%, #05BAEE 0%, #2F728C 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            pointer-events: none;
        }
    </style>
    <button id="scroll-fab" aria-label="Volver arriba" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#05BAEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>
    <script>
        (function () {
            var fab = document.getElementById('scroll-fab');
            if (!fab) return;
            function onScroll() {
                var show = window.innerWidth < 1024 && window.scrollY > 300;
                fab.style.display = show ? 'flex' : 'none';
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll);
        })();
    </script>

</body>
</html>
