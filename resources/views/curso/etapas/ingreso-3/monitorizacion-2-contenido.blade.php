{{-- Etapa "Evolución" — INGRESO 3 (documento §6): narrativa de evolución + Pregunta 5 (editable desde el panel).
     ÚLTIMA pregunta del ingreso: al comprobar aparece el modal "Finalizar caso" con la medalla. --}}
@php $k = 'curso.cont.ingreso-3.monitorizacion-2.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Evolución') }}</h1>

    <p class="prueba-p riesgo-p" style="margin-top:0;">{{ cms($k.'evo1') }}</p>
    <p class="prueba-p riesgo-p" style="margin-top:14px;">{{ cms($k.'evo2') }}</p>
    <p class="prueba-p riesgo-p" style="margin-top:14px;">{{ cms($k.'evo3') }}</p>

    {{-- Pregunta 5 del Ingreso 3 (estrategia de manejo post-alta) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_monitorizacion2_3']])
</div>
