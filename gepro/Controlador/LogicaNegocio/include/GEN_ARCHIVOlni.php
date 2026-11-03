<?php
require_once(PATH_CONTROLADOR_DAO . "/GEN_ARCHIVOdao.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");

/**
 * Obtiene los datos de un archivo según parámetros específicos.
 *
 * @param int $PIDE ID del registro a buscar.
 * @param string $Tabla Nombre de la tabla relacionada.
 * @param string $Tipo Tipo de consulta (opcional, 'max' para obtener el archivo más reciente).
 * @return array Datos del archivo en formato de array asociativo.
 */
function Archivo_Datos(int $PIDE, string $Tabla, string $Tipo = ''): array {
    // Inicializar las variables
    $IDE_ARCHIVO = $IDE_TABLA = $IDE_REGISTRO = $DES_RUTA = $DES_ARCHIVO = $FEC_CARGA = $FEC_CARGA_fecha = $FEC_CARGA_hora = $EST_ARCHIVO = null;

    $campos = "
        IDE_ARCHIVO,
        IDE_TABLA,
        IDE_REGISTRO,
        DES_RUTA,
        DES_ARCHIVO,
        FEC_CARGA,
        CONVERT(VARCHAR(10), FEC_CARGA, 103) as FEC_CARGA_fecha,
        CONVERT(VARCHAR(10), FEC_CARGA, 24) as FEC_CARGA_hora,
        EST_ARCHIVO
    ";

    $filtro_aux = '';

    // Si el tipo es 'max', genera un filtro adicional
    if ($Tipo === 'max') {
        $filtro_aux = " AND IDE_ARCHIVO = (
            SELECT MAX(IDE_ARCHIVO)
            FROM DBO.GEN_ARCHIVO
            WHERE EST_ARCHIVO <> '2' AND IDE_REGISTRO = {$PIDE} AND IDE_TABLA LIKE '{$Tabla}%'
        )";
    }

    $Resultado = [];

    if ($PIDE > 0) {
        // Generar el filtro completo
        $filtro = " AND IDE_REGISTRO = {$PIDE} AND IDE_TABLA LIKE '{$Tabla}%' {$filtro_aux}";

        // Obtener datos
        $data = VIS_SelCampos('GEN_ARCHIVO', $campos, $filtro);

        // Verificar si los datos existen y procesarlos
        if (is_array($data) && count($data) > 0) {
            $dataRow = $data[0];
            $IDE_ARCHIVO = $dataRow->IDE_ARCHIVO ?? null;
            $IDE_TABLA = $dataRow->IDE_TABLA ?? null;
            $IDE_REGISTRO = $dataRow->IDE_REGISTRO ?? null;
            $DES_RUTA = $dataRow->DES_RUTA ?? null;
            $DES_ARCHIVO = $dataRow->DES_ARCHIVO ?? null;
            $FEC_CARGA = $dataRow->FEC_CARGA ?? null;
            $FEC_CARGA_fecha = $dataRow->FEC_CARGA_fecha ?? null;
            $FEC_CARGA_hora = $dataRow->FEC_CARGA_hora ?? null;
            $EST_ARCHIVO = $dataRow->EST_ARCHIVO ?? null;
        }
    }

    // Construir el resultado
    $Resultado = [
        'BIDE' => $IDE_ARCHIVO,
        'IDE_TABLA' => $IDE_TABLA,
        'IDE_REGISTRO' => $IDE_REGISTRO,
        'DES_RUTA' => $DES_RUTA,
        'DES_ARCHIVO' => $DES_ARCHIVO,
        'FEC_CARGA' => $FEC_CARGA,
        'FEC_CARGA_fecha' => $FEC_CARGA_fecha,
        'FEC_CARGA_hora' => $FEC_CARGA_hora,
        'EST_ARCHIVO' => $EST_ARCHIVO,
    ];

    return $Resultado;
}
