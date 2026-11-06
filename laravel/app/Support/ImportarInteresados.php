<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Importa la matriz de interesados (antes migrar_INTERESADOSvista.php): la primera hoja pasa a etl_INTERESADOS
 * y sp_ETL_ImportarInteresados la lleva a CONT_INTERESADOS y PROY_INTERESADOS_SOCIAL.
 * - El archivo es uno solo para toda la entidad (GEN_ARCHIVO con registro 1) y puede traer varios proyectos.
 * - CARGAR: 0 omite la fila, 1 carga el interesado y 2 ademas lo enlaza a la gestion social.
 * - El SP solo agrega: quien ya esta en el contrato no se cambia. Tambien crea los recursos, roles y
 *   cargos nuevos, y descarta en silencio las filas cuyo proyecto o contrato no reconoce.
 * - Lo que haria perder una fila bloquea la migracion; un dato opcional que no esta en el catalogo solo
 *   se avisa, porque queda vacio (las matrices reales usan valores como FUERTE).
 */
class ImportarInteresados
{
    public const REGISTRO = 1;

    private const COLUMNAS = ['CARGAR', 'COD_UNICO', 'COD_CONTRATO', 'DES_COMUNIDAD', 'DES_RECURSO', 'DES_CARGO', 'DES_LOCALIZACION', 'DES_ROL',
        'DES_TELEFONO', 'DES_MAIL', 'DES_DIRECCION', 'DES_REQUERIMIENTOS_PRIMORDIALES', 'DES_EXPECTATIVAS_PRINCIPALES',
        'TIP_INFLUENCIA_POTENCIAL', 'DES_FASE_MAYOR_INTERES', 'TIP_INTERNO_EXTERNO', 'TIP_CLASIFICACION', 'DES_ESTRATEGIA_PRINCIPAL'];

    /** Tamano de las columnas de destino mas cortas que las de etl_INTERESADOS */
    private const MAXIMOS = ['DES_RECURSO' => 200, 'DES_CARGO' => 250, 'DES_ROL' => 150, 'DES_LOCALIZACION' => 100, 'DES_MAIL' => 100, 'DES_TELEFONO' => 50];

    /** Catalogos de nombres: columna => [tabla, id, descripcion, estado] */
    private const NOMBRES = [
        'DES_RECURSO' => ['GEN_RECURSO', 'IDE_RECURSO', 'DES_RECURSO', 'EST_RECURSO'],
        'DES_ROL' => ['GEN_ROLES', 'IDE_ROL', 'DES_ROL', 'EST_ROL'],
        'DES_CARGO' => ['GEN_CARGO', 'IDE_CARGO', 'DES_CARGO', 'EST_CARGO'],
        'DES_COMUNIDAD' => ['GEN_COMUNIDAD', 'IDE_COMUNIDAD', 'DES_COMUNIDAD', 'EST_COMUNIDAD'],
    ];

    /** Listas opcionales: columna => [GEN_TABLAS, etiqueta] */
    private const LISTAS = [
        'TIP_INFLUENCIA_POTENCIAL' => ['69', 'influencia'],
        'TIP_INTERNO_EXTERNO' => ['70', 'tipo interno o externo'],
        'TIP_CLASIFICACION' => ['71', 'clasificación'],
    ];

    private const MAX_MENSAJES = 20;

    public static function leer(string $ruta): array
    {
        return ExcelEtl::leerHojas($ruta, 1, function ($hoja) {
            if (ExcelEtl::titulo($hoja, 'A1') !== 'CARGAR' || ExcelEtl::titulo($hoja, 'B1') !== 'COD_UNICO') {
                throw new RuntimeException('La primera hoja no tiene el formato esperado: A1 debe ser CARGAR y B1 COD_UNICO.');
            }

            return ExcelEtl::filas($hoja, self::COLUMNAS, 'COD_UNICO');
        })[0];
    }

    private static function normal(string $valor): string
    {
        return mb_strtoupper(trim($valor));
    }

    /** Ids activos de cada nombre del catalogo: nombre => lista de ids */
    private static function nombres(array $c): array
    {
        [$tabla, $id, $descripcion, $estado] = $c;
        $porNombre = [];
        foreach (DB::table('dbo.'.$tabla)->where($estado, '<>', '2')->get([$id.' as id', $descripcion.' as nombre']) as $f) {
            $porNombre[self::normal((string) $f->nombre)][(int) $f->id] = true;
        }

        return array_map('array_keys', $porNombre);
    }

    /** Proyecto y contrato de la fila, por el mismo camino del SP: [proyecto, contrato, error] */
    private static function destino(string $interno, string $contrato): array
    {
        $proyecto = DB::table('dbo.PROYECTO')->where('COD_INTERNO', $interno)->where('EST_PROYECTO', '1')->first(['IDE_PROYECTO', 'COD_UNICO']);
        if (! $proyecto) {
            return [null, null, 'no se reconoce el proyecto "'.$interno.'".'];
        }
        $destinos = DB::table('dbo.PROYECTO_ACTIVIDAD as T')
            ->join('dbo.PROYECTO as P', 'P.IDE_PROYECTO', '=', 'T.IDE_PROYECTO')
            ->join('dbo.PROY_CONTRATO as PC', function ($j) {
                $j->on('PC.IDE_PROYECTO_ACTIVIDAD', '=', 'T.IDE_PROYECTO_ACTIVIDAD')->on('PC.IDE_PROYECTO', '=', 'P.IDE_PROYECTO');
            })
            ->join('dbo.CONTRATO as C', 'C.IDE_CONTRATO', '=', 'PC.IDE_CONTRATO')
            ->where('P.COD_UNICO', $proyecto->COD_UNICO)->where('T.TIP_PROYECTO_ACTIVIDAD', '1')->where('C.COD_CONTRATO_ENTIDAD', $contrato)
            ->distinct()->pluck('T.IDE_PROYECTO_ACTIVIDAD');
        if ($destinos->count() !== 1) {
            return [(int) $proyecto->IDE_PROYECTO, null, $destinos->isEmpty()
                ? 'el contrato "'.$contrato.'" no pertenece al proyecto "'.$interno.'".'
                : 'el contrato "'.$contrato.'" coincide con más de un registro del proyecto.'];
        }

        return [(int) $proyecto->IDE_PROYECTO, (int) $destinos->first(), null];
    }

    /** Revisa el archivo sin grabar nada */
    public static function revisar(array $filas, int $proyectoAbierto): array
    {
        $errores = [];
        $avisos = [];
        $catalogos = array_map(fn ($c) => self::nombres($c), self::NOMBRES);
        $listas = [];
        foreach (self::LISTAS as $campo => [$codigo]) {
            $listas[$campo] = DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $codigo)->where('EST_ITEM', '<>', '2')->pluck('DES_ITEM')
                ->mapWithKeys(fn ($v) => [self::normal((string) $v) => true])->all();
        }
        $destinos = [];
        $omitir = 0;
        $cargar = 0;
        $proyectos = [];
        $contratos = [];
        $nuevos = [];
        $existentes = [];
        $nuevosCatalogo = ['DES_RECURSO' => [], 'DES_ROL' => [], 'DES_CARGO' => []];
        $social = 0;

        foreach ($filas as $n => $fila) {
            $donde = 'Fila '.$n.': ';
            //EL SP BUSCA ESTOS NOMBRES EN TODAS LAS FILAS: UN NOMBRE REPETIDO LO HARIA FALLAR AUNQUE CARGAR SEA 0
            foreach ($catalogos as $campo => $porNombre) {
                if (count($porNombre[self::normal($fila[$campo])] ?? []) > 1) {
                    $errores[] = $donde.'"'.$fila[$campo].'" está repetido en el catálogo '.self::NOMBRES[$campo][0].'.';
                }
            }
            if ($fila['CARGAR'] === '0') {
                $omitir++;

                continue;
            }
            if (! in_array($fila['CARGAR'], ['1', '2'], true)) {
                $errores[] = $donde.'CARGAR debe ser 0, 1 o 2.';

                continue;
            }
            $cargar++;
            foreach (self::COLUMNAS as $campo) {
                $maximo = self::MAXIMOS[$campo] ?? 255;
                if (mb_strlen($fila[$campo]) > $maximo) {
                    $errores[] = $donde.$campo.' supera los '.$maximo.' caracteres.';
                }
            }
            if ($fila['DES_RECURSO'] === '') {
                $errores[] = $donde.'falta el nombre del interesado (DES_RECURSO).';
            }
            foreach (self::LISTAS as $campo => [, $etiqueta]) {
                if ($fila[$campo] !== '' && ! isset($listas[$campo][self::normal($fila[$campo])])) {
                    $avisos[$campo.'|'.self::normal($fila[$campo])] = 'El valor "'.$fila[$campo].'" de '.$etiqueta.' no está en el catálogo: quedará vacío.';
                }
            }

            $clave = $fila['COD_UNICO']."\n".$fila['COD_CONTRATO'];
            [$proyecto, $contrato, $problema] = $destinos[$clave] ??= self::destino($fila['COD_UNICO'], $fila['COD_CONTRATO']);
            if ($problema) {
                $errores[] = $donde.$problema;

                continue;
            }
            $proyectos[$fila['COD_UNICO']] = $proyecto;
            $contratos[$contrato] = true;
            foreach ($nuevosCatalogo as $campo => $valores) {
                $valor = self::normal($fila[$campo]);
                if ($valor !== '' && ! isset($catalogos[$campo][$valor])) {
                    $nuevosCatalogo[$campo][$valor] = true;
                }
            }
            if ($fila['CARGAR'] === '2') {
                $social++;
                if ($fila['DES_COMUNIDAD'] === '') {
                    $errores[] = $donde.'con CARGAR = 2 hace falta la comunidad.';
                } else {
                    $comunidad = $catalogos['DES_COMUNIDAD'][self::normal($fila['DES_COMUNIDAD'])][0] ?? null;
                    if (! $comunidad || ! DB::table('dbo.PROY_GESTION_SOCIAL')->where('IDE_PROYECTO', $proyecto)->where('IDE_COMUNIDAD', $comunidad)->where('EST_GESTION_SOCIAL', '<>', '2')->exists()) {
                        $errores[] = $donde.'la comunidad "'.$fila['DES_COMUNIDAD'].'" no tiene gestión social en el proyecto.';
                    }
                }
            }

            $idRecurso = $catalogos['DES_RECURSO'][self::normal($fila['DES_RECURSO'])][0] ?? null;
            $ya = $idRecurso && DB::table('dbo.CONT_INTERESADOS')->where('IDE_CONTRATO', $contrato)->where('IDE_RECURSO', $idRecurso)->where('EST_CONT_INTERESADO', '<>', '2')->exists();
            if ($ya) {
                $existentes[$contrato.'|'.$idRecurso] = true;
            } else {
                $nuevos[$contrato.'|'.self::normal($fila['DES_RECURSO'])] = true;
            }
        }
        if ($cargar === 0) {
            $errores[] = 'El archivo no tiene filas para cargar.';
        }

        return [
            'cargar' => $cargar,
            'omitir' => $omitir,
            'social' => $social,
            'proyectos' => array_map('strval', array_keys($proyectos)),
            'incluyeAbierto' => in_array($proyectoAbierto, $proyectos, true),
            'contratos' => count($contratos),
            'nuevos' => count($nuevos),
            'existentes' => count($existentes),
            'catalogos' => array_map('count', $nuevosCatalogo),
            'errores' => array_slice($errores, 0, self::MAX_MENSAJES),
            'mas_errores' => max(0, count($errores) - self::MAX_MENSAJES),
            'avisos' => array_slice(array_values($avisos), 0, self::MAX_MENSAJES),
        ];
    }

    /**
     * Migra el archivo: vuelve a leerlo y revisarlo, y graba todo o nada.
     *
     * @return array{interesados: int, sociales: int, existentes: int}
     */
    public static function importar(string $ruta, int $proyectoAbierto): array
    {
        $filas = self::leer($ruta);
        $revision = self::revisar($filas, $proyectoAbierto);
        if ($revision['errores']) {
            throw new RuntimeException($revision['errores'][0]);
        }

        return DB::transaction(function () use ($filas, $revision) {
            $interesados = DB::table('dbo.CONT_INTERESADOS')->count();
            $sociales = DB::table('dbo.PROY_INTERESADOS_SOCIAL')->count();
            ExcelEtl::cargar('etl_INTERESADOS', $filas, self::COLUMNAS);
            ExcelEtl::ejecutarSp('sp_ETL_ImportarInteresados');

            $perdidas = DB::table('dbo.etl_INTERESADOS')->whereIn('CARGAR_etx', ['1', '2'])
                ->where(fn ($q) => $q->whereNull('IDE_CONTRATO_fin')->orWhereNull('IDE_RECURSO_fin')->orWhereNull('IDE_CONT_INTERESADO'))->count();
            if ($perdidas > 0) {
                throw new RuntimeException('No se aplicó ningún cambio: '.$perdidas.' fila(s) no se pudieron relacionar con su contrato.');
            }

            return [
                'interesados' => DB::table('dbo.CONT_INTERESADOS')->count() - $interesados,
                'sociales' => DB::table('dbo.PROY_INTERESADOS_SOCIAL')->count() - $sociales,
                'existentes' => $revision['existentes'],
            ];
        });
    }
}
