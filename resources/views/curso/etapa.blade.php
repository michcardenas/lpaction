<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $curso['paciente']['nombre'] }} — Presentación del caso</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @view-transition { navigation: auto; }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        /* ===== Pantalla completa fluida (llena todo el viewport) ===== */
        body {
            font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; margin: 0;
            height: 100vh; display: flex; flex-direction: column; overflow: hidden;
            background:
                radial-gradient(ellipse at 70% 45%, #33505b 0%, transparent 55%),
                linear-gradient(160deg, #273a42 0%, #1d2c33 60%, #16242a 100%);
        }

        /* ===== Top bar ===== */
        .etapa-top {
            height: 76px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            background: #0c1417;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .top-left { display: flex; align-items: center; gap: 14px; }
        .top-back { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; color: #05BAEE; }
        .top-name { font-weight: 600; font-size: 22px; color: #fff; }
        .top-center { display: flex; align-items: center; gap: 16px; }
        .top-lbl { font-weight: 500; font-size: 15px; color: #cdd8dc; white-space: nowrap; }
        .top-pct { font-weight: 600; font-size: 15px; color: #fff; }
        .bar { height: 8px; border-radius: 99px; background: rgba(255,255,255,0.14); overflow: hidden; }
        .bar > i { display: block; height: 100%; background: #05BAEE; border-radius: 99px; }
        .top-right { display: flex; align-items: center; gap: 14px; }
        .top-scope { font-weight: 500; font-size: 15px; color: #cdd8dc; white-space: nowrap; }
        .top-scope b { color: #fff; font-weight: 600; }
        .top-heart { color: #6f8b94; }

        /* ===== Cuerpo: sidebar + main ===== */
        .etapa-body { flex: 1; display: flex; min-height: 0; }

        /* ===== Sidebar de etapas ===== */
        .etapa-side {
            width: 360px; flex-shrink: 0;
            background: rgba(8, 16, 19, 0.55);
            border-right: 1px solid rgba(255,255,255,0.05);
            padding: 14px 0 0;
            overflow-y: auto;
            display: flex; flex-direction: column;
        }
        .side-item {
            display: flex; align-items: center; justify-content: space-between; gap: 14px;
            padding: 16px 28px;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; line-height: 135%;
            color: #8aa0a8; cursor: default;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .side-item .ico { flex-shrink: 0; color: #6f8b94; }
        .side-item.active {
            background: rgba(255,255,255,0.06);
            color: #ffffff;
            border-left: 3px solid #05BAEE;
            padding-left: 25px;
        }
        .side-item.active .ico { color: #05BAEE; }
        /* Área azul al final del menú (rellena el espacio bajo el último ítem) */
        .side-bottom { flex: 1 0 auto; min-height: 70px; background: #0F3B52; }

        /* ===== Main ===== */
        .etapa-main { flex: 1; position: relative; min-width: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        /* Escenario del contenido: tamaño de diseño fijo, escalado para caber sin scroll.
           Los márgenes que queden son del mismo teal del fondo → no se ve recuadro. */
        .main-stage { width: 1080px; height: 824px; flex-shrink: 0; position: relative; padding: 30px 44px; transform-origin: center center; }
        .content-col { width: 660px; position: relative; z-index: 2; }

        .seg { display: inline-flex; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); border-radius: 9px; padding: 4px; }
        .seg button {
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px;
            color: #cdd8dc; background: transparent; border: 0; cursor: pointer;
            padding: 7px 18px; border-radius: 6px; transition: .2s;
        }
        .seg button.on { background: #ffffff; color: #18272d; font-weight: 600; }
        .seg-top { position: absolute; top: 30px; right: 40px; z-index: 3; }

        .h-caso { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 28px; color: #05BAEE; margin: 0 0 14px; }
        .h-sec { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 24px; color: #fff; margin: 0 0 12px; }

        /* tabs */
        .tabs { display: inline-flex; gap: 4px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.10); border-radius: 10px; padding: 5px; margin-bottom: 12px; }
        .tab {
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px;
            color: #b9c7cc; background: transparent; border: 0; cursor: pointer;
            padding: 9px 18px; border-radius: 7px; white-space: nowrap; transition: .2s;
        }
        .tab.on { background: #ffffff; color: #18272d; font-weight: 600; }

        /* tarjeta perfil */
        .perfil-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 18px 24px;
            margin-bottom: 20px;
        }
        .perfil-card p { margin: 0 0 11px; font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 148%; color: #dfe7ea; }
        .perfil-card p:last-child { margin-bottom: 0; }
        .perfil-card b { font-weight: 700; color: #ffffff; }

        .motivo-p { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 155%; color: #cdd9dd; margin: 0; max-width: 640px; }

        /* paciente a la derecha */
        .etapa-juan { position: absolute; right: 70px; top: 70px; z-index: 1; pointer-events: none; user-select: none; }
        .etapa-juan img { height: 600px; width: auto; display: block; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.45)); }

        /* botón siguiente */
        .btn-next {
            position: absolute; right: 40px; bottom: 36px; z-index: 4;
            font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; color: #e9eef0;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.22);
            padding: 14px 26px; border-radius: 9px; cursor: pointer; transition: .2s;
        }
        .btn-next:hover { background: rgba(5,186,238,0.15); border-color: #05BAEE; color: #fff; }
    </style>
</head>
<body>

        {{-- ===== TOP BAR ===== --}}
        <header class="etapa-top">
            <div class="top-left">
                <a href="{{ route('curso') }}" class="top-back" aria-label="Volver">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <span class="top-name">{{ $curso['paciente']['nombre'] }}</span>
            </div>

            <div class="top-center">
                <span class="top-lbl">Avance del caso</span>
                <span class="bar" style="width:340px;"><i style="width:0%"></i></span>
                <span class="top-pct">00%</span>
            </div>

            <div class="top-right">
                <span class="top-scope">Scope: <b>000 / 000 Exp</b></span>
                <span class="bar" style="width:120px;"><i style="width:0%"></i></span>
                <span class="top-heart">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M19 14c1.5-1.5 2.5-3.2 2.5-5.1A4 4 0 0 0 14 6.5L12 8.5l-2-2A4 4 0 0 0 2.5 8.9c0 1.9 1 3.6 2.5 5.1l7 7Z"/></svg>
                </span>
            </div>
        </header>

        {{-- ===== CUERPO ===== --}}
        <div class="etapa-body">

            {{-- Sidebar de etapas --}}
            <aside class="etapa-side">
                @foreach ($curso['etapas'] as $i => $etapa)
                    <div class="side-item {{ $i === 0 ? 'active' : '' }}">
                        <span>{{ $etapa['titulo'] }}</span>
                        @if ($i === 0)
                            {{-- reloj (etapa activa) --}}
                            <svg class="ico" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        @else
                            {{-- candado (bloqueada) --}}
                            <svg class="ico" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                        @endif
                    </div>
                @endforeach

                {{-- Área azul al final del menú --}}
                <div class="side-bottom"></div>
            </aside>

            {{-- Main --}}
            <main class="etapa-main">
              <div class="main-stage">

                {{-- Toggle Contenido / Bibliografía --}}
                <div class="seg seg-top">
                    <button type="button" class="on">Contenido</button>
                    <button type="button">Bibliografía</button>
                </div>

                <div class="content-col">
                    <h1 class="h-caso">Presentación del caso</h1>

                    <h2 class="h-sec">Historia clínica</h2>

                    {{-- Tabs --}}
                    <div class="tabs">
                        <button type="button" class="tab on">Perfil del paciente</button>
                        <button type="button" class="tab">Historia médica</button>
                        <button type="button" class="tab">Medicación</button>
                        <button type="button" class="tab">Alergias</button>
                    </div>

                    {{-- Tarjeta perfil del paciente --}}
                    <div class="perfil-card">
                        <p><b>Edad y sexo:</b> varón, 52 años</p>
                        <p><b>Peso, estatura:</b> 82 kg, 167 cm (índice de masa corporal [IMC]: 29,4 kg/m² ; sobrepeso).</p>
                        <p><b>Hábitos:</b> fumador desde los 15 años; índice paquetes-año (IPA): 42.</p>
                        <p><b>Ocupación:</b> empresario.</p>
                        <p><b>Estilo de vida:</b> vida sedentaria, alto nivel de estrés.</p>
                    </div>

                    <h2 class="h-sec">Motivo de consulta</h2>
                    <p class="motivo-p">
                        Paciente que es traído a Urgencias de nuestro hospital por los servicios de
                        emergencias debido a un cuadro de 2 h de evolución de dolor torácico
                        retroesternal muy intenso que irradia hacia región epigástrica y base del
                        cuello. El paciente refiere clínica acompañante de sudoración profusa y
                        náuseas asociadas, aunque no ha presentado ningún vómito.
                    </p>
                </div>

                {{-- Paciente --}}
                <div class="etapa-juan">
                    {{-- anillos en la base --}}
                    <svg style="position:absolute; left:50%; bottom:6px; transform:translateX(-50%); opacity:.5;" width="460" height="120" viewBox="0 0 460 120" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 4; $r++)
                            <ellipse cx="230" cy="105" rx="{{ $r * 52 }}" ry="{{ $r * 13 }}" stroke="#7fa6b2" stroke-width="1" opacity="{{ 0.5 - $r * 0.1 }}"/>
                        @endfor
                    </svg>
                    <img src="{{ asset($curso['paciente']['imagen']) }}" alt="{{ $curso['paciente']['nombre'] }}">
                </div>

                {{-- Siguiente etapa --}}
                <button type="button" class="btn-next">Siguiente etapa</button>

              </div>{{-- /main-stage --}}
            </main>
        </div>

    <script>
        // Escala SOLO el contenido del main para que quepa sin scroll.
        // El layout (topbar, menú, main) sigue fluido y llena la pantalla;
        // los márgenes que queden son del mismo teal del fondo (no se ve recuadro).
        (function () {
            function scaleMainStage() {
                var main = document.querySelector('.etapa-main');
                var stage = document.querySelector('.main-stage');
                if (!main || !stage) return;
                var s = Math.min(main.clientWidth / 1080, main.clientHeight / 824);
                s = Math.min(s, 1.3);
                stage.style.transform = 'scale(' + s + ')';
            }
            window.addEventListener('resize', scaleMainStage);
            window.addEventListener('load', scaleMainStage);
            if (document.readyState !== 'loading') scaleMainStage();
            else document.addEventListener('DOMContentLoaded', scaleMainStage);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleMainStage);
        })();
    </script>
</body>
</html>
