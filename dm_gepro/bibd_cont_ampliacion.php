<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -       
//  Propósito       : BIBD_CONT_AMPLIACION
//  Fecha           : miércoles, 19 de mayo de 2021 2:50:01
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAMEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_AMPLIACION(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AmpIde ,
			ContIde ,
			AmpTipoPlazo ,
			AmpNumAmpliacion ,
			AmpFecInicio ,
			AmpCantDiasCalendario ,
			AmpFecTermino ,
			AmpResolucion ,
			AmpEstado 
         FROM BIBD_CONT_AMPLIACION order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AmpIde'] = $fila['AmpIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['AmpTipoPlazo'] = $fila['AmpTipoPlazo'];  
				$elemento['AmpNumAmpliacion'] = $fila['AmpNumAmpliacion'];  
				$elemento['AmpFecInicio'] = $fila['AmpFecInicio'];  
				$elemento['AmpCantDiasCalendario'] = $fila['AmpCantDiasCalendario'];  
				$elemento['AmpFecTermino'] = $fila['AmpFecTermino'];  
				$elemento['AmpResolucion'] = $fila['AmpResolucion'];  
				$elemento['AmpEstado'] = $fila['AmpEstado']; 
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
