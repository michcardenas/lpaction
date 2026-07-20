<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Encuesta de satisfacción — Lp(a)ction</title>
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
                radial-gradient(ellipse at 70% 15%, #33505b 0%, transparent 55%),
                linear-gradient(160deg, #273a42 0%, #1d2c33 60%, #16242a 100%);
        }

        /* Nav */
        .en-nav { height: 64px; flex-shrink: 0; display: flex; align-items: center; justify-content: space-between; padding: 0 40px; background: linear-gradient(90deg, #0a0f12 0%, #141d22 100%); }
        .en-nav-left { display: flex; align-items: center; gap: 30px; }
        .en-logo img { height: 26px; width: auto; }
        .en-links { display: flex; align-items: center; gap: 8px; }
        .en-link { font-weight: 500; font-size: 15px; color: rgba(255,255,255,0.82); text-decoration: none; padding: 8px 12px; border-radius: 6px; transition: background .2s; }
        .en-link:hover { background: rgba(100,162,196,0.20); }
        .en-org { display: flex; align-items: center; gap: 10px; }
        .en-org span { font-weight: 500; font-size: 13px; color: rgba(255,255,255,0.75); }
        .en-org img { height: 30px; width: auto; }
        @media (max-width: 820px) { .en-links, .en-org span { display: none; } }

        /* Contenido */
        .en-main { flex: 1; padding: 40px clamp(20px, 5vw, 90px) 60px; max-width: 1240px; width: 100%; margin: 0 auto; }
        .en-title { font-weight: 600; font-size: 38px; line-height: 1.1; margin: 0; }
        .en-title::after { content: ''; display: block; width: 92px; height: 3px; background: #05BAEE; margin: 14px 0 0; border-radius: 2px; }
        .en-sub { font-weight: 400; font-size: 15px; color: #c2d0d5; margin: 16px 0 30px; }

        /* Ítem */
        .en-item { display: grid; grid-template-columns: 74px 1fr auto; align-items: center; gap: 24px; padding: 22px 26px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); margin-bottom: 18px; }
        .en-num { font-weight: 600; font-size: 14px; color: #05BAEE; white-space: nowrap; }
        .en-item-h { font-weight: 600; font-size: 19px; color: #fff; margin: 0 0 8px; }
        .en-item-p { font-weight: 400; font-size: 14px; line-height: 155%; color: #b9c6cb; margin: 0; }

        /* Estrellas */
        .en-stars { display: inline-flex; gap: 8px; }
        .en-star { cursor: pointer; color: #4b6069; transition: color .12s, transform .12s; }
        .en-star:hover { transform: scale(1.08); }
        .en-star svg { display: block; width: 30px; height: 30px; }
        .en-star.on { color: #35c6f4; }
        .en-star.on svg path { fill: currentColor; stroke: currentColor; }
        .en-star svg path { fill: none; stroke: currentColor; stroke-width: 1.6; }

        /* Observaciones (ítem 14) */
        .en-item.obs { grid-template-columns: 74px 1fr; align-items: start; }
        .en-obs-box { margin-top: 14px; }
        .en-obs-box textarea {
            width: 100%; min-height: 150px; resize: vertical;
            background: #f2f4f5; color: #1a2830; border: 0; border-radius: 6px; padding: 16px 18px;
            font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px; line-height: 150%;
        }
        .en-obs-box textarea::placeholder { color: #8a969c; }

        /* Pie: Responder luego / Enviar */
        .en-foot { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 34px; flex-wrap: wrap; }
        .en-btn { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; padding: 15px 34px; border-radius: 8px; border: 0; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; transition: background .2s, color .2s; }
        .en-btn.ghost { background: rgba(255,255,255,0.06); color: #fff; border: 1px solid rgba(255,255,255,0.16); }
        .en-btn.ghost:hover { background: rgba(255,255,255,0.12); }
        .en-btn.cyan { background: #05BAEE; color: #fff; }
        .en-btn.cyan:hover { background: #04a3d1; }
        .en-btn.cyan:disabled { background: rgba(255,255,255,0.10); color: rgba(255,255,255,0.45); cursor: not-allowed; }
        @media (max-width: 620px) {
            .en-item, .en-item.obs { grid-template-columns: 1fr; gap: 12px; }
            .en-stars { justify-content: flex-start; }
            .en-foot { flex-direction: column-reverse; }
            .en-btn { width: 100%; }
        }

        /* Footer legal */
        .en-footer { flex-shrink: 0; background: #000; padding: 16px 40px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .en-footer-txt { font-weight: 500; font-size: 13px; color: #fff; margin: 0; }
        .en-footer-links { display: flex; align-items: center; gap: 32px; }
        .en-footer-links a { font-weight: 500; font-size: 13px; color: #fff; text-decoration: none; }
        .en-footer-links a:hover { color: #05BAEE; }
        @media (max-width: 700px) { .en-footer { flex-direction: column; text-align: center; gap: 10px; } .en-footer-links { gap: 16px; flex-wrap: wrap; justify-content: center; } }
    </style>
</head>
<body>
    <header class="en-nav">
        <div class="en-nav-left">
            <a href="{{ route('curso') }}" class="en-logo"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"></a>
            <nav class="en-links">
                <a href="{{ route('curso') }}" class="en-link">Inicio</a>
                <a href="{{ route('tutoria') }}" class="en-link">Tutoría</a>
                <a href="{{ route('autores') }}" class="en-link">Autores</a>
                <a href="{{ route('perfil') }}" class="en-link">Perfil</a>
            </nav>
        </div>
        <div class="en-org">
            <span>Organizado por:</span>
            <img src="{{ asset('images/sec-logo-hd.png') }}" onerror="this.onerror=null;this.src='{{ asset('images/sec-logo.png') }}'" alt="Sociedad Española de Cardiología">
        </div>
    </header>

    <form method="POST" action="{{ route('encuesta.guardar') }}" id="form-encuesta">
        @csrf
        <main class="en-main">
            <h1 class="en-title">Encuesta de satisfacción</h1>
            <p class="en-sub">Recuerda cumplimentar esta encuesta de satisfacción para acceder a la evaluación final.</p>

            @php $items = $cfg['items'] ?? []; $totalItems = count($items) + 1; @endphp
            @foreach ($items as $i => $item)
                <div class="en-item">
                    <div class="en-num">{{ $i + 1 }} / {{ $totalItems }}</div>
                    <div class="en-item-body">
                        <p class="en-item-h">{{ $item['titulo'] }}</p>
                        <p class="en-item-p">{{ $item['texto'] }}</p>
                    </div>
                    <div class="en-stars" data-item="{{ $i }}">
                        <input type="hidden" name="estrella_{{ $i }}" value="{{ $respuestas[$i] ?? 0 }}">
                        @for ($s = 1; $s <= 5; $s++)
                            <span class="en-star" data-val="{{ $s }}" role="button" aria-label="{{ $s }} estrellas">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M12 2.5l2.9 5.9 6.5.95-4.7 4.58 1.1 6.47L12 17.3l-5.8 3.05 1.1-6.47-4.7-4.58 6.5-.95L12 2.5z"/></svg>
                            </span>
                        @endfor
                    </div>
                </div>
            @endforeach

            {{-- Ítem 14: Observaciones --}}
            <div class="en-item obs">
                <div class="en-num">{{ $totalItems }} / {{ $totalItems }}</div>
                <div class="en-item-body">
                    <p class="en-item-h">{{ $cfg['observaciones']['titulo'] }}</p>
                    <p class="en-item-p">{{ $cfg['observaciones']['texto'] }}</p>
                    <div class="en-obs-box">
                        <textarea name="observaciones" placeholder="{{ $cfg['observaciones']['placeholder'] }}">{{ $respuestas['observaciones'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="en-foot">
                <a href="{{ route('curso') }}" class="en-btn ghost">Responder luego</a>
                <button type="submit" class="en-btn cyan" id="btn-enviar" disabled>Enviar</button>
            </div>
        </main>
    </form>

    <footer class="en-footer">
        <p class="en-footer-txt">El contenido de este sitio web está orientado exclusivamente a profesionales sanitarios. 2026 © Qualimed Ediciones S.L.</p>
        <div class="en-footer-links">
            <a href="#">Aviso legal</a>
            <a href="#">Política de privacidad</a>
            <a href="#">Política de cookies</a>
        </div>
    </footer>

    <script>
        // Rating de estrellas + habilitar "Enviar" cuando todas las preguntas estén valoradas.
        (function () {
            var grupos = document.querySelectorAll('.en-stars');
            var btn = document.getElementById('btn-enviar');
            function pintar(grupo, val) {
                grupo.querySelectorAll('.en-star').forEach(function (st) {
                    st.classList.toggle('on', parseInt(st.dataset.val, 10) <= val);
                });
            }
            function refrescarEnviar() {
                var todas = [...grupos].every(function (g) {
                    return parseInt(g.querySelector('input').value, 10) > 0;
                });
                btn.disabled = !todas;
            }
            grupos.forEach(function (grupo) {
                var input = grupo.querySelector('input');
                pintar(grupo, parseInt(input.value, 10) || 0);
                grupo.querySelectorAll('.en-star').forEach(function (st) {
                    st.addEventListener('click', function () {
                        input.value = st.dataset.val;
                        pintar(grupo, parseInt(st.dataset.val, 10));
                        refrescarEnviar();
                    });
                    st.addEventListener('mouseenter', function () { pintar(grupo, parseInt(st.dataset.val, 10)); });
                });
                grupo.addEventListener('mouseleave', function () { pintar(grupo, parseInt(input.value, 10) || 0); });
            });
            refrescarEnviar();
        })();
    </script>
</body>
</html>
