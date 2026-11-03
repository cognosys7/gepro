@extends('layouts.embebido')

@section('contenido')
    <div class="gp-embebido-cabecera">
        <div>
            <span class="gp-etiqueta-tipo">{{ $nombreTipo ? 'Contratos de '.mb_strtolower($nombreTipo) : 'Todos los contratos' }}</span>
            <strong>{{ trim($proyecto->COD_INTERNO) }}</strong>
            @if (trim((string) $proyecto->COD_UNICO) !== '')<span class="gp-cui">CUI {{ trim($proyecto->COD_UNICO) }}</span>@endif
        </div>
        <p>{{ $proyecto->DES_LARGA_PROYECTO }}</p>
    </div>
    <livewire:proyecto-contratos-tabla :proyecto="(int) $proyecto->IDE_PROYECTO" :opcion="$opcion" :tipo="$tipo" />
    <livewire:proyecto-contrato-formulario :proyecto="(int) $proyecto->IDE_PROYECTO" :opcion="$opcion" />
@endsection
