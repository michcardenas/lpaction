<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificado · Programa formativo Lp(a)ction</title>
<style>
  @page { size: A4 landscape; margin: 0; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Calibri", "Carlito", sans-serif; background: #4b5563; }

  /* Barra de acciones (no se imprime) */
  .toolbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    display: flex; gap: 12px; align-items: center; justify-content: center;
    padding: 12px; background: rgba(17,24,39,.92); color: #fff;
    font-family: system-ui, sans-serif; font-size: 14px;
  }
  .toolbar a, .toolbar button {
    font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer;
    text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
  }
  .btn-pdf { background: #06b6d4; color: #06232b; font-weight: 600; }
  .btn-pdf:hover { background: #22d3ee; }
  .btn-volver { background: transparent; color: #cbd5e1; border: 1px solid #475569; }
  .btn-volver:hover { color: #fff; border-color: #94a3b8; }

  /* Lienzo del certificado */
  .wrap { display: flex; justify-content: center; padding: 72px 16px 40px; }
  .page {
    position: relative;
    width: 842pt; height: 595pt;
    background: #fff; overflow: hidden; color: #3f3f46;
    box-shadow: 0 10px 40px rgba(0,0,0,.35);
    display: flex; flex-direction: column; align-items: center;
    padding: 46pt 70pt 40pt; text-align: center;
  }
  /* Marco interior sutil en granate SEC */
  .page::before {
    content: ""; position: absolute; inset: 16pt; border: 1.5pt solid #8a1538; pointer-events: none;
  }
  .page::after {
    content: ""; position: absolute; inset: 20pt; border: 0.6pt solid #d9b3c2; pointer-events: none;
  }

  .casec-logo { width: 210pt; height: auto; margin-bottom: 14pt; position: relative; }
  .serif { font-family: "Times New Roman", "Liberation Serif", serif; }

  .c-intro   { font-size: 14pt; color: #52525b; margin-bottom: 6pt; }
  .c-nombre  { font-size: 30pt; font-weight: bold; color: #1f2937; line-height: 1.1; }
  .c-rule    { width: 220pt; height: 2.4pt; background: #8a1538; margin: 10pt 0 12pt; }
  .c-part    { font-size: 13.5pt; color: #52525b; line-height: 1.5; max-width: 620pt; }
  .c-curso   { font-size: 24pt; font-weight: bold; color: #8a1538; margin: 10pt 0 4pt; }
  .c-exped   { font-size: 12pt; color: #52525b; margin-bottom: 12pt; }
  .c-cel     { font-size: 13pt; color: #52525b; line-height: 1.5; max-width: 660pt; }
  .c-cred    { font-size: 26pt; font-weight: bold; color: #1f2937; margin: 8pt 0; }
  .c-cred b  { color: #8a1538; }
  .c-norma   { font-size: 11pt; color: #6b7280; line-height: 1.45; max-width: 640pt; }

  .c-firma-wrap { margin-top: auto; display: flex; flex-direction: column; align-items: center; }
  .c-fecha   { font-size: 12pt; color: #52525b; margin-bottom: 6pt; }
  .c-firma-img { width: 150pt; height: auto; }
  .c-firma-line { width: 240pt; border-top: 1pt solid #9ca3af; margin: 2pt 0 6pt; }
  .c-firma-nom { font-size: 12.5pt; font-weight: bold; color: #1f2937; }
  .c-firma-cargo { font-size: 11pt; color: #52525b; }

  @media print {
    body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .toolbar { display: none !important; }
    .wrap { padding: 0; display: block; }
    .page { box-shadow: none; margin: 0; }
  }
</style>
</head>
<body>
  <div class="toolbar">
    <span>Tu certificado está listo.</span>
    <button class="btn-pdf" onclick="window.print()">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0l-4-4m4 4l4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
      Descargar PDF
    </button>
    <a class="btn-volver" href="{{ route('curso') }}">Volver al curso</a>
  </div>

  <div class="wrap">
    <div class="page">
      <img class="casec-logo" src="{{ asset('images/diploma/casec_logo.jpg') }}" alt="Comité de Acreditación de la Sociedad Española de Cardiología">

      <div class="c-intro">Certificado emitido a favor de</div>
      <div class="c-nombre serif">Dr./Dra. {{ $diploma['nombre'] }} {{ $diploma['apellidos'] }}</div>
      <div class="c-rule"></div>

      <div class="c-part">
        con DNI <b>{{ $diploma['documento'] }}</b> por su participación como <b>{{ $diploma['rol'] }}</b> y con
        aprovechamiento en la Actividad de Formación
      </div>
      <div class="c-curso serif">{{ $diploma['curso'] }}</div>
      <div class="c-exped">Expediente Nº: {{ $diploma['expediente'] }}</div>

      <div class="c-cel">
        Celebrada {{ $diploma['lugar'] }} desde el {{ $diploma['fecha_inicio'] }} hasta el {{ $diploma['fecha_fin'] }},
        con una duración de {{ $diploma['horas'] }} horas, y en la cual ha obtenido:
      </div>
      <div class="c-cred"><b>{{ $diploma['creditos'] }} créditos</b></div>
      <div class="c-norma">
        según normativa del Comité de Acreditación y de la Comisión de Formación de la Sociedad Española de Cardiología.
      </div>

      <div class="c-firma-wrap">
        <div class="c-fecha">{{ $diploma['fecha_emision'] }}</div>
        <img class="c-firma-img" src="{{ asset('images/diploma/casec_firma.jpg') }}" alt="Firma">
        <div class="c-firma-line"></div>
        <div class="c-firma-nom serif">{{ $diploma['presidente'] }}</div>
        <div class="c-firma-cargo">Presidente · Sociedad Española de Cardiología</div>
      </div>
    </div>
  </div>
</body>
</html>
