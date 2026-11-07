{{-- Resumen de lo que falta: $etiquetas = nombre del campo => etiqueta. Al aparecer, lleva al primer campo marcado --}}
@php
    $faltan = collect($errors->keys())->filter(fn ($k) => str_starts_with($k, 'datos.'))
        ->map(fn ($k) => $etiquetas[substr($k, 6)] ?? null)->filter()->values();
    $lista = $faltan->count() > 1 ? $faltan->slice(0, -1)->implode(', ').' y '.$faltan->last() : $faltan->implode('');
@endphp
@if ($faltan->isNotEmpty())
    <p class="fm-aviso fm-aviso-error" wire:key="resumen-{{ md5($lista) }}"
        x-init="$nextTick(() => $el.closest('.fm-panel')?.querySelector('.fm-con-error input, .fm-con-error select, .fm-con-error textarea')?.focus())">
        <i class="fa-solid fa-triangle-exclamation"></i>
        Falta revisar {{ $faltan->count() === 1 ? '1 dato' : $faltan->count().' datos' }}: {{ $lista }}.
    </p>
@endif
