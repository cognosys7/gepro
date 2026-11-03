<?php
/* * ******************************************************************************
  //  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada      
 //  Propósito       : Complemento del archivo BIDM_GASTO_CONSOLIDAln
 //  Fecha           : 16 de Enero 2020 02:38:39 p.m.
 //  Desde el Modelo : MF_PROCESO_LICENCIAS
 //  Modificado      : miércoles, 2 de junio de 2021 18:47:40
 //
 //***************************************************************************** */

require_once(PATH_CONTROLADOR_DAO . "/BIDM_GASTO_CONSOLIDAdao.php");

require_once("/LNinclude.php");
       


function BIDM_GASTO_CONSOLIDA_Datos($PIDE) {
    
			$IDE_BIDM_GASTO_CONSOLIDA = NULL;
			$AsientoIde = NULL;
			$AsientoNumDocumento = NULL;
			$AsientoAnio = NULL;
			$AsientoPeriodo = NULL;
			$CencoCodigo = NULL;
			$CencoNombre = NULL;
			$ContratoOrden = NULL;
			$OrdenCodigo = NULL;
			$ActorDocumento = NULL;
			$ActorNombre = NULL;
			$ProyectoCodigo = NULL;
			$ProyectoNombreCorto = NULL;
			$ProyGrupoCodigo = NULL;
			$CtaCodigo = NULL;
			$CtaNomPartida = NULL;
			$CtaNomClase = NULL;
			$CtaNombre = NULL;
			$FuenteAbrev = NULL;
			$AsientoMontoSoles = NULL;
			$Fase = NULL;
			$Componente = NULL;
			$EST_BIDM_GASTO_CONSOLIDA = NULL;   
     
    
         $campos = "";
			$campos .= "IDE_BIDM_GASTO_CONSOLIDA, " ;
			$campos .= "AsientoIde, " ;
			$campos .= "AsientoNumDocumento, " ;
			$campos .= "AsientoAnio, " ;
			$campos .= "AsientoPeriodo, " ;
			$campos .= "CencoCodigo, " ;
			$campos .= "CencoNombre, " ;
			$campos .= "ContratoOrden, " ;
			$campos .= "OrdenCodigo, " ;
			$campos .= "ActorDocumento, " ;
			$campos .= "ActorNombre, " ;
			$campos .= "ProyectoCodigo, " ;
			$campos .= "ProyectoNombreCorto, " ;
			$campos .= "ProyGrupoCodigo, " ;
			$campos .= "CtaCodigo, " ;
			$campos .= "CtaNomPartida, " ;
			$campos .= "CtaNomClase, " ;
			$campos .= "CtaNombre, " ;
			$campos .= "FuenteAbrev, " ;
			$campos .= "AsientoMontoSoles, " ;
			$campos .= "Fase, " ;
			$campos .= "Componente, " ;
			$campos .= "EST_BIDM_GASTO_CONSOLIDA, " ;   
         $campos = substr($campos , 0, strlen($campos)-2) ;
         
         
   
    if($PIDE>0){
        $filtro = "  AND IDE_BIDM_GASTO_CONSOLIDA =".$PIDE ;// echo $campos.''.$filtro.'-';die;            
        $data = VIS_SelCampos ('BIDM_GASTO_CONSOLIDA',$campos,$filtro) ;
        if(count($data)>0) {
			   $IDE_BIDM_GASTO_CONSOLIDA  = $data[0]->IDE_BIDM_GASTO_CONSOLIDA ;
			   $AsientoIde  = $data[0]->AsientoIde ;
			   $AsientoNumDocumento  = $data[0]->AsientoNumDocumento ;
			   $AsientoAnio  = $data[0]->AsientoAnio ;
			   $AsientoPeriodo  = $data[0]->AsientoPeriodo ;
			   $CencoCodigo  = $data[0]->CencoCodigo ;
			   $CencoNombre  = $data[0]->CencoNombre ;
			   $ContratoOrden  = $data[0]->ContratoOrden ;
			   $OrdenCodigo  = $data[0]->OrdenCodigo ;
			   $ActorDocumento  = $data[0]->ActorDocumento ;
			   $ActorNombre  = $data[0]->ActorNombre ;
			   $ProyectoCodigo  = $data[0]->ProyectoCodigo ;
			   $ProyectoNombreCorto  = $data[0]->ProyectoNombreCorto ;
			   $ProyGrupoCodigo  = $data[0]->ProyGrupoCodigo ;
			   $CtaCodigo  = $data[0]->CtaCodigo ;
			   $CtaNomPartida  = $data[0]->CtaNomPartida ;
			   $CtaNomClase  = $data[0]->CtaNomClase ;
			   $CtaNombre  = $data[0]->CtaNombre ;
			   $FuenteAbrev  = $data[0]->FuenteAbrev ;
			   $AsientoMontoSoles  = $data[0]->AsientoMontoSoles ;
			   $Fase  = $data[0]->Fase ;
			   $Componente  = $data[0]->Componente ;
			   $EST_BIDM_GASTO_CONSOLIDA  = $data[0]->EST_BIDM_GASTO_CONSOLIDA ;        }
    }
    
    $Resultado = array (
      'BIDE'   => $IDE_BIDM_GASTO_CONSOLIDA   
      ,'AsientoIde'=> $AsientoIde
      ,'AsientoNumDocumento'=> $AsientoNumDocumento
      ,'AsientoAnio'=> $AsientoAnio
      ,'AsientoPeriodo'=> $AsientoPeriodo
      ,'CencoCodigo'=> $CencoCodigo
      ,'CencoNombre'=> $CencoNombre
      ,'ContratoOrden'=> $ContratoOrden
      ,'OrdenCodigo'=> $OrdenCodigo
      ,'ActorDocumento'=> $ActorDocumento
      ,'ActorNombre'=> $ActorNombre
      ,'ProyectoCodigo'=> $ProyectoCodigo
      ,'ProyectoNombreCorto'=> $ProyectoNombreCorto
      ,'ProyGrupoCodigo'=> $ProyGrupoCodigo
      ,'CtaCodigo'=> $CtaCodigo
      ,'CtaNomPartida'=> $CtaNomPartida
      ,'CtaNomClase'=> $CtaNomClase
      ,'CtaNombre'=> $CtaNombre
      ,'FuenteAbrev'=> $FuenteAbrev
      ,'AsientoMontoSoles'=> $AsientoMontoSoles
      ,'Fase'=> $Fase
      ,'Componente'=> $Componente
      ,'EST_BIDM_GASTO_CONSOLIDA'=> $EST_BIDM_GASTO_CONSOLIDA
    ) ;
    
    return $Resultado ;
}


function Tabla_BIDM_GASTO_CONSOLIDA_Datos_sumMonto ( $filtro ) {
    
    $Data = BIDM_GASTO_CONSOLIDA_Datos_sumMonto ( $filtro ) ; //var_dump($Data);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'"> Monto Total :</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> S/. ' . number_format($Data['AsientoMontoSoles'],2) . '</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'"> </td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> </td>';
    $DatosPadre .= '</tr>';
   
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}


////////////////////////////////////////////////////////////////////////////////




function BIDM_GASTO_CONSOLIDA_Datos_sumMonto($filtro) {
    $AsientoMontoSoles = NULL;

    $campos = "";
    $campos .= " sum(AsientoMontoSoles) as AsientoMontoSoles, " ;
    $campos = substr($campos, 0, strlen($campos) - 2);

    if ( strlen($filtro)>0 ) {
//        $filtro = "  AND IDE_BIDM_GASTO_CONSOLIDA =".$PIDE ;          
        $data = VIS_SelCampos ('BIDM_GASTO_CONSOLIDA',$campos,$filtro) ;
        if(count($data)>0) {
           $AsientoMontoSoles  = $data[0]->AsientoMontoSoles ;
        }
    }
     
    $Resultado = array (
      'AsientoMontoSoles'=> $AsientoMontoSoles
    ) ;
    
    return $Resultado ;
}

//function BIDM_GASTO_CONSOLIDA_Datos_sumMonto($filtro) {
//
//    $AsientoMontoSoles = NULL;
//
//
//    $campos = "";
//    $campos = substr($campos, 0, strlen($campos) - 2);
//
//
//    if ( strlen($filtro)>0 ) {
//        //$filtro = "  AND IDE_BIDM_GASTO_CONSOLIDA =" . $PIDE; 
//echo $campos.' || '.$filtro.' || ';//exit;            
//        $Resultado  =   array();
//        $Objeto     =   new BIDM_GASTO_CONSOLIDA_DAO();  
//        $procedure_parametrosMS = array(
//            array(&$campos, SQLSRV_PARAM_IN)
//            , array(&$filtro, SQLSRV_PARAM_IN)
//        );
//
//        $Objeto->SelCampos_sumMonto_BIDM_GASTO_CONSOLIDA($Resultado, $procedure_parametrosMS);
//        if (count($Resultado)>0){
//            $AsientoMontoSoles = $data[0]->AsientoMontoSoles;
//        } 
//
//        $Resultado = array(
//            'AsientoMontoSoles' => $AsientoMontoSoles
//         );
//
//        return $Resultado;
//    }
//}