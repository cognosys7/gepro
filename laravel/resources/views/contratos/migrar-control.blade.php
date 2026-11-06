@extends('layouts.embebido')

{{-- MIGRAR CONTROL DE ETAPAS DE UN CONTRATO (SE ABRE EN LA VENTANA MODAL) --}}
@section('contenido')
    <div class="gp-embebido-cabecera">
        <div>
            <span class="gp-etiqueta-tipo"><i class="fa-solid fa-file-import"></i> Migrar control de etapas</span>
            <strong>{{ trim((string) $contrato->COD_PROYECTO) }}</strong>
        </div>
        <p>{{ $contrato->DES_PROYECTO }}</p>
    </div>
    <livewire:migrar-control-etapas :contrato="(int) $contrato->IDE_PROYECTO_ACTIVIDAD" />
@endsection
