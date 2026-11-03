{{-- Paginas de la grilla ($filas: LengthAwarePaginator) --}}
@if ($filas->lastPage() > 1)
    <nav class="gp-paginas" aria-label="Páginas">
        <span>Mostrando {{ $filas->firstItem() }}–{{ $filas->lastItem() }} de {{ number_format($filas->total()) }}</span>
        <div>
            <button type="button" wire:click="gotoPage(1)" @disabled($filas->onFirstPage()) title="Primera"><i class="fa-solid fa-angles-left"></i></button>
            <button type="button" wire:click="previousPage" @disabled($filas->onFirstPage()) title="Anterior"><i class="fa-solid fa-angle-left"></i></button>
            @foreach (range(max(1, $filas->currentPage() - 2), min($filas->lastPage(), $filas->currentPage() + 2)) as $p)
                <button type="button" wire:click="gotoPage({{ $p }})" @class(['gp-pagina-actual' => $p === $filas->currentPage()])>{{ $p }}</button>
            @endforeach
            <button type="button" wire:click="nextPage" @disabled(! $filas->hasMorePages()) title="Siguiente"><i class="fa-solid fa-angle-right"></i></button>
            <button type="button" wire:click="gotoPage({{ $filas->lastPage() }})" @disabled(! $filas->hasMorePages()) title="Última"><i class="fa-solid fa-angles-right"></i></button>
        </div>
    </nav>
@endif
