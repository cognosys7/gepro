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
 * - 'segun': campos que se muestran (y su etiqueta) segun el valor de otro campo (p. ej. el tipo de ampliacion);
 * - tipo 'buscador': listas largas en las que se busca al escribir; 'rellena' copia columnas de la fila elegida;
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

    /** Texto escrito en los campos 'buscador': campo => texto */
    public array $buscando = [];

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
        if (! empty($def['de']['columna'])) {
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

    /** Caso de 'segun' del valor elegido (null = la definicion no tiene 'segun') */
    private function casoSegun(): ?array
    {
        $segun = $this->def()['segun'] ?? null;

        return $segun ? ($segun['casos'][trim((string) ($this->datos[$segun['campo']] ?? ''))] ?? []) : null;
    }

    /** Si el campo se muestra con el valor elegido en el campo de 'segun' */
    public function visible(string $campo): bool
    {
        $segun = $this->def()['segun'] ?? null;
        if (! $segun) {
            return true;
        }
        $variables = array_merge(...array_map('array_keys', array_values($segun['casos'])));

        return ! in_array($campo, $variables, true) || array_key_exists($campo, $this->casoSegun());
    }

    public function etiqueta(string $campo): string
    {
        $etiqueta = $this->casoSegun()[$campo] ?? '';

        return $etiqueta !== '' ? $etiqueta : $this->def()['campos'][$campo][0];
    }

    /** Si el calculo automatico corre con lo elegido ('segun' => ['calcular' => [...]]) */
    public function calculoAplica(): bool
    {
        $def = $this->def();
        if (empty($def['calculo'])) {
            return false;
        }
        $segun = $def['segun'] ?? null;

        return ! isset($segun['calcular']) || in_array(trim((string) ($this->datos[$segun['campo']] ?? '')), $segun['calcular'], true);
    }

    private function autoActivo(): bool
    {
        return $this->autoCalcular && $this->calculoAplica();
    }

    /**
     * Opciones del combo; 'una_vez' quita los valores que ya tiene otro registro del mismo "de"
     * (p. ej. el plazo contractual, como PROY_CONT_AMPLIACION_Datos_Contrato del sistema actual)
     */
    private function opcionesCampo(string $campo, ?string $incluir): array
    {
        $def = $this->def();
        $c = $def['campos'][$campo];
        $opciones = Catalogo::opciones($c, $incluir, $this->filaDe());
        if (! empty($c[2]['una_vez']) && ! empty($def['de']['columna']) && $this->de !== null) {
            $usados = DB::table($def['tabla'])->where($def['de']['columna'], $this->de)
                ->where($def['estado'], '<>', Catalogo::eliminado($def))
                ->when($this->idRegistro !== null, fn ($q) => $q->where($def['id'], '<>', $this->idRegistro))
                ->whereIn($campo, array_map('strval', $c[2]['una_vez']))
                ->pluck($campo)->map(fn ($v) => trim((string) $v))->all();
            $opciones = array_diff_key($opciones, array_flip($usados));
        }

        return $opciones;
    }

    /** Definicion del campo si es un 'buscador' que se puede cambiar */
    private function buscador(string $campo): ?array
    {
        $c = $this->def()['campos'][$campo] ?? null;

        return $c && $c[1] === 'buscador' && ! $this->bloqueado($campo) ? $c : null;
    }

    /** Filas que coinciden con lo escrito en un campo 'buscador' (desde dos letras) */
    public function resultados(string $campo): array
    {
        $c = $this->buscador($campo);
        $texto = trim((string) ($this->buscando[$campo] ?? ''));

        return $c && mb_strlen($texto) >= 2 ? Catalogo::buscarLista($c, $texto, $this->filaDe()) : [];
    }

    public function etiquetaBuscador(string $campo): string
    {
        $valor = trim((string) ($this->datos[$campo] ?? ''));

        return $valor === '' ? '' : Catalogo::etiquetaLista($this->def()['campos'][$campo], $valor);
    }

    public function elegir(string $campo, string $clave): void
    {
        $c = $this->buscador($campo);
        if (! $c || ! Catalogo::enLista($c, $clave, $this->filaDe())) {
            return;
        }
        $this->datos[$campo] = $clave;
        $this->buscando[$campo] = '';
        $this->resetValidation('datos.'.$campo);
        //COLUMNAS QUE SE COPIAN DE LA FILA ELEGIDA (P. EJ. LAS COORDENADAS DEL UBIGEO)
        if (! empty($c[2]['rellena'])) {
            $fila = DB::table($c[2]['lista'][0])->where($c[2]['lista'][1], $clave)->first();
            foreach ($c[2]['rellena'] as $destino => $origen) {
                $this->datos[$destino] = trim((string) ($fila->{$origen} ?? ''));
            }
        }
    }

    public function quitar(string $campo): void
    {
        if ($this->buscador($campo)) {
            $this->datos[$campo] = '';
        }
    }

    public function bloqueado(string $campo): bool
    {
        $c = $this->def()['campos'][$campo] ?? null;
        //CALCULADOS POR EL CALCULO AUTOMATICO: SE EDITAN SOLO SI ESTA DESACTIVADO
        if ($c && ! empty($c[2]['auto']) && $this->autoActivo()) {
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
        $this->buscando = [];
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
        $this->buscando = [];
        $this->datos = $this->valores($fila, array_keys(array_filter($this->def()['campos'], fn ($c) => Catalogo::esColumna($c))));
        $this->abierto = true;
    }

    private function leer(string $id): ?object
    {
        $def = $this->def();

        return DB::table($def['tabla'].' as T')->where('T.'.$def['id'], $id)->where('T.'.$def['estado'], '<>', Catalogo::eliminado($def))
            //EN UNA PANTALLA QUE DEPENDE DE OTRO REGISTRO, SOLO SUS PROPIAS FILAS
            ->when(! empty($def['de']), fn ($q) => Catalogo::filtrarDe($q, $def, $this->de, 'T'))
            ->select('T.*')->first();
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
            } elseif ($valor !== null && $tipo === 'combo') {
                $valor = Catalogo::clave($this->def()['campos'][$campo], $valor);
            }
            $datos[$campo] = $valor === null ? '' : trim((string) $valor);
        }

        return $datos;
    }

    /** Recalcula los montos con la clase 'calculo' de la definicion (si el calculo automatico esta activo) */
    private function calcular(): void
    {
        $clase = $this->def()['calculo'] ?? null;
        if ($clase && $this->autoActivo()) {
            $this->datos = array_merge($this->datos, app($clase)->calcular($this->datos, $this->filaDe()));
        }
    }

    public function updatedDatos($valor, $clave): void
    {
        //AL CAMBIAR EL CAMPO DE 'segun', EL CALCULO SE ACTIVA SOLO SI CORRE CON ESE VALOR (COMO LA CASILLA ACTUAL)
        if (isset($this->def()['segun']) && $clave === $this->def()['segun']['campo']) {
            $this->autoCalcular = $this->calculoAplica();
        }
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
                if (! empty($def['de']['columna'])) {
                    $parametros[$def['de']['columna']] = $this->de;
                }
            }
        }

        //VALIDACION SEGUN LA DEFINICION (SOLO LOS CAMPOS EDITABLES)
        $reglas = [];
        $nombres = [];
        foreach ($def['campos'] as $campo => [$etiqueta, $tipo, $o]) {
            if ($this->bloqueado($campo) && ! in_array($campo, $autoCalculados, true)) {
                continue;
            }
            $r = [! empty($o['requerido']) && $this->visible($campo) ? 'required' : 'nullable'];
            if ($tipo === 'numero') {
                $r[] = 'numeric';
            } elseif ($tipo === 'fecha') {
                $r[] = 'date_format:Y-m-d';
            } elseif ($tipo === 'combo') {
                $r[] = Rule::in(array_map('strval', array_keys($this->opcionesCampo($campo, $base[$campo] ?? null))));
            } elseif ($tipo === 'buscador') {
                //EL VALOR QUE YA TENIA EL REGISTRO SE CONSERVA AUNQUE HOY NO SE PUEDA ELEGIR
                $c = $def['campos'][$campo];
                $actual = (string) ($base[$campo] ?? '');
                $de = $this->filaDe();
                $r[] = function ($atributo, $valor, $falla) use ($c, $actual, $de) {
                    if ((string) $valor !== $actual && ! Catalogo::enLista($c, (string) $valor, $de)) {
                        $falla('El valor elegido no es válido.');
                    }
                };
            } else {
                $r[] = 'string';
                if (! empty($o['max'])) {
                    $r[] = 'max:'.$o['max'];
                }
                //CODIGOS QUE SOLO LLEVAN DIGITOS (P. EJ. EL CODIGO DEL PROCESO O EL RUC)
                if (! empty($o['digitos'])) {
                    $r[] = 'regex:/^[0-9]+$/';
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
                //CLAVE QUE ESCRIBE EL USUARIO (P. EJ. EL CODIGO DEL PROCESO): EL SP LA RECIBE EN @pCodigo
                $codigo = ! empty($def['codigo']) ? ['pCodigo' => $parametros[$def['codigo']]] : [];
                Procedimiento::grabar($def['sp'], 'Insert', $codigo + $parametros);
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
                    $combos[$campo] = $this->opcionesCampo($campo, $this->datos[$campo] ?? null);
                }
            }
        }

        return view('livewire.catalogo-formulario', compact('def', 'combos'));
    }
}
