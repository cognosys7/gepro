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
 * filas no eliminadas (estado <> '2'), busqueda con parametros en las columnas de texto y orden
 * por las columnas de la grilla antes de paginar.
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

    public function mount(string $pagina, ?string $padre = null): void
    {
        $def = Catalogo::definicion($pagina);
        $this->pagina = $pagina;
        if ($padre !== null && ! empty($def['jerarquia'])) {
            $fila = Catalogo::fila($def, $padre);
            abort_unless($fila, 404);
            $this->padre = (string) $padre;
            $this->nivel = count(Catalogo::cadena($def, $fila)) + 1;
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
        $columnas = Catalogo::columnasGrilla($this->def());
        if (! array_key_exists($this->orden, $columnas)) {
            //POR DEFECTO, LA PRIMERA COLUMNA DE TEXTO DE LA GRILLA
            $texto = array_keys(array_filter($columnas, fn ($c) => in_array($c[1], ['texto', 'area'], true)));
            $this->orden = $texto[0] ?? array_key_first($columnas);
        }
        $this->direccion = $this->direccion === 'desc' ? 'desc' : 'asc';
    }

    #[On('catalogo-guardado')]
    public function recargar(): void
    {
    }

    /** Baja logica con el Delete de su SP (pone el estado en '2') */
    public function eliminar(int|string $id): void
    {
        $id = trim((string) $id);
        if (! $this->puede('eliminar') || ! preg_match('/^[A-Za-z0-9_-]{1,30}$/', $id)) {
            return;
        }
        $def = $this->def();
        try {
            Procedimiento::grabar($def['sp'], 'Delete', ['pCodigo' => $id, 'pUsuario' => (int) Auth::id()]);
            $this->dispatch('aviso', tipo: 'ok', mensaje: 'Registro eliminado.');
        } catch (\RuntimeException $e) {
            $this->dispatch('aviso', tipo: 'error', mensaje: 'No se pudo eliminar: '.$e->getMessage());
        }
    }

    public function render()
    {
        $this->validarOrden();
        $def = $this->def();
        $columnas = Catalogo::columnasGrilla($def);
        $texto = trim($this->buscar);

        //JERARQUIA: LA RAIZ O LOS HIJOS DEL PADRE; FILTRO FIJO DEL CATALOGO (COMO SU SelGrd)
        $contexto = Catalogo::contexto($def, Catalogo::fila($def, $this->padre));
        $filtro = [];
        foreach (array_merge($def['filtro'] ?? [], $contexto['filtro']) as $columna => $valor) {
            $filtro['T.'.$columna] = $valor;
        }

        $filas = DB::table($def['tabla'].' as T')
            //COMO SelGrd DE SU SP: estado <> '2' (TAMPOCO MUESTRA LOS QUE TIENEN ESTADO NULL)
            ->where('T.'.$def['estado'], '<>', '2')
            ->when($filtro, fn ($q) => $q->where($filtro))
            ->when($texto !== '', function ($q) use ($texto, $columnas) {
                $patron = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%';
                $q->where(function ($q) use ($patron, $columnas) {
                    foreach ($columnas as $columna => $c) {
                        if (in_array($c[1], ['texto', 'area'], true)) {
                            $q->orWhere('T.'.$columna, 'like', $patron);
                        }
                    }
                });
            })
            ->orderBy('T.'.$this->orden, $this->direccion)
            //DESEMPATE POR LA CLAVE (SI NO ES YA LA COLUMNA DEL ORDEN: SQL SERVER NO ACEPTA REPETIRLA)
            ->when($this->orden !== $def['id'], fn ($q) => $q->orderBy('T.'.$def['id']))
            ->select(array_merge(['T.'.$def['id'].' as ID'], array_map(fn ($c) => 'T.'.$c, array_keys($columnas))))
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
