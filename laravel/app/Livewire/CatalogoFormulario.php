<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Catalogo;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;

/**
 * Formulario de cualquier catalogo de config/catalogos.php. Graba con el Insert / Update de su SP:
 * - los parametros que no estan en el formulario se conservan como estan (al registrar van vacios);
 * - los campos de solo lectura se toman siempre de la base;
 * - el perfil "CONSULTA TOTAL" o un catalogo sin edicion abren el formulario solo para ver.
 */
class CatalogoFormulario extends Component
{
    #[Locked]
    public string $pagina;

    public bool $abierto = false;

    #[Locked]
    public ?string $idRegistro = null;

    public array $datos = [];

    /** Catalogos jerarquicos: registro padre bajo el que se registra (null = raiz) */
    #[Locked]
    public ?string $padre = null;

    public function mount(string $pagina, ?string $padre = null): void
    {
        Catalogo::definicion($pagina);
        $this->pagina = $pagina;
        $this->padre = $padre;
    }

    /** Valores que fija la jerarquia al registrar (tabla, padre, nivel...) */
    private function valoresJerarquia(): array
    {
        $def = $this->def();

        return Catalogo::contexto($def, Catalogo::fila($def, $this->padre))['valores'];
    }

    /** Columnas que maneja la jerarquia: no se editan */
    private function columnasJerarquia(): array
    {
        $j = $this->def()['jerarquia'] ?? null;

        return $j ? array_keys(array_merge($j['raiz']['valores'] ?? [], $j['hijo']['valores'] ?? [])) : [];
    }

    public function def(): array
    {
        return Catalogo::definicion($this->pagina);
    }

    /** Si puede grabar lo que tiene abierto (registrar o editar) */
    public function puedeGrabar(): bool
    {
        $accion = $this->idRegistro === null ? 'nuevo' : 'editar';

        return ! empty($this->def()[$accion]) && app(Seguridad::class)->puedeGrabar();
    }

    public function bloqueado(string $campo): bool
    {
        $c = $this->def()['campos'][$campo] ?? null;

        return ! $this->puedeGrabar() || ! $c || ! empty($c[2]['oculto']) || (! empty($c[2]['solo_lectura']) && $this->idRegistro !== null)
            || ! in_array($campo, $this->def()['parametros'], true)
            || in_array($campo, $this->columnasJerarquia(), true);
    }

    #[On('catalogo-nuevo')]
    public function nuevo(): void
    {
        if (empty($this->def()['nuevo']) || ! app(Seguridad::class)->puedeGrabar()) {
            return;
        }
        $this->resetValidation();
        $this->idRegistro = null;
        $this->datos = array_fill_keys(array_keys($this->def()['campos']), '');
        $this->datos[$this->def()['estado']] = '1';
        //SE MUESTRAN LOS VALORES QUE PONE LA JERARQUIA (P. EJ. EL RUBRO SUPERIOR)
        foreach ($this->valoresJerarquia() as $columna => $valor) {
            if (array_key_exists($columna, $this->datos)) {
                $this->datos[$columna] = $valor;
            }
        }
        $this->abierto = true;
    }

    #[On('catalogo-editar')]
    public function editar(int|string $id): void
    {
        //LA CLAVE PUEDE SER UN NUMERO O UN CODIGO (UBIGEO)
        $id = trim((string) $id);
        if (empty($this->def()['editar']) || ! preg_match('/^[A-Za-z0-9_-]{1,30}$/', $id)) {
            return;
        }
        $fila = $this->leer($id);
        if (! $fila) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'El registro ya no existe.');

            return;
        }
        $this->resetValidation();
        $this->idRegistro = $id;
        $this->datos = $this->valores($fila, array_keys($this->def()['campos']));
        $this->abierto = true;
    }

    private function leer(string $id): ?object
    {
        $def = $this->def();

        return DB::table($def['tabla'])->where($def['id'], $id)->where($def['estado'], '<>', '2')->first();
    }

    private function valores(object $fila, array $campos): array
    {
        $datos = [];
        foreach ($campos as $campo) {
            $valor = $fila->{$campo} ?? null;
            $tipo = $this->def()['campos'][$campo][1] ?? '';
            if ($valor !== null && is_numeric($valor) && $tipo === 'numero') {
                $valor = rtrim(rtrim(number_format((float) $valor, 4, '.', ''), '0'), '.');
            } elseif ($valor !== null && $tipo === 'fecha') {
                $valor = substr((string) $valor, 0, 10);
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

    public function guardar(): void
    {
        if (! $this->puedeGrabar()) {
            throw ValidationException::withMessages(['general' => 'No tiene permiso para grabar en este catálogo.']);
        }
        $def = $this->def();

        //VALORES QUE NO VIENEN DEL NAVEGADOR: PARAMETROS OCULTOS Y CAMPOS DE SOLO LECTURA (DE LA BASE)
        $base = [];
        if ($this->idRegistro !== null) {
            $actual = $this->leer($this->idRegistro);
            if (! $actual) {
                throw ValidationException::withMessages(['general' => 'El registro ya no existe.']);
            }
            $base = $this->valores($actual, $def['parametros']);
        }
        $parametros = [];
        foreach ($def['parametros'] as $p) {
            $editable = isset($def['campos'][$p]) && ! $this->bloqueado($p);
            $parametros[$p] = $editable ? trim((string) ($this->datos[$p] ?? '')) : ($base[$p] ?? '');
        }
        //AL REGISTRAR, LA JERARQUIA FIJA SUS COLUMNAS (AL EDITAR SE CONSERVAN LAS DE LA BASE)
        if ($this->idRegistro === null) {
            foreach ($this->valoresJerarquia() as $columna => $valor) {
                if (in_array($columna, $def['parametros'], true)) {
                    $parametros[$columna] = $valor;
                }
            }
        }

        //VALIDACION SEGUN LA DEFINICION (SOLO LOS CAMPOS EDITABLES)
        $reglas = [];
        $nombres = [];
        foreach ($def['campos'] as $campo => [$etiqueta, $tipo, $o]) {
            if ($this->bloqueado($campo)) {
                continue;
            }
            $r = [! empty($o['requerido']) ? 'required' : 'nullable'];
            if ($tipo === 'numero') {
                $r[] = 'numeric';
            } elseif ($tipo === 'fecha') {
                $r[] = 'date_format:Y-m-d';
            } elseif ($tipo === 'combo') {
                $r[] = Rule::in(array_map('strval', array_keys(Catalogo::opciones($def['campos'][$campo], $base[$campo] ?? null))));
            } else {
                $r[] = 'string';
                if (! empty($o['max'])) {
                    $r[] = 'max:'.$o['max'];
                }
            }
            //CODIGO QUE NO SE PUEDE REPETIR (P. EJ. EL UBIGEO): SE VALIDA AL REGISTRAR
            if (! empty($o['unico']) && $this->idRegistro === null) {
                $r[] = Rule::unique('sqlsrv.'.$def['tabla'], $campo);
            }
            $reglas['datos.'.$campo] = $r;
            $nombres['datos.'.$campo] = mb_strtolower($etiqueta, 'UTF-8');
        }
        $this->datos = array_map(fn ($v) => is_string($v) ? trim($v) : $v, $this->datos);
        $this->validate($reglas, [], $nombres);

        $parametros['pUsuario'] = (int) Auth::id();
        try {
            if ($this->idRegistro === null) {
                Procedimiento::grabar($def['sp'], 'Insert', $parametros);
                $mensaje = 'Registro creado.';
            } else {
                Procedimiento::grabar($def['sp'], 'Update', ['pCodigo' => $this->idRegistro] + $parametros);
                $mensaje = 'Registro actualizado.';
            }
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages(['general' => 'No se pudo grabar: '.$e->getMessage()]);
        }

        $this->abierto = false;
        $this->dispatch('catalogo-guardado');
        $this->dispatch('aviso', tipo: 'ok', mensaje: $mensaje);
    }

    public function render()
    {
        $def = $this->def();
        $combos = [];
        if ($this->abierto) {
            foreach ($def['campos'] as $campo => $c) {
                if ($c[1] === 'combo') {
                    $combos[$campo] = Catalogo::opciones($c, $this->datos[$campo] ?? null);
                }
            }
        }

        return view('livewire.catalogo-formulario', compact('def', 'combos'));
    }
}
