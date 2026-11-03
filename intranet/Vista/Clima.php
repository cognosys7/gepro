<?php
$data = null;
$sAnio = date('Y', strtotime('-1 day')) ;
$sMes = date('m', strtotime('-1 day')) ;
$sDia = date('d', strtotime('-1 day')) ;
$ruta = "../json/";
$sArchivo = "C".$sAnio . '-' . $sMes . '-' . $sDia . '.json';

$fecha= substr("0".$sDia.$sMes.$sAnio."N",-9,9);

//if (!file_exists($ruta.$sArchivo)) {
    
    $data1 = file_get_contents("http://www.senamhi.gob.pe/include_mapas/prono_sino_lima/");
    
    $nPos1_inicial  = strpos($data1,"<div style=color:#0000FF"); 
    $nPos1_final  = strpos($data1,"',VAUTO,HAUTO,WIDTH"); 
    
    $clima1 = substr($data1, $nPos1_inicial,$nPos1_final - $nPos1_inicial );
   //Remplazando línea
    $clima1 = str_replace('http://www.senamhi.gob.pe/','../recursos/', $clima1);
    //Remplazando ruta de imagenes
    $clima1 = str_replace('../../admin/icono/','../recursos/images/ico_clima/', $clima1);
    $datax = array("success" => true
            ,'CLIMA'=>str_replace("LIMA ESTE","",$clima1)
            );
    $data = json_encode($datax);
     
    $file = fopen($ruta.$sArchivo, "wb");
    
    fwrite($file, $data);
    
    fclose($file);
    
//} else {
//    $file = fopen($ruta.$sArchivo, "rb");
//    while (!feof($file)) {
//        $data = fgets($file);
//    }
//    fclose($file);
//}
echo $data;
?>
