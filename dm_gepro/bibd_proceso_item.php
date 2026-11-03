<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROCESO_ITEM
//  Fecha           : sábado, 27 de julio de 2019 13:12:30
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROCESO_ITEM(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AdqItemIde ,
			AdquisiProceso ,
			AdquisiCodPAC ,
			AdquisiAnio ,
			AdquisiNumProceso ,
			AdqItemNumItem ,
			AdqItemCodProyecto ,
			AdqItemDepartamento ,
			AdqItemProvincia ,
			AdqItemDistrito ,
			AdqItemObjetoContrato ,
			AdqItemNumPropuestas ,
			AdqItemFecPublicacion ,
			AdqItemFecBuenaProIni ,
			AdqItemFecBuenaProFin ,
			AdqItemFecApelacion ,
			AdqItemFecAdjudicacio ,
			AdqItemFecContratoIni ,
			AdqItemFecContratoTer ,
			AdqItemNumContrato ,
			AdqItemValorReferencia ,
			AdqItemValorAdjudicado ,
			AdqItemPostorGanador ,
			AdqItemPostorGanadRUC ,
			AdqItemObservacion ,
			AdqItemModoEjecucion ,
			AdqItemModoEjecuciAbrev ,
			AdqItemUnidadMedida ,
			AdqItemCantidad ,
			AdqItemEstado 
         FROM BIBD_PROCESO_ITEM order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AdqItemIde'] = $fila['AdqItemIde'];  
				$elemento['AdquisiProceso'] = $fila['AdquisiProceso'];  
				$elemento['AdquisiCodPAC'] = $fila['AdquisiCodPAC'];  
				$elemento['AdquisiAnio'] = $fila['AdquisiAnio'];  
				$elemento['AdquisiNumProceso'] = $fila['AdquisiNumProceso'];  
				$elemento['AdqItemNumItem'] = $fila['AdqItemNumItem'];  
				$elemento['AdqItemCodProyecto'] = $fila['AdqItemCodProyecto'];  
				$elemento['AdqItemDepartamento'] = $fila['AdqItemDepartamento'];  
				$elemento['AdqItemProvincia'] = $fila['AdqItemProvincia'];  
				$elemento['AdqItemDistrito'] = $fila['AdqItemDistrito'];  
				$elemento['AdqItemObjetoContrato'] = $fila['AdqItemObjetoContrato'];  
				$elemento['AdqItemNumPropuestas'] = $fila['AdqItemNumPropuestas'];  
				$elemento['AdqItemFecPublicacion'] = $fila['AdqItemFecPublicacion'];  
				$elemento['AdqItemFecBuenaProIni'] = $fila['AdqItemFecBuenaProIni'];  
				$elemento['AdqItemFecBuenaProFin'] = $fila['AdqItemFecBuenaProFin'];  
				$elemento['AdqItemFecApelacion'] = $fila['AdqItemFecApelacion'];  
				$elemento['AdqItemFecAdjudicacio'] = $fila['AdqItemFecAdjudicacio'];  
				$elemento['AdqItemFecContratoIni'] = $fila['AdqItemFecContratoIni'];  
				$elemento['AdqItemFecContratoTer'] = $fila['AdqItemFecContratoTer'];  
				$elemento['AdqItemNumContrato'] = $fila['AdqItemNumContrato'];  
				$elemento['AdqItemValorReferencia'] = $fila['AdqItemValorReferencia'];  
				$elemento['AdqItemValorAdjudicado'] = $fila['AdqItemValorAdjudicado'];  
				$elemento['AdqItemPostorGanador'] = $fila['AdqItemPostorGanador'];  
				$elemento['AdqItemPostorGanadRUC'] = $fila['AdqItemPostorGanadRUC'];  
				$elemento['AdqItemObservacion'] = $fila['AdqItemObservacion'];  
				$elemento['AdqItemModoEjecucion'] = $fila['AdqItemModoEjecucion'];  
				$elemento['AdqItemModoEjecuciAbrev'] = $fila['AdqItemModoEjecuciAbrev'];  
				$elemento['AdqItemUnidadMedida'] = $fila['AdqItemUnidadMedida'];  
				$elemento['AdqItemCantidad'] = $fila['AdqItemCantidad'];  
				$elemento['AdqItemEstado'] = $fila['AdqItemEstado']; 
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
