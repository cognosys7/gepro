<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_GESTION_SOCIAL_ACTIV
//  Fecha           : sábado, 27 de julio de 2019 12:59:10
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_GESTION_SOCIAL_ACTIV(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			SocialActivIde ,
			SocialIde ,
			SocialActivTipo ,
			SocialActivProgramada ,
			SocialActivFecProgram ,
			SocialActivRealizada ,
			SocialActivFecRealiza ,
			SocialActiviEstado 
         FROM BIBD_PROY_GESTION_SOCIAL_ACTIV order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['SocialActivIde'] = $fila['SocialActivIde']; 
				$elemento['SocialIde'] = $fila['SocialIde'];  
				$elemento['SocialActivTipo'] = $fila['SocialActivTipo'];  
				$elemento['SocialActivProgramada'] = $fila['SocialActivProgramada'];  
				$elemento['SocialActivFecProgram'] = $fila['SocialActivFecProgram'];  
				$elemento['SocialActivRealizada'] = $fila['SocialActivRealizada'];  
				$elemento['SocialActivFecRealiza'] = $fila['SocialActivFecRealiza'];  
				$elemento['SocialActiviEstado'] = $fila['SocialActiviEstado']; 
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
