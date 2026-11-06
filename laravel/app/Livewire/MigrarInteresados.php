<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Archivos;
use App\Support\ImportarInteresados;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;

/**
 * Migrar interesados: toma la ultima matriz de la entidad, la revisa sin grabar y, si no hay errores y el
 * usuario confirma, la migra (App\Support\ImportarInteresados).
 */
class MigrarInteresados extends Component
{
    public const TABLA = 'migrar_INTERESADOS';

    /** Proyecto desde el que se abrio: el archivo puede traer otros */
    #[Locked]
    public int $proyecto;

    #[Locked]
    public ?int $archivoRevisado = null;

    #[Locked]
    public ?array $revision = null;

    #[Locked]
    public ?array $resultado = null;

    #[Locked]
    public ?string $error = null;

    public bool $entendido = false;

    public function mount(int $proyecto): void
    {
        $this->proyecto = $proyecto;
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

    public function archivo(): ?object
    {
        return DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', self::TABLA)->where('IDE_REGISTRO', ImportarInteresados::REGISTRO)
            ->where('EST_ARCHIVO', '<>', '2')->orderByDesc('IDE_ARCHIVO')->first();
    }

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
            $this->revision = ImportarInteresados::revisar(ImportarInteresados::leer(Archivos::rutaReal($archivo)), $this->proyecto);
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
            $resultado = ImportarInteresados::importar(Archivos::rutaReal($archivo), $this->proyecto);
            $this->limpiar();
            $this->resultado = $resultado;
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Interesados migrados.');
        } catch (RuntimeException $e) {
            $this->entendido = false;
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        $archivo = $this->archivo();

        return view('livewire.migrar-interesados', [
            'archivo' => $archivo,
            'importable' => $this->esImportable($archivo),
            'puedeGrabar' => app(Seguridad::class)->puedeGrabar(),
        ]);
    }
}
