{{-- Cuestionario reutilizable (respuesta única). Recibe $pregunta; usa $ingreso, $esUltimaEtapa del padre. --}}
@php
    // Nota DEV: "Repetir etapa" SOLO se desbloquea al re-evaluar (la etapa ya fue completada
    // —estado perfecta/error— y el usuario volvió). En el primer intento (activa) queda oculto.
    $estadoEtapa = data_get(collect($etapasEstado ?? [])->firstWhere('key', $etapaActual), 'estado', 'activa');
    $reevaluando = in_array($estadoEtapa, ['perfecta', 'error']);
@endphp
<div class="pregunta-card" id="cuestionario" data-xp="{{ $pregunta['xp'] }}" data-reevaluando="{{ $reevaluando ? '1' : '0' }}">
    <div class="pregunta-head">
        <p class="pregunta-q">{{ $pregunta['enunciado'] }}</p>
        <p class="pregunta-sub">{{ $pregunta['instruccion'] }}</p>
    </div>

    <div class="pregunta-opts">
        @foreach ($pregunta['opciones'] as $op)
            <label class="opt" data-correcta="{{ $op['correcta'] ? '1' : '0' }}" data-puntos="{{ $op['puntos'] }}" data-justif="{{ $op['justificacion'] }}">
                <input type="radio" name="pregunta" value="{{ $op['key'] }}">
                <span class="opt-mark"></span>
                <span class="opt-txt">{{ $op['texto'] }}</span>
            </label>
        @endforeach
    </div>

    {{-- Justificación (tras comprobar) --}}
    <div class="justif" hidden>
        <p class="justif-h">Justificación</p>
        <p class="justif-txt"></p>
        <button type="button" class="justif-toggle" aria-label="Colapsar justificación" aria-expanded="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
        </button>
    </div>

    {{-- Barra de resultado (tras comprobar) --}}
    <div class="resultado" hidden>
        <span class="resultado-ico"></span>
        <span class="resultado-txt"></span>
    </div>

    {{-- Footer --}}
    <div class="pregunta-foot">
        <button type="button" class="btn-repetir" hidden>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 2.6-6.4L3 8"/><path d="M3 3v5h5"/></svg>
            Repetir etapa
        </button>
        <span class="foot-spacer"></span>
        <button type="button" class="btn-comprobar" hidden>Comprobar</button>
        <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" class="form-siguiente">
            @csrf
            <input type="hidden" name="desde" value="{{ $etapaActual }}">
            <input type="hidden" name="verde" value="0" id="cuest-verde">
            <input type="hidden" name="rojo" value="0" id="cuest-rojo">
            <button type="submit" class="btn-next-q">{{ $esUltimaEtapa ? 'Finalizar' : 'Siguiente etapa' }}</button>
        </form>
    </div>
</div>
