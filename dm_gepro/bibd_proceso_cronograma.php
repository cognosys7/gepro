<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROCESO_CRONOGRAMA
//  Fecha           : sábado, 27 de julio de 2019 13:12:02
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROCESO_CRONOGRAMA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AdquisiProceso ,
			AdquisiCodPAC ,
			AdquisiAnio ,
			AdquisiNumProceso ,
			AdquisiCronNumOrden ,
			AdquisiCronFecPublica ,
			AdquisiCronActividad ,
			AdquisiCronFecInicio ,
			AdquisiCronFecFinaliza ,
			AdquisiCronEstado 
         FROM BIBD_PROCESO_CRONOGRAMA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AdquisiProceso'] = $fila['AdquisiProceso'];  
				$elemento['AdquisiCodPAC'] = $fila['AdquisiCodPAC'];  
				$elemento['AdquisiAnio'] = $fila['AdquisiAnio'];  
				$elemento['AdquisiNumProceso'] = $fila['AdquisiNumProceso'];  
				$elemento['AdquisiCronNumOrden'] = $fila['AdquisiCronNumOrden'];  
				$elemento['AdquisiCronFecPublica'] = $fila['AdquisiCronFecPublica'];  
				$elemento['AdquisiCronActividad'] = $fila['AdquisiCronActividad'];  
				$elemento['AdquisiCronFecInicio'] = $fila['AdquisiCronFecInicio'];  
				$elemento['AdquisiCronFecFinaliza'] = $fila['AdquisiCronFecFinaliza'];  
				$elemento['AdquisiCronEstado'] = $fila['AdquisiCronEstado']; 
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
