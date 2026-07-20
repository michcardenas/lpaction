{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 3
     (Terapias emergentes anti-Lp(a): pelacarsen y ensayo HORIZON.) --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Terapias emergentes anti-Lp(a): pelacarsen y ensayo HORIZON</h1>

    <p class="prueba-p riesgo-p" style="margin: 0 0 12px;">
        Ante una Lp(a) que permanece marcadamente elevada pese al tratamiento óptimo, las terapias específicas
        en desarrollo (pelacarsen, olpasiran, lepodisiran) y el ensayo de resultados cardiovasculares
        <b>Lp(a)HORIZON</b> con pelacarsen adquieren especial relevancia en un paciente como Juan.
    </p>

    {{-- Pregunta 4 del Ingreso 3 (ensayo HORIZON con pelacarsen) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion_3']])
</div>
