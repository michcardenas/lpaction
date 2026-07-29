{{-- Contenido de la etapa "Pruebas complementarias" — INGRESO 3 (editable desde el panel) --}}
@php
    $k = 'curso.cont.ingreso-3.pruebas.';
    $tcImg = cms_img($k.'img_tc', 'images/tc-craneal-ingreso3.jpg');
@endphp
<div class="pruebas tabs-scope">
    <h1 class="h-caso">{{ cms($k.'h1', 'Pruebas complementarias') }}</h1>

    {{-- Tabs de pruebas (slider horizontal si no caben) --}}
    <div class="tabs">
        <button type="button" class="tab on" data-tab="tc">{{ cms($k.'tab_tc', 'TC craneal') }}</button>
        <button type="button" class="tab" data-tab="angiotc">{{ cms($k.'tab_angiotc', 'Angio-TC') }}</button>
        <button type="button" class="tab" data-tab="rm">{{ cms($k.'tab_rm', 'RM cerebral') }}</button>
        <button type="button" class="tab" data-tab="revasc">{{ cms($k.'tab_revasc', 'Revascularización') }}</button>
        <button type="button" class="tab" data-tab="analitica">{{ cms($k.'tab_analitica', 'Analítica sanguínea') }}</button>
    </div>

    {{-- Panel TC craneal --}}
    <div class="tab-panel prueba-panel" data-panel="tc">
        <div class="ecg-block">
            <h3 class="prueba-h">{{ cms($k.'tc_h', 'Tomografía computarizada (TC) craneal') }}</h3>
            <div class="ecg-frame is-cuadrada">
                <button type="button" class="ecg-icon ecg-expand" aria-label="Ampliar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                </button>
                <img src="{{ $tcImg }}" onerror="this.onerror=null;this.src='{{ asset('images/ecg.png') }}'" alt="TC craneal sin contraste">
                <a class="ecg-icon ecg-download" href="{{ $tcImg }}" download aria-label="Descargar imagen">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
                </a>
            </div>
            <p class="ecg-caption">{{ cms($k.'tc_cap', 'Figura 1. TC craneal sin contraste: ausencia de hemorragia intracraneal y de signos de infarto agudo en territorio arterial definido.') }}</p>
        </div>
    </div>

    {{-- Panel Angio-TC --}}
    <div class="tab-panel prueba-panel" data-panel="angiotc" style="display:none">
        <div class="cat-block">
            <h3 class="prueba-h">{{ cms($k.'angiotc_h', 'Angio-TC de vasos intracraneales y supraaórticos') }}</h3>
            <div class="prueba-p rich-p">{!! cms($k.'angiotc_p') !!}</div>
        </div>
    </div>

    {{-- Panel RM cerebral --}}
    <div class="tab-panel prueba-panel" data-panel="rm" style="display:none">
        <div class="cat-block">
            <h3 class="prueba-h">{{ cms($k.'rm_h', 'Resonancia magnética (RM) cerebral a las 48 horas') }}</h3>
            <div class="prueba-p rich-p">{!! cms($k.'rm_p') !!}</div>
        </div>
    </div>

    {{-- Panel Revascularización --}}
    <div class="tab-panel prueba-panel" data-panel="revasc" style="display:none">
        <div class="cat-block">
            <h3 class="prueba-h">{{ cms($k.'revasc_h', 'Revascularización') }}</h3>
            <div class="prueba-p rich-p">{!! cms($k.'revasc_p') !!}</div>
        </div>
    </div>

    {{-- Panel Analítica --}}
    <div class="tab-panel prueba-panel" data-panel="analitica" style="display:none">
        <div class="analitica-block">
            <h3 class="prueba-h">{{ cms($k.'ana_h', 'Analítica sanguínea') }}</h3>
            {!! cms($k.'ana_list') !!}
        </div>
    </div>

    {{-- Cuestionario (Pregunta 1 del Ingreso 3) --}}
    @include('curso.etapas._cuestionario', ['pregunta' => $curso['pregunta_pruebas_3']])
</div>
