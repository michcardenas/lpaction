<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recuperar contraseña — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; }
        .pw-bg {
            background:
                radial-gradient(ellipse at 75% 30%, #eaf3f7 0%, transparent 55%),
                linear-gradient(150deg, #f3f7f9 0%, #e6eef3 55%, #dde8ee 100%);
        }
        .pw-card {
            background: #fff; border: 1px solid rgba(120,140,150,.28);
            border-radius: 12px; box-shadow: 0 10px 40px rgba(27,42,49,.08);
        }
        .pw-input {
            font-size: 15px; background:#fff; border:1px solid #d4dde2; border-radius:8px; color:#1b2a31;
            transition: border-color .2s, box-shadow .2s; width:100%;
        }
        .pw-input:focus { outline:none; border-color:#05BAEE; box-shadow:0 0 0 3px rgba(5,186,238,.15); }
        .pw-btn {
            background:#05BAEE; color:#fff; font-weight:600; border-radius:8px; padding:12px 28px;
            transition: background .2s; border:none; cursor:pointer;
        }
        .pw-btn:hover { background:#049fcb; }
        .header-bar { background:#0b2a39; }
        .footer-dark { background:#0b2a39; }
    </style>
</head>
<body class="pw-bg min-h-screen flex flex-col text-[#1b2a31]">

    <header class="header-bar text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
            </a>
            <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" style="height:36px; width:auto; object-fit:contain;">
            <a href="{{ route('login') }}" class="text-[14px] font-medium underline underline-offset-4 hover:text-[#05BAEE] transition-colors">Acceder</a>
        </div>
    </header>

    <main class="flex-1 flex items-start justify-center px-5 py-12 lg:py-20">
        <div class="w-full max-w-[460px]">
            <h1 class="text-2xl lg:text-[28px] font-semibold mb-2">Recuperar contraseña</h1>
            <p class="text-[14px] text-[#5a6a71] mb-6">Introduce tu correo electrónico y te enviaremos un enlace para crear una contraseña nueva.</p>

            <div class="pw-card p-7 lg:p-8">
                @if (session('status'))
                    <div class="mb-5 px-4 py-3 rounded-lg text-[14px]" style="background:rgba(5,186,238,.1); border:1px solid rgba(5,186,238,.4); color:#06758f;">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-lg text-[14px]" style="background:rgba(224,86,75,0.12); border:1px solid rgba(224,86,75,0.4); color:#e0564b;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <label for="email" class="block text-[14px] font-medium mb-2">Correo electrónico</label>
                    <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}"
                           placeholder="tu@correo.com" required class="pw-input px-4 py-3.5 mb-5">

                    <button type="submit" class="pw-btn w-full">Enviar enlace</button>
                </form>

                <p class="text-[14px] text-[#3a4a52] mt-6 text-center">
                    <a href="{{ route('login') }}" class="font-medium underline underline-offset-4 hover:text-[#05BAEE] transition-colors">Volver al inicio de sesión</a>
                </p>
            </div>
        </div>
    </main>

    <footer class="footer-dark text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5 text-center text-[12px] text-white/70">
            © 2026 Sociedad Española de Cardiología. Plataforma tecnológica y metodología por © Qualimed Ediciones S.L.
        </div>
    </footer>

</body>
</html>
