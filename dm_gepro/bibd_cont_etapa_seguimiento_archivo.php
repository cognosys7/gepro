<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_ETAPA_SEGUIMIENTO_ARCHIVO
//  Fecha           : jueves, 19 de setiembre de 2019 14:34:00
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_SEGUIMIENTO_ARCHIVO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			EtapaSeguimIde ,
			EtapaSeguimArchIde ,
			EtapaSeguimArchTabla ,
			EtapaSeguimArchRuta ,
			EtapaSeguimArchNombre ,
			EtapaSeguimArchEstado 
         FROM BIBD_CONT_ETAPA_SEGUIMIENTO_ARCHIVO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['EtapaSeguimIde'] = $fila['EtapaSeguimIde'];  
				$elemento['EtapaSeguimArchIde'] = $fila['EtapaSeguimArchIde'];  
				$elemento['EtapaSeguimArchTabla'] = $fila['EtapaSeguimArchTabla'];  
				$elemento['EtapaSeguimArchRuta'] = $fila['EtapaSeguimArchRuta'];  
				$elemento['EtapaSeguimArchNombre'] = $fila['EtapaSeguimArchNombre'];  
				$elemento['EtapaSeguimArchEstado'] = $fila['EtapaSeguimArchEstado']; 
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
