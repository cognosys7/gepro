{{-- Campo del formulario: $c = [nombre, etiqueta, tipo (text|number|date|textarea|select), extra] --}}
@php
    $nombre = $c['nombre'];
    $extra = $c['extra'];
    $id = 'fm-'.$nombre;
    $bloqueado = $this->bloqueado($nombre);
    $error = $errors->first('datos.'.$nombre);
@endphp
<div @class(['fm-campo', $extra['clase'] ?? '', 'fm-con-error' => $error])>
    <label for="{{ $id }}">
        {{ $c['etiqueta'] }}
        @if ($bloqueado)<i class="fa-solid fa-lock fm-candado" title="No se puede modificar"></i>@endif
    </label>
    @if ($c['tipo'] === 'textarea')
        <textarea id="{{ $id }}" wire:model="datos.{{ $nombre }}" rows="{{ $extra['filas'] ?? 2 }}" maxlength="{{ $extra['maxlength'] ?? '' }}" @disabled($bloqueado)></textarea>
    @elseif ($c['tipo'] === 'select')
        <select id="{{ $id }}" wire:model="datos.{{ $nombre }}" @disabled($bloqueado)>
            <option value="">Seleccione…</option>
            @foreach ($extra['opciones'] as $valor => $texto)
                <option value="{{ $valor }}">{{ $texto }}</option>
            @endforeach
        </select>
    @else
        <input id="{{ $id }}" type="{{ $c['tipo'] }}" wire:model="datos.{{ $nombre }}" @disabled($bloqueado)
            @isset($extra['maxlength']) maxlength="{{ $extra['maxlength'] }}" @endisset
            @isset($extra['min']) min="{{ $extra['min'] }}" @endisset
            @isset($extra['step']) step="{{ $extra['step'] }}" @endisset>
    @endif
    @if ($error)<p class="fm-error">{{ $error }}</p>@endif
</div>
