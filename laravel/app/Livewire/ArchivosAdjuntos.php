<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Archivos;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use RuntimeException;

/**
 * Archivos adjuntos de un registro (GEN_ARCHIVO, SP_GEN_ARCHIVO): lista, sube, cambia el estado
 * (ACTUAL / VERSION HISTORICA) o reemplaza el archivo, elimina y descarga.
 */
class ArchivosAdjuntos extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Locked]
    public string $tabla;

    #[Locked]
    public string $registro;

    public string $buscar = '';

    public bool $abierto = false;

    #[Locked]
    public ?string $idArchivo = null;

    public $archivo = null;

    public string $estado = '1';

    public function mount(string $tabla, string $registro): void
    {
        abort_unless(Archivos::tabla($tabla), 404);
        $this->tabla = $tabla;
        $this->registro = $registro;
    }

    public function puedeGrabar(): bool
    {
        return app(Seguridad::class)->puedeGrabar();
    }

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    private function fila(string $id): ?object
    {
        return DB::table('dbo.GEN_ARCHIVO')->where('IDE_ARCHIVO', $id)->where('IDE_TABLA', $this->tabla)
            ->where('IDE_REGISTRO', $this->registro)->where('EST_ARCHIVO', '<>', '2')->first();
    }

    /** Estados del archivo (GEN_TABLAS 94), sin "ELIMINADO" */
    public function estados(): array
    {
        return DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', '94')->where('COD_ITEM', '<>', '2')->orderBy('COD_ITEM')
            ->pluck('DES_ITEM', 'COD_ITEM')->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
    }

    public function nuevo(): void
    {
        if (! $this->puedeGrabar()) {
            return;
        }
        $this->resetValidation();
        $this->idArchivo = null;
        $this->archivo = null;
        $this->estado = '1';
        $this->abierto = true;
    }

    public function editar(string $id): void
    {
        $fila = $this->fila($id);
        if (! $fila) {
            return;
        }
        $this->resetValidation();
        $this->idArchivo = (string) (int) $fila->IDE_ARCHIVO;
        $this->archivo = null;
        $this->estado = trim((string) $fila->EST_ARCHIVO);
        $this->abierto = true;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->archivo = null;
        $this->resetValidation();
    }

    public function guardar(): void
    {
        if (! $this->puedeGrabar()) {
            throw ValidationException::withMessages(['general' => 'No tiene permiso para grabar.']);
        }
        $actual = $this->idArchivo !== null ? $this->fila($this->idArchivo) : null;
        if ($this->idArchivo !== null && ! $actual) {
            throw ValidationException::withMessages(['general' => 'El archivo ya no existe.']);
        }
        $this->validate([
            'archivo' => [$actual ? 'nullable' : 'required', 'file', 'max:'.(int) config('gepro.archivos.max_kb'),
                'extensions:'.implode(',', config('gepro.archivos.extensiones'))],
            'estado' => ['required', Rule::in(array_map('strval', array_keys($this->estados())))],
        ], [], ['archivo' => 'archivo', 'estado' => 'estado']);

        [$carpeta] = Archivos::tabla($this->tabla);
        $nombre = $actual ? trim((string) $actual->DES_ARCHIVO) : '';
        $copiado = null;
        if ($this->archivo) {
            $nombre = Archivos::nombreGuardado($this->archivo->getClientOriginalName());
            $copiado = Archivos::carpetaFisica($carpeta).DIRECTORY_SEPARATOR.$nombre;
            if (! copy($this->archivo->getRealPath(), $copiado)) {
                throw ValidationException::withMessages(['general' => 'No se pudo guardar el archivo en el servidor.']);
            }
        }
        $parametros = [
            'IDE_TABLA' => $this->tabla,
            'IDE_REGISTRO' => $this->registro,
            'DES_RUTA' => $actual ? (string) $actual->DES_RUTA : Archivos::rutaGuardada($carpeta),
            'DES_ARCHIVO' => $nombre,
            'EST_ARCHIVO' => $this->estado,
            'pUsuario' => (int) Auth::id(),
        ];
        try {
            if ($actual) {
                Procedimiento::grabar('dbo.SP_GEN_ARCHIVO', 'Update', ['pCodigo' => $this->idArchivo] + $parametros);
            } else {
                Procedimiento::grabar('dbo.SP_GEN_ARCHIVO', 'Insert', $parametros);
            }
        } catch (RuntimeException $e) {
            //SI EL SP FALLA, NO QUEDA UN ARCHIVO SUELTO EN LA CARPETA
            if ($copiado && is_file($copiado)) {
                unlink($copiado);
            }
            throw ValidationException::withMessages(['general' => 'No se pudo grabar: '.$e->getMessage()]);
        }

        $this->cerrar();
        $this->dispatch('aviso', tipo: 'ok', mensaje: $actual ? 'Archivo actualizado.' : 'Archivo cargado.');
    }

    public function eliminar(string $id): void
    {
        if (! $this->puedeGrabar() || ! $this->fila($id)) {
            return;
        }
        try {
            //COMO EL SISTEMA ACTUAL: EL REGISTRO QUEDA CON ESTADO 2 Y EL ARCHIVO SE CONSERVA EN LA CARPETA
            Procedimiento::grabar('dbo.SP_GEN_ARCHIVO', 'Delete', ['pCodigo' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Archivo eliminado.');
        } catch (RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    public function render()
    {
        $texto = trim($this->buscar);
        $filas = DB::table('dbo.GEN_ARCHIVO')
            ->where('IDE_TABLA', $this->tabla)->where('IDE_REGISTRO', $this->registro)->where('EST_ARCHIVO', '<>', '2')
            ->when($texto !== '', fn ($q) => $q->where('DES_ARCHIVO', 'like', '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%'))
            ->orderByDesc('FEC_CARGA')->orderByDesc('IDE_ARCHIVO')
            ->paginate(10, ['IDE_ARCHIVO', 'DES_ARCHIVO', 'FEC_CARGA', 'EST_ARCHIVO']);

        return view('livewire.archivos-adjuntos', ['filas' => $filas, 'estados' => $this->estados() + ['2' => 'ELIMINADO']]);
    }
}
