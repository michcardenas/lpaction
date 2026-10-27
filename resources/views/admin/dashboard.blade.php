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
  .panel.scroll-x { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; }
  th, td { text-align: left; padding: 11px 13px; border-bottom: 1px solid rgba(255,255,255,.06); }
  th { font-size: 11.5px; letter-spacing: .06em; text-transform: uppercase; color: #7fa7b8; font-weight: 700; background: rgba(255,255,255,.03); }
  tbody tr:hover { background: rgba(255,255,255,.03); }
  td .muted { color: #7f97a2; font-size: 12.5px; }
  .pill { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 999px; white-space: nowrap; }
  .pill.ok { background: rgba(22,163,74,.18); color: #6ee7a8; }
  .pill.prog { background: rgba(234,179,8,.16); color: #f4d06a; }
  .pill.none { background: rgba(255,255,255,.06); color: #8b9aa3; }
  .pill.no { background: rgba(220,38,38,.18); color: #ff8a8a; }
  .center { text-align: center; }

  /* Alumnos de PRUEBA: checkbox + fila atenuada (excluidos de las métricas) */
  .chk-test { width: 16px; height: 16px; accent-color: #05BAEE; cursor: pointer; vertical-align: middle; }
  tr.es-test td { opacity: .45; }
  tr.es-test td.col-test { opacity: 1; } /* el checkbox siempre visible */
  .pill.test { background: rgba(5,186,238,.16); color: #7fe3ff; }

  /* Inscritos: cabecera con pestañas + buscador, fila registrada en verde, paginación */
  .insc-head { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin: 30px 4px 14px; }
  .tabs { display: inline-flex; gap: 6px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 10px; padding: 4px; }
  .tab { padding: 7px 14px; border-radius: 7px; font-size: 13.5px; color: #b9c8d0; text-decoration: none; font-weight: 600; }
  .tab.active { background: #05BAEE; color: #06232b; }
  .search { display: flex; gap: 8px; }
  .search input { font: inherit; font-size: 13.5px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14); color: #e7eef2; border-radius: 8px; padding: 8px 12px; width: 230px; }
  .search input::placeholder { color: #7f97a2; }
  .search button { background: #05BAEE; color: #06232b; font-weight: 700; border: 0; border-radius: 8px; padding: 8px 13px; cursor: pointer; font-size: 13.5px; }
  .search .clear { background: transparent; color: #b9c8d0; border: 1px solid rgba(255,255,255,.16); text-decoration: none; display: inline-flex; align-items: center; padding: 8px 11px; border-radius: 8px; font-size: 13.5px; }
  tr.reg td { background: rgba(22,163,74,.09); }
  tr.reg td:first-child { box-shadow: inset 3px 0 0 #16a34a; }
  tr.reg:hover td { background: rgba(22,163,74,.14); }
  .pager { display: flex; align-items: center; justify-content: center; gap: 14px; margin-top: 16px; }
  .pg { font-size: 14px; text-decoration: none; color: #e7eef2; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; padding: 8px 14px; }
  .pg:hover { border-color: rgba(255,255,255,.4); }
  .pg.disabled { opacity: .4; pointer-events: none; }
  .pg-info { font-size: 13px; color: #9fb4bf; }

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
      <a class="btn btn-ghost" href="{{ route('admin.encuestas') }}" title="Puntuaciones y comentarios de la encuesta de satisfacción">Encuestas</a>
      <a class="btn btn-ghost" href="{{ route('admin.preguntas') }}" title="Todas las preguntas con su % de acierto">Preguntas</a>
      <a class="btn btn-ghost" href="{{ route('admin.correos') }}" title="Vista previa de los correos automáticos de la plataforma">Correos</a>
      <a class="btn btn-ghost" href="{{ route('admin.contenido') }}" title="Editar textos e imágenes de la página de inicio">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
        Editar web
      </a>
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

    {{-- ===== Inscritos: los autorizados; en verde los que YA se registraron ===== --}}
    <div class="insc-head">
      <div class="h-sec" style="margin:0">
        Inscritos ·
        <span style="color:#6ee7a8">{{ $registradosN }} registrados</span> ·
        <span style="color:#f4d06a">{{ $pendientesN }} pendientes</span> ·
        {{ $totalAutorizados }} en total
      </div>
      <div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap;">
        <div class="tabs">
          <a class="tab {{ $tab === 'alumnos' ? 'active' : '' }}" href="{{ route('admin', ['tab' => 'alumnos', 'q' => $q ?: null]) }}">Alumnos ({{ $totalAutorizados }})</a>
          <a class="tab {{ $tab === 'test' ? 'active' : '' }}" href="{{ route('admin', ['tab' => 'test', 'q' => $q ?: null]) }}">Test ({{ $testN }})</a>
        </div>
        <form class="search" method="GET" action="{{ route('admin') }}">
          <input type="hidden" name="tab" value="{{ $tab }}">
          <input type="text" name="q" value="{{ $q }}" placeholder="Buscar nombre, correo, documento…">
          <button type="submit">Buscar</button>
          @if ($q !== '')<a class="clear" href="{{ route('admin', ['tab' => $tab]) }}">Limpiar</a>@endif
        </form>
      </div>
    </div>
    <div class="panel scroll-x">
      <table>
        <thead>
          <tr>
            <th>Inscripción</th>
            <th>Alumno</th>
            <th>Especialidad</th>
            <th>Documento</th>
            <th>Provincia</th>
            <th>Población</th>
            <th>Perfil profesional</th>
            <th class="center" title="SÍ = especialidad que puede optar a los créditos oficiales (diploma UEMS-ICOMEN)">Acreditación</th>
            <th class="center">Ingreso 1</th>
            <th class="center">Ingreso 2</th>
            <th class="center">Ingreso 3</th>
            <th class="center">Evaluación</th>
            <th class="center" title="SÍ = el alumno abrió/descargó su diploma">Diploma</th>
            <th>Registro</th>
            <th class="center" title="Marcar como cuenta de prueba: no cuenta en las métricas ni en el informe">Test</th>
            <th class="center" title="Médico seleccionado: recibe el certificado ICOMEM/SEAFORMEC. Sin marcar, recibe el CASEC de la SEC.">Cert. ICOMEM</th>
          </tr>
        </thead>
        <tbody>
          @php
            $pill = fn ($st) => match ($st) {
              'completed'   => '<span class="pill ok">✓</span>',
              'in_progress' => '<span class="pill prog">En curso</span>',
              default       => '<span class="pill none">—</span>',
            };
            $perfilLbl = ['0-7' => '0-7 años', '8-15' => '8-15 años', '16+' => '≥16 años'];
          @endphp
          @forelse ($items as $a)
            <tr class="{{ $a['is_test'] ? 'es-test' : ($a['registrado'] ? 'reg' : '') }}">
              <td>
                @if ($a['is_test']) <span class="pill test">TEST</span>
                @elseif ($a['registrado']) <span class="pill ok">✓ Registrado</span>
                @else <span class="pill none">Pendiente</span> @endif
              </td>
              <td>
                <div>{{ $a['nombre'] }}</div>
                <div class="muted">{{ $a['email'] }}</div>
              </td>
              <td>{{ $a['especialidad'] }}</td>
              <td class="muted">{{ $a['dni'] }}</td>
              <td>{{ $a['provincia'] }}</td>
              <td>{{ $a['poblacion'] }}</td>
              <td>{{ $perfilLbl[$a['perfil']] ?? $a['perfil'] }}</td>
              <td class="center">
                @if (! $a['registrado']) <span class="pill none">—</span>
                @elseif ($a['acreditada']) <span class="pill ok">SÍ</span> @else <span class="pill none">NO</span> @endif
              </td>
              <td class="center">{!! $pill($a['i1']) !!}</td>
              <td class="center">{!! $pill($a['i2']) !!}</td>
              <td class="center">{!! $pill($a['i3']) !!}</td>
              <td class="center">
                @if (! $a['registrado']) <span class="pill none">—</span>
                @else
                  @switch($a['estado_eval'])
                    @case('apto')    <span class="pill ok">APTO</span> @break
                    @case('no_apto') <span class="pill no">NO APTO</span> @break
                    @default         <span class="pill prog">EN CURSO</span>
                  @endswitch
                @endif
              </td>
              <td class="center">
                @if (! $a['registrado']) <span class="pill none">—</span>
                @elseif ($a['diploma']) <span class="pill ok">SÍ</span> @else <span class="pill none">NO</span> @endif
              </td>
              <td class="muted">{{ $a['registro'] ? \Illuminate\Support\Carbon::parse($a['registro'])->format('d/m/Y') : '—' }}</td>
              <td class="center col-test">
                @if ($a['registrado'] && $a['id'])
                  <form method="POST" action="{{ route('admin.toggle-test', $a['id']) }}">@csrf
                    <input type="checkbox" class="chk-test" onchange="this.form.submit()"
                           {{ $a['is_test'] ? 'checked' : '' }}
                           title="{{ $a['is_test'] ? 'Quitar marca de prueba' : 'Marcar como cuenta de prueba' }}">
                  </form>
                @else <span class="muted">—</span> @endif
              </td>
              <td class="center col-test">
                @if ($a['registrado'] && $a['id'])
                  <form method="POST" action="{{ route('admin.toggle-cert-icomem', $a['id']) }}">@csrf
                    <input type="checkbox" class="chk-test" onchange="this.form.submit()"
                           {{ $a['cert_icomem'] ? 'checked' : '' }}
                           title="{{ $a['cert_icomem'] ? 'Certificado ICOMEM. Desmarcar → CASEC.' : 'Certificado CASEC. Marcar → ICOMEM/SEAFORMEC.' }}">
                  </form>
                @else <span class="muted">—</span> @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="16" class="center muted" style="padding:26px;">
              @if ($q !== '') Sin resultados para “{{ $q }}”. @else No hay inscritos en esta lista. @endif
            </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    @if ($items->hasPages())
      <div class="pager">
        @if ($items->onFirstPage()) <span class="pg disabled">‹ Anterior</span>
        @else <a class="pg" href="{{ $items->previousPageUrl() }}">‹ Anterior</a> @endif
        <span class="pg-info">Página {{ $items->currentPage() }} de {{ $items->lastPage() }} · {{ $items->total() }} en total</span>
        @if ($items->hasMorePages()) <a class="pg" href="{{ $items->nextPageUrl() }}">Siguiente ›</a>
        @else <span class="pg disabled">Siguiente ›</span> @endif
      </div>
    @endif

  </div>
</body>
</html>
