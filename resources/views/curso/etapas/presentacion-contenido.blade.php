{{-- Contenido de la etapa "Presentación del caso" --}}
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

    {{-- Tarjeta (cambia según la pestaña) --}}
    <div class="perfil-card">
        <div class="tab-panel" data-panel="perfil">
            <p><b>Edad y sexo:</b> varón, 52 años</p>
            <p><b>Peso, estatura:</b> 82 kg, 167 cm (índice de masa corporal [IMC]: 29,4 kg/m² ; sobrepeso).</p>
            <p><b>Hábitos:</b> fumador desde los 15 años; índice paquetes-año (IPA): 42.</p>
            <p><b>Ocupación:</b> empresario.</p>
            <p><b>Estilo de vida:</b> vida sedentaria, alto nivel de estrés.</p>
        </div>
        <div class="tab-panel" data-panel="historia" style="display:none">
            <p>Hipertensión arterial (HTA) ligera de 7 años de evolución.</p>
        </div>
        <div class="tab-panel" data-panel="medicacion" style="display:none">
            <p><b>Telmisartán:</b> 80 mg/24 h.</p>
        </div>
        <div class="tab-panel" data-panel="alergias" style="display:none">
            <p>Sin alergias medicamentosas conocidas.</p>
        </div>
    </div>

    <h2 class="h-sec">Motivo de consulta</h2>
    <p class="motivo-p">
        Paciente que es traído a Urgencias de nuestro hospital por los servicios de
        emergencias debido a un cuadro de 2 h de evolución de dolor torácico
        retroesternal muy intenso que irradia hacia región epigástrica y base del
        cuello. El paciente refiere clínica acompañante de sudoración profusa y
        náuseas asociadas, aunque no ha presentado ningún vómito.
    </p>
</div>
