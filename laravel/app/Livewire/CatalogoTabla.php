<?php

namespace App\Livewire;

use App\Services\Seguridad;
use App\Support\Catalogo;
use App\Support\Procedimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Grilla de cualquier catalogo de config/catalogos.php (reemplaza Flexigrid + SelGrd de su SP_<TABLA>):
 * filas no eliminadas, busqueda con parametros en las columnas de texto y orden antes de paginar.
 * Tambien sirve a las pantallas que dependen de otro registro ($de) y a los catalogos jerarquicos ($padre).
 */
class CatalogoTabla extends Component
{
    use WithPagination;

    #[Locked]
    public string $pagina;

    #[Url(as: 'q', except: '')]
    public string $buscar = '';

    #[Url(as: 'orden', except: '')]
    public string $orden = '';

    #[Url(as: 'dir', except: 'asc')]
    public string $direccion = 'asc';

    #[Url(as: 'n', except: 10)]
    public int $porPagina = 10;

    /** Catalogos jerarquicos: id del registro padre cuyos hijos se listan (null = raiz) */
    #[Locked]
    public ?string $padre = null;

    /** Nivel de la lista (1 = raiz) */
    #[Locked]
    public int $nivel = 1;

    /** Pantallas que dependen de otro registro (definicion 'de'): su id */
    #[Locked]
    public ?string $de = null;

    public function mount(string $pagina, ?string $padre = null, ?string $de = null): void
    {
        $def = Catalogo::definicion($pagina);
        $this->pagina = $pagina;
        if ($padre !== null && ! empty($def['jerarquia'])) {
            $fila = Catalogo::fila($def, $padre);
            abort_unless($fila, 404);
            $this->padre = (string) $padre;
            $this->nivel = count(Catalogo::cadena($def, $fila)) + 1;
        }
        if (! empty($def['de'])) {
            abort_unless($de !== null && Catalogo::filaDe($def, $de), 404);
            $this->de = (string) $de;
        }
        $this->validarOrden();
    }

    /** Si las filas de esta lista pueden tener hijos (boton para verlos) */
    public function conHijos(): bool
    {
        $j = $this->def()['jerarquia'] ?? null;

        return $j && $this->nivel < $j['niveles'];
    }

    public function urlHijos(int|string $id): string
    {
        return route('catalogos.index', ['pagina' => $this->pagina, 'padre' => $id]);
    }

    /**
     * URL de una accion de la fila ('acciones' en la definicion): otra pantalla de catalogos que depende
     * de este registro ('catalogo' => PAGINA) o una del sistema actual ('legado' => [Pagina, parametros])
     */
    public function urlAccion(array $accion, object $fila): string
    {
        $id = trim((string) $fila->ID);
        //ENLACE EXTERNO (P. EJ. LA FICHA DEL PROCESO EN EL SEACE): SE ABRE EN OTRA PESTAÑA
        if (isset($accion['url'])) {
            return str_replace('{id}', rawurlencode($id), $accion['url']);
        }
        //ENLACE GUARDADO EN UNA COLUMNA (P. EJ. LA RUTA DEL DOCUMENTO EN SHAREPOINT): SOLO SI ES http(s)
        if (isset($accion['campo'])) {
            $url = trim((string) ($fila->{$accion['campo']} ?? ''));

            return preg_match('#^https?://#i', $url) ? $url : '';
        }
        if (isset($accion['catalogo'])) {
            return route('catalogos.index', ['pagina' => $accion['catalogo'], 'de' => $id]);
        }
        [$pagina, $parametros] = $accion['legado'];
        $consulta = ['Pagina' => $pagina, 'Accion' => 'muestraVista', 'AccionLocal' => 2];
        foreach ($parametros as $nombre => $valor) {
            $consulta[$nombre] = str_replace(['{id}', '{de}'], [$id, (string) $this->de], (string) $valor);
        }
        $consulta['vmSinCabecera'] = 1;

        return app(Seguridad::class)->urlLegado('mainpage.php?'.http_build_query($consulta));
    }

    public function def(): array
    {
        return Catalogo::definicion($this->pagina);
    }

    public function puede(string $accion): bool
    {
        return ! empty($this->def()[$accion]) && app(Seguridad::class)->puedeGrabar();
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
        if (! array_key_exists($columna, Catalogo::columnasGrilla($this->def()))) {
            return;
        }
        $this->direccion = $this->orden === $columna && $this->direccion === 'asc' ? 'desc' : 'asc';
        $this->orden = $columna;
        $this->resetPage();
    }

    private function validarOrden(): void
    {
        $def = $this->def();
        $columnas = Catalogo::columnasGrilla($def);
        //SIN ORDEN ELEGIDO: EL DE LA DEFINICION ('orden') O LA PRIMERA COLUMNA DE TEXTO DE LA GRILLA
        if (! array_key_exists($this->orden, $columnas) && empty($def['orden'])) {
            $texto = array_keys(array_filter($columnas, fn ($c) => in_array($c[1], ['texto', 'area'], true)));
            $this->orden = $texto[0] ?? array_key_first($columnas);
        } elseif (! array_key_exists($this->orden, $columnas)) {
            $this->orden = '';
        }
        $this->direccion = $this->direccion === 'desc' ? 'desc' : 'asc';
    }

    #[On('catalogo-guardado')]
    public function recargar(): void
    {
    }

    /** Baja logica con el Delete de su SP */
    public function eliminar(int|string $id): void
    {
        $id = trim((string) $id);
        if (! $this->puede('eliminar') || ! preg_match('/^[A-Za-z0-9_-]{1,30}$/', $id)) {
            return;
        }
        $def = $this->def();
        //EN UNA PANTALLA QUE DEPENDE DE OTRO REGISTRO, SOLO SE ELIMINAN SUS PROPIAS FILAS
        if (! empty($def['de']) && ! Catalogo::filtrarDe(DB::table($def['tabla'].' as T')->where('T.'.$def['id'], $id), $def, $this->de, 'T')->exists()) {
            return;
        }
        try {
            Procedimiento::grabar($def['sp'], 'Delete', ['pCodigo' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Registro eliminado.');
        } catch (\RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    /** Expresion SQL de una columna de la grilla (columna de la tabla o expresion calculada) */
    private function expresion(string $columna, array $campo): string
    {
        return Catalogo::esColumna($campo) ? '[T].['.$columna.']' : $campo[2]['expresion'];
    }

    public function render()
    {
        $this->validarOrden();
        $def = $this->def();
        $columnas = Catalogo::columnasGrilla($def);
        $texto = trim($this->buscar);

        //JERARQUIA (RAIZ O HIJOS DEL PADRE), REGISTRO "de" Y FILTRO FIJO DEL CATALOGO (COMO SU SelGrd)
        $contexto = Catalogo::contexto($def, Catalogo::fila($def, $this->padre));
        $filtro = [];
        foreach (array_merge($def['filtro'] ?? [], $contexto['filtro']) as $columna => $valor) {
            $filtro['T.'.$columna] = $valor;
        }

        $consulta = DB::table($def['tabla'].' as T')
            //COMO SelGrd DE SU SP: estado <> eliminado (TAMPOCO MUESTRA LOS QUE TIENEN ESTADO NULL)
            ->where('T.'.$def['estado'], '<>', Catalogo::eliminado($def))
            ->when($filtro, fn ($q) => $q->where($filtro))
            ->when(! empty($def['de']), fn ($q) => Catalogo::filtrarDe($q, $def, $this->de, 'T'))
            ->when($texto !== '', function ($q) use ($texto, $columnas) {
                $patron = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%';
                $q->where(function ($q) use ($patron, $columnas) {
                    foreach ($columnas as $columna => $c) {
                        if (in_array($c[1], ['texto', 'area'], true) && Catalogo::esColumna($c)) {
                            $q->orWhere('T.'.$columna, 'like', $patron);
                        } elseif (! empty($c[2]['buscar'])) {
                            //CODIGOS NUMERICOS QUE TAMBIEN SE BUSCAN (P. EJ. EL CODIGO DEL PROCESO)
                            $q->orWhereRaw('CAST('.$this->expresion($columna, $c).' AS varchar(40)) LIKE ?', [$patron]);
                        }
                    }
                });
            })
            ->select('T.'.$def['id'].' as ID');
        foreach ($columnas as $columna => $c) {
            $consulta->selectRaw($this->expresion($columna, $c).' AS ['.$columna.']');
        }
        if ($this->orden !== '') {
            $consulta->orderByRaw($this->expresion($this->orden, $columnas[$this->orden]).' '.$this->direccion);
        } else {
            //ORDEN DE LA DEFINICION: COLUMNAS O EXPRESIONES (P. EJ. EL NOMBRE DEL PLAN, COMO SU SelGrd)
            foreach ($def['orden'] as [$columna, $direccion]) {
                $direccion = $direccion === 'desc' ? 'desc' : 'asc';
                str_contains($columna, '(') ? $consulta->orderByRaw($columna.' '.$direccion) : $consulta->orderBy('T.'.$columna, $direccion);
            }
        }
        //DESEMPATE POR LA CLAVE (SI NO ES YA UNA COLUMNA DEL ORDEN: SQL SERVER NO ACEPTA REPETIRLA)
        $porClave = $this->orden === $def['id'] || ($this->orden === '' && in_array($def['id'], array_column($def['orden'], 0), true));
        $filas = $consulta->when(! $porClave, fn ($q) => $q->orderBy('T.'.$def['id']))
            ->paginate($this->porPagina);

        //DESCRIPCIONES DE LOS COMBOS (INCLUIDO EL ESTADO) PARA MOSTRARLAS EN LUGAR DE LOS CODIGOS
        $etiquetas = [];
        foreach ($columnas as $columna => $c) {
            if ($c[1] === 'combo') {
                $etiquetas[$columna] = Catalogo::etiquetas($c);
            }
        }

        return view('livewire.catalogo-tabla', compact('def', 'columnas', 'filas', 'etiquetas'));
    }
}
