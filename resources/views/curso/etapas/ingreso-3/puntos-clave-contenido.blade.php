{{-- Etapa "Puntos clave" — INGRESO 3 (documento §7): lista de puntos clave del caso con referencias. --}}
@php
    $d = $curso['datos_ingreso_3'];
    // Convierte las citas finales (números pegados al texto, p. ej. "cLDL1-4,6.") en superíndice,
    // con el mismo criterio que formatCitas() del front (no toca decimales ni rangos de valores).
    $sup = fn ($t) => preg_replace('/([^\s0-9>])(\d+(?:[-,]\d+)*)(?=[.;]|,(?!\d)|$)/u', '$1<sup>$2</sup>', e($t));
@endphp
<div class="riesgo">
    <h1 class="h-caso">Puntos clave</h1>

    <ul class="analitica-list">
        @foreach ($d['puntos_clave'] as $punto)
            <li style="margin-bottom:12px;">{!! $sup($punto) !!}</li>
        @endforeach
    </ul>
</div>
