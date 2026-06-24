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
        .curso-burger { display: none; }   /* solo visible en móvil */
        .curso-mobmenu { display: none; }  /* oculto por defecto (en escritorio nunca aparece); en móvil se abre con .open */

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
        .juan-img-mobile { display: none; }   /* solo se usa en móvil */
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

        /* ===================================================================== */
        /* =====================  MÓVIL  (≤767px)  ============================= */
        /* Layout de una sola columna · sección 390 · padding 16 · gap 32 · #26383F */
        /* ===================================================================== */
        @media (max-width: 767px) {
            /* La página scrollea (no pantalla fija) */
            body.curso-bg { height: auto !important; min-height: 100vh; display: block !important; }
            .curso-scale-outer { overflow: hidden !important; height: auto !important; min-height: 0 !important; }

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

            /* Globo de luz: 543×308 · blanco 50% · blur 400 · detrás de todo */
            .curso-blob { width: 543px !important; height: 308px !important; opacity: 0.55 !important; filter: blur(120px) !important; }
            .curso-blob:nth-of-type(1) { left: 50% !important; right: auto !important; top: 160px !important; bottom: auto !important; margin-left: -271px; }
            .curso-blob:nth-of-type(2) { display: none !important; }

            /* ===== Sección: una columna · padding 16 · gap 32 ===== */
            .curso-stage {
                width: 100% !important; max-width: 390px; margin: 0 auto;
                padding: 24px 16px !important; transform: none !important;
                display: flex; flex-direction: column; gap: 32px;
            }

            /* Títulos apilados, alineados a la izquierda */
            .curso-titles {
                flex-direction: column !important; align-items: flex-start !important;
                gap: 0 !important; margin: 0 !important;
            }
            .curso-title { font-size: 26px; font-weight: 600; line-height: 130%; }      /* SemiBold 26 · 358×34 */
            .curso-subtitle { font-size: 26px; font-weight: 600; line-height: 130%; text-align: left !important; } /* SemiBold 26 · 358×68 */
            .curso-subtitle .rojo, .curso-subtitle .cyan { display: block; }            /* rojo #A23D33 / cyan #05BAEE se mantienen */

            /* ===== Fila Juan + Panel → columna ===== */
            .curso-row {
                display: flex !important; flex-direction: column; gap: 32px;
                margin: 0 !important; top: 0 !important; justify-content: flex-start !important;
            }

            /* ===== Perfil de paciente — imagen completa (Juan + piso/elipses ya incluidos) ===== */
            .juan-col {
                position: relative !important; left: auto !important; bottom: auto !important;
                width: 390px !important; max-width: none !important;
                margin-left: -16px !important; margin-right: -16px !important;   /* full-bleed: Juan de borde a borde */
                height: 470px !important; overflow: hidden;
            }
            .juan-img { display: none !important; }                              /* imagen desktop oculta en móvil */
            .juan-img-mobile {
                display: block; position: absolute;
                left: 0; top: -108px;                                            /* Juan más arriba */
                width: 390px; max-width: none; height: auto;
            }
            /* Tarjeta de datos (3 cards 230) abajo-izquierda */
            /* CUADRO unificado (tabla) — mismo ancho, redondeado, glass, con divisores */
            .juan-cards {
                position: absolute !important; left: 16px !important; right: auto !important;
                bottom: 60px !important; width: 228px !important;
                display: flex; flex-direction: column;
                padding: 0 !important;
                border-radius: 0 !important; overflow: hidden;                           /* cuadro recto (sin radio) */
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.05) !important;            /* borde blanco 5% (tu ajuste) */
                background: rgba(255,255,255,0.06) !important;                           /* fondo blanco 6% (tu ajuste) */
                -webkit-backdrop-filter: blur(12px) !important; backdrop-filter: blur(12px) !important;  /* glass */
                z-index: 2;
            }
            .juan-card {
                width: 100% !important; max-width: none !important;
                gap: 16px !important;
                padding: 16px 24px !important;
                background: none !important; box-shadow: none !important;
                border: 0 !important; box-sizing: border-box;
                font-size: 14px !important; line-height: 1.5 !important; color: #FFFFFF;
            }
            .juan-card + .juan-card { border-top: 1px solid rgba(255,255,255,0.40) !important; margin-top: 0 !important; }  /* divisor */
            .juan-card svg { width: 20px !important; height: 20px !important; color: #cdd9dd; }

            /* ===== Panel de módulos (358 · pad 16 · borde 1px blanco 40% · fondo 10% · blur 40) ===== */
            .curso-panel {
                position: static !important; top: 0 !important;
                width: 100% !important; flex: none !important;
                margin-top: -61px !important;                                        /* posición del cuadro (tu ajuste) */
                padding: 16px !important; border: 0 !important; border-radius: 12px !important;  /* esquinas redondeadas */
                background: rgba(255,255,255,0.25) !important;                       /* fondo blanco 25% (tu ajuste) */
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.40) !important;        /* borde 1px blanco 40% inner */
                -webkit-backdrop-filter: blur(40px) !important; backdrop-filter: blur(40px) !important;  /* glass blur 40 */
            }

            /* Cada módulo (avance de curso): vertical · pad 16/8 · divisor inferior 0.5 #B9B9B9 25% */
            .ing-row {
                display: grid !important;
                grid-template-columns: 1fr auto;
                grid-template-areas: "label label" "title title" "pct cta";
                gap: 24px 12px !important; padding: 16px 8px !important; align-items: center;
                border-bottom: 0.5px solid rgba(185,185,185,0.25) !important;         /* divisor #B9B9B9 25% */
            }
            .ing-label { grid-area: label; font-size: 18px !important; font-weight: 600 !important; line-height: 140% !important; color: #05BAEE !important; padding-bottom: 12px !important; border-bottom: 0.5px solid rgba(185,185,185,0.25) !important; }  /* línea debajo del título */
            .ing-title { grid-area: title; font-size: 14px !important; font-weight: 400 !important; line-height: 150% !important; color: #FFFFFF !important; padding-left: 0 !important; border-left: none !important; }
            .ing-pct { grid-area: pct; align-self: center; }
            .ing-cta { grid-area: cta; justify-self: end; }
            .btn-iniciar, .btn-locked { width: 148px !important; height: 45px !important; border-radius: 4px !important; font-size: 15px; }

            /* ===== Detalle del curso ===== */
            .detalle-head { display: block !important; padding: 18px 0 10px !important; }
            .detalle-label { margin-bottom: 8px; }
            .detalle-estado { display: inline !important; padding-left: 0 !important; border-left: none !important; }
            .detalle-hasta { display: inline; margin-left: 12px; }
            .finales-grid {
                grid-template-columns: 1fr !important; gap: 16px !important;
                padding-left: 0 !important; padding-right: 0 !important;
            }
            /* Botones Evaluación final / Diploma: alto 53 · texto Medium 14 ls 2% blanco · candado blanco 40% */
            .final-card {
                padding: 16px !important;
                font-size: 14px !important; font-weight: 500 !important; line-height: 150% !important;
                letter-spacing: 0.02em !important; color: #FFFFFF !important;
            }
            .final-card svg { color: rgba(255,255,255,0.40) !important; width: 15px !important; height: 17px !important; }

            /* ===== Footer ===== */
            .curso-footer .flex.items-center.gap-8 { gap: 16px !important; flex-wrap: wrap; justify-content: center; }
            .footer-txt, .footer-link { font-size: 12px !important; }
        }
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
                <a href="#" class="cm-link">Tutoría</a>
                <a href="#" class="cm-link">Autores</a>
                <div class="cm-divider"></div>
                <a href="#" class="cm-link">Mi perfil</a>
                <a href="#" class="cm-link" onclick="event.preventDefault();document.getElementById('cm-logout').submit();">Cerrar sesión</a>
            </nav>
            <div class="cm-org">
                <span class="cm-org-txt">Organizado por:</span>
                <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" class="cm-org-logo">
            </div>
            <form id="cm-logout" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
    </div>

    {{-- ===== CONTENIDO (escalado uniforme) ===== --}}
    <main class="flex-1 min-h-0 relative overflow-hidden curso-scale-outer">
        {{-- Globos blancos pequeños: detrás de Juan y en la esquina superior --}}
        <div class="curso-blob" style="left:1%; bottom:4%;"></div>
        <div class="curso-blob" style="right:3%; top:2%;"></div>

        <div class="curso-stage mx-auto pt-10 pb-10">

            {{-- Títulos --}}
            <div class="curso-titles flex items-end justify-between" style="gap:32px; margin-top:34px; margin-bottom:40px;">
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
                    <img class="juan-img-mobile" src="{{ asset('images/paciente.png') }}" alt="{{ $curso['paciente']['nombre'] }}">
                    <div class="juan-cards">
                        @foreach ($curso['paciente']['datos'] as $dato)
                            <div class="juan-card">
                                @if ($dato['icon'] === 'edad')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v4M16 3v4"/></svg>
                                @elseif ($dato['icon'] === 'fuma')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="13" width="14" height="5" rx="1"/><path d="M12 13v5M7 13v5"/><path d="M18 5c1.2.7 1.2 2 .7 3M21 7c.6 1 .3 2.2-.5 2.8"/><path d="M19 13v5h3v-5z"/></svg>
                                @else
                                    {{-- Corazón con pulso (img3) --}}
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20.5 8.6c0-2.3-1.9-4.1-4.1-4.1-1.6 0-3 .9-3.7 2.3-.7-1.4-2.1-2.3-3.7-2.3C6.8 4.5 5 6.3 5 8.6c0 4.6 7.7 9.2 7.7 9.2s7.8-4.6 7.8-9.2Z"/><path d="M5.4 11.7h2.7l1.3-2.3 2 4.4 1.4-2.5 1 1.5h3.4"/></svg>
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
                            // Avance real del módulo: etapa alcanzada / total de etapas (igual que la barra de la etapa).
                            $etapasTotal = count($curso['etapas']);
                            $idx = (int) ($p->etapa_index ?? 0);
                            $percent = $status === 'completed' ? 100 : (int) round($idx / max($etapasTotal, 1) * 100);
                            $abierto = in_array($status, ['available', 'in_progress', 'completed']);
                        @endphp
                        <div class="ing-row {{ $abierto ? '' : 'locked' }}">
                            <div class="ing-label">{{ $ing['label'] }}</div>
                            <div class="ing-title">{{ $ing['titulo'] }}</div>
                            <div class="ing-pct">{{ str_pad($percent, 2, '0', STR_PAD_LEFT) }} %</div>
                            <div class="ing-cta">
                                @if ($abierto)
                                    <a href="{{ route('curso.etapa', $ing['key']) }}" class="btn-iniciar">Iniciar</a>
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
