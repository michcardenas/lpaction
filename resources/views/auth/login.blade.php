<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body class="login-bg min-h-screen flex flex-col text-[#1b2a31]">

    {{-- Header (dark, sin menú) --}}
    <header class="header-bar text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
            </a>
            <div class="flex items-center gap-4 lg:gap-5">
                <div class="hidden md:flex items-center gap-2.5">
                    <span class="org-text text-white/80">Organizado por:</span>
                    <img src="{{ asset('images/sec-logo.png') }}" alt="Sociedad Española de Cardiología" class="h-9 w-auto">
                </div>
                <a href="{{ route('login') }}" class="btn-acceder">Acceder</a>
            </div>
        </div>
    </header>

    <main class="flex-1 relative overflow-hidden flex justify-center items-start">
        <div class="login-stage">
        {{-- Molecule --}}
        <img class="login-molecule" src="{{ asset('images/molecula-lpa.png') }}" alt="Lp(a)" aria-hidden="true">

        <div class="login-content">
            <h1 class="text-3xl lg:text-[34px] font-semibold mb-7">Ingreso</h1>

            <form action="{{ route('login') }}" method="POST" class="login-card w-full max-w-[790px] p-7 lg:p-9">
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
                <label class="flex items-center gap-2.5 mb-5 cursor-pointer select-none">
                    <input type="checkbox" name="remember"
                           class="w-[18px] h-[18px] rounded-[4px] border border-[#c3ced3] accent-[#05BAEE] cursor-pointer">
                    <span class="text-[14px] text-[#3a4a52]">Recordar usuario y contraseña</span>
                </label>

                {{-- Recuperar --}}
                <a href="#" class="inline-block text-[14px] text-[#3a4a52] hover:text-[#05BAEE] transition-colors mb-7">
                    Recuperar contraseña
                </a>

                {{-- Acciones --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
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
            <div class="flex items-center footer-txt text-white/85">
                <a href="#" class="hover:text-[#05BAEE] transition-colors">Aviso legal</a>
                <span style="display:inline-block; width:1px; height:14px; background:rgba(255,255,255,0.35); margin:0 20px;"></span>
                <a href="#" class="hover:text-[#05BAEE] transition-colors">Política de privacidad</a>
                <span style="display:inline-block; width:1px; height:14px; background:rgba(255,255,255,0.35); margin:0 20px;"></span>
                <a href="#" class="hover:text-[#05BAEE] transition-colors">Política de cookies</a>
            </div>
        </div>
    </footer>

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
    </script>
</body>
</html>
