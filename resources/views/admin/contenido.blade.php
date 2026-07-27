<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar web · Lp(a)ction</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: "Segoe UI", "Calibri", system-ui, sans-serif; color: #e7eef2; background: #0a1a24;
         background-image: radial-gradient(1200px 500px at 80% -10%, rgba(5,186,238,.14), transparent 60%); min-height: 100vh; padding-bottom: 90px; }
  a { color: inherit; }

  .topbar { display: flex; align-items: center; justify-content: space-between; gap: 16px;
            padding: 16px 30px; border-bottom: 1px solid rgba(255,255,255,.08); position: sticky; top: 0;
            background: #0a1a24; z-index: 20; }
  .brand { display: flex; align-items: baseline; gap: 10px; }
  .brand b { font-size: 18px; font-weight: 800; color: #fff; }
  .brand span { font-size: 12px; letter-spacing: .18em; text-transform: uppercase; color: #05BAEE; font-weight: 700; }
  .topbar-actions { display: flex; align-items: center; gap: 10px; }
  .btn { font: inherit; border: 0; border-radius: 8px; padding: 9px 16px; cursor: pointer; text-decoration: none;
         display: inline-flex; align-items: center; gap: 7px; font-size: 14px; }
  .btn-ghost { background: transparent; color: #b9c8d0; border: 1px solid rgba(255,255,255,.16); }
  .btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,.4); }
  .btn-cyan { background: #05BAEE; color: #06232b; font-weight: 700; }
  .btn-cyan:hover { background: #22d3ee; }
  .btn-mini { font-size: 12px; padding: 5px 10px; border-radius: 6px; }

  .wrap { max-width: 920px; margin: 0 auto; padding: 26px 24px 40px; }
  .intro { color: #9fb4bf; font-size: 14px; line-height: 1.6; margin: 6px 4px 22px; }
  .intro b { color: #cfe6ef; }

  .flash { background: rgba(22,163,74,.16); border: 1px solid rgba(22,163,74,.4); color: #8ff0b6;
           padding: 12px 16px; border-radius: 10px; margin: 0 0 18px; font-size: 14px; }
  .errs { background: rgba(220,53,69,.14); border: 1px solid rgba(220,53,69,.4); color: #ffb3bb;
          padding: 12px 16px; border-radius: 10px; margin: 0 0 18px; font-size: 14px; }

  .tabs { display: flex; flex-wrap: wrap; gap: 8px; margin: 2px 0 20px; border-bottom: 1px solid rgba(255,255,255,.1); padding-bottom: 14px; }
  .tab { text-decoration: none; font-size: 14px; font-weight: 600; color: #b9c8d0; padding: 9px 16px; border-radius: 9px;
         border: 1px solid rgba(255,255,255,.14); background: transparent; white-space: nowrap; }
  .tab:hover { color: #fff; border-color: rgba(255,255,255,.35); }
  .tab.active { background: #05BAEE; color: #06232b; border-color: #05BAEE; font-weight: 800; }
  details.sec { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09);
                border-radius: 14px; margin-bottom: 14px; overflow: hidden; }
  details.sec > summary { list-style: none; cursor: pointer; padding: 16px 20px; font-size: 15.5px; font-weight: 700;
                          color: #fff; display: flex; align-items: center; justify-content: space-between; }
  details.sec > summary::-webkit-details-marker { display: none; }
  details.sec > summary .chev { transition: transform .2s; color: #7fa7b8; }
  details.sec[open] > summary .chev { transform: rotate(90deg); }
  details.sec > summary .count { font-size: 11px; font-weight: 600; color: #7fa7b8; letter-spacing: .04em; }
  .sec-body { padding: 6px 20px 20px; }

  .field { padding: 16px 0; border-top: 1px solid rgba(255,255,255,.06); }
  .field:first-child { border-top: 0; }
  .field-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 8px; }
  .field-label { font-size: 13.5px; color: #cfe0e7; font-weight: 600; }
  .badge-edit { font-size: 10.5px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
                color: #7fe3ff; background: rgba(5,186,238,.16); padding: 2px 8px; border-radius: 999px; }
  .hint { font-size: 12px; color: #7f97a2; margin-top: 5px; }

  input[type=text], textarea {
    width: 100%; font: inherit; font-size: 14px; color: #eaf2f6; background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.14); border-radius: 9px; padding: 10px 12px; resize: vertical; }
  input[type=text]:focus, textarea:focus { outline: none; border-color: #05BAEE; background: rgba(5,186,238,.06); }
  textarea { min-height: 74px; line-height: 1.5; }

  .img-row { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
  .img-prev { width: 150px; height: 100px; border-radius: 10px; border: 1px solid rgba(255,255,255,.14);
              background: repeating-conic-gradient(#1a2c37 0% 25%, #14232c 0% 50%) 50% / 18px 18px;
              display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
  .img-prev img { max-width: 100%; max-height: 100%; object-fit: contain; }
  .img-ctl { flex: 1; min-width: 220px; }
  input[type=file] { font-size: 13px; color: #b9c8d0; }
  input[type=file]::file-selector-button { font: inherit; font-size: 13px; margin-right: 10px; cursor: pointer;
    background: rgba(255,255,255,.08); color: #dbe7ec; border: 1px solid rgba(255,255,255,.16);
    border-radius: 7px; padding: 7px 12px; }

  .restore { background: transparent; border: 1px solid rgba(255,255,255,.16); color: #b9c8d0;
             border-radius: 6px; padding: 4px 10px; font-size: 12px; cursor: pointer; }
  .restore:hover { color: #ffd0d5; border-color: rgba(255,120,130,.5); }

  .savebar { position: fixed; bottom: 0; left: 0; right: 0; background: rgba(8,20,27,.92);
             backdrop-filter: blur(8px); border-top: 1px solid rgba(255,255,255,.1);
             padding: 14px 30px; display: flex; align-items: center; justify-content: space-between; z-index: 30; }
  .savebar .note { font-size: 12.5px; color: #8ba0ab; }

  /* Editor de texto con formato (Quill) */
  .rich-wrap { background: #fff; border-radius: 9px; overflow: hidden; border: 1px solid rgba(255,255,255,.14); }
  .rich-wrap .ql-toolbar.ql-snow { border: 0; border-bottom: 1px solid rgba(0,0,0,.12); }
  .rich-wrap .ql-container.ql-snow { border: 0; min-height: 100px; font-family: inherit; font-size: 14px; }
  .rich-wrap .ql-editor { color: #14232c; }
  .rich-tools { margin-top: 6px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
  .rich-html-toggle { background: transparent; border: 1px solid rgba(255,255,255,.18); color: #b9c8d0; border-radius: 6px;
                      padding: 4px 10px; font-size: 12px; cursor: pointer; white-space: nowrap; }
  .rich-html-toggle:hover { color: #fff; border-color: rgba(255,255,255,.4); }
  .rich-html { width: 100%; font-family: ui-monospace, "Consolas", "Courier New", monospace; font-size: 13px; line-height: 1.55;
               color: #eaf2f6; background: rgba(0,0,0,.30); border: 1px solid rgba(255,255,255,.16); border-radius: 9px; padding: 10px 12px; resize: vertical; }
</style>
<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
</head>
<body>

  <div class="topbar">
    <div class="brand"><b>Lp(a)ction</b><span>Editar web</span></div>
    <div class="topbar-actions">
      <a class="btn btn-ghost" href="{{ route('home') }}" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6"/><path d="M10 14 21 3"/></svg>
        Ver la web
      </a>
      <a class="btn btn-ghost" href="{{ route('admin') }}">Volver al panel</a>
    </div>
  </div>

  <div class="wrap">

    {{-- Pestañas: cada ingreso es independiente --}}
    <nav class="tabs">
      @foreach ($tabs as $tabKey => $tabLabel)
        <a class="tab {{ $area === $tabKey ? 'active' : '' }}" href="{{ route('admin.contenido', $tabKey) }}">{{ $tabLabel }}</a>
      @endforeach
    </nav>

    <div class="intro">
      @if ($area === 'landing')
        Edita los <b>textos e imágenes</b> de la página de inicio.
      @else
        Edita los <b>textos de las preguntas</b> de este ingreso (enunciado, opciones y justificaciones).
        La <b>respuesta correcta y la puntuación no se tocan</b>. Cada ingreso es independiente.
      @endif
      Lo que no toques se mantiene igual; usa <b>“Restaurar original”</b> para volver al contenido de fábrica.
    </div>

    @if (session('cms_ok'))
      <div class="flash">{{ session('cms_ok') }}</div>
    @endif
    @if ($errors->any())
      <div class="errs">Revisa las imágenes: deben ser archivos de imagen (máx. 5 MB).</div>
    @endif

    <form method="POST" action="{{ route('admin.contenido.update') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="area" value="{{ $area }}">

      @php $primeraSec = true; @endphp
      @foreach ($secciones as $secKey => $sec)
        <details class="sec" id="sec-{{ $secKey }}" {{ $primeraSec ? 'open' : '' }}>
          @php $primeraSec = false; @endphp
          <summary>
            <span>{{ $sec['label'] }}</span>
            <span style="display:flex; align-items:center; gap:12px;">
              <span class="count">{{ count($sec['fields']) }} campos</span>
              <svg class="chev" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
            </span>
          </summary>
          <div class="sec-body">
            @foreach ($sec['fields'] as $key => $field)
              @php
                $editado = \App\Support\Cms::isOverridden($key);
                $valor   = \App\Support\Cms::raw($key) ?? ($field['default'] ?? '');
              @endphp
              <div class="field">
                <div class="field-head">
                  <span class="field-label">
                    {{ $field['label'] }}
                    @if ($editado) <span class="badge-edit">editado</span> @endif
                  </span>
                  @if ($editado)
                    <button type="submit" name="restore" value="{{ $key }}" class="restore"
                            title="Volver al contenido original">Restaurar original</button>
                  @endif
                </div>

                @if ($field['type'] === 'image')
                  <div class="img-row">
                    <div class="img-prev"><img src="{{ cms_img($key) }}" alt=""></div>
                    <div class="img-ctl">
                      <input type="file" name="img[{{ $key }}]" accept="image/*">
                      <div class="hint">Sube una imagen nueva para reemplazarla (PNG/JPG/WebP, máx. 5 MB).</div>
                    </div>
                  </div>
                @elseif ($field['type'] === 'video')
                  <div class="img-row">
                    <div class="img-prev">
                      @if ($editado)
                        <video src="{{ cms_img($key) }}" muted playsinline preload="metadata" style="max-width:100%;max-height:100%;"></video>
                      @else
                        <span style="font-size:12px; color:#8b9aa3; text-align:center; padding:6px;">Sin vídeo<br>(marcador)</span>
                      @endif
                    </div>
                    <div class="img-ctl">
                      <input type="file" name="video[{{ $key }}]" accept="video/mp4,video/webm,video/ogg">
                      <div class="hint">Sube el vídeo de la introducción (MP4/WebM, máx. 40 MB). Se verá en el curso al guardar.</div>
                    </div>
                  </div>
                @elseif ($field['type'] === 'doc')
                  <div class="img-row">
                    <div class="img-prev">
                      @if ($editado)
                        <span style="font-size:12px; color:#8ff0b6; text-align:center; padding:6px;">Archivo<br>subido ✓</span>
                      @else
                        <span style="font-size:12px; color:#8b9aa3; text-align:center; padding:6px;">Archivo<br>por defecto</span>
                      @endif
                    </div>
                    <div class="img-ctl">
                      <input type="file" name="doc[{{ $key }}]" accept=".pdf,.doc,.docx">
                      <div class="hint">Sube el archivo que se descarga en “Descargar caso” (PDF o Word, máx. 40 MB).</div>
                    </div>
                  </div>
                @elseif ($field['type'] === 'richtext')
                  <div class="rich-group">
                    <div class="rich-wrap">
                      <div class="rich">{!! $valor !!}</div>
                      <input type="hidden" name="text[{{ $key }}]" class="rich-input">
                    </div>
                    <textarea class="rich-html" rows="7" spellcheck="false" style="display:none">{{ $valor }}</textarea>
                    <div class="rich-tools">
                      <button type="button" class="rich-html-toggle">&lt;/&gt; Editar HTML</button>
                      <span class="hint" style="display:inline;">Negrita, listas, <b>x²/x₂</b> (superíndice/subíndice), enlaces… o edita el HTML directamente.</span>
                    </div>
                  </div>
                @elseif ($field['type'] === 'textarea')
                  <textarea name="text[{{ $key }}]">{{ $valor }}</textarea>
                  @if (!empty($field['html']))
                    <div class="hint">Puedes usar etiquetas simples como &lt;em&gt;texto en cursiva&lt;/em&gt;.</div>
                  @endif
                @else
                  <input type="text" name="text[{{ $key }}]" value="{{ $valor }}">
                @endif
              </div>
            @endforeach
          </div>
        </details>
      @endforeach

      <div class="savebar">
        <span class="note">Los cambios se aplican en cuanto guardas.</span>
        <button type="submit" class="btn btn-cyan">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
          Guardar cambios
        </button>
      </div>
    </form>
  </div>

  <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
  <script>
    // Inicializa un editor Quill por cada bloque richtext y vuelca su HTML al input oculto al enviar.
    (function () {
      if (typeof Quill === 'undefined') return;
      // Toolbar con superíndice (x²) y subíndice (x₂).
      var toolbar = [
        ['bold', 'italic', 'underline'],
        [{ script: 'super' }, { script: 'sub' }],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link'], ['clean']
      ];
      // Quita párrafos vacíos que Quill deja al pulsar Enter (causaban espacios de más).
      function limpiar(html) {
        html = html.replace(/<p>(?:\s|&nbsp;|<br\s*\/?>)*<\/p>/gi, '');
        if (html === '<p></p>') html = '';
        return html;
      }
      var editores = [];
      document.querySelectorAll('.rich-group').forEach(function (group) {
        var el = group.querySelector('.rich');
        var input = group.querySelector('.rich-input');
        var ta = group.querySelector('.rich-html');
        var wrap = group.querySelector('.rich-wrap');
        var btn = group.querySelector('.rich-html-toggle');
        if (!el || !input) return;
        var q = new Quill(el, { theme: 'snow', modules: { toolbar: toolbar } });
        input.value = limpiar(q.root.innerHTML);
        var reg = { q: q, input: input, ta: ta, htmlMode: false };
        editores.push(reg);

        // Alternar entre editor visual y edición del HTML en crudo.
        if (btn && ta && wrap) {
          btn.addEventListener('click', function () {
            if (!reg.htmlMode) {
              ta.value = limpiar(q.root.innerHTML);
              wrap.style.display = 'none';
              ta.style.display = 'block';
              btn.textContent = 'Volver al editor visual';
              reg.htmlMode = true;
            } else {
              q.root.innerHTML = ta.value;       // aplica el HTML editado al editor visual
              wrap.style.display = '';
              ta.style.display = 'none';
              btn.innerHTML = '&lt;/&gt; Editar HTML';
              reg.htmlMode = false;
            }
          });
        }
      });
      var form = document.querySelector('form');
      if (form) form.addEventListener('submit', function () {
        editores.forEach(function (r) {
          r.input.value = r.htmlMode ? r.ta.value : limpiar(r.q.root.innerHTML);
        });
      });
    })();
  </script>
</body>
</html>
