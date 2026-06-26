<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        /* En celulares fijamos el viewport a 390 → el diseño móvil escala como una imagen */
        (function () {
            try {
                var mn = Math.min(screen.width, screen.height);
                if (mn && mn < 768) {
                    document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=390');
                }
            } catch (e) {}
        })();
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autores — Lp(a)ction</title>
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
        .curso-burger { display: none; }   /* solo visible en móvil */
        .curso-mobmenu { display: none; }  /* oculto por defecto (en escritorio nunca aparece); en móvil se abre con .open */

        /* ===== Página Autores ===== */
        .tut-bg {
            background:
                radial-gradient(120% 90% at 50% 0%, rgba(255,255,255,0.04) 0%, rgba(255,255,255,0) 60%),
                #26383F;
        }
        .tut-wrap { width: 100%; max-width: 1200px; margin: 0 auto; padding: 72px 48px 96px; }
        .tut-title {
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 38px;
            line-height: 130%; color: #FFFFFF; letter-spacing: 0; margin: 0;
        }
        .tut-title-underline {
            width: 120px; height: 2px; margin-top: 14px;
            background: rgba(150, 178, 188, 0.55); border-radius: 2px;
        }

        /* ===== Subtítulo del comité ===== */
        .aut-subtitle {
            font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px;
            line-height: 150%; color: rgba(255,255,255,0.75); margin-top: 14px;
        }

        /* ===== Grilla de tarjetas (tabla conectada) ===== */
        .aut-grid {
            margin-top: 40px;
            display: grid; grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid rgba(255,255,255,0.15);
            border-left: 1px solid rgba(255,255,255,0.15);
        }
        .aut-card {
            position: relative; overflow: hidden;
            min-height: 200px; padding: 32px;
            border-right: 1px solid rgba(255,255,255,0.15);
            border-bottom: 1px solid rgba(255,255,255,0.15);
            transition: background .3s ease;
        }
        /* Overlay claro al hover → la tarjeta se "ilumina" */
        .aut-card::before {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.13), rgba(255,255,255,0.06));
            opacity: 0; transition: opacity .3s ease; pointer-events: none;
        }
        .aut-card:hover::before { opacity: 1; }

        /* Fila superior: ícono (fijo a la izq.) + pastilla de rol */
        .aut-top { position: relative; display: flex; align-items: center; gap: 14px; }

        /* Ícono: círculo 42px con estetoscopio */
        .aut-icon {
            position: relative; z-index: 1; flex-shrink: 0;
            width: 42px; height: 42px; border-radius: 999px;
            display: inline-flex; align-items: center; justify-content: center;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.30);
            color: rgba(255,255,255,0.70);
            transition: background .3s ease, border-color .3s ease, color .3s ease;
        }
        .aut-card:hover .aut-icon {
            background: #FFFFFF; border-color: #FFFFFF; color: #05BAEE;
        }

        /* Pastilla de rol: oculta por defecto, aparece al hover (no desplaza el ícono) */
        .aut-pill {
            position: relative; z-index: 1;
            display: inline-flex; align-items: center;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.45);
            background: transparent;
            padding: 6px 14px;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px;
            color: #FFFFFF; white-space: nowrap;
            opacity: 0; transition: opacity .3s ease;
        }
        .aut-card:hover .aut-pill { opacity: 1; }

        /* Texto: nombre + organización */
        .aut-text { position: relative; z-index: 1; margin-top: 24px; }
        .aut-name {
            font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 21px;
            line-height: 1.25; color: #FFFFFF; margin: 0;
        }
        .aut-org {
            font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px;
            line-height: 1.5; color: rgba(255,255,255,0.55); margin: 8px 0 0;
            transition: color .3s ease;
        }
        .aut-card:hover .aut-org { color: rgba(255,255,255,0.72); }

        /* ===== Footer simple (línea legal + enlaces) — como el Figma ===== */
        .tut-footer { background: #000; }
        .tut-footer-inner { max-width: 1200px; margin: 0 auto; padding: 22px 48px; display: flex; align-items: center; justify-content: space-between; gap: 16px 32px; flex-wrap: wrap; }
        .tut-footer-legal { font-family:'Montserrat',sans-serif; font-weight:400; font-size:12px; line-height:150%; color: rgba(255,255,255,0.62); margin: 0; }
        .tut-footer-links { display: flex; align-items: center; gap: 24px; flex-shrink: 0; }
        .tut-footer-link { font-family:'Montserrat',sans-serif; font-weight:400; font-size:12px; color: rgba(255,255,255,0.82); text-decoration: none; transition: color .2s; white-space: nowrap; }
        .tut-footer-link:hover { color: #fff; }

        /* ===== Dropdown "Perfil" ===== */
        .perfil-menu { position: relative; }
        .perfil-btn.open { color: #05BAEE; }
        .perfil-btn svg { transition: transform .2s ease; }
        .perfil-btn.open svg { transform: rotate(180deg); }
        .perfil-dd {
            position: absolute; top: calc(100% + 10px); left: 0; z-index: 60;
            min-width: 190px; padding: 10px;
            background: #e7ebed; border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.30);
        }
        .perfil-dd-item {
            display: block; width: 100%; text-align: left;
            padding: 12px 18px; border-radius: 10px;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px;
            color: #1f2933; background: transparent; border: none; cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }
        .perfil-dd-item:hover { background: rgba(0,0,0,0.06); color: #05BAEE; }

        /* ===== Modal "¿Te vas ya?" (cerrar sesión) ===== */
        .lg-overlay {
            position: fixed; inset: 0; z-index: 200; display: flex; align-items: center; justify-content: center;
            background: rgba(26,38,44,0.55); padding: 20px;
        }
        .lg-overlay[hidden] { display: none; }
        .lg-card {
            width: 100%; max-width: 500px; padding: 48px 40px 40px;
            display: flex; flex-direction: column; align-items: center; text-align: center;
            border-radius: 28px;
            background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.40);
            -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
            box-shadow: 0 30px 90px rgba(0,0,0,0.28);
        }
        .lg-icon {
            width: 86px; height: 86px; border-radius: 999px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.30);
            color: rgba(255,255,255,0.85); margin-bottom: 26px;
        }
        .lg-icon svg { width: 38px; height: 38px; }
        .lg-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 26px; color: #fff; margin: 0 0 14px; }
        .lg-text { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px; line-height: 150%; color: rgba(255,255,255,0.80); margin: 0 auto 36px; max-width: 360px; }
        .lg-actions { display: flex; align-items: center; justify-content: center; gap: 48px; }
        .lg-btn { background: transparent; border: none; cursor: pointer; font-family: 'Montserrat', sans-serif; font-size: 15px; color: #fff; padding: 8px 12px; transition: color .2s ease; }
        .lg-salir { font-weight: 500; color: rgba(255,255,255,0.85); }
        .lg-stay { font-weight: 600; color: #fff; }
        .lg-btn:hover { color: #05BAEE; }

        /* ===== Loader "¡Hasta pronto!" (reusa el patrón del login) ===== */
        .reg-loader-overlay { position: fixed; inset: 0; z-index: 210; display: flex; align-items: center; justify-content: center; background: rgba(26,38,44,0.55); }
        .reg-loader-overlay[hidden] { display: none; }
        .reg-loader-card { width: 500px; max-width: calc(100% - 40px); padding: 56px 32px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 40px; border-radius: 28px; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.40); -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px); box-shadow: 0 30px 90px rgba(0,0,0,0.28); text-align: center; }
        .reg-spinner { width: 150px; height: 150px; animation: reg-spin 1.1s linear infinite; }
        @keyframes reg-spin { to { transform: rotate(360deg); } }
        .reg-loader-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 24px; color: #fff; margin: 0; }

        /* ===================================================================== */
        /* =====================  MÓVIL  (≤767px)  ============================= */
        /* ===================================================================== */
        @media (max-width: 767px) {
            /* ===== Nav (móvil) — 77px · glass radial · blur 40 · borde inf. 0.5 #BFBFBF ===== */
            .curso-nav {
                position: sticky; top: 0; z-index: 40;
                background:
                    radial-gradient(130% 190% at 50% 0%, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0.05) 45%, rgba(255,255,255,0) 75%),
                    #0a0a0c;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
                box-shadow: 0 0.5px 0 0 #BFBFBF;   /* borde inferior 0.5px outer (no infla el alto) */
            }
            .curso-nav .h-16 {
                height: 77px !important;
                padding-left: 16px !important; padding-right: 16px !important;
            }
            .curso-nav-right { display: flex !important; align-items: center; gap: 12px !important; }
            .curso-nav-right .nav-org-txt { display: none; }      /* en móvil: solo logo SEC + burger */
            .curso-nav a img { height: 24px !important; width: 113px !important; }    /* logo 113×24 */
            .curso-nav-right img { height: 34px !important; width: auto !important; }  /* SEC 65.28×34 */
            .curso-burger {
                display: inline-flex !important; align-items: center; justify-content: center;
                width: 34px !important; height: 34px !important; padding: 8px; border-radius: 4px; color: #FFFFFF;
            }
            .curso-burger svg { width: 18px; height: 18px; }

            /* ===== Menú a pantalla completa (img4/img5) ===== */
            .curso-mobmenu {
                display: none; position: fixed; top: 0; left: 0; right: 0; z-index: 100;
                height: 833px;                       /* Hug 833 → no llega hasta abajo */
                flex-direction: column; gap: 16px;   /* Gap 16 entre secciones */
                background: linear-gradient(180deg, #2b2b2d 0%, #000000 22%);
                box-shadow: inset 0 -0.5px 0 0 rgba(255,255,255,0.20);  /* borde inferior 0.5 */
            }
            .curso-mobmenu.open { display: flex; }
            .cm-top { flex: none; height: 77px; display: flex; align-items: center; justify-content: space-between; padding: 0 16px; }
            .cm-logo { height: 24px; width: 113px; }
            .cm-top-right { display: flex; align-items: center; gap: 12px; }
            .cm-sec { height: 34px; width: auto; }
            .cm-close {
                display: inline-flex; align-items: center; justify-content: center;
                width: 34px; height: 34px; padding: 8px; border-radius: 4px; color: #FFFFFF;
            }
            .cm-links { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px; padding: 16px; }
            .cm-link {
                font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; line-height: 18px;
                letter-spacing: 0.02em; color: #FFFFFF; text-align: center;
                padding: 8px 16px; border-radius: 4px;          /* button/sistema ghost: hug · radius 4 · pad 8/16 */
            }
            .cm-link:hover, .cm-link:active { background: rgba(255,255,255,0.08); }
            .cm-divider { width: 358px; height: 0; border-top: 1px solid rgba(255,255,255,0.50); margin: 0; }  /* Vector 89: 358 · 1px · #FFFFFF 50% */
            .cm-org { flex: none; display: flex; flex-direction: column; align-items: center; gap: 14px; padding: 0 16px 56px; }
            .cm-org-txt { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; color: rgba(255,255,255,0.75); }
            .cm-org-logo { width: 148px; height: auto; }

            /* ===== Contenido Autores (móvil) — pendiente: por ahora solo reusa el nav ===== */
            .tut-wrap { padding: 32px 16px 56px; }
            .tut-title { font-size: 28px; }
            .tut-title-underline { width: 100px; }
            .aut-grid { grid-template-columns: 1fr; }   /* móvil: 1 columna (layout móvil del comité pendiente) */
            .aut-pill { opacity: 1; }                   /* móvil: sin hover → la pastilla del rol siempre visible */
            /* Footer apilado y centrado en móvil */
            .tut-footer-inner { flex-direction: column; text-align: center; gap: 18px; padding: 28px 16px 36px; }
            .tut-footer-legal { text-align: center; }
            .tut-footer-links { gap: 14px; flex-wrap: wrap; justify-content: center; }
            .tut-footer-links .tut-footer-link { font-size: 12px; }
            /* Modal cerrar sesión: botones apilados (Seguir aquí arriba, Salir abajo) */
            .lg-actions { flex-direction: column-reverse; gap: 16px; width: 100%; }
            .lg-btn { width: 100%; padding: 12px; }
            .lg-card { max-width: 358px; padding: 36px 24px 28px; }
            .reg-loader-card { width: 358px; }
            .reg-spinner { width: 139px; height: 139px; }
        }
    </style>
</head>
<body class="tut-bg curso-bg min-h-screen flex flex-col text-white">

    {{-- ===== NAV ===== --}}
    <header class="curso-nav">
        <div class="mx-auto px-6 lg:px-12 h-16 flex items-center justify-between" style="max-width:1600px;">
            <div class="flex items-center" style="gap:30px;">
                <a href="{{ route('curso') }}" class="shrink-0 flex items-center" style="margin-right:4px;">
                    <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
                </a>
                <nav class="hidden md:flex items-center" style="gap:8px;">
                    <a href="{{ route('curso') }}" class="nav-link">Inicio</a>
                    <a href="{{ route('tutoria') }}" class="nav-link">Tutoría</a>
                    <a href="{{ route('autores') }}" class="nav-link active">Autores</a>
                    <div class="perfil-menu">
                        <button type="button" class="nav-link perfil-btn" onclick="togglePerfil(event)">
                            Perfil
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="perfil-dd" hidden>
                            <a href="{{ route('perfil') }}" class="perfil-dd-item">Mi perfil</a>
                            <button type="button" class="perfil-dd-item" onclick="openLogout()">Cerrar sesión</button>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="curso-nav-right hidden md:flex items-center" style="gap:10px;">
                <span class="nav-org-txt">Organizado por</span>
                <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" class="h-9 w-auto">
                <button type="button" class="curso-burger" aria-label="Menú"
                        onclick="document.getElementById('curso-mobmenu').classList.add('open');document.body.style.overflow='hidden'">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Menú móvil a pantalla completa (img4/img5) — fuera del header (backdrop-filter rompe position:fixed) --}}
    <div class="curso-mobmenu" id="curso-mobmenu">
            <div class="cm-top">
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="cm-logo">
                <div class="cm-top-right">
                    <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" class="cm-sec">
                    <button type="button" class="cm-close" aria-label="Cerrar"
                            onclick="document.getElementById('curso-mobmenu').classList.remove('open');document.body.style.overflow=''">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
                    </button>
                </div>
            </div>
            <nav class="cm-links">
                <a href="{{ route('curso') }}" class="cm-link">Inicio</a>
                <a href="{{ route('tutoria') }}" class="cm-link">Tutoría</a>
                <a href="{{ route('autores') }}" class="cm-link active">Autores</a>
                <div class="cm-divider"></div>
                <a href="{{ route('perfil') }}" class="cm-link">Mi perfil</a>
                <a href="#" class="cm-link" onclick="event.preventDefault();openLogout();">Cerrar sesión</a>
            </nav>
            <div class="cm-org">
                <span class="cm-org-txt">Organizado por:</span>
                <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" class="cm-org-logo">
            </div>
            <form id="cm-logout" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
    </div>

    {{-- ===== CONTENIDO ===== --}}
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

    <main class="flex-1">
        <div class="tut-wrap">

            {{-- Título --}}
            <h1 class="tut-title">Comité científico</h1>
            <div class="tut-title-underline"></div>

            {{-- Subtítulo --}}
            <p class="aut-subtitle">Dirección y contenido avalados por especialistas en riesgo cardiovascular</p>

            {{-- Grilla de 6 tarjetas (3 columnas, tabla conectada) --}}
            <div class="aut-grid grid grid-cols-3">
                @foreach ($members as $m)
                    @php
                        $fem = \Illuminate\Support\Str::startsWith($m['name'], 'Dra.');
                        $esCoord = \Illuminate\Support\Str::contains(\Illuminate\Support\Str::lower($m['role']), 'coordinador');
                        $rolTxt = $esCoord ? ($fem ? 'Coordinadora y autora' : 'Coordinador y autor') : ($fem ? 'Autora' : 'Autor');
                    @endphp
                    <div class="aut-card group">
                        {{-- Fila superior: ícono + pastilla de rol --}}
                        <div class="aut-top comite-top">
                            <span class="aut-icon">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6 6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.3.3 0 1 0 .2.3"/>
                                    <path d="M8 15v1a6 6 0 0 0 12 0v-4"/>
                                    <circle cx="20" cy="10" r="2"/>
                                </svg>
                            </span>
                            <span class="aut-pill">{{ $rolTxt }}</span>
                        </div>

                        {{-- Nombre + organización --}}
                        <div class="aut-text">
                            <h3 class="aut-name">{{ $m['name'] }}</h3>
                            <p class="aut-org">{{ $m['org'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </main>

    {{-- ===== FOOTER (línea legal + enlaces, como el Figma) ===== --}}
    <footer class="tut-footer">
        <div class="tut-footer-inner">
            <p class="tut-footer-legal">El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. {{ date('Y') }} © Qualimed Ediciones S.L.</p>
            <div class="tut-footer-links">
                <a href="#" class="tut-footer-link">Aviso legal</a>
                <a href="#" class="tut-footer-link">Política de privacidad</a>
                <a href="#" class="tut-footer-link">Política de cookies</a>
            </div>
        </div>
    </footer>

    {{-- ===== Modal "¿Te vas ya?" + loader "¡Hasta pronto!" (cerrar sesión) ===== --}}
    <div id="logout-modal" class="lg-overlay" hidden>
        <div class="lg-card">
            <div class="lg-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
            </div>
            <h3 class="lg-title">¿Te vas ya?</h3>
            <p class="lg-text">Guardamos tu avance para que continúes donde lo dejaste.</p>
            <div class="lg-actions">
                <button type="button" class="lg-btn lg-salir" onclick="doLogout()">Salir</button>
                <button type="button" class="lg-btn lg-stay" onclick="closeLogout()">Seguir aquí</button>
            </div>
        </div>
    </div>
    <div id="logout-loader" class="reg-loader-overlay" hidden>
        <div class="reg-loader-card">
            <svg class="reg-spinner" viewBox="0 0 50 50" aria-hidden="true">
                <circle cx="25" cy="25" r="20" fill="none" stroke="rgba(255,255,255,0.22)" stroke-width="4"/>
                <circle cx="25" cy="25" r="20" fill="none" stroke="#05BAEE" stroke-width="4" stroke-linecap="round" stroke-dasharray="32 100"/>
            </svg>
            <div class="reg-loader-text"><h3 class="reg-loader-title">¡Hasta pronto!</h3></div>
        </div>
    </div>
    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>

    <script>
        // ===== Cerrar sesión: dropdown → modal → loader → logout =====
        function togglePerfil(e) {
            e.stopPropagation();
            var menu = e.currentTarget.closest('.perfil-menu');
            var dd = menu.querySelector('.perfil-dd');
            var open = dd.hidden;
            dd.hidden = !open;
            menu.querySelector('.perfil-btn').classList.toggle('open', open);
        }
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.perfil-menu')) {
                document.querySelectorAll('.perfil-dd').forEach(function (d) { d.hidden = true; });
                document.querySelectorAll('.perfil-btn').forEach(function (b) { b.classList.remove('open'); });
            }
        });
        function openLogout() {
            document.querySelectorAll('.perfil-dd').forEach(function (d) { d.hidden = true; });
            document.querySelectorAll('.perfil-btn').forEach(function (b) { b.classList.remove('open'); });
            var mm = document.getElementById('curso-mobmenu'); if (mm) mm.classList.remove('open');
            document.getElementById('logout-modal').hidden = false;
            document.body.style.overflow = 'hidden';
        }
        function closeLogout() {
            document.getElementById('logout-modal').hidden = true;
            document.body.style.overflow = '';
        }
        function doLogout() {
            document.getElementById('logout-modal').hidden = true;
            document.getElementById('logout-loader').hidden = false;
            setTimeout(function () { document.getElementById('logout-form').submit(); }, 1500);
        }
    </script>

</body>
</html>
