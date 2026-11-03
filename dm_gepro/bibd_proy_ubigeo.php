<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_UBIGEO
//  Fecha           : s�bado, 27 de julio de 2019 12:52:39
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_UBIGEO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ProyUBIGEOide ,
			ProyIde ,
			ProyCodigoSPRING ,
			ProyCodigoUnico ,
			ProyCodigoSNIP ,
			ProyNombre ,
			ProyEstado ,
			ProyDepartamento ,
			ProyProvincia ,
			ProyDistrito ,
			ProyUBIGEO ,
			ProyUBIGEOlongitud ,
			ProyUBIGEOlatitud ,
			ProyUBIGEOEstado 
         FROM BIBD_PROY_UBIGEO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ProyUBIGEOide'] = $fila['ProyUBIGEOide']; 
				$elemento['ProyIde'] = $fila['ProyIde']; 
				$elemento['ProyCodigoSPRING'] = $fila['ProyCodigoSPRING'];  
				$elemento['ProyCodigoUnico'] = $fila['ProyCodigoUnico'];  
				$elemento['ProyCodigoSNIP'] = $fila['ProyCodigoSNIP'];  
				$elemento['ProyNombre'] = $fila['ProyNombre'];  
				$elemento['ProyEstado'] = $fila['ProyEstado'];  
				$elemento['ProyDepartamento'] = $fila['ProyDepartamento'];  
				$elemento['ProyProvincia'] = $fila['ProyProvincia'];  
				$elemento['ProyDistrito'] = $fila['ProyDistrito'];  
				$elemento['ProyUBIGEO'] = $fila['ProyUBIGEO'];  
				$elemento['ProyUBIGEOlongitud'] = $fila['ProyUBIGEOlongitud'];  
				$elemento['ProyUBIGEOlatitud'] = $fila['ProyUBIGEOlatitud'];  
				$elemento['ProyUBIGEOEstado'] = $fila['ProyUBIGEOEstado']; 
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
