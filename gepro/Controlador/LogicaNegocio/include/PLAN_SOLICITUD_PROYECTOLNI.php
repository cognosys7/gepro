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

//require_once(PATH_CONTROLADOR_DAO . "/PLAN_SOLICITUD_PROYECTODAO.php");
//require_once(PATH_CONTROLADOR_DAO . "/PLAN_SOLICITUD_PROYECTO_ElaboraDSDAO.php");

require_once("/PLAN_SOLICITUD_FFTOLNI.php");
require_once("/GEN_PIPLNI.php");
require_once("/GEN_ENTIDADLNI.php");
require_once("/GEN_TABLASLNI.php");
require_once("/PLAN_RECURSOLNI.php");

require_once("/LNinclude.php");
    

function PlanSolicitudProyecto_Datos($PIDE){
    
    $IDE_SOLICITUD = $IDE_PIP = $IMP_MONTO_FFTO = null ;
    
    $campos =   " IDE_SOLICITUD, IDE_PIP, IMP_MONTO_FFTO ";
    $filtro = " AND IDE_SOLICITUD_PROYECTO =".$PIDE;
            $data = VIS_SelCampos ('PLAN_SOLICITUD_PROYECTO',$campos,$filtro) ;
    if(count($data)>0) {
        $IDE_SOLICITUD   = $data[0]->IDE_SOLICITUD ;
        $IDE_PIP         = $data[0]->IDE_PIP ;
        $IMP_MONTO_FFTO  = $data[0]->IMP_MONTO_FFTO ;
    }
    
    $Resultado = array (
        'IDE_SOLICITUD'     => $IDE_SOLICITUD ,
        'IDE_PIP'           => $IDE_PIP ,
        'IMP_MONTO_FFTO'    => 'S/. '.number_format($IMP_MONTO_FFTO,2)
    ) ;
    
    return $Resultado ;
}





function Gridver ($PermisosPerfil,$Tipo) {
        
    $Grid_ColVer['ProyectoEstado'] = false;
    $Grid_ColVer['HojaRuta'] = false;
    $Grid_ColVer['FechaRecepcion'] = false;

    $Grid_ColVer['SeguimientoEvaluador'] = false;
    $Grid_ColVer['SeguimientoEstado'] = false;
    $Grid_ColVer['SeguimientoFecha'] = false;

    $Grid_ColVer['Intervencion'] = false;
    $Grid_ColVer['Transferencia'] = false;
    $Grid_ColVer['Devengado'] = false;

    $Grid_ColVer['AsignarEvaluador'] = false;
    $Grid_ColVer['AnularAsignacion'] = false;
    $Grid_ColVer['OtorgarConformidad'] = false;
    $Grid_ColVer['Observar'] = false;
    $Grid_ColVer['AnularEvaluacion'] = false;
    $Grid_ColVer['OtorgarOpinionLegal'] = false;
    $Grid_ColVer['ObservacionLegal'] = false;
    $Grid_ColVer['AnularOpinionFavorable'] = false;
    
    $Grid_ColVer['EntidadSolicitante'] = false;

    $Grid_ColVer['Editar'] = false;
    $Grid_ColVer['Eliminar'] = false;
    $Grid_ColVer['Seleccionar'] = false;
        
        switch ($PermisosPerfil) {
            case 'ADMIN1':
                
                if($Tipo=='HojaRuta') {
                    $Grid_ColVer['HojaRuta'] = true;

                    $Grid_ColVer['FechaRecepcion'] = true;
                    $Grid_ColVer['EntidadSolicitante'] = true;
                    $Grid_ColVer['Seleccionar'] = true;
                } else {
                    $Grid_ColVer['ProyectoEstado'] = true;
                    $Grid_ColVer['HojaRuta'] = true;
                    $Grid_ColVer['FechaRecepcion'] = true;

                    $Grid_ColVer['SeguimientoEvaluador'] = true;
                    $Grid_ColVer['SeguimientoEstado'] = true;
                    $Grid_ColVer['SeguimientoFecha'] = true;

                    $Grid_ColVer['Intervencion'] = true;
                    $Grid_ColVer['Transferencia'] = true;
                    $Grid_ColVer['Devengado'] = true;

                    $Grid_ColVer['AsignarEvaluador'] = true;
                    $Grid_ColVer['AnularAsignacion'] = true;
                    $Grid_ColVer['OtorgarConformidad'] = true;
                    $Grid_ColVer['Observar'] = true;
                    $Grid_ColVer['AnularEvaluacion'] = true;
                    $Grid_ColVer['OtorgarOpinionLegal'] = true;
                    $Grid_ColVer['ObservacionLegal'] = true;
                    $Grid_ColVer['AnularOpinionFavorable'] = true;

                    $Grid_ColVer['Editar'] = true;
                    $Grid_ColVer['Eliminar'] = true;
                }
                
                
                break;
            
            case 'RegisSolicitudFFTO1':
//                if($Tipo=='Inicio') {
//                                        
//                    $Grid_ColVer['Editar'] = true;
//                    $Grid_ColVer['Eliminar'] = true;
//                }
                if($Tipo=='HojaRuta') {
                    $Grid_ColVer['HojaRuta'] = true;

                    $Grid_ColVer['FechaRecepcion'] = true;
                    $Grid_ColVer['EntidadSolicitante'] = true;
                    $Grid_ColVer['Seleccionar'] = true;
                }
                break;
            case 'AsignaProy_Evalu1':
                $Grid_ColVer['HojaRuta'] = true;
                

                $Grid_ColVer['SeguimientoEstado'] = true;

                $Grid_ColVer['SeguimientoEvaluador'] = true;
                $Grid_ColVer['SeguimientoFecha'] = true; 
                $Grid_ColVer['AnularAsignacion'] = true; 
                break;
            case 'EvaluadorProyecto1':
                $Grid_ColVer['HojaRuta'] = true;

                $Grid_ColVer['SeguimientoFecha'] = true;

                if($Tipo=='Ventana2') { 
                    $Grid_ColVer['SeguimientoEstado'] = true;
                    $Grid_ColVer['AnularEvaluacion'] = true; 
                }
                
                break;
            case 'ResponsableLegal1':
                $Grid_ColVer['HojaRuta'] = true;

                $Grid_ColVer['SeguimientoFecha'] = true;

                if($Tipo=='Inicio') { 
                    $Grid_ColVer['SeguimientoEstado'] = true;
                    $Grid_ColVer['SeguimientoEvaluador'] = true;
                    $Grid_ColVer['OtorgarOpinionLegal'] = true; 
                    $Grid_ColVer['ObservacionLegal'] = true;
                }
                
                if($Tipo=='Ventana2') { 
                    $Grid_ColVer['SeguimientoEstado'] = true; 
                    $Grid_ColVer['AnularOpinionFavorable'] = true;
                }
                break;
        }
        
        return $Grid_ColVer;
}





function ControlVer ($PermisosPerfil,$Tipo='') {
        
    $Ocultar = ' style="display:none" ';
    $Ver = '';
    $Bloquear = ' readonly ';
    $Desbloquear = '';
    
    $Control_Ver['IDE_PIP'] = $Ocultar;
    $Control_Ver['PlanSolicitudProyecto_COD_PIP'] = $Ocultar;
    $Control_Ver['PlanSoliProy_COD_PIP2'] = $Ocultar;
    $Control_Ver['IMP_MONTO_SNIP'] = $Ocultar;
    
    $Control_Ver['IMP_MONTO_PERFIL'] = $Ocultar;
    $Control_Ver['IMP_MONTO_EXPEDIENTE_TECNICO'] = $Ocultar;
    $Control_Ver['IMP_MONTO_OBRA'] = $Ocultar;
    $Control_Ver['IMP_MONTO_SUPERVISION'] = $Ocultar;
    
    $Control_Ver['TIP_SOLICITUD'] = $Ocultar;
    $Control_Ver['IMP_MONTO_FFTO'] = $Bloquear;
    $Control_Ver['EST_PROYECTO'] = $Ocultar;

    $Control_Ver['EST_SEGUIMIENTO'] = $Ocultar;
    $Control_Ver['IDE_EVALUADOR'] = $Ocultar;
    $Control_Ver['DES_SEGUIMIENTO'] = $Ocultar;
    $Control_Ver['FEC_SEGUIMIENTO'] = $Ocultar;

    $Control_Ver['TIP_TIPOLOGIA_INTERVENCION'] = $Ocultar;

    $Control_Ver['FEC_ENVIO_DS_MEF'] = $Ocultar;
    $Control_Ver['FEC_PUBLICACION_DS'] = $Ocultar;
    $Control_Ver['FEC_CONVOCATORIA'] = $Ocultar;
    $Control_Ver['FEC_BUENA_PRO'] = $Ocultar;
    $Control_Ver['FEC_SUSCRIPCION_CONTRATO'] = $Ocultar;
    $Control_Ver['FEC_INICIO_FICHA_TECNICA'] = $Ocultar;
    $Control_Ver['FEC_FIN_FICHA_TECNICA'] = $Ocultar;
    $Control_Ver['FEC_INICIO_EXPEDIENTE'] = $Ocultar;
    $Control_Ver['FEC_FIN_EXPEDIENTE'] = $Ocultar;
    $Control_Ver['FEC_INICIO_OBRA'] = $Ocultar;
    $Control_Ver['FEC_FIN_OBRA'] = $Ocultar;
    
    $Control_Ver['TIP_UNIDAD_META_PROYECTO'] = $Ocultar;
    $Control_Ver['CAN_META_PROYECTO'] = $Ocultar;
    $Control_Ver['CAN_PLAZO_EJECUCION_PROYECTO'] = $Ocultar;

    $Control_Ver['IMP_MONTO_INVERSION'] = $Ocultar;
    $Control_Ver['IMP_MONTO_NO_FINANCIADO'] = $Ocultar;
    $Control_Ver['EST_REPRESENTATIVO'] = $Ocultar;
    
    $Control_Ver['IDE_INTERVENCION'] = $Ocultar;
        
    switch ($PermisosPerfil) {
        case 'ADMIN1':
//            $Control_Ver['IDE_PIP'] = $Ver;
            $Control_Ver['PlanSoliProy_COD_PIP2'] = $Ver;
           
            
            break;
        case 'RegisSolicitudFFTO1':
            $Control_Ver['PlanSoliProy_COD_PIP2'] = $Ver;
//            $Control_Ver['IMP_MONTO_SNIP'] = $Ver;
//            $Control_Ver['EST_PROYECTO'] = $Ver;
            
            break;
        
        
//        case 'AsignaEvalua_Proyec1':
//            if($Tipo=='ObservacionTecnica') { $Control_Ver['EST_SEGUIMIENTO'] = $Ver;}
//            break;
        case 'ResponsableLegal1':
            $Control_Ver['PlanSolicitudProyecto_COD_PIP'] = $Ver;
            $Control_Ver['DES_SEGUIMIENTO'] = $Ver;
            $Control_Ver['FEC_SEGUIMIENTO'] = $Ver;
            break;
    }
        
    return $Control_Ver;
}


function PetaniaEtiketa ($PermisosPerfil) {
           
    $Petania_Etiketa['Grilla1'] = 'Lista de Proyectos Solicitados';
    $Petania_Etiketa['Grilla2'] = '';
    $Petania_Etiketa['Detalle1'] = 'Detalle de Proyectos';
    
    switch ($PermisosPerfil) {
//        case 'RegisSolicitudFFTO1':
//            $Petania_Etiketa['Grilla1'] = 'Lista de Proyectos por Solicitud de Financiamiento';
//            $Petania_Etiketa['Detalle1'] = 'Detalle del Proyecto';
//            break;

        
        case 'ResponsableLegal1':
            $Petania_Etiketa['Grilla1'] = 'Lista de Proyectos con Evaluación Técnica';
            $Petania_Etiketa['Detalle1'] = 'Proyecto Evaluado';
//            $Petania_Etiketa['Grilla2'] = 'Lista de Proyectos con Opinión Legal';
            break;
    }
    return $Petania_Etiketa ;
}


function Grid_BotonNuevo ($PermisosPerfil) {
           
    $Grid_BotonNuevo = false;
    
    switch ($PermisosPerfil) {
        case 'ADMIN1':
            $Grid_BotonNuevo = true;
            break;
        case 'RegisSolicitudFFTO1':
            $Grid_BotonNuevo = true;
            break;
    }
    return $Grid_BotonNuevo ;
}


function Grid_CabezaPadre ($PermisosPerfil) {
           
    $GridCabezaPadre = false;
    
    switch ($PermisosPerfil) {
        case 'ADMIN1':
            $GridCabezaPadre = true;
            break;
        case 'RegisSolicitudFFTO1':
            $GridCabezaPadre = true;
            break;
    }
    return $GridCabezaPadre ;
}




function Grid_Filtro ($PermisosPerfil,$Tipo,$IdPlanRecurso) {
           
    $GridFiltro['Filtro1'] = '';
    
    if($Tipo=='Inicio') {
        switch ($PermisosPerfil) {

            case 'ResponsableLegal1':
                $GridFiltro['Filtro1'] = " AND ( T.EST_SEGUIMIENTO = '3' OR T.EST_SEGUIMIENTO = '7' ) ";
                break;
        }
    } elseif ($Tipo=='Ventana2'){
        switch ($PermisosPerfil) {
            case 'ADMIN1':
                break;
            case 'RegisSolicitudFFTO1':
                break;
            case 'AsignaProy_Evalu1':
                //$GridFiltro['Filtro1'] = " AND T.EST_SEGUIMIENTO = '2' ";
		$GridFiltro['Filtro1'] = " AND T.EST_SEGUIMIENTO <> '1' ";
                break;
            case 'EvaluadorProyecto1':
		$GridFiltro['Filtro1'] = " AND T.IDE_EVALUADOR = ". $IdPlanRecurso ;
                //$GridFiltro['Filtro1'] = " AND T.EST_SEGUIMIENTO = '3'  AND T.IDE_EVALUADOR = ". $IdPlanRecurso ;
                break;
            case 'ResponsableLegal1':
                $GridFiltro['Filtro1'] = " AND T.EST_SEGUIMIENTO = '6' ";
                break;
        }
    }
    
    return $GridFiltro ;
}


?>