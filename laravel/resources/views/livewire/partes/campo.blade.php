{{-- Campo del formulario: $c = [nombre, etiqueta, tipo (text|number|date|textarea|select), extra] --}}
@php
    $nombre = $c['nombre'];
    $extra = $c['extra'];
    $id = 'fm-'.$nombre;
    $bloqueado = $this->bloqueado($nombre);
    $error = $errors->first('datos.'.$nombre);
    //'live': EL VALOR SE ENVIA AL SALIR DEL CAMPO (P. EJ. PARA RECALCULAR MONTOS); LAS LISTAS, AL ELEGIR
    $modelo = empty($extra['live']) ? 'wire:model' : ($c['tipo'] === 'select' ? 'wire:model.live' : 'wire:model.live.blur');
    //TEXTO LARGO: SE ABRE MOSTRANDO SU CONTENIDO (CARACTERES POR LINEA SEGUN EL ANCHO DEL CAMPO; TOPE DE 16 LINEAS)
    $filas = $extra['filas'] ?? 2;
    if ($c['tipo'] === 'textarea') {
        $porLinea = str_contains($extra['clase'] ?? '', 'fm-completo') ? 100 : (str_contains($extra['clase'] ?? '', 'fm-ancho') ? 60 : 28);
        $lineas = 0;
        foreach (preg_split('/
||
/', (string) ($datos[$nombre] ?? '')) as $parrafo) {
            $lineas += max(1, (int) ceil(mb_strlen($parrafo) / $porLinea));
        }
        $filas = min(16, max($filas, $lineas));
    }
@endphp
<div @class(['fm-campo', $extra['clase'] ?? '', 'fm-con-error' => $error, 'fm-auto' => ! empty($extra['auto'])])>
    <label for="{{ $id }}">
        {{ $c['etiqueta'] }}
        @if ($bloqueado)<i class="fa-solid fa-lock fm-candado" title="No se puede modificar"></i>@endif
    </label>
    @if ($c['tipo'] === 'textarea')
        <textarea id="{{ $id }}" {{ $modelo }}="datos.{{ $nombre }}" rows="{{ $filas }}" maxlength="{{ $extra['maxlength'] ?? '' }}" @disabled($bloqueado)></textarea>
    @elseif ($c['tipo'] === 'select')
        <select id="{{ $id }}" {{ $modelo }}="datos.{{ $nombre }}" @disabled($bloqueado)>
            <option value="">Seleccione…</option>
            @foreach ($extra['opciones'] as $valor => $texto)
                <option value="{{ $valor }}">{{ $texto }}</option>
            @endforeach
        </select>
    @elseif ($c['tipo'] === 'buscador')
        {{-- LISTAS LARGAS: SE BUSCA AL ESCRIBIR Y SE ELIGE UN RESULTADO --}}
        @if (trim((string) ($datos[$nombre] ?? '')) !== '')
            <div class="fm-elegido">
                <span>{{ $this->etiquetaBuscador($nombre) }}</span>
                @unless ($bloqueado)
                    <button type="button" wire:click="quitar('{{ $nombre }}')" title="Cambiar"><i class="fa-solid fa-xmark"></i></button>
                @endunless
            </div>
        @elseif (! $bloqueado)
            @php($resultados = $this->resultados($nombre))
            @php($escrito = trim((string) ($buscando[$nombre] ?? '')))
            <input id="{{ $id }}" type="search" autocomplete="off" placeholder="Escriba para buscar…"
                wire:model.live.debounce.300ms="buscando.{{ $nombre }}" wire:keydown.enter.prevent>
            @if (mb_strlen($escrito) >= 2)
                <ul class="fm-resultados">
                    @forelse ($resultados as $clave => $texto)
                        <li wire:key="res-{{ $nombre }}-{{ $clave }}">
                            <button type="button" wire:click="elegir('{{ $nombre }}', {{ \Illuminate\Support\Js::from((string) $clave) }})">{{ $texto }}</button>
                        </li>
                    @empty
                        <li class="fm-sin-resultados">Sin resultados.</li>
                    @endforelse
                </ul>
            @endif
        @endif
    @else
        <input id="{{ $id }}" type="{{ $c['tipo'] }}" {{ $modelo }}="datos.{{ $nombre }}" @disabled($bloqueado)
            @isset($extra['maxlength']) maxlength="{{ $extra['maxlength'] }}" @endisset
            @isset($extra['min']) min="{{ $extra['min'] }}" @endisset
            @isset($extra['step']) step="{{ $extra['step'] }}" @endisset>
    @endif
    @if (! empty($extra['ayuda']))<p class="fm-ayuda">{{ $extra['ayuda'] }}</p>@endif
    @if ($error)<p class="fm-error">{{ $error }}</p>@endif
</div>
