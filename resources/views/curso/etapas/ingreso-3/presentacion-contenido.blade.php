{{-- Contenido de la etapa "Presentación del caso" — INGRESO 3 (editable desde el panel) --}}
@php $k = 'curso.cont.ingreso-3.presentacion.'; @endphp
<div class="content-col">
    <h1 class="h-caso">{{ cms($k.'h1', 'Presentación del caso') }}</h1>

    <h2 class="h-sec">{{ cms($k.'h_historia', 'Historia clínica') }}</h2>

    {{-- Tabs --}}
    <div class="tabs">
        <button type="button" class="tab on" data-tab="perfil">{{ cms($k.'tab_perfil', 'Perfil del paciente') }}</button>
        <button type="button" class="tab" data-tab="historia">{{ cms($k.'tab_historia', 'Historia médica') }}</button>
        <button type="button" class="tab" data-tab="medicacion">{{ cms($k.'tab_medicacion', 'Medicación') }}</button>
        <button type="button" class="tab" data-tab="alergias">{{ cms($k.'tab_alergias', 'Alergias') }}</button>
    </div>

    <div class="perfil-card">
        <div class="tab-panel" data-panel="perfil">
            {!! cms($k.'perfil') !!}
        </div>
        <div class="tab-panel" data-panel="historia" style="display:none">
            {!! cms($k.'historia') !!}
        </div>
        <div class="tab-panel" data-panel="medicacion" style="display:none">
            {!! cms($k.'medicacion') !!}
        </div>
        <div class="tab-panel" data-panel="alergias" style="display:none">
            {!! cms($k.'alergias_p', '<p>Sin alergias medicamentosas conocidas.</p>') !!}
        </div>
    </div>

    <h2 class="h-sec">{{ cms($k.'h_motivo', 'Motivo de consulta') }}</h2>
    <div class="motivo-p rich-p">{!! cms($k.'motivo') !!}</div>
</div>
