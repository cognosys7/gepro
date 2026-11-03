<?php

namespace App\Livewire\Seguridad;

use Illuminate\Database\Query\Builder;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

/**
 * Busqueda, orden y paginas de las grillas del sistema de seguridad (reemplazan Flexigrid y los
 * pa*Flexigrid, que reciben el filtro y el orden como texto SQL armado con lo que escribe el usuario).
 * Cada grilla declara columnas(): columna => [titulo, expresion SQL, se busca]; el orden solo acepta
 * esas columnas y la busqueda va con parametros.
 */
trait Grilla
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $buscar = '';

    #[Url(as: 'orden', except: '')]
    public string $orden = '';

    #[Url(as: 'dir', except: 'asc')]
    public string $direccion = 'asc';

    #[Url(as: 'n', except: 10)]
    public int $porPagina = 10;

    /** @return array<string, array{0: string, 1: string, 2: bool}> */
    abstract public function columnas(): array;

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
        if (! array_key_exists($columna, $this->columnas())) {
            return;
        }
        $this->direccion = $this->orden === $columna && $this->direccion === 'asc' ? 'desc' : 'asc';
        $this->orden = $columna;
        $this->resetPage();
    }

    /** Texto buscado en las columnas marcadas, sin distinguir mayusculas (LIKE con parametros) */
    protected function filtrar(Builder $consulta): Builder
    {
        $texto = trim($this->buscar);
        if ($texto === '') {
            return $consulta;
        }
        $patron = '%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $texto).'%';

        return $consulta->where(function ($q) use ($patron) {
            foreach ($this->columnas() as [, $expresion, $seBusca]) {
                if ($seBusca) {
                    $q->orWhereRaw($expresion.' LIKE ?', [$patron]);
                }
            }
        });
    }

    /** Orden elegido (solo columnas de la grilla) o el de la pantalla; luego $desempate */
    protected function ordenar(Builder $consulta, array $porDefecto, string $desempate): Builder
    {
        $columnas = $this->columnas();
        $this->direccion = $this->direccion === 'desc' ? 'desc' : 'asc';
        if (array_key_exists($this->orden, $columnas)) {
            $consulta->orderByRaw($columnas[$this->orden][1].' '.$this->direccion);
        } else {
            $this->orden = '';
            foreach ($porDefecto as $expresion) {
                $consulta->orderByRaw($expresion);
            }
        }

        return $consulta->orderByRaw($desempate);
    }
}
