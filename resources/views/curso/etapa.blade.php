<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        /* Bloqueo de viewport por dispositivo (escala el diseño "como una imagen"):
           teléfono→móvil 390 · tablet→web 1440 (igual que en web, sin desborde) · desktop sin cambios. */
        (function () {
            try {
                var vp = document.querySelector('meta[name="viewport"]');
                var shortSide = Math.min(screen.width || 9999, screen.height || 9999);
                var longSide  = Math.max(screen.width || 0, screen.height || 0);
                var coarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
                if (shortSide < 768) vp.setAttribute('content', 'width=390');
                else if (coarse && shortSide <= 1024 && longSide <= 1400) vp.setAttribute('content', 'width=1440');
            } catch (e) {}
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
        /* perfecta: etapa superada sin errores → texto claro + check verde (clickeable → mano) */
        .side-item.perfecta { color: rgba(255,255,255,0.80); cursor: pointer; }
        .side-item.perfecta .ico { color: #54c06a; }
        /* Etapas no clickeables (check verde superado, o la que se está viendo): sin cursor de mano */
        .side-item.no-click { cursor: default; }
        /* error: etapa superada con algún fallo → texto claro + cruz roja */
        .side-item.error { color: rgba(255,255,255,0.80); cursor: pointer; }
        .side-item.error .ico { color: #d9534f; }
        /* pendiente: etapa en repetición (sin nueva respuesta aún) → texto claro, SIN icono */
        .side-item.pendiente { color: rgba(255,255,255,0.80); cursor: pointer; }
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

        /* padding-right reserva sitio para las pestañas Contenido/Bibliografía (position:absolute
           arriba a la derecha), para que un título largo (p. ej. el del ensayo HORIZON) envuelva
           en vez de cortarse por debajo de ellas. En tablet/móvil las pestañas van en línea → se resetea. */
        .h-caso { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 26px; color: #05BAEE; margin: 0 0 32px; padding-right: 300px; line-height: 130%; }
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
        /* Imagen CUADRADA (p. ej. TC craneal): centrada, tamaño acotado y fondo negro
           (evita que un cuadrado ocupe todo el ancho y se vea enorme). */
        .ecg-frame.is-cuadrada { background: #000; display: flex; align-items: center; justify-content: center; }
        .ecg-frame.is-cuadrada img { width: auto; max-width: 100%; max-height: 460px; margin: 0 auto; }
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
        .resumen-foot { display: flex; justify-content: center; margin-top: 63px; }
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
        /* Contenido editado con Quill dentro de Pruebas: que se vea como el nativo (no toca el default) */
        .cat-block p:not(.prueba-p) { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #d3dee1; margin: 0 0 8px; }
        .analitica-block ul:not(.analitica-list) { list-style: none; margin: 0; padding: 0; max-width: 1000px; }
        .analitica-block ul:not(.analitica-list) li { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 168%; color: #d3dee1; position: relative; padding-left: 20px; }
        .analitica-block ul:not(.analitica-list) li::before { content: '•'; position: absolute; left: 5px; color: #d3dee1; }
        .analitica-sublist { list-style: none; margin: 2px 0 2px 24px; padding: 0; }
        .analitica-sublist li::before { content: '◦'; }

        /* Párrafos/bloques editables con Quill: el contenedor lleva la clase de
           estilo (prueba-p, motivo-p, analitica-intro…) y los <p>/<ul> que Quill
           genera al editar heredan el estilo, sin margen extra ni doble viñeta.
           Con el default (texto plano) el bloque se ve idéntico a un <p>. */
        .rich-p > p { margin: 0; }
        .rich-p > p + p { margin-top: 0.8em; }
        .rich-p > ul, .rich-p > ol { margin: 0.3em 0 0; padding-left: 1.4em; }
        .rich-p b, .rich-p strong { color: #fff; }

        /* --- Robustez del contenido editable con Quill ---
           Al guardar una etapa en el editor, Quill quita las clases originales
           (analitica-list, prueba-p…) y los <li>/<p>/<ul> tomaban el TIPO DE LETRA
           y el COLOR por defecto del navegador (Times, negro) — invisibles/distintos
           sobre el fondo oscuro. Se replica el estilo original (Montserrat, color
           claro, viñeta) para el contenido, tenga o no la clase, de modo que se vea
           EXACTO como antes por más que se edite. El cuestionario/justificaciones
           conservan su propio estilo (regla al final). */
        #view-contenido li { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 168%; color: #d3dee1; }
        #view-contenido li b, #view-contenido li strong { color: #fff; }
        #view-contenido p:not([class]) { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 16px; line-height: 150%; color: #d3dee1; }
        #view-contenido ul:not(.analitica-list):not(.analitica-sublist) { list-style: none; margin: 0; padding: 0; max-width: 1000px; }
        #view-contenido ul:not(.analitica-list):not(.analitica-sublist) > li { position: relative; padding-left: 20px; }
        #view-contenido ul:not(.analitica-list):not(.analitica-sublist) > li::before { content: '•'; position: absolute; left: 5px; color: #d3dee1; }
        #view-contenido .justif-txt li { font-size: 14px; line-height: 165%; color: rgba(255,255,255,0.75); }

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
        .opt { display: flex; align-items: center; gap: 16px; padding: 26px 32px; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #fff; cursor: pointer; position: relative; overflow: hidden; }
        /* hover: un "brillito" (resplandor cyan) que se pasea de un extremo al otro; la opción NO se mueve (no se monta en la de al lado) */
        .opt::before { content: ''; position: absolute; top: -25%; bottom: -25%; left: 0; width: 48%; pointer-events: none; background: radial-gradient(ellipse at center, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0) 70%); transform: translateX(-18%); transition: transform .55s cubic-bezier(.22,.61,.36,1); }
        .opt:hover::before { transform: translateX(112%); }
        .opt > * { position: relative; z-index: 1; }
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
        .btn-repetir:disabled { opacity: .4; cursor: not-allowed; pointer-events: none; }
        .btn-repetir:disabled:hover { background: rgba(255,255,255,0.10); color: rgba(255,255,255,0.78); }

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
        /* Justificación editada con formato (Quill): normaliza bloques para que se vea igual */
        .justif-txt p { margin: 0; }
        .justif-txt p + p { margin-top: 0.7em; }
        .justif-txt ul, .justif-txt ol { margin: 0.3em 0; padding-left: 1.4em; }
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
        @keyframes resetPop { from { opacity: 0; transform: translateY(14px) scale(calc(var(--rp-scale, 1) * .97)); } to { opacity: 1; transform: translateY(0) scale(var(--rp-scale, 1)); } }

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
        .rp-medal.rp-lottie { width: 170px; height: 170px; margin-bottom: 6px; filter: none; }
        .rp-medal.rp-lottie svg { width: 100% !important; height: 100% !important; }
        .rp-title { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 26px; line-height: 1.1; margin: 0 0 16px; color: #fff; }
        .rp-text { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 18px; line-height: 175%; letter-spacing: 0.02em; text-align: center; color: #c8d3d7; margin: 0 0 32px; max-width: 440px; }
        .rp-actions { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
        .rp-btn { display: inline-block; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 14px; line-height: 150%; letter-spacing: 0.01em; color: #cfe6ef; text-decoration: none; padding: 13px 30px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.28); background: rgba(255,255,255,0.04); transition: background .2s, border-color .2s; }
        .rp-btn:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.45); }
        .rp-btn.cyan { background: #05BAEE; border-color: #05BAEE; color: #fff; }
        .rp-btn.cyan:hover { background: #04a3d1; border-color: #04a3d1; }
        .rp-right { flex: 0 0 300px; position: relative; pointer-events: none; }
        /* Juan y los anillos son DECORATIVOS: pointer-events:none para que no tapen el clic de
           los botones (la imagen es muy ancha y su caja invadía "Mejorar puntuación"). */
        .rp-right .rp-juan { position: absolute; right: 0; bottom: 0; height: 106%; width: auto; max-width: none; object-fit: contain; object-position: bottom right; z-index: 2; pointer-events: none; }
        .rp-rings { position: absolute; right: 22px; bottom: 4px; opacity: .45; z-index: 1; pointer-events: none; }
        /* Los botones del modal SIEMPRE por encima de la imagen y clicables. */
        .rp-left { position: relative; z-index: 3; }
        .rp-actions { position: relative; z-index: 3; }
        .rp-actions .rp-btn { position: relative; z-index: 3; }
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

        /* ===================== TABLET (768–1023px) =====================
           Layout equivalente al mobile (drawer + columna, sin scale) pero
           con anchos y tipografía adaptados al ancho tablet. */
        @media (min-width: 768px) and (max-width: 1023px) {
            html, body { height: auto !important; }
            body { overflow: visible !important; display: block !important; min-height: 100vh; }

            /* Top bar tablet: hamburguesa + score + corazón (como mobile pero con más aire) */
            .etapa-top {
                position: sticky; top: 0; z-index: 60;
                height: 72px !important; padding: 0 24px !important; gap: 20px;
                background:
                    radial-gradient(130% 190% at 50% 0%, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0.05) 45%, rgba(255,255,255,0) 75%),
                    #0a0a0c !important;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
                box-shadow: 0 0.5px 0 0 #BFBFBF !important;
                border-bottom: 0 !important;
            }
            .top-left { width: auto !important; flex: 0 0 auto; gap: 12px; }
            .top-name, .top-center, .top-back { display: none !important; }
            .etapa-burger { display: inline-flex !important; }
            .top-right { flex: 1; display: flex; align-items: center; gap: 16px; justify-content: flex-start; }
            .top-scope { font-weight: 500 !important; font-size: 15px !important; letter-spacing: 0.02em !important; color: #FFFFFF !important; flex: 0 0 auto; white-space: nowrap; }
            .top-scope b { font-weight: 500 !important; color: #FFFFFF !important; }
            .sc-pre { display: none; }
            .sc-max { display: inline; }
            .score-bar { flex: 1; max-width: 320px; height: 8px !important; background: #D4D4D4 !important; border-radius: 99px !important; box-shadow: 0 0 0 0.5px #D4D4D4; }
            .top-heart { flex: 0 0 auto; }
            .heart-desktop { display: none; }
            .heart-mobile { display: block !important; width: 34px; height: 34px; }

            /* Sidebar → drawer lateral (idéntico al mobile) */
            .etapa-body { display: block !important; }
            .etapa-side {
                position: fixed !important; top: 0; left: 0; bottom: 0; width: 340px; max-width: 85vw;
                z-index: 100; transform: translateX(-100%); transition: transform .28s ease;
                box-shadow: 2px 0 24px rgba(0,0,0,0.55);
            }
            .etapa-side.open { transform: translateX(0); }
            .etapa-backdrop { display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; opacity: 0; pointer-events: none; transition: opacity .28s; }
            .etapa-backdrop.open { opacity: 1; pointer-events: auto; }

            .side-head { display: flex; align-items: center; gap: 10px; padding: 18px 20px; border-bottom: 1px solid rgba(255,255,255,0.10); flex-shrink: 0; }
            .side-close { display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; background: none; border: 0; color: #fff; cursor: pointer; padding: 0; }
            .side-head-lbl { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; color: #fff; white-space: nowrap; }
            .side-head-bar { flex: 1; height: 6px; min-width: 24px; }
            .side-head-pct { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; color: #fff; flex-shrink: 0; }
            .side-salir { display: block; margin: 16px 20px 20px; padding: 14px; text-align: center; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.20); border-radius: 8px; color: #fff; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; text-decoration: none; }

            /* Content: reflow a columna, reset scale */
            .etapa-main { width: 100% !important; display: block !important; overflow: visible !important; align-items: stretch !important; justify-content: flex-start !important; }
            .main-stage { width: 100% !important; height: auto !important; transform: none !important; padding: 32px 32px !important; max-width: 800px !important; margin: 0 auto !important; }
            .content-col { width: 100% !important; margin-left: 0 !important; }
            .seg-top { position: static !important; top: auto !important; right: auto !important; display: inline-flex; margin: 0 0 20px; }
            .view { position: static !important; inset: auto !important; }
            .view-scroll, #view-biblio { overflow: visible !important; bottom: auto !important; }

            /* Juan en flujo, centrado, tamaño tablet — Juan COMPLETO con ondas visibles */
            .etapa-juan {
                position: relative !important; right: auto !important; top: auto !important;
                width: 100% !important; max-width: 520px !important; margin: 40px auto 0 !important;
                height: 820px !important; overflow: hidden;
                -webkit-mask-image: none;
                mask-image: none;
            }
            .etapa-juan .etapa-rings, .etapa-juan-d { display: none !important; }
            .etapa-juan-m {
                display: block !important; position: absolute !important;
                left: 50% !important; top: -40px !important;
                transform: translateX(-50%);
                width: 520px !important; max-width: none !important; height: auto !important; margin: 0 !important;
                -webkit-mask-image: none !important; mask-image: none !important;
            }

            /* Botón Siguiente etapa: centrado, presencia visual clara */
            .btn-next {
                position: static !important; right: auto !important; bottom: auto !important;
                display: flex !important; align-items: center; justify-content: center; gap: 12px;
                width: 100%; max-width: 320px;
                margin: 40px auto 20px !important;
                padding: 16px 32px !important; line-height: 21px !important;
                background: rgba(255,255,255,0.22) !important;
                border: 0 !important; box-shadow: inset 0 0 0 1px #2F728C !important;
                border-radius: 4px !important;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
                font-size: 15px !important; font-weight: 500;
            }
            .biblio-next { margin-top: 28px !important; }
            .main-stage:has(.video-full) { display: flex !important; flex-direction: column; min-height: calc(100dvh - 72px); }
            .main-stage:has(.video-full) .btn-next { margin-top: auto !important; }
            .btn-descargar { width: 100% !important; justify-content: center; max-width: 400px; }
            .btn-finalizar { width: 100% !important; max-width: 400px; }
            .resumen-foot { width: 100%; }
            .main-stage:has(.resumen-card) { display: flex !important; flex-direction: column; min-height: calc(100dvh - 72px); }
            .main-stage:has(.resumen-card) #view-contenido { flex: 1 1 auto; display: flex; flex-direction: column; }
            .main-stage:has(.resumen-card) .riesgo { flex: 1 1 auto; display: flex; flex-direction: column; }
            .main-stage:has(.resumen-card) .resumen-foot { margin-top: auto !important; }

            /* Tabs (Perfil/Historia/Medicación/Alergias) scroll horizontal si no cabe */
            .tabs { overflow-x: auto !important; scrollbar-width: none; }
            .tabs::-webkit-scrollbar { display: none; height: 0; }
            .tabs .tab { flex: 0 0 auto !important; }

            /* Tipografía tablet: entre mobile y desktop */
            .h-caso { font-size: 28px !important; line-height: 130% !important; margin-bottom: 20px !important; padding-right: 0 !important; }
            .h-sec:has(+ .motivo-p) { margin-top: -8px !important; margin-bottom: 10px !important; }
            #view-biblio .h-caso { display: none !important; }
            #view-biblio .biblio-list { overflow: visible !important; flex: none !important; padding-right: 0 !important; }
            .biblio-item { font-weight: 400 !important; font-size: 15px !important; line-height: 150% !important; }
            .biblio-h { margin-top: 0 !important; }

            /* Quiz: opciones a 2 columnas (más espacio que móvil) */
            .pregunta-opts { grid-template-columns: 1fr 1fr !important; }
            .pregunta-opts .opt { padding: 20px 24px !important; }
            .pregunta-head { padding: 24px 24px 18px !important; }
            .pregunta-foot { flex-direction: row !important; flex-wrap: wrap !important; align-items: stretch !important; padding: 20px 24px !important; gap: 12px !important; }
            .pregunta-foot .foot-spacer { display: none !important; }
            .pregunta-foot .btn-comprobar { order: 1; flex: 1 0 100% !important; width: auto !important; padding: 14px !important; font-size: 15px !important; }
            .pregunta-foot .btn-repetir  { order: 2; flex: 1 1 0 !important; width: auto !important; justify-content: center; gap: 8px !important; padding: 12px 16px !important; font-size: 14px !important; white-space: nowrap; }
            .pregunta-foot .btn-next-q   { order: 3; flex: 1 1 0 !important; width: auto !important; padding: 12px 16px !important; font-size: 14px !important; white-space: nowrap; }

            /* Texto del cuerpo consistente (15/150%) */
            .perfil-card p, .motivo-p, .prueba-p, .pregunta-q, .pregunta-sub,
            .analitica-intro, .analitica-list, .opt, .video-cap, .biblio-item {
                font-size: 15px !important; line-height: 150% !important;
            }

            /* Toggle Contenido/Bibliografía + Tabs internos */
            .seg-top, .tabs {
                width: auto !important; display: inline-flex !important; gap: 8px !important; padding: 6px !important;
                background: rgba(255,255,255,0.10) !important; border: 1px solid #2F728C !important;
                border-radius: 0 !important;
                -webkit-backdrop-filter: blur(40px); backdrop-filter: blur(40px);
            }
            .seg-top button, .tabs .tab {
                font-weight: 500 !important; font-size: 13px !important; line-height: 150% !important; letter-spacing: 0.01em !important; padding: 10px 18px !important;
                border-radius: 6px !important;
            }
            .seg-top button.on, .tabs .tab.on { color: #454545 !important; }
        }

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
            .h-caso { font-size: 22px !important; line-height: 140% !important; margin-bottom: 16px !important; padding-right: 0 !important; }   /* menos espacio → sube el toggle */
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

        /* =====================================================================  */
        /* ===  PULIDO WEB (≥1024px) — destellos glass + sidebar activo         === */
        /* Antes aplicaba desde 768, pero rompía el layout tablet. Ahora solo    */
        /* aplica en desktop y el bloque tablet propio (768-1023) toma el resto. */
        /* =====================================================================  */
        @media (min-width: 1024px) {
            /* === FIX bug imagen doble: .etapa-juan img tiene specificidad (0,1,1) y vence a
                   .etapa-juan-m {display:none} (0,1,0) → la imagen mobile aparecía en desktop/tablet.
                   Forzamos ocultarla con !important. */
            .etapa-juan-m { display: none !important; }

            /* === Layout: content-col 640px + correr a la derecha (más aire después del sidebar) === */
            .content-col { width: 640px !important; margin-left: 28px; }

            /* === Destellos de luz de fondo en el stage (decorativos, no clickables) === */
            .main-stage { isolation: isolate; }
            .main-stage::before,
            .main-stage::after {
                content: '';
                position: absolute;
                pointer-events: none;
                z-index: 0;
                filter: blur(40px);
                opacity: 0.85;
            }
            /* Destello 1 — arriba derecha (zona Contenido/Bibliografía + cabeza de Juan) */
            .main-stage::before {
                top: -60px; right: -60px;
                width: 520px; height: 360px;
                background: radial-gradient(closest-side, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0) 80%);
            }
            /* Destello 2 — abajo izquierda (zona Motivo de consulta) */
            .main-stage::after {
                bottom: -40px; left: -40px;
                width: 480px; height: 320px;
                background: radial-gradient(closest-side, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 80%);
            }

            /* === Top bar: barras más DELGADAS y track más sutil === */
            .bar {
                height: 6px !important;
                background: rgba(255,255,255,0.22) !important;
            }
            .bar > i { box-shadow: 0 0 6px rgba(5,186,238,0.40); }

            /* === Sidebar: item activo "Presentación" AZUL con acento lateral === */
            .side-item.viendo {
                background:
                    radial-gradient(120% 60% at 0% 0%, rgba(5,186,238,0.22) 0%, rgba(5,186,238,0) 55%),
                    linear-gradient(180deg, rgba(5,186,238,0.18) 0%, rgba(5,186,238,0.06) 100%) !important;
                color: #FFFFFF !important;
                border-left: 3px solid #05BAEE !important;
                padding-left: 29px !important;             /* 32 - 3 para compensar borde */
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.18);
            }
            .side-item.viendo .ico { color: #05BAEE !important; }

            /* === PERFIL-CARD: destello glass moderno === */
            .perfil-card {
                background:
                    radial-gradient(120% 60% at 0% 0%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0) 55%),
                    rgba(255,255,255,0.10) !important;
                border: 1px solid rgba(255,255,255,0.18) !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.32);
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }

            /* === Cards de PRUEBAS (ECG / Cat / Analítica): destello superior === */
            .ecg-block, .cat-block, .analitica-block {
                background:
                    radial-gradient(110% 55% at 0% 0%, rgba(255,255,255,0.16) 0%, rgba(255,255,255,0) 55%),
                    rgba(255,255,255,0.10) !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.30);
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }

            /* === PREGUNTA-CARD (cuestionario): glass moderno === */
            .pregunta-card {
                background:
                    radial-gradient(85% 40% at 18% 0%, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 55%),
                    radial-gradient(60% 35% at 85% 0%, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0) 50%),
                    rgba(20,32,38,0.85) !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.30);
                -webkit-backdrop-filter: blur(40px);
                backdrop-filter: blur(40px);
            }

            /* === Tabs y SEG (toggle Contenido/Bibliografía + tabs Perfil/Historia/Med/Alergias) === */
            .seg {
                background: linear-gradient(180deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.05) 100%) !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.28);
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }
            .tabs {
                background: linear-gradient(180deg, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0.04) 100%) !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }
            /* El botón activo (Contenido / Perfil del paciente) ya queda blanco; le añado destello */
            .seg button.on, .tabs .tab.on {
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.85), 0 2px 6px rgba(0,0,0,0.15);
            }

            /* === BTN-NEXT (Siguiente etapa): destello glass + blur === */
            .btn-next {
                background: linear-gradient(180deg, rgba(255,255,255,0.14) 0%, rgba(255,255,255,0.05) 100%) !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.30);
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }
            .btn-next:hover {
                background: #05BAEE !important;
                border-color: #05BAEE !important;
                color: #FFFFFF !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.45),
                    0 6px 22px rgba(5,186,238,0.50);
            }

            /* ================================================================ */
            /* === Pulido FINAL de botones restantes: quiz/modales/lightbox === */
            /* ================================================================ */

            /* 1) Radius 0 universal en todos los botones que aún tenían radio */
            .btn-next-q, .btn-comprobar, .btn-comprobar.comprobado, .btn-comprobar:disabled,
            .btn-repetir, .vid-btn, .btn-descargar, .btn-finalizar,
            .ep-btn, .reset-confirm, .rp-btn, .rp-btn.cyan, .lb-btn, .lb-close {
                border-radius: 0 !important;
            }

            /* 2) Destello glass NEUTRO (botones translúcidos) */
            .btn-next-q.enabled, .btn-repetir, .btn-finalizar, .ep-btn,
            .reset-confirm, .rp-btn, .lb-btn, .lb-close, .vid-btn, .ecg-icon {
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.14) 0%, rgba(255,255,255,0.04) 100%),
                    rgba(255,255,255,0.06) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.30),
                    inset 0 -1px 0 rgba(0,0,0,0.18) !important;
                -webkit-backdrop-filter: blur(20px);
                backdrop-filter: blur(20px);
            }
            /* btn-next-q deshabilitado conserva su gris original */
            .btn-next-q:not(.enabled) {
                background: rgba(185,185,185,0.25) !important;
                box-shadow: none !important;
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
            }

            /* ep-btn (Entendido del pop-up Atención) — borde cyan + destello glass */
            .ep-btn {
                box-shadow:
                    inset 0 0 0 1px #05BAEE,
                    inset 0 1px 0 rgba(255,255,255,0.40),
                    inset 0 -1px 0 rgba(0,0,0,0.18) !important;
            }
            .ep-btn:hover, .ep-btn:active, .ep-btn:focus {
                background: #05BAEE !important;
                box-shadow:
                    inset 0 0 0 1px #05BAEE,
                    inset 0 1px 0 rgba(255,255,255,0.55),
                    0 6px 22px rgba(5,186,238,0.55) !important;
            }

            /* btn-next-q.enabled (Siguiente etapa del quiz al acertar) — borde cyan + glow */
            .btn-next-q.enabled { border: 1px solid #05BAEE !important; }
            .btn-next-q.enabled:hover {
                background:
                    linear-gradient(180deg, rgba(5,186,238,0.22) 0%, rgba(5,186,238,0.08) 100%),
                    rgba(5,186,238,0.10) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.40),
                    0 6px 22px rgba(5,186,238,0.45) !important;
            }

            /* 3) Botones CLAROS (Comprobar blanco) */
            .btn-comprobar {
                background: linear-gradient(180deg, #ffffff 0%, #e8eef0 100%) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.95),
                    inset 0 -1px 0 rgba(0,0,0,0.12),
                    0 2px 8px rgba(0,0,0,0.18) !important;
            }
            .btn-comprobar:hover {
                background: linear-gradient(180deg, #ffffff 0%, #dde4e7 100%) !important;
            }
            .btn-comprobar:disabled {
                background: rgba(185,185,185,0.25) !important;
                box-shadow: none !important;
            }
            .btn-comprobar.comprobado,
            .btn-comprobar.comprobado:disabled {
                background: linear-gradient(180deg, #2E7D9B 0%, #245F77 100%) !important;
                color: #fff !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.30),
                    inset 0 -1px 0 rgba(0,0,0,0.25),
                    0 4px 14px rgba(5,186,238,0.30) !important;
            }
            .btn-comprobar.comprobado:hover {
                background: linear-gradient(180deg, #34899B 0%, #2A7188 100%) !important;
            }

            /* 4) Botones CYAN sólidos (Descargar resumen + rp-btn.cyan) — glow azul */
            .btn-descargar, .rp-btn.cyan {
                background: linear-gradient(180deg, #1bc8f5 0%, #0497c2 100%) !important;
                border: 1px solid #05BAEE !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.45),
                    inset 0 -1px 0 rgba(0,0,0,0.22),
                    0 6px 22px rgba(5,186,238,0.45) !important;
                color: #fff !important;
            }
            .btn-descargar:hover, .rp-btn.cyan:hover {
                background: linear-gradient(180deg, #2dd0f7 0%, #04a3d1 100%) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.55),
                    inset 0 -1px 0 rgba(0,0,0,0.22),
                    0 8px 28px rgba(5,186,238,0.60) !important;
            }

            /* 5) Hover destello reforzado en variantes glass neutras */
            .btn-repetir:hover, .rp-btn:hover, .lb-btn:hover,
            .reset-confirm:hover, .btn-finalizar:hover {
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0.08) 100%),
                    rgba(255,255,255,0.10) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.45),
                    inset 0 -1px 0 rgba(0,0,0,0.18) !important;
            }

            /* 6) Iconos del ECG (ampliar / descargar) — gris semi-opaco para contrastar
                  con el fondo BLANCO del ECG (el glass blanco translúcido era invisible). */
            .ecg-icon {
                background: rgba(60,80,90,0.78) !important;
                border: 1px solid rgba(255,255,255,0.30) !important;
                color: rgba(255,255,255,0.90) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.22),
                    inset 0 -1px 0 rgba(0,0,0,0.20) !important;
                -webkit-backdrop-filter: blur(8px) !important;
                backdrop-filter: blur(8px) !important;
            }
            .ecg-icon:hover {
                background: rgba(80,105,118,0.88) !important;
                color: #FFFFFF !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.35),
                    inset 0 -1px 0 rgba(0,0,0,0.22) !important;
            }

            /* Hover universal en tabs y seg buttons INACTIVOS: glass claro para feedback visual.
               Los activos (.on) mantienen su fondo blanco sólido. */
            .tab:not(.on),
            .seg button:not(.on) {
                transition: background .25s ease, color .25s ease !important;
            }
            .tab:not(.on):hover,
            .seg button:not(.on):hover {
                background: linear-gradient(180deg, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.06) 100%) !important;
                color: #FFFFFF !important;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.30) !important;
            }

            /* === Excepción: el ECG SÍ tiene border-radius (spec del cliente, no entra en la regla "todo recto") === */
            .ecg-frame { border-radius: 12px !important; max-height: 280px !important; }
            .ecg-frame img { max-height: 280px !important; object-fit: cover !important; object-position: center top !important; }

            /* === Excepción: "Descargar caso" + "Finalizar ingreso" del resumen
                  — mismas dimensiones: radio pequeñito + largo + delgado (spec cliente img1) === */
            .btn-descargar,
            .btn-finalizar {
                border-radius: 5px !important;
                padding: 9px 44px !important;
                font-size: 14px !important;
                min-width: 227px !important;
                box-sizing: border-box !important;
                justify-content: center !important;
            }

            /* 8) Brillito en opciones del quiz: destello CIRCULAR difuminado y SUAVE.
                  Se mueve poco (queda dentro del botón) y la transición es lenta y elegante. */
            .opt::before {
                top: -50% !important;
                bottom: -50% !important;
                left: 0 !important;
                width: 320px !important;
                background: radial-gradient(ellipse at center, rgba(255,255,255,0.20) 0%, rgba(255,255,255,0) 60%) !important;
                transform: translateX(-30%) !important;
                transition: transform 1.2s cubic-bezier(.22,.61,.36,1) !important;
            }
            .opt:hover::before { transform: translateX(50%) !important; }
            /* Tras comprobar (correcta/wrong): el brillito se va, el fondo lo reemplaza */
            .opt.correct::before, .opt.wrong::before { display: none !important; }

            /* 7) Controles de video (.vid-btn) hover */
            .vid-btn:hover {
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0.06) 100%),
                    rgba(15,18,20,0.65) !important;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.45),
                    inset 0 -1px 0 rgba(0,0,0,0.22) !important;
            }
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
                {{-- Título del caso: "Ingreso 1/2/3" (antes iba el nombre del paciente) --}}
                <span class="top-name">{{ $ingresoData['label'] ?? $curso['paciente']['nombre'] }}</span>
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
                @php
                    $medKey = $medalla['key'] ?? 'sin';
                    $medSrc = $medKey === 'sin'
                        ? asset('images/experiencia-global.svg')
                        : asset('images/medalla-' . $medKey . '.png');
                    $medalToJs = collect($curso['medallas'] ?? [])->map(fn($m) => [
                        'key' => $m['key'], 'min' => (int) $m['min'],
                    ])->values()->all();
                @endphp
                <span class="top-heart" id="top-heart"
                      data-medallas='@json($medalToJs)'
                      data-medalla="{{ $medKey }}"
                      data-sin-src="{{ asset('images/experiencia-global.svg') }}"
                      data-base="{{ asset('images/') }}/">
                    <img class="heart-desktop" src="{{ $medSrc }}" alt="{{ $medalla['label'] ?? 'Experiencia' }}" width="32" height="32">
                    <img class="heart-mobile"  src="{{ $medSrc }}" alt="{{ $medalla['label'] ?? 'Experiencia' }}" width="32" height="32">
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
                    @php
                        // Se puede navegar a CUALQUIER etapa ya alcanzada (perfecta ✓, error ✗ o activa)
                        // para revisar sus respuestas; solo las bloqueadas y la que se ve ahora no enlazan.
                        // Las correctas entran en modo revisión (respuestas visibles); las de fallo permiten repetir.
                        $clickable = ! in_array($etapa['estado'], ['bloqueada']) && ! $etapa['viendo'];
                    @endphp
                    <a href="{{ $clickable ? route('curso.etapa', [$ingreso, $etapa['key']]) : '#' }}"
                       class="side-item {{ $etapa['estado'] }} {{ $etapa['viendo'] ? 'viendo' : '' }} {{ $clickable ? '' : 'no-click' }}"
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
                        @elseif ($etapa['estado'] === 'pendiente')
                            {{-- en repetición: SIN icono hasta aprobar o fallar de nuevo (svg vacío para
                                 mantener la alineación; el JS le inyecta ✓/✗ en vivo al responder) --}}
                            <svg class="ico" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"></svg>
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

                {{-- Vista: Contenido (cambia por etapa e ingreso).
                     Convención:
                     - Ingreso 1 usa vistas planas: curso/etapas/{etapa}-contenido.blade.php
                     - Ingresos posteriores usan subcarpeta: curso/etapas/ingreso-{N}/{etapa}-contenido.blade.php
                     (Evita conflictos con la etapa "monitorizacion-2" que ya existe con sufijo -2 en I1.) --}}
                @php
                    $ingresoN = preg_match('/ingreso-(\d+)/', $ingreso, $m) ? (int)$m[1] : 1;
                    $contenidoView = $ingresoN > 1
                        ? 'curso.etapas.ingreso-'.$ingresoN.'.'.$etapaActual.'-contenido'
                        : 'curso.etapas.'.$etapaActual.'-contenido';
                    $biblioView = $ingresoN > 1
                        ? 'curso.etapas.ingreso-'.$ingresoN.'.'.$etapaActual.'-biblio'
                        : 'curso.etapas.'.$etapaActual.'-biblio';
                @endphp
                <div id="view-contenido" class="view @if($etapaActual !== 'presentacion') view-scroll @endif">
                    @if (view()->exists($contenidoView))
                        @include($contenidoView)
                    @else
                        <h1 class="h-caso">{{ collect($etapasEstado)->firstWhere('key', $etapaActual)['titulo'] ?? 'Etapa' }}</h1>
                        <p class="prueba-p" style="margin-top:10px;">Contenido en construcción.</p>
                    @endif
                </div>

                {{-- Vista: Bibliografía (cambia por etapa e ingreso) --}}
                <div id="view-biblio" class="view" style="display:none;">
                    @includeIf($biblioView)
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
                    {{-- anillos en la base (solo desktop; en móvil la imagen ya los trae).
                         bottom:110px → el CENTRO del círculo queda a la altura donde el cuerpo de Juan
                         se desvanece (~85% de la imagen), para que "toque" el círculo y el degradado
                         empiece ahí, sin hueco (ajuste pedido por el cliente). --}}
                    <svg class="etapa-rings" style="position:absolute; left:50%; bottom:110px; transform:translateX(-50%); opacity:.5;" width="460" height="120" viewBox="0 0 460 120" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 4; $r++)
                            <ellipse cx="230" cy="105" rx="{{ $r * 52 }}" ry="{{ $r * 13 }}" stroke="#7fa6b2" stroke-width="1" opacity="{{ 0.5 - $r * 0.1 }}"/>
                        @endfor
                    </svg>
                    @php
                        $pImg = ($pacienteIngreso ?? $curso['paciente'])['imagen'];
                        // Imagen del paciente editable desde el panel (por ingreso). Si no hay override, se mantiene la actual.
                        $pImgOv = \App\Support\Cms::raw('curso.cont.'.$ingreso.'.presentacion.img_paciente');
                        if ($pImgOv && file_exists(public_path($pImgOv))) $pImg = $pImgOv;
                        // Cache-busting por fecha del archivo: al cambiar la imagen (mismo nombre), el navegador la vuelve a pedir.
                        $pImgSrc = asset($pImg) . (file_exists(public_path($pImg)) ? '?v=' . filemtime(public_path($pImg)) : '');
                    @endphp
                    <img class="etapa-juan-d" src="{{ $pImgSrc }}" onerror="this.onerror=null;this.src='{{ asset($curso['paciente']['imagen']) }}'" alt="{{ $curso['paciente']['nombre'] }}">
                    <img class="etapa-juan-m" src="{{ $pImgSrc }}" onerror="this.onerror=null;this.src='{{ asset('images/paciente.png') }}'" alt="{{ $curso['paciente']['nombre'] }}">
                </div>
                @endif

                {{-- Siguiente etapa (botón flotante; las etapas con cuestionario llevan el suyo dentro) --}}
                @unless (in_array($etapaActual, ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2', 'resumen']))
                <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" id="form-avanzar" style="display:contents;">
                    @csrf
                    <input type="hidden" name="desde" value="{{ $etapaActual }}">
                    {{-- El pop-up "Atención (varias correctas)" SOLO aparece al salir de la Presentación; en las demás etapas sin pregunta avanza directo. --}}
                    <button type="button" class="btn-next" onclick="@if($etapaActual === 'presentacion')document.getElementById('etapa-popup').removeAttribute('hidden')@else document.getElementById('form-avanzar').submit()@endif">{{ $esUltimaEtapa ? 'Finalizar ingreso' : 'Siguiente etapa' }}</button>
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
                <h3 class="reset-title" id="reset-title">Repetir etapa</h3>
                <p class="reset-text">Vas a repetir esta pregunta: la puntuación de este capítulo <strong>se reinicia por completo</strong> y las opciones quedan limpias para responderlas de nuevo. Si respondes correctamente, vuelves a ganar los puntos y el capítulo queda en verde.<br><strong>¿Quieres repetir esta pregunta?</strong></p>
                <div class="reset-actions">
                    <button type="button" class="reset-cancel" id="reset-cancel">Cancelar</button>
                    <form method="POST" action="{{ route('curso.reiniciar', $ingreso) }}" style="margin:0;">
                        @csrf
                        <input type="hidden" name="etapa" value="{{ $etapaActual }}">
                        <button type="submit" class="reset-confirm" id="reset-confirm">Repetir etapa</button>
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
                    $medLottie = 'medallas/medalla-' . $medalla['key'] . '.json';  // animación oficial (Lottie) bronce/plata/oro
                    $medImg  = 'images/medalla-' . $medalla['key'] . '.png';   // corazón de la medalla (respaldo)

                    // Juan del modal según la medalla, POR INGRESO. Prioridad:
                    //  1) juan-{N}-{medalla}.png  → expresión propia de ese ingreso por medalla (si se sube)
                    //  2) Ingreso 1: juan-{medalla}.png → set de expresiones existente
                    //  3) imagen base del paciente de ESE ingreso (así el Ingreso 3 muestra su Juan, no el del 1)
                    $ingN = preg_match('/ingreso-(\d+)/', $ingreso, $mmJuan) ? (int) $mmJuan[1] : 1;
                    $juanCandidatos = ['images/juan-' . $ingN . '-' . $medalla['key'] . '.png'];
                    if ($ingN === 1) $juanCandidatos[] = 'images/juan-' . $medalla['key'] . '.png';
                    $juanCandidatos[] = 'images/juan-' . $ingN . '.png';   // expresión única (feliz) del ingreso para cualquier medalla
                    $juanCandidatos[] = ($pacienteIngreso ?? $curso['paciente'])['imagen'];
                    $juanImg = collect($juanCandidatos)->first(fn ($p) => file_exists(public_path($p)))
                        ?? $curso['paciente']['imagen'];
                @endphp
                <div class="rp-left">
                    @if (file_exists(public_path($medLottie)))
                        {{-- Medalla ANIMADA oficial (Lottie) --}}
                        <div class="rp-medal rp-lottie" data-lottie="{{ asset($medLottie) }}" role="img" aria-label="{{ $medalla['label'] }}"></div>
                    @elseif (file_exists(public_path($medImg)))
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
                            @php $accion = $b['accion'] ?? ''; @endphp
                            @if ($accion === 'continuar')
                                {{-- plata/oro: AVANZA a las etapas finales (con temporizador de 10 s) --}}
                                <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" style="display:contents;">
                                    @csrf
                                    <input type="hidden" name="desde" value="{{ $etapaActual }}">
                                    <input type="hidden" name="confirmar" value="1">
                                    <button type="submit" class="rp-btn cyan rp-continuar" data-espera="{{ ($medalla['key'] ?? '') === 'oro' ? 0 : 10 }}">{{ $b['texto'] }}</button>
                                </form>
                            @elseif ($accion === 'mejorar')
                                {{-- cierra el modal y vuelve a la etapa a repasar --}}
                                <a class="rp-btn {{ ($b['estilo'] ?? '') === 'cyan' ? 'cyan' : '' }}"
                                   href="{{ route('curso.etapa', [$ingreso, $etapaActual]) }}">{{ $b['texto'] }}</a>
                            @else
                                {{-- "Volver al temario" (sin/bronce): DESBLOQUEA los capítulos finales y lleva
                                     al último. Antes era un enlace directo al último capítulo, pero al no haber
                                     avanzado el progreso rebotaba a esta misma pregunta y el caso no se podía
                                     terminar nunca. --}}
                                <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" style="display:contents;">
                                    @csrf
                                    <input type="hidden" name="desde" value="{{ $etapaActual }}">
                                    <input type="hidden" name="confirmar" value="1">
                                    <input type="hidden" name="hasta" value="fin">
                                    <button type="submit" class="rp-btn {{ ($b['estilo'] ?? '') === 'cyan' ? 'cyan' : '' }}">{{ $b['texto'] }}</button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="rp-right">
                    <svg class="rp-rings" width="280" height="84" viewBox="0 0 280 84" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 3; $r++)
                            <ellipse cx="140" cy="74" rx="{{ $r * 44 }}" ry="{{ $r * 10 }}" stroke="#7fa6b2" stroke-width="1" opacity="{{ 0.5 - $r * 0.12 }}"/>
                        @endfor
                    </svg>
                    {{-- Juan de la medalla, ya resuelto por ingreso (arriba) --}}
                    <img class="rp-juan" src="{{ asset($juanImg) }}" alt="{{ $curso['paciente']['nombre'] }}">
                </div>
            </div>
        </div>
        {{-- Temporizador de 10 s del botón "Finalizar caso" (avanzar) en el modal de medalla --}}
        <script>
        (function(){
            var btn = document.querySelector('.rp-continuar');
            if (!btn) return;
            var seg = parseInt(btn.getAttribute('data-espera'), 10);
            if (isNaN(seg) || seg <= 0) return;   // sin temporizador (medalla de ORO): el botón queda activo desde el inicio
            var base = btn.textContent;
            btn.disabled = true; btn.style.opacity = '0.5'; btn.style.cursor = 'not-allowed';
            (function tick(){
                if (seg <= 0) { btn.textContent = base; btn.disabled = false; btn.style.opacity = ''; btn.style.cursor = ''; return; }
                btn.textContent = base + '  (' + seg + ')';
                seg--; setTimeout(tick, 1000);
            })();
        })();
        </script>
        {{-- Medalla ANIMADA (Lottie) + sonido oficial al mostrarse el resultado --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
        <script>
        (function(){
            var el = document.querySelector('.rp-lottie');
            if (!el || !el.getAttribute('data-lottie')) return;
            if (window.lottie) {
                try { window.lottie.loadAnimation({ container: el, renderer: 'svg', loop: true, autoplay: true, path: el.getAttribute('data-lottie') }); } catch (e) {}
            }
            // Sonido oficial de medalla (solo con medalla: bronce/plata/oro)
            try { var s = new Audio('{{ asset('sounds/medalla-oficial.mp3') }}'); var p = s.play(); if (p && p.catch) p.catch(function(){}); } catch (e) {}
        })();
        </script>
        @endif

        {{-- Pop-up "¡Medalla alcanzada!" durante el curso (mismo estilo que el final, centrado y sin Juan) --}}
        <div class="result-modal" id="medal-unlock" hidden>
            <div class="result-panel">
                <div class="rp-left">
                    {{-- Efecto animado (Lottie) por medalla; imagen estática de respaldo si falla --}}
                    <div class="rp-medal rp-lottie" id="mu-lottie" style="display:none"></div>
                    <img class="rp-medal" id="mu-medal" src="" alt="Medalla">
                    <h2 class="rp-title" id="mu-title"></h2>
                    <p class="rp-text" id="mu-text"></p>
                    <div class="rp-actions">
                        <button type="button" class="rp-btn cyan" id="mu-continue">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Librería Lottie para el efecto animado del pop-up de medalla durante el curso --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>

    </div>{{-- /etapa-page --}}

    @php
        // Medallas que se ANUNCIAN al alcanzar su puntaje durante el curso (sin medalla no se celebra).
        $medallasUnlock = collect($curso['medallas'] ?? [])
            ->filter(fn ($m) => (int) ($m['min'] ?? 0) > 0)
            ->map(function ($m) {
                $img = 'images/medalla-' . $m['key'] . '.png';
                $lot = 'medallas/medalla-' . $m['key'] . '.json';   // efecto animado (Lottie) oficial por medalla
                $snd = 'sounds/medalla-oficial.mp3';                 // sonido oficial de medalla (mismo para todas)
                return [
                    'min'    => (int) $m['min'],
                    'titulo' => $m['unlock']['titulo'] ?? ('¡' . ($m['label'] ?? 'Medalla') . ' alcanzada!'),
                    'texto'  => $m['unlock']['texto'] ?? ($m['texto'] ?? ''),
                    'img'    => file_exists(public_path($img)) ? asset($img) : '',
                    'lottie' => file_exists(public_path($lot)) ? asset($lot) : '',
                    'sound'  => file_exists(public_path($snd)) ? asset($snd) : '',
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

        // ===== El pop-up de resultado/medalla escala uniforme (igual en cualquier PC), como el resto del curso.
        //       Se aplica vía la variable --rp-scale que usa el keyframe resetPop (así no pisa la animación). =====
        (function () {
            function scaleResultPanels() {
                var panels = document.querySelectorAll('.result-panel');
                if (!panels.length) return;
                if (window.innerWidth < 720) {          // móvil: el modal usa su layout responsive propio
                    panels.forEach(function (p) { p.style.removeProperty('--rp-scale'); });
                    return;
                }
                // Misma filosofía que .main-stage: escala proporcional a la pantalla (diseño de ref. 1440x820).
                var s = Math.min(window.innerWidth / 1440, window.innerHeight / 820);
                s = Math.min(Math.max(s, 0.5), 1.6);
                panels.forEach(function (p) { p.style.setProperty('--rp-scale', s.toFixed(4)); });
            }
            window.__scaleResultPanels = scaleResultPanels;   // por si el pop-up de medalla se abre dinámicamente
            window.addEventListener('resize', scaleResultPanels);
            window.addEventListener('load', scaleResultPanels);
            if (document.readyState !== 'loading') scaleResultPanels();
            else document.addEventListener('DOMContentLoaded', scaleResultPanels);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleResultPanels);
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

            // Precarga de los sonidos de medalla (archivos ligeros) para que suenen al instante, sin lag.
            var sndCache = {};
            MED.forEach(function (m) {
                if (m.sound && !sndCache[m.sound]) {
                    var a = new Audio(m.sound);
                    a.preload = 'auto';
                    try { a.load(); } catch (e) {}
                    sndCache[m.sound] = a;
                }
            });
            function sonar(m) {
                if (!m || !m.sound) return;
                var a = sndCache[m.sound] || (sndCache[m.sound] = new Audio(m.sound));
                try {
                    a.pause();
                    a.currentTime = 0;                 // siempre desde el inicio
                    var p = a.play();
                    if (p && p.catch) p.catch(function () {});   // si el navegador bloquea el autoplay: silencioso, sin error
                } catch (e) {}
            }

            var sb = document.getElementById('score-bar');
            var inicial = sb ? ((parseInt(sb.getAttribute('data-verde'), 10) || 0) - (parseInt(sb.getAttribute('data-rojo'), 10) || 0)) : 0;
            function idxFor(s) { var i = -1; MED.forEach(function (m, k) { if (s >= m.min) i = k; }); return i; }
            var anunciada = idxFor(inicial);    // medallas ya logradas al cargar: NO se vuelven a anunciar

            var imgEl = document.getElementById('mu-medal');
            var lotEl = document.getElementById('mu-lottie');
            var lotAnim = null;
            function abrir(m) {
                // Efecto animado (Lottie) por medalla; si no hay Lottie, cae a la imagen estática.
                if (lotAnim) { try { lotAnim.destroy(); } catch (e) {} lotAnim = null; }
                if (m.lottie && window.lottie) {
                    imgEl.style.display = 'none';
                    lotEl.style.display = '';
                    try {
                        lotAnim = window.lottie.loadAnimation({ container: lotEl, renderer: 'svg', loop: true, autoplay: true, path: m.lottie });
                    } catch (e) {
                        lotEl.style.display = 'none';
                        if (m.img) { imgEl.src = m.img; imgEl.style.display = ''; }
                    }
                } else if (m.img) {
                    lotEl.style.display = 'none';
                    imgEl.src = m.img; imgEl.style.display = '';
                } else {
                    lotEl.style.display = 'none'; imgEl.style.display = 'none';
                }
                document.getElementById('mu-title').textContent = m.titulo;
                document.getElementById('mu-text').textContent = m.texto;
                modal.hidden = false;
                sonar(m);
            }
            function cerrar() { modal.hidden = true; if (lotAnim) { try { lotAnim.destroy(); } catch (e) {} lotAnim = null; } }
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

            // Sonidos de respuesta (precargados, ligeros): correcta vs incorrecta al Comprobar.
            var sndOk  = new Audio('{{ asset('sounds/respuesta-correcta.mp3') }}');
            var sndBad = new Audio('{{ asset('sounds/respuesta-incorrecta.wav') }}');
            sndOk.preload = 'auto'; sndBad.preload = 'auto';
            try { sndOk.load(); sndBad.load(); } catch (e) {}
            function sonarResp(correcta) {
                var a = correcta ? sndOk : sndBad;
                try { a.pause(); a.currentTime = 0; var p = a.play(); if (p && p.catch) p.catch(function () {}); } catch (e) {}
            }

            // Citas bibliográficas -> superíndice. Solo el número pegado a una palabra al final de la frase.
            // NO toca medidas (≥50%, 4 g/día, 1-3 meses) ni nombres de gen (PCSK9 se maneja aparte).
            function formatCitas(t) {
                t = t || '';
                // Si el texto YA es HTML del editor (Quill: <p>, <sup>, <b>, <li>…) no se escapa
                // (Quill ya escapó el texto). Si es texto plano, se escapa para no romper "<1%", ">55".
                var esHtml = /<\/?(p|sup|sub|strong|b|em|i|u|ul|ol|li|br|a)\b/i.test(t);
                if (!esHtml) {
                    t = t.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                }
                t = t.replace(/(PCSK)9(\d+(?:[-,]\d+)*)/g, '$19<sup>$2</sup>');                 // gen PCSK9 + cita: solo la cita
                // Cita al final de frase. La coma solo cuenta como fin de cita si NO va seguida de
                // un dígito; así no rompe rangos decimales como "1,7-2,1" (odds ratio) ni "20-25%".
                t = t.replace(/([^\s0-9>])(\d+(?:[-,]\d+)*)(?=[.;]|,(?!\d)|$)/g, '$1<sup>$2</sup>');
                t = t.replace(/\r?\n/g, '<br>');   // respeta los saltos de línea (listas numeradas del documento)
                return t;
            }

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

            // Modo revisión: al VOLVER a un capítulo ya hecho (reevaluando) que tiene opciones marcadas,
            // solo se pueden revisar las cursadas (ver su justificación); Comprobar queda bloqueado.
            var reevaluando  = card.getAttribute('data-reevaluando') === '1';
            var preselArr    = (card.getAttribute('data-presel') || '').split(',').filter(Boolean);
            var modoRevision = reevaluando && preselArr.length > 0;

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
                item.classList.remove('activa', 'perfecta', 'pendiente');
                item.classList.add('error');
                var ico = item.querySelector('.ico');
                if (ico) ico.innerHTML = '<circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/>';
            }

            // Al APROBAR una etapa en repetición (pendiente, sin icono): pinta el check verde al instante.
            // Solo aplica a 'pendiente' — la etapa activa normal conserva su reloj hasta avanzar.
            function marcarCheckMenu() {
                var item = document.querySelector('.etapa-side .side-item.viendo');
                if (!item || !item.classList.contains('pendiente') || item.classList.contains('error')) return;
                item.classList.remove('pendiente');
                item.classList.add('perfecta');
                var ico = item.querySelector('.ico');
                if (ico) ico.innerHTML = '<circle cx="12" cy="12" r="9"/><path d="m8.4 12 2.4 2.4 4.8-5.2"/>';
            }

            function pintarBarra() {
                var verde = baseVerde + liveVerde, rojo = baseRojo + liveRojo;
                var exp = verde - rojo;                         // EXP = verde - rojo (el rojo nunca baja)
                if (xpVal) xpVal.textContent = exp;
                var g = Math.max(0, Math.min(100, exp / maxScore * 100));          // CONTRAPESO: verde mostrado = verde - rojo (al fallar, el verde se achica)
                var r = Math.max(0, Math.min(100 - g, rojo / maxScore * 100));     // rojo = penalizaciones; "come" al verde (contrapeso)
                if (green) green.style.width = g + '%';
                if (red) red.style.width = r + '%';
                actualizarMedallaHeader(exp);
            }

            // Cambia el corazón del header a la medalla que corresponde al score actual.
            // Umbrales del config (sin=0, bronce=200, plata=300, oro=400).
            var heartWrap = document.getElementById('top-heart');
            var heartImgs = heartWrap ? heartWrap.querySelectorAll('img') : [];
            var medallasCfg = [];
            var heartBase = '', heartSinSrc = '';
            if (heartWrap) {
                try { medallasCfg = JSON.parse(heartWrap.getAttribute('data-medallas') || '[]'); } catch (e) {}
                heartBase = heartWrap.getAttribute('data-base') || '';
                heartSinSrc = heartWrap.getAttribute('data-sin-src') || '';
            }
            function medallaKeyPara(score) {
                var key = 'sin';
                for (var i = 0; i < medallasCfg.length; i++) {
                    if (score >= medallasCfg[i].min) key = medallasCfg[i].key;
                }
                return key;
            }
            function actualizarMedallaHeader(exp) {
                if (!heartWrap || heartImgs.length === 0) return;
                var nueva = medallaKeyPara(exp);
                if (heartWrap.getAttribute('data-medalla') === nueva) return;
                heartWrap.setAttribute('data-medalla', nueva);
                var src = nueva === 'sin' ? heartSinSrc : (heartBase + 'medalla-' + nueva + '.png');
                heartImgs.forEach(function (img) { img.src = src; });
            }

            // Re-pinta las opciones ya marcadas en intentos previos (al volver, el rojo permanece visible).
            // OJO: estas YA están contabilizadas en el Score base (servidor); aquí NO se re-suman al vivo,
            // solo se deja la marca y se desbloquea "Siguiente" si ya había alguna correcta.
            preselArr.forEach(function (key) {
                var input = card.querySelector('input[name="pregunta"][value="' + key + '"]');
                if (!input || marcadas[key]) return;
                var opt = input.closest('.opt');
                var pts = parseInt(opt.getAttribute('data-puntos'), 10) || 0;
                opt.classList.add(pts > 0 ? 'correct' : 'wrong');
                opt.style.cursor = 'pointer';                          // ya cursada: clicable para ver su justificación
                marcadas[key] = true;
                input.disabled = true;
                if (pts > 0) sigBtn.classList.add('enabled');
            });
            pintarBarra();
            sincronizarSel();
            if (Object.keys(marcadas).length >= totalOpts) comprobar.disabled = true;

            // ===== Revisión de opciones ya cursadas: clic en una opción YA respondida → ver su justificación + puntuación =====
            // Aplica SIEMPRE: tras Comprobar en la etapa activa Y al VOLVER a un capítulo ya hecho (modo revisión).
            card.querySelectorAll('.opt').forEach(function (opt) {
                var inp = opt.querySelector('input[name="pregunta"]');
                var k   = inp ? inp.value : null;
                opt.addEventListener('click', function (e) {
                    if (k && marcadas[k]) {                 // opción ya cursada → mostrar su justificación + puntuación (no re-puntúa)
                        e.preventDefault();
                        justifTxt.innerHTML = formatCitas(opt.getAttribute('data-justif') || '');
                        justif.hidden = false;
                        if (resultado && resIco && resTxt) {
                            var pts = parseInt(opt.getAttribute('data-puntos'), 10) || 0;
                            var correcta = pts > 0;
                            var xp = Math.abs(pts);
                            if (correcta) {
                                resultado.className = 'resultado ok';
                                resIco.textContent = '✓';
                                resTxt.textContent = '¡Excelente!   + ' + xp + ' XP';
                            } else {
                                resultado.className = 'resultado bad';
                                resIco.textContent = '✕';
                                resTxt.textContent = '¡Respuesta incorrecta!   - ' + xp + ' XP';
                            }
                            resultado.hidden = false;
                        }
                    }
                });
            });

            // Modo revisión (al VOLVER a un capítulo ya hecho): Comprobar bloqueado y las NO cursadas se atenúan.
            if (modoRevision) {
                if (comprobar) { comprobar.hidden = true; comprobar.disabled = true; }   // Comprobar bloqueado
                sigBtn.classList.add('enabled');                                          // etapa ya superada: puede avanzar
                // Chrome/bfcache puede restaurar el estado marcado de radios entre navegaciones →
                // limpiamos explícitamente para que ninguna opción aparezca marcada al entrar.
                card.querySelectorAll('input[name="pregunta"]').forEach(function (inp) {
                    inp.checked = false;
                });
                card.querySelectorAll('.opt').forEach(function (opt) {
                    var inp = opt.querySelector('input[name="pregunta"]');
                    var k   = inp ? inp.value : null;
                    if (k && marcadas[k]) {
                        opt.style.cursor = 'pointer';                                      // cursada → revisable
                    } else {
                        if (inp) inp.disabled = true;                                      // NO cursada → no revisable
                        opt.style.pointerEvents = 'none';
                        opt.style.opacity = '0.5';
                    }
                });
            }

            // "Comprobar" aparece al elegir una opción. "Reiniciar capítulo" lo controla el servidor
            // (visible solo si el capítulo tiene error); aquí no se muestra por el simple hecho de seleccionar.
            card.querySelectorAll('input[name="pregunta"]').forEach(function (r) {
                r.addEventListener('change', function () {
                    if (modoRevision) return;                     // en revisión no se re-puntúa
                    comprobar.hidden = false;                     // reaparece "Comprobar" al elegir otra opción
                    comprobar.classList.remove('comprobado');     // vuelve a su estado normal
                    if (justif)    justif.hidden = true;          // se oculta la justificación de la opción anterior
                    if (resultado) resultado.hidden = true;       // y su línea de resultado (✓/✕)
                });
            });

            // Chevron de la justificación: colapsa/expande el texto
            var justToggle = card.querySelector('.justif-toggle');
            if (justToggle) justToggle.addEventListener('click', function () {
                var col = justif.classList.toggle('collapsed');
                justToggle.setAttribute('aria-expanded', col ? 'false' : 'true');
            });

            comprobar.addEventListener('click', function () {
                if (modoRevision) return;               // en revisión, Comprobar bloqueado
                var sel = card.querySelector('input[name="pregunta"]:checked');
                if (!sel) return;                       // requiere una opción
                comprobar.classList.add('comprobado');  // se pinta de azul al comprobar
                var key = sel.value;
                if (marcadas[key]) { return; }   // ya puntuada: no recuenta
                var opt = sel.closest('.opt');
                var pts = parseInt(opt.getAttribute('data-puntos'), 10) || 0;
                var correcta = pts > 0;                 // correcta = puntos positivos
                var xp = Math.abs(pts);
                sonarResp(correcta);                    // suena: correcta / incorrecta

                opt.classList.add(correcta ? 'correct' : 'wrong');   // queda marcada
                opt.style.cursor = 'pointer';                          // ya cursada: clicable para releer su justificación
                justifTxt.innerHTML = formatCitas(opt.getAttribute('data-justif') || '');
                justif.hidden = false;

                marcadas[key] = true;
                sel.disabled = true;                       // esa opción ya no se re-marca
                if (correcta) { liveVerde += pts; } else { liveRojo += xp; }   // el rojo NO se recupera
                pintarBarra();
                sincronizarSel();
                persistir();                        // guarda al instante (no espera a "Siguiente etapa")
                if (!correcta) marcarCruzMenu();     // solo pinta la X en el menu; el botón "Reiniciar capítulo"
                                                     // aparece al VOLVER al capítulo (render del servidor), no al fallar
                else marcarCheckMenu();              // en repetición (pendiente): al aprobar, check verde al instante
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
                comprobar.hidden = true;       // tras comprobar, el botón desaparece hasta elegir otra opción
                if (Object.keys(marcadas).length >= card.querySelectorAll('input[name="pregunta"]').length) comprobar.disabled = true;
            });

            // "Repetir etapa" → confirma con el modal "Reiniciar capítulo"
            var modal   = document.getElementById('reset-modal');
            var mCancel = document.getElementById('reset-cancel');
            function cerrarModal() { if (modal) modal.hidden = true; }

            // "Repetir etapa" abre el modal; confirmar reinicia SOLO esta etapa (POST a curso.reiniciar con la etapa)
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
