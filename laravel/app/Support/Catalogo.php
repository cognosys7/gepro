<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Definicion de un catalogo (config/catalogos.php) y opciones de sus combos.
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

    /**
     * Opciones de un combo: GEN_TABLAS (activos, sin "eliminado" en la tabla 99, como SP_GEN_TABLAS
     * SelCampos) o la lista de otra tabla (sin los eliminados). Con $incluir se agrega el valor actual
     * aunque ya no este activo, para no perderlo al editar.
     */
    public static function opciones(array $campo, ?string $incluir = null): array
    {
        $o = $campo[2];
        if (isset($o['tabla'])) {
            $consulta = DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $o['tabla'])
                ->where(fn ($q) => $q->where('EST_ITEM', 1)->when($incluir !== null && $incluir !== '', fn ($q) => $q->orWhere('COD_ITEM', $incluir)))
                ->when($o['tabla'] === '99', fn ($q) => $q->where('COD_ITEM', '<>', '2'))
                ->orderBy('COD_ORDEN')->orderBy('DES_ITEM');

            return $consulta->pluck('DES_ITEM', 'COD_ITEM')->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
        }
        if (isset($o['lista'])) {
            [$tabla, $id, $descripcion, $estado] = $o['lista'];

            return DB::table($tabla)
                ->where(fn ($q) => $q->where($estado, '<>', '2')->orWhereNull($estado)->when($incluir !== null && $incluir !== '', fn ($q) => $q->orWhere($id, $incluir)))
                ->orderBy($descripcion)
                ->pluck($descripcion, $id)->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
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
            [$tabla, $id, $descripcion] = $o['lista'];

            return DB::table($tabla)->pluck($descripcion, $id)->mapWithKeys(fn ($d, $k) => [trim((string) $k) => trim((string) $d)])->all();
        }

        return [];
    }
}
