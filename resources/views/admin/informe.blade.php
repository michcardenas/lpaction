<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Informe final · Resultados del curso · Lp(a)ction</title>
@php
  $fmt = fn ($v, $dec = 0, $def = '—') => is_null($v) ? $def : number_format($v, $dec, ',', '.');
  $pctBucket = fn ($n, $base) => $base > 0 ? round($n / $base * 100, 1) : 0;
@endphp
<style>
  @page { size: A4 portrait; margin: 14mm 15mm; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Segoe UI", "Calibri", system-ui, sans-serif; color: #17272e; background: #e9edf0; }

  .toolbar { position: sticky; top: 0; z-index: 50; display: flex; gap: 12px; align-items: center; justify-content: center;
             padding: 12px; background: #0d2430; color: #fff; font-size: 14px; }
  .toolbar button, .toolbar a { font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer;
             text-decoration: none; display: inline-flex; align-items: center; gap: 7px; }
  .btn-pdf { background: #05BAEE; color: #06232b; font-weight: 700; }
  .btn-pdf:hover { background: #22d3ee; }
  .btn-volver { background: transparent; color: #cbd5e1; border: 1px solid #3a5563; }

  .doc { max-width: 820px; margin: 20px auto; }
  .page { background: #fff; box-shadow: 0 6px 24px rgba(0,0,0,.12); padding: 40px 46px; margin-bottom: 22px; }

  .kicker { font-size: 11.5px; letter-spacing: .16em; text-transform: uppercase; color: #05BAEE; font-weight: 700; }
  h2 { font-size: 22px; color: #0d2430; margin: 3px 0 6px; }
  .lead { font-size: 13.5px; color: #5d6d75; line-height: 1.5; max-width: 620px; }
  .sec-h { border-bottom: 2px solid #eaeef1; padding-bottom: 14px; margin-bottom: 20px; }

  /* Portada */
  .cover { min-height: 240px; display: flex; flex-direction: column; justify-content: center;
           background: linear-gradient(135deg, #0d2430, #0a3a4a); color: #fff; }
  .cover .kicker { color: #7fe3ff; }
  .cover h1 { font-size: 40px; line-height: 1.05; margin: 10px 0 6px; font-weight: 800; }
  .cover p { color: #b9d4de; font-size: 14px; }
  .badge-real { display: inline-block; margin-top: 16px; font-size: 11.5px; font-weight: 700; letter-spacing: .08em;
                background: rgba(5,186,238,.2); color: #7fe3ff; padding: 5px 12px; border-radius: 999px; }

  /* KPIs */
  .kpis { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .kpi { border: 1px solid #e7edf0; border-radius: 12px; padding: 16px 18px; }
  .kpi .n { font-size: 30px; font-weight: 800; color: #0d2430; line-height: 1; }
  .kpi .l { font-size: 12.5px; color: #56666e; margin-top: 6px; }
  .kpi .s { font-size: 11.5px; color: #8a99a0; margin-top: 3px; }
  .kpi.hl { background: #f2fbfe; border-color: #bfeafb; }
  .kpi.hl .n { color: #0784a8; }

  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  th, td { text-align: left; padding: 9px 12px; border-bottom: 1px solid #eef1f3; }
  th { font-size: 11px; letter-spacing: .05em; text-transform: uppercase; color: #7a8891; font-weight: 700; }
  td.num, th.num { text-align: right; font-variant-numeric: tabular-nums; }
  .bar-row { position: relative; }
  .bar-bg { height: 7px; background: #eef2f4; border-radius: 5px; margin-top: 6px; overflow: hidden; }
  .bar-bg i { display: block; height: 100%; background: linear-gradient(90deg,#05BAEE,#39d3ff); border-radius: 5px; }

  .callout { margin-top: 18px; background: #f6f9fb; border-left: 3px solid #05BAEE; padding: 12px 16px;
             font-size: 12.5px; color: #46565e; border-radius: 0 8px 8px 0; }
  .callout b { color: #0d2430; }
  ul.read { margin: 6px 0 0 2px; list-style: none; font-size: 13px; color: #46565e; }
  ul.read li { padding: 4px 0 4px 18px; position: relative; }
  ul.read li::before { content: "•"; color: #05BAEE; position: absolute; left: 2px; font-weight: 700; }

  .heat td.v { text-align: center; font-variant-numeric: tabular-nums; font-weight: 600; }
  .foot { margin-top: 22px; padding-top: 10px; border-top: 1px solid #eef1f3; font-size: 10.5px; color: #9aa8af; text-align: center; }

  @media print {
    body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .toolbar { display: none !important; }
    .doc { max-width: none; margin: 0; }
    .page { box-shadow: none; padding: 0 0 8mm; margin: 0; page-break-after: always; }
    .page:last-child { page-break-after: auto; }
  }
</style>
</head>
<body>
  <div class="toolbar">
    <span>Informe final · datos reales</span>
    <button class="btn-pdf" onclick="window.print()">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0l-4-4m4 4l4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
      Descargar PDF
    </button>
    <a class="btn-volver" href="{{ route('admin') }}">Volver al panel</a>
  </div>

  <div class="doc">

    {{-- 1 · Portada --}}
    <section class="page cover">
      <div class="kicker">Informe final</div>
      <h1>Resultados<br>del curso</h1>
      <p>Programa formativo Lp(a)ction · La evolución de Juan</p>
      <span class="badge-real">DATOS REALES · Generado el {{ $r['generado']->format('d/m/Y') }}</span>
    </section>

    {{-- 2 · Visión ejecutiva --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Resumen</div>
        <h2>Visión ejecutiva del curso</h2>
        <p class="lead">Indicadores principales de alcance, finalización, resultado académico, acreditación y experiencia del participante.</p>
      </div>
      <div class="kpis">
        <div class="kpi"><div class="n">{{ $fmt($r['registrados']) }}</div><div class="l">Participantes registrados</div><div class="s">{{ $r['plazas'] ? 'Sobre '.$fmt($r['plazas']).' plazas' : '' }}</div></div>
        <div class="kpi"><div class="n">{{ $fmt($r['m3']) }}</div><div class="l">Completan los 3 módulos</div><div class="s">{{ $r['pctCompletan'] }}% del total</div></div>
        <div class="kpi hl"><div class="n">{{ $fmt($r['notaMedia'],1) }} / 10</div><div class="l">Nota media final</div><div class="s">Entre evaluados</div></div>
        <div class="kpi"><div class="n">{{ $r['pctAptos'] }}%</div><div class="l">Aptos / evaluados</div><div class="s">{{ $r['aptos'] }} de {{ $r['evaluados'] }}</div></div>
        <div class="kpi"><div class="n">{{ $fmt($r['diplomas']) }}</div><div class="l">Diplomas emitidos</div><div class="s">{{ $r['aptos'] ? round($r['diplomas']/$r['aptos']*100,1).'% de aptos' : '—' }}</div></div>
        <div class="kpi hl"><div class="n">{{ $fmt($r['satisfaccion'],1) }} / 5</div><div class="l">Satisfacción global</div><div class="s">n = {{ $r['encuestas'] }}</div></div>
      </div>
      <div class="callout">
        <b>Lectura recomendada</b>
        <ul class="read">
          <li>Alcance: {{ $r['registrados'] }} registros y una activación del {{ $r['pctActivacion'] }}%.</li>
          <li>Retención: {{ $r['m3'] }} personas completan el tercer módulo, el {{ $r['pctCompletan'] }}% de los participantes.</li>
          <li>Aprendizaje: {{ $r['pctAptos'] }}% de aptos y nota media final de {{ $fmt($r['notaMedia'],1) }} sobre 10.</li>
        </ul>
      </div>
    </section>

    {{-- 3 · Embudo --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Actividad y participación</div>
        <h2>Embudo del curso</h2>
        <p class="lead">Avance de los participantes desde el registro hasta resultar aptos.</p>
      </div>
      <table>
        <thead><tr><th>Etapa</th><th class="num">n</th><th class="num">Total</th><th class="num">% del total</th></tr></thead>
        <tbody>
          @foreach ($r['funnel'] as $f)
            <tr>
              <td>{{ $f['etapa'] }}</td>
              <td class="num">{{ $fmt($f['n']) }}</td>
              <td class="num">{{ $fmt($r['registrados']) }}</td>
              <td class="num">{{ $pctBucket($f['n'], $r['registrados']) }}%
                <div class="bar-bg"><i style="width: {{ $pctBucket($f['n'], $r['registrados']) }}%"></i></div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>

    {{-- 4 · Retención por módulo --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Retención</div>
        <h2>Cuántas personas realizan cada módulo</h2>
        <p class="lead">Cifra sobre el total de participantes y retención respecto al módulo anterior.</p>
      </div>
      @php
        $mods = [
          ['Módulo 1', 'Primer ingreso', $r['m1'], $r['inician']],
          ['Módulo 2', 'Segundo ingreso', $r['m2'], $r['m1']],
          ['Módulo 3', 'Tercer ingreso', $r['m3'], $r['m2']],
        ];
      @endphp
      <div class="kpis">
        @foreach ($mods as [$mod, $ing, $n, $prev])
          <div class="kpi">
            <div class="s" style="margin:0 0 4px; text-transform:uppercase; letter-spacing:.08em; color:#05BAEE; font-weight:700;">{{ $mod }} · {{ $ing }}</div>
            <div class="n">{{ $fmt($n) }}</div>
            <div class="l">de {{ $r['registrados'] }} participantes · {{ $pctBucket($n, $r['registrados']) }}% del total</div>
            <div class="s">{{ $prev > 0 ? $pctBucket($n, $prev).'% de quienes hicieron el módulo anterior' : '—' }}</div>
          </div>
        @endforeach
      </div>
      <div class="callout">
        <b>Pérdida acumulada:</b> {{ max(0, $r['m1'] - $r['m3']) }} personas entre el Módulo 1 y el Módulo 3
        @if($r['m1'] > 0) (el {{ $pctBucket(max(0,$r['m1']-$r['m3']), $r['m1']) }}% de quienes completaron el primer módulo).@endif
      </div>
    </section>

    {{-- 5 · Notas y distribución --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Resultado académico</div>
        <h2>Notas y distribución de calificaciones</h2>
        <p class="lead">Distribución de la mejor calificación de cada usuario. Los no evaluados se mantienen visibles.</p>
      </div>
      @php $b = $r['buckets']; $tot = $r['registrados']; @endphp
      <table>
        <thead><tr><th>Rango</th><th class="num">n</th><th class="num">% del total</th><th></th></tr></thead>
        <tbody>
          @foreach ([['≥ 9,0', $b['b9']], ['8,0 – 8,9', $b['b8']], ['< 8,0', $b['bl']], ['No evaluado', $b['ne']]] as [$lbl, $n])
            <tr><td>{{ $lbl }}</td><td class="num">{{ $fmt($n) }}</td>
              <td class="num">{{ $pctBucket($n, $tot) }}%</td>
              <td style="width:35%"><div class="bar-bg"><i style="width: {{ $pctBucket($n, $tot) }}%"></i></div></td></tr>
          @endforeach
        </tbody>
      </table>
      <div class="kpis" style="margin-top:20px; grid-template-columns: repeat(3,1fr);">
        <div class="kpi hl"><div class="n">{{ $fmt($r['notaMedia'],1) }}</div><div class="l">Nota media (sobre 10)</div></div>
        <div class="kpi"><div class="n">{{ $r['intento1'] }}</div><div class="l">Aptos al 1.er intento</div><div class="s">de {{ $r['aptos'] }} aptos</div></div>
        <div class="kpi"><div class="n">{{ $r['intento2'] }}</div><div class="l">Aptos usando 2.º intento</div></div>
      </div>
      <div class="callout"><b>Criterio académico:</b> máximo de dos intentos. La nota media se calcula sobre la mejor nota de cada usuario evaluado.</div>
    </section>

    {{-- 6 · Preguntas más difíciles --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Dificultad</div>
        <h2>Preguntas con menor porcentaje de acierto</h2>
        <p class="lead">Preguntas de los casos ordenadas de menor a mayor acierto (respuesta perfecta). Base = usuarios que las respondieron.</p>
      </div>
      <table>
        <thead><tr><th>Código</th><th>Enunciado</th><th class="num">% acierto</th><th class="num">n</th></tr></thead>
        <tbody>
          @forelse ($r['dificiles'] as $d)
            <tr><td style="white-space:nowrap; font-weight:600;">{{ $d['codigo'] }}</td>
              <td>{{ $d['enunciado'] }}</td>
              <td class="num">{{ $d['acierto'] }}%</td>
              <td class="num">{{ $d['n'] }}</td></tr>
          @empty
            <tr><td colspan="4" style="color:#9aa8af; padding:18px 12px;">Aún no hay respuestas suficientes para calcular la dificultad.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="callout"><b>Interpretación:</b> menor acierto = mayor dificultad. Señala contenidos que necesitan refuerzo o preguntas a revisar por posible ambigüedad.</div>
    </section>

    {{-- 7 · Encuesta global --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Experiencia</div>
        <h2>Encuesta de satisfacción global</h2>
        <p class="lead">Media sobre 5, porcentaje de respuestas positivas (4–5) y número de respuestas válidas por dimensión.</p>
      </div>
      <div class="kpis" style="margin-bottom:20px;">
        <div class="kpi hl"><div class="n">{{ $fmt($r['satisfaccion'],1) }} / 5</div><div class="l">Valor global</div></div>
        <div class="kpi"><div class="n">{{ $r['encuestas'] }}</div><div class="l">Encuestas válidas</div><div class="s">{{ $r['tasaRespuesta'] }}% de los registrados</div></div>
        <div class="kpi"><div class="n">{{ $r['dimMasBaja'] ? $fmt($r['dimMasBaja']['media'],1).' / 5' : '—' }}</div><div class="l">Dimensión más baja</div><div class="s">{{ $r['dimMasBaja']['nombre'] ?? '—' }}</div></div>
      </div>
      <table>
        <thead><tr><th>Dimensión</th><th class="num">Media</th><th class="num">4–5</th><th class="num">n</th></tr></thead>
        <tbody>
          @foreach ($r['dimensiones'] as $d)
            <tr><td>{{ $d['nombre'] }}</td>
              <td class="num">{{ $fmt($d['media'],1) }}</td>
              <td class="num">{{ $d['media'] !== null ? $d['pos'].'%' : '—' }}</td>
              <td class="num">{{ $d['n'] }}</td></tr>
          @endforeach
        </tbody>
      </table>
      <div class="foot">Escala: 1 = valoración mínima; 5 = valoración máxima. Positivo = respuestas 4 o 5.</div>
    </section>

    {{-- 8 · Participación por perfil --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Experiencia</div>
        <h2>Participación en la encuesta por perfil</h2>
        <p class="lead">Peso de cada perfil profesional entre las respuestas y su valoración media.</p>
      </div>
      <div class="kpis">
        @foreach (['0-7', '8-15', '16+'] as $pf)
          @php $p = $r['porPerfil'][$pf]; @endphp
          <div class="kpi">
            <div class="s" style="margin:0 0 4px; text-transform:uppercase; letter-spacing:.08em; color:#05BAEE; font-weight:700;">{{ $pf }} años · {{ $p['label'] }}</div>
            <div class="n">{{ $p['respuestas'] }}</div>
            <div class="l">respuestas de {{ $p['registrados'] }} participantes</div>
            <div class="s">Media {{ $fmt($p['media'],1) }} / 5 · {{ $p['pos'] }}% positivo · {{ $p['peso'] }}% de las encuestas</div>
          </div>
        @endforeach
      </div>
      <div class="callout"><b>Participación total:</b> {{ $r['encuestas'] }} encuestas · {{ $r['porPerfil']['0-7']['respuestas'] }} en consolidación · {{ $r['porPerfil']['8-15']['respuestas'] }} consolidados · {{ $r['porPerfil']['16+']['respuestas'] }} expertos.</div>
    </section>

    {{-- 9 · Heatmap por experiencia --}}
    <section class="page">
      <div class="sec-h">
        <div class="kicker">Experiencia</div>
        <h2>Resultados por experiencia profesional</h2>
        <p class="lead">Media sobre 5 por dimensión según el nivel de experiencia del profesional.</p>
      </div>
      @php
        $heatColor = function ($v) {
          if ($v === null) return 'background:#f3f5f6;color:#b3bec4';
          // 4.0 (rojo suave) → 5.0 (verde)
          $t = max(0, min(1, ($v - 4.0) / 1.0));
          $r1 = round(253 + (214 - 253) * $t); $g1 = round(232 + (240 - 232) * $t); $b1 = round(200 + (216 - 200) * $t);
          return "background:rgb($r1,$g1,$b1);color:#1e3a2b";
        };
      @endphp
      <table class="heat">
        <thead><tr><th>Dimensión</th><th class="num">0–7 años</th><th class="num">8–15 años</th><th class="num">≥16 años</th></tr></thead>
        <tbody>
          @foreach ($r['heatmap'] as $h)
            <tr>
              <td>{{ $h['nombre'] }}</td>
              <td class="v" style="{{ $heatColor($h['0-7']) }}">{{ $fmt($h['0-7'],1) }}</td>
              <td class="v" style="{{ $heatColor($h['8-15']) }}">{{ $fmt($h['8-15'],1) }}</td>
              <td class="v" style="{{ $heatColor($h['16+']) }}">{{ $fmt($h['16+'],1) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      @if($r['dimMasBaja'])
      <div class="callout"><b>Lectura:</b> «{{ $r['dimMasBaja']['nombre'] }}» es la dimensión con menor valoración media. Conviene revisar su visibilidad y utilidad percibida.</div>
      @endif
      <div class="foot">Informe generado automáticamente por la plataforma Lp(a)ction el {{ $r['generado']->format('d/m/Y H:i') }} · Qualimed Ediciones S.L.</div>
    </section>

  </div>
</body>
</html>
