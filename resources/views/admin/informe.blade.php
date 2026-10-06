<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Informe final · Resultados del curso · Lp(a)ction</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@php
  // ---- Datos reales (CourseReport::build()) + helpers de formato ----
  $fmt   = fn ($v, $dec = 0, $def = '—') => is_null($v) ? $def : number_format($v, $dec, ',', '.');
  $pct   = fn ($x, $base) => $base > 0 ? round($x / $base * 100, 1) : 0;
  $barW  = fn ($x, $base) => $base > 0 ? min(100, round($x / $base * 100, 1)) : 0;

  $reg   = (int) $r['registrados'];
  $bk    = $r['buckets'];
  // Donut: segmentos sobre el TOTAL de participantes (los no evaluados no desaparecen).
  $deg   = fn ($n) => $reg > 0 ? $n / $reg * 360 : 0;
  $c1    = $deg($bk['b9']);
  $c2    = $c1 + $deg($bk['b8']);
  $c3    = $c2 + $deg($bk['bl']);
  $donutBg = $reg > 0
      ? "conic-gradient(#2b7f9e 0 {$c1}deg, #17a9dd {$c1}deg {$c2}deg, #7a1420 {$c2}deg {$c3}deg, #c2ccd2 {$c3}deg 360deg)"
      : "conic-gradient(#c2ccd2 0 360deg)";

  // Etiquetas de perfil por experiencia.
  $pfTit = ['0-7' => '0-7 años de experiencia profesional', '8-15' => '8-15 años de experiencia profesional', '16+' => '≥16 años de experiencia profesional'];
  $pfCol = ['0-7' => '0-7 años', '8-15' => '8-15 años', '16+' => '≥16 años'];
  $pfRef = ['0-7' => 'de usuarios activos', '8-15' => 'de quienes completan M1', '16+' => 'de quienes completan M2'];
@endphp
<style>
  @page { size: A4 portrait; margin: 0; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  :root { --mol: url('{{ asset('images/molecula-lpa.png') }}'); }
  body { font-family: 'Montserrat', system-ui, sans-serif; color: #223b45; background: #cfe0ec; }

  /* Barra de herramientas (no se imprime) */
  .toolbar { position: sticky; top: 0; z-index: 50; display: flex; gap: 12px; align-items: center; justify-content: center;
             padding: 12px; background: #0d2430; color: #fff; font-size: 14px; }
  .toolbar button, .toolbar a { font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer;
             text-decoration: none; display: inline-flex; align-items: center; gap: 7px; }
  .btn-pdf { background: #05BAEE; color: #06232b; font-weight: 700; }
  .btn-pdf:hover { background: #22d3ee; }
  .btn-volver { background: transparent; color: #cbd5e1; border: 1px solid #3a5563; }

  .doc { width: 210mm; margin: 18px auto; }

  /* Cada página = A4, fondo azul claro con molécula tenue en las esquinas */
  .page { position: relative; width: 210mm; min-height: 297mm; overflow: hidden;
          background: linear-gradient(170deg, #eaf5fb 0%, #dcebf4 55%, #d2e6f1 100%);
          padding: 24mm 20mm; margin-bottom: 18px; box-shadow: 0 8px 30px rgba(20,60,80,.14); }
  .page::before, .page::after { content: ''; position: absolute; width: 360px; height: 360px;
          background: var(--mol) no-repeat center / contain; opacity: .10; pointer-events: none; z-index: 0; }
  .page::before { top: -110px; right: -120px; }
  .page::after  { bottom: -120px; left: -130px; }
  .page > * { position: relative; z-index: 1; }

  /* Cabecera de página */
  .ph { display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px;
        border-bottom: 1.5px solid #9fd4ea; margin-bottom: 26px; }
  .ph img { height: 30px; }
  .ph .tag { font-size: 12px; font-weight: 700; letter-spacing: .06em; color: #7a1420; }

  h2.sec { font-family: 'Montserrat'; font-size: 28px; font-weight: 700; color: #2f7e9c; margin-bottom: 10px; }
  .lead { font-size: 14px; color: #55707c; line-height: 1.5; max-width: 560px; margin-bottom: 26px; }

  /* Tarjeta con cabecera roja */
  .card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(20,60,80,.08); overflow: hidden; break-inside: avoid; }
  .card-h { background: #7a1420; color: #fff; text-align: center; font-weight: 700; font-size: 17px; padding: 16px; letter-spacing: .01em; }
  .card-b { padding: 26px 30px; }

  /* KPIs visión ejecutiva */
  .kpis { display: grid; grid-template-columns: 1fr 1fr; gap: 26px 40px; }
  .kpi .n { font-size: 40px; font-weight: 800; color: #2176a0; line-height: 1; }
  .kpi .l { font-size: 16px; font-weight: 600; color: #7a1420; margin-top: 6px; }
  .kpi .s { font-size: 12.5px; color: #8a99a0; margin-top: 3px; }

  /* Tabla genérica dentro de card */
  table { width: 100%; border-collapse: collapse; }
  .tbl-head td { color: #7a1420; font-weight: 600; font-size: 14px; padding: 14px 10px; background: #eceef1; }
  .tbl-head td.c { color: #2f7e9c; }
  .tbl-head td.r { text-align: center; }

  /* Fila de embudo / dificultad con barra */
  .barrow td { padding: 16px 10px 4px; font-size: 14px; color: #33505c; vertical-align: bottom; }
  .barrow td.lbl { color: #223b45; }
  .barrow td.c { text-align: center; color: #33505c; }
  .barrow td.pc { text-align: right; color: #33505c; font-weight: 500; }
  .bar { grid-column: 1 / -1; height: 20px; border-radius: 999px; background: #fff; border: 1px solid #dceaf1; overflow: hidden; }
  .bar i { display: block; height: 100%; border-radius: 999px;
           background: linear-gradient(90deg, #2b6f90 0%, #19a3d6 65%, #27c2ef 100%); }
  .bar-cell { padding: 2px 10px 14px; }

  /* Pastilla roja + etiquetas (retención / perfil) */
  .pill { display: inline-flex; align-items: center; justify-content: center; background: #7a1420; color: #fff;
          font-weight: 700; font-size: 17px; border-radius: 999px; padding: 12px 30px; }
  .pill-sm { font-size: 15px; padding: 10px 24px; }
  .chip { display: inline-block; background: #f3f6f8; border-radius: 999px; padding: 10px 20px; font-size: 14px; color: #33505c; }
  .chip b { color: #2176a0; }

  .mod-card { background: #fff; border-radius: 20px; box-shadow: 0 8px 26px rgba(20,60,80,.08); padding: 22px 28px; margin-bottom: 20px; break-inside: avoid; }
  .mod-top { display: flex; align-items: center; gap: 22px; padding-bottom: 16px; border-bottom: 1px solid #edf1f4; margin-bottom: 16px; }
  .mod-top .ingreso { color: #2f7e9c; font-weight: 600; font-size: 16px; line-height: 1.15; }
  .mod-big { display: flex; align-items: baseline; gap: 14px; }
  .mod-big .n { font-size: 48px; font-weight: 800; color: #2176a0; line-height: .9; }
  .mod-big .of { font-size: 15px; color: #56707b; }
  .mod-big .tot { margin-left: auto; font-size: 16px; font-weight: 700; color: #2176a0; }

  /* Tarjeta cian (lectura / interpretación / resultado global) */
  .cyan { border-radius: 20px; color: #fff; padding: 22px 28px; margin-top: 26px; break-inside: avoid;
          background: linear-gradient(100deg, #2e7f9d 0%, #1aa6da 70%, #1cb6e8 100%); box-shadow: 0 10px 28px rgba(26,120,160,.25); }
  .cyan .ct { font-size: 13px; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.85); font-weight: 600; }
  .cyan .cbig { font-size: 24px; font-weight: 700; }
  .cyan .crow { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
  .cyan hr { border: 0; border-top: 1px solid rgba(255,255,255,.3); margin: 12px 0; }
  .cyan ul { list-style: none; }
  .cyan li { font-size: 15px; padding: 5px 0 5px 18px; position: relative; }
  .cyan li::before { content: '·'; position: absolute; left: 4px; font-weight: 800; }
  .cyan p { font-size: 14px; line-height: 1.5; color: rgba(255,255,255,.92); }

  /* Donut */
  .donut-wrap { display: flex; align-items: center; gap: 40px; }
  .donut { width: 220px; height: 220px; border-radius: 50%; background: {!! $donutBg !!}; flex: none; position: relative; }
  .donut::after { content: ''; position: absolute; inset: 58px; background: #fdfefe; border-radius: 50%; }
  .donut-c { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2; }
  .donut-c .n { font-size: 40px; font-weight: 800; color: #2176a0; line-height: 1; }
  .donut-c .l { font-size: 13px; color: #7a8891; }
  .legend { display: flex; flex-direction: column; gap: 16px; }
  .legend .row { display: flex; align-items: center; gap: 12px; font-size: 14px; color: #33505c; }
  .legend .dot { width: 16px; height: 16px; border-radius: 50%; flex: none; }
  .legend .rng { width: 62px; font-weight: 600; color: #223b45; }
  .legend .cn { width: 42px; text-align: right; }
  .legend .pc { width: 52px; text-align: right; color: #7a8891; }

  /* Tiles rojos */
  .rtiles { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 26px; }
  .rtile { background: #7a1420; color: #fff; border-radius: 16px; padding: 20px; text-align: center; }
  .rtile .n { font-size: 34px; font-weight: 800; }
  .rtile .l { font-size: 13.5px; margin-top: 6px; color: rgba(255,255,255,.88); }
  .rtile .s { font-size: 13px; font-weight: 700; margin-top: 6px; }

  /* Cuatro tarjetas de resultado global (encuesta) */
  .gcards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin: -28px 0 24px; }
  .gcard { background: #fff; border: 1px solid #dfeaf0; border-radius: 16px; padding: 16px 18px; box-shadow: 0 6px 18px rgba(20,60,80,.06); }
  .gcard .l { font-size: 12.5px; color: #7a1420; font-weight: 600; }
  .gcard .n { font-size: 26px; font-weight: 800; color: #2176a0; margin-top: 10px; }

  /* Tabla listada (encuesta / heatmap) */
  .ltbl td { padding: 13px 10px; font-size: 14px; border-bottom: 1px solid #eef2f4; }
  .ltbl tr:last-child td { border-bottom: 0; }
  .ltbl .dim { color: #33505c; }
  .ltbl .v { text-align: center; color: #33505c; font-variant-numeric: tabular-nums; }
  .ltbl thead td { background: #eceef1; color: #7a1420; font-weight: 600; border-bottom: 0; }
  .ltbl thead td.c { color: #2f7e9c; text-align: center; }

  .note { text-align: center; font-size: 12px; color: #88969d; margin-top: 14px; }

  /* Resumen final */
  .scard { background: #fff; border-radius: 20px; box-shadow: 0 8px 26px rgba(20,60,80,.08); padding: 24px 30px; margin-bottom: 22px; break-inside: avoid; }
  .scard .k { font-size: 14px; letter-spacing: .12em; text-transform: uppercase; color: #7a1420; font-weight: 700; padding-bottom: 12px; border-bottom: 1px solid #edf1f4; margin-bottom: 16px; }
  .scard .big { display: flex; align-items: baseline; gap: 14px; }
  .scard .big .n { font-size: 48px; font-weight: 800; color: #2176a0; line-height: .9; }
  .scard .big .u { font-size: 15px; color: #56707b; }
  .scard .txt { font-size: 14px; color: #55707c; line-height: 1.5; margin-top: 12px; }

  /* Portada */
  .cover { display: flex; flex-direction: column; align-items: center; justify-content: flex-start; text-align: center; padding-top: 0; }
  .cover-top { width: 100%; display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
  .cover-badge { background: #7a1420; color: #fff; font-weight: 800; letter-spacing: .04em; font-size: 20px; padding: 12px 34px; border-radius: 999px; }
  .cover-sec { height: 86px; }
  .cover-logo { height: 70px; margin: 6px 0 4px; }
  .cover-mol { width: 460px; max-width: 70%; margin: 6px 0; }
  .cover h1 { font-size: 74px; line-height: .98; font-weight: 700; color: #2f8bb0; letter-spacing: -.01em; }
  .cover-foot { margin-top: 28px; width: 100%; display: flex; align-items: center; justify-content: space-between; }
  .cover-qual { height: 74px; }
  .cover-data { font-size: 15px; font-weight: 700; letter-spacing: .05em; color: #7a1420; border-top: 1px solid #c88; border-bottom: 1px solid #c88; padding: 10px 0; }

  @media print {
    body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .toolbar { display: none !important; }
    .doc { margin: 0; width: auto; }
    .page { margin: 0; box-shadow: none; page-break-after: always; }
    .page:last-child { page-break-after: auto; }
  }
</style>
</head>
<body>

  <div class="toolbar">
    <button class="btn-pdf" onclick="window.print()">⭳ Descargar PDF</button>
    <a class="btn-volver" href="{{ route('admin') }}">← Volver al panel</a>
  </div>

  <div class="doc">

    {{-- ======================= PORTADA ======================= --}}
    <section class="page cover">
      <div class="cover-top">
        <span class="cover-badge">INFORME FINAL</span>
        <img class="cover-sec" src="{{ asset('images/sec-logo-hd.png') }}" alt="Sociedad Española de Cardiología">
      </div>
      <img class="cover-logo" src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction">
      <img class="cover-mol" src="{{ asset('images/molecula-lpa.png') }}" alt="">
      <h1>Resultados<br>del curso</h1>
      <div class="cover-foot">
        <img class="cover-qual" src="{{ asset('images/qualimed-logo.svg') }}" alt="Qualimed">
        <span class="cover-data">DATOS REALES · {{ $r['generado']->format('d/m/Y') }}</span>
      </div>
    </section>

    {{-- ===================== VISIÓN EJECUTIVA ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Visión ejecutiva del curso</h2>
      <p class="lead">Los indicadores principales combinan alcance, finalización, resultado académico, acreditación y experiencia del participante.</p>

      <div class="card">
        <div class="card-h">Indicadores principales</div>
        <div class="card-b">
          <div class="kpis">
            <div class="kpi"><div class="n">{{ $fmt($r['registrados']) }}</div><div class="l">Participantes registrados</div><div class="s">Sobre {{ $fmt($r['plazas']) }} plazas</div></div>
            <div class="kpi"><div class="n">{{ $fmt($r['m3']) }}</div><div class="l">Completan los 3 módulos</div><div class="s">{{ $fmt($r['pctCompletan'],1) }}% del total</div></div>
            <div class="kpi"><div class="n">{{ $fmt($r['notaMedia'],1) }} / 10</div><div class="l">Nota media final</div><div class="s">Entre evaluados</div></div>
            <div class="kpi"><div class="n">{{ $fmt($r['pctAptos'],1) }}%</div><div class="l">Aptos / evaluados</div><div class="s">{{ $fmt($r['aptos']) }} de {{ $fmt($r['evaluados']) }}</div></div>
            <div class="kpi"><div class="n">{{ $fmt($r['diplomas']) }}</div><div class="l">Diplomas emitidos</div><div class="s">{{ $fmt($pct($r['diplomas'],$r['aptos']),1) }}% de aptos</div></div>
            <div class="kpi"><div class="n">{{ $fmt($r['satisfaccion'],1) }} / 5</div><div class="l">Satisfacción global</div><div class="s">n = {{ $fmt($r['encuestas']) }}</div></div>
          </div>
        </div>
      </div>

      <div class="cyan">
        <div class="ct">Lectura recomendada</div>
        <hr>
        <ul>
          <li>Alcance: {{ $fmt($r['registrados']) }} registros y una activación del {{ $fmt($r['pctActivacion'],1) }}%.</li>
          <li>Retención: {{ $fmt($r['m3']) }} usuarios completan el tercer módulo, el {{ $fmt($r['pctCompletan'],1) }}% de los participantes.</li>
          <li>Aprendizaje: {{ $fmt($r['pctAptos'],1) }}% de aptos y nota media final de {{ $fmt($r['notaMedia'],1) }} sobre 10.</li>
        </ul>
      </div>
    </section>

    {{-- ===================== EMBUDO ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Actividad y participación</h2>
      <p class="lead">El informe presenta el embudo de participación del curso: cuántas personas van quedando en cada etapa, desde el registro hasta la aprobación final.</p>

      <div class="card">
        <div class="card-h">Embudo del curso</div>
        <div class="card-b" style="padding-top:8px;">
          <table>
            <tr class="tbl-head"><td>Etapa</td><td class="r c">N.º participantes etapa</td><td class="r c">Total participantes</td><td class="r">% del total</td></tr>
            @foreach ($r['funnel'] as $f)
              <tr class="barrow">
                <td class="lbl">{{ str_replace('Completan Módulo ', 'Completan M', $f['etapa']) }}</td>
                <td class="c">{{ $fmt($f['n']) }}</td>
                <td class="c">{{ $fmt($r['registrados']) }}</td>
                <td class="pc">{{ $fmt($pct($f['n'], $r['registrados']),1) }}%</td>
              </tr>
              <tr><td colspan="4" class="bar-cell"><div class="bar"><i style="width:{{ $barW($f['n'], $r['registrados']) }}%"></i></div></td></tr>
            @endforeach
          </table>
        </div>
      </div>
    </section>

    {{-- ===================== RETENCIÓN POR MÓDULO ===================== --}}
    @php
      $mods = [
        1 => ['pill' => 'Módulo 1', 'ing' => 'Primer<br>ingreso', 'n' => $r['m1'], 'ret' => $pct($r['m1'], $r['inician']), 'ref' => 'de usuarios activos'],
        2 => ['pill' => 'Módulo 2', 'ing' => 'Segundo<br>ingreso', 'n' => $r['m2'], 'ret' => $pct($r['m2'], $r['m1']), 'ref' => 'de quienes completan M1'],
        3 => ['pill' => 'Módulo 3', 'ing' => 'Tercer<br>ingreso', 'n' => $r['m3'], 'ret' => $pct($r['m3'], $r['m2']), 'ref' => 'de quienes completan M2'],
      ];
      $perdida = max(0, $r['m1'] - $r['m3']);
    @endphp
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Cuántos participantes realizan cada módulo</h2>
      <p class="lead">La cifra principal se muestra sobre el total de participantes y también se indica la retención respecto al módulo anterior.</p>

      @foreach ($mods as $m)
        <div class="mod-card">
          <div class="mod-top">
            <span class="pill">{{ $m['pill'] }}</span>
            <span class="ingreso">{!! $m['ing'] !!}</span>
            <span class="chip" style="margin-left:6px;"><b>{{ $fmt($m['ret'],1) }}%</b> {{ $m['ref'] }}</span>
          </div>
          <div class="mod-big">
            <span class="n">{{ $fmt($m['n']) }}</span>
            <span class="of">de {{ $fmt($r['registrados']) }} participantes</span>
            <span class="tot">{{ $fmt($pct($m['n'], $r['registrados']),1) }}% del total</span>
          </div>
          <div class="bar" style="margin-top:12px;"><i style="width:{{ $barW($m['n'], $r['registrados']) }}%"></i></div>
        </div>
      @endforeach

      <div class="cyan">
        <div class="crow"><span class="ct">Pérdida acumulada</span><span class="cbig">{{ $fmt($perdida) }} participantes entre M1 y M3</span></div>
        <hr>
        <p>Equivale al {{ $fmt($pct($perdida, $r['m1']),1) }}% de quienes completaron el primer módulo.</p>
      </div>
    </section>

    {{-- ===================== NOTAS / DONUT ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Notas y gráfico de calificaciones</h2>
      <p class="lead">El gráfico se calcula sobre todos los participantes para que los no evaluados no desaparezcan de la lectura.</p>

      <div class="card">
        <div class="card-b">
          <div style="text-align:center; margin-bottom:22px;"><span class="pill pill-sm" style="background:linear-gradient(100deg,#2e7f9d,#1aa6da);">Distribución de la mejor calificación</span></div>
          <div class="donut-wrap">
            <div class="donut"><div class="donut-c"><div class="n">{{ $fmt($r['notaMedia'],1) }}</div><div class="l">nota media</div></div></div>
            <div class="legend">
              <div class="row"><span class="dot" style="background:#2b7f9e"></span><span class="rng">≥9,0</span><span class="cn">{{ $fmt($bk['b9']) }}</span><span class="pc">{{ $fmt($pct($bk['b9'],$reg),1) }}%</span><span>Excelente</span></div>
              <div class="row"><span class="dot" style="background:#17a9dd"></span><span class="rng">8,0-8,9</span><span class="cn">{{ $fmt($bk['b8']) }}</span><span class="pc">{{ $fmt($pct($bk['b8'],$reg),1) }}%</span><span>Apto</span></div>
              <div class="row"><span class="dot" style="background:#7a1420"></span><span class="rng">&lt;8,0</span><span class="cn">{{ $fmt($bk['bl']) }}</span><span class="pc">{{ $fmt($pct($bk['bl'],$reg),1) }}%</span><span>No apto</span></div>
              <div class="row"><span class="dot" style="background:#c2ccd2"></span><span class="rng">No eval.</span><span class="cn">{{ $fmt($bk['ne']) }}</span><span class="pc">{{ $fmt($pct($bk['ne'],$reg),1) }}%</span><span>Sin nota</span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="rtiles">
        <div class="rtile"><div class="n">{{ $fmt($pct($r['intento1'],$r['aptos']),1) }}%</div><div class="l">Aptos al 1.er intento</div><div class="s">{{ $fmt($r['intento1']) }} de {{ $fmt($r['aptos']) }}</div></div>
        <div class="rtile"><div class="n">{{ $fmt($r['intento2']) }}</div><div class="l">Aprueban en 2.º intento</div><div class="s">{{ $fmt($pct($r['intento2'],$r['aptos']),1) }}% de aptos</div></div>
        <div class="rtile"><div class="n">{{ $fmt($r['evaluados']) }}</div><div class="l">Realizan la evaluación</div><div class="s">{{ $fmt($pct($r['evaluados'],$r['registrados']),1) }}% de registrados</div></div>
      </div>

      <div class="cyan">
        <div class="crow"><span class="ct">Criterio académico</span><span class="cbig">Apto con ≥80%</span></div>
        <hr>
        <p>Máximo de dos intentos. La nota media se calcula sobre la mejor nota de cada usuario evaluado, no sobre el total de intentos.</p>
      </div>
    </section>

    {{-- ===================== TOP 5 DIFICULTAD ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Preguntas con menor porcentaje de acierto</h2>
      <p class="lead">Se ordenan de menor a mayor acierto e incluyen código, enunciado abreviado, porcentaje y base de respuestas.</p>

      <div class="card">
        <div class="card-h">Top 5 de dificultad</div>
        <div class="card-b" style="padding-top:8px;">
          <table>
            <tr class="tbl-head"><td>Código</td><td>Enunciado abreviado</td><td class="r c">% acierto</td><td class="r">N.º participantes</td></tr>
            @forelse ($r['dificiles'] as $d)
              <tr class="barrow">
                <td class="lbl">{{ $d['codigo'] }}</td>
                <td>{{ $d['enunciado'] }}</td>
                <td class="c">{{ $fmt($d['acierto']) }}%</td>
                <td class="pc">{{ $fmt($d['n']) }}</td>
              </tr>
              <tr><td colspan="4" class="bar-cell"><div class="bar"><i style="width:{{ min(100,(int)$d['acierto']) }}%"></i></div></td></tr>
            @empty
              <tr><td colspan="4" style="padding:26px 10px; color:#8a99a0; font-size:14px;">Aún no hay respuestas suficientes para calcular la dificultad por pregunta.</td></tr>
            @endforelse
          </table>
        </div>
      </div>

      <div class="cyan">
        <div class="crow"><span class="ct">Interpretación</span><span class="cbig">Menor acierto = mayor dificultad</span></div>
        <hr>
        <p>Estos ítems señalan contenidos que necesitan refuerzo o preguntas que deben revisarse por posible ambigüedad.</p>
      </div>
    </section>

    {{-- ===================== ENCUESTA GLOBAL ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Encuesta de satisfacción global</h2>
      <p class="lead">El listado muestra la media sobre 5, el porcentaje de respuestas positivas (4-5) y el número de respuestas válidas de cada pregunta.</p>

      <div style="text-align:center; margin-bottom:22px;"><span class="pill pill-sm" style="background:linear-gradient(100deg,#2e7f9d,#1aa6da); display:block; border-radius:16px;">Resultado global</span></div>
      <div class="gcards">
        <div class="gcard"><div class="l">Valor global</div><div class="n">{{ $fmt($r['satisfaccion'],1) }} / 5</div></div>
        <div class="gcard"><div class="l">Encuestas válidas</div><div class="n">{{ $fmt($r['encuestas']) }}</div></div>
        <div class="gcard"><div class="l">Tasa de respuesta</div><div class="n">{{ $fmt($r['tasaRespuesta'],1) }}%</div></div>
        <div class="gcard"><div class="l">Dimensión más baja</div><div class="n" style="font-size:19px;">{{ $r['dimMasBaja'] ? $r['dimMasBaja']['nombre'].' · '.$fmt($r['dimMasBaja']['media'],1).' / 5' : '—' }}</div></div>
      </div>

      <div class="card">
        <div class="card-h">Listado completo</div>
        <div class="card-b" style="padding:6px 30px 20px;">
          <table class="ltbl">
            <thead><tr><td>Dimensión</td><td class="c">Media</td><td class="c">4-5</td><td class="c">Usuarios</td></tr></thead>
            <tbody>
              @foreach ($r['dimensiones'] as $d)
                <tr><td class="dim">{{ $d['nombre'] }}</td><td class="v">{{ $fmt($d['media'],1) }}</td><td class="v">{{ $fmt($d['pos']) }}%</td><td class="v">{{ $fmt($d['n']) }}</td></tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <p class="note">Escala: 1 = valoración mínima; 5 = valoración máxima. Positivo = respuestas 4 o 5.</p>
    </section>

    {{-- ===================== PARTICIPACIÓN POR PERFIL ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Participación en la encuesta por perfil profesional</h2>
      <p class="lead">Se informa del peso de cada perfil profesional entre las respuestas y de su tasa de respuesta respecto a los participantes de ese rango.</p>

      <div style="text-align:center; margin-bottom:20px;"><span class="pill pill-sm" style="background:linear-gradient(100deg,#2e7f9d,#1aa6da); display:block; border-radius:16px;">Quién ha respondido</span></div>

      @foreach (['0-7','8-15','16+'] as $pf)
        @php $p = $r['porPerfil'][$pf]; @endphp
        <div class="mod-card">
          <div class="mod-top">
            <span class="pill pill-sm">{{ $pfTit[$pf] }}</span>
            <span class="ingreso" style="margin-left:auto; font-size:17px;">{{ $p['label'] }}</span>
          </div>
          <div class="mod-big" style="align-items:center;">
            <span class="n">{{ $fmt($p['respuestas']) }}</span>
            <span class="of">respuestas de <b>{{ $fmt($p['registrados']) }} participantes</b></span>
            <div class="rtile" style="margin-left:auto; padding:12px 24px;">
              <div class="n" style="font-size:24px;">{{ $fmt($p['media'],1) }}</div>
              <div class="l">Media / 5</div>
              <div class="s">{{ $fmt($p['pos']) }}% positivo</div>
            </div>
          </div>
          <div class="bar" style="margin-top:14px;"><i style="width:{{ $barW($p['respuestas'], $p['registrados']) }}%"></i></div>
          <div style="text-align:right; font-size:13px; color:#8a99a0; margin-top:8px;"><b style="color:#2176a0;">{{ $fmt($p['peso'],1) }}%</b> de todas las encuestas</div>
        </div>
      @endforeach

      <div class="cyan">
        <div class="ct" style="text-align:center;">Participación total</div>
        <hr>
        <div class="crow" style="font-size:14px;">
          <span>{{ $fmt($r['encuestas']) }} encuestas</span>
          <span>{{ $fmt($r['porPerfil']['0-7']['respuestas']) }} en consolidación</span>
          <span>{{ $fmt($r['porPerfil']['8-15']['respuestas']) }} consolidados</span>
          <span>{{ $fmt($r['porPerfil']['16+']['respuestas']) }} expertos</span>
        </div>
      </div>
    </section>

    {{-- ===================== HEATMAP ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Resultados por experiencia profesional</h2>
      <p class="lead">La tabla permite comprobar si una dimensión funciona de forma diferente entre profesionales en consolidación, consolidados y expertos.</p>

      <div class="card">
        <div class="card-h">Media sobre 5 por dimensión</div>
        <div class="card-b" style="padding:6px 30px 20px;">
          <table class="ltbl">
            <thead><tr>
              <td>Dimensión</td>
              <td class="c">0-7 años<br>n={{ $fmt($r['porPerfil']['0-7']['respuestas']) }}</td>
              <td class="c">8-15 años<br>n={{ $fmt($r['porPerfil']['8-15']['respuestas']) }}</td>
              <td class="c">≥16 años<br>n={{ $fmt($r['porPerfil']['16+']['respuestas']) }}</td>
            </tr></thead>
            <tbody>
              @foreach ($r['heatmap'] as $h)
                <tr><td class="dim">{{ $h['nombre'] }}</td><td class="v">{{ $fmt($h['0-7'],1) }}</td><td class="v">{{ $fmt($h['8-15'],1) }}</td><td class="v">{{ $fmt($h['16+'],1) }}</td></tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="cyan">
        <div class="crow"><span class="ct">Lectura</span><span class="cbig">{{ $r['dimMasBaja'] ? $r['dimMasBaja']['nombre'].' es la dimensión más baja' : 'Sin datos de encuesta todavía' }}</span></div>
        <hr>
        <p>Conviene revisar la visibilidad del canal y la utilidad percibida de esa dimensión en los tres perfiles profesionales.</p>
      </div>
    </section>

    {{-- ===================== RESUMEN FINAL ===================== --}}
    <section class="page">
      <div class="ph"><img src="{{ asset('images/logo-lpaction.svg') }}" alt="Lp(a)ction"><span class="tag">DATOS REALES</span></div>
      <h2 class="sec">Resumen ejecutivo</h2>
      <p class="lead">Fortalezas, fricciones y oportunidades del curso, sin repetir todas las cifras del cuerpo del informe.</p>
      @php
        $txtAprend = $r['notaMedia'] !== null
            ? 'es sólido, con nota media de '.$fmt($r['notaMedia'],1).' sobre 10'
            : 'se mostrará cuando haya evaluaciones registradas';
        if (! empty($r['dificiles'])) $txtAprend .= '; la pregunta '.$r['dificiles'][0]['codigo'].' concentra el menor acierto y conviene revisarla';
        $txtExp = $r['satisfaccion'] !== null ? 'La valoración es positiva en todos los perfiles' : 'Aún no hay encuestas registradas';
        if ($r['dimMasBaja']) $txtExp .= '; «'.$r['dimMasBaja']['nombre'].'» es la dimensión más débil';
      @endphp

      <div class="scard">
        <div class="k">Alcance y retención</div>
        <div class="big"><span class="n">{{ $fmt($r['m3']) }}</span><span class="u">participantes completan M3</span></div>
        <p class="txt">La finalización alcanza el {{ $fmt($r['pctCompletan'],1) }}% del total; la mayor oportunidad está en la transición entre módulos.</p>
      </div>
      <div class="scard">
        <div class="k">Aprendizaje</div>
        <div class="big"><span class="n">{{ $fmt($r['pctAptos'],1) }}%</span><span class="u">de aptos</span></div>
        <p class="txt">El resultado académico {{ $txtAprend }}.</p>
      </div>
      <div class="scard">
        <div class="k">Experiencia</div>
        <div class="big"><span class="n">{{ $fmt($r['satisfaccion'],1) }}</span><span class="u">sobre 5</span></div>
        <p class="txt">{{ $txtExp }}.</p>
      </div>
    </section>

  </div>
</body>
</html>
