<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Definicion de un catalogo (config/catalogos.php), opciones de sus combos, la relacion padre-hijos
 * de los catalogos jerarquicos y el registro "de" en las pantallas que dependen de otro registro
 * (Etapas de un contrato, Control de una etapa, Control mensual de un control anual...).
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
        $def = config('catalogos.'.$pagina);
        //'base': LA MISMA PANTALLA DE OTRO CATALOGO CON OTRO FILTRO (P. EJ. EL PROCESO DE UN CONTRATO)
        if (! empty($def['base'])) {
            $def = array_merge(config('catalogos.'.$def['base']), $def);
        }

        return $def;
    }

    /** Valor del estado que significa "eliminado" (baja logica del SP): '2' salvo que se indique otro */
    public static function eliminado(array $def): string
    {
        return (string) ($def['eliminado'] ?? '2');
    }

    /** Campos que se muestran en la grilla */
    public static function columnasGrilla(array $def): array
    {
        return array_filter($def['campos'], fn ($c) => ! empty($c[2]['grilla']));
    }

    /** Columnas de la tabla (las de expresion son calculadas: solo grilla) */
    public static function esColumna(array $campo): bool
    {
        return empty($campo[2]['expresion']);
    }

    /** Reemplaza {de.COLUMNA} con los valores del registro "de" */
    public static function conDe(string $texto, ?object $de): string
    {
        return preg_replace_callback('/\{de\.(\w+)\}/', fn ($m) => trim((string) ($de->{$m[1]} ?? '')), $texto);
    }

    /** Descripcion de una lista: una columna o una expresion SQL */
    private static function expresionLista(array $lista): string
    {
        return str_contains($lista[2], '(') ? $lista[2] : '['.$lista[2].']';
    }

    /** Solo las filas de la lista que no estan eliminadas */
    private static function activos($consulta, array $lista)
    {
        return $consulta->where(fn ($q) => $q->where($lista[3], '<>', '2')->orWhereNull($lista[3]));
    }

    /** Lista de otra tabla: [tabla, id, descripcion, estado, filtro opcional]; la descripcion puede ser una expresion */
    private static function consultaLista(array $lista, ?object $de = null, array $opciones = [])
    {
        [$tabla, $id] = $lista;
        $expresion = self::expresionLista($lista);

        return DB::table($tabla)
            ->when(! empty($lista[4]), fn ($q) => $q->where($lista[4]))
            //FILTRO QUE DEPENDE DEL REGISTRO "de": ['SQL CON ?', ['{de.COLUMNA}']]
            ->when(! empty($opciones['filtro_sql']), function ($q) use ($opciones, $de) {
                [$sql, $valores] = $opciones['filtro_sql'];
                $q->whereRaw($sql, array_map(fn ($v) => self::conDe((string) $v, $de), $valores));
            })
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
     * Opciones de un combo: GEN_TABLAS (activos; sin "eliminado" en la tabla 99, como SP_GEN_TABLAS
     * SelCampos; 'solo' limita a esos codigos y 'excluir' los quita) o la lista de otra tabla (sin los
     * eliminados). Con $incluir se agrega el valor actual aunque ya no este activo, para no perderlo.
     */
    public static function opciones(array $campo, ?string $incluir = null, ?object $de = null): array
    {
        return self::normalizar($campo, self::opcionesSinNormalizar($campo, $incluir, $de));
    }

    /**
     * 'clave_numerica': la columna es numerica pero GEN_TABLAS guarda el codigo con ceros ('07'), o la
     * columna guarda la clave con decimales ('1.000'): las claves se comparan como enteros ('7', '1')
     */
    public static function clave(array $campo, mixed $valor): string
    {
        $valor = trim((string) $valor);

        return ! empty($campo[2]['clave_numerica']) && is_numeric($valor) ? (string) (int) $valor : $valor;
    }

    private static function normalizar(array $campo, array $opciones): array
    {
        if (empty($campo[2]['clave_numerica'])) {
            return $opciones;
        }
        $r = [];
        foreach ($opciones as $k => $v) {
            $r[is_numeric($k) ? (string) (int) $k : (string) $k] = $v;
        }

        return $r;
    }

    private static function opcionesSinNormalizar(array $campo, ?string $incluir, ?object $de): array
    {
        $o = $campo[2];
        $conIncluir = $incluir !== null && $incluir !== '';
        $excluir = array_map('strval', $o['excluir'] ?? []);
        //VALORES FIJOS (LA COLUMNA GUARDA EL TEXTO, P. EJ. EL ESTADO DEL ITEM DE UN PROCESO)
        if (isset($o['valores'])) {
            $valores = array_combine($o['valores'], $o['valores']);

            return $conIncluir && ! isset($valores[$incluir]) ? $valores + [$incluir => $incluir] : $valores;
        }
        if (isset($o['tabla'])) {
            if ($o['tabla'] === '99') {
                $excluir[] = '2';
            }

            return DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $o['tabla'])
                ->where(fn ($q) => $q->where('EST_ITEM', 1)->when($conIncluir, fn ($q) => $q->orWhere('COD_ITEM', $incluir)))
                ->when($excluir, fn ($q) => $q->whereNotIn('COD_ITEM', $excluir))
                ->when(! empty($o['solo']), fn ($q) => $q->whereIn('COD_ITEM', array_map('strval', $o['solo'])))
                ->orderBy('COD_ORDEN')->orderBy('DES_ITEM')
                ->pluck('DES_ITEM', 'COD_ITEM')->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
        }
        if (isset($o['lista'])) {
            $id = $o['lista'][1];
            $opciones = self::aOpciones(self::activos(self::consultaLista($o['lista'], $de, $o), $o['lista'])
                ->when($excluir, fn ($q) => $q->whereNotIn($id, $excluir))
                ->get());
            //EL VALOR ACTUAL NO SE PIERDE AUNQUE ESTE ELIMINADO O FUERA DEL FILTRO DE LA LISTA
            if ($conIncluir && ! isset($opciones[$incluir]) && ! in_array($incluir, $excluir, true)) {
                $opciones += self::filaFuera($o['lista'], $incluir);
            }

            return $opciones;
        }

        return [];
    }

    /** La fila de una lista por su clave, sin el filtro de la lista ni su estado */
    private static function filaFuera(array $lista, string $valor): array
    {
        unset($lista[4]);

        return self::aOpciones(self::consultaLista($lista)->where($lista[1], $valor)->get());
    }

    /**
     * Campo 'buscador' (listas largas, p. ej. UBIGEO o comunidades): las filas activas cuya descripcion
     * contiene todas las palabras escritas
     */
    public static function buscarLista(array $campo, string $texto, ?object $de = null, int $limite = 15): array
    {
        $o = $campo[2];
        $consulta = self::activos(self::consultaLista($o['lista'], $de, $o), $o['lista']);
        foreach (preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY) as $palabra) {
            $consulta->whereRaw(self::expresionLista($o['lista']).' LIKE ?', ['%'.str_replace(['[', '%', '_'], ['[[]', '[%]', '[_]'], $palabra).'%']);
        }

        return self::aOpciones($consulta->limit($limite)->get());
    }

    /** Si la clave se puede elegir en el campo 'buscador' */
    public static function enLista(array $campo, string $valor, ?object $de = null): bool
    {
        $o = $campo[2];

        return self::activos(self::consultaLista($o['lista'], $de, $o), $o['lista'])->where($o['lista'][1], $valor)->limit(1)->get()->isNotEmpty();
    }

    /** Descripcion del valor elegido en el campo 'buscador' */
    public static function etiquetaLista(array $campo, string $valor): string
    {
        return (string) (array_values(self::filaFuera($campo[2]['lista'], $valor))[0] ?? $valor);
    }

    /** Todas las descripciones de un combo (tambien inactivas), para mostrar los valores en la grilla */
    public static function etiquetas(array $campo): array
    {
        return self::normalizar($campo, self::etiquetasSinNormalizar($campo));
    }

    private static function etiquetasSinNormalizar(array $campo): array
    {
        $o = $campo[2];
        if (isset($o['valores'])) {
            return array_combine($o['valores'], $o['valores']);
        }
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
     * REGISTRO "de" ('de' en la definicion): la pantalla lista los registros de otro (p. ej. las etapas
     * de un contrato). ['tabla', 'id', 'columna' (la de esta tabla que apunta a el), 'titulo' (expresion
     * SQL sobre la tabla "de" para la cabecera)]. Al registrar, "columna" toma su id.
     */
    public static function filaDe(array $def, int|string|null $id): ?object
    {
        if (empty($def['de']) || $id === null || $id === '') {
            return null;
        }
        $d = $def['de'];

        return DB::table($d['tabla'].' as X')->where('X.'.$d['id'], $id)
            ->select('X.*')->selectRaw(($d['titulo'] ?? "''").' AS TITULO_DE')->first();
    }

    /**
     * Limita una consulta (tabla con alias) a las filas del registro "de": por su 'columna' o, si la
     * tabla no apunta directo a el, con 'enlace' (SQL con {T} = alias y ? = id del registro "de"; p. ej.
     * los contratos de un PROYECTO_ACTIVIDAD a traves de PROY_CONTRATO)
     */
    public static function filtrarDe($consulta, array $def, int|string|null $de, string $alias)
    {
        $d = $def['de'];
        if (! empty($d['enlace'])) {
            return $consulta->whereRaw(str_replace('{T}', $alias, $d['enlace']), [$de]);
        }

        return $consulta->where($alias.'.'.$d['columna'], $de);
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

        return DB::table($def['tabla'])->where($def['id'], $id)->where($def['estado'], '<>', self::eliminado($def))->first();
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
            $fila = DB::table($def['tabla'])->where($condiciones)->where($def['estado'], '<>', self::eliminado($def))->first();
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
