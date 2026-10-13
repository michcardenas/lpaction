<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Encuestas de satisfacción · Lp(a)ction</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Segoe UI", "Calibri", system-ui, sans-serif; color: #e7eef2; background: #0a1a24;
         background-image: radial-gradient(1200px 500px at 80% -10%, rgba(5,186,238,.14), transparent 60%); min-height: 100vh; }
  a { color: inherit; }
  .topbar { display: flex; align-items: center; justify-content: space-between; gap: 16px;
            padding: 16px 30px; border-bottom: 1px solid rgba(255,255,255,.08); }
  .brand { display: flex; align-items: baseline; gap: 10px; }
  .brand b { font-size: 18px; font-weight: 800; color: #fff; }
  .brand span { font-size: 12px; letter-spacing: .18em; text-transform: uppercase; color: #05BAEE; font-weight: 700; }
  .btn { font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer; text-decoration: none;
         display: inline-flex; align-items: center; gap: 7px; font-size: 14px; background: transparent; color: #b9c8d0; border: 1px solid rgba(255,255,255,.16); }
  .btn:hover { color: #fff; border-color: rgba(255,255,255,.4); }
  .wrap { max-width: 1400px; margin: 0 auto; padding: 24px 30px 60px; }
  h1 { font-size: 22px; color: #fff; margin-bottom: 4px; }
  .lead { font-size: 13.5px; color: #9fb4bf; margin-bottom: 20px; }
  .panel { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  th, td { text-align: left; padding: 11px 12px; border-bottom: 1px solid rgba(255,255,255,.06); vertical-align: top; }
  th { font-size: 11px; letter-spacing: .04em; text-transform: uppercase; color: #7fa7b8; font-weight: 700; background: rgba(255,255,255,.03); white-space: nowrap; }
  th.dim { max-width: 120px; white-space: normal; }
  td.num { text-align: center; font-variant-numeric: tabular-nums; font-weight: 700; }
  .muted { color: #7f97a2; font-size: 12.5px; }
  .obs { max-width: 360px; white-space: normal; color: #cdd9df; line-height: 1.45; }
  .obs.empty { color: #5f7682; font-style: italic; }
  .media { font-size: 16px; font-weight: 800; color: #7fe3ff; text-align: center; }
  .v5 { color: #6ee7a8; } .v4 { color: #7fe3ff; } .v3 { color: #f4d06a; } .v12 { color: #ff8a8a; } .v0 { color: #5f7682; }
  .pill.test { background: rgba(5,186,238,.16); color: #7fe3ff; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px; }
  tr.es-test td { opacity: .5; }
</style>
</head>
<body>
  <div class="topbar">
    <div class="brand"><b>Lp(a)ction</b><span>Encuestas de satisfacción</span></div>
    <a class="btn" href="{{ route('admin') }}">← Volver al panel</a>
  </div>
  <div class="wrap">
    <h1>Encuestas de satisfacción</h1>
    <p class="lead">Puntuación (1-5) por dimensión y comentario de cada alumno que ha completado la encuesta. {{ $rows->count() }} respuesta(s).</p>

    <div class="panel">
      <table>
        <thead>
          <tr>
            <th>Alumno</th>
            <th class="num">Media</th>
            @foreach ($dims as $d)<th class="dim num">{{ $d }}</th>@endforeach
            <th>Observaciones</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          @php
            $cls = fn ($v) => $v >= 5 ? 'v5' : ($v == 4 ? 'v4' : ($v == 3 ? 'v3' : ($v >= 1 ? 'v12' : 'v0')));
          @endphp
          @forelse ($rows as $r)
            <tr class="{{ $r['is_test'] ? 'es-test' : '' }}">
              <td>
                <div>{{ $r['nombre'] }} @if ($r['is_test'])<span class="pill test">TEST</span>@endif</div>
                <div class="muted">{{ $r['email'] }}</div>
              </td>
              <td class="media">{{ $r['media'] !== null ? number_format($r['media'], 1, ',', '.') : '—' }}</td>
              @for ($i = 0; $i < count($dims); $i++)
                @php $v = (int) ($r['valoraciones'][$i] ?? 0); @endphp
                <td class="num {{ $cls($v) }}">{{ $v > 0 ? $v : '—' }}</td>
              @endfor
              <td class="obs {{ $r['observaciones'] === '' ? 'empty' : '' }}">{{ $r['observaciones'] !== '' ? $r['observaciones'] : 'Sin comentario' }}</td>
              <td class="muted">{{ $r['completada'] ? $r['completada']->format('d/m/Y') : '—' }}</td>
            </tr>
          @empty
            <tr><td colspan="{{ count($dims) + 4 }}" class="muted" style="padding:26px; text-align:center;">Aún no hay encuestas completadas.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
