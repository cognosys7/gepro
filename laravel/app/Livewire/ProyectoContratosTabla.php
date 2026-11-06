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
 * Contratos (servicios) de un proyecto: reemplaza PROYECTO_ACTIVIDAD (Flexigrid + SelGrd de
 * dbo.SP_PROYECTO_ACTIVIDAD). Mismos datos:
 * - PROYECTO_ACTIVIDAD no anulados de todos los proyectos con el mismo codigo unico (CUI) del proyecto;
 * - filtro por tipo segun el icono de la grilla de Proyectos (Estudios, Obras, Supervision...);
 * - fechas: las de la ampliacion de plazo si existe, si no las del contrato.
 * Busqueda con parametros (el sistema actual concatenaba el campo y el texto) y orden antes de paginar.
 */
class ProyectoContratosTabla extends Component
{
    use WithPagination;

    #[Locked]
    public int $proyecto;

    #[Locked]
    public int $opcion;

    /** 0 todos, 1 estudios, 2 obras, 3 supervision, 4 post-cierre, 5 otros (Pfiltro) */
    #[Locked]
    public int $tipo = 0;

    #[Url(as: 'q', except: '')]
    public string $buscar = '';

    #[Url(as: 'orden', except: 'IMP_COSTO_ACTUAL')]
    public string $orden = 'IMP_COSTO_ACTUAL';

    #[Url(as: 'dir', except: 'desc')]
    public string $direccion = 'desc';

    #[Url(as: 'n', except: 10)]
    public int $porPagina = 10;

    /** Intervenciones de cada tipo (PROYECTO_ACTIVIDADln.php, $Pfiltro) */
    public const TIPOS = [
        1 => ['Estudios', [155, 174, 161, 160, 159, 152]],
        2 => ['Obras', [151]],
        3 => ['Supervisión', [153]],
        4 => ['Post-cierre', [169, 163]],
        5 => ['Otros', null],
    ];

    /** Columnas que se pueden ordenar => expresion SQL (lista cerrada) */
    public const ORDEN = [
        'COD_PROYECTO' => 'PRY.COD_PROYECTO',
        'COD_CONTRATO_ENTIDAD' => 'C.COD_CONTRATO_ENTIDAD',
        'DES_PROYECTO' => 'PRY.DES_PROYECTO',
        'IMP_COSTO_ACTUAL' => 'PRY.IMP_COSTO_ACTUAL',
        'FEC_INICIO' => 'FEC_INICIO',
        'FEC_TERMINO' => 'FEC_TERMINO',
        'INTERVENCION' => 'ITV.DES_INTERVENCION',
        'TIPO_CONTRATO' => 'TT1.DES_ITEM',
        'ESTADO' => 'EST_PRY.DES_ITEM',
    ];

    /**
     * Acciones de la fila: titulo, icono, color, pantalla del sistema actual y parametros
     * ({id} = IDE_PROYECTO_ACTIVIDAD, {proyecto} = IDE_PROYECTO, {intervencion}, {proceso}).
     * Son las funciones de gepro/recursos/js/PROYECTO_ACTIVIDAD.js; 'si' indica cuando se muestra.
     */
    public const ACCIONES = [
        'etapas' => ['Etapas (componentes)', 'fa-table-cells-large', 'gr-azul', 'PROY_COMPONENTE', ['PIDE_PROYECTO_ACTIVIDAD' => '{id}', 'PIDE_INTERVENCION' => '{intervencion}']],
        'contrato' => ['Detalle del contrato', 'fa-file-lines', 'gr-azul', 'CONTRATO', ['PIDE' => '{id}', 'PIDE2' => '{proyecto}']],
        'ampliacion' => ['Ampliación de plazo', 'fa-clock-rotate-left', 'gr-ambar', 'PROY_CONT_AMPLIACION', ['PIDE' => '{id}', 'PIDE_PROYECTO' => '{proyecto}']],
        'riesgo' => ['Riesgos', 'fa-triangle-exclamation', 'gr-rojo', 'PROY_RIESGO_PROBLEMA', ['PIDE_PROYECTO_ACTIVIDAD' => '{id}', 'PIDE_PROYECTO' => '{proyecto}'], 'si' => 'intervencion'],
        'interesados' => ['Interesados', 'fa-users', 'gr-violeta', 'CONT_INTERESADOS', ['PIDE' => '{id}', 'PIDE_PROYECTO' => '{proyecto}', 'PINTERVENCION' => '{intervencion}']],
        'adquisicion' => ['Proceso de adquisición', 'fa-cart-shopping', 'gr-azul', 'PROCESO_CONTRATO', [], 'si' => 'adquisicion'],
        'documentos' => ['Documentos', 'fa-folder-open', 'gr-teal', 'CONT_DOCUMENTACION', ['Opcion' => 1, 'PIDE' => '{id}', 'PIDE2' => '{proyecto}'], 'si' => 'intervencion'],
        'entregables' => ['Calidad de entregables', 'fa-thumbs-up', 'gr-verde', 'CONT_CALIDAD', ['PIDE' => '{id}', 'PIDE_PROYECTO' => '{proyecto}'], 'si' => 'intervencion'],
        'migrar' => ['Migrar control de etapas', 'fa-file-import', 'gr-verde', 'migrar_CONT_ETAPA_CONTROL', ['PIDE' => '{id}', 'Tabla' => 'migrar_CONT_ETAPA_CONTROL']],
    ];

    /**
     * Acciones visibles por opcion del menu (Grilla_verBotones_ProyectoActividad: 'false' es visible;
     * "Migrar" usa el indicador de Etapas y "Eliminar" el de Editar).
     */
    public const POR_OPCION = [
        200 => ['etapas', 'contrato', 'riesgo', 'interesados', 'adquisicion', 'documentos', 'entregables', 'migrar'],
        210 => ['contrato', 'adquisicion'],
        211 => ['etapas', 'contrato', 'ampliacion', 'interesados', 'migrar'],
        212 => ['riesgo'],
        214 => ['interesados'],
        215 => ['documentos'],
        216 => ['entregables'],
        310 => ['interesados'],
    ];

    public const EDICION = [
        'nuevo' => [210, 211],
        'editar' => [200, 210, 211],
        'eliminar' => [200, 210, 211],
    ];

    /** Solo se eliminan los registrados en GEPRO (SelGrd: TIP_PROYECTO_ACTIVIDAD 27 a 34) */
    public const TIPOS_ELIMINABLES = [27, 28, 29, 30, 31, 32, 33, 34];

    public function mount(int $proyecto, int $opcion, int $tipo = 0): void
    {
        $this->proyecto = $proyecto;
        $this->opcion = $opcion;
        $this->tipo = array_key_exists($tipo, self::TIPOS) ? $tipo : 0;
        $this->validarOrden();
    }

    public function puede(string $accion): bool
    {
        //ADEMAS DE LA OPCION DEL MENU, EL PERFIL "CONSULTA TOTAL" NO GRABA NI ELIMINA
        return in_array($this->opcion, self::EDICION[$accion] ?? [], true)
            && app(\App\Services\Seguridad::class)->puedeGrabar();
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
        if (! array_key_exists($columna, self::ORDEN)) {
            return;
        }
        $this->direccion = $this->orden === $columna && $this->direccion === 'asc' ? 'desc' : 'asc';
        $this->orden = $columna;
        $this->resetPage();
    }

    private function validarOrden(): void
    {
        if (! array_key_exists($this->orden, self::ORDEN)) {
            $this->orden = 'IMP_COSTO_ACTUAL';
        }
        $this->direccion = $this->direccion === 'asc' ? 'asc' : 'desc';
    }

    #[On('contrato-guardado')]
    public function recargar(): void
    {
    }

    /** Baja logica con dbo.SP_PROYECTO_ACTIVIDAD 'Delete' (EST_PROYECTO_ACTIVIDAD = '2') */
    public function eliminar(int $id): void
    {
        if (! $this->puede('eliminar')) {
            return;
        }
        $tipo = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $id)->value('TIP_PROYECTO_ACTIVIDAD');
        if (! in_array((int) $tipo, self::TIPOS_ELIMINABLES, true)) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'Este contrato no se puede eliminar.');

            return;
        }
        try {
            Procedimiento::grabar('dbo.SP_PROYECTO_ACTIVIDAD', 'Delete', ['pCodigo' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Contrato eliminado.');
        } catch (\RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    /** Si la accion se muestra en la fila (algunas dependen de la intervencion o del tipo de contrato) */
    public function accionVisible(string $clave, object $fila): bool
    {
        return match (self::ACCIONES[$clave]['si'] ?? null) {
            'intervencion' => $fila->INTERVENCION !== null,
            'adquisicion' => (int) $fila->TIP_PROYECTO_ACTIVIDAD === 1,
            default => true,
        };
    }

    public function urlAccion(string $clave, object $fila): string
    {
        [, , , $pagina, $parametros] = self::ACCIONES[$clave];
        if ($clave === 'migrar') {
            return route('contratos.migrar-control', ['contrato' => (int) $fila->ID, 'opcion' => $this->opcion]);
        }
        //PANTALLAS QUE YA ESTAN EN LARAVEL (config/catalogos.php, P. EJ. LAS ETAPAS DEL CONTRATO)
        if (\App\Support\Catalogo::existe($pagina) && ! empty(config('catalogos.'.$pagina.'.de'))) {
            return route('catalogos.index', ['pagina' => $pagina, 'de' => (int) $fila->ID]);
        }
        $consulta = ['Pagina' => $pagina, 'Accion' => 'muestraVista', 'AccionLocal' => 2];
        foreach ($parametros as $nombre => $valor) {
            $consulta[$nombre] = str_replace(
                ['{id}', '{proyecto}', '{intervencion}', '{proceso}'],
                [(int) $fila->ID, (int) $fila->IDE_PROYECTO, (int) $fila->IDE_INTERVENCION, (int) $fila->IDE_PROCESO_ITEM],
                (string) $valor
            );
        }
        $consulta['vmSinCabecera'] = 1;

        return app(Seguridad::class)->urlLegado('mainpage.php?'.http_build_query($consulta));
    }

    /** Codigo unico del proyecto (el sistema actual compara P.COD_UNICO = '<valor>', vacio si no tiene) */
    private function codigoUnico(): string
    {
        return (string) DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $this->proyecto)->value('COD_UNICO');
    }

    public function consulta()
    {
        $texto = trim($this->buscar);
        $intervenciones = array_merge(...array_filter(array_column(self::TIPOS, 1)));

        return DB::table('dbo.PROYECTO_ACTIVIDAD as PRY')
            ->leftJoin('dbo.GEN_INTERVENCION as ITV', 'PRY.IDE_INTERVENCION', '=', 'ITV.IDE_INTERVENCION')
            ->leftJoin('dbo.GEN_TABLAS as EST_PRY', function ($j) {
                $j->on('PRY.EST_PROYECTO_ACTIVIDAD', '=', 'EST_PRY.COD_ITEM')->where('EST_PRY.COD_TABLA', '8');
            })
            ->leftJoin('dbo.GEN_TABLAS as TT1', function ($j) {
                $j->on('TT1.COD_ITEM', '=', 'PRY.TIP_PROYECTO_ACTIVIDAD')->where('TT1.COD_TABLA', '65');
            })
            ->leftJoin('dbo.PROYECTO as P', 'PRY.IDE_PROYECTO', '=', 'P.IDE_PROYECTO')
            ->leftJoin('dbo.PROY_CONTRATO as PC', 'PC.IDE_PROYECTO_ACTIVIDAD', '=', 'PRY.IDE_PROYECTO_ACTIVIDAD')
            ->leftJoin('dbo.CONTRATO as C', 'C.IDE_CONTRATO', '=', 'PC.IDE_CONTRATO')
            ->where('PRY.EST_PROYECTO_ACTIVIDAD', '<>', '2')
            ->where('P.COD_UNICO', $this->codigoUnico())
            ->when($this->tipo >= 1 && $this->tipo <= 4, fn ($q) => $q->whereIn('PRY.IDE_INTERVENCION', self::TIPOS[$this->tipo][1]))
            ->when($this->tipo === 5, fn ($q) => $q->where(fn ($q) => $q->whereNotIn('PRY.IDE_INTERVENCION', $intervenciones)->orWhereNull('PRY.IDE_INTERVENCION')))
            ->when($texto !== '', function ($q) use ($texto) {
                $patron = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%';
                $q->where(function ($q) use ($patron) {
                    foreach (['PRY.COD_PROYECTO', 'C.COD_CONTRATO_ENTIDAD', 'PRY.DES_PROYECTO', 'ITV.DES_INTERVENCION', 'EST_PRY.DES_ITEM', 'TT1.DES_ITEM'] as $c) {
                        $q->orWhere($c, 'like', $patron);
                    }
                });
            })
            ->select([
                'PRY.IDE_PROYECTO_ACTIVIDAD as ID', 'PRY.COD_PROYECTO', 'C.COD_CONTRATO_ENTIDAD', 'PRY.DES_PROYECTO',
                'PRY.IMP_COSTO_ACTUAL', 'ITV.DES_INTERVENCION as INTERVENCION', 'TT1.DES_ITEM as TIPO_CONTRATO',
                'EST_PRY.DES_ITEM as ESTADO', 'PRY.IDE_INTERVENCION', 'PRY.IDE_PROYECTO', 'PRY.IDE_PROCESO_ITEM',
                'PRY.TIP_PROYECTO_ACTIVIDAD',
            ])
            ->selectRaw('CONVERT(varchar(10), COALESCE((SELECT TOP 1 PCA.FEC_INICIO_AMP FROM dbo.PROY_CONT_AMPLIACION PCA WHERE PCA.IDE_PROYECTO_ACTIVIDAD = PRY.IDE_PROYECTO_ACTIVIDAD AND PCA.TIP_AMPLIACION = 3 AND PCA.EST_CONT_AMPLIACION <> 2), C.FEC_INICIO_CONTRATO), 23) AS FEC_INICIO')
            ->selectRaw('CONVERT(varchar(10), COALESCE((SELECT MAX(PCA.FEC_TERMINO_AMP) FROM dbo.PROY_CONT_AMPLIACION PCA WHERE PCA.IDE_PROYECTO_ACTIVIDAD = PRY.IDE_PROYECTO_ACTIVIDAD AND PCA.EST_CONT_AMPLIACION <> 2), C.FEC_TERMINO_CONTRATO), 23) AS FEC_TERMINO');
    }

    public function render()
    {
        $this->validarOrden();
        $contratos = $this->consulta()
            ->orderByRaw(self::ORDEN[$this->orden].' '.$this->direccion)
            ->orderBy('PRY.IDE_PROYECTO_ACTIVIDAD')
            ->paginate($this->porPagina);

        $acciones = array_intersect_key(self::ACCIONES, array_flip(self::POR_OPCION[$this->opcion] ?? []));

        return view('livewire.proyecto-contratos-tabla', ['contratos' => $contratos, 'acciones' => $acciones]);
    }
}
