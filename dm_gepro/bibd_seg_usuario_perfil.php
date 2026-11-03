<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar Pisfil Ahumada                 
//  Propósito       : BIBD_USUARIO_PERFIL
//  Fecha           : viernes, 4 de octubre de 2019 16:18:04
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_SEG_USUARIO_PERFIL(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			Personal ,
			Usuario ,
			Perfil ,
			Sistema 
         FROM BIBD_SEG_USUARIO_PERFIL order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['Personal'] = $fila['Personal'];  
				$elemento['Usuario'] = $fila['Usuario'];  
				$elemento['Perfil'] = $fila['Perfil'];  
				$elemento['Sistema'] = $fila['Sistema']; 
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
