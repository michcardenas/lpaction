<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lp(a)ction — ¿Qué cambia en tu práctica cuando la Lp(a) está elevada?</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        html { scroll-behavior: smooth; }
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
        /* "No es un caso teórico" — exact bg #26383F + corner glows */
        .band-caso {
            background-color: #26383F;
            background-image:
                radial-gradient(ellipse 58% 48% at 50% 90%, rgba(170,200,210,.13) 0%, transparent 70%),
                radial-gradient(circle at 5% 7%,  rgba(150,188,202,.11) 0%, transparent 26%),
                radial-gradient(circle at 96% 10%, rgba(150,188,202,.08) 0%, transparent 24%),
                radial-gradient(circle at 94% 95%, rgba(150,188,202,.07) 0%, transparent 30%);
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
        .hero {
            --hero-h: calc(100vh - 4rem);
            --u: min(1.1vh, 0.78vw);
            min-height: var(--hero-h);
        }
        .hero-eyebrow      { font-size: calc(var(--u) * 1.5); }
        .hero-title-1      { font-size: calc(var(--u) * 4.4); }
        .hero-title-2      { font-size: calc(var(--u) * 4.4); }
        .hero-pad-top      { padding-top: calc(var(--u) * 4); }
        .hero-pad-bottom   { padding-bottom: calc(var(--u) * 4); }
        .hero-eyebrow-mb   { margin-bottom: calc(var(--u) * 2); }
        .hero-title-gap    { margin-top: calc(var(--u) * 0.6); }
        .hero-bar-text     { font-size: calc(var(--u) * 1.4); }
        .hero-bar-cta      { font-size: calc(var(--u) * 1.5); padding: calc(var(--u) * 1.7) calc(var(--u) * 3); }
        .hero-bar          { padding: calc(var(--u) * 2) calc(var(--u) * 3); border-radius: calc(var(--u) * 1.2); }
        .hero-mol {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: calc(var(--hero-h) * 0.30);
            bottom: calc(var(--hero-h) * 0.16);
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        .hero-mol img { height: 100%; width: auto; object-fit: contain; }
    </style>
</head>
<body class="antialiased text-neutral-900">

    {{-- Header --}}
    <header class="bg-[#0a0a0a] text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="/" class="text-2xl font-semibold tracking-tight">
                    Lp<span class="text-[#22d3ee]">(a)</span>ction
                </a>
                <nav class="hidden lg:flex items-center gap-7 text-sm text-neutral-200">
                    <a href="#caso" class="hover:text-white">Caso clínico</a>
                    <a href="#metodologia" class="hover:text-white">Metodología</a>
                    <a href="#contenidos" class="hover:text-white">Contenidos</a>
                    <a href="#comite" class="hover:text-white">Comité científico</a>
                </nav>
            </div>

            <div class="flex items-center gap-5">
                <div class="hidden md:flex items-center gap-3 text-xs text-neutral-300">
                    <span>Organizado por:</span>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center">
                            <span class="text-[10px] leading-none">SEC</span>
                        </div>
                        <span class="text-[11px] leading-tight max-w-[110px]">Sociedad Española<br>de Cardiología</span>
                    </div>
                </div>
                <a href="#acceder" class="inline-flex items-center gap-2 bg-[#22d3ee] hover:bg-[#0ea5e9] text-[#0a0a0a] font-medium text-sm px-5 py-2 rounded-md transition">
                    Acceder
                </a>
                <button class="lg:hidden text-white" aria-label="Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden hero-gradient hero">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 flex flex-col relative" style="min-height: inherit;">

            {{-- Top: eyebrow + title --}}
            <div class="text-center hero-pad-top relative z-10">
                <p class="text-[#9a3a4a] font-normal hero-eyebrow hero-eyebrow-mb">
                    ¿Qué cambia en tu práctica cuando la Lp(a) está elevada?
                </p>

                <h1 class="tracking-tight text-[#0d1117]">
                    <span class="block font-normal leading-[1.1] hero-title-1">Juan ingresa tres veces.</span>
                    <span class="block font-extrabold leading-[1.1] hero-title-gap whitespace-nowrap hero-title-2">
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

            {{-- Bottom: SEAFORMEC bar (behind the molecule's bottom edge) --}}
            <div class="hero-pad-bottom relative z-10">
                <div class="bg-white/40 backdrop-blur-sm border border-neutral-200/70 hero-bar flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-sm">
                    <p class="text-neutral-700 max-w-2xl leading-relaxed hero-bar-text">
                        Solicitada la acreditación al Sistema Español de Acreditación de la Formación Médica Continuada (SEAFORMEC).
                    </p>
                    <a href="#acceder" class="inline-flex items-center gap-3 bg-[#1ccfeb] hover:bg-[#0ea5e9] text-white font-medium rounded-lg transition whitespace-nowrap shadow-sm hero-bar-cta">
                        Accede al curso
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M7 17L17 7M17 7H8M17 7V16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Band: intro statement (real cell texture bg) ──────────── --}}
    <section class="relative overflow-hidden" style="background-color:#5E8B97;">
        {{-- Real microscopic texture --}}
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image:url('{{ asset('images/fondo_hero_intermedio.png') }}');"></div>
        {{-- Subtle left darkening for text legibility --}}
        <div class="absolute inset-0"
             style="background:linear-gradient(90deg, rgba(16,36,44,.28) 0%, rgba(16,36,44,.10) 45%, rgba(16,36,44,0) 72%);"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-10 py-12 lg:py-16">
            <div class="reveal border-l-2 pl-6 lg:pl-8 max-w-6xl" style="border-color:#5E8B97;">
                <p class="text-white text-lg md:text-xl lg:text-[1.55rem] font-semibold leading-[1.5]"
                   style="text-shadow:0 1px 8px rgba(0,0,0,.25);">
                    Este curso online acreditado te sitúa ante el recorrido clínico de Juan
                    para identificar cuándo la Lp(a) cambia la interpretación del riesgo residual,
                    la recurrencia de eventos y la progresión valvular.
                </p>
            </div>
        </div>
    </section>

    {{-- ── Section: No es un caso teórico ─────────────────────────── --}}
    <section id="caso" class="band-caso relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 py-16 lg:py-20">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-6 items-center">

                {{-- Left: text --}}
                <div class="reveal-stagger order-2 lg:order-1 lg:col-span-5">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px w-10 bg-[#3a8a9e]"></span>
                        <span class="text-[#22d3ee] text-sm tracking-wide">Caso clínico</span>
                    </div>

                    <h2 class="text-[1.75rem] md:text-3xl lg:text-[2.4rem] font-bold leading-[1.15] mb-7">
                        <span class="block text-white">No es un caso teórico.</span>
                        <span class="block text-[#22d3ee]">Es un paciente que vuelve.</span>
                    </h2>

                    <p class="text-slate-300/90 text-base lg:text-[1.05rem] leading-relaxed mb-6 max-w-md">
                        A lo largo de tres ingresos hospitalarios, seguirás la evolución de Juan
                        en distintos momentos clave de su trayectoria cardiovascular.
                    </p>
                    <p class="text-slate-300/90 text-base lg:text-[1.05rem] leading-relaxed max-w-md">
                        En cada fase tendrás que valorar si la información disponible revela un riesgo
                        no completamente explicado por los factores clásicos y si la determinación de
                        Lp(a) puede cambiar la interpretación del caso y el manejo posterior.
                    </p>
                </div>

                {{-- Right: Juan + data card --}}
                <div class="reveal order-1 lg:order-2 lg:col-span-7 relative min-h-[500px] flex flex-col lg:block items-center justify-center">

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
                            <span class="absolute bottom-3 left-1/2 -translate-x-1/2 lg:left-auto lg:right-[-1.5rem] text-[#22d3ee] text-4xl lg:text-5xl font-medium tracking-tight">Juan</span>
                        </div>
                    </div>

                    {{-- Data card --}}
                    <div class="relative lg:absolute lg:top-1/2 lg:right-0 lg:-translate-y-1/2 z-20
                                w-full max-w-[300px] mx-auto lg:mx-0 mt-6 lg:mt-0
                                rounded-xl border border-white/15 overflow-hidden bg-white/[0.03] backdrop-blur-sm shadow-2xl">
                        {{-- Edad --}}
                        <div class="flex items-center justify-between px-4 py-3.5 border-b border-white/10">
                            <span class="flex items-center gap-3 text-slate-300 text-[0.92rem]">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2.5" y="6" width="19" height="13" rx="2"/><path d="M7 6V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/></svg>
                                Edad
                            </span>
                            <span class="text-white text-[0.92rem] font-semibold">52</span>
                        </div>
                        {{-- Peso --}}
                        <div class="flex items-center justify-between px-4 py-3.5 border-b border-white/10">
                            <span class="flex items-center gap-3 text-slate-300 text-[0.92rem]">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="17" rx="3"/><path d="M9.5 9a2.5 2.5 0 0 1 5 0"/><path d="M12 9l1.5-1.5"/></svg>
                                Peso
                            </span>
                            <span class="text-white text-[0.92rem] font-semibold">82 kg</span>
                        </div>
                        {{-- Índice paquetes-año --}}
                        <div class="flex items-center justify-between px-4 py-3.5 border-b border-white/10">
                            <span class="flex items-center gap-3 text-slate-300 text-[0.92rem]">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="11" width="15" height="5" rx="1"/><path d="M13 11v5M6 11v5"/><path d="M20 5.5c1 .6 1 1.6.6 2.4M17 4.5c1.2.7 1.2 2 .7 3"/><path d="M19 11v5h3v-5z"/></svg>
                                Índice paquetes-año
                            </span>
                            <span class="text-white text-[0.92rem] font-semibold">42</span>
                        </div>
                        {{-- Estilo de vida --}}
                        <div class="px-4 py-3.5">
                            <span class="flex items-center gap-3 text-slate-300 text-[0.92rem] mb-2.5">
                                <svg class="w-[18px] h-[18px] text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.5 8.5c0-2.2-1.8-4-4-4-1.6 0-3 .9-3.7 2.3C12.1 5.4 10.7 4.5 9 4.5c-2.2 0-4 1.8-4 4 0 4.5 7.5 9 7.5 9s8-4.5 8-9Z"/></svg>
                                Estilo de vida
                            </span>
                            <span class="block text-white text-[0.92rem] font-semibold leading-snug pl-[30px]">Vida sedentaria, alto nivel de estrés</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
