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
    <title>Registro — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @view-transition { navigation: auto; }
        body { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; }
        .login-bg {
            background:
                radial-gradient(ellipse at 78% 35%, #eaf3f7 0%, transparent 55%),
                linear-gradient(150deg, #f3f7f9 0%, #e6eef3 55%, #dde8ee 100%);
        }
        /* Stage con escala → el formulario completo siempre visible en PC */
        .reg-stage { position: relative; width: 1320px; transform-origin: center center; }
        @media (max-width: 1023px) {
            .reg-stage { width: 100%; transform: none !important; }
            .reg-scale-outer { height: auto !important; }
        }
        .reg-molecule {
            position: absolute; right: -4%; top: 46%; transform: translateY(-50%);
            width: min(38vw, 540px); pointer-events: none; user-select: none; z-index: 0;
        }
        .reg-card {
            background: rgba(0, 0, 0, 0.05);              /* #0000000D */
            border: 1px solid rgba(0, 0, 0, 0.10);        /* #0000001A */
            border-radius: 10px;
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        }
        .login-input {
            font-family: 'Montserrat', sans-serif; font-size: 14px;
            background: #ffffff; border: 1px solid #d4dde2; border-radius: 8px; color: #1b2a31;
            transition: border-color .2s, box-shadow .2s;
        }
        .login-input::placeholder { color: #9aa7ad; }
        .login-input:focus { outline: none; border-color: #05BAEE; box-shadow: 0 0 0 3px rgba(5,186,238,.15); }
        .login-label { font-weight: 600; font-size: 14px; color: #1b2a31; }
        .req { color: #e0564b; }
        .sec-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 16px; line-height: 150%; letter-spacing: 0; color: #2F728C; }
        .btn-primary {
            font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px;
            background: #05BAEE; color: #fff; padding: 12px 30px; border-radius: 8px; transition: background .2s;
        }
        .btn-primary:hover { background: #04a3d1; }
        .link-cyan { color: #05BAEE; }
        /* radios tipo de centro */
        .center-opt { border: 1px solid #d4dde2; border-radius: 8px; background: #fff; cursor: pointer; transition: border-color .2s, background .2s; }
        .center-opt:has(input:checked) { border-color: #05BAEE; background: #f2fbfe; }
        .center-dot { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #b9c5cb; flex-shrink: 0; transition: .2s; }
        .center-opt:has(input:checked) .center-dot { border-color: #05BAEE; box-shadow: inset 0 0 0 3px #05BAEE, inset 0 0 0 4px #fff; }
        /* radio cards perfil */
        .perfil-card { border: 1px solid #d4dde2; border-radius: 8px; background: #fff; cursor: pointer; transition: border-color .2s, background .2s; }
        .perfil-card:has(input:checked) { border-color: #6fb33f; background: #f0f8e9; }
        .perfil-dot { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #b9c5cb; flex-shrink: 0; transition: .2s; }
        .perfil-card:has(input:checked) .perfil-dot { border-color: #6fb33f; background: #6fb33f; box-shadow: inset 0 0 0 3px #fff; }
        /* header / footer */
        .header-bar { background: linear-gradient(90deg, #060606 0%, #181818 50%, #060606 100%); }
        .footer-dark { background: linear-gradient(90deg, #080808 0%, #1a1a1a 50%, #080808 100%); }
        .org-text { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 12px; letter-spacing: .01em; }
        .btn-acceder { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; letter-spacing: .01em; background: #05BAEE; color: #fff; padding: 9px 24px; border-radius: 7px; transition: background .2s; white-space: nowrap; }
        .btn-acceder:hover { background: #04a3d1; }
        .footer-txt { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 12px; line-height: 150%; letter-spacing: .01em; }
        .field-error { color: #e0564b; font-size: 12px; margin-top: 4px; }
        /* ===== Loader / overlay al registrarse ===== */
        .reg-loader-overlay {
            position: fixed; inset: 0; z-index: 200;
            display: flex; align-items: center; justify-content: center;
            background: rgba(26, 38, 44, 0.55);
            opacity: 0; transition: opacity .35s ease;
        }
        .reg-loader-overlay[hidden] { display: none; }
        .reg-loader-overlay.is-visible { opacity: 1; }
        .reg-loader-card {
            width: 540px; height: 442px;
            padding: 64px 32px;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 64px;
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.10);        /* #FFFFFF1A */
            border: 1px solid rgba(255, 255, 255, 0.40);  /* #FFFFFF66 */
            backdrop-filter: blur(40px); -webkit-backdrop-filter: blur(40px);
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.28);
            transform: scale(0.94); transition: transform .45s cubic-bezier(.2, .8, .2, 1);
            text-align: center;
        }
        .reg-loader-overlay.is-visible .reg-loader-card { transform: scale(1); }
        .reg-spinner { width: 160px; height: 160px; animation: reg-spin 1.1s linear infinite; }
        .reg-spin-track { fill: none; stroke: rgba(255, 255, 255, 0.16); stroke-width: 1.6; }
        .reg-spin-arc { fill: none; stroke-width: 1.6; stroke-linecap: round; stroke-dasharray: 46 180; }
        @keyframes reg-spin { to { transform: rotate(360deg); } }
        .reg-loader-text { transition: opacity .3s ease; }
        .reg-loader-text.is-dissolving { opacity: 0; }
        .reg-loader-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 24px; color: #fff; margin: 0 0 14px; }
        .reg-loader-sub { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px; line-height: 150%; color: rgba(255, 255, 255, 0.78); margin: 0 auto; max-width: 380px; }

        /* ── Nav superior fijo (spec Figma móvil): 64px · padding 16 · space-between
              · borde inf 0.5px #BFBFBF · glass (radial blanco + blur 40) ── */
        @media (max-width: 767px) {
            .reg-nav {
                position: sticky; top: 0; z-index: 50;
                height: 64px;
                /* glass oscuro: base + radial blanco (spec white 25–50%, atenuado para verse como el Figma) + blur 40 */
                background: radial-gradient(120% 190% at 80% 0%, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0.04) 55%, transparent 100%), #0a0a0c;
                -webkit-backdrop-filter: blur(40px);
                backdrop-filter: blur(40px);
                border-bottom: 0.5px solid #BFBFBF;
            }
            .reg-nav-inner {
                max-width: 100% !important;
                padding-left: 16px !important; padding-right: 16px !important;
                height: 64px !important;
            }
            .reg-nav-sec { height: 36px !important; }
            .reg-nav-btn {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 500 !important; font-size: 12px !important; letter-spacing: 0.01em !important; line-height: 150% !important;
                color: #FFFFFF !important; background: #05BAEE !important;
                padding: 12px 16px !important; border-radius: 4px !important; text-decoration: none !important;
            }

            /* ── Cuerpo del registro en móvil: la página scrollea + form a 358 (Fill) ── */
            body.login-bg { height: auto !important; min-height: 100vh; }
            main.reg-scale-outer {
                overflow: visible !important; height: auto !important;
                display: block !important;
            }
            /* Imagen de fondo (molécula bg removido): 358×321 · drop shadow 0 4 4 #000 50%
               · FIJA al fondo (no scrollea con el form) */
            .reg-molecule {
                display: block !important;
                position: fixed !important;
                left: 50% !important; right: auto !important;
                transform: translateX(-50%) !important;
                top: 150px !important;
                width: 358px !important; height: 321px !important;
                object-fit: contain !important;
                filter: drop-shadow(0 4px 4px rgba(0,0,0,0.50)) !important;
                z-index: 0 !important;
            }
            .reg-stage > div {
                padding-left: 16px !important; padding-right: 16px !important;
            }
            /* Form card (spec Figma): Fill 358 · padding 16 · gap 16 · bg #000 5% · borde 1px #000 10% · blur 12.
               El .reg-card ya trae bg/borde/blur que coinciden → solo fijo ancho, padding y gap. */
            #reg-form.reg-card {
                max-width: 100% !important; width: 100% !important;
                padding: 16px !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 16px !important;
            }
            #reg-form.reg-card > * { margin: 0 !important; }   /* gap 16 entre bloques */
            /* Label de campo: "texto" + "*" con gap ~8 (el span .req + el espacio existente) */
            .login-label .req { margin-left: 4px; }
            /* Bloque (spec Figma): vertical · gap 8 (título↔campos · campo↔campo) · 326 ancho */
            .reg-block { display: flex !important; flex-direction: column !important; gap: 8px !important; }
            .reg-block > * { margin: 0 !important; }
            #reg-form .grid { gap: 8px !important; }            /* campos dentro de cada grid a 8 */
            /* Título "Registro": Montserrat SemiBold 22 / 140% / ls0 / #111111 */
            .reg-title {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 600 !important;
                font-size: 22px !important;
                line-height: 140% !important;
                letter-spacing: 0 !important;
                color: #111111 !important;
            }

            /* ── Footer registro móvil: copyright centrado (2 líneas) + links 1 fila + divisor ── */
            .footer-dark .max-w-7xl {
                padding-left: 16px !important; padding-right: 16px !important;
                gap: 14px !important;
            }
            .footer-dark p.footer-txt { text-align: center !important; }
            .reg-footer-links {
                width: 100% !important;
                justify-content: center !important;
                flex-wrap: nowrap !important;
                border-top: 0.5px solid rgba(255,255,255,0.18);
                padding-top: 14px;
            }
            .reg-footer-links a { white-space: nowrap !important; }
            .reg-footer-links span { margin: 0 8px !important; }   /* separadores más pegados → caben en 1 fila */

            /* ── Modal loader "Registro completado" (spec Figma): 358 · Hug 308 · radius 32 · borde 1px #FFF40
                  · padding 32/16/16/16 · gap 32 · bg #FFF10 · blur 40 · spinner 139 · texto gap 16 ── */
            .reg-loader-card {
                width: 358px !important;
                height: auto !important; min-height: 0 !important;
                padding: 32px 16px 16px !important;
                gap: 32px !important;
            }
            .reg-spinner { width: 139px !important; height: 139px !important; }
            /* Título modal: Montserrat SemiBold 22 / 140% / ls0 / blanco · gap 16 al subtítulo */
            .reg-loader-title {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 600 !important;
                font-size: 22px !important;
                line-height: 140% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
                margin: 0 0 16px !important;
            }
            /* Subtítulo modal: Montserrat Regular 14 / 150% / ls0 / blanco / 326 */
            .reg-loader-sub {
                font-family: 'Montserrat', sans-serif !important;
                font-weight: 400 !important;
                font-size: 14px !important;
                line-height: 150% !important;
                letter-spacing: 0 !important;
                color: #FFFFFF !important;
                width: 326px !important; max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="login-bg h-screen flex flex-col text-[#1b2a31]">

    {{-- Header / Nav superior fijo (spec Figma móvil) --}}
    <header class="reg-nav header-bar text-white">
        <div class="reg-nav-inner max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            {{-- Logo Lp(a)ction (izq) --}}
            <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
            </a>
            {{-- Logo SEC (centro en móvil) --}}
            <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" class="reg-nav-sec" style="height:36px; width:auto; object-fit:contain;">
            {{-- Acceder (der) --}}
            <a href="{{ route('login') }}" class="btn-acceder reg-nav-btn">Acceder</a>
        </div>
    </header>

    <main class="flex-1 min-h-0 relative overflow-hidden flex justify-center items-center reg-scale-outer">
        <img class="reg-molecule" src="{{ asset('images/molecula-lpa.png') }}" alt="Lp(a)" aria-hidden="true">

        <div class="reg-stage">
        <div class="relative z-10 px-6 lg:px-10 pt-6 lg:pt-7 pb-6">
            <h1 class="reg-title text-3xl lg:text-[32px] font-semibold mb-3">Registro</h1>

            <form id="reg-form" action="{{ route('register') }}" method="POST" class="reg-card p-4" style="max-width:1284px;">
                @csrf

                {{-- 1. Datos personales (bloque · gap 8) --}}
                <div class="reg-block">
                <h2 class="sec-title mb-3">1. Datos personales</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-3 mb-3">
                    <div>
                        <label class="login-label block mb-1">Nombre <span class="req">*</span></label>
                        <input name="name" value="{{ old('name') }}" placeholder="Ej: María" class="login-input w-full px-4 py-2">
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Apellidos <span class="req">*</span></label>
                        <input name="last_name" value="{{ old('last_name') }}" placeholder="Ej: García López" class="login-input w-full px-4 py-2">
                        @error('last_name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Documento de identificación (DNI/NIE) <span class="req">*</span></label>
                        <input name="document_id" value="{{ old('document_id') }}" placeholder="Ej: 12345678A" class="login-input w-full px-4 py-2">
                        @error('document_id')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">País <span class="req">*</span></label>
                        <select name="country" class="login-input w-full px-4 py-2 appearance-none">
                            <option value="" {{ old('country') ? '' : 'selected' }} disabled>Selecciona tu país</option>
                            @foreach (['España','Andorra','Portugal','Francia','Italia','México','Colombia','Argentina','Chile'] as $c)
                                <option value="{{ $c }}" {{ old('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        @error('country')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Provincia <span class="req">*</span></label>
                        <input name="province" value="{{ old('province') }}" placeholder="Ej: Madrid" class="login-input w-full px-4 py-2">
                        @error('province')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Población <span class="req">*</span></label>
                        <input name="city" value="{{ old('city') }}" placeholder="Ej: Alcobendas" class="login-input w-full px-4 py-2">
                        @error('city')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-4 gap-y-3">
                    <div>
                        <label class="login-label block mb-1">Correo electrónico <span class="req">*</span></label>
                        <input name="email" type="email" value="{{ old('email') }}" placeholder="Ej: correo@ejemplo.com" class="login-input w-full px-4 py-2">
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Repetir correo electrónico <span class="req">*</span></label>
                        <input name="email_confirmation" type="email" placeholder="Repite tu correo" class="login-input w-full px-4 py-2">
                    </div>
                    <div>
                        <label class="login-label block mb-1">Contraseña <span class="req">*</span></label>
                        <input name="password" type="password" placeholder="Mínimo 8 caracteres" class="login-input w-full px-4 py-2">
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Repetir contraseña <span class="req">*</span></label>
                        <input name="password_confirmation" type="password" placeholder="Repite tu contraseña" class="login-input w-full px-4 py-2">
                    </div>
                </div>
                </div>{{-- /bloque Datos personales --}}

                {{-- 2. Datos profesionales --}}
                <h2 class="sec-title mt-4 mb-3">2. Datos profesionales</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                    <div>
                        <label class="login-label block mb-1">Especialidad <span class="req">*</span></label>
                        <select name="specialty" class="login-input w-full px-4 py-2 appearance-none">
                            <option value="" {{ old('specialty') ? '' : 'selected' }} disabled>Selecciona tu especialidad</option>
                            @foreach (['Cardiología','Medicina Interna','Medicina Familiar y Comunitaria','Endocrinología','Nefrología','Neurología','Medicina Intensiva','Otra'] as $s)
                                <option value="{{ $s }}" {{ old('specialty') === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('specialty')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="login-label block mb-1">Hospital <span class="req">*</span></label>
                        <input name="hospital" value="{{ old('hospital') }}" placeholder="Empieza a escribir el nombre" class="login-input w-full px-4 py-2">
                        @error('hospital')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 mt-3">
                    <span class="login-label">Tipo de centro <span class="req">*</span></span>
                    @foreach (['privado' => 'Centro Privado', 'publico' => 'Centro público', 'ambos' => 'Ambos'] as $val => $lbl)
                        <label class="center-opt inline-flex items-center gap-2.5 px-4 py-2.5">
                            <input type="radio" name="center_type" value="{{ $val }}" class="sr-only" {{ old('center_type') === $val ? 'checked' : '' }}>
                            <span class="center-dot"></span>
                            <span class="text-[14px]">{{ $lbl }}</span>
                        </label>
                    @endforeach
                </div>
                @error('center_type')<p class="field-error">{{ $message }}</p>@enderror

                {{-- 3. Perfil profesional --}}
                <h2 class="sec-title mt-4 mb-1.5">3. Perfil profesional</h2>
                <p class="text-[13px] text-[#56666d] mb-4 max-w-4xl">Selecciona la opción que mejor describe el momento actual en la práctica clínica. Esta información permite un análisis formativo más preciso de la actividad.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @php $perfiles = [
                        '0-7'  => ['0-7 años', 'Inicio/consolidación en la práctica como especialista'],
                        '8-15' => ['8-15 años', 'Práctica consolidada y toma de decisiones habitual'],
                        '16+'  => ['≥16 años', 'Trayectoria senior y manejo de escenarios complejos'],
                    ]; @endphp
                    @foreach ($perfiles as $val => $p)
                        <label class="perfil-card flex items-start gap-3 p-3">
                            <input type="radio" name="experience_level" value="{{ $val }}" class="sr-only mt-0.5" {{ old('experience_level') === $val ? 'checked' : '' }}>
                            <span class="perfil-dot mt-0.5"></span>
                            <span>
                                <span class="block font-semibold text-[15px]">{{ $p[0] }}</span>
                                <span class="block text-[13px] text-[#56666d] leading-snug mt-0.5">{{ $p[1] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('experience_level')<p class="field-error">{{ $message }}</p>@enderror

                {{-- Consentimientos --}}
                <label class="flex items-start gap-3 mt-4 cursor-pointer">
                    <input type="checkbox" name="accepted_privacy" value="1" {{ old('accepted_privacy') ? 'checked' : '' }}
                           class="w-[18px] h-[18px] mt-0.5 rounded-[4px] border border-[#c3ced3] accent-[#05BAEE] cursor-pointer shrink-0">
                    <span class="text-[14px] text-[#3a4a52]">He leído y acepto política de privacidad y aviso legal</span>
                </label>
                @error('accepted_privacy')<p class="field-error">{{ $message }}</p>@enderror

                <label class="flex items-start gap-3 mt-2.5 cursor-pointer">
                    <input type="checkbox" name="accepted_novartis" value="1" {{ old('accepted_novartis') ? 'checked' : '' }}
                           class="w-[18px] h-[18px] mt-0.5 rounded-[4px] border border-[#c3ced3] accent-[#05BAEE] cursor-pointer shrink-0">
                    <span class="text-[13px] text-[#3a4a52] leading-snug">Acepto que mis datos y los datos generados en esta página web sean facilitados a Novartis Farmacéutica, S.A., para el envío de correos electrónicos individuales. El contenido de los correos electrónicos podrá ser sobre productos y/o servicios, y/o actividades y/o eventos y/o noticias prestados, organizados y/o relativos a Novartis.</span>
                </label>

                {{-- Acciones --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-5">
                    <button type="submit" class="btn-primary self-start">Registrarse</button>
                    <p class="text-[14px] text-[#3a4a52]">
                        Tengo cuenta.
                        <a href="{{ route('login') }}" class="link-cyan font-medium underline underline-offset-4 ml-1">Ingresar a mi cuenta</a>
                    </p>
                </div>
            </form>
        </div>
        </div>{{-- /reg-stage --}}
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

    {{-- Loader / overlay que aparece al pulsar "Registrarse" --}}
    <div id="reg-loader" class="reg-loader-overlay" hidden>
        <div class="reg-loader-card">
            <svg class="reg-spinner" viewBox="0 0 50 50" aria-hidden="true">
                <defs>
                    <linearGradient id="regSpin" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#05BAEE" stop-opacity="0"/>
                        <stop offset="60%" stop-color="#05BAEE" stop-opacity=".5"/>
                        <stop offset="100%" stop-color="#05BAEE" stop-opacity="1"/>
                    </linearGradient>
                </defs>
                <circle class="reg-spin-track" cx="25" cy="25" r="20"/>
                <circle class="reg-spin-arc" cx="25" cy="25" r="20" stroke="url(#regSpin)"/>
            </svg>
            <div class="reg-loader-text" id="loaderText">
                <h3 class="reg-loader-title" id="loaderTitle">Registro completado</h3>
                <p class="reg-loader-sub" id="loaderSub">Estamos preparando tu aula virtual. En unos segundos podrás acceder al curso.</p>
            </div>
        </div>
    </div>

    <script>
        // Escala el formulario para que se vea completo en cualquier PC (ajusta a ancho y alto)
        (function () {
            function scaleReg() {
                var stage = document.querySelector('.reg-stage');
                if (!stage) return;
                if (window.innerWidth < 1024) { stage.style.transform = ''; return; }
                var designW = 1320;
                var availH = window.innerHeight - 64 - 56 - 18; // header + footer + margen
                var naturalH = stage.offsetHeight; // alto real sin escalar
                // Escala para LLENAR el espacio disponible igual en cualquier PC (sin cap en 1).
                var s = Math.min(window.innerWidth / designW, availH / naturalH);
                s = Math.min(s, 1.25); // tope para que no se agrande de más en pantallas muy altas
                stage.style.transform = 'scale(' + s + ')';
            }
            window.addEventListener('resize', scaleReg);
            window.addEventListener('load', scaleReg);
            if (document.readyState !== 'loading') scaleReg();
            else document.addEventListener('DOMContentLoaded', scaleReg);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleReg);
        })();

        // ===== Secuencia del loader al pulsar "Registrarse" =====
        (function () {
            var form = document.getElementById('reg-form');
            var overlay = document.getElementById('reg-loader');
            if (!form || !overlay) return;
            var titleEl = document.getElementById('loaderTitle');
            var subEl = document.getElementById('loaderSub');
            var textWrap = document.getElementById('loaderText');

            var DELAY_TO_STATE2 = 4800; // ms — delay del spec de Figma
            var DISSOLVE = 600;          // ms — duración del dissolve
            var STATE2_HOLD = 2200;      // ms que se muestra "Accediendo al curso" antes de entrar

            // Campos que validamos en el cliente
            var email  = form.querySelector('[name="email"]');
            var emailC = form.querySelector('[name="email_confirmation"]');
            var pwd    = form.querySelector('[name="password"]');
            var pwdC   = form.querySelector('[name="password_confirmation"]');

            // IMPORTANTE: limpiar el mensaje de error en cuanto el usuario edita los campos.
            // Si no, el navegador deja el error "pegado" y bloquea el siguiente envío
            // (revalida ANTES de disparar 'submit', así que nuestro código no llega a limpiarlo).
            function clearEmailValidity() { if (emailC) emailC.setCustomValidity(''); }
            function clearPwdValidity()   { if (pwdC) pwdC.setCustomValidity(''); }
            if (email)  email.addEventListener('input', clearEmailValidity);
            if (emailC) emailC.addEventListener('input', clearEmailValidity);
            if (pwd)    pwd.addEventListener('input', clearPwdValidity);
            if (pwdC)   pwdC.addEventListener('input', clearPwdValidity);

            form.addEventListener('submit', function (e) {
                if (emailC) emailC.setCustomValidity('');
                if (pwdC) pwdC.setCustomValidity('');
                if (email && emailC && email.value !== emailC.value) {
                    e.preventDefault();
                    emailC.setCustomValidity('Los correos electrónicos no coinciden.');
                    emailC.reportValidity();
                    return;
                }
                if (pwd && pwdC && pwd.value !== pwdC.value) {
                    e.preventDefault();
                    pwdC.setCustomValidity('Las contraseñas no coinciden.');
                    pwdC.reportValidity();
                    return;
                }
                // Todo OK → mostrar el loader y enviar el formulario real al final
                e.preventDefault();
                runLoader();
            });

            function runLoader() {
                overlay.hidden = false;
                void overlay.offsetWidth; // reflow para que anime la entrada
                overlay.classList.add('is-visible');

                // Estado 2 con dissolve (a los 4800 ms)
                setTimeout(function () {
                    textWrap.classList.add('is-dissolving');
                    setTimeout(function () {
                        titleEl.textContent = 'Accediendo al curso';
                        subEl.textContent = 'Esto solo tardará unos segundos.';
                        textWrap.classList.remove('is-dissolving');
                    }, DISSOLVE / 2);
                }, DELAY_TO_STATE2);

                // Entrar al curso → envío real del formulario (crea el usuario y redirige)
                setTimeout(function () {
                    HTMLFormElement.prototype.submit.call(form);
                }, DELAY_TO_STATE2 + STATE2_HOLD);
            }
        })();
    </script>
</body>
</html>
