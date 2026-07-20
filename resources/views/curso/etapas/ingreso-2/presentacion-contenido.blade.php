{{-- Contenido de la etapa "Presentación del caso" — INGRESO 2 (Juan, 53 años, 10 meses después) --}}
@php $d = $curso['datos_ingreso_2']; @endphp
<div class="content-col">
    <h1 class="h-caso">Presentación del caso</h1>

    <h2 class="h-sec">Historia clínica</h2>

    {{-- Tabs --}}
    <div class="tabs">
        <button type="button" class="tab on" data-tab="perfil">Perfil del paciente</button>
        <button type="button" class="tab" data-tab="historia">Historia médica</button>
        <button type="button" class="tab" data-tab="medicacion">Medicación</button>
        <button type="button" class="tab" data-tab="alergias">Alergias</button>
    </div>

    <div class="perfil-card">
        <div class="tab-panel" data-panel="perfil">
            <p><b>Edad y sexo:</b> {{ $d['perfil']['edad_sexo'] }}</p>
            <p><b>Peso, estatura:</b> {{ $d['perfil']['peso_estatura'] }}</p>
            <p><b>Hábitos:</b> {{ $d['perfil']['habitos'] }}</p>
            <p><b>Ocupación:</b> {{ $d['perfil']['ocupacion'] }}</p>
            <p><b>Estilo de vida:</b> {{ $d['perfil']['estilo_vida'] }}</p>
        </div>
        <div class="tab-panel" data-panel="historia" style="display:none">
            @foreach ($d['historia'] as $item)
                <p>{{ $item }}</p>
            @endforeach
        </div>
        <div class="tab-panel" data-panel="medicacion" style="display:none">
            @foreach ($d['medicacion'] as $item)
                <p>{{ $item }}</p>
            @endforeach
        </div>
        <div class="tab-panel" data-panel="alergias" style="display:none">
            <p>{{ $d['alergias'] }}</p>
        </div>
    </div>

    <h2 class="h-sec">Motivo de consulta</h2>
    <p class="motivo-p">{{ $d['motivo_consulta'] }}</p>
</div>
