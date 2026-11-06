<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROYECTO
//  Fecha           : s�bado, 27 de julio de 2019 12:51:19
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROYECTO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ProyIde ,
			PortafolioCodigo ,
			Portafolio ,
			PortafolioGrupo ,
			Programa ,
			CentroCostoCodigo ,
			CentroCosto ,
			SedeEjecutoraRUC ,
			SedeEjecutora ,
			ProyFaseComponente ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			ProyCodigoSNIP ,
			ProyNombre ,
			ProyNombreCorta ,
			ProyNombreIngles ,
			ProyTipoMoneda ,
			ProyMtoAprobadoLoc ,
			ProyMtoAprobadoExt ,
			ProyFechaAprobacion ,
			ProyFecInicio ,
			ProyFecTermino ,
			ProyUbicacion ,
			ProyUnidadFormuladora ,
			ProyViabilidad ,
			ProyAreaIntervencion ,
			ProyCuencaHidrografica ,
			ProyNumPAMS ,
			ProyStakeholder ,
			ProyEstatus ,
			ProyAccionGestion ,
			ProyAccionGestionSoc ,
			ProyAccionCorrectiva ,
			ProyOportunidadMejora ,
			ProyNumBeneficiarios ,
			ProyTipoProyecto ,
			ProyEstado ,
			
			ProyNombreBuscar ,
			ProyPrincipal
			
         FROM BIBD_PROYECTO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['PortafolioCodigo'] = $fila['PortafolioCodigo'];  
				$elemento['Portafolio'] = $fila['Portafolio'];  
				$elemento['PortafolioGrupo'] = $fila['PortafolioGrupo'];  
				$elemento['Programa'] = $fila['Programa'];  
				$elemento['CentroCostoCodigo'] = $fila['CentroCostoCodigo'];  
				$elemento['CentroCosto'] = $fila['CentroCosto'];  
				$elemento['SedeEjecutoraRUC'] = $fila['SedeEjecutoraRUC'];  
				$elemento['SedeEjecutora'] = $fila['SedeEjecutora'];  
				$elemento['ProyFaseComponente'] = $fila['ProyFaseComponente'];  
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['ProyCodigoSNIP'] = $fila['ProyCodigoSNIP'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyNombreCorta'] = $fila['ProyNombreCorta'];  
				$elemento['ProyNombreIngles'] = $fila['ProyNombreIngles'];  
				$elemento['ProyTipoMoneda'] = $fila['ProyTipoMoneda'];  
				$elemento['ProyMtoAprobadoLoc'] = $fila['ProyMtoAprobadoLoc'];  
				$elemento['ProyMtoAprobadoExt'] = $fila['ProyMtoAprobadoExt'];  
				$elemento['ProyFechaAprobacion'] = $fila['ProyFechaAprobacion'];  
				$elemento['ProyFecInicio'] = $fila['ProyFecInicio'];  
				$elemento['ProyFecTermino'] = $fila['ProyFecTermino'];  
				$elemento['ProyUbicacion'] = $fila['ProyUbicacion'];  
				$elemento['ProyUnidadFormuladora'] = $fila['ProyUnidadFormuladora'];  
				$elemento['ProyViabilidad'] = $fila['ProyViabilidad'];  
				$elemento['ProyAreaIntervencion'] = $fila['ProyAreaIntervencion'];  
				$elemento['ProyCuencaHidrografica'] = $fila['ProyCuencaHidrografica'];  
				$elemento['ProyNumPAMS'] = $fila['ProyNumPAMS'];  
				$elemento['ProyStakeholder'] = $fila['ProyStakeholder'];  
				$elemento['ProyEstatus'] = $fila['ProyEstatus'];  
				$elemento['ProyAccionGestion'] = $fila['ProyAccionGestion'];  
				$elemento['ProyAccionGestionSoc'] = $fila['ProyAccionGestionSoc'];  
				$elemento['ProyAccionCorrectiva'] = $fila['ProyAccionCorrectiva'];  
				$elemento['ProyOportunidadMejora'] = $fila['ProyOportunidadMejora'];  
				$elemento['ProyNumBeneficiarios'] = $fila['ProyNumBeneficiarios'];  
				$elemento['ProyTipoProyecto'] = $fila['ProyTipoProyecto'];  
				$elemento['ProyEstado'] = $fila['ProyEstado'];

				$elemento['ProyNombreBuscar'] = $fila['ProyNombreBuscar'];
				$elemento['ProyPrincipal'] = $fila['ProyPrincipal'];	
				
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
