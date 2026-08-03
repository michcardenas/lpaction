{{-- Contenido de la etapa "Resumen del caso" (última) --}}
<div class="riesgo">
    <h1 class="h-caso">Resumen del caso</h1>

    <div class="resumen-card">
        <div class="resumen-head">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 14h6"/><path d="M9 17h6"/></svg>
            <span class="resumen-title">Antes de finalizar</span>
        </div>
        <p class="resumen-txt">Descarga y revisa el caso con todas las opciones antes de avanzar al siguiente ingreso.</p>
        <a class="btn-descargar" href="{{ route('curso.descargar', $ingreso) }}" onclick="marcarCasoDescargado()">
            Descargar caso
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
        </a>
    </div>

    {{-- Finalizar ingreso: BLOQUEADO hasta pulsar "Descargar caso" (gate del cliente). --}}
    @php $gateOk = ($casoDescargado ?? false); @endphp
    <form method="POST" action="{{ route('curso.avanzar', $ingreso) }}" class="resumen-foot">
        @csrf
        <input type="hidden" name="desde" value="{{ $etapaActual }}">
        <button type="submit" class="btn-finalizar{{ $gateOk ? '' : ' is-locked' }}" @disabled(! $gateOk)
                title="{{ $gateOk ? '' : 'Descarga el caso para poder finalizar el ingreso' }}">
            Finalizar ingreso
        </button>
    </form>
</div>
