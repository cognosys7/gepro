@extends('layouts.embebido')

{{-- MIGRAR INTERESADOS (SE ABRE EN LA VENTANA MODAL) --}}
@section('contenido')
    <div class="gp-embebido-cabecera">
        <div>
            <span class="gp-etiqueta-tipo"><i class="fa-solid fa-file-import"></i> Migrar interesados</span>
            <strong>{{ trim((string) $proyecto->COD_INTERNO) }}</strong>
        </div>
        <p>{{ $proyecto->DES_LARGA_PROYECTO }}</p>
    </div>
    <livewire:migrar-interesados :proyecto="(int) $proyecto->IDE_PROYECTO" />
@endsection
