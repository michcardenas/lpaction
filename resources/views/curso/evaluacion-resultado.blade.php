<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la evaluación — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; }
        body {
            font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh; display: flex; flex-direction: column; color: #fff;
            background:
                radial-gradient(ellipse at 70% 20%, #33505b 0%, transparent 55%),
                linear-gradient(160deg, #273a42 0%, #1d2c33 60%, #16242a 100%);
        }
        @php $res = $res ?? []; $apto = $res['apto'] ?? false; @endphp

        /* ===== Nav ===== */
        .rv-nav { height: 64px; flex-shrink: 0; display: flex; align-items: center; justify-content: space-between; padding: 0 40px;
                  background: linear-gradient(90deg, #0a0f12 0%, #141d22 100%); }
        .rv-nav-left { display: flex; align-items: center; gap: 30px; }
        .rv-logo img { height: 26px; width: auto; }
        .rv-links { display: flex; align-items: center; gap: 8px; }
        .rv-link { font-weight: 500; font-size: 15px; color: rgba(255,255,255,0.82); text-decoration: none; padding: 8px 12px; border-radius: 6px; transition: background .2s, color .2s; }
        .rv-link:hover { background: rgba(100,162,196,0.20); }
        .rv-org { display: flex; align-items: center; gap: 10px; }
        .rv-org span { font-weight: 500; font-size: 13px; color: rgba(255,255,255,0.75); }
        .rv-org img { height: 30px; width: auto; }
        @media (max-width: 820px) { .rv-links, .rv-org span { display: none; } }

        /* ===== Contenido ===== */
        .rv-main { flex: 1; padding: 40px clamp(20px, 5vw, 90px) 60px; max-width: 1240px; width: 100%; margin: 0 auto; }
        .rv-title { font-weight: 600; font-size: 38px; line-height: 1.1; margin: 0; }
        .rv-title::after { content: ''; display: block; width: 92px; height: 3px; background: #05BAEE; margin: 14px 0 0; border-radius: 2px; }
        .rv-sub { font-weight: 400; font-size: 15px; color: #c2d0d5; margin: 16px 0 30px; }

        /* Banners resumen */
        .rv-banners { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 30px; }
        .rv-banner { display: flex; align-items: center; gap: 14px; padding: 20px 24px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.14); }
        .rv-banner .ico { flex-shrink: 0; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; }
        .rv-banner.ok .ico { color: #7ed3a0; }
        .rv-banner.info .ico { color: #e6c46a; }
        .rv-banner-txt { font-weight: 500; font-size: 15px; color: #eaf0f2; }
        .rv-banner .estado { margin-left: auto; font-weight: 600; font-size: 15px; }
        .rv-banner .estado.apto { color: #7ed3a0; }
        .rv-banner .estado.no { color: #ff8a7c; }
        @media (max-width: 820px) { .rv-banners { grid-template-columns: 1fr; } }

        /* Tarjeta de pregunta (revisión) */
        .rv-q { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.18); margin-bottom: 24px; overflow: hidden; }
        .rv-q-head { padding: 24px 30px 20px; }
        .rv-q-num { font-weight: 600; font-size: 15px; color: #05BAEE; margin: 0 0 12px; }
        .rv-q-enun { font-weight: 500; font-size: 17px; line-height: 168%; color: #fff; margin: 0; }
        .rv-opts { display: grid; grid-template-columns: 1fr 1fr; border-top: 1px solid rgba(255,255,255,0.12); }
        .rv-opt { display: flex; align-items: flex-start; gap: 15px; padding: 22px 30px; font-weight: 500; font-size: 15px; line-height: 155%; color: #cfd8db; position: relative; }
        .rv-opt:nth-child(odd) { border-right: 1px solid rgba(255,255,255,0.12); }
        .rv-opt:not(:nth-last-child(-n+2)) { border-bottom: 1px solid rgba(255,255,255,0.12); }
        .rv-mark { flex-shrink: 0; width: 22px; height: 22px; margin-top: 1px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.35); position: relative; }
        /* Elegida por el alumno → azul, igual que al seleccionarla durante el examen.
           NO se revela si fue correcta o incorrecta (sin verde ni rojo): solo lo que contestó. */
        .rv-opt.elegida { background: rgba(5,186,238,0.10); color: #eaf0f2; }
        .rv-opt.elegida .rv-mark { border: 0; background: linear-gradient(180deg, #05BAEE 0%, #2F728C 100%); }
        .rv-opt.elegida .rv-mark::after { content: '\2713'; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; font-weight: 800; }
        @media (max-width: 820px) { .rv-opts { grid-template-columns: 1fr; } .rv-opt:nth-child(odd) { border-right: 0; } .rv-opt { border-bottom: 1px solid rgba(255,255,255,0.12); } }

        /* ===== Modal de resultado (sobre la revisión) ===== */
        .rv-modal { position: fixed; inset: 0; z-index: 100; display: flex; align-items: center; justify-content: center; padding: 24px; background: rgba(10,16,19,0.55); backdrop-filter: blur(3px); -webkit-backdrop-filter: blur(3px); }
        .rv-modal[hidden] { display: none; }
        .rv-modal-card {
            width: 100%; max-width: 430px; text-align: center;
            background: linear-gradient(180deg, rgba(58,74,82,0.96) 0%, rgba(40,55,62,0.96) 100%);
            border: 1px solid rgba(255,255,255,0.16); border-radius: 22px; padding: 44px 38px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            -webkit-backdrop-filter: blur(30px); backdrop-filter: blur(30px);
            animation: pop .34s cubic-bezier(.22,.61,.36,1) both;
        }
        @keyframes pop { from { opacity: 0; transform: translateY(16px) scale(.96); } to { opacity: 1; transform: none; } }
        .rv-ico { width: 88px; height: 88px; margin: 0 auto 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .rv-ico.apto { background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.30); color: rgba(255,255,255,0.92); }
        .rv-ico.no   { background: rgba(192,57,43,0.12); border: 2px solid rgba(192,57,43,0.55); color: #ff8a7c; }
        .rv-estado { font-weight: 600; font-size: 25px; margin: 0 0 10px; color: #fff; }
        .rv-nota { font-weight: 500; font-size: 15px; color: #c2d0d5; margin: 0 0 18px; }
        .rv-nota b { font-weight: 600; color: #fff; }
        .rv-msg { font-weight: 400; font-size: 15px; color: #c2d0d5; margin: 0 0 30px; }
        .rv-actions { display: flex; gap: 14px; }
        .rv-actions > * { flex: 1; }
        .rv-btn { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; padding: 14px 20px; border-radius: 8px; border: 0; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; transition: background .2s, color .2s; }
        .rv-btn.light { background: #eef2f3; color: #1a2830; }
        .rv-btn.light:hover { background: #fff; }
        .rv-btn.dark { background: rgba(255,255,255,0.06); color: #fff; border: 1px solid rgba(255,255,255,0.16); }
        .rv-btn.dark:hover { background: rgba(255,255,255,0.12); }
        @media (max-width: 460px) { .rv-actions { flex-direction: column; } }

        /* Pie de la revisión: Finalizar revisión + Completar encuesta */
        .rv-foot { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 36px; flex-wrap: wrap; }
        .rv-foot-btn { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; padding: 15px 30px; border-radius: 8px; border: 0; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; transition: background .2s, color .2s; }
        .rv-foot-btn.ghost { background: rgba(255,255,255,0.06); color: #fff; border: 1px solid rgba(255,255,255,0.16); }
        .rv-foot-btn.ghost:hover { background: rgba(255,255,255,0.12); }
        .rv-foot-btn.cyan { background: #05BAEE; color: #fff; }
        .rv-foot-btn.cyan:hover { background: #04a3d1; }
        @media (max-width: 560px) { .rv-foot { flex-direction: column-reverse; } .rv-foot-btn { width: 100%; } }

        /* ===== Footer ===== */
        .rv-footer { flex-shrink: 0; background: #000; padding: 16px 40px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .rv-footer-txt { font-weight: 500; font-size: 13px; color: #fff; margin: 0; }
        .rv-footer-links { display: flex; align-items: center; gap: 32px; }
        .rv-footer-links a { font-weight: 500; font-size: 13px; color: #fff; text-decoration: none; }
        .rv-footer-links a:hover { color: #05BAEE; }
        @media (max-width: 700px) { .rv-footer { flex-direction: column; text-align: center; gap: 10px; } .rv-footer-links { gap: 16px; flex-wrap: wrap; justify-content: center; } }
    </style>
</head>
<body>
    {{-- Nav --}}
    <header class="rv-nav">
        <div class="rv-nav-left">
            <a href="{{ route('curso') }}" class="rv-logo"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"></a>
            <nav class="rv-links">
                <a href="{{ route('curso') }}" class="rv-link">Inicio</a>
                <a href="{{ route('tutoria') }}" class="rv-link">Tutoría</a>
                <a href="{{ route('autores') }}" class="rv-link">Autores</a>
                <a href="{{ route('perfil') }}" class="rv-link">Perfil</a>
            </nav>
        </div>
        <div class="rv-org">
            <span>Organizado por:</span>
            <img src="{{ asset('images/sec-logo-hd.png') }}" onerror="this.onerror=null;this.src='{{ asset('images/sec-logo.png') }}'" alt="Sociedad Española de Cardiología">
        </div>
    </header>

    {{-- Contenido: revisión de respuestas --}}
    <main class="rv-main">
        <h1 class="rv-title">Resultados de la evaluación</h1>
        <p class="rv-sub">Revisa tu desempeño y el detalle de tus respuestas.</p>

        <div class="rv-banners">
            <div class="rv-banner ok">
                <span class="ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </span>
                <span class="rv-banner-txt">Acierto: {{ $res['aciertos'] ?? 0 }}/{{ $res['total'] ?? 0 }} respuestas ({{ $res['pct'] ?? 0 }}%)</span>
                <span class="estado {{ $apto ? 'apto' : 'no' }}">{{ $apto ? 'Apto' : 'No apto' }}</span>
            </div>
            <div class="rv-banner info">
                <span class="ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </span>
                <span class="rv-banner-txt">Para aprobar la evaluación necesitas un promedio mínimo de acierto del {{ $res['aprobar_pct'] ?? 80 }}%.</span>
            </div>
        </div>

        @foreach (($res['detalle'] ?? []) as $i => $q)
            <div class="rv-q">
                <div class="rv-q-head">
                    <p class="rv-q-num">Pregunta {{ $i + 1 }}/{{ $res['total'] ?? count($res['detalle'] ?? []) }}</p>
                    <p class="rv-q-enun">{{ $q['enunciado'] }}</p>
                </div>
                <div class="rv-opts">
                    @foreach ($q['opciones'] as $letra => $texto)
                        @php
                            // Solo se resalta LA ELEGIDA (azul, como en el examen); no se revela la correcta.
                            $cls = $letra === $q['elegida'] ? 'elegida' : '';
                        @endphp
                        <div class="rv-opt {{ $cls }}">
                            <span class="rv-mark"></span>
                            <span class="rv-opt-txt">{{ $texto }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Pie: solo "Finalizar revisión" en la posición prominente. Se eliminó "Completar encuesta
             de satisfacción" (la encuesta es obligatoria ANTES de la evaluación, no aquí). Petición del cliente. --}}
        <div class="rv-foot" style="justify-content: flex-end;">
            <a href="{{ route('curso') }}" class="rv-foot-btn cyan">Finalizar revisión</a>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="rv-footer">
        <p class="rv-footer-txt">El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. 2026 © Qualimed Ediciones S.L.</p>
        <div class="rv-footer-links">
            <a href="#">Aviso legal</a>
            <a href="#">Política de privacidad</a>
            <a href="#">Política de cookies</a>
        </div>
    </footer>

    {{-- Modal de resultado (aparece encima de la revisión al finalizar) --}}
    @php $intentosRestantes = max(0, ($res['max_intentos'] ?? 2) - ($res['intentos'] ?? 0)); @endphp
    <div class="rv-modal" id="rv-modal">
        <div class="rv-modal-card">
            @if ($apto)
                <div class="rv-ico apto">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <h2 class="rv-estado">Evaluación aprobada</h2>
                <p class="rv-nota">Respuestas correctas: <b>{{ $res['aciertos'] ?? 0 }}/{{ $res['total'] ?? 0 }}</b> · APTO</p>
                <p class="rv-msg">Tu diploma ya está disponible.</p>
                <div class="rv-actions">
                    <button type="button" class="rv-btn dark" onclick="document.getElementById('rv-modal').hidden=true;">Ver respuestas</button>
                    <a href="{{ route('curso') }}" class="rv-btn light">Ir al diploma</a>
                </div>
            @else
                <div class="rv-ico no">
                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </div>
                <h2 class="rv-estado">Evaluación no superada</h2>
                <p class="rv-nota">Respuestas correctas: <b>{{ $res['aciertos'] ?? 0 }}/{{ $res['total'] ?? 0 }}</b> · NO APTA</p>
                <p class="rv-msg">
                    @if ($intentosRestantes > 0)
                        Necesitas un {{ $res['aprobar_pct'] ?? 80 }}%. Te queda{{ $intentosRestantes === 1 ? '' : 'n' }} {{ $intentosRestantes }} intento{{ $intentosRestantes === 1 ? '' : 's' }}.
                    @else
                        Has agotado los intentos disponibles.
                    @endif
                </p>
                <div class="rv-actions">
                    <button type="button" class="rv-btn dark" onclick="document.getElementById('rv-modal').hidden=true;">Ver respuestas</button>
                    @if ($intentosRestantes > 0)
                        <form method="POST" action="{{ route('evaluacion.comenzar') }}" style="margin:0; flex:1;">
                            @csrf
                            <button type="submit" class="rv-btn light" style="width:100%;">Reintentar</button>
                        </form>
                    @else
                        <a href="{{ route('curso') }}" class="rv-btn light">Volver al curso</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
</html>
