<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;

/**
 * Formulario de Proyectos (GeneraForm / RegistraDatos / ActualizarForm de PROYECTOln.php).
 * Graba con el mismo dbo.SP_PROYECTO (Insert / Update / Delete), con las mismas reglas:
 * - Un proyecto nuevo nace con estado 98; el estado no se cambia desde aqui (el SP no lo actualiza).
 * - Si el estado no es 98, los datos de origen (codigos, descripcion, montos, fechas, centro de
 *   costo) quedan bloqueados (Control_Bloqueo('SPRING1') en PROYECTOlni.php).
 * - Eliminar es una baja logica: el SP pone EST_PROYECTO = '2'.
 */
class ProyectoFormulario extends Component
{
    /** Estado de los proyectos registrados por el usuario (editables por completo) */
    public const ESTADO_PROPIO = '98';

    /** Campos que se bloquean en los proyectos que no son propios */
    public const BLOQUEABLES = ['COD_INTERNO', 'COD_UNICO', 'COD_SNIP', 'DES_LARGA_PROYECTO', 'DES_PROYECTO_ENGLISH',
        'IMP_APROBADO_LOC', 'FEC_APROBACION', 'FEC_INICIO_PROY', 'FEC_TERMINO_PROY', 'IDE_CENCOSTO'];

    /** Campos que se muestran (los demas se conservan como estan: el formulario actual los tiene ocultos) */
    public const VISIBLES = ['COD_INTERNO', 'DES_LARGA_PROYECTO', 'IDE_ETAPA_CONTRATO', 'IDE_PORTAFOLIO', 'IDE_PROGRAMA',
        'IDE_CENCOSTO', 'DES_UBICACION_PROYECTO', 'DES_AREA_INTERVENCION', 'DES_CUENCA_HIDROGRAFICA', 'DES_STAKEHOLDER',
        'NUM_PAMS', 'DES_ESTATUS', 'DES_ACCION_GESTION_SOCIAL', 'COD_UNICO', 'COD_SNIP', 'TIP_PROYECTO',
        'IMP_APROBADO_LOC', 'NUM_BENEFICIARIOS', 'FEC_APROBACION', 'FEC_INICIO_PROY', 'FEC_TERMINO_PROY', 'DES_PROYECTO_ENGLISH'];

    /** Todos los parametros de Insert/Update de SP_PROYECTO, en su orden */
    public const PARAMETROS = ['IDE_PORTAFOLIO', 'IDE_PROGRAMA', 'IDE_CENCOSTO', 'IDE_ENTIDAD_EJECUTORA', 'IDE_ETAPA_CONTRATO',
        'COD_INTERNO', 'COD_UNICO', 'COD_SNIP', 'DES_LARGA_PROYECTO', 'DES_CORTA_PROYECTO', 'DES_PROYECTO_ENGLISH', 'TIP_MONEDA',
        'IMP_APROBADO_LOC', 'IMP_APROBADO_EXT', 'FEC_APROBACION', 'FEC_INICIO_PROY', 'FEC_TERMINO_PROY', 'DES_UBICACION_PROYECTO',
        'DES_UNIDAD_FORMULADORA', 'DES_VIABILIDAD', 'DES_AREA_INTERVENCION', 'DES_CUENCA_HIDROGRAFICA', 'NUM_PAMS',
        'DES_STAKEHOLDER', 'DES_ESTATUS', 'DES_ACCION_GESTION', 'DES_ACCION_GESTION_SOCIAL', 'DES_ACCION_CORRECTIVA',
        'DES_OPORTUNIDAD_MEJORA', 'TIP_PROYECTO', 'TIP_GRUPO_PROYECTO', 'NUM_BENEFICIARIOS', 'EST_PROYECTO'];

    /**
     * Seccion III del formulario: pantallas relacionadas al proyecto (AbrirObjEsp, AbrirAccGes... de
     * gepro/recursos/js/PROYECTO.js), con su titulo e icono; las que estan en config/catalogos.php se abren en Laravel.
     */
    public const RELACIONADAS = [
        'PROY_SOCIAL_OBJETIVO_ESP' => ['Objetivos específicos de gestión social', 'fa-flag'],
        'PROY_ACCION_GESTION' => ['Principales acciones de gestión', 'fa-square-check'],
        'PROY_ACCION_CORRECTIVA' => ['Desviaciones y acciones correctivas', 'fa-wrench'],
        'PROY_OPORTUNIDAD_RIESGO' => ['Oportunidades de mejora y análisis de riesgo', 'fa-triangle-exclamation'],
        'PROY_COSTO_COMPONENTE' => ['Costos del proyecto por componente', 'fa-money-bill-wave'],
        'PROY_SEGUIMIENTO' => ['Seguimiento del proyecto', 'fa-eye'],
    ];

    public bool $abierto = false;

    #[Locked]
    public ?int $idProyecto = null;

    #[Locked]
    public string $estado = self::ESTADO_PROPIO;

    /** Valores del formulario: campo de SP_PROYECTO => valor (texto) */
    public array $datos = [];

    /** Opcion del menu desde la que se abrio (define si se puede registrar o editar) */
    #[Locked]
    public int $opcion = 110;

    public function mount(int $opcion): void
    {
        $this->opcion = $opcion;
    }

    private function puede(string $accion): bool
    {
        //ADEMAS DE LA OPCION DEL MENU, EL PERFIL "CONSULTA TOTAL" NO GRABA NI ELIMINA
        return in_array($this->opcion, ProyectosTabla::EDICION[$accion] ?? [], true)
            && app(\App\Services\Seguridad::class)->puedeGrabar();
    }

    #[On('proyecto-nuevo')]
    public function nuevo(): void
    {
        if (! $this->puede('nuevo')) {
            return;
        }
        $this->resetValidation();
        $this->idProyecto = null;
        $this->estado = self::ESTADO_PROPIO;
        $this->datos = array_fill_keys(self::PARAMETROS, '');
        $this->datos['EST_PROYECTO'] = self::ESTADO_PROPIO;
        $this->abierto = true;
    }

    #[On('proyecto-editar')]
    public function editar(int $id): void
    {
        if (! $this->puede('editar')) {
            return;
        }
        $fila =DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $id)->where('EST_PROYECTO', '<>', '2')->first();
        if (! $fila) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'El proyecto ya no existe.');

            return;
        }
        $this->resetValidation();
        $this->idProyecto = $id;
        $this->datos = [];
        foreach (self::PARAMETROS as $campo) {
            $valor = $fila->{$campo} ?? null;
            if ($valor !== null && str_starts_with($campo, 'FEC_')) {
                $valor = substr((string) $valor, 0, 10);
            } elseif ($valor !== null && str_starts_with($campo, 'IMP_')) {
                $valor = rtrim(rtrim(number_format((float) $valor, 3, '.', ''), '0'), '.');
            }
            $this->datos[$campo] = $valor === null ? '' : trim((string) $valor);
        }
        $this->estado = $this->datos['EST_PROYECTO'] !== '' ? $this->datos['EST_PROYECTO'] : self::ESTADO_PROPIO;
        $this->abierto = true;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->resetValidation();
    }

    /** URL de una pantalla relacionada (config/catalogos.php) para el proyecto que se edita */
    public function urlRelacionada(string $pagina): ?string
    {
        if ($this->idProyecto === null || ! array_key_exists($pagina, self::RELACIONADAS)) {
            return null;
        }
        return route('catalogos.index', ['pagina' => $pagina, 'de' => $this->idProyecto]);
    }

    public function bloqueado(string $campo): bool
    {
        return $this->idProyecto !== null && $this->estado !== self::ESTADO_PROPIO && in_array($campo, self::BLOQUEABLES, true);
    }

    protected function reglas(): array
    {
        $texto = fn (int $max) => ['nullable', 'string', 'max:'.$max];

        return [
            'datos.COD_INTERNO' => $texto(12),
            'datos.COD_UNICO' => $texto(10),
            'datos.COD_SNIP' => $texto(10),
            'datos.DES_LARGA_PROYECTO' => ['required', 'string', 'max:500'],
            'datos.DES_PROYECTO_ENGLISH' => $texto(200),
            'datos.IDE_ETAPA_CONTRATO' => ['required', 'integer', 'exists:sqlsrv.dbo.GEN_INTERVENCION,IDE_INTERVENCION'],
            'datos.IDE_PORTAFOLIO' => ['required', 'integer', 'exists:sqlsrv.dbo.GEN_PORTAFOLIO_PROYECTO,IDE_PORTAFOLIO'],
            'datos.IDE_PROGRAMA' => ['nullable', 'integer', 'exists:sqlsrv.dbo.GEN_PROGRAMA_PROYECTO,IDE_PROGRAMA'],
            'datos.IDE_CENCOSTO' => ['nullable', 'integer', 'exists:sqlsrv.dbo.GEN_CENTRO_COSTO,IDE_CENCOSTO'],
            'datos.TIP_PROYECTO' => ['nullable', 'string', 'max:3'],
            'datos.DES_UBICACION_PROYECTO' => $texto(1000),
            'datos.DES_AREA_INTERVENCION' => $texto(1000),
            'datos.DES_CUENCA_HIDROGRAFICA' => $texto(1000),
            'datos.DES_STAKEHOLDER' => $texto(1000),
            'datos.DES_ESTATUS' => $texto(4000),
            'datos.DES_ACCION_GESTION_SOCIAL' => $texto(4000),
            'datos.NUM_PAMS' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'datos.NUM_BENEFICIARIOS' => ['nullable', 'integer', 'min:0', 'max:9999999999'],
            'datos.IMP_APROBADO_LOC' => ['nullable', 'numeric', 'min:0', 'max:999999999999'],
            'datos.FEC_APROBACION' => ['nullable', 'date_format:Y-m-d'],
            'datos.FEC_INICIO_PROY' => ['nullable', 'date_format:Y-m-d'],
            'datos.FEC_TERMINO_PROY' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:datos.FEC_INICIO_PROY'],
        ];
    }

    protected function nombres(): array
    {
        return [
            'datos.COD_INTERNO' => 'código', 'datos.COD_UNICO' => 'código único', 'datos.COD_SNIP' => 'código SNIP',
            'datos.DES_LARGA_PROYECTO' => 'descripción larga', 'datos.DES_PROYECTO_ENGLISH' => 'descripción en inglés',
            'datos.IDE_ETAPA_CONTRATO' => 'fase - componente', 'datos.IDE_PORTAFOLIO' => 'portafolio', 'datos.IDE_PROGRAMA' => 'programa',
            'datos.IDE_CENCOSTO' => 'centro de costo', 'datos.TIP_PROYECTO' => 'tipo de proyecto', 'datos.NUM_PAMS' => 'número de pasivos',
            'datos.NUM_BENEFICIARIOS' => 'número de beneficiarios', 'datos.IMP_APROBADO_LOC' => 'monto aprobado',
            'datos.FEC_APROBACION' => 'fecha de aprobación', 'datos.FEC_INICIO_PROY' => 'fecha de inicio', 'datos.FEC_TERMINO_PROY' => 'fecha de término',
        ];
    }

    public function guardar(): void
    {
        if (! $this->puede($this->idProyecto === null ? 'nuevo' : 'editar')) {
            throw ValidationException::withMessages(['general' => 'Esta opción del menú no permite grabar proyectos.']);
        }
        //LOS CAMPOS BLOQUEADOS Y LOS OCULTOS NO SE TOMAN DEL NAVEGADOR: SE VUELVEN A LEER DE LA BASE
        if ($this->idProyecto !== null) {
            $actual = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $this->idProyecto)->where('EST_PROYECTO', '<>', '2')->first();
            if (! $actual) {
                throw ValidationException::withMessages(['general' => 'El proyecto ya no existe.']);
            }
            $this->estado = trim((string) $actual->EST_PROYECTO) ?: self::ESTADO_PROPIO;
            foreach (self::PARAMETROS as $campo) {
                if ($this->bloqueado($campo) || ! in_array($campo, self::VISIBLES, true)) {
                    $valor = $actual->{$campo} ?? null;
                    $this->datos[$campo] = $valor === null ? '' : trim(str_starts_with($campo, 'FEC_') ? substr((string) $valor, 0, 10) : (string) $valor);
                }
            }
        } else {
            foreach (self::PARAMETROS as $campo) {
                if (! in_array($campo, self::VISIBLES, true)) {
                    $this->datos[$campo] = '';
                }
            }
            $this->datos['EST_PROYECTO'] = self::ESTADO_PROPIO;
        }
        $this->datos = array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->datos);
        $this->validate($this->reglas(), [], $this->nombres());

        $parametros = [];
        foreach (self::PARAMETROS as $campo) {
            $parametros[$campo] = $this->datos[$campo] ?? '';
        }
        $parametros['pUsuario'] = (int) Auth::id();

        try {
            if ($this->idProyecto === null) {
                Procedimiento::grabar('dbo.SP_PROYECTO', 'Insert', $parametros);
                $mensaje = 'Proyecto registrado.';
            } else {
                Procedimiento::grabar('dbo.SP_PROYECTO', 'Update', ['pCodigo' => $this->idProyecto] + $parametros);
                $mensaje = 'Proyecto actualizado.';
            }
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages(['general' => 'No se pudo grabar: '.$e->getMessage()]);
        }

        $this->abierto = false;
        $this->dispatch('proyecto-guardado');
        $this->dispatch('aviso', tipo: 'ok', mensaje: $mensaje);
    }

    /** Opciones de los combos (las mismas consultas SelCampos del sistema actual, con sus filtros fijos) */
    public function combos(): array
    {
        $tabla = fn (string $codigo) => DB::table('dbo.GEN_TABLAS')->where('EST_ITEM', 1)->where('COD_TABLA', $codigo)
            ->orderBy('COD_ORDEN')->orderBy('DES_ITEM')->pluck('DES_ITEM', 'COD_ITEM')->map(fn ($d) => trim((string) $d))->all();

        return [
            'IDE_ETAPA_CONTRATO' => DB::table('dbo.GEN_INTERVENCION')->where('EST_INTERVENCION', '<>', '2')
                ->where('IDE_SECTOR', 14)->where('NUM_NIVEL', 3)->orderBy('DES_INTERVENCION')
                ->pluck('DES_INTERVENCION', 'IDE_INTERVENCION')->all(),
            'IDE_PORTAFOLIO' => DB::table('dbo.GEN_PORTAFOLIO_PROYECTO')->where('EST_PORTAFOLIO', '<>', '2')
                ->orderBy('DES_PORTAFOLIO')->pluck('DES_PORTAFOLIO', 'IDE_PORTAFOLIO')->all(),
            'IDE_PROGRAMA' => DB::table('dbo.GEN_PROGRAMA_PROYECTO')->where('EST_PROGRAMA', '<>', '2')
                ->orderBy('DES_PROGRAMA')->pluck('DES_PROGRAMA', 'IDE_PROGRAMA')->all(),
            'IDE_CENCOSTO' => DB::table('dbo.GEN_CENTRO_COSTO')->where('EST_CENCOSTO', '<>', '2')
                ->orderBy('DES_CENCOSTO')->pluck('DES_CENCOSTO', 'IDE_CENCOSTO')->all(),
            'TIP_PROYECTO' => $tabla('58'),
            'EST_PROYECTO' => $tabla('61'),
        ];
    }

    public function render()
    {
        return view('livewire.proyecto-formulario', [
            'combos' => $this->abierto ? $this->combos() : [],
        ]);
    }
}
