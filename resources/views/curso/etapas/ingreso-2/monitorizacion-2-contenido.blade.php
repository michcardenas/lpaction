{{-- Contenido de la etapa "Monitorización y seguimiento 2" — INGRESO 2.
     En el módulo 2 este capítulo NO tiene cuestionario (el documento no lo contempla):
     recoge el perfil lipídico tras inclisirán, el cribado familiar y el cierre del caso. --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Monitorización y seguimiento 2</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">{{ $d['perfil_post_inclisiran_intro'] }}</p>
    <ul class="analitica-list">
        @foreach ($d['perfil_post_inclisiran'] as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>

    @if (!empty($d['perfil_post_inclisiran_comentario']))
        <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ $d['perfil_post_inclisiran_comentario'] }}</p>
    @endif

    {{-- Screening familiar: varios párrafos (texto_1, texto_2, …) --}}
    @foreach ((array) ($d['screening'] ?? []) as $parrafo)
        <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ $parrafo }}</p>
    @endforeach

    @if (!empty($d['cierre']))
        <p class="prueba-p riesgo-p" style="margin-top:16px;">{{ $d['cierre'] }}</p>
    @endif
</div>
