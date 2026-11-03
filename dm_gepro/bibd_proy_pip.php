<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_PIP
//  Fecha           : s�bado, 27 de julio de 2019 12:52:21
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_PIP(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			PIPide ,
			ProyIde ,
			ProyCodigoSPRING ,
			ProyNombre ,
			ProyEstado ,
			PIPCodigoUnico ,
			PIPCodigoSNIP ,
			PIPCodigo ,
			PIPDenominacion ,
			PIPFecRegistro ,
			PIPFecViabilidad ,
			PIPMtoViable ,
			PIPFuncion ,
			PIPPrograma ,
			PIPSubPrograma ,
			PIPNivel ,
			PIPSector ,
			PIPPliego ,
			PIPUnidadEjecutora ,
			PIPResponsableViabilidad ,
			PIPMontoF15 ,
			PIPMontoF16 ,
			PIPCostoActualizado ,
			PIPNumBeneficiarios 
         FROM BIBD_PROY_PIP order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['PIPide'] = $fila['PIPide']; 
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyEstado'] = $fila['ProyEstado'];  
				$elemento['PIPCodigoUnico'] = $fila['PIPCodigoUnico'];  
				$elemento['PIPCodigoSNIP'] = $fila['PIPCodigoSNIP'];  
				$elemento['PIPCodigo'] = $fila['PIPCodigo']; 
				$elemento['PIPDenominacion'] = $fila['PIPDenominacion'];  
				$elemento['PIPFecRegistro'] = $fila['PIPFecRegistro'];  
				$elemento['PIPFecViabilidad'] = $fila['PIPFecViabilidad'];  
				$elemento['PIPMtoViable'] = $fila['PIPMtoViable'];  
				$elemento['PIPFuncion'] = $fila['PIPFuncion'];  
				$elemento['PIPPrograma'] = $fila['PIPPrograma'];  
				$elemento['PIPSubPrograma'] = $fila['PIPSubPrograma'];  
				$elemento['PIPNivel'] = $fila['PIPNivel'];  
				$elemento['PIPSector'] = $fila['PIPSector'];  
				$elemento['PIPPliego'] = $fila['PIPPliego'];  
				$elemento['PIPUnidadEjecutora'] = $fila['PIPUnidadEjecutora'];  
				$elemento['PIPResponsableViabilidad'] = $fila['PIPResponsableViabilidad'];  
				$elemento['PIPMontoF15'] = $fila['PIPMontoF15'];  
				$elemento['PIPMontoF16'] = $fila['PIPMontoF16'];  
				$elemento['PIPCostoActualizado'] = $fila['PIPCostoActualizado'];  
				$elemento['PIPNumBeneficiarios'] = $fila['PIPNumBeneficiarios']; 
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
