<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONTRATODAO.php");

//require_once("/LNinclude.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function Contrato_Datos($PIDE) {
    
    $COD_CONTRATO = $DES_CONTRATO = $IMP_TOTAL = $COD_UNICO_ORDEN = $EST_CONTRATO = $COD_CONTRATO_ENTIDAD = $COD_ORDEN ='';
        
    if($PIDE>0) {
        $campos = " COD_CONTRATO, DES_CONTRATO , IMP_TOTAL , COD_CONTRATO_ENTIDAD , COD_UNICO_ORDEN , COD_ORDEN , EST_CONTRATO ";
        $filtro = "  AND IDE_CONTRATO =".$PIDE ;// echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('CONTRATO',$campos,$filtro) ;
        if(count($data)>0) {
            $COD_CONTRATO           = $data[0]->COD_CONTRATO ;
            $DES_CONTRATO           = $data[0]->DES_CONTRATO ;
            $IMP_TOTAL              = $data[0]->IMP_TOTAL ;
            $COD_CONTRATO_ENTIDAD   = $data[0]->COD_CONTRATO_ENTIDAD ;
            $COD_UNICO_ORDEN        = $data[0]->COD_UNICO_ORDEN ;
            $COD_ORDEN        = $data[0]->COD_ORDEN ;
            $EST_CONTRATO           = $data[0]->EST_CONTRATO ;
//            $IDE_INTERVENCION_SUP   = $data[0]->IDE_INTERVENCION_SUP ;
        }
    }
    
    $Resultado = array (
        'IDE_CONTRATO'          => $PIDE ,
        'COD_CONTRATO'          => $COD_CONTRATO ,
        'DES_CONTRATO'          => $DES_CONTRATO,
        'IMP_TOTAL'             => $IMP_TOTAL ,
        'IMP_TOTAL_mon'         => $IMP_TOTAL,
        'COD_CONTRATO_ENTIDAD'  => $COD_CONTRATO_ENTIDAD ,
        'COD_UNICO_ORDEN'       => $COD_UNICO_ORDEN , 
        'COD_ORDEN'       => $COD_ORDEN , 
        'EST_CONTRATO'          => $EST_CONTRATO
        
    ) ;
//    var_dump($Resultado); exit;
    return $Resultado ;
}



function Tabla_Contrato_Datos ( $PIDE ) {
    
    $Data = Contrato_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
//    
//    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Código Contrato' . '('.$Data['IDE_CONTRATO'] .')'. ':</td>';
//    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> ' . $Data['COD_CONTRATO'] . '</td>';
//    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Número Contrato:</td>';
//    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> <span style="color: #990000;">' . $Data['COD_CONTRATO_ENTIDAD'] . '</span></td>';
//    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td>Contrato' . '('.$Data['IDE_CONTRATO'] .')'. ':</td>';
    $DatosPadre .= '<td>Contrato :</td>';
    $DatosPadre .= '<td colspan="3">' . $Data['COD_CONTRATO_ENTIDAD'] . ' - ' . $Data['DES_CONTRATO'] . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Cod. Orden Det :</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> <span style="color: #990000;">' . $Data['COD_UNICO_ORDEN'] . '</span></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Monto Contractual:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'">' . FormatoSoles($Data['IMP_TOTAL']) . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}



function Control_Bloqueo_CONT($Tipo) {

    $Control_Bloqueo = array(
        'TIP_ORDEN'                 => '',
	'COD_ORDEN'                 => '',
	'COD_SEC_DET_ORDEN'         => '',
	'COD_UNICO_ORDEN'           => '',
        'COD_CONTRATO'              => '',
	'COD_CONTRATO_ENTIDAD'      => '',
	'DES_CONTRATO'              => '',
	'TIP_CONTRATO'              => '',
	'FEC_CONTRATO'              => '',
	'FEC_INICIO_CONTRATO'       => '',
	'FEC_TERMINO_CONTRATO'      => '',
	'FEC_CIERRE_CONTRATO'       => '',
	'IMP_IMPONIBLE'             => '',
        'IMP_IMPUESTOS'             => '',
        'IMP_TOTAL'                 => '',
        'EST_CONTRATO'              => cboReadonly()
    );
    
    switch ($Tipo){
        case 'SPRING1':
                $Control_Bloqueo['TIP_ORDEN']               = cboReadonly() ;
                $Control_Bloqueo['COD_ORDEN']               = 'readonly' ;
                $Control_Bloqueo['COD_SEC_DET_ORDEN']       = 'readonly' ;
                $Control_Bloqueo['COD_UNICO_ORDEN']         = 'readonly' ;
                $Control_Bloqueo['COD_CONTRATO']            = 'readonly' ;
                $Control_Bloqueo['COD_CONTRATO_ENTIDAD']    = 'readonly' ;
                $Control_Bloqueo['DES_CONTRATO']            = 'readonly' ; 
                $Control_Bloqueo['TIP_CONTRATO']            = cboReadonly() ;
                $Control_Bloqueo['FEC_CONTRATO']            = 'readonly' ;
                $Control_Bloqueo['FEC_INICIO_CONTRATO']     = 'readonly' ;
                $Control_Bloqueo['FEC_TERMINO_CONTRATO']    = 'readonly' ;
                $Control_Bloqueo['FEC_CIERRE_CONTRATO']     = 'readonly' ;
                $Control_Bloqueo['IMP_IMPONIBLE']           = 'readonly' ;
                $Control_Bloqueo['IMP_IMPUESTOS']           = 'readonly' ;
                $Control_Bloqueo['IMP_TOTAL']               = 'readonly' ;
                $Control_Bloqueo['EST_CONTRATO']            = cboReadonly() ; 
            break;
    }
    
    return $Control_Bloqueo;
}
?>