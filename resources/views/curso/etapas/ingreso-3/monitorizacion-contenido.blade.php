{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 3 (editable desde el panel)
     (Terapias emergentes anti-Lp(a): pelacarsen y ensayo HORIZON.) --}}
@php $k = 'curso.cont.ingreso-3.monitorizacion.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Terapias emergentes anti-Lp(a): pelacarsen y ensayo HORIZON') }}</h1>

    {{-- El documento va directo a la pregunta (sin texto introductorio). --}}

    {{-- Pregunta 4 del Ingreso 3 (ensayo HORIZON con pelacarsen) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion_3']])
</div>
