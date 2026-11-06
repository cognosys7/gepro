<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar Pisfil Ahumada                
//  Propósito       : BIBD_PERFIL_ACCESOS
//  Fecha           : viernes, 4 de octubre de 2019 16:18:22
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_SEG_PERFIL_ACCESOS(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			Sistema ,
			Perfil ,
			Modulo ,
			Opcion ,
			Estado 
         FROM BIBD_SEG_PERFIL_ACCESOS order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['Sistema'] = $fila['Sistema'];  
				$elemento['Perfil'] = $fila['Perfil'];  
				$elemento['Modulo'] = $fila['Modulo'];  
				$elemento['Opcion'] = $fila['Opcion'];  
				$elemento['Estado'] = $fila['Estado']; 
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
