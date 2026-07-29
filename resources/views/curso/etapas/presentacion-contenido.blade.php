{{-- Contenido de la etapa "Presentación del caso" — INGRESO 1 (textos editables desde el panel, con Quill) --}}
@php $k = 'curso.cont.ingreso-1.presentacion.'; @endphp
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

    {{-- Tarjeta (cambia según la pestaña) --}}
    <div class="perfil-card">
        <div class="tab-panel" data-panel="perfil">
            {!! cms($k.'perfil', '<p><b>Edad y sexo:</b> varón, 52 años</p><p><b>Peso, estatura:</b> 82 kg, 167 cm (índice de masa corporal [IMC]: 29,4 kg/m² ; sobrepeso).</p><p><b>Hábitos:</b> fumador desde los 15 años; índice paquetes-año (IPA): 42.</p><p><b>Ocupación:</b> empresario.</p><p><b>Estilo de vida:</b> vida sedentaria, alto nivel de estrés.</p>') !!}
        </div>
        <div class="tab-panel" data-panel="historia" style="display:none">
            {!! cms($k.'historia_p', '<p>Hipertensión arterial (HTA) ligera de 7 años de evolución.</p>') !!}
        </div>
        <div class="tab-panel" data-panel="medicacion" style="display:none">
            {!! cms($k.'medicacion', '<p><b>Telmisartán:</b> 80 mg/24 h.</p>') !!}
        </div>
        <div class="tab-panel" data-panel="alergias" style="display:none">
            {!! cms($k.'alergias_p', '<p>Sin alergias medicamentosas conocidas.</p>') !!}
        </div>
    </div>

    <h2 class="h-sec">{{ cms($k.'h_motivo', 'Motivo de consulta') }}</h2>
    <div class="motivo-p rich-p">{!! cms($k.'motivo') !!}</div>
</div>
