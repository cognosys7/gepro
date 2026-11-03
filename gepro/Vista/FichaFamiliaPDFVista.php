<?php
require_once(RECURSOSGEN_LIB .'/PDF.php');
require_once('../lib/util.php');
require_once('../Configuracion.php');
$aPagina = 'FichaFamiliaPDF';
$lControlador = PATH_CONTROLADOR_LN . '/' . ucfirst($aPagina) . 'LN.php';
require_once($lControlador);
EjecutaLN();

$lCollection = Collection::Singleton();
$oFicha = $lCollection->Get('oFicha');
$oObservacion = $lCollection->Get('oObservacion');
$lAccion = $lCollection->Get('lAccion');
$lAccion1 = $lCollection->Get('lAccion1');
$lAccion2 = $lCollection->Get('lAccion2');
$lAccion3 = $lCollection->Get('lAccion3');

//$SNIP = $oFicha->{'CODIGO SNIP'};
//$Nombre = $lProyecto[0]->NombreProyecto;//$oFicha->PROYECTO;

$pdf = new PDF('P');

$pdf->AliasNbPages();
$pdf->Open();
$pdf->SetTitle("Familia");
$pdf->SetAuthor('Alnix');
$pdf->SetMargins(15, 20);
$pdf->AddPage();

//Definiendo valores iniciales 
$pdf->SetFillColor(19, 130, 233);

//se debe opciones de fuente antes de usar titulo
$pdf->SetFont('Helvetica', '', 6);
//Anio
$pdf->titulo(ANIO);
$pdf->ln(4);
$pdf->titulo(DECENIO);
$pdf->ln(8);
//Título
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->titulo('INFORMACIÓN RESUMEN DE LA FAMILIA DE BIENES');
$pdf->ln(10);

//Nombre del proyecto
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->SetFillColor(19, 130, 233);
$pdf->SetTextColor(255,255,255);
//$pdf->MultiCell(170, 4, utf8_decode($Nombre), 1, 'L', 1);

//Restableciendo valores
$pdf->SetTextColor(0);

$pdf->SetFont('Helvetica', 'B', 6);

//Primer cuadro
$lParametros1 = array(
    'BORDE'=>1
    ,'FONDO'=>1
    ,'ANCHOCOLUMNA01'=>43
    ,'ANCHOCOLUMNA02'=>127
);

$pdf->MiCuadro01($oFicha->GetPropertyList(), $lParametros1);
$pdf->ln(5);

//Listado de Observaciones
//$pdf->SetFont('Helvetica', 'B', 8);
//$pdf->MultiCell(170, 4, utf8_decode('OBSERVACIÓN N°'), 1, 'L', 0);
////$pdf->MiCuadro01($oObservacion->GetPropertyList(), $lParametros1);
//$pdf->ln(15);


//$sFechaInicioC = null;
//$sFechaInicioR = null;
//$pdf->MiTabla(array(43,43,42,42), array(), array(),array('FECHA INICIO CONTRACTUAL:',$lProyecto2[0]->FechaInicio,'FECHA INICIO REAL:',$lProyecto2[0]->FechaInicioObraReal));
//$pdf->MiTabla(array(43,43,42,42), array(), array(),array('CULMINACIÓN CONTRACTUAL:',$lProyecto2[0]->FechaFinal,'CULMINACIÓN REAL:',$lProyecto2[0]->FechaFinalObraReal));
//$pdf->MiTabla(array(43,43,42,42), array(), array(),array('PLAZO DE EJECUCIÓN CONTRACTUAL:',$lProyecto2[0]->DiasEjecucion." días calendarios",
    //'PLAZO DE EJECUCIÓN REAL:',$lProyecto2[0]->DiasPlazoEjecucionObraReal." días calendarios"));
//$pdf->MiTabla(array(43,43,42,42), array(), array(),array('NIVEL EDUCATIVO:',$lProyecto2[0]->NivelProyecto,'TIPO DE COLEGIO:',$lProyecto2[0]->TipoZonaColegio));
//$pdf->MiTabla(array(43,10,20,10,20,10,20,10,17,10), array(), array()
//        ,array('N° DE INSTITUCIONES:',$lProyecto2[0]->InstitucionesPorProyecto
//        ,'ALUMNOS',$lProyecto2[0]->AlumnosHombresTotalPorProyecto
//        ,'ALUMNAS',$lProyecto2[0]->AlumnosMujeresTotalPorProyecto
//        ,'TOTAL ALUMNOS',$lProyecto2[0]->TotalAlumnosPorProyecto
//        ,'DOCENTES',$lProyecto2[0]->DocentesTotalPorProyecto)
//        );
//$pdf->MiTabla(array(43,127), array(), array(),array('ESTADO SITUACIONAL:',$lProyecto2[0]->SituacionProyecto.' - AVANCE FÍSICO REAL '.$lProyecto2[0]->AvanceFisicoRealPorcentaje.' %'));
//$pdf->ln(15);

////Metas físicas
//$pdf->SetFont('Helvetica', 'B', 8);
//$pdf->MultiCell(170, 4, utf8_decode('METAS FÍSICAS'), 1, 'L', 0);
//Formato de Tabla
$lFormato['FillColor']['R'] = 19;
$lFormato['FillColor']['G'] = 130;
$lFormato['FillColor']['B'] = 233;

$lFormato['DrawColor']['R'] = 0;
$lFormato['DrawColor']['G'] = 0;
$lFormato['DrawColor']['B'] = 0;

//$pdf->MiTabla(
//        array(50,30,90)
//        ,array('Meta','Cantidad','Descripcion')
//        , $lMeta
//        ,array('META','CANTIDAD','DESCRIPCIÓN')
//        ,array('L','C','L')
//        ,$lFormato);
//$pdf->ln(10);
//Acciones por Observación

//COMENTARIOJ-INI
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(170, 4, mb_convert_encoding('ACTAS DE CONSTATACIÓN', 'ISO-8859-1', 'UTF-8'), 1, 'L', 0);
$pdf->MiTabla(
        array(170)
        ,array('CONSTATACION')
        , $lAccion1
        ,array('CONSTATACION')
        ,array('L')
        ,$lFormato);
$pdf->ln(5);

$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(170, 4, mb_convert_encoding('ACTAS DE VERIFICACIÓN', 'ISO-8859-1', 'UTF-8'), 1, 'L', 0);
$pdf->MiTabla(
        array(170)
        ,array('VERIFICACION')
        , $lAccion2
        ,array('VERIFICACION')
        ,array('L')
        ,$lFormato);
$pdf->ln(5);

$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(170, 4, mb_convert_encoding('ACTA DE CONFORMIDAD', 'ISO-8859-1', 'UTF-8'), 1, 'L', 0);
$pdf->MiTabla(
        array(170)
        ,array('CONFORMIDAD')
        , $lAccion3
        ,array('CONFORMIDAD')
        ,array('L')
        ,$lFormato);
$pdf->ln(5);

//Acciones por Observación
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(170, 4, mb_convert_encoding('CRONOLOGÍA DE DOCUMENTACIÓN', 'ISO-8859-1', 'UTF-8'), 1, 'L', 0);
$pdf->MiTabla(
        array(170)
        ,array('Documento')
        , $lAccion
        ,array('OBSERVACIÓN')
        ,array('L')
        ,$lFormato);
$pdf->ln(5);
//COMENTARIOJ-FIN

$pdf->Close();
$sCarpeta = '../fichas/';
$nombreArchivo = $sCarpeta.'Ficha_'. date('dmYHis') . '.pdf';

$pdf->Output($nombreArchivo, 'F');

header("Location: $nombreArchivo");
?>
