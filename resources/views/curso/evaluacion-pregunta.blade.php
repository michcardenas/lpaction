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
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body {
            font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; color: #fff;
            background:
                radial-gradient(ellipse at 70% 40%, #33505b 0%, transparent 55%),
                linear-gradient(160deg, #273a42 0%, #1d2c33 60%, #16242a 100%);
        }
        .ev-top { height: 64px; flex-shrink: 0; display: flex; align-items: center; padding: 0 32px;
                  background: linear-gradient(90deg, #0a0f12 0%, #141d22 100%); }
        .ev-back { display: inline-flex; align-items: center; gap: 8px; color: #cfe6ef; text-decoration: none; font-weight: 500; font-size: 15px; transition: color .2s; }
        .ev-back:hover { color: #fff; }

        .ev-main { flex: 1; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 40px 32px; }
        .ev-stage { width: 1320px; flex-shrink: 0; transform-origin: center center; }
        .ev-inner { animation: evAppear .4s cubic-bezier(.22,.61,.36,1) both; }
        @keyframes evAppear { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        .ev-title { font-weight: 600; font-size: 38px; line-height: 1.1; margin: 0; }
        .ev-title::after { content: ''; display: block; width: 92px; height: 3px; background: #05BAEE; margin: 14px 0 0; border-radius: 2px; }
        .ev-subtitle { font-weight: 400; font-size: 15px; color: #c2d0d5; margin: 16px 0 34px; }

        /* Tarjeta de pregunta — mismo estilo del cuestionario de las etapas */
        .pregunta-card { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.30); overflow: hidden; }
        .pregunta-head { padding: 26px 32px 22px; }
        .pregunta-num { font-weight: 600; font-size: 15px; color: #05BAEE; margin: 0 0 12px; }
        .pregunta-q { font-weight: 500; font-size: 18px; line-height: 170%; letter-spacing: 0.01em; color: #fff; margin: 0; }

        .pregunta-opts { display: grid; grid-template-columns: 1fr 1fr; border-top: 1px solid rgba(255,255,255,0.14); }
        .opt { display: flex; align-items: flex-start; gap: 16px; padding: 24px 32px; font-weight: 500; font-size: 15px; line-height: 155%; letter-spacing: 0.01em; color: #eaf0f2; cursor: pointer; position: relative; overflow: hidden; transition: background .18s; }
        .opt:hover { background: rgba(255,255,255,0.04); }
        .opt:has(input:checked) { background: rgba(5,186,238,0.10); }
        .opt:nth-child(odd) { border-right: 1px solid rgba(255,255,255,0.14); }
        .opt:not(:nth-last-child(-n+2)) { border-bottom: 1px solid rgba(255,255,255,0.14); }
        .opt input { display: none; }
        .opt-mark { flex-shrink: 0; width: 22px; height: 22px; margin-top: 1px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.45); position: relative; transition: border-color .15s, background .15s; }
        .opt input:checked + .opt-mark { border: 0; background: linear-gradient(180deg, #05BAEE 0%, #2F728C 100%); }
        .opt input:checked + .opt-mark::after { content: '\2713'; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; font-weight: 800; }

        .pregunta-foot { display: flex; align-items: center; justify-content: flex-end; padding: 18px 32px; border-top: 1px solid rgba(255,255,255,0.14); }
        .btn-next-q {
            font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px;
            background: rgba(255,255,255,0.10); color: rgba(255,255,255,0.55);
            border: 0; padding: 14px 30px; border-radius: 6px; cursor: not-allowed; transition: background .2s, color .2s;
        }
        .btn-next-q.enabled { background: #05BAEE; color: #fff; cursor: pointer; }
        .btn-next-q.enabled:hover { background: #04a3d1; }

        /* Footer */
        .ev-footer { flex-shrink: 0; background: #000; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .ev-footer-txt { font-weight: 500; font-size: 13px; color: #fff; margin: 0; }
        .ev-footer-links { display: flex; align-items: center; gap: 32px; }
        .ev-footer-links a { font-weight: 500; font-size: 13px; color: #fff; text-decoration: none; transition: color .2s; }
        .ev-footer-links a:hover { color: #05BAEE; }

        /* ===== Móvil y tablet: layout FLUIDO (sin el escenario fijo de 1320px escalado) ===== */
        @media (max-width: 1024px) {
            .ev-main { align-items: flex-start; overflow: visible; padding: 26px 16px 40px; }
            .ev-stage { width: 100% !important; max-width: 660px; margin: 0 auto; transform: none !important; }
            .ev-title { font-size: 28px; }
            .ev-subtitle { margin: 12px 0 24px; }
            .pregunta-opts { grid-template-columns: 1fr; }
            .opt:nth-child(odd) { border-right: 0; }
            .opt { border-bottom: 1px solid rgba(255,255,255,0.14); padding: 18px 18px; }
            .pregunta-head { padding: 22px 18px 18px; }
            .pregunta-q { font-size: 16px; line-height: 160%; }
            .pregunta-foot { padding: 16px 18px; }
            .btn-next-q { width: 100%; text-align: center; }
        }
        @media (max-width: 560px) {
            .ev-top { padding: 0 16px; }
            .ev-title { font-size: 24px; }
            .pregunta-q { font-size: 15px; }
            .opt { padding: 16px; font-size: 14.5px; }
        }
        @media (max-width: 700px) {
            .ev-footer { flex-direction: column; text-align: center; gap: 10px; padding: 16px; }
            .ev-footer-links { gap: 16px; flex-wrap: wrap; justify-content: center; }
        }

        /* Loader "Evaluación enviada / Calculando resultados..." (mismo del resto del sitio) */
        .reg-loader-overlay { position: fixed; inset: 0; z-index: 200; display: flex; align-items: center; justify-content: center; background: rgba(26,38,44,0.55); opacity: 0; transition: opacity .35s ease; }
        .reg-loader-overlay[hidden] { display: none; }
        .reg-loader-overlay.is-visible { opacity: 1; }
        .reg-loader-card { width: 540px; max-width: calc(100% - 40px); height: 442px; padding: 64px 32px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 56px; border-radius: 32px; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.40); backdrop-filter: blur(40px); -webkit-backdrop-filter: blur(40px); box-shadow: 0 30px 90px rgba(0,0,0,0.28); transform: scale(0.94); transition: transform .45s cubic-bezier(.2,.8,.2,1); text-align: center; }
        .reg-loader-overlay.is-visible .reg-loader-card { transform: scale(1); }
        .reg-spinner { width: 160px; height: 160px; animation: reg-spin 1.1s linear infinite; }
        .reg-spin-track { fill: none; stroke: rgba(255,255,255,0.16); stroke-width: 1.6; }
        .reg-spin-arc { fill: none; stroke-width: 1.6; stroke-linecap: round; stroke-dasharray: 46 180; }
        @keyframes reg-spin { to { transform: rotate(360deg); } }
        .reg-loader-title { font-weight: 600; font-size: 24px; color: #fff; margin: 0 0 14px; }
        .reg-loader-sub { font-weight: 400; font-size: 15px; line-height: 150%; color: rgba(255,255,255,0.78); margin: 0 auto; max-width: 380px; }
        @media (max-width: 480px) {
            .reg-loader-card { width: 358px; height: auto; padding: 32px 16px; gap: 32px; }
            .reg-spinner { width: 139px; height: 139px; }
            .reg-loader-title { font-size: 22px; }
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
            <p class="ev-subtitle">Elige la opción correcta para avanzar.</p>

            <form method="POST" action="{{ route('evaluacion.responder') }}" id="form-pregunta">
                @csrf
                <div class="pregunta-card">
                    <div class="pregunta-head">
                        <p class="pregunta-num">Pregunta {{ $numero }}/{{ $total }}</p>
                        <p class="pregunta-q">{{ $pregunta['enunciado'] }}</p>
                    </div>

                    <div class="pregunta-opts">
                        @foreach ($opcionesBarajadas as $letra => $texto)
                            <label class="opt">
                                <input type="radio" name="opcion" value="{{ $letra }}" @checked(($seleccion ?? null) === $letra)>
                                <span class="opt-mark"></span>
                                <span class="opt-txt">{{ $texto }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="pregunta-foot">
                        <button type="submit" class="btn-next-q" id="btn-siguiente" disabled>
                            {{ $numero >= $total ? 'Finalizar evaluación' : 'Siguiente pregunta' }}
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </main>

    <footer class="ev-footer">
        <p class="ev-footer-txt">El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. 2026 © Qualimed Ediciones S.L.</p>
        <div class="ev-footer-links">
            <a href="#">Aviso legal</a>
            <a href="#">Política de privacidad</a>
            <a href="#">Política de cookies</a>
        </div>
    </footer>

    {{-- Loader que aparece al FINALIZAR la evaluación (última pregunta) --}}
    <div id="eval-loader" class="reg-loader-overlay" hidden>
        <div class="reg-loader-card">
            <svg class="reg-spinner" viewBox="0 0 50 50" aria-hidden="true">
                <defs>
                    <linearGradient id="evalSpin" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#05BAEE" stop-opacity="0"/>
                        <stop offset="60%" stop-color="#05BAEE" stop-opacity=".5"/>
                        <stop offset="100%" stop-color="#05BAEE" stop-opacity="1"/>
                    </linearGradient>
                </defs>
                <circle class="reg-spin-track" cx="25" cy="25" r="20"/>
                <circle class="reg-spin-arc" cx="25" cy="25" r="20" stroke="url(#evalSpin)"/>
            </svg>
            <div class="reg-loader-text">
                <h3 class="reg-loader-title">Evaluación enviada</h3>
                <p class="reg-loader-sub">Calculando resultados...</p>
            </div>
        </div>
    </div>

    <script>
        // Al FINALIZAR la evaluación (última pregunta), muestra el loader antes de enviar.
        (function () {
            var form = document.getElementById('form-pregunta');
            var overlay = document.getElementById('eval-loader');
            var esUltima = {{ $numero >= $total ? 'true' : 'false' }};
            if (!form || !overlay || !esUltima) return;
            form.addEventListener('submit', function (e) {
                var elegido = form.querySelector('input[name="opcion"]:checked');
                if (!elegido) return;                 // sin elegir no envía (el botón está disabled igual)
                e.preventDefault();
                overlay.hidden = false;
                requestAnimationFrame(function () { overlay.classList.add('is-visible'); });
                setTimeout(function () { form.submit(); }, 1600);   // deja ver el loader ~1.6s
            });
        })();
    </script>

    <script>
        // Habilita "Siguiente pregunta" solo cuando se elige una opción.
        (function () {
            var btn = document.getElementById('btn-siguiente');
            var radios = document.querySelectorAll('input[name="opcion"]');
            function refresh() {
                var any = [...radios].some(function (r) { return r.checked; });
                btn.classList.toggle('enabled', any);
                btn.disabled = !any;
            }
            radios.forEach(function (r) { r.addEventListener('change', refresh); });
            refresh();
        })();

        // Escala el contenido para llenar la pantalla dejando aire (descuenta el padding del main).
        (function () {
            var main = document.querySelector('.ev-main');
            var stage = document.querySelector('.ev-stage');
            if (!main || !stage) return;
            function scaleEv() {
                stage.style.transform = 'none';
                if (window.innerWidth <= 1024) return;   // móvil/tablet: layout fluido, no se escala
                var sw = stage.offsetWidth, sh = stage.offsetHeight;
                if (!main.clientWidth || !sw) { requestAnimationFrame(scaleEv); return; }
                var cs = getComputedStyle(main);
                var padX = parseFloat(cs.paddingLeft) + parseFloat(cs.paddingRight);
                var padY = parseFloat(cs.paddingTop) + parseFloat(cs.paddingBottom);
                var s = Math.min((main.clientWidth - padX) / sw, (main.clientHeight - padY) / sh);
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
