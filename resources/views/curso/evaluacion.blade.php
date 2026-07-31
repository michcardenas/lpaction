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

        /* Contenido: escenario fijo escalado a la pantalla (igual que las etapas) + animación */
        .ev-main { flex: 1; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 56px 32px; }
        .ev-stage { width: 1320px; flex-shrink: 0; transform-origin: center center; }
        .ev-inner { animation: evAppear .55s cubic-bezier(.22,.61,.36,1) both; }
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

        .ev-aviso-encuesta { display: flex; align-items: center; gap: 12px; margin-top: 22px; padding: 16px 20px; border-radius: 8px; background: rgba(230,196,106,0.10); border: 1px solid rgba(230,196,106,0.35); color: #f0dda2; font-weight: 500; font-size: 14px; line-height: 150%; }
        .ev-aviso-encuesta svg { flex-shrink: 0; }
        .ev-aviso-encuesta b { color: #fff; font-weight: 600; }
        .ev-foot { display: flex; justify-content: flex-end; margin-top: 28px; }
        .ev-comenzar { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 16px; background: #05BAEE; color: #fff; border: 0; padding: 16px 42px; border-radius: 6px; cursor: pointer; transition: background .2s; }
        .ev-comenzar:hover { background: #04a3d1; }

        /* ===== Móvil y tablet: layout FLUIDO (sin el escenario fijo de 1320px escalado) ===== */
        @media (max-width: 1024px) {
            .ev-main { align-items: flex-start; overflow: visible; padding: 26px 16px 40px; }
            .ev-stage { width: 100% !important; max-width: 660px; margin: 0 auto; transform: none !important; }
            .ev-title { font-size: 28px; }
            .ev-subtitle { margin: 12px 0 26px; }
            .ev-card { padding: 22px 18px; max-width: 100%; }
            .ev-h { font-size: 20px; }
            .ev-grid { grid-template-columns: 1fr; gap: 16px; }
            .ev-info, .ev-stat { padding: 18px 20px; }
            .ev-info-head { font-size: 16px; }
            .ev-foot { display: block; margin-top: 22px; }
            .ev-foot form { margin: 0; }
            .ev-comenzar { display: block; width: 100%; text-align: center; }
        }
        @media (max-width: 560px) {
            .ev-top { padding: 0 16px; }
            .ev-title { font-size: 24px; }
            .ev-h { font-size: 18px; }
            .ev-card { padding: 18px 14px; }
            .ev-info, .ev-stat { padding: 16px; }
        }

        /* Footer (mismo que el resto del sitio) */
        .ev-footer {
            flex-shrink: 0; background: #000000;
            padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
        }
        .ev-footer-txt { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; line-height: 150%; color: #FFFFFF; margin: 0; }
        .ev-footer-links { display: flex; align-items: center; gap: 32px; }
        .ev-footer-links a { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; color: #FFFFFF; text-decoration: none; transition: color .2s; }
        .ev-footer-links a:hover { color: #05BAEE; }
        @media (max-width: 700px) {
            .ev-footer { flex-direction: column; text-align: center; gap: 10px; padding: 16px; }
            .ev-footer-links { gap: 16px; flex-wrap: wrap; justify-content: center; }
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
            <div class="ev-inner">
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
                            <li>10 preguntas tipo test, con 4 opciones y una única respuesta correcta</li>
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

            @unless ($encuestaHecha ?? false)
                {{-- La encuesta de satisfacción es obligatoria antes de la evaluación --}}
                <div class="ev-aviso-encuesta">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="13"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Para comenzar la evaluación primero debes completar la <b>encuesta de satisfacción</b>.</span>
                </div>
            @endunless

            <div class="ev-foot">
                @if (! ($encuestaHecha ?? false))
                    <a href="{{ route('encuesta') }}" class="ev-comenzar" style="text-decoration:none;">Completar encuesta de satisfacción</a>
                @elseif (($intentos ?? 0) >= ($maxIntentos ?? 2) && empty($apto))
                    <button type="button" class="ev-comenzar" disabled style="opacity:.5;cursor:not-allowed;">Sin intentos disponibles</button>
                @elseif (! empty($apto))
                    <a href="{{ route('curso') }}" class="ev-comenzar" style="text-decoration:none;">Volver al curso (APTO)</a>
                @else
                    <form method="POST" action="{{ route('evaluacion.comenzar') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="ev-comenzar">Comenzar evaluación</button>
                    </form>
                @endif
            </div>
            </div>{{-- /ev-inner --}}
        </div>
    </main>

    {{-- Footer (mismo que el resto del sitio) --}}
    <footer class="ev-footer">
        <p class="ev-footer-txt">El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. 2026 © Qualimed Ediciones S.L.</p>
        <div class="ev-footer-links">
            <a href="#">Aviso legal</a>
            <a href="#">Política de privacidad</a>
            <a href="#">Política de cookies</a>
        </div>
    </footer>

    <script>
        // Escala el contenido para que se vea igual y llene la pantalla en cualquier PC (como las etapas).
        (function () {
            var main = document.querySelector('.ev-main');
            var stage = document.querySelector('.ev-stage');
            if (!main || !stage) return;
            function scaleEv() {
                stage.style.transform = 'none';
                if (window.innerWidth <= 1024) return;   // móvil/tablet: layout fluido, no se escala
                var sw = stage.offsetWidth, sh = stage.offsetHeight;
                if (!main.clientWidth || !sw) { requestAnimationFrame(scaleEv); return; }
                // Descontar el padding del main para que el contenido NO llene los bordes
                // (así queda aire entre el título/botón y el topbar/footer).
                var cs = getComputedStyle(main);
                var padX = parseFloat(cs.paddingLeft) + parseFloat(cs.paddingRight);
                var padY = parseFloat(cs.paddingTop) + parseFloat(cs.paddingBottom);
                var availW = main.clientWidth - padX;
                var availH = main.clientHeight - padY;
                var s = Math.min(availW / sw, availH / sh);
                s = Math.min(Math.max(s, 0.4), 1.7);
                stage.style.transform = 'scale(' + s + ')';
            }
            setTimeout(scaleEv, 60);
            window.addEventListener('resize', scaleEv);
            window.addEventListener('load', scaleEv);
            if (document.readyState !== 'loading') scaleEv();
            else document.addEventListener('DOMContentLoaded', scaleEv);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleEv);
        })();
    </script>
</body>
</html>
