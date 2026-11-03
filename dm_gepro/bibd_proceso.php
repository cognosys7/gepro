<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROCESO
//  Fecha           : sábado, 27 de julio de 2019 13:10:59
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROCESO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AdquisiProceso ,
			AdquisiTipo ,
			AdquisiTipoSigla ,
			SedeEjecutoraRUC ,
			SedeEjecutora ,
			CentroCostoCodigo ,
			CentroCosto ,
			AdquisiCodPAC ,
			AdquisiDepartamento ,
			AdquisiProvincia ,
			AdquisiDistrito ,
			AdquisiAnioEjec ,
			AdquisiNumProceso ,
			AdquisiTipoObjeto ,
			AdquisiObjetoContr ,
			AdquisiValorRefere ,
			AdquisiURL ,
			AdquisiEstado 
         FROM BIBD_PROCESO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AdquisiProceso'] = $fila['AdquisiProceso'];  
				$elemento['AdquisiTipo'] = $fila['AdquisiTipo'];  
				$elemento['AdquisiTipoSigla'] = $fila['AdquisiTipoSigla'];  
				$elemento['SedeEjecutoraRUC'] = $fila['SedeEjecutoraRUC'];  
				$elemento['SedeEjecutora'] = $fila['SedeEjecutora'];  
				$elemento['CentroCostoCodigo'] = $fila['CentroCostoCodigo'];  
				$elemento['CentroCosto'] = $fila['CentroCosto'];  
				$elemento['AdquisiCodPAC'] = $fila['AdquisiCodPAC'];  
				$elemento['AdquisiDepartamento'] = $fila['AdquisiDepartamento'];  
				$elemento['AdquisiProvincia'] = $fila['AdquisiProvincia'];  
				$elemento['AdquisiDistrito'] = $fila['AdquisiDistrito'];  
				$elemento['AdquisiAnioEjec'] = $fila['AdquisiAnioEjec'];  
				$elemento['AdquisiNumProceso'] = $fila['AdquisiNumProceso'];  
				$elemento['AdquisiTipoObjeto'] = $fila['AdquisiTipoObjeto'];  
				$elemento['AdquisiObjetoContr'] = $fila['AdquisiObjetoContr'];  
				$elemento['AdquisiValorRefere'] = $fila['AdquisiValorRefere'];  
				$elemento['AdquisiURL'] = $fila['AdquisiURL'];  
				$elemento['AdquisiEstado'] = $fila['AdquisiEstado']; 
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
