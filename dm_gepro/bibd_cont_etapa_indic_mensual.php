<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_ETAPA_INDIC_MENSUAL
//  Fecha           : martes, 10 de setiembre de 2019 18:17:32
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_INDIC_MENSUAL(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			
			ProyIde ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			ProyCodigoSNIP ,
			ContCodigoUnicoOrden,
			
			EtapaIndicadorAnioIde ,
			EtapaIndicadorMesIde ,
			ContIde ,
			EtapaIde ,
			EtapaPlan ,
			EtapaPlanIde ,
			EtapaPlanInicio ,
			EtapaPlanTermino ,
			EtapaIndicadorNombre ,
			EtapaIndicadorUnidad ,
			EtapaIndicadorAnio ,
			EtapaIndicadorAnioValor ,
			EtapaIndicadorMesCod ,
			EtapaIndicadorMesNombre ,
			EtapaIndicadorMes ,
			EtapaIndicadorMesValor ,
			EtapaIndicadorTipo ,
			EtapaIndicadorPrioridad ,
			EtapaIndicadorPeriProg 
         FROM BIBD_CONT_ETAPA_INDIC_MENSUAL order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
			  
				$elemento['ProyIde'] = $fila['ProyIde'];
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['ProyCodigoSNIP'] = $fila['ProyCodigoSNIP'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
			  
				$elemento['EtapaIndicadorAnioIde'] = $fila['EtapaIndicadorAnioIde'];  
				$elemento['EtapaIndicadorMesIde'] = $fila['EtapaIndicadorMesIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['EtapaPlan'] = $fila['EtapaPlan'];  
				$elemento['EtapaPlanIde'] = $fila['EtapaPlanIde'];  
				$elemento['EtapaPlanInicio'] = $fila['EtapaPlanInicio'];  
				$elemento['EtapaPlanTermino'] = $fila['EtapaPlanTermino'];  
				$elemento['EtapaIndicadorNombre'] = $fila['EtapaIndicadorNombre'];  
				$elemento['EtapaIndicadorUnidad'] = $fila['EtapaIndicadorUnidad'];  
				$elemento['EtapaIndicadorAnio'] = $fila['EtapaIndicadorAnio'];  
				$elemento['EtapaIndicadorAnioValor'] = $fila['EtapaIndicadorAnioValor'];  
				$elemento['EtapaIndicadorMesCod'] = $fila['EtapaIndicadorMesCod'];  
				$elemento['EtapaIndicadorMesNombre'] = $fila['EtapaIndicadorMesNombre'];  
				$elemento['EtapaIndicadorMes'] = $fila['EtapaIndicadorMes'];  
				$elemento['EtapaIndicadorMesValor'] = $fila['EtapaIndicadorMesValor'];  
				$elemento['EtapaIndicadorTipo'] = $fila['EtapaIndicadorTipo'];  
				$elemento['EtapaIndicadorPrioridad'] = $fila['EtapaIndicadorPrioridad'];  
				$elemento['EtapaIndicadorPeriProg'] = $fila['EtapaIndicadorPeriProg']; 
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
