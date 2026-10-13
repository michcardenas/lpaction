<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Preguntas y acierto · Lp(a)ction</title>
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
  .btn { font: inherit; border-radius: 8px; padding: 9px 16px; text-decoration: none; font-size: 14px;
         background: transparent; color: #b9c8d0; border: 1px solid rgba(255,255,255,.16); }
  .btn:hover { color: #fff; border-color: rgba(255,255,255,.4); }
  .wrap { max-width: 1100px; margin: 0 auto; padding: 24px 30px 60px; }
  h1 { font-size: 22px; color: #fff; margin-bottom: 4px; }
  .lead { font-size: 13.5px; color: #9fb4bf; margin-bottom: 20px; }
  .panel { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  th, td { text-align: left; padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,.06); vertical-align: middle; }
  th { font-size: 11.5px; letter-spacing: .05em; text-transform: uppercase; color: #7fa7b8; font-weight: 700; background: rgba(255,255,255,.03); }
  td.c, th.c { text-align: center; white-space: nowrap; }
  .code { font-weight: 700; color: #7fe3ff; white-space: nowrap; }
  .bar-wrap { display: flex; align-items: center; gap: 10px; }
  .bar { flex: 1; height: 9px; min-width: 90px; border-radius: 6px; background: rgba(255,255,255,.10); overflow: hidden; }
  .bar i { display: block; height: 100%; border-radius: 6px; background: linear-gradient(90deg,#2b6f90,#39d3ff); }
  .pcnum { width: 46px; text-align: right; font-variant-numeric: tabular-nums; font-weight: 700; }
  .muted { color: #7f97a2; }
</style>
</head>
<body>
  <div class="topbar">
    <div class="brand"><b>Lp(a)ction</b><span>Preguntas y % de acierto</span></div>
    <a class="btn" href="{{ route('admin') }}">← Volver al panel</a>
  </div>
  <div class="wrap">
    <h1>Todas las preguntas y su acierto</h1>
    <p class="lead">% de acierto y número de respuestas de cada pregunta de los ingresos, ordenadas de menor a mayor acierto. ({{ count($preguntas) }} preguntas)</p>

    <div class="panel">
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Enunciado</th>
            <th class="c">% acierto</th>
            <th class="c">Respuestas</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($preguntas as $p)
            <tr>
              <td class="code">{{ $p['codigo'] }}</td>
              <td>{{ $p['enunciado'] }}</td>
              <td class="c">
                @if ($p['acierto'] !== null)
                  <div class="bar-wrap">
                    <div class="bar"><i style="width: {{ $p['acierto'] }}%"></i></div>
                    <span class="pcnum">{{ $p['acierto'] }}%</span>
                  </div>
                @else
                  <span class="muted">— sin respuestas</span>
                @endif
              </td>
              <td class="c">{{ $p['n'] }}</td>
            </tr>
          @empty
            <tr><td colspan="4" class="c muted" style="padding:26px;">No hay preguntas registradas.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
