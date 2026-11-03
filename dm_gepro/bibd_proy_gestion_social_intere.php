<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_GESTION_SOCIAL_INTERE
//  Fecha           : miércoles, 21 de julio de 2021 12:57:46
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_GESTION_SOCIAL_INTERE(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			SocialIntrsaIde ,
			SocialIde ,
			InteresadoIde ,
			SocialIntrsaNombre ,
			SocialIntrsaTipo ,
			SocialIntrsaRol ,
			SocialIntrsaCargo ,
			SocialIntrsaEstado 
         FROM BIBD_PROY_GESTION_SOCIAL_INTERE order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['SocialIntrsaIde'] = $fila['SocialIntrsaIde'];  
				$elemento['SocialIde'] = $fila['SocialIde'];  
				$elemento['InteresadoIde'] = $fila['InteresadoIde'];  
				$elemento['SocialIntrsaNombre'] = $fila['SocialIntrsaNombre'];  
				$elemento['SocialIntrsaTipo'] = $fila['SocialIntrsaTipo'];  
				$elemento['SocialIntrsaRol'] = $fila['SocialIntrsaRol'];  
				$elemento['SocialIntrsaCargo'] = $fila['SocialIntrsaCargo'];  
				$elemento['SocialIntrsaEstado'] = $fila['SocialIntrsaEstado']; 
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
