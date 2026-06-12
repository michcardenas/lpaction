{{-- Bibliografía de la etapa "Resumen del caso" (mismas 32 referencias) --}}
<h1 class="h-caso">Resumen del caso</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
