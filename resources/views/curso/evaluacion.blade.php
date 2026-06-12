<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Evaluación final — Lp(a)ction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @view-transition { navigation: auto; }
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body {
            font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; color: #fff;
            background:
                radial-gradient(ellipse at 70% 40%, #33505b 0%, transparent 55%),
                linear-gradient(160deg, #273a42 0%, #1d2c33 60%, #16242a 100%);
        }

        /* Top bar */
        .ev-top { height: 64px; flex-shrink: 0; display: flex; align-items: center; padding: 0 32px;
                  background: linear-gradient(90deg, #0a0f12 0%, #141d22 100%); }
        .ev-back { display: inline-flex; align-items: center; gap: 8px; color: #cfe6ef; text-decoration: none; font-weight: 500; font-size: 15px; transition: color .2s; }
        .ev-back:hover { color: #fff; }

        /* Contenido con animación de aparición */
        .ev-main { flex: 1; padding: 48px 56px; }
        .ev-stage { max-width: 1320px; margin: 0 auto; animation: evAppear .55s cubic-bezier(.22,.61,.36,1) both; }
        @keyframes evAppear { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

        .ev-title { font-weight: 600; font-size: 38px; line-height: 1.1; margin: 0; }
        .ev-title::after { content: ''; display: block; width: 92px; height: 3px; background: #05BAEE; margin: 14px 0 0; border-radius: 2px; }
        .ev-subtitle { font-weight: 400; font-size: 15px; color: #c2d0d5; margin: 16px 0 36px; }

        .ev-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.16); padding: 32px 36px; max-width: 1010px; }
        .ev-h { font-weight: 600; font-size: 24px; margin: 0 0 8px; }
        .ev-card > .ev-p { font-weight: 400; font-size: 15px; color: #c2d0d5; margin: 0 0 28px; }

        .ev-grid { display: grid; grid-template-columns: 1.75fr 1fr; gap: 22px; align-items: start; }
        .ev-info { background: rgba(0,0,0,0.18); border: 1px solid rgba(255,255,255,0.10); padding: 26px 28px; }
        .ev-info-head { display: flex; align-items: center; gap: 12px; font-weight: 600; font-size: 17px; margin-bottom: 14px; }
        .ev-info p { font-weight: 400; font-size: 15px; line-height: 165%; color: #c8d3d7; margin: 0 0 18px; }
        .ev-saber { font-weight: 600; color: #fff !important; margin: 0 0 10px !important; }
        .ev-list { list-style: none; margin: 0; padding: 0; }
        .ev-list li { position: relative; padding-left: 20px; font-weight: 400; font-size: 15px; line-height: 165%; color: #c8d3d7; }
        .ev-list li::before { content: '•'; position: absolute; left: 5px; color: #c8d3d7; }

        .ev-stats { display: flex; flex-direction: column; gap: 22px; }
        .ev-stat { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12); padding: 22px 26px; }
        .ev-stat-num { font-weight: 700; font-size: 22px; }
        .ev-stat-lbl { font-weight: 400; font-size: 14px; color: #aeb9bd; margin-top: 4px; }

        .ev-foot { display: flex; justify-content: flex-end; margin-top: 40px; }
        .ev-comenzar { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 16px; background: #05BAEE; color: #fff; border: 0; padding: 16px 42px; border-radius: 6px; cursor: pointer; transition: background .2s; }
        .ev-comenzar:hover { background: #04a3d1; }

        @media (max-width: 880px) {
            .ev-main { padding: 28px 22px; }
            .ev-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="ev-top">
        <a href="{{ route('curso') }}" class="ev-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Abandonar examen
        </a>
    </header>

    <main class="ev-main">
        <div class="ev-stage">
            <h1 class="ev-title">Evaluación final</h1>
            <p class="ev-subtitle">Certificación del conocimiento adquirido</p>

            <div class="ev-card">
                <h2 class="ev-h">Has llegado al final del curso</h2>
                <p class="ev-p">Es el momento de poner a prueba lo aprendido y obtener tu certificación.</p>

                <div class="ev-grid">
                    <div class="ev-info">
                        <div class="ev-info-head">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><line x1="12" y1="11" x2="12" y2="16"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            Un momento antes de empezar
                        </div>
                        <p>Has dejado atrás los casos prácticos. Esta evaluación funciona distinto: es obligatoria, puntúa, y de ella depende tu diploma.</p>
                        <p class="ev-saber">Qué necesitas saber:</p>
                        <ul class="ev-list">
                            <li>25 preguntas tipo test, con 4 opciones y una única respuesta correcta</li>
                            <li>Necesitas un 80% de aciertos para superarla</li>
                            <li>Tómate tu tiempo: lee cada enunciado con calma antes de responder</li>
                        </ul>
                    </div>

                    <div class="ev-stats">
                        <div class="ev-stat">
                            <div class="ev-stat-num">{{ $intentos }} / {{ $maxIntentos }}</div>
                            <div class="ev-stat-lbl">Intentos</div>
                        </div>
                        <div class="ev-stat">
                            <div class="ev-stat-num">{{ $nota }}</div>
                            <div class="ev-stat-lbl">Nota</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ev-foot">
                <button type="button" class="ev-comenzar" onclick="return false;">Comenzar evaluación</button>
            </div>
        </div>
    </main>
</body>
</html>
