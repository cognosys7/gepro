<?php

namespace App\Support;

/**
 * Opciones del menu (seguridad.tsopcion) en el orden en que se ven: cada opcion principal (nivel 1)
 * seguida de sus secundarias, todas por opcorden. Es el orden que usa el menu y el que cambian Subir y
 * Bajar (paActualizaOrdenOpcion). Los pa*Flexigrid del sistema actual ordenan por opcorden2, que Subir y
 * Bajar no actualizan, asi que alli la lista no siempre coincide con el menu.
 */
class ArbolOpciones
{
    /**
     * @param  iterable<object>  $filas  con idopcion, opcmodulo, opcnivel, opcpadre y opcorden
     * @return list<object> las mismas filas en orden; las secundarias sin principal activa van al final
     *                      de su modulo. Cada fila recibe 'primera' y 'ultima' (entre sus hermanas).
     */
    public static function ordenar(iterable $filas): array
    {
        $porModulo = [];
        foreach ($filas as $f) {
            $porModulo[(int) $f->opcmodulo][] = $f;
        }
        $resultado = [];
        foreach ($porModulo as $opciones) {
            $ids = [];
            foreach ($opciones as $f) {
                $ids[(int) $f->idopcion] = true;
            }
            $hijos = [];
            $sueltas = [];
            foreach ($opciones as $f) {
                $padre = (int) $f->opcnivel === 1 ? 0 : (int) $f->opcpadre;
                if ($padre !== 0 && ! isset($ids[$padre])) {
                    $sueltas[] = $f;
                } else {
                    $hijos[$padre][] = $f;
                }
            }
            $vistas = [];
            $agregar = function (int $padre) use (&$agregar, &$resultado, &$vistas, $hijos) {
                $lista = $hijos[$padre] ?? [];
                usort($lista, fn ($a, $b) => [(int) $a->opcorden, (int) $a->idopcion] <=> [(int) $b->opcorden, (int) $b->idopcion]);
                foreach ($lista as $i => $f) {
                    $f->primera = $i === 0;
                    $f->ultima = $i === count($lista) - 1;
                    $resultado[] = $f;
                    $vistas[(int) $f->idopcion] = true;
                    $agregar((int) $f->idopcion);
                }
            };
            $agregar(0);
            //SECUNDARIAS SIN PRINCIPAL ACTIVA (Y LAS QUE FORMAN UN CICLO, QUE NUNCA SE ALCANZAN DESDE LA RAIZ)
            foreach ($opciones as $f) {
                if (! isset($vistas[(int) $f->idopcion]) && ! in_array($f, $sueltas, true)) {
                    $sueltas[] = $f;
                }
            }
            foreach ($sueltas as $f) {
                $f->primera = $f->ultima = true;
                $resultado[] = $f;
            }
        }

        return $resultado;
    }
}
