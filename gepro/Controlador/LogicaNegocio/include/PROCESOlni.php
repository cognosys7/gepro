<?php

require_once(PATH_CONTROLADOR_DAO . "/PROCESOdao.php");

//require_once("/LNinclude.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function Proceso_Datos($PIDE) {
    
    $IDE_TIPO_PROC = $IDE_PLAN = $IDE_ENTIDAD_EJECUTORA = $DES_DEPTO_EJECUTORA = $DES_PROV_EJECUTORA = $DES_DIST_EJECUTORA = '' ;
    $NUM_ANO_EJE = $NUM_PROC_ESPECIFICO = $DES_OBJETO = $TIP_OBJETO = $IMP_VAL_REFERENCIAL = $DES_URL_PROCESO = $EST_PROCESO = '' ;
    
    if($PIDE>0) {
        $campos = " IDE_TIPO_PROC, IDE_PLAN, IDE_ENTIDAD_EJECUTORA, DES_DEPTO_EJECUTORA, DES_PROV_EJECUTORA, DES_DIST_EJECUTORA, ";
        $campos .= " NUM_ANO_EJE, NUM_PROC_ESPECIFICO, DES_OBJETO, TIP_OBJETO, IMP_VAL_REFERENCIAL, DES_URL_PROCESO, EST_PROCESO ";
        
        $filtro = "  AND IDE_CONVOCATORIA =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('PROCESO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_TIPO_PROC          = $data[0]->IDE_TIPO_PROC ;
            $IDE_PLAN               = $data[0]->IDE_PLAN ;
            $IDE_ENTIDAD_EJECUTORA  = $data[0]->IDE_ENTIDAD_EJECUTORA ;
            $DES_DEPTO_EJECUTORA    = $data[0]->DES_DEPTO_EJECUTORA ;
            $DES_PROV_EJECUTORA     = $data[0]->DES_PROV_EJECUTORA ;
            $DES_DIST_EJECUTORA     = $data[0]->DES_DIST_EJECUTORA ;
            $NUM_ANO_EJE            = $data[0]->NUM_ANO_EJE ;
            $NUM_PROC_ESPECIFICO    = $data[0]->NUM_PROC_ESPECIFICO ;
            $DES_OBJETO             = $data[0]->DES_OBJETO ;
            $TIP_OBJETO             = $data[0]->TIP_OBJETO ;
            $IMP_VAL_REFERENCIAL    = $data[0]->IMP_VAL_REFERENCIAL ;
            $DES_URL_PROCESO        = $data[0]->DES_URL_PROCESO ;
            $EST_PROCESO            = $data[0]->EST_PROCESO ;
        }
    }
    
    $Resultado = array (
        'BIDE'      => $PIDE ,
        'IDE_TIPO_PROC'         => $IDE_TIPO_PROC ,
        'IDE_PLAN'              => $IDE_PLAN ,
        'IDE_ENTIDAD_EJECUTORA' => $IDE_ENTIDAD_EJECUTORA ,
        'DES_DEPTO_EJECUTORA'   => $DES_DEPTO_EJECUTORA ,
        'DES_PROV_EJECUTORA'    => $DES_PROV_EJECUTORA ,
        'DES_DIST_EJECUTORA'    => $DES_DIST_EJECUTORA ,
        'NUM_ANO_EJE'           => $NUM_ANO_EJE ,
        'NUM_PROC_ESPECIFICO'   => $NUM_PROC_ESPECIFICO ,
        'DES_OBJETO'            => $DES_OBJETO ,
        'TIP_OBJETO'            => $TIP_OBJETO ,
        'IMP_VAL_REFERENCIAL'   => $IMP_VAL_REFERENCIAL ,
        'DES_URL_PROCESO'       => $DES_URL_PROCESO ,
        'EST_PROCESO'           => $EST_PROCESO 
    ) ;
    
    return $Resultado ;
}


?>