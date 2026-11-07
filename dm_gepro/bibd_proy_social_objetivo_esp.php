<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_SOCIAL_OBJETIVO_ESP
//  Fecha           : miércoles, 21 de julio de 2021 12:54:01
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_SOCIAL_OBJETIVO_ESP(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ObjetivoEspIde ,
			ProyIde ,
			AccionFecha ,
			ObjetivoEspecifico ,
			Meta ,
			Indicador ,
			Actividad ,
			ObjetivoEspEstado 
         FROM BIBD_PROY_SOCIAL_OBJETIVO_ESP order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ObjetivoEspIde'] = $fila['ObjetivoEspIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['AccionFecha'] = $fila['AccionFecha'];  
				$elemento['ObjetivoEspecifico'] = $fila['ObjetivoEspecifico'];  
				$elemento['Meta'] = $fila['Meta'];  
				$elemento['Indicador'] = $fila['Indicador'];  
				$elemento['Actividad'] = $fila['Actividad'];  
				$elemento['ObjetivoEspEstado'] = $fila['ObjetivoEspEstado']; 
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
