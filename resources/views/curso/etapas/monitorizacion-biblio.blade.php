{{-- Bibliografía de la etapa "Monitorización y seguimiento" (mismas 32 referencias) --}}
<h1 class="h-caso">Monitorización y seguimiento</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
