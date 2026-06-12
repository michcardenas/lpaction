{{-- Bibliografía de la etapa "Puntos clave" (mismas 32 referencias) --}}
<h1 class="h-caso">Puntos clave</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
