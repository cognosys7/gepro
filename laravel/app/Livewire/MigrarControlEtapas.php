<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Archivos;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Migrar control de etapas: elige el ultimo Excel del contrato y pide confirmar antes de importar.
 * La importacion sigue en el sistema actual (migrar_Importar_SQLSERVERvista.php): corre al abrir su
 * pagina, por eso el boton solo se habilita despues de confirmar.
 */
class MigrarControlEtapas extends Component
{
    public const TABLA = 'migrar_CONT_ETAPA_CONTROL';

    #[Locked]
    public int $contrato;

    public bool $entendido = false;

    public function mount(int $contrato): void
    {
        $this->contrato = $contrato;
    }

    /** Al cerrar una ventana (adjuntos o importacion) se vuelve a leer el archivo y a pedir confirmacion */
    #[On('gepro-modal-cerrada')]
    public function recargar(): void
    {
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

    public function urlImportar(): string
    {
        return app(Seguridad::class)->urlLegado('mainpage.php?'.http_build_query([
            'Pagina' => 'migrar_Importar_sqlserver', 'Accion' => 'muestraVista', 'AccionLocal' => 2,
            'PIDE' => $this->contrato, 'Tabla' => self::TABLA, 'vmSinCabecera' => 1,
        ]));
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
