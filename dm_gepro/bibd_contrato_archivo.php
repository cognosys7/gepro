<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONTRATO_ARCHIVO
//  Fecha           : sábado, 27 de julio de 2019 13:14:24
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONTRATO_ARCHIVO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContratoIde ,
			ContArchIde ,
			ContArchTabla ,
			ContArchRuta ,
			ContArchNombre ,
			ContArchEstado 
         FROM BIBD_CONTRATO_ARCHIVO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContratoIde'] = $fila['ContratoIde'];  
				$elemento['ContArchIde'] = $fila['ContArchIde'];  
				$elemento['ContArchTabla'] = $fila['ContArchTabla'];  
				$elemento['ContArchRuta'] = $fila['ContArchRuta'];  
				$elemento['ContArchNombre'] = $fila['ContArchNombre'];  
				$elemento['ContArchEstado'] = $fila['ContArchEstado']; 
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
