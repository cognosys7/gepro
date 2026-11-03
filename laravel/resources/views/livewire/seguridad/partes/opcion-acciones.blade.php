{{-- Acciones de una opcion del menu ($o): subir, bajar, editar y eliminar --}}
<div class="op-acciones">
    <button type="button" class="gr-ico gr-gris" title="Subir" wire:click="mover({{ (int) $o->idopcion }}, true)" @disabled($o->primera)><i class="fa-solid fa-arrow-up"></i></button>
    <button type="button" class="gr-ico gr-gris" title="Bajar" wire:click="mover({{ (int) $o->idopcion }}, false)" @disabled($o->ultima)><i class="fa-solid fa-arrow-down"></i></button>
    <button type="button" class="gr-ico gr-ambar" title="Editar" wire:click="editar({{ (int) $o->idopcion }})"><i class="fa-solid fa-pen"></i></button>
    <button type="button" class="gr-ico gr-rojo" title="Eliminar" wire:click="eliminar({{ (int) $o->idopcion }})"
        wire:confirm="¿Eliminar la opción {{ trim((string) $o->opcdescripcion) }}? Dejará de verse en el menú."><i class="fa-solid fa-trash-can"></i></button>
</div>
