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
        .top-right { display: flex; align-items: center; gap: 16px; }
        .top-scope { font-weight: 400; font-size: 16px; color: #e9eff1; white-space: nowrap; }
        .top-scope b { color: #fff; font-weight: 700; }
        .top-heart { color: #c9d3d7; display: inline-flex; }

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
            background: rgba(255,255,255,0.07);
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
        .opt { display: flex; align-items: center; gap: 16px; padding: 26px 32px; font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 16px; line-height: 150%; letter-spacing: 0.02em; color: #fff; cursor: pointer; transition: background .15s; }
        .opt:hover { background: rgba(255,255,255,0.03); }
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

        .justif { padding: 22px 32px; border-top: 1px solid rgba(255,255,255,0.14); }
        .justif-h { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; color: #fff; margin: 0 0 8px; }
        .justif-txt { font-family: 'Montserrat', sans-serif; font-weight: 400; font-size: 14px; line-height: 165%; color: rgba(255,255,255,0.75); margin: 0; }

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
        .reset-actions { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .reset-cancel { font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 15px; background: none; border: 0; color: rgba(255,255,255,0.78); cursor: pointer; padding: 12px 8px; transition: color .2s; }
        .reset-cancel:hover { color: #fff; }
        .reset-confirm { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 15px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.20); color: #fff; padding: 13px 26px; border-radius: 8px; cursor: pointer; transition: background .2s, border-color .2s; }
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
    </style>
</head>
<body>
    <div class="etapa-page">

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
                <span class="bar" style="width:340px;"><i style="width:{{ $avance }}%"></i></span>
                <span class="top-pct">{{ $avance }}%</span>
            </div>

            <div class="top-right">
                <span class="top-scope">Scope: <b><span id="xp-val">{{ $xpBase ?? 0 }}</span> / 500 Exp</b></span>
                <span class="bar" style="width:120px;"><i id="xp-bar" style="width:{{ max(0, min(100, ($xpBase ?? 0) / 500 * 100)) }}%"></i></span>
                <span class="top-heart">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35c-.3 0-.6-.1-.84-.3C7.2 17.66 2.5 13.88 2.5 9.6 2.5 6.5 4.9 4.5 7.4 4.5c1.8 0 3.42.94 4.6 2.42C13.18 5.44 14.8 4.5 16.6 4.5c2.5 0 4.9 2 4.9 5.1 0 4.28-4.7 8.06-8.66 11.45-.24.2-.54.3-.84.3Z"/></svg>
                </span>
            </div>
        </header>

        {{-- ===== CUERPO ===== --}}
        <div class="etapa-body">

            {{-- Sidebar de etapas --}}
            <aside class="etapa-side">
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
            </aside>

            {{-- Main --}}
            <main class="etapa-main">
              <div class="main-stage">

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
                </div>

                {{-- Paciente (solo en Presentación) --}}
                @if ($etapaActual === 'presentacion')
                <div class="etapa-juan">
                    {{-- anillos en la base --}}
                    <svg style="position:absolute; left:50%; bottom:6px; transform:translateX(-50%); opacity:.5;" width="460" height="120" viewBox="0 0 460 120" fill="none" aria-hidden="true">
                        @for ($r = 1; $r <= 4; $r++)
                            <ellipse cx="230" cy="105" rx="{{ $r * 52 }}" ry="{{ $r * 13 }}" stroke="#7fa6b2" stroke-width="1" opacity="{{ 0.5 - $r * 0.1 }}"/>
                        @endfor
                    </svg>
                    <img src="{{ asset($curso['paciente']['imagen']) }}" alt="{{ $curso['paciente']['nombre'] }}">
                </div>
                @endif

                {{-- Siguiente etapa (botón flotante; las etapas con cuestionario llevan el suyo dentro) --}}
                @unless (in_array($etapaActual, ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2', 'resumen']))
                <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" style="display:contents;">
                    @csrf
                    <input type="hidden" name="desde" value="{{ $etapaActual }}">
                    <button type="submit" class="btn-next">{{ $esUltimaEtapa ? 'Finalizar ingreso' : 'Siguiente etapa' }}</button>
                </form>
                @endunless

              </div>{{-- /main-stage --}}
            </main>
        </div>

        {{-- Modal: Reiniciar capítulo (confirmación de "Repetir etapa") --}}
        @if (in_array($etapaActual, ['pruebas', 'riesgo', 'terapeutico', 'monitorizacion', 'monitorizacion-2']))
        <div class="reset-modal" id="reset-modal" hidden>
            <div class="reset-card" role="dialog" aria-modal="true" aria-labelledby="reset-title">
                <span class="reset-ico">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </span>
                <h3 class="reset-title" id="reset-title">Reiniciar capítulo</h3>
                <p class="reset-text">Vas a repetir este capítulo. Si continúas, se eliminarán tus respuestas y los puntos obtenidos solo en esta sección. El resto de tu progreso no se verá afectado.<br><strong>¿Quieres reiniciar este capítulo?</strong></p>
                <div class="reset-actions">
                    <button type="button" class="reset-cancel" id="reset-cancel">Cancelar</button>
                    <form method="POST" action="{{ route('curso.reiniciar', $ingreso) }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="reset-confirm" id="reset-confirm">Reiniciar capítulo</button>
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

    </div>{{-- /etapa-page --}}

    <script>
        // Layout fluido (llena toda la pantalla). El contenido del main se escala para
        // caber/llenar sin scroll; los márgenes que queden son del mismo teal (no se ven).
        (function () {
            function scaleMainStage() {
                var main = document.querySelector('.etapa-main');
                var stage = document.querySelector('.main-stage');
                if (!main || !stage) return;
                if (!main.clientWidth || !main.clientHeight) { requestAnimationFrame(scaleMainStage); return; }
                var s = Math.min(main.clientWidth / 1080, main.clientHeight / 824);
                s = Math.min(Math.max(s, 0.2), 1.6);   // tope alto → en pantallas grandes el contenido llena más
                stage.style.transform = 'scale(' + s + ')';
            }
            setTimeout(scaleMainStage, 250);
            window.addEventListener('resize', scaleMainStage);
            window.addEventListener('load', scaleMainStage);
            if (document.readyState !== 'loading') scaleMainStage();
            else document.addEventListener('DOMContentLoaded', scaleMainStage);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(scaleMainStage);
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

        // ===== Cuestionario interactivo (puntaje por opción; admite varias correctas) =====
        (function () {
            var card = document.getElementById('cuestionario');
            if (!card) return;
            var xpVal = document.getElementById('xp-val');
            var xpBar = document.getElementById('xp-bar');
            var maxXP = 500;
            var currentXP = parseInt(xpVal ? xpVal.textContent : '0', 10) || 0;
            var base       = currentXP;           // XP ya persistido (sin contar esta etapa)
            var etapaScore = 0;                   // aporte de esta etapa al Scope (reemplaza, no acumula)
            var huboError  = false;               // se marca si en algun intento se eligio una opcion incorrecta
            var resuelto   = false;               // true solo al acertar (bloquea la pregunta)
            var xp = parseInt(card.getAttribute('data-xp'), 10) || 50;

            var comprobar = card.querySelector('.btn-comprobar');
            var repetir   = card.querySelector('.btn-repetir');
            var sigBtn    = card.querySelector('.btn-next-q');
            var justif    = card.querySelector('.justif');
            var justifTxt = card.querySelector('.justif-txt');
            var resultado = card.querySelector('.resultado');
            var resIco    = card.querySelector('.resultado-ico');
            var resTxt    = card.querySelector('.resultado-txt');
            var resInput  = document.getElementById('cuest-resultado');
            var ptsInput  = document.getElementById('cuest-puntos');

            function setXP(v) {
                currentXP = v;                                  // permite restar (puede bajar de 0)
                if (xpVal) xpVal.textContent = currentXP;
                if (xpBar) xpBar.style.width = Math.max(0, Math.min(100, currentXP / maxXP * 100)) + '%';
            }

            // Repetir aparece (con animación) al elegir una opción
            card.querySelectorAll('input[name="pregunta"]').forEach(function (r) {
                r.addEventListener('change', function () { if (!resuelto) repetir.hidden = false; });
            });

            comprobar.addEventListener('click', function () {
                if (resuelto) return;
                var sel = card.querySelector('input[name="pregunta"]:checked');
                if (!sel) return;                       // requiere una opción
                var opt = sel.closest('.opt');
                var pts = parseInt(opt.getAttribute('data-puntos'), 10) || 0;
                var correcta = pts > 0;                 // correcta = puntos positivos
                xp = Math.abs(pts);                     // XP a sumar/restar según la opción elegida

                opt.classList.remove('correct', 'wrong');
                opt.classList.add(correcta ? 'correct' : 'wrong');

                justifTxt.textContent = opt.getAttribute('data-justif') || '';
                justif.hidden = false;

                etapaScore = pts;                          // reemplaza el aporte de esta etapa
                setXP(base + etapaScore);                  // Scope = XP persistido + esta etapa

                if (correcta) {
                    resultado.className = 'resultado ok';
                    resIco.textContent = '✓';
                    resTxt.textContent = '¡Excelente!   + ' + xp + ' XP';
                    sigBtn.classList.add('enabled');           // habilita Siguiente etapa
                    resuelto = true;
                    card.querySelectorAll('input[name="pregunta"]').forEach(function (r) { r.disabled = true; });
                    comprobar.disabled = true;
                    if (resInput) resInput.value = huboError ? 'error' : 'perfecta';
                    if (ptsInput) ptsInput.value = pts;
                } else {
                    resultado.className = 'resultado bad';
                    resIco.textContent = '✕';
                    resTxt.textContent = '¡Respuesta incorrecta!   - ' + xp + ' XP';
                    huboError = true;                          // marca error: cruz en el sidebar
                }
                resultado.hidden = false;
                repetir.hidden = false;
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
