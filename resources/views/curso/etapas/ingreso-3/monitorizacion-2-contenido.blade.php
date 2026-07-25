{{-- Etapa "Evolución" — INGRESO 3 (documento §6): narrativa de evolución + Pregunta 5.
     ÚLTIMA pregunta del ingreso: al comprobar aparece el modal "Finalizar caso" con la medalla. --}}
@php $d = $curso['datos_ingreso_3']; @endphp
<div class="riesgo">
    <h1 class="h-caso">Evolución</h1>

    @foreach ($d['evolucion'] as $parrafo)
        <p class="prueba-p riesgo-p" style="margin-top:{{ $loop->first ? '0' : '14px' }};">{{ $parrafo }}</p>
    @endforeach

    {{-- Pregunta 5 del Ingreso 3 (estrategia de manejo post-alta) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion2_3']])
</div>
