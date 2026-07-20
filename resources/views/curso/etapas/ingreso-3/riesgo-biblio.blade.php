{{-- Bibliografía de la etapa "Evaluación del riesgo cardiovascular" — INGRESO 3 (34 referencias) --}}
<h1 class="h-caso">Evaluación del riesgo cardiovascular</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia_3'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
