<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_COMUNICACION
//  Fecha           : s�bado, 27 de julio de 2019 12:53:41
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_COMUNICACION(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ProyIde ,
			ComunicaIde ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			ProyCodigoSNIP ,
			ProyNombre ,
			ProyEstado ,
			ComunicaNombre ,
			ComunicaFecInicio ,
			ComunicaFecTermino ,
			ComunicaDireccEmisor ,
			ComunicaFrecuencia ,
			ComunicaComplejidad ,
			ComunicaTipoMetodo ,
			ComunicaTipoMedio ,
			ComunicaGlosarioTerm 
         FROM BIBD_PROY_COMUNICACION order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['ComunicaIde'] = $fila['ComunicaIde'];  
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['ProyCodigoSNIP'] = $fila['ProyCodigoSNIP'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyEstado'] = $fila['ProyEstado'];  
				$elemento['ComunicaNombre'] = $fila['ComunicaNombre'];  
				$elemento['ComunicaFecInicio'] = $fila['ComunicaFecInicio'];  
				$elemento['ComunicaFecTermino'] = $fila['ComunicaFecTermino'];  
				$elemento['ComunicaDireccEmisor'] = $fila['ComunicaDireccEmisor'];  
				$elemento['ComunicaFrecuencia'] = $fila['ComunicaFrecuencia'];  
				$elemento['ComunicaComplejidad'] = $fila['ComunicaComplejidad'];  
				$elemento['ComunicaTipoMetodo'] = $fila['ComunicaTipoMetodo'];  
				$elemento['ComunicaTipoMedio'] = $fila['ComunicaTipoMedio'];  
				$elemento['ComunicaGlosarioTerm'] = $fila['ComunicaGlosarioTerm']; 
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
