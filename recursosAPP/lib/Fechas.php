<?php
////ESTA FUNCION ES IGUAL A CAMBIAFECHA2 DEVUELVE D-M-Y
function Obtienefecha($fecha,$Tipo) 
{
    $fecha          = explode("/",$fecha);
    $day            = $fecha[0];
    $mes            = $fecha[1];
    $year           = $fecha[2];
    if ($Tipo == 1)
    {
        $final      = $day;
    }
    if ($Tipo == 2)
    {
        $final      = $mes;
    }
    if ($Tipo == 3)
    {
        $final      = $year;
    }
    return $final;
}

function cambiafecha($fecha) 
{
    $fecha          = explode("/",$fecha);
    $day            = $fecha[0];
    $mes            = $fecha[1];
    $year           = $fecha[2];
    $final          = $year.'-'.$mes.'-'.$day;
    return $final;
}

function cambiafecha2($fecha) 
{
    if (($fecha <> "") and ($fecha <> "0000-00-00"))
    {
        $fecha          = explode("-",$fecha);
        $day            = $fecha[2];
        $mes            = $fecha[1];
        $year           = $fecha[0];
        $final          = $day.'/'.$mes.'/'.$year;
    }
    else
    {
        $final = "";
    }
    return $final;
}

function sumaNdias($fechaValor,$Dias)
{
    $fechaValor  = explode("/",$fechaValor); 
    $FechaValorX = date_create($fechaValor[2]."-".$fechaValor[1]."-".$fechaValor[0]);
    $Fecha = date_add($FechaValorX, date_interval_create_from_date_string($Dias.' days'));
    return date_format($Fecha,'d/m/Y'); 
}

function restaNdias($fechaValor1,$fechaValor2)
{
    $fechaValor1  = explode("/",$fechaValor1); 
    $fechaValor2  = explode("/",$fechaValor2); 
    $FechaValor1X = $fechaValor1[2]."-".$fechaValor1[1]."-".$fechaValor1[0];
    $FechaValor2X = $fechaValor2[2]."-".$fechaValor2[1]."-".$fechaValor2[0];
    return ((strtotime($FechaValor1X)-strtotime($FechaValor2X))/86400);
}

function CalculaEdad($fecha) {
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}
/*
 * Cambia fecha para procedimientos almacenados SQLSERVER 2008
 */
function cambiafecha3($fecha) 
{
    $fecha          = explode("/",$fecha);
    $day            = $fecha[0];
    $mes            = $fecha[1];
    $year           = $fecha[2];
    $final          = $year.'-'.$day.'-'.$mes;
    return $final;
}

function SumarYearFecha($fecha,$Year)
{
    $fecha          = explode("/",$fecha);
    $day            = (int)$fecha[0];
    $mes            = $fecha[1];
    $year           = $fecha[2];
    $FechaFormat    = $year."-".$mes."-".$day;
    $nuevafecha     = strtotime ('+'.$Year.' year' , strtotime($FechaFormat));
    $nuevafecha     = date('d/m/Y',$nuevafecha);
    return $nuevafecha;
}
?>
