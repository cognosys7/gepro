<?php
$data = null;
$sAnio = date('Y', strtotime('-1 day')) ;
$sMes = date('m', strtotime('-1 day')) ;
$sDia = date('d', strtotime('-1 day')) ;

$sArchivo = "C".$sAnio . '-' . $sMes . '-' . $sDia . '.json';

$fecha= substr("0".$sDia.$sMes.$sAnio."N",-9,9);
        
if (!file_exists($sArchivo)) {
    
    $data1 = file_get_contents("http://www.senamhi.gob.pe/include_mapas/prono_sino/v.01/index.detalle.php?id=0001&f=$fecha");
    
    $clima1 = substr($data1, 2977, 20);
    $clima1_1 = substr($clima1, strpos($clima1, "<div style=\"\">"), strpos($clima1, "</div>"));
    
    $clima2 = substr($data1, 3060, 30);
    $clima2_1 = substr($clima2, strpos($clima2, ">")+1, strpos($clima2, "</div>")- strpos($clima2, ">")  -1);
    
    $clima3 = substr($data1, 3160, 300);
    $clima3_1 = substr($clima3, strpos($clima3, ">")+1, strpos($clima3, "</td>") - strpos($clima3, ">") - 1);
    $clima4 = substr($data1, 2668, 50);
    
    $clima4_1 = substr($clima4, 0, strpos($clima4, ".gif"));
    
    $cod_img =0;
    
    switch ($clima4_1) {
        case 'icon001':
                $cod_img =1;
            break;
        case 'icon002':
                $cod_img =2;
            break;
        case 'icon003':
                $cod_img =3;
             break;
        case 'icon004':
                $cod_img =4;
             break;
        case 'icon005':
                $cod_img =5;
             break;
        case 'icon006':
                $cod_img =6;
             break;
        case 'icon007':
                $cod_img =7;
             break;
        case 'icon008':
                $cod_img =8;
             break;
        case 'icon009':
                $cod_img =9;
             break;
        case 'icon010':
                $cod_img =10;
             break;
        case 'icon011':
                $cod_img =11;
             break;
        case 'icon012':
                $cod_img =12;
             break;
        case 'icon013':
                $cod_img =13;
             break;
        case 'icon014':
                $cod_img =14;
             break;
        case 'icon015':
                $cod_img =15;
             break;
        case 'icon016':
                $cod_img =16;
             break;
        case 'icon017':
                $cod_img =17;
             break;
        case 'icon018':
                $cod_img =18;
             break;
        case 'icon019':
                $cod_img =19;
            break;

        default:
            $cod_img =1;
            break;
    }
    
    $datax = array("success" => true
            ,'MAX'=>$clima1_1
            ,'MIN'=>$clima2_1
            ,'DES'=>  mb_convert_encoding($clima3_1, 'UTF-8', 'ISO-8859-1')
            ,'IMG'=>  $cod_img
            );
    $data = json_encode($datax);
     
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
