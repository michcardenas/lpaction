<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        /* En celulares fijamos el viewport a 390 → el diseño móvil escala como una imagen */
        (function () {
            try { var mn = Math.min(screen.width, screen.height);
                if (mn && mn < 768) document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=390'); } catch (e) {}
        })();
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $curso['paciente']['nombre'] }} — Presentación del caso</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @view-transition { navigation: auto; }
        * { box-sizing: border-box; }
        [hidden] { display: none !important; }   /* el atributo hidden siempre oculta */
        html, body { height: 100%; }
        /* ===== Pantalla completa: llena todo el viewport en cualquier PC ===== */
        body {
            font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif; margin: 0;
            height: 100vh; display: flex; flex-direction: column; overflow: hidden;
            background:
                radial-gradient(ellipse at 70% 45%, #33505b 0%, transparent 55%),
                linear-gradient(160deg, #273a42 0%, #1d2c33 60%, #16242a 100%);
        }
        /* el wrapper no afecta el layout (sus hijos actúan como hijos directos del body) */
        .etapa-page { display: contents; }

        /* ===== Top bar ===== */
        .etapa-top {
            height: 76px; flex-shrink: 0;
            display: flex; align-items: center;
            padding: 0 33px 0 40px;
            background: #0c1417;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        /* El grupo izquierdo mide lo del sidebar → "Avance del caso" arranca alineado con el contenido */
        .top-left { display: flex; align-items: center; gap: 14px; width: 352px; flex-shrink: 0; }
        .top-back { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; color: #05BAEE; }
        .top-name { font-weight: 600; font-size: 22px; color: #fff; }
        .top-center { display: flex; align-items: center; gap: 16px; flex: 1; min-width: 0; }
        .top-lbl { font-weight: 500; font-size: 16px; color: #f1f5f6; white-space: nowrap; }
        .top-pct { font-weight: 600; font-size: 16px; color: #fff; }
        .bar { height: 9px; border-radius: 99px; background: rgba(255,255,255,0.8); overflow: hidden; }
        .bar > i { display: block; height: 100%; background: #05BAEE; border-radius: 99px; }
        /* Barra del Score: verde (ganado) + rojo (penalizado), contrapeso */
        .score-bar { display: flex; }
        .score-bar > i { border-radius: 0; flex-shrink: 0; transition: width .25s ease; }
        .score-bar > i.green { background: #54c06a; }
        .score-bar > i.red { background: #d9534f; }
        .top-right { display: flex; align-items: center; gap: 16px; }
        .top-scope { font-weight: 400; font-size: 16px; color: #e9eff1; white-space: nowrap; }
        .top-scope b { color: #fff; font-weight: 700; }
        .top-heart { color: #c9d3d7; display: inline-flex; }
        .sc-max, .heart-mobile { display: none; }   /* solo en móvil */

        /* ===== Cuerpo: sidebar + main ===== */
        .etapa-body { flex: 1; display: flex; min-height: 0; }

        /* ===== Sidebar de etapas ===== */
        .etapa-side {
            width: 360px; flex-shrink: 0;
            background: #26383F;
            padding: 0;
            overflow-y: auto;
            display: flex; flex-direction: column;
        }
        .side-item {
            display: flex; align-items: center; justify-content: space-between; gap: 32px;
            padding: 16px 32px;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; line-height: 150%; letter-spacing: 0.02em;
            color: rgba(255,255,255,0.55); cursor: default;
            border: 0.5px solid rgba(255,255,255,0.10);   /* #FFFFFF1A */
            /* brillo sutil tipo cristal sobre el #26383F */
            background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 62%);
        }
        .side-item { text-decoration: none; }
        .side-item .ico { flex-shrink: 0; color: rgba(255,255,255,0.40); }
        /* perfecta: etapa superada sin errores → texto claro + check verde */
        .side-item.perfecta { color: rgba(255,255,255,0.80); cursor: pointer; }
        .side-item.perfecta .ico { color: #54c06a; }
        /* error: etapa superada con algún fallo → texto claro + cruz roja */
        .side-item.error { color: rgba(255,255,255,0.80); cursor: pointer; }
        .side-item.error .ico { color: #d9534f; }
        /* activa: texto blanco + reloj cyan */
        .side-item.activa { color: #FFFFFF; cursor: pointer; }
        .side-item.activa .ico { color: #05BAEE; }
        /* etapa que se está viendo: fondo resaltado */
        .side-item.viendo {
            background: linear-gradient(180deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.03) 100%);
            color: #FFFFFF;
        }
        /* Espacio bajo el último ítem — mismo tono que toda la columna (#26383F) */
        .side-bottom { flex: 1 0 auto; min-height: 70px; background: #26383F; }
        /* Header "Avance del caso" y botón "Salir del caso": solo en el drawer móvil */
        .side-head, .side-salir { display: none; }

        /* ===== Main ===== */
        .etapa-main { flex: 1; position: relative; min-width: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        /* Escenario del contenido: tamaño de diseño fijo, escalado para caber sin scroll.
           Los márgenes que queden son del mismo teal del fondo → no se ve recuadro. */
        .main-stage { width: 1080px; height: 824px; flex-shrink: 0; position: relative; padding: 30px 32px; transform-origin: center center; }
        .content-col { width: 656px; position: relative; z-index: 2; }

        .seg { display: inline-flex; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.22); border-radius: 0; padding: 4px; }
        .seg button {
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px;
            color: #e6edef; background: transparent; border: 0; cursor: pointer;
            padding: 8px 20px; border-radius: 0; transition: .2s;
        }
        .seg button.on { background: #ffffff; color: #16262c; font-weight: 600; }
        .seg-top { position: absolute; top: 32px; right: 8px; z-index: 3; }

        .h-caso { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 26px; color: #05BAEE; margin: 0 0 32px; }
        .h-sec { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 27px; color: #fff; margin: 0 0 22px; }

        /* tabs (ocupan todo el ancho del contenido, repartidos) */
        .tabs { display: flex; width: 100%; gap: 4px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.16); border-radius: 0; padding: 4px; margin-bottom: 10px; }
        .tab {
            flex: 1;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px;
            color: #cfdadd; background: transparent; border: 0; cursor: pointer;
            padding: 10px 12px; border-radius: 0; white-space: nowrap; transition: .2s; text-align: center;
        }
        .tab.on { background: #ffffff; color: #16262c; font-weight: 600; }

        /* tarjeta perfil */
        .perfil-card {
            background: rgba(255,255,255,0.16);   /* tu ajuste */
            border: 1px solid rgba(255,255,255,0.16);
            border-radius: 0;
            padding: 24px 26px;
            margin-bottom: 28px;
        }
        .perfil-card p { margin: 0 0 15px; font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 150%; color: #e6edef; }
        .perfil-card p:last-child { margin-bottom: 0; }
        .perfil-card b { font-weight: 700; color: #ffffff; }

        .motivo-p { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 160%; color: #d3dee1; margin: 0; max-width: 640px; }

        /* ===== Vistas Contenido / Bibliografía ===== */
        .view { position: absolute; inset: 30px 8px; z-index: 2; }
        /* la vista de bibliografía termina arriba del botón (no se solapan) */
        #view-biblio { display: flex; flex-direction: column; bottom: 100px; }
        .biblio-list { flex: 1; min-height: 0; overflow-y: auto; padding-right: 16px; margin-top: 2px; }
        .biblio-list::-webkit-scrollbar { width: 8px; }
        .biblio-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.18); border-radius: 8px; }
        .biblio-h { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 24px; line-height: 130%; letter-spacing: 0; color: #FFFFFF; margin: 0 0 18px; }
        .biblio-item { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #FFFFFF; margin: 0 0 17px; max-width: 1010px; }
        .biblio-item:last-child { margin-bottom: 0; }

        /* Animación suave al cambiar de pestaña / vista (fade + leve subida) */
        @keyframes fadeSwap { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .tab-panel { animation: fadeSwap .28s ease; }
        .view { animation: fadeSwap .28s ease; }

        /* ===== Etapa con contenido largo: scroll, termina arriba del botón ===== */
        .view-scroll { overflow-y: auto; bottom: 96px; scrollbar-width: none; -ms-overflow-style: none; }
        .view-scroll::-webkit-scrollbar { display: none; width: 0; height: 0; }

        /* ===== Etapa: Pruebas complementarias ===== */
        .pruebas { width: 100%; }
        .prueba-panel { margin-top: 4px; }
        /* Tarjeta del ECG — specs: ancho 1016px, gap 16px entre elementos */
        .ecg-block {
            width: 100%;
            background: rgba(255,255,255,0.10);   /* #FFFFFF1A */
            border: 1px solid rgba(255,255,255,0.40);   /* #FFFFFF66 */
            border-radius: 0;
            padding: 22px;
            display: flex; flex-direction: column; gap: 16px;
        }
        .prueba-h { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 24px; line-height: 130%; letter-spacing: 0; color: #fff; margin: 0; }
        .prueba-p { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #d3dee1; margin: 0; }
        .ecg-frame { position: relative; border-radius: 0; overflow: hidden; }
        .ecg-frame img { display: block; width: 100%; height: auto; }
        .ecg-icon { position: absolute; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; background: rgba(18,28,33,0.55); border: 1px solid rgba(255,255,255,0.18); border-radius: 0; color: #fff; cursor: pointer; -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px); }
        .ecg-expand { top: 12px; right: 12px; }
        .ecg-download { bottom: 12px; right: 12px; text-decoration: none; }
        .ecg-caption { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 12px; line-height: 150%; letter-spacing: 0.02em; color: #aab7bb; margin: 0; }

        /* Cateterismo: tarjeta (como el ECG) + grilla de videos */
        .cat-block { width: 100%; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.40); border-radius: 0; padding: 16px; display: flex; flex-direction: column; gap: 16px; }
        .videos-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 24px; margin: 0; }
        .video-item { margin: 0; }
        .video-player { position: relative; aspect-ratio: 476 / 310; border-radius: 8px; overflow: hidden; background: linear-gradient(135deg, #70757a 0%, #44484b 100%); }
        .video-player img, .video-player video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block; }
        .video-controls { position: absolute; left: 0; right: 0; bottom: 0; display: flex; align-items: center; gap: 12px; padding: 12px; background: linear-gradient(0deg, rgba(0,0,0,0.40), rgba(0,0,0,0)); }
        .vid-btn { width: 34px; height: 34px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(15,18,20,0.55); border: 0; border-radius: 7px; color: #fff; cursor: pointer; -webkit-backdrop-filter: blur(3px); backdrop-filter: blur(3px); }
        .vid-bar { flex: 1; height: 4px; background: rgba(255,255,255,0.30); border-radius: 99px; overflow: hidden; }
        .vid-bar > i { display: block; height: 100%; width: 0; background: #fff; }
        .video-cap { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 13px; line-height: 148%; color: #aab7bb; margin: 10px 0 0; }
        /* Reproductor grande (Puntos clave): ancho completo */
        .video-full { margin: 0; max-width: 1010px; }
        .video-full .video-player { aspect-ratio: 1016 / 617; }

        /* Resumen del caso */
        .resumen-card { max-width: 560px; margin: 90px auto 0; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.16); padding: 32px 40px; text-align: center; }
        .resumen-head { display: flex; align-items: center; justify-content: center; gap: 12px; color: #fff; margin-bottom: 16px; }
        .resumen-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 19px; color: #fff; }
        .resumen-txt { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px; line-height: 160%; color: #c8d3d7; margin: 0 auto 24px; max-width: 420px; }
        .btn-descargar { display: inline-flex; align-items: center; gap: 10px; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; background: #05BAEE; color: #fff; border: 0; padding: 12px 28px; border-radius: 6px; cursor: pointer; text-decoration: none; transition: background .2s; }
        .btn-descargar:hover { background: #04a3d1; }
        .resumen-foot { display: flex; justify-content: center; margin-top: 34px; }
        .btn-finalizar { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; background: rgba(185,185,185,0.25); color: #BFBFBF; border: 0; padding: 13px 38px; border-radius: 6px; cursor: pointer; transition: background .2s, color .2s; }
        .btn-finalizar:hover { background: rgba(185,185,185,0.40); color: #fff; }

        /* Analítica sanguínea: cuadro + lista de valores */
        .analitica-block { width: 100%; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.40); border-radius: 0; padding: 22px 24px; }
        .analitica-block .prueba-h { margin: 0 0 10px; }
        .analitica-intro { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 150%; color: #d3dee1; margin: 0 0 8px; }
        .analitica-list { list-style: none; margin: 0; padding: 0; max-width: 1000px; }
        .analitica-list li { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 168%; color: #d3dee1; position: relative; padding-left: 20px; }
        .analitica-list li::before { content: '•'; position: absolute; left: 5px; color: #d3dee1; }
        .analitica-list b { color: #fff; }
        .analitica-sublist { list-style: none; margin: 2px 0 2px 24px; padding: 0; }
        .analitica-sublist li::before { content: '◦'; }

        /* Cuestionario — specs: 1016px, #2A2A2A, borde 1px #FFFFFF66, blur(40px) */
        .pregunta-card {
            width: 100%;
            background: #2A2A2A;
            border: 1px solid rgba(255,255,255,0.40);
            -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
            border-radius: 0; margin-top: 28px; overflow: hidden;
        }
        .pregunta-head { padding: 26px 32px 22px; }
        .pregunta-q { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 18px; line-height: 175%; letter-spacing: 0.02em; color: #fff; margin: 0; }
        .pregunta-sub { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; line-height: 150%; letter-spacing: 0.02em; color: rgba(255,255,255,0.60); margin: 4px 0 0; }
        /* opciones en grid 2×2 con separadores */
        .pregunta-opts { display: grid; grid-template-columns: 1fr 1fr; border-top: 1px solid rgba(255,255,255,0.14); }
        .opt { display: flex; align-items: center; gap: 16px; padding: 26px 32px; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #fff; cursor: pointer; transition: background .2s ease, transform .2s ease, box-shadow .2s ease; }
        .opt:hover { background: rgba(5,186,238,0.10); transform: translateX(10px); box-shadow: inset 3px 0 0 #05BAEE; }   /* hover: se corre a la derecha + brillo cyan */
        .opt:has(input:checked) { background: rgba(5,186,238,0.08); }   /* fila seleccionada: tinte cyan sutil */
        .opt:nth-child(odd) { border-right: 1px solid rgba(255,255,255,0.14); }
        .opt:nth-child(-n+2) { border-bottom: 1px solid rgba(255,255,255,0.14); }
        .opt input { display: none; }
        .opt-mark { flex-shrink: 0; width: 22px; height: 22px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.45); position: relative; transition: border-color .15s; }
        .opt input:checked + .opt-mark { border: 0; background: linear-gradient(180deg, #05BAEE 0%, #2F728C 100%); }
        .opt input:checked + .opt-mark::after { content: '\2713'; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; font-weight: 800; }
        .opt-txt { vertical-align: middle; }
        /* footer con el botón */
        .pregunta-foot { display: flex; align-items: center; gap: 12px; padding: 18px 32px; border-top: 1px solid rgba(255,255,255,0.14); }
        .pregunta-foot form { margin: 0; display: contents; }
        .foot-spacer { flex: 1; }
        /* Siguiente etapa: gris/deshabilitado por defecto; se activa (borde cyan) al acertar */
        .btn-next-q { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; line-height: 150%; letter-spacing: 0.01em; background: rgba(185,185,185,0.25); color: #BFBFBF; border: 1px solid transparent; padding: 11px 28px; border-radius: 5px; cursor: default; pointer-events: none; transition: background .2s, color .2s, border-color .2s; }
        .btn-next-q.enabled { background: transparent; color: #fff; border-color: #05BAEE; cursor: pointer; pointer-events: auto; }
        .btn-next-q.enabled:hover { background: rgba(5,186,238,0.14); }
        .btn-comprobar { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; line-height: 150%; letter-spacing: 0.01em; background: #FFFFFF; color: #454545; border: 0; padding: 11px 30px; border-radius: 5px; cursor: pointer; transition: background .2s; }
        .btn-comprobar:hover { background: #efefef; }
        .btn-comprobar:disabled { background: rgba(185,185,185,0.25); color: #BFBFBF; cursor: default; }
        .btn-comprobar.comprobado, .btn-comprobar.comprobado:disabled { background: #2E7D9B; color: #fff; }   /* se pinta de azul al comprobar */
        .btn-comprobar.comprobado:hover { background: #2A7188; }
        .btn-repetir { display: inline-flex; align-items: center; gap: 10px; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; background: rgba(255,255,255,0.10); border: 0; color: rgba(255,255,255,0.78); padding: 11px 22px; border-radius: 5px; cursor: pointer; transition: background .2s, color .2s; animation: fadeSwap .3s ease; }
        .btn-repetir:hover { background: rgba(255,255,255,0.16); color: #fff; }

        /* Estados tras Comprobar — brillo verde/rojo en una esquina (la letra queda blanca) */
        .opt.correct { background: radial-gradient(circle at bottom right, rgba(56,79,29,0.45) 0%, rgba(56,79,29,0) 50%); }
        .opt.wrong   { background: radial-gradient(circle at bottom right, rgba(155,48,40,0.35) 0%, rgba(155,48,40,0) 50%); }
        .pregunta-opts .opt.wrong .opt-mark, .pregunta-opts .opt.correct .opt-mark { border-width: 0; }
        .pregunta-opts .opt.wrong .opt-mark { background: #C0392B; }
        .pregunta-opts .opt.correct .opt-mark { background: #59A700; }
        .pregunta-opts .opt.wrong .opt-mark::after,
        .pregunta-opts .opt.correct .opt-mark::after { content: ''; position: absolute; inset: 0; background: none; border-radius: 0; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; font-weight: 800; }
        .pregunta-opts .opt.wrong .opt-mark::after { content: '\2715'; }
        .pregunta-opts .opt.correct .opt-mark::after { content: '\2713'; }

        .justif { display: flex; flex-direction: column; position: relative; padding: 22px 32px; border-top: 1px solid rgba(255,255,255,0.14); }
        .justif-h { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; color: #fff; margin: 0 0 8px; }
        .justif-txt { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 14px; line-height: 165%; color: rgba(255,255,255,0.75); margin: 0; }
        /* Chevron para colapsar/expandir la justificación (abajo-derecha) */
        .justif-toggle { align-self: flex-end; margin-top: 12px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.24); border-radius: 8px; color: rgba(255,255,255,0.78); cursor: pointer; transition: background .2s, border-color .2s; }
        .justif-toggle:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.28); }
        .justif-toggle svg { display: block; transition: transform .25s ease; }
        .justif.collapsed .justif-txt { display: none; }
        .justif.collapsed .justif-h { margin-bottom: 0; }
        .justif.collapsed .justif-toggle { position: absolute; top: 14px; right: 32px; margin-top: 0; }   /* colapsado: chevron en línea con el título, sin campo vacío */
        .justif.collapsed .justif-toggle svg { transform: rotate(180deg); }

        .resultado { display: flex; align-items: center; gap: 12px; padding: 16px 32px; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 16px; color: #fff; }
        .resultado.bad { background: rgba(150,52,45,0.92); }
        .resultado.ok { background: #384F1D; }
        .resultado-ico { width: 26px; height: 26px; border-radius: 50%; border: 2px solid #fff; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; flex-shrink: 0; }

        /* Modal "Reiniciar capítulo" (confirma Repetir etapa). Fuera del stage escalado. */
        .reset-modal { position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 24px; background: rgba(8,14,17,0.62); backdrop-filter: blur(3px); animation: resetFade .2s ease both; }
        .reset-modal[hidden] { display: none; }
        .reset-card { width: 100%; max-width: 470px; background: linear-gradient(180deg, rgba(40,56,63,0.97) 0%, rgba(28,42,48,0.97) 100%); border: 1px solid rgba(255,255,255,0.14); border-radius: 18px; padding: 40px 40px 32px; text-align: center; box-shadow: 0 30px 80px rgba(0,0,0,0.45); animation: resetPop .28s cubic-bezier(.22,.61,.36,1) both; }
        .reset-ico { width: 66px; height: 66px; border-radius: 50%; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.16); display: inline-flex; align-items: center; justify-content: center; color: #cfe6ef; margin-bottom: 20px; }
        .reset-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 22px; color: #fff; margin: 0 0 14px; }
        .reset-text { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 14px; line-height: 165%; color: rgba(255,255,255,0.72); margin: 0 0 28px; }
        .reset-text strong { color: #fff; font-weight: 600; }
        .reset-actions { display: flex; flex-direction: column-reverse; align-items: stretch; gap: 8px; }   /* apilados: Reiniciar etapa arriba, Cancelar abajo (target) */
        .reset-actions form { width: 100%; margin: 0; }
        .reset-cancel { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; background: none; border: 0; color: rgba(255,255,255,0.78); cursor: pointer; padding: 12px 8px; width: 100%; transition: color .2s; }
        .reset-cancel:hover { color: #fff; }
        .reset-confirm { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.20); color: #fff; padding: 14px 26px; width: 100%; border-radius: 8px; cursor: pointer; transition: background .2s, border-color .2s; }
        .reset-confirm:hover { background: rgba(255,255,255,0.20); border-color: rgba(255,255,255,0.32); }
        @keyframes resetFade { from { opacity: 0; } to { opacity: 1; } }
        @keyframes resetPop { from { opacity: 0; transform: translateY(14px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }

        /* Lightbox de imágenes (ampliar ECG / cateterismo + descargar). Fuera del stage escalado. */
        .img-lightbox { position: fixed; inset: 0; z-index: 10000; display: flex; flex-direction: column; background: rgba(6,10,12,0.93); -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px); animation: resetFade .2s ease both; }
        .img-lightbox[hidden] { display: none; }
        .lb-bar { flex-shrink: 0; display: flex; justify-content: flex-end; align-items: center; gap: 14px; padding: 16px 22px; }
        .lb-btn { display: inline-flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; color: #fff; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.22); border-radius: 8px; padding: 9px 16px; cursor: pointer; text-decoration: none; transition: background .2s; }
        .lb-btn:hover { background: rgba(255,255,255,0.20); }
        .lb-close { padding: 9px 11px; }
        .lb-stage { flex: 1; min-height: 0; overflow: auto; display: flex; align-items: center; align-items: safe center; justify-content: center; justify-content: safe center; padding: 0 24px 16px; }
        .lb-img { width: 94vw; max-height: 82vh; object-fit: contain; border-radius: 4px; box-shadow: 0 24px 70px rgba(0,0,0,0.55); cursor: zoom-in; }
        .lb-img.zoom { max-width: none; max-height: none; width: 165%; flex-shrink: 0; cursor: zoom-out; }
        .lb-caption { flex-shrink: 0; text-align: center; color: rgba(255,255,255,0.78); font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; line-height: 150%; padding: 0 24px 18px; margin: 0 auto; max-width: 1000px; }

        /* Pop-up de resultado/medalla ("finalizar caso"): overlay sobre la etapa difuminada, panel SÓLIDO. */
        .result-modal { position: fixed; inset: 0; z-index: 10001; display: flex; align-items: center; justify-content: center; padding: 28px; background: rgba(8,14,17,0.72); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); animation: resetFade .25s ease both; }
        .result-modal[hidden] { display: none; }
        .result-panel { position: relative; width: 100%; max-width: 860px; min-height: 420px; border-radius: 22px; overflow: hidden; background: linear-gradient(135deg, #2a3c43 0%, #182830 100%); border: 1px solid rgba(255,255,255,0.12); box-shadow: 0 40px 100px rgba(0,0,0,0.5); display: flex; align-items: stretch; animation: resetPop .32s cubic-bezier(.22,.61,.36,1) both; }
        .rp-left { flex: 1; padding: 54px 48px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; z-index: 2; }
        .rp-medal { width: 74px; height: 74px; object-fit: contain; margin-bottom: 26px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.45)); }
        .rp-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 26px; line-height: 1.1; margin: 0 0 16px; color: #fff; }
        .rp-text { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 15px; line-height: 165%; color: #c8d3d7; margin: 0 0 32px; max-width: 440px; }
        .rp-actions { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
        .rp-btn { display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; color: #cfe6ef; text-decoration: none; padding: 13px 30px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.28); background: rgba(255,255,255,0.04); transition: background .2s, border-color .2s; }
        .rp-btn:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.45); }
        .rp-btn.cyan { background: #05BAEE; border-color: #05BAEE; color: #fff; }
        .rp-btn.cyan:hover { background: #04a3d1; border-color: #04a3d1; }
        .rp-right { flex: 0 0 300px; position: relative; }
        .rp-right .rp-juan { position: absolute; right: 0; bottom: 0; height: 106%; width: auto; max-width: none; object-fit: contain; object-position: bottom right; }
        .rp-rings { position: absolute; right: 22px; bottom: 4px; opacity: .45; z-index: 1; }
        @media (max-width: 720px) { .result-panel { flex-direction: column; min-height: 0; } .rp-left { padding: 38px 24px 24px; } .rp-right { flex: 0 0 230px; } }

        /* Pop-up de medalla alcanzada (durante el curso): mismo estilo que el final, centrado y sin Juan. */
        #medal-unlock { z-index: 10003; }
        #medal-unlock .result-panel { max-width: 520px; min-height: 0; }
        #medal-unlock .rp-left { padding: 44px 40px; }

        /* paciente a la derecha: la figura va desde "Historia clínica" hasta el final de "Motivo de consulta" */
        .etapa-juan { position: absolute; right: -165px; top: -56px; z-index: 1; pointer-events: none; user-select: none; }
        .etapa-juan img { height: 820px; width: auto; display: block; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.45)); }

        /* botón siguiente */
        .btn-next {
            position: absolute; right: 32px; bottom: 44px; z-index: 4;
            font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; color: #eef3f4;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.32);
            padding: 12px 24px; border-radius: 0; cursor: pointer; transition: .2s;
        }
        .btn-next:hover { background: rgba(5,186,238,0.15); border-color: #05BAEE; color: #fff; }
        .biblio-next { position: static; align-self: flex-start; margin-top: 28px; }   /* Siguiente etapa dentro de la vista Bibliografía (etapas con quiz) */

        /* ===== Pop-up "Atención" (al darle Siguiente etapa) — desktop + móvil =====
           Spec: 358 · radius 32 · borde 1px #FFFFFF40 · fondo blanco 10% · blur 40 · pad 32/16/16/16 · gap 32 */
        .etapa-popup {
            position: fixed; inset: 0; z-index: 10002;
            display: flex; align-items: center; justify-content: center; padding: 16px;
            background: rgba(8,14,17,0.62); -webkit-backdrop-filter: blur(3px); backdrop-filter: blur(3px);
            animation: resetFade .2s ease both;
        }
        .etapa-popup[hidden] { display: none; }
        .ep-card {
            width: 358px; max-width: 100%;
            display: flex; flex-direction: column; align-items: center; gap: 32px;
            padding: 32px 16px 16px; border-radius: 32px; text-align: center;
            background:
                radial-gradient(85% 50% at 20% 4%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0) 55%),   /* brillito sup-izq */
                radial-gradient(65% 42% at 84% 6%, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 50%),   /* brillito sup-der */
                rgba(255,255,255,0.10);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.40), inset 0 1px 0 rgba(255,255,255,0.35);     /* + brillo borde superior */
            -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
            animation: resetPop .28s cubic-bezier(.22,.61,.36,1) both;
        }
        .ep-icon {
            width: 66px; height: 66px; border-radius: 50%; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.20); border: 1px solid rgba(255,255,255,0.20); color: #cfe6ef;   /* fondo blanco 20% (tu ajuste) */
        }
        .ep-body { display: flex; flex-direction: column; gap: 14px; }
        .ep-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 20px; line-height: 130%; color: #fff; margin: 0; }
        .ep-text { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 14px; line-height: 150%; color: rgba(255,255,255,0.80); margin: 0; }
        .ep-text b { color: #fff; font-weight: 600; }
        .ep-btn {
            width: 100%; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; color: #fff;
            background: rgba(255,255,255,0.06); border: 0; box-shadow: inset 0 0 0 1px #05BAEE;   /* borde azul */
            padding: 14px 24px; border-radius: 8px; cursor: pointer; transition: background .2s, color .2s;
        }
        .ep-btn:hover, .ep-btn:active, .ep-btn:focus { background: #05BAEE; color: #fff; }   /* al click → azul total */

        /* Hamburguesa (solo móvil) */
        .etapa-burger { display: none; align-items: center; justify-content: center; width: 30px; height: 30px; color: #05BAEE; background: none; border: 0; cursor: pointer; padding: 0; }
        .etapa-backdrop { display: none; }
        .etapa-glow { display: none; }   /* globo de luz, solo móvil */
        .etapa-juan-m { display: none; }   /* imagen con piso, solo móvil */
        .etapa-bg-glows { display: none; }   /* globos de fondo, solo móvil */

        /* ===================== MÓVIL (≤767px) ===================== */
        @media (max-width: 767px) {
            html, body { height: auto !important; }
            body { overflow: visible !important; display: block !important; min-height: 100vh; }

            /* Top bar móvil: hamburguesa + score + corazón */
            .etapa-top {
                position: sticky; top: 0; z-index: 60;
                height: 66px !important; padding: 0 16px !important; gap: 16px;
                background:
                    radial-gradient(130% 190% at 50% 0%, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0.05) 45%, rgba(255,255,255,0) 75%),
                    #0a0a0c !important;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
                box-shadow: 0 0.5px 0 0 #BFBFBF !important;   /* borde inferior 0.5 #BFBFBF outer */
                border-bottom: 0 !important;
            }
            .top-left { width: auto !important; flex: 0 0 auto; gap: 10px; }
            .top-name, .top-center, .top-back { display: none !important; }   /* móvil: solo hamburguesa */
            .etapa-burger { display: inline-flex !important; }
            .top-right { flex: 1; display: flex; align-items: center; gap: 12px; justify-content: flex-start; }
            /* Texto "X / 450 Exp" (Medium 14 · ls 2% · blanco, sin "Score:") */
            .top-scope { font-weight: 500 !important; font-size: 14px !important; letter-spacing: 0.02em !important; color: #FFFFFF !important; flex: 0 0 auto; white-space: nowrap; }
            .top-scope b { font-weight: 500 !important; color: #FFFFFF !important; }
            .sc-pre { display: none; }            /* sin "Score:" */
            .sc-max { display: inline; }           /* sí "/ 450" */
            /* Barra 8px · radius 99 · #D4D4D4 (borde 0.5) */
            .score-bar { flex: 1; height: 8px !important; background: #D4D4D4 !important; border-radius: 99px !important; box-shadow: 0 0 0 0.5px #D4D4D4; }
            /* Corazón = imagen experiencia global 32×32 */
            .top-heart { flex: 0 0 auto; }
            .heart-desktop { display: none; }
            .heart-mobile { display: block !important; width: 32px; height: 32px; }

            /* Sidebar de etapas → drawer lateral (se abre con la hamburguesa, no tapa) */
            .etapa-body { display: block !important; }
            .etapa-side {
                position: fixed !important; top: 0; left: 0; bottom: 0; width: 300px; max-width: 85vw;
                z-index: 100; transform: translateX(-100%); transition: transform .28s ease;
                box-shadow: 2px 0 24px rgba(0,0,0,0.55);
            }
            .etapa-side.open { transform: translateX(0); }
            .etapa-backdrop { display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; opacity: 0; pointer-events: none; transition: opacity .28s; }
            .etapa-backdrop.open { opacity: 1; pointer-events: auto; }

            /* ===== Drawer móvil: header "Avance del caso" + barra + ✕ ; y botón "Salir del caso" ===== */
            .side-head { display: flex; align-items: center; gap: 10px; padding: 16px 18px; border-bottom: 1px solid rgba(255,255,255,0.10); flex-shrink: 0; }
            .side-close { display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; background: none; border: 0; color: #fff; cursor: pointer; padding: 0; }
            .side-head-lbl { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; color: #fff; white-space: nowrap; }
            .side-head-bar { flex: 1; height: 6px; min-width: 24px; }
            .side-head-pct { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 12px; color: #fff; flex-shrink: 0; }
            .side-salir { display: block; margin: 14px 16px 18px; padding: 13px; text-align: center; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.20); border-radius: 8px; color: #fff; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; text-decoration: none; }
            .side-salir:hover { background: rgba(255,255,255,0.14); }

            /* ===== Contenido: reflow a COLUMNA (rough — luego detalle) ===== */
            .etapa-main { width: 100% !important; display: block !important; overflow: visible !important; align-items: stretch !important; justify-content: flex-start !important; }
            .main-stage { width: 100% !important; height: auto !important; transform: none !important; padding: 20px 16px !important; }
            .content-col { width: 100% !important; }
            .seg-top { position: static !important; top: auto !important; right: auto !important; display: inline-flex; margin: 0 0 18px; }
            .view { position: static !important; inset: auto !important; }
            .view-scroll, #view-biblio { overflow: visible !important; bottom: auto !important; }
            /* Juan en flujo, centrado abajo */
            .etapa-juan {
                position: relative !important; right: auto !important; top: auto !important;
                width: 390px !important; max-width: none !important; margin: 24px -16px 0 !important;   /* full-bleed (borde a borde) */
                height: 480px !important; overflow: hidden;
                -webkit-mask-image: linear-gradient(to bottom, #000 86%, transparent 100%);
                mask-image: linear-gradient(to bottom, #000 86%, transparent 100%);                   /* desvanecido inferior */
            }
            .etapa-juan .etapa-rings, .etapa-juan-d { display: none !important; }   /* móvil: la imagen ya trae el piso/círculos */
            .etapa-juan-m {
                display: block !important; position: absolute !important;
                left: 0 !important; top: -85px !important;                          /* sube → recorta el vacío de arriba */
                width: 390px !important; max-width: none !important; height: auto !important; margin: 0 !important;
                -webkit-mask-image: none !important; mask-image: none !important;
            }
            /* Botón "Siguiente etapa": fill · hug 45 · radius 4 · borde 1px #2F728C · pad 12/24 · blanco 10% · blur 40 */
            .btn-next {
                position: static !important; right: auto !important; bottom: auto !important;
                display: block; width: 100%; margin-top: 4px !important; text-align: center;   /* tu ajuste */
                padding: 12px 24px !important; line-height: 21px !important;                  /* hug 45 */
                background: rgba(255,255,255,0.22) !important;                                /* blanco 22% (tu ajuste) */
                border: 0 !important; box-shadow: inset 0 0 0 1px #2F728C !important;
                border-radius: 4px !important;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
            }
            .biblio-next { margin-top: 24px !important; }   /* gap antes del botón Siguiente en Bibliografía */
            /* Etapa de video corto (Puntos clave): el contenido llena el viewport y "Siguiente etapa" se ancla al fondo */
            .main-stage:has(.video-full) { display: flex !important; flex-direction: column; min-height: calc(100dvh - 66px); }
            .main-stage:has(.video-full) .btn-next { margin-top: auto !important; }
            /* Resumen del caso: botones full-width + "Finalizar ingreso" anclado al fondo */
            .btn-descargar { width: 100% !important; justify-content: center; }
            .btn-finalizar { width: 100% !important; }
            .resumen-foot { width: 100%; }
            .main-stage:has(.resumen-card) { display: flex !important; flex-direction: column; min-height: calc(100dvh - 66px); }
            .main-stage:has(.resumen-card) #view-contenido { flex: 1 1 auto; display: flex; flex-direction: column; }
            .main-stage:has(.resumen-card) .riesgo { flex: 1 1 auto; display: flex; flex-direction: column; }
            .main-stage:has(.resumen-card) .resumen-foot { margin-top: auto !important; }
            .main-stage:has(.resumen-card) #view-biblio .biblio-next { margin-top: 32px !important; margin-bottom: 8px; }
            /* Tabs (Perfil/Historia/Medicación/Alergias): scroll horizontal, no desbordan la página */
            .tabs { overflow-x: auto !important; scrollbar-width: none; }
            .tabs::-webkit-scrollbar { display: none; height: 0; }
            .tabs .tab { flex: 0 0 auto !important; }

            /* ===== DETALLE: glow + título + cajas de tabs (specs Figma) ===== */
            .main-stage { position: relative; z-index: 0; overflow-x: clip; }      /* stacking context + contiene el glow */
            .etapa-glow {
                display: block; position: absolute; z-index: -1; pointer-events: none;
                width: 543px; height: 308px; left: 50%; top: 90px; margin-left: -271px;
                background: #FFFFFF; opacity: 0.22; border-radius: 50%; filter: blur(150px);
            }
            /* Globos de luz de fondo (ambiente, distintas esquinas) */
            .etapa-bg-glows { display: block; position: fixed; inset: 0; z-index: -1; pointer-events: none; overflow: hidden; }
            .etapa-bg-glows span { position: absolute; border-radius: 50%; }
            .etapa-bg-glows span:nth-child(1) { width: 300px; height: 240px; top: -50px;  left: -90px;  background: rgba(255,255,255,0.12); filter: blur(100px); }
            .etapa-bg-glows span:nth-child(2) { width: 260px; height: 230px; top: 110px;  right: -100px; background: rgba(5,186,238,0.14);  filter: blur(110px); }
            .etapa-bg-glows span:nth-child(3) { width: 300px; height: 260px; bottom: 200px; left: -110px; background: rgba(130,225,252,0.10); filter: blur(120px); }
            .etapa-bg-glows span:nth-child(4) { width: 340px; height: 280px; bottom: -70px; right: -90px;  background: rgba(5,186,238,0.12);  filter: blur(120px); }
            /* Título "Presentación del caso" SemiBold 22/140% #05BAEE */
            .h-caso { font-size: 22px !important; line-height: 140% !important; margin-bottom: 16px !important; }   /* menos espacio → sube el toggle */
            /* "Motivo de consulta" (h+p): lo subo un poco + gap interno 8 (img1) */
            .h-sec:has(+ .motivo-p) { margin-top: -16px !important; margin-bottom: 8px !important; }
            /* ===== Bibliografía: borrar "Presentación del caso" duplicado + texto Regular 14 + subir título ===== */
            #view-biblio .h-caso { display: none !important; }                                   /* duplicado fuera */
            #view-biblio .biblio-list { overflow: visible !important; flex: none !important; padding-right: 0 !important; }
            .biblio-item { font-weight: 400 !important; font-size: 14px !important; line-height: 150% !important; }   /* Regular 14/150% (img1) */
            .biblio-h { margin-top: -8px !important; }                                            /* sube el título "Bibliografía" */
            /* ===== Quiz: opciones a 1 columna (la grilla 2×2 no cabe en móvil) ===== */
            .pregunta-opts { grid-template-columns: 1fr !important; }
            .pregunta-opts .opt { border-right: 0 !important; border-bottom: 1px solid rgba(255,255,255,0.14) !important; padding: 16px 20px !important; }
            .pregunta-opts .opt:last-child { border-bottom: 0 !important; }
            .pregunta-head { padding: 22px 20px 16px !important; }
            /* Pie en columna: Comprobar (aparece al seleccionar) arriba, Siguiente, Repetir; todos full-width */
            .pregunta-foot { flex-direction: row !important; flex-wrap: wrap !important; align-items: stretch !important; padding: 16px 20px !important; gap: 10px !important; }
            .pregunta-foot .foot-spacer { display: none !important; }
            .pregunta-foot .btn-comprobar { order: 1; flex: 1 0 100% !important; width: auto !important; padding: 12px !important; font-size: 14px !important; }   /* arriba, full-width */
            .pregunta-foot .btn-repetir  { order: 2; flex: 1 1 0 !important; width: auto !important; justify-content: center; gap: 6px !important; padding: 12px 8px !important; font-size: 13px !important; white-space: nowrap; }   /* abajo-izq */
            .pregunta-foot .btn-next-q   { order: 3; flex: 1 1 0 !important; width: auto !important; padding: 12px 8px !important; font-size: 13px !important; white-space: nowrap; }   /* abajo-der */
            /* === "Frases" iguales: todo el cuerpo de texto al MISMO tamaño (14 / 150%) === */
            .perfil-card p, .motivo-p, .prueba-p, .pregunta-q, .pregunta-sub,
            .analitica-intro, .analitica-list, .opt, .video-cap, .biblio-item {
                font-size: 14px !important; line-height: 150% !important;
            }
            /* Cajas de tabs: borde 1px #2F728C · pad 4 · gap 8 · blanco 10% · blur 40 */
            .seg-top, .tabs {
                width: 100% !important; display: flex !important; gap: 8px !important; padding: 4px !important;
                background: rgba(255,255,255,0.10) !important; border: 1px solid #2F728C !important;
                border-radius: 0 !important;                            /* cajas cuadradas (img1); los botones internos siguen redondeados */
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
            }
            .seg-top button, .tabs .tab {
                font-weight: 500 !important; font-size: 12px !important; line-height: 150% !important; letter-spacing: 0.01em !important; padding: 8px 14px !important;
                border-radius: 6px !important;                          /* botones un poco redondeados */
            }
            .seg-top button { flex: 1 !important; }
            .seg-top button.on, .tabs .tab.on { color: #454545 !important; }
        }
    </style>
</head>
<body>
    <div class="etapa-page">

        {{-- Globos de luz de fondo (ambiente, solo móvil) --}}
        <div class="etapa-bg-glows" aria-hidden="true"><span></span><span></span><span></span><span></span></div>

        {{-- ===== TOP BAR ===== --}}
        <header class="etapa-top">
            <div class="top-left">
                <button type="button" class="etapa-burger" aria-label="Etapas"
                        onclick="document.querySelector('.etapa-side').classList.toggle('open');document.querySelector('.etapa-backdrop').classList.toggle('open')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
                <a href="{{ route('curso') }}" class="top-back" aria-label="Volver">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <span class="top-name">{{ $curso['paciente']['nombre'] }}</span>
            </div>

            <div class="top-center">
                <span class="top-lbl">Avance del caso</span>
                <span class="bar" style="width:340px;"><i style="width:{{ $avance }}%"></i></span>
                <span class="top-pct">{{ $avance }}%</span>
            </div>

            <div class="top-right">
                <span class="top-scope"><span class="sc-pre">Score: </span><b><span id="xp-val">{{ $exp ?? 0 }}</span><span class="sc-max"> / {{ $maxScore ?? 450 }}</span> Exp</b></span>
                @php $mx = max(1, $maxScore ?? 450); $gW = max(0, min(100, ($exp ?? 0) / $mx * 100)); $rW = max(0, min(100 - $gW, ($rojoBase ?? 0) / $mx * 100)); @endphp
                <span class="bar score-bar" id="score-bar" data-verde="{{ $verdeBase ?? 0 }}" data-rojo="{{ $rojoBase ?? 0 }}" data-max="{{ $mx }}" style="width:120px;"><i id="xp-green" class="green" style="width:{{ $gW }}%"></i><i id="xp-red" class="red" style="width:{{ $rW }}%"></i></span>
                <span class="top-heart">
                    <svg class="heart-desktop" width="30" height="30" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35c-.3 0-.6-.1-.84-.3C7.2 17.66 2.5 13.88 2.5 9.6 2.5 6.5 4.9 4.5 7.4 4.5c1.8 0 3.42.94 4.6 2.42C13.18 5.44 14.8 4.5 16.6 4.5c2.5 0 4.9 2 4.9 5.1 0 4.28-4.7 8.06-8.66 11.45-.24.2-.54.3-.84.3Z"/></svg>
                    <img class="heart-mobile" src="{{ asset('images/experiencia-global.png') }}" alt="Experiencia" width="32" height="32">
                </span>
            </div>
        </header>

        {{-- ===== CUERPO ===== --}}
        <div class="etapa-body">

            {{-- Sidebar de etapas --}}
            <aside class="etapa-side">
                {{-- Header del drawer (solo móvil): ✕ + Avance del caso + barra de progreso --}}
                <div class="side-head">
                    <button type="button" class="side-close" aria-label="Cerrar menú"
                            onclick="document.querySelector('.etapa-side').classList.remove('open');document.querySelector('.etapa-backdrop').classList.remove('open')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                    <span class="side-head-lbl">Avance del caso</span>
                    <span class="bar side-head-bar"><i style="width:{{ $avance }}%"></i></span>
                    <span class="side-head-pct">{{ $avance }}%</span>
                </div>
                @foreach ($etapasEstado as $etapa)
                    @php $clickable = in_array($etapa['estado'], ['perfecta', 'error', 'activa']); @endphp
                    <a href="{{ $clickable ? route('curso.etapa', [$ingreso, $etapa['key']]) : '#' }}"
                       class="side-item {{ $etapa['estado'] }} {{ $etapa['viendo'] ? 'viendo' : '' }}"
                       @unless($clickable) onclick="return false;" @endunless>
                        <span>{{ $etapa['titulo'] }}</span>
                        @if ($etapa['estado'] === 'perfecta')
                            {{-- check verde (etapa superada sin errores) --}}
                            <svg class="ico" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><circle cx="12" cy="12" r="9"/><path d="m8.4 12 2.4 2.4 4.8-5.2"/></svg>
                        @elseif ($etapa['estado'] === 'error')
                            {{-- cruz roja (etapa superada con algún fallo) --}}
                            <svg class="ico" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/></svg>
                        @elseif ($etapa['estado'] === 'activa')
                            {{-- reloj (activa) --}}
                            <svg class="ico" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        @else
                            {{-- candado (bloqueada) --}}
                            <svg class="ico" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                        @endif
                    </a>
                @endforeach

                {{-- Área azul al final del menú --}}
                <div class="side-bottom"></div>
                {{-- Salir del caso (solo móvil; en desktop hay flecha de volver en la barra) --}}
                <a href="{{ route('curso') }}" class="side-salir">Salir del caso</a>
            </aside>

            {{-- Backdrop del drawer (móvil) --}}
            <div class="etapa-backdrop" onclick="document.querySelector('.etapa-side').classList.remove('open');this.classList.remove('open')"></div>

            {{-- Main --}}
            <main class="etapa-main">
              <div class="main-stage">
                <div class="etapa-glow" aria-hidden="true"></div>

                {{-- Toggle Contenido / Bibliografía --}}
                <div class="seg seg-top">
                    <button type="button" id="tab-contenido" class="on">Contenido</button>
                    <button type="button" id="tab-biblio">Bibliografía</button>
                </div>

                {{-- Vista: Contenido (cambia por etapa) --}}
                <div id="view-contenido" class="view @if($etapaActual !== 'presentacion') view-scroll @endif">
                    @if (view()->exists('curso.etapas.' . $etapaActual . '-contenido'))
                        @include('curso.etapas.' . $etapaActual . '-contenido')
                    @else
                        <h1 class="h-caso">{{ collect($etapasEstado)->firstWhere('key', $etapaActual)['titulo'] ?? 'Etapa' }}</h1>
                        <p class="prueba-p" style="margin-top:10px;">Contenido en construcción.</p>
                    @endif
                </div>

                {{-- Vista: Bibliografía (cambia por etapa) --}}
                <div id="view-biblio" class="view" style="display:none;">
                    @includeIf('curso.etapas.' . $etapaActual . '-biblio')
                    {{-- En etapas con quiz el botón "Siguiente etapa" vive dentro del cuestionario (Contenido, aquí oculto);
                         agregamos uno en Bibliografía que envía ese mismo form para poder avanzar. --}}
                    @if (in_array($etapaActual, ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2', 'resumen']))
                        <button type="button" class="btn-next biblio-next"
                                onclick="var f=document.querySelector('#view-contenido form'); if(f){ f.submit(); }">{{ $esUltimaEtapa ? 'Finalizar ingreso' : 'Siguiente etapa' }}</button>
                    @endif
                </div>

                {{-- Paciente (solo en Presentación) --}}
                @if ($etapaActual === 'presentacion')
                <div class="etapa-juan">
                    {{-- anillos en la base (solo desktop; en móvil la imagen ya los trae) --}}
                    <svg class="etapa-rings" style="position:absolute; left:50%; bottom:6px; transform:translateX(-50%); opacity:.5;" width="460" height="120" viewBox="0 0 460 120" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 4; $r++)
                            <ellipse cx="230" cy="105" rx="{{ $r * 52 }}" ry="{{ $r * 13 }}" stroke="#7fa6b2" stroke-width="1" opacity="{{ 0.5 - $r * 0.1 }}"/>
                        @endfor
                    </svg>
                    <img class="etapa-juan-d" src="{{ asset($curso['paciente']['imagen']) }}" alt="{{ $curso['paciente']['nombre'] }}">
                    <img class="etapa-juan-m" src="{{ asset('images/paciente.png') }}" alt="{{ $curso['paciente']['nombre'] }}">
                </div>
                @endif

                {{-- Siguiente etapa (botón flotante; las etapas con cuestionario llevan el suyo dentro) --}}
                @unless (in_array($etapaActual, ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2', 'resumen']))
                <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" id="form-avanzar" style="display:contents;">
                    @csrf
                    <input type="hidden" name="desde" value="{{ $etapaActual }}">
                    <button type="button" class="btn-next" onclick="document.getElementById('etapa-popup').removeAttribute('hidden')">{{ $esUltimaEtapa ? 'Finalizar ingreso' : 'Siguiente etapa' }}</button>
                </form>
                @endunless

              </div>{{-- /main-stage --}}
            </main>
        </div>

        {{-- Pop-up "Atención: más de una respuesta correcta" (al darle Siguiente etapa) --}}
        <div class="etapa-popup" id="etapa-popup" hidden>
            <div class="ep-card" role="dialog" aria-modal="true" aria-labelledby="ep-title">
                <span class="ep-icon">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9.5"/><path d="M12 16.5v-5"/><path d="M12 8h.01"/></svg>
                </span>
                <div class="ep-body">
                    <h3 class="ep-title" id="ep-title">Atención: puede haber más de una respuesta correcta</h3>
                    <p class="ep-text">En algunas preguntas <b>puede haber una, dos o tres opciones correctas</b>. Aunque el botón <b>"Siguiente etapa"</b> se active al seleccionar una respuesta válida, tu objetivo es identificar todas las opciones correctas antes de avanzar. Para <b>repetir una pregunta</b>, pulsa <b>"Siguiente etapa"</b> y luego <b>vuelve</b> al <b>capítulo marcado en rojo</b>. Desde ahí podrás <b>repetir únicamente esa pregunta</b>.</p>
                </div>
                <button type="button" class="ep-btn" onclick="document.getElementById('form-avanzar').submit()">Entendido</button>
            </div>
        </div>

        {{-- Modal: Reiniciar capítulo (confirmación de "Repetir etapa") --}}
        @if (in_array($etapaActual, ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2']))
        <div class="reset-modal" id="reset-modal" hidden>
            <div class="reset-card" role="dialog" aria-modal="true" aria-labelledby="reset-title">
                <span class="reset-ico">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </span>
                <h3 class="reset-title" id="reset-title">Reiniciar etapa</h3>
                <p class="reset-text">Vas a repetir este capítulo. Si continúas, se eliminarán tus respuestas y los puntos obtenidos solo en esta sección. El resto de tu progreso no se verá afectado.<br><strong>¿Quieres reiniciar este capítulo?</strong></p>
                <div class="reset-actions">
                    <button type="button" class="reset-cancel" id="reset-cancel">Cancelar</button>
                    <form method="POST" action="{{ route('curso.reiniciar', $ingreso) }}" style="margin:0;">
                        @csrf
                        <input type="hidden" name="etapa" value="{{ $etapaActual }}">
                        <button type="submit" class="reset-confirm" id="reset-confirm">Reiniciar etapa</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Lightbox para ampliar imágenes (ECG, cateterismo) + descargar --}}
        <div class="img-lightbox" id="img-lightbox" hidden>
            <div class="lb-bar">
                <a class="lb-btn lb-download" id="lb-download" href="#" download>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
                    Descargar
                </a>
                <button type="button" class="lb-btn lb-close" id="lb-close" aria-label="Cerrar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <div class="lb-stage" id="lb-stage">
                <img id="lb-img" class="lb-img" src="" alt="">
            </div>
            <p class="lb-caption" id="lb-caption"></p>
        </div>

        {{-- Pop-up de resultado/medalla, sobre la etapa difuminada (al "Finalizar ingreso") --}}
        @if (!empty($mostrarResultado) && !empty($medalla))
        <div class="result-modal" id="result-modal">
            <div class="result-panel">
                @php
                    $medImg  = 'images/medalla-' . $medalla['key'] . '.png';   // corazón de la medalla
                    $juanImg = 'images/juan-' . $medalla['key'] . '.png';       // Juan según la medalla/expresión
                @endphp
                <div class="rp-left">
                    @if (file_exists(public_path($medImg)))
                        <img class="rp-medal" src="{{ asset($medImg) }}" alt="{{ $medalla['label'] }}">
                    @else
                        {{-- Respaldo: corazón vectorial del color del nivel hasta que se suba la imagen --}}
                        <svg class="rp-medal" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="{{ $medalla['color'] }}" stroke="rgba(255,255,255,0.45)" stroke-width="0.9"/>
                        </svg>
                    @endif
                    <h2 class="rp-title">{{ $medalla['titulo'] }}</h2>
                    <p class="rp-text">{{ $medalla['texto'] }}</p>
                    <div class="rp-actions">
                        @foreach ($medalla['botones'] as $b)
                            @php
                                $href = ($b['accion'] ?? '') === 'mejorar'
                                    ? route('curso.etapa', [$ingreso, 'resumen'])   // cierra el modal y vuelve a la etapa a repasar
                                    : route('curso');                                // temario / finalizar → portal
                            @endphp
                            <a class="rp-btn {{ ($b['estilo'] ?? '') === 'cyan' ? 'cyan' : '' }}" href="{{ $href }}">{{ $b['texto'] }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="rp-right">
                    <svg class="rp-rings" width="280" height="84" viewBox="0 0 280 84" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 3; $r++)
                            <ellipse cx="140" cy="74" rx="{{ $r * 44 }}" ry="{{ $r * 10 }}" stroke="#7fa6b2" stroke-width="1" opacity="{{ 0.5 - $r * 0.12 }}"/>
                        @endfor
                    </svg>
                    {{-- Juan de la medalla si existe; si no, el Juan normal --}}
                    <img class="rp-juan" src="{{ file_exists(public_path($juanImg)) ? asset($juanImg) : asset($curso['paciente']['imagen']) }}" alt="{{ $curso['paciente']['nombre'] }}">
                </div>
            </div>
        </div>
        @endif

        {{-- Pop-up "¡Medalla alcanzada!" durante el curso (mismo estilo que el final, centrado y sin Juan) --}}
        <div class="result-modal" id="medal-unlock" hidden>
            <div class="result-panel">
                <div class="rp-left">
                    <img class="rp-medal" id="mu-medal" src="" alt="Medalla">
                    <h2 class="rp-title" id="mu-title"></h2>
                    <p class="rp-text" id="mu-text"></p>
                    <div class="rp-actions">
                        <button type="button" class="rp-btn cyan" id="mu-continue">Continuar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /etapa-page --}}

    @php
        // Medallas que se ANUNCIAN al alcanzar su puntaje durante el curso (sin medalla no se celebra).
        $medallasUnlock = collect($curso['medallas'] ?? [])
            ->filter(fn ($m) => (int) ($m['min'] ?? 0) > 0)
            ->map(function ($m) {
                $img = 'images/medalla-' . $m['key'] . '.png';
                return [
                    'min'    => (int) $m['min'],
                    'titulo' => $m['unlock']['titulo'] ?? ('¡' . ($m['label'] ?? 'Medalla') . ' alcanzada!'),
                    'texto'  => $m['unlock']['texto'] ?? ($m['texto'] ?? ''),
                    'img'    => file_exists(public_path($img)) ? asset($img) : '',
                ];
            })->sortBy('min')->values()->all();
    @endphp

    <script>
        // Layout fluido (llena toda la pantalla). El contenido del main se escala para
        // caber/llenar sin scroll; los márgenes que queden son del mismo teal (no se ven).
        (function () {
            function scaleMainStage() {
                var main = document.querySelector('.etapa-main');
                var stage = document.querySelector('.main-stage');
                if (!main || !stage) return;
                if (window.innerWidth < 768) { stage.style.transform = ''; return; }   // móvil: sin escalado (layout en columna)
                if (!main.clientWidth || !main.clientHeight) { requestAnimationFrame(scaleMainStage); return; }
                var s = Math.min(main.clientWidth / 1080, main.clientHeight / 824);
                s = Math.min(Math.max(s, 0.2), 1.6);   // tope alto → en pantallas grandes el contenido llena más
                stage.style.transform = 'scale(' + s + ')';
            }
            // Móvil: mueve el título del caso (.h-caso) ARRIBA del toggle Contenido/Bibliografía
            function moveCasoTitle() {
                if (window.innerWidth >= 768) return;
                var seg = document.querySelector('.seg-top');
                var h = document.querySelector('#view-contenido .h-caso');
                if (seg && h && !seg.previousElementSibling?.classList?.contains('h-caso')) seg.parentNode.insertBefore(h, seg);
            }
            setTimeout(scaleMainStage, 250);
            window.addEventListener('resize', scaleMainStage);
            window.addEventListener('load', scaleMainStage);
            if (document.readyState !== 'loading') { scaleMainStage(); moveCasoTitle(); }
            else document.addEventListener('DOMContentLoaded', function () { scaleMainStage(); moveCasoTitle(); });
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleMainStage);
            // Móvil: al tocar un tab (Perfil/Historia/Medicación/Alergias) lo trae a la vista (scroll horizontal)
            document.addEventListener('click', function (e) {
                var t = e.target.closest('.tabs .tab');
                if (t && window.innerWidth < 768) t.scrollIntoView({ block: 'nearest', inline: 'center', behavior: 'smooth' });
            });
        })();

        // ===== Toggle Contenido / Bibliografía =====
        (function () {
            var tabC = document.getElementById('tab-contenido');
            var tabB = document.getElementById('tab-biblio');
            var viewC = document.getElementById('view-contenido');
            var viewB = document.getElementById('view-biblio');
            var juan = document.querySelector('.etapa-juan');
            if (!tabC || !tabB || !viewC || !viewB) return;
            function show(biblio) {
                tabB.classList.toggle('on', biblio);
                tabC.classList.toggle('on', !biblio);
                viewB.style.display = biblio ? 'flex' : 'none';
                viewC.style.display = biblio ? 'none' : 'block';
                if (juan) juan.style.display = biblio ? 'none' : 'block';
            }
            tabC.addEventListener('click', function () { show(false); });
            tabB.addEventListener('click', function () { show(true); });
        })();

        // ===== Pestañas genéricas (sirve para cualquier etapa) =====
        // Cada .tabs cambia los [data-panel] que estén dentro de su propio contenedor.
        (function () {
            document.querySelectorAll('.tabs').forEach(function (tabsEl) {
                var scope = tabsEl.closest('.tabs-scope') || tabsEl.parentElement;
                var tabs = tabsEl.querySelectorAll('.tab');
                tabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        var key = tab.getAttribute('data-tab');
                        tabs.forEach(function (t) { t.classList.toggle('on', t === tab); });
                        scope.querySelectorAll('[data-panel]').forEach(function (p) {
                            p.style.display = (p.getAttribute('data-panel') === key) ? 'block' : 'none';
                        });
                    });
                });
            });
        })();

        // ===== Pop-up de medalla alcanzada (se anuncia al cruzar el puntaje durante el curso) =====
        (function () {
            var modal = document.getElementById('medal-unlock');
            if (!modal) return;
            var MED = @json($medallasUnlock);   // ordenadas asc por 'min'
            var sb = document.getElementById('score-bar');
            var inicial = sb ? ((parseInt(sb.getAttribute('data-verde'), 10) || 0) - (parseInt(sb.getAttribute('data-rojo'), 10) || 0)) : 0;
            function idxFor(s) { var i = -1; MED.forEach(function (m, k) { if (s >= m.min) i = k; }); return i; }
            var anunciada = idxFor(inicial);    // medallas ya logradas al cargar: NO se vuelven a anunciar

            var imgEl = document.getElementById('mu-medal');
            function abrir(m) {
                if (m.img) { imgEl.src = m.img; imgEl.style.display = ''; } else { imgEl.style.display = 'none'; }
                document.getElementById('mu-title').textContent = m.titulo;
                document.getElementById('mu-text').textContent = m.texto;
                modal.hidden = false;
            }
            function cerrar() { modal.hidden = true; }
            document.getElementById('mu-continue').addEventListener('click', cerrar);
            modal.addEventListener('click', function (e) { if (e.target === modal) cerrar(); });

            // Lo llama el cuestionario tras cada "Comprobar" con el Score global actualizado.
            window.checkMedalUnlock = function (score) {
                var i = idxFor(score);
                if (i > anunciada) { anunciada = i; abrir(MED[i]); }
            };
        })();

        // ===== Cuestionario interactivo (puntaje por opción; admite varias correctas) =====
        (function () {
            var card = document.getElementById('cuestionario');
            if (!card) return;
            var xpVal = document.getElementById('xp-val');
            var scoreBar = document.getElementById('score-bar');
            var green = document.getElementById('xp-green');
            var red   = document.getElementById('xp-red');
            var maxScore  = scoreBar ? (parseInt(scoreBar.getAttribute('data-max'), 10) || 450) : 450;
            var baseVerde = scoreBar ? (parseInt(scoreBar.getAttribute('data-verde'), 10) || 0) : 0;
            var baseRojo  = scoreBar ? (parseInt(scoreBar.getAttribute('data-rojo'), 10) || 0) : 0;
            var liveVerde = 0, liveRojo = 0;      // aporte de esta etapa (el rojo NO se recupera)
            var marcadas = {};                    // opciones ya puntuadas (key -> true), no recontar

            var comprobar = card.querySelector('.btn-comprobar');
            var repetir   = card.querySelector('.btn-repetir');
            var sigBtn    = card.querySelector('.btn-next-q');
            var justif    = card.querySelector('.justif');
            var justifTxt = card.querySelector('.justif-txt');
            var resultado = card.querySelector('.resultado');
            var resIco    = card.querySelector('.resultado-ico');
            var resTxt    = card.querySelector('.resultado-txt');
            var selInput  = document.getElementById('cuest-sel');
            var totalOpts = card.querySelectorAll('input[name="pregunta"]').length;
            function sincronizarSel() { if (selInput) selInput.value = Object.keys(marcadas).join(','); }

            var etapaKey  = card.getAttribute('data-etapa') || '';
            var marcarUrl = card.getAttribute('data-marcar') || '';
            var csrf      = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

            // Guarda al instante en el servidor las opciones marcadas (al Comprobar), SIN avanzar:
            // así el Score y la cruz persisten aunque navegues a otra etapa por el menú izquierdo.
            function persistir() {
                if (!marcarUrl) return;
                fetch(marcarUrl, {
                    method: 'POST',
                    keepalive: true,   // sobrevive aunque recargues (F5) justo después de responder
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                    body: 'etapa=' + encodeURIComponent(etapaKey) + '&sel=' + encodeURIComponent(Object.keys(marcadas).join(','))
                }).catch(function () {});
            }

            // (Sin beacon en 'pagehide': el guardado por "Comprobar" ya usa fetch keepalive, que sobrevive al F5.
            //  Un beacon en pagehide PISABA el "Reiniciar capítulo": al navegar re-guardaba la etapa con el
            //  fallo anterior y volvía a poner la X. Con keepalive el F5 queda cubierto sin esa carrera.)

            // Pinta la X (cruz roja) en el item del menu de ESTA etapa apenas hay un fallo (sin esperar a avanzar).
            function marcarCruzMenu() {
                var item = document.querySelector('.etapa-side .side-item.viendo');
                if (!item || item.classList.contains('error')) return;
                item.classList.remove('activa', 'perfecta');
                item.classList.add('error');
                var ico = item.querySelector('.ico');
                if (ico) ico.innerHTML = '<circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/>';
            }

            function pintarBarra() {
                var verde = baseVerde + liveVerde, rojo = baseRojo + liveRojo;
                var exp = verde - rojo;                         // EXP = verde - rojo (el rojo nunca baja)
                if (xpVal) xpVal.textContent = exp;
                var g = Math.max(0, Math.min(100, exp / maxScore * 100));
                var r = Math.max(0, Math.min(100 - g, rojo / maxScore * 100));
                if (green) green.style.width = g + '%';
                if (red) red.style.width = r + '%';
            }

            // Re-pinta las opciones ya marcadas en intentos previos (al volver, el rojo permanece visible).
            // OJO: estas YA están contabilizadas en el Score base (servidor); aquí NO se re-suman al vivo,
            // solo se deja la marca y se desbloquea "Siguiente" si ya había alguna correcta.
            (card.getAttribute('data-presel') || '').split(',').filter(Boolean).forEach(function (key) {
                var input = card.querySelector('input[name="pregunta"][value="' + key + '"]');
                if (!input || marcadas[key]) return;
                var opt = input.closest('.opt');
                var pts = parseInt(opt.getAttribute('data-puntos'), 10) || 0;
                opt.classList.add(pts > 0 ? 'correct' : 'wrong');
                marcadas[key] = true;
                input.disabled = true;
                if (pts > 0) sigBtn.classList.add('enabled');
            });
            pintarBarra();
            sincronizarSel();
            if (Object.keys(marcadas).length >= totalOpts) comprobar.disabled = true;

            // "Comprobar" aparece al elegir una opción. "Reiniciar capítulo" lo controla el servidor
            // (visible solo si el capítulo tiene error); aquí no se muestra por el simple hecho de seleccionar.
            card.querySelectorAll('input[name="pregunta"]').forEach(function (r) {
                r.addEventListener('change', function () { comprobar.hidden = false; });
            });

            // Chevron de la justificación: colapsa/expande el texto
            var justToggle = card.querySelector('.justif-toggle');
            if (justToggle) justToggle.addEventListener('click', function () {
                var col = justif.classList.toggle('collapsed');
                justToggle.setAttribute('aria-expanded', col ? 'false' : 'true');
            });

            comprobar.addEventListener('click', function () {
                var sel = card.querySelector('input[name="pregunta"]:checked');
                if (!sel) return;                       // requiere una opción
                comprobar.classList.add('comprobado');  // se pinta de azul al comprobar
                var key = sel.value;
                if (marcadas[key]) { return; }   // ya puntuada: no recuenta
                var opt = sel.closest('.opt');
                var pts = parseInt(opt.getAttribute('data-puntos'), 10) || 0;
                var correcta = pts > 0;                 // correcta = puntos positivos
                var xp = Math.abs(pts);

                opt.classList.add(correcta ? 'correct' : 'wrong');   // queda marcada
                justifTxt.textContent = opt.getAttribute('data-justif') || '';
                justif.hidden = false;

                marcadas[key] = true;
                sel.disabled = true;                       // esa opción ya no se re-marca
                if (correcta) { liveVerde += pts; } else { liveRojo += xp; }   // el rojo NO se recupera
                pintarBarra();
                sincronizarSel();
                persistir();                        // guarda al instante (no espera a "Siguiente etapa")
                if (!correcta) marcarCruzMenu();     // solo pinta la X en el menu; el botón "Reiniciar capítulo"
                                                     // aparece al VOLVER al capítulo (render del servidor), no al fallar
                if (window.checkMedalUnlock) window.checkMedalUnlock((baseVerde + liveVerde) - (baseRojo + liveRojo));

                if (correcta) {
                    resultado.className = 'resultado ok';
                    resIco.textContent = '✓';
                    resTxt.textContent = '¡Excelente!   + ' + xp + ' XP';
                    sigBtn.classList.add('enabled');           // basta una correcta para poder avanzar
                } else {
                    resultado.className = 'resultado bad';
                    resIco.textContent = '✕';
                    resTxt.textContent = '¡Respuesta incorrecta!   - ' + xp + ' XP';
                    // incorrecta: ya sumó al rojo; el sidebar quedará con cruz (rojo>0)
                }
                resultado.hidden = false;
                if (Object.keys(marcadas).length >= card.querySelectorAll('input[name="pregunta"]').length) comprobar.disabled = true;
            });

            // "Repetir etapa" → confirma con el modal "Reiniciar capítulo"
            var modal   = document.getElementById('reset-modal');
            var mCancel = document.getElementById('reset-cancel');
            function cerrarModal() { if (modal) modal.hidden = true; }

            // "Repetir etapa" abre el modal; confirmar reinicia TODO el modulo desde Presentacion (POST a curso.reiniciar)
            repetir.addEventListener('click', function () { if (modal) modal.hidden = false; });
            if (mCancel) mCancel.addEventListener('click', cerrarModal);
            if (modal) modal.addEventListener('click', function (e) { if (e.target === modal) cerrarModal(); });
        })();

        // ===== Lightbox: ampliar imágenes (ECG, cateterismo) con zoom + descargar =====
        (function () {
            var lb      = document.getElementById('img-lightbox');
            var lbImg   = document.getElementById('lb-img');
            var lbCap   = document.getElementById('lb-caption');
            var lbDl    = document.getElementById('lb-download');
            var lbClose = document.getElementById('lb-close');

            function abrir(src, txt) {
                if (!lb) return;
                lbImg.classList.remove('zoom');
                lbImg.src = src;
                lbImg.alt = txt || '';
                lbCap.textContent = txt || '';
                lbDl.href = src;
                lbDl.setAttribute('download', '');     // fuerza descarga (mismo origen)
                lb.hidden = false;
            }
            function cerrar() { if (lb) { lb.hidden = true; lbImg.classList.remove('zoom'); } }

            if (lb) {
                lbImg.addEventListener('click', function () { lbImg.classList.toggle('zoom'); });  // clic = acercar/alejar
                lbClose.addEventListener('click', cerrar);
                lb.addEventListener('click', function (e) { if (e.target === lb || e.target.id === 'lb-stage') cerrar(); });
                document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !lb.hidden) cerrar(); });
            }

            // ECG: botón "ampliar" abre el lightbox
            document.querySelectorAll('.ecg-frame').forEach(function (frame) {
                var img = frame.querySelector('img');
                var exp = frame.querySelector('.ecg-expand');
                if (img && exp) exp.addEventListener('click', function () { abrir(img.getAttribute('src'), img.getAttribute('alt')); });
            });

            // Cateterismo: imágenes → lightbox; vídeos reales → reproducir/pantalla completa
            document.querySelectorAll('.video-player').forEach(function (p) {
                var media  = p.querySelector('img, video');
                if (!media) return;
                var play   = p.querySelector('.vid-play');
                var expand = p.querySelector('.vid-expand');
                var bar    = p.querySelector('.vid-bar > i');
                var capEl  = p.closest('.video-item') ? p.closest('.video-item').querySelector('.video-cap') : null;
                var txt    = capEl ? capEl.textContent.trim() : media.getAttribute('alt');

                if (media.tagName === 'VIDEO') {
                    if (play) play.addEventListener('click', function () { if (media.paused) media.play(); else media.pause(); });
                    if (expand) expand.addEventListener('click', function () { if (media.requestFullscreen) media.requestFullscreen(); });
                    media.addEventListener('timeupdate', function () { if (bar && media.duration) bar.style.width = (media.currentTime / media.duration * 100) + '%'; });
                } else {
                    var open = function () { abrir(media.getAttribute('src'), txt); };
                    if (play) play.addEventListener('click', open);
                    if (expand) expand.addEventListener('click', open);
                }
            });
        })();
    </script>
</body>
</html>
