{{-- Bibliografía de la etapa "Monitorización y seguimiento 2" — INGRESO 2 (34 referencias) --}}
<h1 class="h-caso">Monitorización y seguimiento 2</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia_2'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
