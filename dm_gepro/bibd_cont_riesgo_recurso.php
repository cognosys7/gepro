<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_RIESGO_RECURSO
//  Fecha           : s�bado, 27 de julio de 2019 13:19:29
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_RIESGO_RECURSO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			RiesgoIde ,
			RiesgoRecursoIde ,
			RecursoTipo ,
			RecursoCodigo ,
			RecursoNombre ,
			RecursoSedeEntidad ,

			RiesgoRecursoEstado 
         FROM BIBD_CONT_RIESGO_RECURSO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['RiesgoIde'] = $fila['RiesgoIde'];  
				$elemento['RiesgoRecursoIde'] = $fila['RiesgoRecursoIde'];  
				$elemento['RecursoTipo'] = $fila['RecursoTipo'];  
				$elemento['RecursoCodigo'] = $fila['RecursoCodigo'];  
				$elemento['RecursoNombre'] = $fila['RecursoNombre'];  
				$elemento['RecursoSedeEntidad'] = $fila['RecursoSedeEntidad']; 

				$elemento['RiesgoRecursoEstado'] = $fila['RiesgoRecursoEstado']; 
            $arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta No V�lida:</b> ' . $e->getMessage() . "<br/>";
		$mensaje .= '<b>Consulta: </b>' . $sql;
		die($mensaje);
	}
}
?>
