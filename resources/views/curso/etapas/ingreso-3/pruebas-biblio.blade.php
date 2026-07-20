{{-- Bibliografía de la etapa "Pruebas complementarias" — INGRESO 3 (34 referencias) --}}
<h1 class="h-caso">Pruebas complementarias</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia_3'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
