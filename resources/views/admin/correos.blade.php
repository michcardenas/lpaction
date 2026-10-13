<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Correos automáticos · Lp(a)ction</title>
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
  .wrap { max-width: 1000px; margin: 0 auto; padding: 24px 30px 60px; }
  h1 { font-size: 22px; color: #fff; margin-bottom: 4px; }
  .lead { font-size: 13.5px; color: #9fb4bf; margin-bottom: 22px; }
  .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
  .card { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 14px; padding: 18px 20px;
          display: flex; flex-direction: column; gap: 10px; }
  .card .tag { font-size: 11px; letter-spacing: .1em; text-transform: uppercase; color: #05BAEE; font-weight: 700; }
  .card h3 { font-size: 15.5px; color: #fff; line-height: 1.35; }
  .card .when { font-size: 12.5px; color: #9fb4bf; flex: 1; }
  .card a.ver { align-self: flex-start; margin-top: 4px; }
  a.ver { color: #7fe3ff; text-decoration: none; font-size: 13.5px; font-weight: 600; border: 1px solid rgba(5,186,238,.4); border-radius: 8px; padding: 7px 14px; }
  a.ver:hover { background: rgba(5,186,238,.14); }
  .note { margin-top: 24px; font-size: 12.5px; color: #7f97a2; line-height: 1.6; }
</style>
</head>
<body>
  <div class="topbar">
    <div class="brand"><b>Lp(a)ction</b><span>Correos automáticos</span></div>
    <a class="btn" href="{{ route('admin') }}">← Volver al panel</a>
  </div>
  <div class="wrap">
    <h1>Correos automáticos</h1>
    <p class="lead">Vista previa de los 6 correos que envía la plataforma. Los datos ("María", fecha de cierre) son de ejemplo; en el envío real se personalizan por usuario.</p>

    <div class="grid">
      @php $num = 1; @endphp
      @foreach ($correos as $clave => $info)
        <div class="card">
          <div class="tag">Correo {{ str_pad($num++, 2, '0', STR_PAD_LEFT) }}</div>
          <h3>{{ $info['asunto'] }}</h3>
          <div class="when">{{ $info['cuando'] }}</div>
          <a class="ver" href="{{ route('admin.correos.preview', $clave) }}" target="_blank" rel="noopener">Ver correo →</a>
        </div>
      @endforeach
    </div>

    <p class="note">
      La fecha de cierre de los recordatorios (correos 05 y 06) se configura en el servidor con la variable <code>LPA_FECHA_CIERRE</code>.
      Actualmente: <strong>{{ config('curso.correos.fecha_cierre') }}</strong>.
    </p>
  </div>
</body>
</html>
