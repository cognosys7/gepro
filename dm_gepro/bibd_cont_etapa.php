<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_ETAPA
//  Fecha           : sábado, 27 de julio de 2019 13:05:03
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContIde ,
			ContCodigoUnicoOrden ,
			EtapaIde ,
			EtapaContractual ,
			EtapaComponente ,
			EtapaContratoAbrev ,
			EtapaModoEjecucion ,
			EtapaModoEjecucionAbrev ,
			EtapaEstado ,
			EtapaEstadoAbrev ,
			EtapaSecuencia ,
			EtapaMontoInversion 
         FROM BIBD_CONT_ETAPA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['EtapaContractual'] = $fila['EtapaContractual'];  
				$elemento['EtapaComponente'] = $fila['EtapaComponente'];  
				$elemento['EtapaContratoAbrev'] = $fila['EtapaContratoAbrev'];  
				$elemento['EtapaModoEjecucion'] = $fila['EtapaModoEjecucion'];  
				$elemento['EtapaModoEjecucionAbrev'] = $fila['EtapaModoEjecucionAbrev'];  
				$elemento['EtapaEstado'] = $fila['EtapaEstado'];  
				$elemento['EtapaEstadoAbrev'] = $fila['EtapaEstadoAbrev'];  
				$elemento['EtapaSecuencia'] = $fila['EtapaSecuencia'];  
				$elemento['EtapaMontoInversion'] = $fila['EtapaMontoInversion']; 
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
