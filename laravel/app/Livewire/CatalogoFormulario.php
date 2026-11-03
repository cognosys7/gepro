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
 * - los parametros que no estan en el formulario se conservan como estan (al registrar van vacios o
 *   con 'nuevo_valores', que acepta {de.COLUMNA});
 * - los campos de solo lectura se toman siempre de la base; los 'calculado' los llena el SP;
 * - en las pantallas que dependen de otro registro ('de'), su columna toma el id de ese registro;
 * - 'calculo' => clase con calcular(datos, de): recalcula montos al escribir (p. ej. control mensual);
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

    /** Pantallas que dependen de otro registro: su id */
    #[Locked]
    public ?string $de = null;

    /** Calculo automatico de montos (casilla "Calcular montos automáticamente") */
    public bool $autoCalcular = true;

    public function mount(string $pagina, ?string $padre = null, ?string $de = null): void
    {
        Catalogo::definicion($pagina);
        $this->pagina = $pagina;
        $this->padre = $padre;
        $this->de = $de;
    }

    public function def(): array
    {
        return Catalogo::definicion($this->pagina);
    }

    private function filaDe(): ?object
    {
        return Catalogo::filaDe($this->def(), $this->de);
    }

    /** Valores que fija la jerarquia al registrar (tabla, padre, nivel...) */
    private function valoresJerarquia(): array
    {
        $def = $this->def();

        return Catalogo::contexto($def, Catalogo::fila($def, $this->padre))['valores'];
    }

    /** Columnas que fijan la jerarquia o el registro "de": no se editan */
    private function columnasFijas(): array
    {
        $def = $this->def();
        $j = $def['jerarquia'] ?? null;
        $fijas = $j ? array_keys(array_merge($j['raiz']['valores'] ?? [], $j['hijo']['valores'] ?? [])) : [];
        if (! empty($def['de'])) {
            $fijas[] = $def['de']['columna'];
        }

        return $fijas;
    }

    /** Valores iniciales al registrar ('nuevo_valores' con {de.COLUMNA}) */
    private function valoresNuevo(): array
    {
        $de = $this->filaDe();

        return array_map(fn ($v) => Catalogo::conDe((string) $v, $de), $this->def()['nuevo_valores'] ?? []);
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
        //CALCULADOS POR EL CALCULO AUTOMATICO: SE EDITAN SOLO SI ESTA DESACTIVADO
        if ($c && ! empty($c[2]['auto']) && $this->autoCalcular) {
            return true;
        }

        return ! $this->puedeGrabar() || ! $c || ! empty($c[2]['oculto']) || ! empty($c[2]['calculado'])
            || ! Catalogo::esColumna($c)
            || (! empty($c[2]['solo_lectura']) && $this->idRegistro !== null)
            || ! in_array($campo, $this->def()['parametros'], true)
            || in_array($campo, $this->columnasFijas(), true);
    }

    #[On('catalogo-nuevo')]
    public function nuevo(): void
    {
        if (empty($this->def()['nuevo']) || ! app(Seguridad::class)->puedeGrabar()) {
            return;
        }
        $def = $this->def();
        $this->resetValidation();
        $this->idRegistro = null;
        $this->autoCalcular = true;
        $this->datos = array_fill_keys(array_keys($def['campos']), '');
        $this->datos[$def['estado']] = '1';
        //VALORES INICIALES Y LOS QUE PONE LA JERARQUIA (P. EJ. EL RUBRO SUPERIOR)
        foreach (array_merge($this->valoresNuevo(), $this->valoresJerarquia()) as $columna => $valor) {
            if (array_key_exists($columna, $this->datos)) {
                //NUMEROS CON EL MISMO FORMATO QUE AL EDITAR ('.1800' -> '0.18')
                if (($def['campos'][$columna][1] ?? '') === 'numero' && is_numeric($valor)) {
                    $valor = rtrim(rtrim(number_format((float) $valor, 4, '.', ''), '0'), '.');
                }
                $this->datos[$columna] = $valor;
            }
        }
        $this->calcular();
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
        $this->autoCalcular = true;
        $this->datos = $this->valores($fila, array_keys(array_filter($this->def()['campos'], fn ($c) => Catalogo::esColumna($c))));
        $this->abierto = true;
    }

    private function leer(string $id): ?object
    {
        $def = $this->def();

        return DB::table($def['tabla'])->where($def['id'], $id)->where($def['estado'], '<>', Catalogo::eliminado($def))
            //EN UNA PANTALLA QUE DEPENDE DE OTRO REGISTRO, SOLO SUS PROPIAS FILAS
            ->when(! empty($def['de']), fn ($q) => $q->where($def['de']['columna'], $this->de))
            ->first();
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

    /** Recalcula los montos con la clase 'calculo' de la definicion (si el calculo automatico esta activo) */
    private function calcular(): void
    {
        $clase = $this->def()['calculo'] ?? null;
        if ($clase && $this->autoCalcular) {
            $this->datos = array_merge($this->datos, app($clase)->calcular($this->datos, $this->filaDe()));
        }
    }

    public function updatedDatos(): void
    {
        $this->calcular();
    }

    public function updatedAutoCalcular(): void
    {
        $this->calcular();
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
        //LOS MONTOS SE RECALCULAN AL ESCRIBIR (updatedDatos), NO AL GRABAR: ASI UN REGISTRO QUE SE GRABA
        //SIN CAMBIAR SUS IMPORTES CONSERVA LOS QUE TENIA (COMO EL SISTEMA ACTUAL)

        //VALORES QUE NO VIENEN DEL NAVEGADOR: PARAMETROS OCULTOS, SOLO LECTURA Y CALCULADOS (DE LA BASE)
        $base = [];
        if ($this->idRegistro !== null) {
            $actual = $this->leer($this->idRegistro);
            if (! $actual) {
                throw ValidationException::withMessages(['general' => 'El registro ya no existe.']);
            }
            $base = $this->valores($actual, $def['parametros']);
        } else {
            $base = $this->valoresNuevo();
        }
        $autoCalculados = array_keys(array_filter($def['campos'], fn ($c) => ! empty($c[2]['auto'])));
        $parametros = [];
        foreach ($def['parametros'] as $p) {
            $editable = isset($def['campos'][$p]) && (! $this->bloqueado($p) || (in_array($p, $autoCalculados, true) && $this->puedeGrabar()));
            $parametros[$p] = $editable ? trim((string) ($this->datos[$p] ?? '')) : ($base[$p] ?? '');
        }
        //AL REGISTRAR, LA JERARQUIA Y EL REGISTRO "de" FIJAN SUS COLUMNAS (AL EDITAR SE CONSERVAN)
        if ($this->idRegistro === null) {
            foreach ($this->valoresJerarquia() as $columna => $valor) {
                if (in_array($columna, $def['parametros'], true)) {
                    $parametros[$columna] = $valor;
                }
            }
            if (! empty($def['de'])) {
                abort_unless($this->filaDe(), 404);
                $parametros[$def['de']['columna']] = $this->de;
            }
        }

        //VALIDACION SEGUN LA DEFINICION (SOLO LOS CAMPOS EDITABLES)
        $reglas = [];
        $nombres = [];
        foreach ($def['campos'] as $campo => [$etiqueta, $tipo, $o]) {
            if ($this->bloqueado($campo) && ! in_array($campo, $autoCalculados, true)) {
                continue;
            }
            $r = [! empty($o['requerido']) ? 'required' : 'nullable'];
            if ($tipo === 'numero') {
                $r[] = 'numeric';
            } elseif ($tipo === 'fecha') {
                $r[] = 'date_format:Y-m-d';
            } elseif ($tipo === 'combo') {
                $r[] = Rule::in(array_map('strval', array_keys(Catalogo::opciones($def['campos'][$campo], $base[$campo] ?? null, $this->filaDe()))));
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
            $de = $this->filaDe();
            foreach ($def['campos'] as $campo => $c) {
                if ($c[1] === 'combo') {
                    $combos[$campo] = Catalogo::opciones($c, $this->datos[$campo] ?? null, $de);
                }
            }
        }

        return view('livewire.catalogo-formulario', compact('def', 'combos'));
    }
}
