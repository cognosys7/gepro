<?php
require_once('../lib/PDF.php');
require_once('../lib/Util.php');
require_once('../Configuracion.php');
$aPagina = 'DirectorioPDF';
$lControlador = PATH_CONTROLADOR_LN . '/' . ucfirst($aPagina) . 'LN.php';
require_once($lControlador);
EjecutaLN();

$lCollection    = Collection::Singleton();
$lstDirectorio  = $lCollection->Get('lReporte');
$lFiltro        = $lCollection->Get('lFiltro');
$TipoBusqueda   = $lCollection->Get('TipoBusqueda');
        
$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->Open();
$pdf->SetTitle("Reporte-Servicios_PRONIED");
$pdf->SetAuthor('PRONIED - Oficina de Tecnologías de Información - Alnix');
$pdf->SetMargins(15, 20);
$pdf->AddPage();
//se debe opciones de fuente antes de usar titulo
$pdf->SetFont('Helvetica', 'B', 12);

//Título
$pdf->titulo('DIRECTORIO TELEFONICO - PRONIED');
//Salto de línea
$pdf->ln(4);
$pdf->SetFont('Helvetica', 'B', 10);


$pdf->titulo("Jr. Carabaya Nº 341 - Lima - Central Telefónica: 615-596 ");

$pdf->ln(5);
$pdf->SetFont('Helvetica', 'B', 6);
$pdf->titulo("DIRECTORIO PRONIED AL ".date("d/m/Y") );

$pdf->ln(2);
$pdf->SetFont('Helvetica', 'B', 6);

$pdf->titulo("FUENTE: INTEGRIX ");

$pdf->ln(5);
$pdf->SetFont('Helvetica', 'B', 4);
//
//$pdf->ln();
$pdf->ln(8);
//Formato de Tabla
$lFormato['FillColor']['R'] = 238;
$lFormato['FillColor']['G'] = 238;
$lFormato['FillColor']['B'] = 238;

$lFormato['DrawColor']['R'] = 0;
$lFormato['DrawColor']['G'] = 0;
$lFormato['DrawColor']['B'] = 0;
//Campos en A4 Horizontal deben sumar 270
$lstAnchoColumna = array(50,25,25,85);  
$lstAnchoTitulo  = array(185);  
//campos
$lstCabecera = array(
    'CARGO',
    'ANEXO', 
    'MOVIL', 
    'COLABORADOR',
    
);
$lstCabeceraTitulo = array(
    'UNIDADORGANICA',
    
);

$lCaption           = array('CARGO','ANEXO', 'DIRECTO/RPC', 'NOMBRES Y APELLIDOS');
$lCaptionTitulo     = array('ÁREA');
$lAlineacion        = array('L','C','C', 'L');
$lAlineacionTitulo  = array('C');
//Llama a método para imprimir reporte
//$pdf->MiTabla($lstAnchoColumna, $lstCabecera, $lstDirectorio, $lCaption, $lAlineacion, $lFormato);
$Fcol   = 0;
$listaDirectorio  = count($lstDirectorio) > 0 ? true : false;
if (($listaDirectorio == true) || ($listaDirectorio > 0))
{
    $TitulOficina            = "";
    foreach ($lstDirectorio as $ObjDirectorio) 
    {
        $uornombre           = $ObjDirectorio->UNIDADORGANICA;
        $cargo               = $ObjDirectorio->CARGO;
        $Persona             = $ObjDirectorio->COLABORADOR;
        $Celular             = $ObjDirectorio->MOVIL;
        $Anexo               = $ObjDirectorio->ANEXO;
        $Permiso             = BuscarCadena($uornombre,$cargo,$TipoBusqueda);
        if ($Permiso == 1)
        {
            $Fcol++;
            $ColorX          = ColorFilaCeleste($Fcol);
            if ($TitulOficina <> $uornombre)
            {
                $TitulOficina    = $uornombre;
                $pdf->MiTabla2($lstAnchoTitulo, $lstCabeceraTitulo, array($TitulOficina), $lCaptionTitulo, $lAlineacionTitulo, $lFormato,0);
                $Fcol = 1;
            }
            $pdf->MiTabla2($lstAnchoColumna, $lstCabecera, array($cargo,$Anexo,$Celular,$Persona), $lCaption, $lAlineacion, '',$Fcol);

        }
    }
}

$pdf->write(6, utf8_decode("FUENTE: DIRECTORIO INSTITUCIONAL "));

$pdf->Close();
$nombreArchivo = 'DIRECTORIO_'.date('d-m-Y'). '.pdf';
$pdf->Output($nombreArchivo, 'F');

header("Location: $nombreArchivo");
?>