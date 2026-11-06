<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Importa el Excel de control de un contrato (antes migrar_Importar_SQLSERVERvista.php): las hojas 1, 2 y 3
 * pasan a las tablas etl_OBR_* y los sp_ETL_ImportarControlCostos_OBR_* las llevan a PROY_CONT_ETAPA_CONTROL
 * y PROY_CONT_COMP_CONTROL_DET.
 * - Primero se revisa todo el archivo: si una fila es dudosa no se graba nada.
 * - Todo corre en una transaccion. Los SP capturan sus errores sin avisar, por eso se comprueba
 *   @@TRANCOUNT despues de cada uno y las filas que quedaron sin reconocer.
 * - Los SP corren dos veces, como en el sistema actual: la primera pasada crea la etapa y el control
 *   anual que falten y la segunda inserta el detalle de esos controles.
 */
class ImportarControl
{
    private const COMUNES = ['CARGAR', 'TIPO', 'CONTRATO', 'COD_GESTION_CAMBIO', 'DESCRIPCION_GC', 'TIP_CONCEPTO', 'ITEM', 'ANIO', 'MES', 'CONCEPTO_PAGO'];

    private const IMPORTES_PLAN = ['AVANCE', 'MONTO_BRUTO', 'AMORTIZACION', 'SALDO_SIN_IGV', 'PCT_IGV', 'MTO_IGV', 'MTO_NETO'];

    private const IMPORTES_REAL = ['AVANCE', 'MONTO_BRUTO', 'REAJUSTE', 'AMORT_ADEL_DIR', 'AMORT_ADEL_MAT', 'AMORTIZACION', 'SALDO_SIN_IGV',
        'DEDUC_ADEL_DIR', 'DEDUC_ADEL_MAT', 'MTO_IMPONIBLE', 'PCT_IGV', 'MTO_IGV', 'MTO_NETO', 'IMP_PENALIDAD', 'IMP_RETENCION', 'IMP_PAGO'];

    /** Hojas en el orden del archivo: clave => [nombre, tabla etl, SP, importes] */
    private const HOJAS = [
        'PROG' => ['Programado', 'etl_OBR_PROG', 'sp_ETL_ImportarControlCostos_OBR_PROG', self::IMPORTES_PLAN],
        'REAL' => ['Real', 'etl_OBR_REAL', 'sp_ETL_ImportarControlCostos_OBR_REAL', self::IMPORTES_REAL],
        'FC' => ['Reprogramado', 'etl_OBR_FC', 'sp_ETL_ImportarControlCostos_OBR_FC', self::IMPORTES_PLAN],
    ];

    private const MAX_ERRORES = 20;

    /** Los importes se guardan como numeric(18,4) */
    private const MAX_IMPORTE = 1.0E14;

    /** Lee las tres hojas: clave => filas [numero de fila => columna => texto]; omite las que no tienen contrato */
    public static function leer(string $ruta): array
    {
        $claves = array_keys(self::HOJAS);
        $filas = ExcelEtl::leerHojas($ruta, 3, function ($hoja, $i, $nombre) use ($claves) {
            if (ExcelEtl::titulo($hoja, 'A1') !== 'CARGAR' || ExcelEtl::titulo($hoja, 'C1') !== 'CONTRATO') {
                throw new RuntimeException('La hoja "'.$nombre.'" no tiene el formato esperado: A1 debe ser CARGAR y C1 CONTRATO.');
            }

            return ExcelEtl::filas($hoja, array_merge(self::COMUNES, self::HOJAS[$claves[$i]][3]), 'CONTRATO');
        });

        return array_combine($claves, $filas);
    }

    /**
     * Revisa el archivo sin grabar nada: cuenta las filas y lista lo que impide migrar
     *
     * @return array{hojas: array, contratos: list<string>, errores: list<string>, mas_errores: int}
     */
    public static function revisar(array $datos, int $contrato): array
    {
        $errores = [];
        $resumen = [];
        $contratos = [];
        $validos = self::catalogos();

        foreach (self::HOJAS as $clave => [$nombre, , , $importes]) {
            $cargar = 0;
            $omitir = 0;
            foreach ($datos[$clave] as $n => $fila) {
                $donde = 'Hoja '.$nombre.', fila '.$n.': ';
                if ($fila['CARGAR'] === '0') {
                    $omitir++;

                    continue;
                }
                if ($fila['CARGAR'] !== '1') {
                    $errores[] = $donde.'CARGAR debe ser 1 o 0.';

                    continue;
                }
                $cargar++;
                $contratos[$fila['CONTRATO']] = true;
                foreach (['TIP_CONCEPTO' => 'concepto', 'ANIO' => 'año', 'MES' => 'mes'] as $campo => $etiqueta) {
                    $valor = $campo === 'MES' ? str_pad($fila[$campo], 2, '0', STR_PAD_LEFT) : $fila[$campo];
                    if (! isset($validos[$campo][self::normal($valor)])) {
                        $errores[] = $donde.'no se reconoce el '.$etiqueta.' "'.$fila[$campo].'".';
                    }
                }
                foreach ($importes as $campo) {
                    if ($fila[$campo] !== '' && ! is_numeric($fila[$campo])) {
                        $errores[] = $donde.$campo.' no es un número ("'.$fila[$campo].'").';
                    } elseif ($fila[$campo] !== '' && abs((float) $fila[$campo]) >= self::MAX_IMPORTE) {
                        $errores[] = $donde.$campo.' es demasiado grande ("'.$fila[$campo].'").';
                    }
                }
                foreach ($fila as $campo => $valor) {
                    if (mb_strlen($valor) > 255) {
                        $errores[] = $donde.$campo.' supera los 255 caracteres.';
                    }
                }
            }
            $resumen[$clave] = ['nombre' => $nombre, 'cargar' => $cargar, 'omitir' => $omitir];
        }

        foreach (array_keys($contratos) as $codigo) {
            $problema = self::problemaContrato($codigo, $contrato);
            if ($problema) {
                array_unshift($errores, $problema);
            }
        }
        if (array_sum(array_column($resumen, 'cargar')) === 0) {
            $errores[] = 'El archivo no tiene filas con CARGAR = 1.';
        }

        return [
            'hojas' => $resumen,
            'contratos' => array_map('strval', array_keys($contratos)),
            'errores' => array_slice($errores, 0, self::MAX_ERRORES),
            'mas_errores' => max(0, count($errores) - self::MAX_ERRORES),
        ];
    }

    private static function normal(string $valor): string
    {
        return mb_strtoupper(trim($valor));
    }

    /** Valores que reconocen los SP: conceptos (tabla 66), anios (101) y meses (18) */
    private static function catalogos(): array
    {
        $tabla = fn (string $codigo, string $columna) => DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $codigo)->pluck($columna)
            ->mapWithKeys(fn ($v) => [self::normal((string) $v) => true])->all();

        return ['TIP_CONCEPTO' => $tabla('66', 'DES_ITEM'), 'ANIO' => $tabla('101', 'DES_ITEM'), 'MES' => $tabla('18', 'COD_ITEM')];
    }

    /** Mismo camino de los SP: codigo -> CONTRATO -> PROY_CONTRATO. Debe llegar al contrato abierto */
    private static function problemaContrato(string $codigo, int $contrato): ?string
    {
        $ide = DB::table('dbo.CONTRATO')->where('COD_CONTRATO_ENTIDAD', $codigo)->max('IDE_CONTRATO');
        if ($ide === null) {
            $ordenes = DB::table('dbo.CONTRATO')->where('COD_UNICO_ORDEN', $codigo)->pluck('IDE_CONTRATO');
            if ($ordenes->count() > 1) {
                return 'El contrato "'.$codigo.'" coincide con más de una orden.';
            }
            $ide = $ordenes->first();
        }
        if ($ide === null) {
            return 'El contrato "'.$codigo.'" del archivo no existe en GEPRO.';
        }
        $destinos = DB::table('dbo.PROY_CONTRATO')->where('IDE_CONTRATO', $ide)->pluck('IDE_PROYECTO_ACTIVIDAD')->map(fn ($v) => (int) $v);
        if ($destinos->count() !== 1) {
            return 'El contrato "'.$codigo.'" no está enlazado a un solo proyecto.';
        }

        return $destinos->first() === $contrato ? null : 'El contrato "'.$codigo.'" del archivo es distinto del contrato abierto.';
    }

    /**
     * Migra el archivo: vuelve a leerlo y revisarlo, y graba todo o nada.
     *
     * @return array<string, array{nombre: string, migradas: int}>
     */
    public static function importar(string $ruta, int $contrato): array
    {
        $datos = self::leer($ruta);
        $revision = self::revisar($datos, $contrato);
        if ($revision['errores']) {
            throw new RuntimeException($revision['errores'][0]);
        }

        return DB::transaction(function () use ($datos, $revision) {
            foreach (self::HOJAS as $clave => [, $tabla, , $importes]) {
                ExcelEtl::cargar($tabla, $datos[$clave], array_merge(self::COMUNES, $importes));
            }
            foreach ([1, 2] as $pasada) {
                foreach (self::HOJAS as [, , $sp]) {
                    ExcelEtl::ejecutarSp($sp);
                }
            }

            $resultado = [];
            foreach (self::HOJAS as $clave => [$nombre, $tabla]) {
                $sinControl = DB::table('dbo.'.$tabla)->whereNull('IDE_CONT_ETAPA_CONTROL_fin')->count();
                if ($sinControl > 0) {
                    throw new RuntimeException('No se aplicó ningún cambio: '.$sinControl.' fila(s) de la hoja '.$nombre.' no se pudieron relacionar con el control del contrato.');
                }
                $migradas = DB::table('dbo.'.$tabla)->count();
                if ($migradas !== $revision['hojas'][$clave]['cargar']) {
                    throw new RuntimeException('No se aplicó ningún cambio: en la hoja '.$nombre.' se esperaban '.$revision['hojas'][$clave]['cargar'].' filas y quedaron '.$migradas.'.');
                }
                $resultado[$clave] = ['nombre' => $nombre, 'migradas' => $migradas];
            }

            return $resultado;
        });
    }
}
