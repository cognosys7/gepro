<?php
require_once(PATH_CONTROLADOR_DAO . "/CONT_INTERESADOSDAO.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function Interesados_Datos($PIDE) {
    
    $IDE_CONTRATO = $IDE_RECURSO = $IDE_ROL = $IDE_PUESTO = $DES_LOCALIZACION = $DES_MAIL = $DES_TELEFONO = '' ;
    $DES_REQUERIMIENTOS_PRIMORDIALES = $DES_EXPECTATIVAS_PRINCIPALES = $TIP_INFLUENCIA_POTENCIAL = $DES_FASE_MAYOR_INTERES = $TIP_INTERNO_EXTERNO = $TIP_CLASIFICACION = '';
    $DES_INTERES_PROYECTO = $TIP_EVALUACION_IMPACTO = $DES_ESTRATEGIA_PRINCIPAL = $DES_OBSERVACION = $EST_CONT_INTERESADO = '';
        
    if($PIDE>0) {
        $campos = " IDE_CONTRATO, IDE_RECURSO, IDE_ROL, IDE_PUESTO, DES_LOCALIZACION, DES_MAIL, DES_TELEFONO " ;
        $campos.= ", DES_REQUERIMIENTOS_PRIMORDIALES, DES_EXPECTATIVAS_PRINCIPALES, TIP_INFLUENCIA_POTENCIAL, DES_FASE_MAYOR_INTERES, TIP_INTERNO_EXTERNO, TIP_CLASIFICACION" ;
        $campos.= ", DES_INTERES_PROYECTO, TIP_EVALUACION_IMPACTO, DES_ESTRATEGIA_PRINCIPAL, DES_OBSERVACION, EST_CONT_INTERESADO ";
        $filtro = "  AND IDE_CONT_INTERESADO =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('CONT_INTERESADOS',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_CONTRATO                   = $data[0]->IDE_CONTRATO ;
            $IDE_RECURSO                    = $data[0]->IDE_RECURSO ;
            $IDE_ROL                        = $data[0]->IDE_ROL ;
            $IDE_PUESTO                     = $data[0]->IDE_PUESTO ;
            $DES_LOCALIZACION               = $data[0]->DES_LOCALIZACION ;
            $DES_MAIL                       = $data[0]->DES_MAIL ;
            $DES_TELEFONO                   = $data[0]->DES_TELEFONO ;
            $DES_REQUERIMIENTOS_PRIMORDIALES= $data[0]->DES_REQUERIMIENTOS_PRIMORDIALES ;
            $DES_EXPECTATIVAS_PRINCIPALES   = $data[0]->DES_EXPECTATIVAS_PRINCIPALES ;
            $TIP_INFLUENCIA_POTENCIAL       = $data[0]->TIP_INFLUENCIA_POTENCIAL ;
            $DES_FASE_MAYOR_INTERES         = $data[0]->DES_FASE_MAYOR_INTERES ;
            $TIP_INTERNO_EXTERNO            = $data[0]->TIP_INTERNO_EXTERNO ;
            $TIP_CLASIFICACION              = $data[0]->TIP_CLASIFICACION ;
            $DES_INTERES_PROYECTO           = $data[0]->DES_INTERES_PROYECTO ;
            $TIP_EVALUACION_IMPACTO         = $data[0]->TIP_EVALUACION_IMPACTO ;
            $DES_ESTRATEGIA_PRINCIPAL       = $data[0]->DES_ESTRATEGIA_PRINCIPAL ;
            $DES_OBSERVACION                = $data[0]->DES_OBSERVACION ;
            $EST_CONT_INTERESADO            = $data[0]->EST_CONT_INTERESADO ;
        }
    }
    
    $Resultado = array (
        'BIDE'               => $PIDE ,
        'IDE_CONTRATO'      => $IDE_CONTRATO ,
        'IDE_RECURSO'       => $IDE_RECURSO ,
        'IDE_ROL'           => $IDE_ROL ,
        'IDE_PUESTO'        => $IDE_PUESTO,
        'DES_LOCALIZACION'  => $DES_LOCALIZACION ,
        'DES_MAIL'          => $DES_MAIL , 
        'DES_TELEFONO'      => $DES_TELEFONO,
        'DES_REQUERIMIENTOS_PRIMORDIALES'   => $DES_REQUERIMIENTOS_PRIMORDIALES,
        'DES_EXPECTATIVAS_PRINCIPALES'      => $DES_EXPECTATIVAS_PRINCIPALES,
        'TIP_INFLUENCIA_POTENCIAL'          => $TIP_INFLUENCIA_POTENCIAL ,
        'DES_FASE_MAYOR_INTERES'            => $DES_FASE_MAYOR_INTERES , 
        'TIP_INTERNO_EXTERNO'               => $TIP_INTERNO_EXTERNO,
        'TIP_CLASIFICACION'                 => $TIP_CLASIFICACION,
        'DES_INTERES_PROYECTO'      => $DES_INTERES_PROYECTO,
        'TIP_EVALUACION_IMPACTO'    => $TIP_EVALUACION_IMPACTO ,
        'DES_ESTRATEGIA_PRINCIPAL'  => $DES_ESTRATEGIA_PRINCIPAL , 
        'DES_OBSERVACION'           => $DES_OBSERVACION,
        'EST_CONT_INTERESADO'       => $EST_CONT_INTERESADO
    ) ;
    
    return $Resultado ;
}

?>