{{-- Etapa "Terapia de mantenimiento / Evolución" — INGRESO 3 (evolución + puntos clave del caso) --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Evolución</h1>

    @foreach ($d['evolucion'] as $parrafo)
        <p class="prueba-p" style="margin-top:{{ $loop->first ? '0' : '14px' }};">{{ $parrafo }}</p>
    @endforeach

    <h2 class="h-sec riesgo-h" style="margin-top:28px;">Puntos clave</h2>
    <ul class="analitica-list">
        @foreach ($d['puntos_clave'] as $punto)
            <li style="margin-bottom:10px;">{{ $punto }}</li>
        @endforeach
    </ul>
</div>
