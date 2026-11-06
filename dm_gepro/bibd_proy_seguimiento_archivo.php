<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_ETAPA_SEGUIMIENTO_ARCHIVO
//  Fecha           : jueves, 19 de setiembre de 2019 14:34:00
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_SEGUIMIENTO_ARCHIVO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			SeguimIde ,
			SeguimArchIde ,
			SeguimArchTabla ,
			SeguimArchRuta ,
			SeguimArchNombre ,
			SeguimArchEstado ,
			SeguimIdeProyecto,
			SeguimDesSeguimiento,
			SeguimFecSeguimiento

         FROM BIBD_PROY_SEGUIMIENTO_ARCHIVO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['SeguimIde'] = $fila['SeguimIde'];  
				$elemento['SeguimArchIde'] = $fila['SeguimArchIde'];  
				$elemento['SeguimArchTabla'] = $fila['SeguimArchTabla'];  
				$elemento['SeguimArchRuta'] = $fila['SeguimArchRuta'];  
				$elemento['SeguimArchNombre'] = $fila['SeguimArchNombre'];  
				$elemento['SeguimArchEstado'] = $fila['SeguimArchEstado']; 
				$elemento['SeguimIdeProyecto'] = $fila['SeguimIdeProyecto']; 
				$elemento['SeguimDesSeguimiento'] = $fila['SeguimDesSeguimiento']; 
				$elemento['SeguimFecSeguimiento'] = $fila['SeguimFecSeguimiento']; 

            $arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		http_response_code(500);
		$mensaje  = '<b>Consulta No V�lida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}
}
?>
