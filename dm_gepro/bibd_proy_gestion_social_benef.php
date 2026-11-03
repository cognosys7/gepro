<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_GESTION_SOCIAL_BENEF
//  Fecha           : miércoles, 21 de julio de 2021 12:57:20
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_GESTION_SOCIAL_BENEF(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			SocialBenefIde ,
			SocialIde ,
			SocialBenefConceptoSup ,
			SocialBenefConcepto ,
			SocialBenefActividad ,
			SocialBenefCantidad ,
			SocialBenefConcpNivel ,
			SocialBenefFecInicio ,
			SocialBenefFecTermino ,
			SocialBenefEstado 
         FROM BIBD_PROY_GESTION_SOCIAL_BENEF order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['SocialBenefIde'] = $fila['SocialBenefIde'];  
				$elemento['SocialIde'] = $fila['SocialIde'];  
				$elemento['SocialBenefConceptoSup'] = $fila['SocialBenefConceptoSup'];  
				$elemento['SocialBenefConcepto'] = $fila['SocialBenefConcepto'];  
				$elemento['SocialBenefActividad'] = $fila['SocialBenefActividad'];  
				$elemento['SocialBenefCantidad'] = $fila['SocialBenefCantidad'];  
				$elemento['SocialBenefConcpNivel'] = $fila['SocialBenefConcpNivel'];  
				$elemento['SocialBenefFecInicio'] = $fila['SocialBenefFecInicio'];  
				$elemento['SocialBenefFecTermino'] = $fila['SocialBenefFecTermino'];  
				$elemento['SocialBenefEstado'] = $fila['SocialBenefEstado']; 
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
