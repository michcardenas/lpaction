<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de administración · Lp(a)ction</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Segoe UI", "Calibri", system-ui, sans-serif; color: #e7eef2; background: #0a1a24;
         background-image: radial-gradient(1200px 500px at 80% -10%, rgba(5,186,238,.14), transparent 60%); min-height: 100vh; }
  a { color: inherit; }

  .topbar { display: flex; align-items: center; justify-content: space-between; gap: 16px;
            padding: 16px 30px; border-bottom: 1px solid rgba(255,255,255,.08); }
  .brand { display: flex; align-items: baseline; gap: 10px; }
  .brand b { font-size: 18px; font-weight: 800; color: #fff; letter-spacing: .01em; }
  .brand span { font-size: 12px; letter-spacing: .18em; text-transform: uppercase; color: #05BAEE; font-weight: 700; }
  .topbar-actions { display: flex; align-items: center; gap: 10px; }
  .btn { font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer; text-decoration: none;
         display: inline-flex; align-items: center; gap: 7px; font-size: 14px; }
  .btn-ghost { background: transparent; color: #b9c8d0; border: 1px solid rgba(255,255,255,.16); }
  .btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,.4); }
  .btn-cyan { background: #05BAEE; color: #06232b; font-weight: 700; }
  .btn-cyan:hover { background: #22d3ee; }

  .wrap { max-width: 1180px; margin: 0 auto; padding: 28px 30px 60px; }
  .h-sec { font-size: 13px; letter-spacing: .12em; text-transform: uppercase; color: #7fa7b8; font-weight: 700;
           margin: 30px 4px 14px; }

  /* Tarjetas KPI */
  .cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
  .card { background: rgba(255,255,255,.045); border: 1px solid rgba(255,255,255,.09); border-radius: 14px;
          padding: 20px 22px; position: relative; overflow: hidden; }
  .card .lbl { font-size: 13px; color: #9fb4bf; margin-bottom: 8px; }
  .card .num { font-size: 38px; font-weight: 800; color: #fff; line-height: 1; }
  .card .sub { font-size: 12.5px; color: #7f97a2; margin-top: 8px; }
  .card.cyan { border-color: rgba(5,186,238,.35); background: rgba(5,186,238,.10); }
  .card.cyan .num { color: #7fe3ff; }

  /* Avance por ingreso */
  .ing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
  .ing { background: rgba(255,255,255,.045); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; padding: 20px 22px; }
  .ing .t { display: flex; align-items: baseline; justify-content: space-between; }
  .ing .t b { font-size: 15px; color: #fff; }
  .ing .t .pc { font-size: 22px; font-weight: 800; color: #7fe3ff; }
  .bar { height: 9px; border-radius: 6px; background: rgba(255,255,255,.10); margin: 14px 0 10px; overflow: hidden; }
  .bar i { display: block; height: 100%; border-radius: 6px; background: linear-gradient(90deg,#05BAEE,#39d3ff); }
  .ing .legend { display: flex; gap: 16px; font-size: 12.5px; color: #9fb4bf; }
  .ing .legend .dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 6px; vertical-align: middle; }

  /* Tabla */
  .panel { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; overflow: hidden; }
  table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  th, td { text-align: left; padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,.06); }
  th { font-size: 11.5px; letter-spacing: .06em; text-transform: uppercase; color: #7fa7b8; font-weight: 700; background: rgba(255,255,255,.03); }
  tbody tr:hover { background: rgba(255,255,255,.03); }
  td .muted { color: #7f97a2; font-size: 12.5px; }
  .pill { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 999px; white-space: nowrap; }
  .pill.ok { background: rgba(22,163,74,.18); color: #6ee7a8; }
  .pill.prog { background: rgba(234,179,8,.16); color: #f4d06a; }
  .pill.none { background: rgba(255,255,255,.06); color: #8b9aa3; }
  .center { text-align: center; }

  @media (max-width: 900px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .ing-grid { grid-template-columns: 1fr; }
    .scroll-x { overflow-x: auto; }
  }
</style>
</head>
<body>
  <div class="topbar">
    <div class="brand"><b>Lp(a)ction</b><span>Panel de administración</span></div>
    <div class="topbar-actions">
      <a class="btn btn-cyan" href="{{ route('admin.informe.dinamico') }}" target="_blank" rel="noopener">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8M16 17H8M10 9H8"/></svg>
        Informe de resultados
      </a>
      @if ($informeDisponible)
        <a class="btn btn-ghost" href="{{ route('admin.informe') }}" title="Maqueta con datos simulados">Maqueta</a>
      @endif
      <a class="btn btn-ghost" href="{{ route('curso') }}">Ver curso</a>
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="btn btn-ghost" type="submit">Cerrar sesión</button>
      </form>
    </div>
  </div>

  <div class="wrap">

    {{-- KPIs principales --}}
    <div class="cards">
      <div class="card">
        <div class="lbl">Alumnos registrados</div>
        <div class="num">{{ $totalAlumnos }}</div>
        <div class="sub">+{{ $nuevos7d }} en los últimos 7 días</div>
      </div>
      <div class="card cyan">
        <div class="lbl">Curso completado</div>
        <div class="num">{{ $cursoCompleto }}</div>
        <div class="sub">han aprobado la evaluación final</div>
      </div>
      <div class="card">
        <div class="lbl">Evaluación · APTO</div>
        <div class="num">{{ $aptos }}</div>
        <div class="sub">nota media {{ $mediaNota !== null ? $mediaNota.' / 10' : '—' }}</div>
      </div>
      <div class="card">
        <div class="lbl">Encuestas respondidas</div>
        <div class="num">{{ $stats['encuesta']['completados'] }}</div>
        <div class="sub">de satisfacción</div>
      </div>
    </div>

    {{-- Avance por ingreso --}}
    <div class="h-sec">Avance por ingreso</div>
    <div class="ing-grid">
      @foreach (['ingreso-1' => 'Ingreso 1', 'ingreso-2' => 'Ingreso 2', 'ingreso-3' => 'Ingreso 3'] as $key => $lbl)
        <div class="ing">
          <div class="t"><b>{{ $lbl }}</b><span class="pc">{{ $stats[$key]['pct'] }}%</span></div>
          <div class="bar"><i style="width: {{ $stats[$key]['pct'] }}%"></i></div>
          <div class="legend">
            <span><span class="dot" style="background:#39d3ff"></span>{{ $stats[$key]['completados'] }} completados</span>
            <span><span class="dot" style="background:#f4d06a"></span>{{ $stats[$key]['en_curso'] }} en curso</span>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Tabla de alumnos --}}
    <div class="h-sec">Alumnos ({{ $totalAlumnos }})</div>
    <div class="panel scroll-x">
      <table>
        <thead>
          <tr>
            <th>Alumno</th>
            <th class="center">Ingreso 1</th>
            <th class="center">Ingreso 2</th>
            <th class="center">Ingreso 3</th>
            <th class="center">Evaluación</th>
            <th>Registro</th>
          </tr>
        </thead>
        <tbody>
          @php
            $pill = function ($st) {
              return match ($st) {
                'completed'   => '<span class="pill ok">✓ Completado</span>',
                'in_progress' => '<span class="pill prog">En curso</span>',
                default       => '<span class="pill none">—</span>',
              };
            };
          @endphp
          @forelse ($alumnos as $a)
            <tr>
              <td>
                <div>{{ $a['nombre'] }}</div>
                <div class="muted">{{ $a['email'] }}</div>
              </td>
              <td class="center">{!! $pill($a['i1']) !!}</td>
              <td class="center">{!! $pill($a['i2']) !!}</td>
              <td class="center">{!! $pill($a['i3']) !!}</td>
              <td class="center">
                @if ($a['apto'])
                  <span class="pill ok">APTO{{ $a['nota'] !== null ? ' · '.$a['nota'].'/10' : '' }}</span>
                @elseif ($a['nota'] !== null)
                  <span class="pill prog">No apto · {{ $a['nota'] }}/10</span>
                @else
                  <span class="pill none">—</span>
                @endif
              </td>
              <td class="muted">{{ optional($a['registro'])->format('d/m/Y') ?? '—' }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="center muted" style="padding:26px;">Aún no hay alumnos registrados.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>
