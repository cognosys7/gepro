<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONTRATO
//  Fecha           : s�bado, 27 de julio de 2019 13:03:50
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONTRATO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContratoIde ,
			ProyIde ,
			ContIde ,
			AdquisiProceso ,
			ContCodigoUnicoOrden ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			ProyCodigoSNIP ,
			ProyNombre ,
			ProyEstado ,
			ContFaseComponente ,
			ContTipoOrden ,
			ContCodigoOrden ,
			ContCodigoOrdenItem ,
			ContCodigo ,
			ContCodigoEntidad ,
			ContNombre ,
			ContGeneNombreCorta ,
			ContModalidadGestion ,
			ContGeneAlcance ,
			ContGeneUbicacion ,
			ContGeneEstado ,
			ContTipoSPRING ,
			ContFechaSuscribe ,
			ContFechaInicio ,
			ContFechaTermino ,
			ContFechaCierre ,
			ContMontoImponible ,
			ContMontoImpuesto ,
			ContMontoTotal ,
			ContEstado ,
			ProveedorCodigo ,
			ProveedorRuc ,
			ProveedorNombre ,
			ProveedorDireccion ,
			ProveedorComentario ,
			CodResponsable ,
			Responsable ,
			Responsable_Base ,
			Responsable_Tipo ,
			AdquisicionCodPAC ,
			AdquisicionNumProEsp ,
			AdquisicionObjeto 
         FROM BIBD_CONTRATO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContratoIde'] = $fila['ContratoIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['AdquisiProceso'] = $fila['AdquisiProceso'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['ProyCodigoSNIP'] = $fila['ProyCodigoSNIP'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyEstado'] = $fila['ProyEstado'];  
				$elemento['ContFaseComponente'] = $fila['ContFaseComponente'];  
				$elemento['ContTipoOrden'] = $fila['ContTipoOrden'];  
				$elemento['ContCodigoOrden'] = $fila['ContCodigoOrden'];  
				$elemento['ContCodigoOrdenItem'] = $fila['ContCodigoOrdenItem'];  
				$elemento['ContCodigo'] = $fila['ContCodigo'];  
				$elemento['ContCodigoEntidad'] = $fila['ContCodigoEntidad'];  

				$elemento['ContNombre'] = $fila['ContNombre'];  
				$elemento['ContGeneNombreCorta'] = $fila['ContGeneNombreCorta'];  
				$elemento['ContModalidadGestion'] = $fila['ContModalidadGestion'];  
				$elemento['ContGeneAlcance'] = $fila['ContGeneAlcance'];  
				$elemento['ContGeneUbicacion'] = $fila['ContGeneUbicacion'];  
				$elemento['ContGeneEstado'] = $fila['ContGeneEstado'];  
				$elemento['ContTipoSPRING'] = $fila['ContTipoSPRING'];  
				$elemento['ContFechaSuscribe'] = $fila['ContFechaSuscribe'];  
				$elemento['ContFechaInicio'] = $fila['ContFechaInicio'];  
				$elemento['ContFechaTermino'] = $fila['ContFechaTermino'];  
				$elemento['ContFechaCierre'] = $fila['ContFechaCierre'];  
				$elemento['ContMontoImponible'] = $fila['ContMontoImponible'];  
				$elemento['ContMontoImpuesto'] = $fila['ContMontoImpuesto'];  
				$elemento['ContMontoTotal'] = $fila['ContMontoTotal'];  

				$elemento['ContEstado'] = $fila['ContEstado'];  
				$elemento['ProveedorCodigo'] = $fila['ProveedorCodigo'];  
				$elemento['ProveedorRuc'] = $fila['ProveedorRuc'];  
				$elemento['ProveedorNombre'] = $fila['ProveedorNombre'];  
				$elemento['ProveedorDireccion'] = $fila['ProveedorDireccion'];  
				$elemento['ProveedorComentario'] = $fila['ProveedorComentario'];  
				$elemento['CodResponsable'] = $fila['CodResponsable'];  
				$elemento['Responsable'] = $fila['Responsable'];  
				$elemento['Responsable_Base'] = $fila['Responsable_Base'];  
				$elemento['Responsable_Tipo'] = $fila['Responsable_Tipo'];  
				$elemento['AdquisicionCodPAC'] = $fila['AdquisicionCodPAC'];  
				$elemento['AdquisicionNumProEsp'] = $fila['AdquisicionNumProEsp'];  
				$elemento['AdquisicionObjeto'] = $fila['AdquisicionObjeto']; 
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
