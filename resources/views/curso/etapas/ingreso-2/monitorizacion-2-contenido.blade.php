{{-- Contenido de la etapa "Monitorización y seguimiento" — INGRESO 2 (editable desde el panel, con Quill).
     Capítulo de REPASO (sin cuestionario): recoge el perfil lipídico tras 1 mes de inclisirán.
     Trasladado aquí desde la etapa "Optimización de control lipídico…" (petición del cliente). --}}
@php $k = 'curso.cont.ingreso-2.monitorizacion-2.'; @endphp
<div class="riesgo">
    <h1 class="h-caso">{{ cms($k.'h1', 'Monitorización y seguimiento') }}</h1>

    <h3 class="prueba-h" style="margin: 8px 0 10px;">{{ cms($k.'h_perfil', 'Perfil lipídico tras 1 mes de inclisirán (1.ª dosis)') }}</h3>
    <div class="prueba-p riesgo-p rich-p" style="margin: 0 0 12px;">{!! cms($k.'perfil_intro') !!}</div>
    {!! cms($k.'lista') !!}
    <div class="prueba-p riesgo-p rich-p" style="margin-top:16px;">{!! cms($k.'comentario') !!}</div>
</div>
