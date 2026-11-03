<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROCESO_ITEM_POSTOR
//  Fecha           : sábado, 27 de julio de 2019 13:12:47
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROCESO_ITEM_POSTOR(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AdqItemIde ,
			ProcItemNumItem ,
			ProcItemCodProyecto ,
			ProcItemPostorRuc ,
			ProcItemPostorRazonSoc ,
			ProcItemPostorTipo ,
			ProcItemPostorValorRefe ,
			ProcItemPostorValorOfer ,
			ProcItemPostorFecPropu ,
			ProcItemPostorEstado 
         FROM BIBD_PROCESO_ITEM_POSTOR order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AdqItemIde'] = $fila['AdqItemIde'];  
				$elemento['ProcItemNumItem'] = $fila['ProcItemNumItem'];  
				$elemento['ProcItemCodProyecto'] = $fila['ProcItemCodProyecto'];  
				$elemento['ProcItemPostorRuc'] = $fila['ProcItemPostorRuc'];  
				$elemento['ProcItemPostorRazonSoc'] = $fila['ProcItemPostorRazonSoc'];  
				$elemento['ProcItemPostorTipo'] = $fila['ProcItemPostorTipo'];  
				$elemento['ProcItemPostorValorRefe'] = $fila['ProcItemPostorValorRefe'];  
				$elemento['ProcItemPostorValorOfer'] = $fila['ProcItemPostorValorOfer'];  
				$elemento['ProcItemPostorFecPropu'] = $fila['ProcItemPostorFecPropu'];  
				$elemento['ProcItemPostorEstado'] = $fila['ProcItemPostorEstado']; 
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
