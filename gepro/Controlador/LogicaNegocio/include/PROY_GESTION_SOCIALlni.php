<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_SOLIC_PROY_INTERVENCIONDATA de la tabla PROY_GESTION_SOCIAL
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_GESTION_SOCIALdao.php");

require_once("/LNinclude.php");
       


function GestionSocial_Datos($PIDE) {
    
    $IDE_PROYECTO = $IDE_COMUNIDAD = $IDE_ETAPA_CONTRATO = $NUM_BENEFICIARIOS = $TIP_UNIDAD_BENEFICIARIO = $DES_UNIDAD_BENEFICIARIO = $EST_MATRIZ_RC = $EST_ACTA_APROBACION = $data = '';
    
    if($PIDE>0) {
        $campos = " IDE_PROYECTO ,IDE_COMUNIDAD, IDE_ETAPA_CONTRATO, NUM_BENEFICIARIOS, TIP_UNIDAD_BENEFICIARIO,  EST_MATRIZ_RC, EST_ACTA_APROBACION ";
        $filtro = "  AND IDE_GESTION_SOCIAL =".$PIDE  ; //echo $campos.' // '.$filtro;exit;
            $data = VIS_SelCampos ('PROY_GESTION_SOCIAL',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PROYECTO               = $data[0]->IDE_PROYECTO ;
            $IDE_COMUNIDAD              = $data[0]->IDE_COMUNIDAD ;
            $IDE_ETAPA_CONTRATO         = $data[0]->IDE_ETAPA_CONTRATO ;
            $NUM_BENEFICIARIOS          = $data[0]->NUM_BENEFICIARIOS ;
            $TIP_UNIDAD_BENEFICIARIO    = $data[0]->TIP_UNIDAD_BENEFICIARIO ;
            $EST_MATRIZ_RC              = $data[0]->EST_MATRIZ_RC ;
            $EST_ACTA_APROBACION        = $data[0]->EST_ACTA_APROBACION ;
        }
    }
    
    $Resultado = array (
        'IDE_PROYECTO'              => $IDE_PROYECTO ,
        'IDE_COMUNIDAD'             => $IDE_COMUNIDAD, 
        'IDE_ETAPA_CONTRATO'        => $IDE_ETAPA_CONTRATO, 
        'NUM_BENEFICIARIOS'         => $NUM_BENEFICIARIOS, 
        'TIP_UNIDAD_BENEFICIARIO'   => $TIP_UNIDAD_BENEFICIARIO, 
        'EST_MATRIZ_RC'             => $EST_MATRIZ_RC, 
        'EST_ACTA_APROBACION'       => $EST_ACTA_APROBACION
    ) ;
    
    return $Resultado ;
}


function Tabla_GestionSocial_Datos ( $PIDE ) {
    
    $Data = GestionSocial_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(2).'">Número Beneficiarios:</td>';
    $DatosPadre .= '<td colspan="3">' . $Data['NUM_BENEFICIARIOS'] . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}


function Tabla_GestionSocial_Datos_vs2 ( $Comunidad , $Des_UBIGEO , $Des_Beneficiarios ) {
    
//    $Data = GestionSocial_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Comunidad:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'">' . $Comunidad . '</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">UBIGEO:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'">' . $Des_UBIGEO . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Beneficiarios:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'">' . $Des_Beneficiarios . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}


?>