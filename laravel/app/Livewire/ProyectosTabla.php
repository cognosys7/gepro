<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Grilla de Proyectos (reemplaza Flexigrid + SelGrd_PROYECTO<Opcion> de dbo.SP_PROYECTO).
 * - Mismos datos: dbo.PROYECTO no anulados (EST_PROYECTO <> '2') y sin CUI duplicado (dbo.FN_PROYECTO(1)).
 * - Busqueda con parametros (el SP concatenaba el filtro) y orden aplicado antes de paginar
 *   (el SP ordenaba solo la pagina visible).
 * - Las acciones de cada fila dependen de la opcion del menu (Proyecto_BotonVer en PROYECTOlni.php)
 *   y abren las pantallas del sistema actual en una ventana modal.
 */
class ProyectosTabla extends Component
{
    use WithPagination;

    #[Locked]
    public int $opcion = 110;

    #[Url(as: 'q', except: '')]
    public string $buscar = '';

    #[Url(as: 'orden', except: 'COD_INTERNO')]
    public string $orden = 'COD_INTERNO';

    #[Url(as: 'dir', except: 'asc')]
    public string $direccion = 'asc';

    #[Url(as: 'n', except: 10)]
    public int $porPagina = 10;

    /** Columnas que se pueden ordenar (lista cerrada: nunca se ordena por texto del usuario) */
    public const COLUMNAS = [
        'COD_INTERNO' => 'Código',
        'COD_UNICO' => 'Código Único',
        'DES_LARGA_PROYECTO' => 'Descripción Larga',
    ];

    /**
     * Acciones de la fila: titulo, icono (Font Awesome 6), color (.gr-ico) y pantalla del sistema
     * actual que abren (Pagina + parametros; {id} = IDE_PROYECTO, {opcion} = opcion del menu).
     * Son las funciones de gepro/recursos/js/PROYECTO.js.
     */
    public const ACCIONES = [
        'pip' => ['Proyecto de inversión', 'fa-sack-dollar', 'gr-verde', 'PROY_PIP', ['PIDE' => '{id}']],
        'ubigeo' => ['Lugares beneficiados (UBIGEO)', 'fa-location-dot', 'gr-azul', 'PROY_ACT_UBIGEO', ['PIDE_PROYECTO_ACTIVIDAD' => '{id}']],
        'contrato' => ['Contratos del proyecto', 'fa-file-contract', 'gr-azul', 'PROYECTO_ACTIVIDAD', ['Opcion' => '{opcion}', 'PIDE' => '{id}', 'Pfiltro' => 0]],
        'estudios' => ['Contratos de estudios', 'fa-book', 'gr-azul', 'PROYECTO_ACTIVIDAD', ['Opcion' => '{opcion}', 'PIDE' => '{id}', 'Pfiltro' => 1]],
        'obras' => ['Contratos de obras', 'fa-building', 'gr-ambar', 'PROYECTO_ACTIVIDAD', ['Opcion' => '{opcion}', 'PIDE' => '{id}', 'Pfiltro' => 2]],
        'supervision' => ['Contratos de supervisión', 'fa-eye', 'gr-teal', 'PROYECTO_ACTIVIDAD', ['Opcion' => '{opcion}', 'PIDE' => '{id}', 'Pfiltro' => 3]],
        'postcierre' => ['Contratos de post-cierre', 'fa-leaf', 'gr-verde', 'PROYECTO_ACTIVIDAD', ['Opcion' => '{opcion}', 'PIDE' => '{id}', 'Pfiltro' => 4]],
        'otros' => ['Otros contratos', 'fa-ellipsis', 'gr-gris', 'PROYECTO_ACTIVIDAD', ['Opcion' => '{opcion}', 'PIDE' => '{id}', 'Pfiltro' => 5]],
        'social' => ['Gestión social (beneficiarios)', 'fa-users', 'gr-violeta', 'PROY_GESTION_SOCIAL', ['PIDE' => '{id}']],
        'leccion' => ['Lecciones aprendidas', 'fa-lightbulb', 'gr-ambar', 'PROY_LECCION_APRENDIDA', ['PIDE' => '{id}']],
        'comunicacion' => ['Comunicaciones', 'fa-comments', 'gr-azul', 'PROY_COMUNICACION', ['PIDE' => '{id}']],
        'migrar' => ['Migrar interesados', 'fa-file-import', 'gr-verde', 'migrar_CONT_INTERESADOS', ['PIDE' => '{id}', 'Tabla' => 'migrar_CONT_INTERESADOS']],
    ];

    /**
     * Acciones visibles por opcion del menu. En Proyecto_BotonVer el valor 'false' es "no ocultar"
     * (hide de Flexigrid); aqui se listan directamente las columnas que se ven.
     * "Migrar interesados" se ve donde se ve Gestion social (en la vista usa el mismo indicador).
     */
    public const POR_OPCION = [
        10 => ['pip', 'ubigeo', 'contrato', 'social', 'migrar', 'leccion', 'comunicacion'],
        110 => ['pip', 'ubigeo', 'sigam'],
        200 => ['pip', 'ubigeo', 'contrato', 'social', 'migrar', 'leccion', 'comunicacion'],
        210 => ['contrato'],
        211 => ['estudios', 'obras', 'supervision', 'postcierre', 'otros', 'social', 'migrar', 'leccion', 'ficha'],
        212 => ['contrato'],
        213 => ['contrato'],
        214 => ['contrato'],
        215 => ['contrato'],
        216 => ['contrato'],
        217 => ['contrato'],
        310 => ['estudios', 'obras', 'supervision', 'postcierre', 'otros', 'social', 'migrar'],
        410 => ['leccion'],
        510 => ['comunicacion'],
    ];

    /**
     * Registrar, editar y eliminar segun la opcion del menu (Proyecto_BotonVer: Nuevo solo en 110;
     * Editar donde su valor es 'false'; Eliminar solo en 10 y 200).
     */
    public const EDICION = [
        'nuevo' => [110],
        'editar' => [10, 110, 200, 210, 211, 212, 214, 215, 216],
        'eliminar' => [10, 200],
    ];

    public function mount(int $opcion): void
    {
        $this->opcion = array_key_exists($opcion, self::POR_OPCION) ? $opcion : 110;
        $this->validarOrden();
    }

    public function puede(string $accion): bool
    {
        //ADEMAS DE LA OPCION DEL MENU, EL PERFIL "CONSULTA TOTAL" NO GRABA NI ELIMINA
        return in_array($this->opcion, self::EDICION[$accion] ?? [], true)
            && app(\App\Services\Seguridad::class)->puedeGrabar();
    }

    #[On('proyecto-guardado')]
    public function recargar(): void
    {
        //SOLO VUELVE A DIBUJAR LA GRILLA CON LOS DATOS GRABADOS
    }

    /** Baja logica con dbo.SP_PROYECTO 'Delete' (EST_PROYECTO = '2'), como el sistema actual */
    public function eliminar(int $id): void
    {
        if (! $this->puede('eliminar')) {
            return;
        }
        try {
            Procedimiento::grabar('dbo.SP_PROYECTO', 'Delete', ['pCodigo' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Proyecto eliminado.');
        } catch (\RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    public function updatedPorPagina(): void
    {
        if (! in_array($this->porPagina, [10, 25, 50, 100], true)) {
            $this->porPagina = 10;
        }
        $this->resetPage();
    }

    public function ordenarPor(string $columna): void
    {
        if (! array_key_exists($columna, self::COLUMNAS)) {
            return;
        }
        $this->direccion = $this->orden === $columna && $this->direccion === 'asc' ? 'desc' : 'asc';
        $this->orden = $columna;
        $this->resetPage();
    }

    private function validarOrden(): void
    {
        if (! array_key_exists($this->orden, self::COLUMNAS)) {
            $this->orden = 'COD_INTERNO';
        }
        $this->direccion = $this->direccion === 'desc' ? 'desc' : 'asc';
    }

    /** URL de la pantalla que abre una accion para un proyecto */
    public function urlAccion(string $accion, object $fila): ?string
    {
        if ($accion === 'sigam') {
            return str_replace('{codigo}', rawurlencode(trim((string) $fila->COD_INTERNO)), config('gepro.enlaces.sigam'));
        }
        if ($accion === 'ficha') {
            return config('gepro.enlaces.ficha_tecnica').(int) $fila->IDE_PROYECTO.'.php';
        }
        [, , , $pagina, $parametros] = self::ACCIONES[$accion];
        if ($accion === 'migrar') {
            return route('proyectos.migrar-interesados', ['proyecto' => (int) $fila->IDE_PROYECTO, 'opcion' => $this->opcion]);
        }
        //CONTRATOS DEL PROYECTO: YA ESTAN EN LARAVEL (ProyectoContratosTabla)
        if ($pagina === 'PROYECTO_ACTIVIDAD') {
            return route('proyectos.contratos', ['proyecto' => (int) $fila->IDE_PROYECTO, 'opcion' => $this->opcion, 'tipo' => (int) $parametros['Pfiltro']]);
        }
        //LAS DEMAS SON PANTALLAS DE config/catalogos.php (P. EJ. LECCIONES APRENDIDAS)
        return route('catalogos.index', ['pagina' => $pagina, 'de' => (int) $fila->IDE_PROYECTO]);
    }

    public function render()
    {
        $this->validarOrden();
        $texto = trim($this->buscar);

        $proyectos = DB::table('dbo.PROYECTO as T')
            ->where('T.EST_PROYECTO', '<>', '2')
            ->whereIn('T.IDE_PROYECTO', DB::table(DB::raw('dbo.FN_PROYECTO(1) as F'))->select('F.IDE_PROYECTO'))
            ->when($texto !== '', function ($q) use ($texto) {
                $patron = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%';
                $q->where(function ($q) use ($patron) {
                    $q->where('T.COD_INTERNO', 'like', $patron)
                        ->orWhere('T.COD_UNICO', 'like', $patron)
                        ->orWhere('T.DES_LARGA_PROYECTO', 'like', $patron);
                });
            })
            ->orderBy('T.'.$this->orden, $this->direccion)
            ->orderBy('T.IDE_PROYECTO')
            ->select(['T.IDE_PROYECTO', 'T.COD_INTERNO', 'T.COD_UNICO', 'T.DES_LARGA_PROYECTO'])
            ->paginate($this->porPagina);

        $acciones = [];
        foreach (self::POR_OPCION[$this->opcion] as $clave) {
            $acciones[$clave] = match ($clave) {
                'sigam' => ['Ver proyecto en SIGAM', 'fa-map', 'gr-azul', null, []],
                'ficha' => ['Ficha técnica', 'fa-list-check', 'gr-azul', null, []],
                default => self::ACCIONES[$clave],
            };
        }

        return view('livewire.proyectos-tabla', [
            'proyectos' => $proyectos,
            'acciones' => $acciones,
        ]);
    }
}
