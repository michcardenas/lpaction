<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis diplomas · Programa formativo Lp(a)ction</title>
<style>
  @page { size: A4 landscape; margin: 0; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Calibri", "Carlito", sans-serif; background: #4b5563; }
  .serif { font-family: "Times New Roman", "Liberation Serif", serif; }

  /* Barra de acciones (no se imprime) */
  .toolbar { position: fixed; top:0; left:0; right:0; z-index:1000; display:flex; gap:12px; align-items:center; justify-content:center; padding:12px; background:rgba(17,24,39,.92); color:#fff; font-family: system-ui, sans-serif; font-size:14px; }
  .toolbar a, .toolbar button { font:inherit; border:0; border-radius:8px; padding:9px 16px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
  .btn-pdf { background:#06b6d4; color:#06232b; font-weight:600; }
  .btn-pdf:hover { background:#22d3ee; }
  .btn-volver { background:transparent; color:#cbd5e1; border:1px solid #475569; }
  .btn-volver:hover { color:#fff; border-color:#94a3b8; }

  .wrap { display:flex; justify-content:center; padding: 72px 16px 20px; }
  .wrap + .wrap { padding-top: 24px; }
  .dual-sep { text-align:center; color:#cbd5e1; font-family: system-ui, sans-serif; font-size:13px; letter-spacing:.08em; text-transform:uppercase; padding: 4px 0 0; }

  /* Lienzo base (compartido por los dos certificados) */
  .cpage, .upage { position: relative; width: 842pt; height: 595pt; background:#fff; box-shadow:0 10px 40px rgba(0,0,0,.35); overflow:hidden; }

  /* ===== Diploma 1 · CASEC ===== */
  .cpage { color:#3f3f46; display:flex; flex-direction:column; align-items:center; padding:34pt 70pt 22pt; text-align:center; }
  .cpage::before { content:""; position:absolute; inset:16pt; border:1.5pt solid #8a1538; pointer-events:none; }
  .cpage::after { content:""; position:absolute; inset:20pt; border:0.6pt solid #d9b3c2; pointer-events:none; }
  .casec-logo { width:196pt; height:auto; margin-bottom:7pt; position:relative; }
  .c-intro { font-size:14pt; color:#52525b; margin-bottom:6pt; }
  .c-nombre { font-size:30pt; font-weight:bold; color:#1f2937; line-height:1.1; }
  .c-rule { width:220pt; height:2.4pt; background:#8a1538; margin:10pt 0 12pt; }
  .c-part { font-size:13.5pt; color:#52525b; line-height:1.5; max-width:620pt; }
  .c-curso { font-size:24pt; font-weight:bold; color:#8a1538; margin:10pt 0 4pt; }
  .c-exped { font-size:12pt; color:#52525b; margin-bottom:12pt; }
  .c-cel { font-size:13pt; color:#52525b; line-height:1.5; max-width:660pt; }
  .c-cred { font-size:26pt; font-weight:bold; color:#1f2937; margin:5pt 0; }
  .c-cred b { color:#8a1538; }
  .c-norma { font-size:11pt; color:#6b7280; line-height:1.45; max-width:640pt; }
  .c-firma-wrap { margin-top:auto; display:flex; flex-direction:column; align-items:center; }
  .c-fecha { font-size:12pt; color:#52525b; margin-bottom:2pt; }
  .c-firma-img { width:104pt; height:auto; }
  .c-firma-line { width:240pt; border-top:1pt solid #9ca3af; margin:2pt 0 3pt; }
  .c-firma-nom { font-size:12.5pt; font-weight:bold; color:#1f2937; }
  .c-firma-cargo { font-size:11pt; color:#52525b; }

  /* ===== Diploma 2 · UEMS-ICOMEN ===== */
  .upage { color:#7f7f7f; }
  .upage img { display:block; width:100%; height:100%; object-fit:contain; }
  .abs { position:absolute; }
  .center-line { left:0; width:842pt; text-align:center; line-height:1; }
  .corner { position:absolute; width:24pt; height:24pt; }
  .corner::before, .corner::after { content:""; position:absolute; background:#c81f2d; }
  .corner::before { width:24pt; height:2.4pt; }
  .corner::after { width:2.4pt; height:24pt; }
  .c-tl { top:22pt; left:30pt; } .c-tl::before { top:0; left:0; } .c-tl::after { top:0; left:0; }
  .c-tr { top:22pt; right:30pt; } .c-tr::before { top:0; right:0; } .c-tr::after { top:0; right:0; }
  .c-bl { bottom:22pt; left:30pt; } .c-bl::before { bottom:0; left:0; } .c-bl::after { bottom:0; left:0; }
  .c-br { bottom:22pt; right:30pt; } .c-br::before { bottom:0; right:0; } .c-br::after { bottom:0; right:0; }
  .accent { position:absolute; left:413pt; width:26pt; height:5pt; background:#ac0011; }
  .escudo { top:19pt; left:71pt; width:83pt; height:86pt; }
  .logosec { top:10pt; left:646pt; width:148pt; height:102pt; }
  .sello { top:459pt; left:377pt; width:90pt; height:89pt; }
  .firma1 { top:473pt; left:143pt; width:139pt; height:51pt; }
  .firma2 { top:446pt; left:563pt; width:169pt; height:110pt; }
  .badge { top:404pt; left:600pt; width:208pt; height:81pt; }
  .u-intro { top:129pt; font-size:14pt; }
  .u-nombre { top:168pt; font-size:28pt; font-weight:bold; }
  .u-dni { top:225pt; font-size:14pt; }
  .u-dni b { font-weight:bold; }
  .u-aprov { top:242pt; font-size:14pt; }
  .u-curso { top:274pt; font-size:28pt; font-weight:bold; }
  .u-cuerpo { top:327pt; font-size:10pt; line-height:1.2; }
  .u-firmanp { top:413pt; font-size:10pt; }
  .u-cuerpo b, .u-firmanp b { font-weight:bold; }
  .sig-name { font-size:11pt; line-height:1.25; }
  .sig-l { top:529pt; left:20pt; width:400pt; text-align:center; }
  .sig-r { top:529pt; left:480pt; width:320pt; text-align:center; }

  @media print {
    body { background:#fff; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    .toolbar, .dual-sep { display:none !important; }
    .wrap { padding:0; display:block; }
    .wrap + .wrap { page-break-before: always; }
    .cpage, .upage { box-shadow:none; margin:0; }
  }
</style>
</head>
<body>
  <div class="toolbar">
    <span>Tienes 2 diplomas (desliza para ver el 2º).</span>
    <button class="btn-pdf" onclick="window.print()">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0l-4-4m4 4l4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
      Descargar PDF (los 2)
    </button>
    <a class="btn-volver" href="{{ route('curso') }}">Volver al curso</a>
  </div>

  {{-- ================= DIPLOMA 1 · CASEC ================= --}}
  <div class="wrap">
    <div class="cpage">
      <img class="casec-logo" src="{{ asset('images/diploma/casec_logo.jpg') }}" alt="Comité de Acreditación de la Sociedad Española de Cardiología">
      <div class="c-intro">Certificado emitido a favor de</div>
      <div class="c-nombre serif">Dr./Dra. {{ $casec['nombre'] }} {{ $casec['apellidos'] }}</div>
      <div class="c-rule"></div>
      <div class="c-part">con DNI <b>{{ $casec['documento'] }}</b> por su participación como <b>{{ $casec['rol'] }}</b> y con aprovechamiento en la Actividad de Formación</div>
      <div class="c-curso serif">{{ $casec['curso'] }}</div>
      <div class="c-exped">Expediente Nº: {{ $casec['expediente'] }}</div>
      <div class="c-cel">Celebrada {{ $casec['lugar'] }} desde el {{ $casec['fecha_inicio'] }} hasta el {{ $casec['fecha_fin'] }}, con una duración de {{ $casec['horas'] }} horas, y en la cual ha obtenido:</div>
      <div class="c-cred"><b>{{ $casec['creditos'] }} créditos</b></div>
      <div class="c-norma">según normativa del Comité de Acreditación y de la Comisión de Formación de la Sociedad Española de Cardiología.</div>
      <div class="c-firma-wrap">
        <div class="c-fecha">{{ $casec['fecha_emision'] }}</div>
        <img class="c-firma-img" src="{{ asset('images/diploma/casec_firma.jpg') }}" alt="Firma">
        <div class="c-firma-line"></div>
        <div class="c-firma-nom serif">{{ $casec['presidente'] }}</div>
        <div class="c-firma-cargo">Presidente Sociedad Española de Cardiología</div>
      </div>
    </div>
  </div>

  <div class="dual-sep">▼ Diploma 2 de 2 · UEMS-ICOMEN ▼</div>

  {{-- ================= DIPLOMA 2 · UEMS-ICOMEN ================= --}}
  <div class="wrap">
    <div class="upage">
      <div class="corner c-tl"></div><div class="corner c-tr"></div><div class="corner c-bl"></div><div class="corner c-br"></div>
      <div class="abs escudo"><img src="{{ asset('images/diploma/escudo_madrid.jpg') }}" alt=""></div>
      <div class="abs logosec"><img src="{{ asset('images/diploma/logo_sec.jpg') }}" alt=""></div>
      <div class="abs center-line u-intro">El presente certificado acredita que</div>
      <div class="abs center-line u-nombre serif">Dr./Dra. {{ $uems['nombre'] }} {{ $uems['apellidos'] }}</div>
      <div class="accent" style="top:207pt;"></div>
      <div class="abs center-line u-dni"><b>con {{ $uems['documento'] }}</b>, ha participado como ASISTENTE</div>
      <div class="abs center-line u-aprov">y con aprovechamiento&nbsp; en el curso</div>
      <div class="accent" style="top:260pt;"></div>
      <div class="abs center-line u-curso serif">{{ $uems['curso'] }}</div>
      <div class="abs center-line u-cuerpo">
        Incluido en el PROGRAMA DE FORMACIÓN de la Sociedad Española de Cardiología, en colaboración con Ilustre Colegio Oficial de Médicos<br>
        de Madrid, celebrado online, desde {{ $uems['fecha_inicio'] }} al {{ $uems['fecha_fin'] }}, con una duración de {{ $uems['horas'] }} horas lectivas.<br>
        Esta actividad docente (Nº de registro {{ $uems['registro_uems'] }}) ha sido acreditada por el Consejo Profesional Médico Español para el<br>
        DPC/FMC (SEAFORMEC – EACCME), con <b>{{ $uems['creditos'] }} créditos</b> a distancia ECMEC´s.
      </div>
      <div class="abs center-line u-firmanp">Y para que conste, firman el presente certificado en Madrid, a {{ $uems['fecha_emision'] }}.</div>
      <div class="abs badge"><img src="{{ asset('images/diploma/badge_seaformec_v2.png') }}" alt="Actividad acreditada SEAFORMEC/SMPAC · UEMS"></div>
      <div class="abs firma1"><img src="{{ asset('images/diploma/firma1.jpg') }}" alt=""></div>
      <div class="abs sello"><img src="{{ asset('images/diploma/sello_madrid.jpg') }}" alt=""></div>
      <div class="abs firma2"><img src="{{ asset('images/diploma/firma2.jpg') }}" alt=""></div>
      <div class="abs sig-name serif sig-l">Dr. D. Manuel Martínez-Sellés D'Oliveira Soares<br>Presidente del ICOMEM</div>
      <div class="abs sig-name serif sig-r">Ignacio Fernández Lozano<br>Presidente Sociedad Española de Cardiología</div>
    </div>
  </div>
</body>
</html>
