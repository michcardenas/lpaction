<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --navy:#0b2a39; --cyan:#05BAEE; --ink:#1b2a31; --muted:#5a6a71; }
        body { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; color: var(--ink); background: #f3f7f9; }
        .lg-header { background: var(--navy); }
        .lg-footer { background: var(--navy); }
        .lg-wrap { max-width: 860px; margin: 0 auto; padding: 40px 20px 64px; }
        .lg-card { background:#fff; border:1px solid rgba(120,140,150,.22); border-radius:14px;
                   box-shadow:0 10px 40px rgba(27,42,49,.06); padding: 40px 44px; }
        .lg-card h1 { font-size: 30px; font-weight: 700; color: var(--navy); margin-bottom: 6px; line-height:1.2; }
        .lg-sub { font-size: 13.5px; color: var(--muted); margin-bottom: 28px; }
        .lg-card h2 { font-size: 20px; font-weight: 700; color: var(--navy); margin: 30px 0 12px; }
        .lg-card h3 { font-size: 16px; font-weight: 600; color: var(--navy); margin: 22px 0 8px; }
        .lg-card p { font-size: 15px; line-height: 1.7; margin-bottom: 14px; color: #2a3a41; }
        .lg-card ul { margin: 0 0 16px 22px; }
        .lg-card li { font-size: 15px; line-height: 1.7; margin-bottom: 8px; color: #2a3a41; }
        .lg-card a { color: var(--cyan); text-decoration: none; }
        .lg-card a:hover { text-decoration: underline; }
        .lg-card strong { color: var(--ink); }
        .lg-note { background: rgba(5,186,238,.07); border:1px solid rgba(5,186,238,.3); border-radius:10px;
                   padding:14px 18px; font-size:14px; color:#0a5a70; margin: 0 0 24px; }
        .lg-back { display:inline-block; margin-top: 10px; font-size:14px; }
        @media (max-width: 640px) { .lg-card { padding: 26px 20px; } .lg-card h1 { font-size: 24px; } }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <header class="lg-header text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                <img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction" class="h-7 w-auto">
            </a>
            <img src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología" style="height:34px; width:auto; object-fit:contain;">
            <a href="{{ route('login') }}" class="text-[14px] font-medium underline underline-offset-4 hover:text-[#05BAEE] transition-colors">Acceder</a>
        </div>
    </header>

    <main class="flex-1">
        <div class="lg-wrap">
            <div class="lg-card">
                @yield('contenido')
                <a href="{{ route('home') }}" class="lg-back">← Volver al inicio</a>
            </div>
        </div>
    </main>

    <footer class="lg-footer text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-[12px] text-white/70 text-center md:text-left">
                © 2026 Sociedad Española de Cardiología. Plataforma tecnológica y metodología por © Qualimed Ediciones S.L.
            </p>
            <div class="flex items-center gap-5 text-[12px] text-white/85">
                <a href="{{ route('aviso.legal') }}" class="hover:text-[#05BAEE] transition-colors">Aviso legal</a>
                <a href="{{ route('politica.privacidad') }}" class="hover:text-[#05BAEE] transition-colors">Política de privacidad</a>
                <a href="{{ route('politica.cookies') }}" class="hover:text-[#05BAEE] transition-colors">Política de cookies</a>
            </div>
        </div>
    </footer>

</body>
</html>
