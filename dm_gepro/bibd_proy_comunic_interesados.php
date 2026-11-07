<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_COMUNIC_INTERESADOS
//  Fecha           : sábado, 27 de julio de 2019 12:57:08
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_COMUNIC_INTERESADOS(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ComIntrsaIde ,
			ComunicaIde ,
			ComunicaNombre ,
			ComunicaFecInicio ,
			ComuniIntrsaCod ,
			ComuniIntrsaNombre ,
			ComIntrsaRol ,
			ComIntrsaCargo ,
			ComIntersResponsabi ,
			ComIntersComentario ,
			ComIntersEstado 
         FROM BIBD_PROY_COMUNIC_INTERESADOS order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ComIntrsaIde'] = $fila['ComIntrsaIde'];  
				$elemento['ComunicaIde'] = $fila['ComunicaIde'];  
				$elemento['ComunicaNombre'] = $fila['ComunicaNombre'];  
				$elemento['ComunicaFecInicio'] = $fila['ComunicaFecInicio'];  
				$elemento['ComuniIntrsaCod'] = $fila['ComuniIntrsaCod'];  
				$elemento['ComuniIntrsaNombre'] = $fila['ComuniIntrsaNombre'];  
				$elemento['ComIntrsaRol'] = $fila['ComIntrsaRol'];  
				$elemento['ComIntrsaCargo'] = $fila['ComIntrsaCargo'];  
				$elemento['ComIntersResponsabi'] = $fila['ComIntersResponsabi'];  
				$elemento['ComIntersComentario'] = $fila['ComIntersComentario'];  
				$elemento['ComIntersEstado'] = $fila['ComIntersEstado']; 
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
