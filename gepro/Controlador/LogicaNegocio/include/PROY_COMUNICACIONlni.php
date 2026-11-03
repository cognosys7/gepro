<?php

  require_once(PATH_CONTROLADOR_DAO . "/PROY_COMUNICACIONDAO.php");

  require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
  require_once(PATH_CONTROLADOR_LN . "/include/GEN_TABLASLNI.php");
       


function ProyectoComunicacion_Datos($PIDE) {
    
    $IDE_PROYECTO = $DES_COMUNICACION = $FEC_INICIO = $FEC_TERMINO = $TIP_DIRECCION_EMISOR_RECEPTOR = '' ;
    $TIP_FRECUENCIA = $TIP_COMPLEJIDAD_COMUNICACION = $TIP_METODO_COMUNICACION = $TIP_MEDIO_COMUNICACION = $DES_GLOSARIO_TERMINOS = $EST_COMUNICACION = '';
    
    $campos =   " IDE_PROYECTO , DES_COMUNICACION , CONVERT(varchar(10), FEC_INICIO , 103 ) as FEC_INICIO , CONVERT(varchar(10), FEC_TERMINO , 103) as FEC_TERMINO, TIP_DIRECCION_EMISOR_RECEPTOR , " ;
    $campos .=  " TIP_FRECUENCIA , TIP_COMPLEJIDAD_COMUNICACION , TIP_METODO_COMUNICACION , TIP_MEDIO_COMUNICACION , DES_GLOSARIO_TERMINOS , EST_COMUNICACION ";
//    setlocale(LC_MONETARY,"es_ES");
    
    if($PIDE>0){
        $filtro = " AND IDE_COMUNICACION = ".$PIDE ; //echo $campos.' // '.$filtro.' // -';die;
            $data = VIS_SelCampos ('PROY_COMUNICACION',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PROYECTO                   = $data[0]->IDE_PROYECTO ;
            $DES_COMUNICACION               = $data[0]->DES_COMUNICACION ;
            $FEC_INICIO                     = $data[0]->FEC_INICIO ;
            $FEC_TERMINO                    = $data[0]->FEC_TERMINO ;
            $TIP_DIRECCION_EMISOR_RECEPTOR  = $data[0]->TIP_DIRECCION_EMISOR_RECEPTOR ;
            $TIP_FRECUENCIA                 = $data[0]->TIP_FRECUENCIA ;
            $TIP_COMPLEJIDAD_COMUNICACION   = $data[0]->TIP_COMPLEJIDAD_COMUNICACION ;
            $TIP_METODO_COMUNICACION        = $data[0]->TIP_METODO_COMUNICACION ;
            $TIP_MEDIO_COMUNICACION         = $data[0]->TIP_MEDIO_COMUNICACION ;
            $DES_GLOSARIO_TERMINOS          = $data[0]->DES_GLOSARIO_TERMINOS ;
            $EST_COMUNICACION               = $data[0]->EST_COMUNICACION ;
        }
    }
    
    $Resultado = array (
        'BIDE'                              => $PIDE 
        ,'IDE_PROYECTO'                     => $IDE_PROYECTO
        ,'DES_COMUNICACION'                 => $DES_COMUNICACION
        ,'FEC_INICIO'                       => $FEC_INICIO
        ,'FEC_TERMINO'                      => $FEC_TERMINO
        ,'TIP_DIRECCION_EMISOR_RECEPTOR'    => $TIP_DIRECCION_EMISOR_RECEPTOR
        ,'TIP_FRECUENCIA'                   => $TIP_FRECUENCIA
        ,'TIP_COMPLEJIDAD_COMUNICACION'     => $TIP_COMPLEJIDAD_COMUNICACION
        ,'TIP_METODO_COMUNICACION'          => $TIP_METODO_COMUNICACION
        ,'TIP_MEDIO_COMUNICACION'           => $TIP_MEDIO_COMUNICACION
        ,'DES_GLOSARIO_TERMINOS'            => $DES_GLOSARIO_TERMINOS
        ,'EST_COMUNICACION'                 => $EST_COMUNICACION
    ) ;
    
    return $Resultado ;
}




function Tabla_ProyectoComunicacion_Datos ($PIDE , $Estado) {
//    #D1542F
    $Data = ProyectoComunicacion_Datos($PIDE);
        
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td>Comunicado ('. $Data['BIDE'].') :</td>';
    $DatosPadre .= '<td colspan="3"> ' . $Data['DES_COMUNICACION']. '</td>';
    $DatosPadre .= '</tr>';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Alcance :</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'">' . $Data['FEC_INICIO'] . '&nbsp;&nbsp; al &nbsp;&nbsp;' . $Data['FEC_TERMINO'] . '</td>';
    $DatosPadre.=  '<td style="width:'.TBpadre_EtiketaAncho(4).'">Frecuencia:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'">' . $Estado . '</td>'; 
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}
?>