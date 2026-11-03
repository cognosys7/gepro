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
require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");

//require_once("/LNinclude.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       

function ProyectoActividad_Datos($PIDE) {
    
    $IDE_PROYECTO = $IDE_INTERVENCION = $TIP_PROYECTO_ACTIVIDAD = $DES_UBICACION = $DES_PROYECTO_ABREV = $COD_PROYECTO = $DES_PROYECTO = '';
    
    $campos = " IDE_PROYECTO, IDE_INTERVENCION, TIP_PROYECTO_ACTIVIDAD, DES_UBICACION, DES_PROYECTO_ABREV, COD_PROYECTO , DES_PROYECTO ";
//    setlocale(LC_MONETARY,"es_ES");
    
    if($PIDE>0){
        $filtro = "  AND IDE_PROYECTO_ACTIVIDAD =".$PIDE ;// echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('PROYECTO_ACTIVIDAD',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PROYECTO           = $data[0]->IDE_PROYECTO ;
            $IDE_INTERVENCION       = $data[0]->IDE_INTERVENCION ;
            $TIP_PROYECTO_ACTIVIDAD = $data[0]->TIP_PROYECTO_ACTIVIDAD ;
            $DES_UBICACION          = $data[0]->DES_UBICACION ;
            $DES_PROYECTO_ABREV     = $data[0]->DES_PROYECTO_ABREV ;
            $COD_PROYECTO           = $data[0]->COD_PROYECTO ;
            $DES_PROYECTO           = $data[0]->DES_PROYECTO ;
            
        }
    }
    
    $Resultado = array (
        'IDE_PROYECTO_ACTIVIDAD'    => $PIDE
        ,'IDE_PROYECTO'             => $IDE_PROYECTO
        ,'IDE_INTERVENCION'         => $IDE_INTERVENCION
        ,'TIP_PROYECTO_ACTIVIDAD'   => $TIP_PROYECTO_ACTIVIDAD
        ,'DES_UBICACION'            => $DES_UBICACION
        ,'DES_PROYECTO_ABREV'       => $DES_PROYECTO_ABREV
        ,'COD_PROYECTO'             => $COD_PROYECTO
        ,'DES_PROYECTO'             => $DES_PROYECTO
    ) ;
    
    return $Resultado ;
}

//function Tabla_ProyectoActividad_Datos ( $PIDE , $COD_INTERNO , $COD_UNICO , $DES_LARGA_PROYECTO , $FEC_INICIO_PROY , $FEC_TERMINO_PROY , $IMP_APROBADO_LOC ) {
//    
////    $Data = Proyecto_Datos($PIDE);
//    $DatosPadre = '<table class="tbDatoPadre" style="width:98%">';
//    
//    $DatosPadre .= '<tr>';
//    $DatosPadre.= '<td style="width:12%">Código Interno:</td>';
//    $DatosPadre .= '<td style="width:38"> ' . $COD_INTERNO . '</td>';
//    $DatosPadre .= '<td style="width:12%">Código Único:</td>';
//    $DatosPadre .= '<td style="width:38%">' . $COD_UNICO . '</td>';
//    $DatosPadre .= '</tr>';
//    
//    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td>Proyecto:</td>';
//    $DatosPadre .= '<td colspan="3"> ' . $DES_LARGA_PROYECTO . '</td>';
//    $DatosPadre .= '</tr>';
//
//    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td>Ejecución contractual:</td>';
//    $DatosPadre .= '<td>' . $FEC_INICIO_PROY . ' al ' . $FEC_TERMINO_PROY . '</td>';
//    $DatosPadre.= '<td>Monto de Inversión:</td>';
//    $DatosPadre .= '<td>' . FormatoSoles($IMP_APROBADO_LOC) . '</td>';
//    $DatosPadre .= '</tr>';
//    
//    $DatosPadre .= '</table>';
//    
//    return $DatosPadre ;
//}



function Grilla_verBotones_ProyectoActividad ($Tipo) {

    $BotonVer = array(
        'Nuevo'         => 'false',
        'Editar'        => 'true',
        'Eliminar'      => 'true',
        
        'Contrato'      => 'true',
        'Ampliacion'    => 'true',
        'Presupuesto'   => 'true',
        'Componente'    => 'true',
        'Riesgo'        => 'true',
        'Interesado'    => 'true',
        'Seguimiento'   => 'true',
        'ProcAdq'       => 'true',
        'Documentacion' => 'true',
        'Entregable'    => 'true'
    );
    
    switch ($Tipo){
        case 200:   $BotonVer['Editar']         = 'false' ;
                    $BotonVer['Contrato']       = 'false' ;
//                    $BotonVer['Presupuesto']    = 'false' ;
                    $BotonVer['Componente']     = 'false' ;
                    $BotonVer['Riesgo']         = 'false' ;
                    $BotonVer['Interesado']     = 'false' ;
                    $BotonVer['Seguimiento']    = 'false' ;
                    $BotonVer['ProcAdq']        = 'false' ;
                    $BotonVer['Documentacion']  = 'false' ;
                    $BotonVer['Entregable']     = 'false' ;
            break;
        
        case 210:   
                    $BotonVer['Nuevo']          = 'true' ;
                    $BotonVer['Editar']         = 'false' ;
                    $BotonVer['Contrato']       = 'false' ;
                    $BotonVer['ProcAdq']        = 'false' ;
            break;
        
        case 211:   $BotonVer['Nuevo']          = 'true' ;
                    $BotonVer['Componente'] = 'false' ;
                    $BotonVer['Contrato'] = 'false' ;
                    $BotonVer['Ampliacion'] = 'false' ;
                    //$BotonVer['Riesgo'] = 'false' ;
                    $BotonVer['Interesado'] = 'false' ;
                    //$BotonVer['ProcAdq'] = 'false' ;
                    $BotonVer['Editar'] = 'false' ;
            break;
        
        case 212:   $BotonVer['Riesgo']         = 'false' ;
            break;
        
        case 213:   $BotonVer['Seguimiento']    = 'false' ;
            break;
        
        case 214:    $BotonVer['Interesado']    = 'false' ;
            break;
        
        case 215:    $BotonVer['Documentacion'] = 'false' ;
            break;
        
        case 216:    $BotonVer['Entregable']    = 'false' ;
            break;
        
        case 217:    //$BotonVer['Presupuesto']   = 'false' ;
            break;
        
        case 310:    
                    $BotonVer['Interesado'] = 'false' ;     
            break;
    }
    
    return $BotonVer;
}



function Control_BloqueoACT($Tipo) {

    $Control_Bloqueo = array(
        'DES_PROYECTO'              => '',
	'IMP_COSTO_ACTUAL'          => '',
	'EST_PROYECTO_ACTIVIDAD'    => cboReadonly('51'),
        'COD_PROYECTO'              => 'VerValor'
    );
    
    switch ($Tipo){
        case 'SPRING1':
                $Control_Bloqueo['DES_PROYECTO']            = 'readonly' ;
                $Control_Bloqueo['IMP_COSTO_ACTUAL']        = 'readonly' ;
                $Control_Bloqueo['EST_PROYECTO_ACTIVIDAD']  = cboReadonly('') ; 
                $Control_Bloqueo['COD_PROYECTO']            = 'OcultarExtrator' ; 
            break;
    }
    
    return $Control_Bloqueo;
}

?>