<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_LECCION_APRENDIDA
//  Fecha           : s�bado, 27 de julio de 2019 12:54:40
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_LECCION_APRENDIDA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			LeccionIde ,
			ProyIde ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			ProyCodigoSNIP ,
			ProyNombre ,
			ProyEstado ,
			LeccionFaseComponente ,
			LeccionCodigo ,
			LeccionTipo ,
                        LeccionTipoRiesgo ,
                        LeccionRiesgo ,
			LeccionCausa ,
			LeccionTipoImpacto ,
			LeccionEfecto ,
			LeccionRespuestaSugRea ,
			LeccionFecha ,
			LeccionEstado 
         FROM BIBD_PROY_LECCION_APRENDIDA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['LeccionIde'] = $fila['LeccionIde'];
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['ProyCodigoSNIP'] = $fila['ProyCodigoSNIP'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyEstado'] = $fila['ProyEstado'];  
				$elemento['LeccionFaseComponente'] = $fila['LeccionFaseComponente'];  
				$elemento['LeccionCodigo'] = $fila['LeccionCodigo'];  
				$elemento['LeccionTipo'] = $fila['LeccionTipo'];
                                $elemento['LeccionTipoRiesgo'] = $fila['LeccionTipoRiesgo']; 
                                $elemento['LeccionRiesgo'] = $fila['LeccionRiesgo'];
				$elemento['LeccionCausa'] = $fila['LeccionCausa'];  
				$elemento['LeccionTipoImpacto'] = $fila['LeccionTipoImpacto'];  
				$elemento['LeccionEfecto'] = $fila['LeccionEfecto'];  
				$elemento['LeccionRespuestaSugRea'] = $fila['LeccionRespuestaSugRea'];  
				$elemento['LeccionFecha'] = $fila['LeccionFecha'];  
				$elemento['LeccionEstado'] = $fila['LeccionEstado']; 
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
