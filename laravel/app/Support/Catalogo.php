<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Definicion de un catalogo (config/catalogos.php), opciones de sus combos y, en los catalogos
 * jerarquicos (Tablas maestras, Entregables, Concepto de gestion social), la relacion padre-hijos.
 */
class Catalogo
{
    public static function existe(string $pagina): bool
    {
        return preg_match('/^[A-Za-z0-9_]+$/', $pagina) && is_array(config('catalogos.'.$pagina));
    }

    public static function definicion(string $pagina): array
    {
        abort_unless(self::existe($pagina), 404);

        return config('catalogos.'.$pagina);
    }

    /** Campos que se muestran en la grilla */
    public static function columnasGrilla(array $def): array
    {
        return array_filter($def['campos'], fn ($c) => ! empty($c[2]['grilla']));
    }

    /** Lista de otra tabla: [tabla, id, descripcion, estado, filtro opcional]; la descripcion puede ser una expresion */
    private static function consultaLista(array $lista)
    {
        [$tabla, $id, $descripcion] = $lista;
        $expresion = str_contains($descripcion, '(') ? $descripcion : '['.$descripcion.']';

        return DB::table($tabla)
            ->when(! empty($lista[4]), fn ($q) => $q->where($lista[4]))
            ->selectRaw($expresion.' AS D, ['.$id.'] AS K')
            ->orderBy('D');
    }

    private static function aOpciones($filas): array
    {
        $r = [];
        foreach ($filas as $f) {
            $r[trim((string) $f->K)] = trim((string) $f->D);
        }

        return $r;
    }

    /**
     * Opciones de un combo: GEN_TABLAS (activos, sin "eliminado" en la tabla 99, como SP_GEN_TABLAS
     * SelCampos) o la lista de otra tabla (sin los eliminados). Con $incluir se agrega el valor actual
     * aunque ya no este activo, para no perderlo al editar.
     */
    public static function opciones(array $campo, ?string $incluir = null): array
    {
        $o = $campo[2];
        $conIncluir = $incluir !== null && $incluir !== '';
        if (isset($o['tabla'])) {
            return DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $o['tabla'])
                ->where(fn ($q) => $q->where('EST_ITEM', 1)->when($conIncluir, fn ($q) => $q->orWhere('COD_ITEM', $incluir)))
                ->when($o['tabla'] === '99', fn ($q) => $q->where('COD_ITEM', '<>', '2'))
                ->orderBy('COD_ORDEN')->orderBy('DES_ITEM')
                ->pluck('DES_ITEM', 'COD_ITEM')->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
        }
        if (isset($o['lista'])) {
            $estado = $o['lista'][3];
            $id = $o['lista'][1];

            return self::aOpciones(self::consultaLista($o['lista'])
                ->where(fn ($q) => $q->where(fn ($q) => $q->where($estado, '<>', '2')->orWhereNull($estado))
                    ->when($conIncluir, fn ($q) => $q->orWhere($id, $incluir)))
                ->get());
        }

        return [];
    }

    /** Todas las descripciones de un combo (tambien inactivas), para mostrar los valores en la grilla */
    public static function etiquetas(array $campo): array
    {
        $o = $campo[2];
        if (isset($o['tabla'])) {
            return DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $o['tabla'])
                ->pluck('DES_ITEM', 'COD_ITEM')->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
        }
        if (isset($o['lista'])) {
            $lista = $o['lista'];
            unset($lista[4]);

            return self::aOpciones(self::consultaLista($lista)->get());
        }

        return [];
    }

    /*
     * JERARQUIA ('jerarquia' en la definicion):
     * - raiz / hijo: ['filtro' => [...], 'valores' => [...]]: condiciones de la grilla y valores que se
     *   graban al registrar en la raiz o bajo un padre. En "hijo", {id} es el id del padre, {COLUMNA} un
     *   valor del padre y {COLUMNA+1} ese valor mas uno.
     * - padre: condiciones para encontrar el padre de un registro ({COLUMNA} = valor del registro).
     * - niveles: cuantos niveles se pueden abrir; boton: [texto, icono] para ver los hijos.
     */

    /** Reemplaza {id}, {COLUMNA} y {COLUMNA+N} con los valores de una fila */
    public static function resolver(array $plantilla, ?object $fila, string $columnaId): array
    {
        $r = [];
        foreach ($plantilla as $columna => $valor) {
            $r[$columna] = preg_replace_callback('/\{(\w+)(?:\+(\d+))?\}/', function ($m) use ($fila, $columnaId) {
                $v = $m[1] === 'id' ? ($fila->{$columnaId} ?? '') : ($fila->{$m[1]} ?? '');
                $v = trim((string) $v);

                return isset($m[2]) ? (string) ((int) $v + (int) $m[2]) : $v;
            }, (string) $valor);
        }

        return $r;
    }

    public static function fila(array $def, int|string|null $id): ?object
    {
        if ($id === null || $id === '') {
            return null;
        }

        return DB::table($def['tabla'])->where($def['id'], $id)->where($def['estado'], '<>', '2')->first();
    }

    /** Cadena de padres de un registro, desde la raiz hasta el (incluido) */
    public static function cadena(array $def, ?object $fila): array
    {
        $cadena = [];
        $vistos = [];
        while ($fila && empty($vistos[$fila->{$def['id']}]) && count($cadena) < 10) {
            $vistos[$fila->{$def['id']}] = true;
            array_unshift($cadena, $fila);
            $condiciones = self::resolver($def['jerarquia']['padre'], $fila, $def['id']);
            if (in_array('', $condiciones, true)) {
                break;
            }
            $fila = DB::table($def['tabla'])->where($condiciones)->where($def['estado'], '<>', '2')->first();
        }

        return $cadena;
    }

    /** Condiciones de la grilla y valores a grabar para la raiz o bajo el padre indicado */
    public static function contexto(array $def, ?object $padre): array
    {
        if (empty($def['jerarquia'])) {
            return ['filtro' => [], 'valores' => []];
        }
        $j = $def['jerarquia'];
        $parte = $padre ? $j['hijo'] : $j['raiz'];

        return [
            'filtro' => self::resolver($parte['filtro'], $padre, $def['id']),
            'valores' => self::resolver($parte['valores'] ?? [], $padre, $def['id']),
        ];
    }
}
