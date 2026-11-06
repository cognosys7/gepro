<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Archivos;
use App\Support\ImportarControl;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;

/**
 * Migrar control de etapas: elige el ultimo Excel del contrato, lo revisa sin grabar y, si no hay
 * errores y el usuario confirma, lo migra (App\Support\ImportarControl).
 */
class MigrarControlEtapas extends Component
{
    public const TABLA = 'migrar_CONT_ETAPA_CONTROL';

    #[Locked]
    public int $contrato;

    /** Archivo revisado: si cambia, hay que volver a revisar */
    #[Locked]
    public ?int $archivoRevisado = null;

    #[Locked]
    public ?array $revision = null;

    #[Locked]
    public ?array $resultado = null;

    #[Locked]
    public ?string $error = null;

    public bool $entendido = false;

    public function mount(int $contrato): void
    {
        $this->contrato = $contrato;
    }

    /** Al cerrar la ventana de adjuntos se vuelve a leer el archivo */
    #[On('gepro-modal-cerrada')]
    public function recargar(): void
    {
        $this->limpiar();
    }

    private function limpiar(): void
    {
        $this->archivoRevisado = null;
        $this->revision = null;
        $this->error = null;
        $this->entendido = false;
    }

    /** Ultimo archivo no eliminado del contrato (Archivo_Datos 'max' del sistema actual) */
    public function archivo(): ?object
    {
        return DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', self::TABLA)->where('IDE_REGISTRO', $this->contrato)
            ->where('EST_ARCHIVO', '<>', '2')->orderByDesc('IDE_ARCHIVO')->first();
    }

    /** Si el archivo se puede importar: existe en el disco y es un Excel */
    public function esImportable(?object $archivo): bool
    {
        return $archivo && Archivos::rutaReal($archivo)
            && in_array(strtolower(pathinfo((string) $archivo->DES_ARCHIVO, PATHINFO_EXTENSION)), ['xls', 'xlsx', 'xlsm'], true);
    }

    /** Lee el archivo y muestra lo que encontro, sin grabar nada */
    public function revisar(): void
    {
        $this->limpiar();
        $this->resultado = null;
        $archivo = $this->archivo();
        if (! $this->esImportable($archivo)) {
            $this->error = 'No se puede usar este archivo: no está en el servidor o no es un Excel.';

            return;
        }
        try {
            $this->revision = ImportarControl::revisar(ImportarControl::leer(Archivos::rutaReal($archivo)), $this->contrato);
            $this->archivoRevisado = (int) $archivo->IDE_ARCHIVO;
        } catch (RuntimeException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function puedeMigrar(): bool
    {
        return $this->revision !== null && ! $this->revision['errores'] && $this->entendido;
    }

    public function migrar(): void
    {
        $archivo = $this->archivo();
        if (! app(Seguridad::class)->puedeGrabar() || ! $this->puedeMigrar()) {
            return;
        }
        if (! $this->esImportable($archivo) || (int) $archivo->IDE_ARCHIVO !== $this->archivoRevisado) {
            $this->limpiar();
            $this->error = 'El archivo cambió después de la revisión. Revíselo de nuevo.';

            return;
        }
        try {
            $resultado = ImportarControl::importar(Archivos::rutaReal($archivo), $this->contrato);
            $this->limpiar();
            $this->resultado = $resultado;
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Control de etapas migrado.');
        } catch (RuntimeException $e) {
            $this->entendido = false;
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        $archivo = $this->archivo();

        return view('livewire.migrar-control-etapas', [
            'archivo' => $archivo,
            'importable' => $this->esImportable($archivo),
            'puedeGrabar' => app(Seguridad::class)->puedeGrabar(),
        ]);
    }
}
