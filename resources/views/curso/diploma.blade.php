<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Diploma · Programa formativo Lp(a)ction</title>
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
    background: #fff; overflow: hidden; color: #7f7f7f;
    box-shadow: 0 10px 40px rgba(0,0,0,.35);
  }
  .abs { position: absolute; }
  .center-line { left: 0; width: 842pt; text-align: center; line-height: 1; }

  /* Marcas de esquina rojas (L) */
  .corner { position: absolute; width: 24pt; height: 24pt; }
  .corner::before, .corner::after { content: ""; position: absolute; background: #c81f2d; }
  .corner::before { width: 24pt; height: 2.4pt; }
  .corner::after  { width: 2.4pt; height: 24pt; }
  .c-tl { top: 22pt; left: 30pt; }  .c-tl::before { top: 0; left: 0; }  .c-tl::after { top: 0; left: 0; }
  .c-tr { top: 22pt; right: 30pt; } .c-tr::before { top: 0; right: 0; } .c-tr::after { top: 0; right: 0; }
  .c-bl { bottom: 22pt; left: 30pt; }  .c-bl::before { bottom: 0; left: 0; }  .c-bl::after { bottom: 0; left: 0; }
  .c-br { bottom: 22pt; right: 30pt; } .c-br::before { bottom: 0; right: 0; } .c-br::after { bottom: 0; right: 0; }

  /* Barras de acento rojas */
  .accent { position: absolute; left: 413pt; width: 26pt; height: 5pt; background: #ac0011; }

  /* Logos e imágenes */
  .escudo  { top: 19pt;  left: 71pt;  width: 83pt;  height: 86pt; }
  .logosec { top: 10pt;  left: 646pt; width: 148pt; height: 102pt; }
  .sello   { top: 459pt; left: 377pt; width: 90pt;  height: 89pt; }
  .firma1  { top: 473pt; left: 143pt; width: 139pt; height: 51pt; }
  .firma2  { top: 446pt; left: 563pt; width: 169pt; height: 110pt; }
  .badge   { top: 396pt; left: 650pt; width: 152pt; height: 66pt; }
  .page img { display: block; width: 100%; height: 100%; object-fit: contain; }

  /* Tipos de texto */
  .serif { font-family: "Times New Roman", "Liberation Serif", serif; }
  .intro   { top: 129pt; font-size: 14pt; }
  .nombre  { top: 168pt; font-size: 28pt; font-weight: bold; }
  .dni     { top: 225pt; font-size: 14pt; }
  .dni b   { font-weight: bold; }
  .aprov   { top: 242pt; font-size: 14pt; }
  .curso   { top: 274pt; font-size: 28pt; font-weight: bold; }
  .cuerpo  { top: 327pt; font-size: 10pt; line-height: 1.2; }
  .firmanp { top: 413pt; font-size: 10pt; }
  .cuerpo b, .firmanp b { font-weight: bold; }

  /* Firmas: nombre y cargo */
  .sig-name { font-size: 11pt; line-height: 1.25; }
  .sig-l { top: 529pt; left: 20pt;  width: 400pt; text-align: center; }
  .sig-r { top: 529pt; left: 480pt; width: 320pt; text-align: center; }

  /* Letra pequeña de acreditación */
  .fine { position: absolute; top: 437pt; left: 618pt; width: 210pt; font-size: 4pt;
          line-height: 1.35; color: #000; text-align: center; z-index: 10; }

  /* Impresión: quitar fondo/toolbar y forzar tamaño exacto */
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
    <span>Tu diploma está listo.</span>
    <button class="btn-pdf" onclick="window.print()">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0l-4-4m4 4l4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
      Descargar PDF
    </button>
    <a class="btn-volver" href="{{ route('curso') }}">Volver al curso</a>
  </div>

  <div class="wrap">
    <div class="page">
      {{-- Esquinas --}}
      <div class="corner c-tl"></div>
      <div class="corner c-tr"></div>
      <div class="corner c-bl"></div>
      <div class="corner c-br"></div>

      {{-- Logos --}}
      <div class="abs escudo"><img src="{{ asset('images/diploma/escudo_madrid.jpg') }}" alt=""></div>
      <div class="abs logosec"><img src="{{ asset('images/diploma/logo_sec.jpg') }}" alt=""></div>

      {{-- Texto principal --}}
      <div class="abs center-line intro">El presente certificado acredita que</div>
      <div class="abs center-line nombre serif">Dr./Dra. {{ $diploma['nombre'] }} {{ $diploma['apellidos'] }}</div>
      <div class="accent" style="top:207pt;"></div>
      <div class="abs center-line dni"><b>con {{ $diploma['documento'] }}</b>, ha participado como ASISTENTE</div>
      <div class="abs center-line aprov">y con aprovechamiento&nbsp; en el curso</div>
      <div class="accent" style="top:260pt;"></div>
      <div class="abs center-line curso serif">{{ $diploma['curso'] }}</div>

      <div class="abs center-line cuerpo">
        Incluido en el PROGRAMA DE FORMACIÓN de la Sociedad Española de Cardiología, en colaboración con Ilustre Colegio Oficial de Médicos<br>
        de Madrid, celebrado online, desde {{ $diploma['fecha_inicio'] }} al {{ $diploma['fecha_fin'] }}, con una duración de {{ $diploma['horas'] }} horas lectivas.<br>
        Esta actividad docente (Nº de registro {{ $diploma['registro_uems'] }}) ha sido acreditada por el Consejo Profesional Médico Español para el<br>
        DPC/FMC (SEAFORMEC – EACCME), con <b>{{ $diploma['creditos'] }} créditos</b> a distancia ECMEC´s.
      </div>

      <div class="abs center-line firmanp">Y para que conste, firman el presente certificado en Madrid, a {{ $diploma['fecha_emision'] }}.</div>

      {{-- Insignia SEAFORMEC/UEMS + letra pequeña --}}
      <div class="abs badge"><img src="{{ asset('images/diploma/badge_seaformec.jpg') }}" alt=""></div>
      <div class="fine">
        Actividad presencial: acreditada con 0.0 ECMECs y CPE-DPCs<br>
        Actividad a distancia: acreditada con {{ $diploma['creditos'] }} ECMECs y CPE-DPCs<br>
        Registro UEMS-EACCME: {{ $diploma['registro_uems'] }}<br>
        Registro SEAFORMEC-SMPAC: {{ $diploma['registro_seaformec'] }}
      </div>

      {{-- Firmas --}}
      <div class="abs firma1"><img src="{{ asset('images/diploma/firma1.jpg') }}" alt=""></div>
      <div class="abs sello"><img src="{{ asset('images/diploma/sello_madrid.jpg') }}" alt=""></div>
      <div class="abs firma2"><img src="{{ asset('images/diploma/firma2.jpg') }}" alt=""></div>

      <div class="abs sig-name serif sig-l">Dr. D. Manuel Martínez-Sellés D'Oliveira Soares<br>Presidente del ICOMEM</div>
      <div class="abs sig-name serif sig-r">Dr. D. Ignacio Fernández Lozano<br>Presidente de la SEC</div>
    </div>
  </div>
</body>
</html>
