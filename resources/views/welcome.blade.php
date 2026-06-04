<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            .hero { --u: min(calc(100vw / 480), calc((100vh - 4rem) / 700)); }
            .hero-title-2 { white-space: normal; }
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
                {{-- Mobile menu --}}
                <button class="lg:hidden text-white" aria-label="Menú">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
        </div>
    </header>

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
                        El tratamiento parece <em class="italic">correcto.</em> La evolución, <em class="italic">no.</em>
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

        {{-- Banda 1440×160 (padding 48/78). Texto: border-left 1px #FFF · padding 8/16 · height 64 (hug) --}}
        <div class="relative mx-auto px-6 flex items-center" style="max-width:1332px; min-height:160px;">
            <div class="reveal w-full" style="border-left:1px solid #FFFFFF; padding:8px 16px;">
                <p style="font-family:'Montserrat',sans-serif; font-weight:600; font-size:16px; line-height:150%; letter-spacing:0; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,.35);">
                    Este curso online acreditado te sitúa ante el recorrido clínico de Juan para identificar cuándo la Lp(a) cambia la interpretación del riesgo residual, la recurrencia de eventos y la progresión valvular.
                </p>
            </div>
        </div>
    </section>

    {{-- ── Section: No es un caso teórico ─────────────────────────── --}}
    <section id="caso" class="band-caso relative overflow-hidden">
        {{-- Globos blancos: 543×308 · white · opacity .5 · blur(400px) [Figma] --}}
        <div class="caso-blob" style="left:3%; bottom:2%;"></div>
        <div class="caso-blob" style="right:7%; top:4%;"></div>

        <div class="caso-scale-outer">
        <div class="caso-scale-inner">
        <div class="relative px-6 lg:px-10 py-16 lg:py-20">
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-12 items-center">

                {{-- Left: text (fixed width on laptop) --}}
                <div class="reveal-stagger order-2 lg:order-1 caso-text">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px w-10" style="background:#05BAEE;"></span>
                        <span style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:12px; line-height:150%; letter-spacing:0.02em; color:#05BAEE;">Caso clínico</span>
                    </div>

                    <h2 class="mb-7" style="font-family:'Montserrat',sans-serif; font-weight:600; font-size:24px; line-height:130%; letter-spacing:0;">
                        <span class="block" style="color:#FFFFFF;">No es un caso teórico.</span>
                        <span class="block" style="color:#05BAEE;">Es un paciente que vuelve.</span>
                    </h2>

                    <p class="mb-6" style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:18px; line-height:175%; letter-spacing:0.02em; color:rgba(203,213,225,0.9);">
                        A lo largo de tres ingresos hospitalarios, seguirás la evolución de Juan
                        en distintos momentos clave de su trayectoria cardiovascular.
                    </p>
                    <p style="font-family:'Montserrat',sans-serif; font-weight:500; font-size:18px; line-height:175%; letter-spacing:0.02em; color:rgba(203,213,225,0.9);">
                        En cada fase tendrás que valorar si la información disponible revela un riesgo
                        no completamente explicado por los factores clásicos y si la determinación de
                        Lp(a) puede cambiar la interpretación del caso y el manejo posterior.
                    </p>
                </div>

                {{-- Right: Juan + data card --}}
                <div class="reveal order-1 lg:order-2 w-full lg:flex-1 relative min-h-[500px] flex flex-col lg:block items-center justify-center">

                    {{-- Concentric ripple rings at Juan's feet --}}
                    <svg class="hidden lg:block absolute left-[33%] bottom-[6%] -translate-x-1/2 w-[480px] h-[160px] opacity-60 pointer-events-none" viewBox="0 0 480 160" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 5; $r++)
                            <ellipse cx="240" cy="145" rx="{{ $r * 46 }}" ry="{{ $r * 14 }}"
                                     stroke="#84b0bd" stroke-width="1" opacity="{{ 0.5 - $r * 0.08 }}"/>
                        @endfor
                    </svg>

                    {{-- Juan figure --}}
                    <div class="relative z-10 flex justify-center lg:justify-start lg:pl-[4%]">
                        <div class="relative">
                            <img src="{{ asset('images/juan.png') }}" alt="Juan, paciente del caso clínico"
                                 class="h-[340px] md:h-[460px] lg:h-[520px] w-auto object-contain">
                            <span class="absolute" style="left:calc(50% + 26px); transform:translateX(-50%); bottom:18px; color:#05BAEE; font-family:'Montserrat',sans-serif; font-weight:500; font-size:38px; line-height:130%; letter-spacing:0;">Juan</span>
                        </div>
                    </div>

                    {{-- Data card: 297px · gap 1px [Figma] · anclada al final de "Juan" --}}
                    <div class="relative caso-card z-20 mx-auto lg:mx-0 mt-6 lg:mt-0 overflow-hidden"
                         style="width:297px; display:flex; flex-direction:column; gap:1px; border-radius:12px; background:rgba(0,0,0,0.18); -webkit-backdrop-filter:blur(16px); backdrop-filter:blur(16px);">
                        {{-- Edad --}}
                        <div class="flex items-center justify-between card-row" style="background:rgba(255,255,255,0.08);">
                            <span class="flex items-center gap-3 text-slate-300 card-txt">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2.5" y="6" width="19" height="13" rx="2"/><path d="M7 6V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/></svg>
                                Edad
                            </span>
                            <span class="text-white card-txt">52</span>
                        </div>
                        {{-- Peso --}}
                        <div class="flex items-center justify-between card-row" style="background:rgba(255,255,255,0.08);">
                            <span class="flex items-center gap-3 text-slate-300 card-txt">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="17" rx="3"/><path d="M9.5 9a2.5 2.5 0 0 1 5 0"/><path d="M12 9l1.5-1.5"/></svg>
                                Peso
                            </span>
                            <span class="text-white card-txt">82 kg</span>
                        </div>
                        {{-- Índice paquetes-año --}}
                        <div class="flex items-center justify-between card-row" style="background:rgba(255,255,255,0.08);">
                            <span class="flex items-center gap-3 text-slate-300 card-txt">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="11" width="15" height="5" rx="1"/><path d="M13 11v5M6 11v5"/><path d="M20 5.5c1 .6 1 1.6.6 2.4M17 4.5c1.2.7 1.2 2 .7 3"/><path d="M19 11v5h3v-5z"/></svg>
                                Índice paquetes-año
                            </span>
                            <span class="text-white card-txt">42</span>
                        </div>
                        {{-- Estilo de vida --}}
                        <div class="card-row" style="background:rgba(255,255,255,0.08);">
                            <span class="flex items-center gap-3 text-slate-300 card-txt mb-2.5">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.5 8.5c0-2.2-1.8-4-4-4-1.6 0-3 .9-3.7 2.3C12.1 5.4 10.7 4.5 9 4.5c-2.2 0-4 1.8-4 4 0 4.5 7.5 9 7.5 9s8-4.5 8-9Z"/></svg>
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
    <section id="metodologia" class="bg-black py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">

            {{-- Eyebrow --}}
            <div class="reveal flex items-center gap-3 mb-7">
                <span class="h-px w-12 bg-gradient-to-r from-transparent via-[#22d3ee]/50 to-[#22d3ee]"></span>
                <span class="text-[#22d3ee] text-sm tracking-wide">Metodología</span>
            </div>

            {{-- Title --}}
            <h2 class="reveal text-white text-4xl md:text-5xl font-normal tracking-tight mb-12 lg:mb-16">
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
                    <div class="grid grid-cols-[44px_1fr] lg:grid-cols-[96px_1fr_1.15fr] items-start lg:items-center
                                px-2 lg:px-6 py-6 lg:py-7 {{ $i < count($steps) - 1 ? 'border-b border-white/20' : '' }}">
                        <div class="text-white/90 text-lg lg:text-xl text-center">{{ $s['n'] }}</div>
                        <div class="text-white text-lg lg:text-xl font-medium">{{ $s['t'] }}</div>
                        <div class="col-span-2 lg:col-span-1 mt-2 lg:mt-0 pl-[44px] lg:pl-0 lg:pr-8
                                    text-[#aeb8bd] text-sm lg:text-[1.02rem] leading-relaxed">
                            {{ $s['d'] }}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── Section: Qué decisiones podrás mejorar ─────────────────── --}}
    <section id="decisiones" class="relative overflow-hidden">
        {{-- Background cell texture (placeholder = intermediate texture; swap with section-specific export) --}}
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image:url('{{ asset('images/fondo_decisiones.png') }}'), url('{{ asset('images/fondo_hero_intermedio.png') }}');"></div>
        {{-- Legibility overlay: darker top-left (title), lighter toward texture --}}
        <div class="absolute inset-0"
             style="background:linear-gradient(125deg, rgba(18,28,38,.66) 0%, rgba(18,28,38,.34) 45%, rgba(18,28,38,.18) 100%);"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-20">
            <h2 class="reveal text-white text-4xl md:text-5xl font-normal tracking-tight mb-4"
                style="text-shadow:0 2px 14px rgba(0,0,0,.4);">
                Qué decisiones podrás mejorar
            </h2>
            <p class="reveal text-white/90 text-base lg:text-lg max-w-2xl mb-10 leading-relaxed"
               style="text-shadow:0 1px 10px rgba(0,0,0,.35);">
                El curso se organiza en tres bloques con un recorrido progresivo, desde la base
                clínica de la Lp(a) hasta la actualización en terapias dirigidas.
            </p>

            @php
                $decisiones = [
                    'Identificar cuándo medir Lp(a) en práctica real',
                    'Reconocer riesgo cardiovascular residual no explicado',
                    'Integrar la Lp(a) en la estratificación del riesgo',
                    'Interpretar resultados (mg/dL vs. nmol/L) en contexto clínico',
                    'Ajustar el manejo en pacientes con eventos recurrentes',
                    'Anticipar el impacto de terapias dirigidas',
                ];
            @endphp
            <div class="reveal-stagger grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:grid-flow-col gap-3.5">
                @foreach ($decisiones as $d)
                    <div class="flex items-center gap-3 rounded-lg border border-white/25
                                bg-gradient-to-r from-white/[0.13] to-white/[0.03] backdrop-blur-sm
                                px-5 py-4">
                        <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="#6fb33f" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 12.5l5 5L20 6"/>
                        </svg>
                        <span class="text-white text-[0.98rem] lg:text-base font-medium">{{ $d }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Section: Contenidos formativos ─────────────────────────── --}}
    <section id="contenidos" class="relative">
        {{-- Dark heading band --}}
        <div class="contenidos-band">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-20">
                <div class="reveal flex items-center gap-3 mb-7">
                    <span class="h-px w-12 bg-gradient-to-r from-transparent to-white/50"></span>
                    <span class="text-slate-300 text-sm tracking-wide">Contenidos</span>
                </div>
                <h2 class="reveal text-white text-4xl md:text-5xl font-normal tracking-tight mb-4">
                    Contenidos formativos
                </h2>
                <p class="reveal text-slate-200/90 text-base lg:text-lg max-w-md">
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
                <div class="min-h-[280px] lg:min-h-[340px] flex flex-col justify-end p-8 lg:p-10">
                    <h3 class="text-[#2e6f80] text-2xl lg:text-[1.6rem] font-bold mb-3.5">{{ $mod['title'] }}</h3>
                    <p class="text-[#45545b] text-[0.98rem] lg:text-base leading-relaxed max-w-xs">{{ $mod['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ── Section: Comité científico ─────────────────────────────── --}}
    <section id="comite" class="bg-black py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">

            {{-- Eyebrow --}}
            <div class="reveal flex items-center gap-3 mb-7">
                <span class="h-px w-12 bg-gradient-to-r from-transparent to-white/50"></span>
                <span class="text-slate-300 text-sm tracking-wide">Comité científico</span>
            </div>

            {{-- Title + subtitle --}}
            <h2 class="reveal text-white text-4xl md:text-5xl font-normal tracking-tight mb-4">
                Comité científico
            </h2>
            <p class="reveal text-slate-200/90 text-base lg:text-lg mb-12 lg:mb-16">
                Dirección y contenido avalados por especialistas en riesgo cardiovascular
            </p>

            {{-- Members grid 3×2 --}}
            @php
                $members = [
                    ['name' => 'Dra. Almudena Castro Conde',        'org' => 'Hospital Universitario La Paz, Madrid'],
                    ['name' => 'Dr. David Crémer Luengos',          'org' => 'Hospital Universitario Son Llàtzer, Palma de Mallorca'],
                    ['name' => 'Dr. Abel García del Egido',         'org' => 'Complejo Asistencial Universitario de León'],
                    ['name' => 'Dr. José Luis Zamorano Gómez',      'org' => 'Hospital Universitario Ramón y Cajal, Madrid'],
                    ['name' => 'Dr. José López Miranda',            'org' => 'Hospital Universitario Reina Sofía, Córdoba'],
                    ['name' => 'Dr. José Ramón González Juanatey',  'org' => 'Universidad de Santiago de Compostela'],
                ];
            @endphp

            <div class="reveal-stagger grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-white/15">
                @foreach ($members as $m)
                    <div class="group relative border-r border-b border-white/15 p-7 lg:p-8 min-h-[200px] cursor-pointer
                                overflow-hidden transition-colors duration-300 hover:bg-[#22d3ee]/[0.035]">

                        {{-- Hover radial glow --}}
                        <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                             style="background:radial-gradient(circle at 28% 0%, rgba(34,211,238,.10), transparent 65%);"></div>
                        {{-- Hover inset highlight border --}}
                        <div class="pointer-events-none absolute inset-0 ring-1 ring-inset ring-[#22d3ee]/0 group-hover:ring-[#22d3ee]/50 transition-all duration-300"></div>

                        <div class="relative">
                            {{-- Stethoscope icon --}}
                            <div class="w-11 h-11 rounded-full border border-white/30 group-hover:border-[#22d3ee] flex items-center justify-center mb-7 transition-colors duration-300">
                                <svg class="w-5 h-5 text-white/70 group-hover:text-[#22d3ee] transition-colors duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6 6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.3.3 0 1 0 .2.3"/>
                                    <path d="M8 15v1a6 6 0 0 0 12 0v-4"/>
                                    <circle cx="20" cy="10" r="2"/>
                                </svg>
                            </div>

                            <h3 class="text-white text-lg lg:text-xl font-bold leading-tight mb-2.5 group-hover:text-white">
                                {{ $m['name'] }}
                            </h3>
                            <p class="text-slate-400 text-sm lg:text-[0.95rem] leading-relaxed group-hover:text-slate-300 transition-colors duration-300">
                                {{ $m['org'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

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

</body>
</html>
