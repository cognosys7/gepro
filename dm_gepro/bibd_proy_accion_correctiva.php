<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_ACCION_CORRECTIVA
//  Fecha           : lunes, 12 de julio de 2021 21:41:12
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_ACCION_CORRECTIVA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AccionIde ,
			ProyIde ,
			AccionFecha ,
			DesviacionAutomatica ,
			AccionCorrectiva ,
			AccionEstado,
			Componente 
         FROM BIBD_PROY_ACCION_CORRECTIVA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AccionIde'] = $fila['AccionIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['AccionFecha'] = $fila['AccionFecha'];  
				$elemento['DesviacionAutomatica'] = $fila['DesviacionAutomatica'];  
				$elemento['AccionCorrectiva'] = $fila['AccionCorrectiva'];  
				$elemento['AccionEstado'] = $fila['AccionEstado']; 
				$elemento['Componente'] = $fila['Componente']; 
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
