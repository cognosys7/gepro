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
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCION_COMPDAO.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
//function Intervencion_Com_Datos($PIDE) {
//    
//    $IDE_INTERVENCION = $IDE_COMPONENTE = $COMP_PRINCIPAL = $IDE_MODO_EJECUCION = $IDE_TIPO_PROC = $EST_INTERVENCION_COMP = '';
//        
//    if($PIDE>0) {
//        $campos = " IDE_INTERVENCION, IDE_COMPONENTE, COMP_PRINCIPAL, IDE_MODO_EJECUCION, IDE_TIPO_PROC, EST_INTERVENCION_COMP ";
//        $filtro = "  AND IDE_INTERVENCION_COMP =".$PIDE ; //echo $campos.''.$filtro.'-';die;
//            $data = VIS_SelCampos ('GEN_INTERVENCION_COM',$campos,$filtro) ;
//        if(count($data)>0) {
//            $IDE_INTERVENCION       = $data[0]->IDE_INTERVENCION ;
//            $IDE_COMPONENTE         = $data[0]->IDE_COMPONENTE ;
//            $COMP_PRINCIPAL         = $data[0]->COMP_PRINCIPAL ;
//            $IDE_MODO_EJECUCION     = $data[0]->IDE_MODO_EJECUCION ;
//            $IDE_TIPO_PROC          = $data[0]->IDE_TIPO_PROC ;
//            $EST_INTERVENCION_COMP  = $data[0]->EST_INTERVENCION_COMP ;
//        }
//    }
//    
//    $Resultado = array (
//        'BIDE'                  => $PIDE ,
//        'IDE_INTERVENCION'      => $IDE_INTERVENCION ,
//        'IDE_COMPONENTE'        => $IDE_COMPONENTE ,
//        'COMP_PRINCIPAL'        => $COMP_PRINCIPAL ,
//        'IDE_MODO_EJECUCION'    => $IDE_MODO_EJECUCION , 
//        'IDE_TIPO_PROC'         => $IDE_TIPO_PROC,
//        'EST_INTERVENCION_COMP' => $EST_INTERVENCION_COMP
//    ) ;
//    
//    return $Resultado ;
//}



function Tabla_IntervencionCom_Datos2 ( $VTipoIntervencion, $VComponente, $VModalidad ) {
    
//    $Data = Intervencion_Com_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    $DatosPadre .= '<tr>';//$Data['DES_COMUNIDAD']
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Fase - Componente:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> ' . $VTipoIntervencion . '</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Etapa del Componente: </td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> ' . $VComponente . '</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Modalidad:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> ' . $VModalidad . '</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}
?>