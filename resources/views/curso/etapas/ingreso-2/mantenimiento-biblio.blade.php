{{-- Bibliografía de la etapa "Terapia de mantenimiento al alta de rehabilitación cardiaca" — INGRESO 2 (34 referencias) --}}
<h1 class="h-caso">Terapia de mantenimiento al alta de rehabilitación cardiaca</h1>
<h2 class="biblio-h">Bibliografía</h2>
<div class="biblio-list">
    @foreach ($curso['bibliografia_2'] as $i => $ref)
        <p class="biblio-item">{{ $i + 1 }}. {{ $ref }}</p>
    @endforeach
</div>
