<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use RuntimeException;
use Throwable;

/**
 * Piezas comunes de las importaciones desde Excel (ImportarControl, ImportarInteresados): leer las hojas,
 * llenar las tablas etl_ con parametros y ejecutar los sp_ETL_*, que capturan sus errores sin avisar.
 */
class ExcelEtl
{
    /** Filas por INSERT: SQL Server admite 2100 parametros */
    private const FILAS_POR_INSERT = 50;

    /**
     * Abre las primeras hojas del archivo y entrega cada una a $leer($hoja, $indice, $nombre)
     *
     * @return list<mixed>
     */
    public static function leerHojas(string $ruta, int $cantidad, callable $leer): array
    {
        try {
            $lector = IOFactory::createReaderForFile($ruta);
            $nombres = $lector->listWorksheetNames($ruta);
        } catch (Throwable $e) {
            throw new RuntimeException('No se pudo abrir el archivo: no es un Excel válido.');
        }
        if (count($nombres) < $cantidad) {
            throw new RuntimeException('El archivo debe tener al menos '.$cantidad.' hojas.');
        }
        $nombres = array_slice($nombres, 0, $cantidad);
        $lector->setReadDataOnly(true);
        $lector->setLoadSheetsOnly($nombres);
        try {
            $libro = $lector->load($ruta);
        } catch (Throwable $e) {
            throw new RuntimeException('No se pudo leer el archivo.');
        }

        $datos = [];
        foreach ($nombres as $i => $nombre) {
            $datos[] = $leer($libro->getSheetByNameOrThrow($nombre), $i, $nombre);
        }
        $libro->disconnectWorksheets();

        return $datos;
    }

    /** Titulo de una columna en mayusculas: solo la primera linea de la celda */
    public static function titulo(Worksheet $hoja, string $celda): string
    {
        return strtoupper(trim(strtok((string) $hoja->getCell($celda)->getValue(), "\n") ?: ''));
    }

    /** Filas de la hoja [numero de fila => columna => texto], desde la columna A; omite las que no tienen $obligatoria */
    public static function filas(Worksheet $hoja, array $columnas, string $obligatoria): array
    {
        $filas = [];
        for ($n = 2, $ultima = $hoja->getHighestDataRow(); $n <= $ultima; $n++) {
            $fila = [];
            foreach ($columnas as $i => $columna) {
                $fila[$columna] = self::texto($hoja, chr(65 + $i).$n);
            }
            if ($fila[$obligatoria] !== '') {
                $filas[$n] = $fila;
            }
        }

        return $filas;
    }

    /** Valor de la celda como texto: en las formulas, el que Excel dejo calculado */
    private static function texto(Worksheet $hoja, string $celda): string
    {
        $c = $hoja->getCell($celda);
        $valor = $c->isFormula() ? $c->getOldCalculatedValue() : $c->getValue();
        if (is_float($valor)) {
            //SIN NOTACION CIENTIFICA: LOS SP CONVIERTEN LOS IMPORTES A numeric(18,4)
            return rtrim(rtrim(sprintf('%.10F', $valor), '0'), '.');
        }

        return trim((string) $valor);
    }

    /** Vacia la tabla etl_ y la llena con las filas, siempre con parametros */
    public static function cargar(string $tabla, array $filas, array $columnas): void
    {
        DB::statement('TRUNCATE TABLE dbo.'.$tabla);
        $vacia = array_fill_keys($columnas, '');
        foreach (array_chunk($filas, self::FILAS_POR_INSERT) as $grupo) {
            DB::table('dbo.'.$tabla)->insert(array_map(fn ($f) => array_intersect_key($f, $vacia) + $vacia, $grupo));
        }
    }

    /** El SP captura sus errores y deja abierta su transaccion: asi se nota que fallo */
    public static function ejecutarSp(string $sp): void
    {
        try {
            $antes = (int) DB::selectOne('SELECT @@TRANCOUNT AS n')->n;
            $sentencia = DB::connection()->getPdo()->prepare('SET NOCOUNT ON; EXEC dbo.'.$sp);
            $sentencia->execute();
            while ($sentencia->nextRowset()) {
            }
            $correcto = (int) DB::selectOne('SELECT @@TRANCOUNT AS n')->n === $antes;
        } catch (PDOException $e) {
            //SQL SERVER AVISA AQUI CUANDO EL SP DEJO ABIERTA SU TRANSACCION
            Log::error('Importacion desde Excel: '.$sp, ['error' => $e->getMessage()]);
            $correcto = false;
        }
        if (! $correcto) {
            throw new RuntimeException('No se aplicó ningún cambio: el proceso de carga falló en la base de datos.');
        }
    }
}
