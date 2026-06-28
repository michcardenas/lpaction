<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Bloqueo de viewport por dispositivo, para que el navegador escale el diseño "como una imagen":
         - Teléfono (<768): diseño móvil bloqueado a 390.
         - Tablet (táctil, lado corto ≤1024): muestra el diseño WEB completo bloqueado a 1440 y lo escala
           para caber → se ve igual que en web, sin desbordarse ni romperse.
         - Desktop: sin cambios (device-width). --}}
    <script>
        (function () {
            var vp = document.querySelector('meta[name="viewport"]');
            if (!vp) return;
            function apply() {
                var shortSide = Math.min(screen.width || 9999, screen.height || 9999);
                var longSide  = Math.max(screen.width || 0, screen.height || 0);
                var coarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
                if (shortSide < 768) {
                    vp.setAttribute('content', 'width=390');
                } else if (coarse && shortSide <= 1024 && longSide <= 1400) {
                    vp.setAttribute('content', 'width=1440');
                } else {
                    vp.setAttribute('content', 'width=device-width, initial-scale=1.0');
                }
            }
            apply();
            window.addEventListener('orientationchange', apply);
            window.addEventListener('resize', apply);
        })();
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ingreso — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @view-transition { navigation: auto; }
        body { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; }
        .login-bg {
            background:
                radial-gradient(ellipse at 75% 30%, #eaf3f7 0%, transparent 55%),
                linear-gradient(150deg, #f3f7f9 0%, #e6eef3 55%, #dde8ee 100%);
        }
        /* Stage con escala uniforme → mismo aspecto en cualquier PC */
        .login-stage {
            position: relative;
            width: 1340px;
            flex-shrink: 0;
            padding-top: 64px;
            min-height: 520px;
            transform-origin: top center;
        }
        .login-content { position: relative; z-index: 10; padding: 0 40px; }
        .login-molecule {
            position: absolute;
            right: 34px;
            top: 54%;
            transform: translateY(-50%);
            width: 620px;
            max-width: none;
            pointer-events: none;
            user-select: none;
            z-index: 0;
        }
        @media (max-width: 1023px) {
            .login-stage { width: 100%; transform: none !important; min-height: 0; padding-top: 24px; }
            .login-content { padding: 0 24px; }
            .login-molecule { right: -8%; top: 50%; width: min(62vw, 480px); }
        }
        .login-card {
            background: rgba(255, 255, 255, 0.35);
            border: 1px solid rgba(120, 140, 150, 0.28);
            border-radius: 8px;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }
        .login-input {
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            background: #ffffff;
            border: 1px solid #d4dde2;
            border-radius: 8px;
            color: #1b2a31;
            transition: border-color .2s, box-shadow .2s;
        }
        .login-input::placeholder { color: #9aa7ad; }
        .login-input:focus {
            outline: none;
            border-color: #05BAEE;
            box-shadow: 0 0 0 3px rgba(5, 186, 238, 0.15);
        }
        .login-label { font-weight: 700; font-size: 15px; color: #1b2a31; }
        .btn-primary {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600; font-size: 15px;
            background: #05BAEE; color: #fff;
            padding: 12px 30px; border-radius: 8px;
            transition: background .2s;
        }
        .btn-primary:hover { background: #04a3d1; }
        .link-cyan { color: #05BAEE; }
        /* Header / Footer oscuros */
        .header-bar { background: linear-gradient(90deg, #060606 0%, #181818 50%, #060606 100%); }
        .footer-dark { background: linear-gradient(90deg, #080808 0%, #1a1a1a 50%, #080808 100%); }
        .org-text { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 12px; letter-spacing: 0.01em; }
        .btn-acceder {
            font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; letter-spacing: 0.01em;
            background: #05BAEE; color: #fff; padding: 9px 24px; border-radius: 7px;
            transition: background .2s; white-space: nowrap;
        }
        .btn-acceder:hover { background: #04a3d1; }
        .footer-txt {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 12px;
            line-height: 150%;
            letter-spacing: 0.01em;
        }

        /* ── Loader "Accediendo al curso" (mismo modal que el registro) ── */
        .reg-loader-overlay { position: fixed; inset: 0; z-index: 200; display: flex; align-items: center; justify-content: center; background: rgba(26,38,44,0.55); opacity: 0; transition: opacity .35s ease; }
        .reg-loader-overlay[hidden] { display: none; }
        .reg-loader-overlay.is-visible { opacity: 1; }
        .reg-loader-card { width: 540px; height: 442px; padding: 64px 32px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 64px; border-radius: 32px; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.40); backdrop-filter: blur(40px); -webkit-backdrop-filter: blur(40px); box-shadow: 0 30px 90px rgba(0,0,0,0.28); transform: scale(0.94); transition: transform .45s cubic-bezier(.2,.8,.2,1); text-align: center; }
        .reg-loader-overlay.is-visible .reg-loader-card { transform: scale(1); }
        .reg-spinner { width: 160px; height: 160px; animation: reg-spin 1.1s linear infinite; }
        .reg-spin-track { fill: none; stroke: rgba(255,255,255,0.16); stroke-width: 1.6; }
        .reg-spin-arc { fill: none; stroke-width: 1.6; stroke-linecap: round; stroke-dasharray: 46 180; }
        @keyframes reg-spin { to { transform: rotate(360deg); } }
        .reg-loader-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 24px; color: #fff; margin: 0 0 14px; }
        .reg-loader-sub { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px; line-height: 150%; color: rgba(255,255,255,0.78); margin: 0 auto; max-width: 380px; }
        /* Modal a spec Figma móvil: 358 · padding 32/16 · gap 32 · spinner 139 · título 22 · sub 14 */
        @media (max-width: 767px) {
            .reg-loader-card { width: 358px; height: auto; min-height: 0; padding: 32px 16px 16px; gap: 32px; }
            .reg-spinner { width: 139px; height: 139px; }
            .reg-loader-title { font-weight: 600; font-size: 22px; line-height: 140%; letter-spacing: 0; color: #FFFFFF; margin: 0 0 16px; }
            .reg-loader-sub { font-weight: 400; font-size: 14px; line-height: 150%; letter-spacing: 0; color: #FFFFFF; width: 326px; max-width: 100%; }
        }

        /* ── Móvil: nav glass + molécula fija + footer (igual que registro) ── */
        @media (max-width: 767px) {
            /* Nav superior fijo */
            .reg-nav {
                position: sticky; top: 0; z-index: 50; height: 64px;
                background: radial-gradient(120% 190% at 80% 0%, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0.04) 55%, transparent 100%), #0a0a0c;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
                border-bottom: 0.5px solid #BFBFBF;
            }
            .reg-nav-inner { max-width: 100% !important; padding-left: 16px !important; padding-right: 16px !important; height: 64px !important; }
            .reg-nav-sec { height: 36px !important; }
            .reg-nav-btn {
                font-family: 'Montserrat', sans-serif !important; font-weight: 500 !important; font-size: 12px !important;
                letter-spacing: 0.01em !important; line-height: 150% !important; color: #FFFFFF !important; background: #05BAEE !important;
                padding: 12px 16px !important; border-radius: 4px !important; text-decoration: none !important;
            }
            /* Molécula de fondo: 358×321 · FIJA · drop shadow 0 4 4 #000 50% */
            main { overflow: visible !important; }
            .login-molecule {
                position: fixed !important; left: 50% !important; right: auto !important;
                transform: translateX(-50%) !important; top: 150px !important;
                width: 358px !important; height: 321px !important; object-fit: contain !important;
                filter: drop-shadow(0 4px 4px rgba(0,0,0,0.50)) !important; z-index: 0 !important;
            }
            /* Footer: copyright centrado (2 líneas) + links 1 fila + divisor */
            .footer-dark .max-w-7xl { padding-left: 16px !important; padding-right: 16px !important; gap: 14px !important; }
            .footer-dark p.footer-txt { text-align: center !important; }
            .reg-footer-links {
                width: 100% !important; justify-content: center !important; flex-wrap: nowrap !important;
                border-top: 0.5px solid rgba(255,255,255,0.18); padding-top: 14px;
            }
            .reg-footer-links a { white-space: nowrap !important; }
            .reg-footer-links span { margin: 0 8px !important; }

            /* ── Formulario Ingreso (spec Figma): título SemiBold 22 · form Fill 358 · gap 16 ── */
            .login-content { padding-left: 16px !important; padding-right: 16px !important; }
            .login-title {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 600 !important;
                font-size: 22px !important;
                line-height: 140% !important;
                letter-spacing: 0 !important;
                color: #111111 !important;
            }
            #login-form.login-card {
                max-width: 100% !important; width: 100% !important;
                padding: 16px !important;
                display: flex !important; flex-direction: column !important; gap: 16px !important;
            }
            #login-form.login-card > * { margin: 0 !important; }   /* gap 16 controla todo */
            .login-cta { gap: 16px !important; }                    /* Ingresar ↔ Crear cuenta */
            /* subir la caja un poco (menos espacio título ↔ form) */
            .login-title { margin-bottom: 16px !important; }
            /* Inputs (campo 326×78): gap 4 entre label e input */
            #login-form .login-label { margin-bottom: 4px !important; }
            /* Recordar (selector/checkbox): gap 16 checkbox ↔ texto */
            .login-remember { gap: 16px !important; }
            /* Recuperar contraseña: botón ghost full-width · radius 4 · padding 12/4 · centrado */
            .login-recuperar {
                display: block !important; width: 100% !important; text-align: center !important;
                padding: 12px 4px !important; border-radius: 4px !important;
            }
            /* Ingresar: full-width · radius 4 · padding 12/24 */
            .login-cta .btn-primary {
                width: 100% !important; border-radius: 4px !important; align-self: stretch !important;
                padding: 12px 24px !important;
            }
            /* ── Tamaños de letra (spec Figma) ── */
            #login-form .login-label { font-size: 14px !important; }   /* labels Usuario / Contraseña */
            /* Recordar: Montserrat Medium 14 / 150% / ls 2% / #575757 */
            .login-remember span {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 500 !important; font-size: 14px !important;
                line-height: 150% !important; letter-spacing: 0.02em !important; color: #575757 !important;
            }
            /* "Soy médico y no estoy registrado. Crear cuenta" en una sola línea */
            .login-cta p { font-size: 12px !important; white-space: nowrap !important; }
        }
    </style>
</head>
<body class="login-bg min-h-screen flex flex-col text-[#1b2a31]">

    {{-- Header / Nav superior fijo (igual que registro) --}}
    <header class="reg-nav header-bar text-white">
        <div class="reg-nav-inner max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
            </a>
            <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" class="reg-nav-sec" style="height:36px; width:auto; object-fit:contain;">
            <a href="{{ route('register') }}" class="btn-acceder reg-nav-btn">Acceder</a>
        </div>
    </header>

    <main class="flex-1 relative overflow-hidden flex justify-center items-start">
        <div class="login-stage">
        {{-- Molecule --}}
        <img class="login-molecule" src="{{ asset('images/molecula-lpa.png') }}" alt="Lp(a)" aria-hidden="true">

        <div class="login-content">
            <h1 class="login-title text-3xl lg:text-[34px] font-semibold mb-7">Ingreso</h1>

            <form id="login-form" action="{{ route('login') }}" method="POST" class="login-card w-full max-w-[790px] p-7 lg:p-9">
                @csrf

                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-lg text-[14px]" style="background:rgba(224,86,75,0.12); border:1px solid rgba(224,86,75,0.4); color:#e0564b;">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Usuario --}}
                <div class="mb-5">
                    <label for="email" class="login-label block mb-2">Usuario</label>
                    <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}"
                           placeholder="Tu correo electrónico"
                           class="login-input w-full px-4 py-3.5">
                </div>

                {{-- Contraseña --}}
                <div class="mb-4">
                    <label for="password" class="login-label block mb-2">Contraseña</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password"
                               placeholder="**** **** ****"
                               class="login-input w-full px-4 py-3.5 pr-12">
                        <button type="button" onclick="togglePwd()" aria-label="Mostrar contraseña"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7d8a90] hover:text-[#05BAEE] transition-colors">
                            <svg id="eye-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Recordar --}}
                <label class="login-remember flex items-center gap-2.5 mb-5 cursor-pointer select-none">
                    <input type="checkbox" name="remember"
                           class="w-[18px] h-[18px] rounded-[4px] border border-[#c3ced3] accent-[#05BAEE] cursor-pointer">
                    <span class="text-[14px] text-[#3a4a52]">Recordar usuario y contraseña</span>
                </label>

                {{-- Recuperar (botón ghost full-width) --}}
                <a href="#" class="login-recuperar inline-block text-[14px] text-[#3a4a52] hover:text-[#05BAEE] transition-colors mb-7">
                    Recuperar contraseña
                </a>

                {{-- Acciones (cta) --}}
                <div class="login-cta flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                    <button type="submit" class="btn-primary self-start">Ingresar</button>
                    <p class="text-[14px] text-[#3a4a52]">
                        Soy médico y no estoy registrado.
                        <a href="{{ route('register') }}" class="link-cyan font-medium underline underline-offset-4 ml-1">Crear cuenta</a>
                    </p>
                </div>
            </form>
        </div>
        </div>{{-- /login-stage --}}
    </main>

    {{-- Footer --}}
    <footer class="footer-dark text-white relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="footer-txt text-white/70 text-center md:text-left">
                © 2026 Sociedad Española de Cardiología. Plataforma tecnológica y metodología por © Qualimed Ediciones S.L.
            </p>
            <div class="reg-footer-links flex items-center footer-txt text-white/85">
                <a href="#" class="hover:text-[#05BAEE] transition-colors">Aviso legal</a>
                <span style="display:inline-block; width:1px; height:14px; background:rgba(255,255,255,0.35); margin:0 20px;"></span>
                <a href="#" class="hover:text-[#05BAEE] transition-colors">Política de privacidad</a>
                <span style="display:inline-block; width:1px; height:14px; background:rgba(255,255,255,0.35); margin:0 20px;"></span>
                <a href="#" class="hover:text-[#05BAEE] transition-colors">Política de cookies</a>
            </div>
        </div>
    </footer>

    {{-- Loader "Accediendo al curso" (aparece al pulsar Ingresar) --}}
    <div id="login-loader" class="reg-loader-overlay" hidden>
        <div class="reg-loader-card">
            <svg class="reg-spinner" viewBox="0 0 50 50" aria-hidden="true">
                <defs>
                    <linearGradient id="loginSpin" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#05BAEE" stop-opacity="0"/>
                        <stop offset="60%" stop-color="#05BAEE" stop-opacity=".5"/>
                        <stop offset="100%" stop-color="#05BAEE" stop-opacity="1"/>
                    </linearGradient>
                </defs>
                <circle class="reg-spin-track" cx="25" cy="25" r="20"/>
                <circle class="reg-spin-arc" cx="25" cy="25" r="20" stroke="url(#loginSpin)"/>
            </svg>
            <div class="reg-loader-text">
                <h3 class="reg-loader-title">Accediendo al curso</h3>
                <p class="reg-loader-sub">Esto solo tardará unos segundos.</p>
            </div>
        </div>
    </div>

    <script>
        function togglePwd() {
            var i = document.getElementById('password');
            i.type = i.type === 'password' ? 'text' : 'password';
        }
        // Escala uniforme del login → mismo aspecto en cualquier PC
        (function () {
            function scaleLogin() {
                var stage = document.querySelector('.login-stage');
                if (!stage) return;
                if (window.innerWidth < 1024) { stage.style.transform = ''; return; }
                var s = Math.min(1, window.innerWidth / 1440);
                stage.style.transform = 'scale(' + s + ')';
            }
            window.addEventListener('resize', scaleLogin);
            window.addEventListener('load', scaleLogin);
            if (document.readyState !== 'loading') scaleLogin();
            else document.addEventListener('DOMContentLoaded', scaleLogin);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleLogin);
        })();

        // ===== Loader "Accediendo al curso" al pulsar Ingresar =====
        (function () {
            var form = document.getElementById('login-form');
            var overlay = document.getElementById('login-loader');
            if (!form || !overlay) return;
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                overlay.hidden = false;
                void overlay.offsetWidth;           // reflow → anima la entrada
                overlay.classList.add('is-visible');
                setTimeout(function () { form.submit(); }, 1600);  // muestra el loader y luego envía
            });
        })();
    </script>
</body>
</html>
