<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_DOCUMENTACION_ARCHIVO
//  Fecha           : sábado, 27 de julio de 2019 13:40:49
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_DOCUMENTACION_ARCHIVO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContDocumentoIde ,
			ContDocumArchIde ,
			ContDocumArchTabla ,
			ContDocumArchRuta ,
			ContDocumArchNombre ,
			ContDocumArchEstado 
         FROM BIBD_CONT_DOCUMENTACION_ARCHIVO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContDocumentoIde'] = $fila['ContDocumentoIde'];  
				$elemento['ContDocumArchIde'] = $fila['ContDocumArchIde'];  
				$elemento['ContDocumArchTabla'] = $fila['ContDocumArchTabla'];  
				$elemento['ContDocumArchRuta'] = $fila['ContDocumArchRuta'];  
				$elemento['ContDocumArchNombre'] = $fila['ContDocumArchNombre'];  
				$elemento['ContDocumArchEstado'] = $fila['ContDocumArchEstado']; 
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
