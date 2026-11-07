<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_SEGUIMIENTO
//  Fecha           : sábado, 27 de julio de 2019 13:21:56
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_SEGUIMIENTO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContSeguimientoIde ,
			ContIde ,
			ContCodigoUnicoOrden ,
			ContSeguimientoAdverti ,
			ContSeguimientoMedida ,
			ContSeguimientoFecha ,
			ContSeguimientoEstado 
         FROM BIBD_CONT_SEGUIMIENTO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContSeguimientoIde'] = $fila['ContSeguimientoIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['ContSeguimientoAdverti'] = $fila['ContSeguimientoAdverti'];  
				$elemento['ContSeguimientoMedida'] = $fila['ContSeguimientoMedida'];  
				$elemento['ContSeguimientoFecha'] = $fila['ContSeguimientoFecha'];  
				$elemento['ContSeguimientoEstado'] = $fila['ContSeguimientoEstado']; 
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
