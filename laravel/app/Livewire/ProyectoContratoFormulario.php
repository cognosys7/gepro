<?php

namespace App\Livewire;

use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;

/**
 * Formulario de un contrato del proyecto (PROYECTO_ACTIVIDAD). Graba con dbo.SP_PROYECTO_ACTIVIDAD.
 * Reglas del sistema actual (PROYECTO_ACTIVIDADln.php / PROYECTO_ACTIVIDADVISTA.php / CONTRATOln.php):
 * - Se elige un contrato de dbo.CONTRATO: copia su codigo (COD_UNICO_ORDEN), descripcion, monto total y
 *   estado (4 -> 3, 5 -> 4), y su IDE_CONTRATO va en IMP_TRANSFERIDO: el SP lo usa para crear o
 *   actualizar el enlace en PROY_CONTRATO ("artilugio para reutilizar un campo").
 * - Nuevo: estado 98 si no se elige contrato. El estado no se escribe a mano.
 * - Si el estado no es 98, la descripcion, el costo actual y el contrato quedan bloqueados.
 */
class ProyectoContratoFormulario extends Component
{
    public const ESTADO_PROPIO = '98';

    public const BLOQUEABLES = ['COD_PROYECTO', 'DES_PROYECTO', 'IMP_COSTO_ACTUAL', 'IMP_TRANSFERIDO'];

    public const VISIBLES = ['COD_PROYECTO', 'DES_PROYECTO', 'IDE_INTERVENCION', 'TIP_PROYECTO_ACTIVIDAD', 'DES_PROYECTO_ABREV',
        'DES_UBICACION', 'IMP_INVERSION', 'IMP_FINANCIADO', 'IMP_VALOR_REFERENCIAL', 'IMP_COSTO_ACTUAL'];

    /** Parametros de Insert/Update de SP_PROYECTO_ACTIVIDAD, en su orden */
    public const PARAMETROS = ['IDE_PROYECTO', 'COD_PROYECTO', 'IDE_ENTIDAD_EJECUTORA', 'IDE_PROCESO_ITEM', 'IDE_PRIORIZACION',
        'IDE_INTERVENCION', 'GRUPO_TIPO_INTERVENCION', 'TIP_PROYECTO_ACTIVIDAD', 'DES_PROYECTO', 'DES_PROYECTO_ITEM',
        'DES_PROYECTO_ABREV', 'IMP_INVERSION', 'IMP_FINANCIADO', 'IMP_TRANSFERIDO', 'IMP_VALOR_REFERENCIAL', 'IMP_COSTO_ACTUAL',
        'IMP_LIQUIDADO', 'DES_UBICACION', 'GEO_LONGITUD_UBICACION', 'GEO_LATITUD_UBICACION', 'EST_PROYECTO_ACTIVIDAD'];

    #[Locked]
    public int $proyecto;

    #[Locked]
    public int $opcion;

    public bool $abierto = false;

    #[Locked]
    public ?int $idContrato = null;

    #[Locked]
    public string $estado = self::ESTADO_PROPIO;

    public array $datos = [];

    /** Busqueda de contrato */
    public string $buscarContrato = '';

    /** Contrato elegido en esta edicion (IDE_CONTRATO), para no tomarlo del navegador */
    #[Locked]
    public ?int $contratoElegido = null;

    public function mount(int $proyecto, int $opcion): void
    {
        $this->proyecto = $proyecto;
        $this->opcion = $opcion;
    }

    private function puede(string $accion): bool
    {
        //ADEMAS DE LA OPCION DEL MENU, EL PERFIL "CONSULTA TOTAL" NO GRABA NI ELIMINA
        return in_array($this->opcion, ProyectoContratosTabla::EDICION[$accion] ?? [], true)
            && app(\App\Services\Seguridad::class)->puedeGrabar();
    }

    #[On('contrato-nuevo')]
    public function nuevo(): void
    {
        if (! $this->puede('nuevo')) {
            return;
        }
        $this->resetValidation();
        $this->idContrato = null;
        $this->contratoElegido = null;
        $this->buscarContrato = '';
        $this->estado = self::ESTADO_PROPIO;
        $this->datos = array_fill_keys(self::PARAMETROS, '');
        $this->datos['IDE_PROYECTO'] = (string) $this->proyecto;
        $this->datos['EST_PROYECTO_ACTIVIDAD'] = self::ESTADO_PROPIO;
        $this->abierto = true;
    }

    #[On('contrato-editar')]
    public function editar(int $id): void
    {
        if (! $this->puede('editar')) {
            return;
        }
        $fila = $this->leer($id);
        if (! $fila) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'El contrato ya no existe.');

            return;
        }
        $this->resetValidation();
        $this->idContrato = $id;
        $this->contratoElegido = null;
        $this->buscarContrato = '';
        $this->datos = $this->valores($fila);
        $this->estado = $this->datos['EST_PROYECTO_ACTIVIDAD'] !== '' ? $this->datos['EST_PROYECTO_ACTIVIDAD'] : self::ESTADO_PROPIO;
        $this->abierto = true;
    }

    private function leer(int $id): ?object
    {
        return DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $id)->where('EST_PROYECTO_ACTIVIDAD', '<>', '2')->first();
    }

    private function valores(object $fila): array
    {
        $datos = [];
        foreach (self::PARAMETROS as $campo) {
            $valor = $fila->{$campo} ?? null;
            if ($valor !== null && str_starts_with($campo, 'IMP_')) {
                $valor = rtrim(rtrim(number_format((float) $valor, 2, '.', ''), '0'), '.');
            }
            $datos[$campo] = $valor === null ? '' : trim((string) $valor);
        }

        return $datos;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->resetValidation();
    }

    public function bloqueado(string $campo): bool
    {
        return $this->idContrato !== null && $this->estado !== self::ESTADO_PROPIO && in_array($campo, self::BLOQUEABLES, true);
    }

    /** Contratos que coinciden con la busqueda (los mismos que lista la busqueda de Contratos: no anulados) */
    public function contratosEncontrados(): array
    {
        $texto = trim($this->buscarContrato);
        if (mb_strlen($texto) < 2 || $this->bloqueado('COD_PROYECTO')) {
            return [];
        }
        $patron = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%';

        return DB::table('dbo.CONTRATO')
            ->where('EST_CONTRATO', '<>', '2')
            ->where(fn ($q) => $q->where('COD_UNICO_ORDEN', 'like', $patron)->orWhere('COD_CONTRATO_ENTIDAD', 'like', $patron)->orWhere('DES_CONTRATO', 'like', $patron))
            ->orderBy('COD_CONTRATO_ENTIDAD')
            ->limit(10)
            ->get(['IDE_CONTRATO', 'COD_UNICO_ORDEN', 'COD_CONTRATO_ENTIDAD', 'DES_CONTRATO', 'IMP_TOTAL'])
            ->all();
    }

    /** Elegir un contrato: copia sus datos como CompruebaPaseDatos() de CONTRATOvista.php */
    public function elegirContrato(int $idContrato): void
    {
        if ($this->bloqueado('COD_PROYECTO')) {
            return;
        }
        $c = DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $idContrato)->where('EST_CONTRATO', '<>', '2')->first();
        if (! $c) {
            return;
        }
        $estado = trim((string) $c->EST_CONTRATO);
        $this->contratoElegido = (int) $c->IDE_CONTRATO;
        $this->datos['COD_PROYECTO'] = trim((string) $c->COD_UNICO_ORDEN);
        $this->datos['DES_PROYECTO'] = trim((string) $c->DES_CONTRATO);
        $this->datos['IMP_COSTO_ACTUAL'] = $c->IMP_TOTAL === null ? '' : rtrim(rtrim(number_format((float) $c->IMP_TOTAL, 2, '.', ''), '0'), '.');
        $this->datos['IMP_TRANSFERIDO'] = (string) (int) $c->IDE_CONTRATO;
        $this->datos['EST_PROYECTO_ACTIVIDAD'] = $estado === '4' ? '3' : ($estado === '5' ? '4' : $estado);
        $this->estado = $this->idContrato === null ? $this->datos['EST_PROYECTO_ACTIVIDAD'] : $this->estado;
        $this->buscarContrato = '';
    }

    /** Codigo del contrato enlazado (para mostrarlo junto al numero) */
    public function contratoEnlazado(): ?string
    {
        $id = (int) ($this->datos['IMP_TRANSFERIDO'] ?? 0);

        return $id > 0 ? DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $id)->value('COD_CONTRATO_ENTIDAD') : null;
    }

    public function guardar(): void
    {
        if (! $this->puede($this->idContrato === null ? 'nuevo' : 'editar')) {
            throw ValidationException::withMessages(['general' => 'Esta opción del menú no permite grabar contratos.']);
        }

        //LOS CAMPOS OCULTOS Y BLOQUEADOS SE TOMAN DE LA BASE (O DEL CONTRATO ELEGIDO), NO DEL NAVEGADOR
        $elegido = $this->contratoElegido ? DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $this->contratoElegido)->first() : null;
        if ($this->idContrato !== null) {
            $actual = $this->leer($this->idContrato);
            if (! $actual) {
                throw ValidationException::withMessages(['general' => 'El contrato ya no existe.']);
            }
            $base = $this->valores($actual);
            $this->estado = $base['EST_PROYECTO_ACTIVIDAD'] !== '' ? $base['EST_PROYECTO_ACTIVIDAD'] : self::ESTADO_PROPIO;
            foreach (self::PARAMETROS as $campo) {
                $delContrato = $elegido && ! $this->bloqueado($campo) && in_array($campo, ['IMP_TRANSFERIDO', 'EST_PROYECTO_ACTIVIDAD'], true);
                if (! $delContrato && ($this->bloqueado($campo) || ! in_array($campo, self::VISIBLES, true))) {
                    $this->datos[$campo] = $base[$campo];
                }
            }
        } else {
            foreach (self::PARAMETROS as $campo) {
                if (! in_array($campo, self::VISIBLES, true) && ! in_array($campo, ['IMP_TRANSFERIDO', 'EST_PROYECTO_ACTIVIDAD'], true)) {
                    $this->datos[$campo] = '';
                }
            }
            $this->datos['IDE_PROYECTO'] = (string) $this->proyecto;
            if (! $elegido) {
                $this->datos['IMP_TRANSFERIDO'] = '';
                $this->datos['EST_PROYECTO_ACTIVIDAD'] = self::ESTADO_PROPIO;
            }
        }
        if ($elegido && ! $this->bloqueado('IMP_TRANSFERIDO')) {
            $this->datos['IMP_TRANSFERIDO'] = (string) (int) $elegido->IDE_CONTRATO;
        }
        $this->datos = array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->datos);

        $monto = ['nullable', 'numeric', 'min:0', 'max:9999999999999999'];
        $this->validate([
            'datos.COD_PROYECTO' => ['required', 'string', 'max:30'],
            'datos.DES_PROYECTO' => ['required', 'string', 'max:1000'],
            'datos.IDE_INTERVENCION' => ['required', 'integer', 'exists:sqlsrv.dbo.GEN_INTERVENCION,IDE_INTERVENCION'],
            'datos.TIP_PROYECTO_ACTIVIDAD' => ['nullable', 'string', 'max:3'],
            'datos.DES_PROYECTO_ABREV' => ['nullable', 'string', 'max:120'],
            'datos.DES_UBICACION' => ['nullable', 'string', 'max:500'],
            'datos.IMP_INVERSION' => array_merge(['required'], array_slice($monto, 1)),
            'datos.IMP_FINANCIADO' => array_merge(['required'], array_slice($monto, 1)),
            'datos.IMP_VALOR_REFERENCIAL' => $monto,
            'datos.IMP_COSTO_ACTUAL' => array_merge(['required'], array_slice($monto, 1)),
        ], [], [
            'datos.COD_PROYECTO' => 'número', 'datos.DES_PROYECTO' => 'descripción del servicio', 'datos.IDE_INTERVENCION' => 'fase - componente',
            'datos.TIP_PROYECTO_ACTIVIDAD' => 'modalidad de gestión', 'datos.DES_PROYECTO_ABREV' => 'descripción abreviada',
            'datos.DES_UBICACION' => 'ubicación', 'datos.IMP_INVERSION' => 'monto de inversión', 'datos.IMP_FINANCIADO' => 'monto financiado',
            'datos.IMP_VALOR_REFERENCIAL' => 'valor referencial', 'datos.IMP_COSTO_ACTUAL' => 'costo actual',
        ]);

        $parametros = [];
        foreach (self::PARAMETROS as $campo) {
            $parametros[$campo] = $this->datos[$campo] ?? '';
        }
        $parametros['pUsuario'] = (int) Auth::id();

        try {
            if ($this->idContrato === null) {
                Procedimiento::grabar('dbo.SP_PROYECTO_ACTIVIDAD', 'Insert', $parametros);
                $mensaje = 'Contrato registrado.';
            } else {
                Procedimiento::grabar('dbo.SP_PROYECTO_ACTIVIDAD', 'Update', ['pCodigo' => $this->idContrato] + $parametros);
                $mensaje = 'Contrato actualizado.';
            }
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages(['general' => 'No se pudo grabar: '.$e->getMessage()]);
        }

        $this->abierto = false;
        $this->dispatch('contrato-guardado');
        $this->dispatch('aviso', tipo: 'ok', mensaje: $mensaje);
    }

    public function combos(): array
    {
        $tabla = fn (string $codigo) => DB::table('dbo.GEN_TABLAS')->where('EST_ITEM', 1)->where('COD_TABLA', $codigo)
            ->orderBy('COD_ORDEN')->orderBy('DES_ITEM')->pluck('DES_ITEM', 'COD_ITEM')->map(fn ($d) => trim((string) $d))->all();

        return [
            'IDE_INTERVENCION' => DB::table('dbo.GEN_INTERVENCION')->where('EST_INTERVENCION', '<>', '2')
                ->where('IDE_SECTOR', 14)->where('NUM_NIVEL', 3)->orderBy('DES_INTERVENCION')
                ->pluck('DES_INTERVENCION', 'IDE_INTERVENCION')->all(),
            'TIP_PROYECTO_ACTIVIDAD' => $tabla('65'),
            'EST_PROYECTO_ACTIVIDAD' => $tabla('8'),
        ];
    }

    public function render()
    {
        return view('livewire.proyecto-contrato-formulario', [
            'combos' => $this->abierto ? $this->combos() : [],
            'encontrados' => $this->abierto ? $this->contratosEncontrados() : [],
        ]);
    }
}
