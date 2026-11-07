<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar Pisfil Ahumada                
//  Propósito       : BIBD_PROY_GESTION_SOCIAL_ACTIV_ARCHIVO
//  Fecha           : miércoles, 11 de setiembre de 2019 20:24:08
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de agosto 2019
//******************************************************************************/

 function BIBD_PROY_GESTION_SOCIAL_ACTIV_ARCHIVO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			SocialActivIde ,
			SocialActivArchIde ,
			SocialActivArchTabla ,
			SocialActivArchRuta ,
			SocialActivArchNombre ,
			SocialActivArchivo ,
			SocialActivArchEstado 
         FROM BIBD_PROY_GESTION_SOCIAL_ACTIV_ARCHIVO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['SocialActivIde'] = $fila['SocialActivIde'];  
				$elemento['SocialActivArchIde'] = $fila['SocialActivArchIde'];  
				$elemento['SocialActivArchTabla'] = $fila['SocialActivArchTabla'];  
				$elemento['SocialActivArchRuta'] = $fila['SocialActivArchRuta'];  
				$elemento['SocialActivArchNombre'] = $fila['SocialActivArchNombre'];  
				$elemento['SocialActivArchivo'] = $fila['SocialActivArchivo'];  
				$elemento['SocialActivArchEstado'] = $fila['SocialActivArchEstado']; 
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
