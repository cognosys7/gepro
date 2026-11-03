<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_RIESGO_PROBLEMA
//  Fecha           : lunes, 9 de setiembre de 2019 20:34:48
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (3)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_RIESGO_PROBLEMA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContIde ,
			ContCodigoUnicoOrden ,
			RiesgoIde ,
			RiesgoTipo ,
			RiesgoCodigo ,
			RiesgoDescripcion ,
			ImpactoRiesgoNombre ,
			ImpactoRiesgoValor ,
			ProbabiliRiesgoNombre ,
			ProbabiliRiesgoValor ,
			PrioridadRiesgoNombre ,
			PrioridadRiesgoValor ,
			RiesgoCausaGeneradora ,
			RiesgoDisparador ,
			RiesgoAccionrespuesta ,
			RiesgoEstrategia ,
			RiesgoEstado ,
			RiesgoFechaInicio ,
			RiesgoFechaTermino ,
			RiesgoAlertaDias ,
			RiesgoAlertaColor ,
			RiesgoAlertaTitulo ,
			RiesgoAlertaMensaje 
         FROM BIBD_CONT_RIESGO_PROBLEMA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['RiesgoIde'] = $fila['RiesgoIde'];  
				$elemento['RiesgoTipo'] = $fila['RiesgoTipo'];  
				$elemento['RiesgoCodigo'] = $fila['RiesgoCodigo'];  
				$elemento['RiesgoDescripcion'] = $fila['RiesgoDescripcion'];  
				$elemento['ImpactoRiesgoNombre'] = $fila['ImpactoRiesgoNombre'];  
				$elemento['ImpactoRiesgoValor'] = $fila['ImpactoRiesgoValor'];  
				$elemento['ProbabiliRiesgoNombre'] = $fila['ProbabiliRiesgoNombre'];  
				$elemento['ProbabiliRiesgoValor'] = $fila['ProbabiliRiesgoValor'];  
				$elemento['PrioridadRiesgoNombre'] = $fila['PrioridadRiesgoNombre'];  
				$elemento['PrioridadRiesgoValor'] = $fila['PrioridadRiesgoValor'];  
				$elemento['RiesgoCausaGeneradora'] = $fila['RiesgoCausaGeneradora'];  
				$elemento['RiesgoDisparador'] = $fila['RiesgoDisparador'];  
				$elemento['RiesgoAccionrespuesta'] = $fila['RiesgoAccionrespuesta'];  
				$elemento['RiesgoEstrategia'] = $fila['RiesgoEstrategia'];  
				$elemento['RiesgoEstado'] = $fila['RiesgoEstado'];  
				$elemento['RiesgoFechaInicio'] = $fila['RiesgoFechaInicio'];  
				$elemento['RiesgoFechaTermino'] = $fila['RiesgoFechaTermino'];  
				$elemento['RiesgoAlertaDias'] = $fila['RiesgoAlertaDias'];  
				$elemento['RiesgoAlertaColor'] = $fila['RiesgoAlertaColor'];  
				$elemento['RiesgoAlertaTitulo'] = $fila['RiesgoAlertaTitulo'];  
				$elemento['RiesgoAlertaMensaje'] = $fila['RiesgoAlertaMensaje']; 
            $arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta No Válida:</b> ' . $e->getMessage() . "<br/>";
		$mensaje .= '<b>Consulta: </b>' . $sql;
		die($mensaje);
	}
}
?>
