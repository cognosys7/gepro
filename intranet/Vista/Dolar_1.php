<?php
$data  = null;
$sAnio = date('Y');
$sMes  = date('m');
$sDia  = date('d');

$sArchivo = $sAnio . '-' . $sMes . '-' . $sDia . '.json';
$data = file_get_contents("http://www.sbs.gob.pe/app/stats/tc-cv.asp?FECHA_CONSULTA=16/11/2016&button22=Consultar");
echo $data;
exit;
if (!file_exists($sArchivo)) 
{
    
    //$data = file_get_contents("http://code.staffsystems.us/webservices/tipo-de-cambio/serverside.php?work=get_sbs&&anho=$sAnio&&mes=$sMes&&dia=$sDia");
    $data = file_get_contents("http://www.sbs.gob.pe/app/stats/tc-cv.asp?FECHA_CONSULTA=16/11/2016&button22=Consultar");

    $file = fopen($sArchivo, "wb");
    
    fwrite($file, $data);
    
    fclose($file);
    
} else {

    $file = fopen($sArchivo, "rb");

    while (!feof($file)) {
        $data = fgets($file);
    }
    fclose($file);
}
echo $data;
?>
