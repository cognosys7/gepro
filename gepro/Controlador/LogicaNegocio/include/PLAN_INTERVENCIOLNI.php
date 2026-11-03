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

require_once(PATH_CONTROLADOR_DAO . "/PLAN_INTERVENCIONDAO.php");

require_once("/GEN_NORMATIVALNI.php");
require_once("/GEN_ENTIDADLNI.php");
require_once("/GEN_UBIGEOLNI.php");

require_once("/LNinclude.php");



function PlanIntervencion_Datos($PIDE){
    
    $IDE = $COD_ARCC = $DES_INTERVENCION = $IMP_PRESUPUESTO_INICIAL = $IDE_ENTIDAD = $IDE_DS_INCORPORACION = null ;
    
    $campos = " COD_ARCC, DES_INTERVENCION, IMP_PRESUPUESTO_INICIAL, IDE_ENTIDAD, IDE_DS_INCORPORACION ";
    $filtro = " AND IDE_PLAN_INTERVENCION =".$PIDE;
            $data = VIS_SelCampos ('PLAN_INTERVENCION',$campos,$filtro) ;
    if(count($data)>0) {
        $IDE                        = $PIDE ;
        $COD_ARCC                   = $data[0]->COD_ARCC ;
        $DES_INTERVENCION           = $data[0]->DES_INTERVENCION ;
        $IMP_PRESUPUESTO_INICIAL    = 'S/. '.number_format($data[0]->IMP_PRESUPUESTO_INICIAL,2) ;
        $IDE_ENTIDAD                = $data[0]->IDE_ENTIDAD ;
        $IDE_DS_INCORPORACION       = $data[0]->IDE_DS_INCORPORACION ;
    }
    
    $Resultado = array (
        'IDE'                       => $IDE ,
        'COD_ARCC'                  => $COD_ARCC ,
        'DES_INTERVENCION'          => $DES_INTERVENCION ,
        'IMP_PRESUPUESTO_INICIAL'   => $IMP_PRESUPUESTO_INICIAL,
        'IDE_ENTIDAD'               => $IDE_ENTIDAD,
        'IDE_DS_INCORPORACION'      => $IDE_DS_INCORPORACION
    ) ;
    
    return $Resultado ;
}


?>