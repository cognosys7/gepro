<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_ACCION_GESTION
//  Fecha           : viernes, 9 de julio de 2021 12:47:55
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_ACCION_GESTION(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AccionIde ,
			ProyIde ,
			AccionFecha ,
			ComponenteTipo ,
			ComponenteCodTipo ,
			AccionDescripcion ,
			AccionEstado 
         FROM BIBD_PROY_ACCION_GESTION order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AccionIde'] = $fila['AccionIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['AccionFecha'] = $fila['AccionFecha'];  
				$elemento['ComponenteTipo'] = $fila['ComponenteTipo'];  
				$elemento['ComponenteCodTipo'] = $fila['ComponenteCodTipo'];  
				$elemento['AccionDescripcion'] = $fila['AccionDescripcion'];  
				$elemento['AccionEstado'] = $fila['AccionEstado']; 
            $arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		http_response_code(500);
		$mensaje  = '<b>Consulta No Válida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}
}
?>
