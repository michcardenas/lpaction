<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resumen del caso · {{ $resumen['ingreso']['label'] ?? 'Ingreso' }} · Lp(a)ction</title>
<style>
  @page { size: A4 portrait; margin: 14mm 14mm 16mm; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Segoe UI", "Calibri", system-ui, sans-serif; color: #1f2a30; background: #eef1f3; }

  /* Barra de acciones (no se imprime) */
  .toolbar {
    position: sticky; top: 0; z-index: 50;
    display: flex; gap: 12px; align-items: center; justify-content: center;
    padding: 12px; background: #0d2430; color: #fff; font-size: 14px;
  }
  .toolbar button, .toolbar a {
    font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer;
    text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
  }
  .btn-pdf { background: #05BAEE; color: #06232b; font-weight: 700; }
  .btn-pdf:hover { background: #22d3ee; }
  .btn-volver { background: transparent; color: #cbd5e1; border: 1px solid #3a5563; }
  .btn-volver:hover { color: #fff; }

  .sheet {
    max-width: 800px; margin: 22px auto; background: #fff; padding: 34px 40px 42px;
    box-shadow: 0 8px 30px rgba(0,0,0,.14);
  }

  /* Cabecera */
  .head { border-bottom: 3px solid #05BAEE; padding-bottom: 16px; margin-bottom: 8px; }
  .kicker { font-size: 12px; letter-spacing: .14em; text-transform: uppercase; color: #05BAEE; font-weight: 700; }
  .h-title { font-size: 24px; font-weight: 800; margin: 4px 0 2px; color: #0d2430; }
  .h-sub { font-size: 14px; color: #5b6b73; line-height: 1.5; }
  .meta { display: flex; flex-wrap: wrap; gap: 8px 22px; margin-top: 12px; font-size: 13px; color: #384850; }
  .meta b { color: #0d2430; }

  /* Tarjeta de puntuación */
  .score { display: flex; align-items: center; gap: 16px; margin: 18px 0 6px;
           background: #f5f9fb; border: 1px solid #e1e9ee; border-radius: 10px; padding: 14px 18px; }
  .medal { width: 46px; height: 46px; border-radius: 50%; display: grid; place-items: center; flex: none;
           color: #fff; font-weight: 800; font-size: 12px; }
  .score-txt { font-size: 14px; color: #384850; }
  .score-txt .big { font-size: 20px; font-weight: 800; color: #0d2430; }

  /* Preguntas */
  .q { margin-top: 22px; page-break-inside: avoid; }
  .q-etapa { font-size: 11px; letter-spacing: .1em; text-transform: uppercase; color: #8a99a0; font-weight: 700; }
  .q-enun { font-size: 15px; font-weight: 700; margin: 3px 0 10px; color: #16232a; line-height: 1.4; }
  .opt { display: flex; gap: 10px; align-items: flex-start; padding: 8px 12px; border-radius: 8px;
         font-size: 13.5px; line-height: 1.45; border: 1px solid #eceff1; margin-bottom: 6px; }
  .opt .ic { flex: none; width: 18px; height: 18px; margin-top: 1px; }
  .opt.ok   { background: #eafaf1; border-color: #b7e6c8; }
  .opt.ok .txt { color: #14663a; }
  .opt.bad  { background: #fdecea; border-color: #f4b6ac; }
  .opt.bad .txt { color: #8a2318; }
  .opt .txt { color: #33444c; }
  .tag { font-size: 10.5px; font-weight: 700; padding: 1px 7px; border-radius: 999px; margin-left: 6px;
         vertical-align: middle; white-space: nowrap; }
  .tag.correct { background: #16a34a; color: #fff; }
  .tag.yours   { background: #05BAEE; color: #06232b; }

  .foot { margin-top: 26px; padding-top: 12px; border-top: 1px solid #e6ebee; font-size: 11px; color: #93a1a8; text-align: center; }

  @media print {
    body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .toolbar { display: none !important; }
    .sheet { box-shadow: none; margin: 0; max-width: none; padding: 0; }
  }
</style>
</head>
<body>
  <div class="toolbar">
    <span>Resumen del caso — {{ $resumen['ingreso']['label'] ?? '' }}</span>
    <button class="btn-pdf" onclick="window.print()">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0l-4-4m4 4l4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
      Descargar PDF
    </button>
    <a class="btn-volver" href="{{ route('curso.etapa', [$ingreso, 'resumen']) }}">Volver al caso</a>
  </div>

  <div class="sheet">
    <div class="head">
      <div class="kicker">Programa formativo Lp(a)ction · Resumen del caso</div>
      <h1 class="h-title">{{ $resumen['ingreso']['label'] ?? 'Ingreso' }}</h1>
      <p class="h-sub">{{ $resumen['ingreso']['titulo'] ?? '' }}</p>
      <div class="meta">
        <span>Paciente: <b>{{ $resumen['paciente']['nombre'] ?? 'Juan' }}</b></span>
        @if(!empty($resumen['alumno']))<span>Alumno/a: <b>{{ $resumen['alumno'] }}</b></span>@endif
        <span>Estado: <b>{{ $resumen['completado'] ? 'Ingreso completado' : 'En curso' }}</b></span>
      </div>
    </div>

    <div class="score">
      <div class="medal" style="background: {{ $resumen['medalla']['color'] ?? '#9aa0a6' }};">
        {{ mb_strtoupper(mb_substr($resumen['medalla']['label'] ?? 'S', 0, 1)) }}
      </div>
      <div class="score-txt">
        <div><span class="big">{{ $resumen['score'] }}</span> / {{ $resumen['maxScore'] }} puntos
          &nbsp;·&nbsp; {{ $resumen['medalla']['label'] ?? 'Sin medalla' }}</div>
        <div style="color:#6b7b82; margin-top:2px;">Aciertos +{{ $resumen['verde'] }} · Penalizaciones −{{ $resumen['rojo'] }}</div>
      </div>
    </div>

    @foreach ($resumen['preguntas'] as $q)
      <div class="q">
        <div class="q-etapa">{{ $q['etapa'] }}</div>
        <div class="q-enun">{{ $q['enunciado'] }}</div>
        @foreach ($q['opciones'] as $op)
          @php
            // Verde si es correcta; rojo solo si el alumno la eligió y era incorrecta.
            $cls = $op['correcta'] ? 'ok' : ($op['elegida'] ? 'bad' : '');
          @endphp
          <div class="opt {{ $cls }}">
            @if ($op['correcta'])
              <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            @elseif ($op['elegida'])
              <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            @else
              <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="#c3ccd1" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="8"/></svg>
            @endif
            <span class="txt">{{ $op['texto'] }}@if($op['correcta'])<span class="tag correct">Correcta</span>@endif @if($op['elegida'])<span class="tag yours">Tu respuesta</span>@endif</span>
          </div>
        @endforeach
      </div>
    @endforeach

    <div class="foot">Documento de estudio generado por la plataforma Lp(a)ction · Qualimed Ediciones S.L.</div>
  </div>
</body>
</html>
