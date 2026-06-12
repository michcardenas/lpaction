{{-- Bibliografía de la etapa "Pruebas complementarias" (mismas 32 referencias) --}}
<h1 class="h-caso">Pruebas complementarias</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
