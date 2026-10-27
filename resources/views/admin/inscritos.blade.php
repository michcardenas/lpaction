<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscritos · Panel Lp(a)ction</title>
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

  .wrap { max-width: 1100px; margin: 0 auto; padding: 28px 30px 60px; }
  h1.title { font-size: 22px; color: #fff; font-weight: 800; margin-bottom: 4px; }
  .subt { font-size: 13px; color: #9fb4bf; margin-bottom: 22px; }

  .cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
  .card { background: rgba(255,255,255,.045); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; padding: 18px 20px; }
  .card .lbl { font-size: 12.5px; color: #9fb4bf; margin-bottom: 7px; }
  .card .num { font-size: 32px; font-weight: 800; color: #fff; line-height: 1; }
  .card.green { border-color: rgba(22,163,74,.4); background: rgba(22,163,74,.10); }
  .card.green .num { color: #6ee7a8; }
  .card.amber { border-color: rgba(234,179,8,.32); background: rgba(234,179,8,.08); }
  .card.amber .num { color: #f4d06a; }

  .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-bottom: 14px; }
  .tabs { display: inline-flex; gap: 6px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09);
          border-radius: 10px; padding: 4px; }
  .tab { padding: 8px 16px; border-radius: 7px; font-size: 14px; color: #b9c8d0; text-decoration: none; font-weight: 600; }
  .tab.active { background: #05BAEE; color: #06232b; }
  .search { display: flex; gap: 8px; }
  .search input { font: inherit; font-size: 14px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14);
                  color: #e7eef2; border-radius: 8px; padding: 9px 13px; width: 260px; }
  .search input::placeholder { color: #7f97a2; }
  .search button { background: #05BAEE; color: #06232b; font-weight: 700; border: 0; border-radius: 8px; padding: 9px 14px; cursor: pointer; font-size: 14px; }
  .search .clear { background: transparent; color: #b9c8d0; border: 1px solid rgba(255,255,255,.16); text-decoration: none; display: inline-flex; align-items: center; padding: 9px 12px; border-radius: 8px; }

  .panel { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; overflow: hidden; }
  .panel.scroll-x { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  th, td { text-align: left; padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,.06); }
  th { font-size: 11.5px; letter-spacing: .06em; text-transform: uppercase; color: #7fa7b8; font-weight: 700; background: rgba(255,255,255,.03); }
  tbody tr:hover { background: rgba(255,255,255,.03); }
  td .muted { color: #7f97a2; font-size: 12.5px; }
  .idx { color: #5f7d86; font-size: 12px; width: 44px; }
  .pill { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 999px; white-space: nowrap; }
  .pill.ok { background: rgba(22,163,74,.20); color: #6ee7a8; }
  .pill.none { background: rgba(255,255,255,.06); color: #8b9aa3; }
  .pill.test { background: rgba(5,186,238,.16); color: #7fe3ff; }
  /* Fila REGISTRADO: fondo verde tenue + barrita verde a la izquierda */
  tr.reg td { background: rgba(22,163,74,.09); }
  tr.reg td:first-child { box-shadow: inset 3px 0 0 #16a34a; }
  tr.reg:hover td { background: rgba(22,163,74,.15); }

  .pager { display: flex; align-items: center; justify-content: center; gap: 14px; margin-top: 18px; }
  .pg { font-size: 14px; text-decoration: none; color: #e7eef2; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14);
        border-radius: 8px; padding: 8px 14px; }
  .pg:hover { border-color: rgba(255,255,255,.4); }
  .pg.disabled { opacity: .4; pointer-events: none; }
  .pg-info { font-size: 13px; color: #9fb4bf; }
  .empty { text-align: center; color: #8b9aa3; padding: 34px; }

  @media (max-width: 820px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .search input { width: 160px; }
  }
</style>
</head>
<body>
  <div class="topbar">
    <div class="brand"><b>Lp(a)ction</b><span>Inscritos</span></div>
    <div class="topbar-actions">
      <a class="btn btn-ghost" href="{{ route('admin') }}">← Volver al panel</a>
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="btn btn-ghost" type="submit">Cerrar sesión</button>
      </form>
    </div>
  </div>

  <div class="wrap">
    <h1 class="title">Inscritos al curso</h1>
    <div class="subt">Lista de personas autorizadas a registrarse. En <b style="color:#6ee7a8">verde</b> las que ya crearon su cuenta.</div>

    {{-- KPIs --}}
    <div class="cards">
      <div class="card"><div class="lbl">Autorizados (total)</div><div class="num">{{ $totalAutorizados }}</div></div>
      <div class="card green"><div class="lbl">Ya registrados</div><div class="num">{{ $registrados }}</div></div>
      <div class="card amber"><div class="lbl">Pendientes</div><div class="num">{{ $pendientes }}</div></div>
      <div class="card"><div class="lbl">Cuentas de prueba</div><div class="num">{{ $totalTest }}</div></div>
    </div>

    {{-- Pestañas + buscador --}}
    <div class="toolbar">
      <div class="tabs">
        <a class="tab {{ $tab === 'alumnos' ? 'active' : '' }}" href="{{ route('admin.inscritos', ['tab' => 'alumnos', 'q' => $q ?: null]) }}">Alumnos ({{ $totalAutorizados }})</a>
        <a class="tab {{ $tab === 'test' ? 'active' : '' }}" href="{{ route('admin.inscritos', ['tab' => 'test', 'q' => $q ?: null]) }}">Test ({{ $totalTest }})</a>
      </div>
      <form class="search" method="GET" action="{{ route('admin.inscritos') }}">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input type="text" name="q" value="{{ $q }}" placeholder="Buscar nombre, correo o documento…">
        <button type="submit">Buscar</button>
        @if ($q !== '')
          <a class="clear" href="{{ route('admin.inscritos', ['tab' => $tab]) }}">Limpiar</a>
        @endif
      </form>
    </div>

    {{-- Tabla --}}
    <div class="panel scroll-x">
      <table>
        <thead>
          <tr>
            <th class="idx">#</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Documento</th>
            <th>Estado</th>
            <th>Fecha de registro</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i => $r)
            <tr class="{{ $r['registrado'] ? 'reg' : '' }}">
              <td class="idx">{{ $items->firstItem() + $i }}</td>
              <td>{{ $r['nombre'] ?? '—' }}</td>
              <td>{{ $r['email'] }}</td>
              <td class="muted">{{ $r['documento'] ?: '—' }}</td>
              <td>
                @if ($r['registrado'])
                  @if ($tab === 'test')
                    <span class="pill test">TEST</span>
                  @else
                    <span class="pill ok">✓ Registrado</span>
                  @endif
                @else
                  <span class="pill none">Pendiente</span>
                @endif
              </td>
              <td class="muted">{{ $r['fecha'] ? \Illuminate\Support\Carbon::parse($r['fecha'])->format('d/m/Y H:i') : '—' }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="empty">
              @if ($q !== '') No hay resultados para “{{ $q }}”. @else No hay registros en esta lista. @endif
            </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    @if ($items->hasPages())
      <div class="pager">
        @if ($items->onFirstPage())
          <span class="pg disabled">‹ Anterior</span>
        @else
          <a class="pg" href="{{ $items->previousPageUrl() }}">‹ Anterior</a>
        @endif
        <span class="pg-info">Página {{ $items->currentPage() }} de {{ $items->lastPage() }} · {{ $items->total() }} en total</span>
        @if ($items->hasMorePages())
          <a class="pg" href="{{ $items->nextPageUrl() }}">Siguiente ›</a>
        @else
          <span class="pg disabled">Siguiente ›</span>
        @endif
      </div>
    @endif

  </div>
</body>
</html>
