{{-- Perfiles activos con acceso a la opcion ($o->perfiles) --}}
@php($n = (int) $o->perfiles)
<span @class(['op-perfiles', 'op-perfiles-ninguno' => $n === 0]) title="Perfiles con acceso (se asignan en Acceso)">
    <i class="fa-solid fa-user-shield"></i> {{ $n === 0 ? 'Sin perfiles' : $n.' '.($n === 1 ? 'perfil' : 'perfiles') }}
</span>
