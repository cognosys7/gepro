<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Edgar Pisfil Ahumada              
//  Propósito       : BIBD_SEG_AUDITORIA
//  Fecha           : lunes, 30 de setiembre de 2019 17:14:49
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (4)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_SEG_AUDITORIA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			Concepto ,
			UsuarioCrea ,
			PersonaCrea ,
			FechaCrea ,
			FechaHoraCrea ,
			UsuarioModifica ,
			PersonaModifica ,
			FechaModifica ,
			FechaHoraModifica ,
			Estado ,
			ProyIde ,
			ContIde ,
			ContratoIde ,
			ProyNombre ,
			ProyNombreIngles ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			Proyecto ,
			Region ,
			
			SocialFecActualiza ,
			SocialPerActualiza ,
			LeccionFecActualiza ,
			LeccionPerActualiza ,
			ComunicaFecActualiza ,
			ComunicaPerActualiza ,
			
			ContCodigoEntidad ,
			ContNombre ,
			ContCodigoUnicoOrden ,
			Contrato_Orden ,
			ContratoEntidad_Item ,
				
			EtapaHitoFechaModifica, 
			EtapaHitoPersonaModifica,
			EtapaAvanFisicoFechaModifica,
			EtapaAvanFisicoPersonaModifica,
			EtapaValorizacionFechaModifica,
			EtapaValorizacionPersonaModifica,
			
			ContEntregFecActualiza,
			ContEntregPerActualiza,

			ContIntrsaFecActualiza,
			ContIntrsaPerActualiza,

			RiesgoFecActualiza,
			RiesgoPerActualiza,
			
			ContDocumentoFecActualiza,
			ContDocumentoPerActualiza
			
			
         FROM BIBD_SEG_AUDITORIA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['Concepto'] = $fila['Concepto'];  
				$elemento['UsuarioCrea'] = $fila['UsuarioCrea'];  
				$elemento['PersonaCrea'] = $fila['PersonaCrea'];  
				$elemento['FechaCrea'] = $fila['FechaCrea'];  
				$elemento['FechaHoraCrea'] = $fila['FechaHoraCrea'];  
				$elemento['UsuarioModifica'] = $fila['UsuarioModifica'];  
				$elemento['PersonaModifica'] = $fila['PersonaModifica'];  
				$elemento['FechaModifica'] = $fila['FechaModifica'];  
				$elemento['FechaHoraModifica'] = $fila['FechaHoraModifica'];  
				$elemento['Estado'] = $fila['Estado'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContratoIde'] = $fila['ContratoIde'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyNombreIngles'] = $fila['ProyNombreIngles'];  
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['Proyecto'] = $fila['Proyecto'];  
				$elemento['Region'] = $fila['Region']; 

				$elemento['SocialFecActualiza'] = $fila['SocialFecActualiza']; 
				$elemento['SocialPerActualiza'] = $fila['SocialPerActualiza']; 
				$elemento['LeccionFecActualiza'] = $fila['LeccionFecActualiza']; 
				$elemento['LeccionPerActualiza'] = $fila['LeccionPerActualiza']; 
				$elemento['ComunicaFecActualiza'] = $fila['ComunicaFecActualiza']; 
				$elemento['ComunicaPerActualiza'] = $fila['ComunicaPerActualiza']; 
				
				$elemento['ContCodigoEntidad'] = $fila['ContCodigoEntidad'];  
				$elemento['ContNombre'] = $fila['ContNombre'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['Contrato_Orden'] = $fila['Contrato_Orden'];  
				$elemento['ContratoEntidad_Item'] = $fila['ContratoEntidad_Item']; 
				
				$elemento['EtapaHitoFechaModifica'] = $fila['EtapaHitoFechaModifica']; 
				$elemento['EtapaHitoPersonaModifica'] = $fila['EtapaHitoPersonaModifica']; 
				$elemento['EtapaAvanFisicoFechaModifica'] = $fila['EtapaAvanFisicoFechaModifica']; 
				$elemento['EtapaAvanFisicoPersonaModifica'] = $fila['EtapaAvanFisicoPersonaModifica']; 
				$elemento['EtapaValorizacionFechaModifica'] = $fila['EtapaValorizacionFechaModifica']; 
				$elemento['EtapaValorizacionPersonaModifica'] = $fila['EtapaValorizacionPersonaModifica']; 
				
				$elemento['ContEntregFecActualiza'] = $fila['ContEntregFecActualiza']; 
				$elemento['ContEntregPerActualiza'] = $fila['ContEntregPerActualiza']; 
				$elemento['ContIntrsaFecActualiza'] = $fila['ContIntrsaFecActualiza']; 
				$elemento['ContIntrsaPerActualiza'] = $fila['ContIntrsaPerActualiza']; 
				$elemento['RiesgoFecActualiza'] = $fila['RiesgoFecActualiza']; 
				$elemento['RiesgoPerActualiza'] = $fila['RiesgoPerActualiza']; 
				
				$elemento['ContDocumentoFecActualiza'] = $fila['ContDocumentoFecActualiza']; 
				$elemento['ContDocumentoPerActualiza'] = $fila['ContDocumentoPerActualiza']; 
				
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
