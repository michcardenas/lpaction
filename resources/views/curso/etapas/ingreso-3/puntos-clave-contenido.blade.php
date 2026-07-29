{{-- Etapa "Puntos clave" — INGRESO 3 (documento §7): lista de puntos clave del caso con referencias (editable desde el panel). --}}
@php $k = 'curso.cont.ingreso-3.puntos-clave.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Puntos clave') }}</h1>

    {!! cms($k.'lista') !!}
</div>
