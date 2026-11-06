<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_DOCUMENTACION
//  Fecha           : s�bado, 27 de julio de 2019 13:21:03
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_DOCUMENTACION(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContDocumentoIde ,
			ContIde ,
			ContCodigoUnicoOrden ,
			MatrizConocimArea ,
			MatrizGrupoProceso ,
			MatrizConocimNombre ,
			MatrizConocimAbrev ,
			MatrizConocimOrden ,
			ContDocumentoFecha ,
			ContDocumentoNombre ,
			ContDocumentoEstado 
         FROM BIBD_CONT_DOCUMENTACION order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContDocumentoIde'] = $fila['ContDocumentoIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['MatrizConocimArea'] = $fila['MatrizConocimArea'];  
				$elemento['MatrizGrupoProceso'] = $fila['MatrizGrupoProceso'];  
				$elemento['MatrizConocimNombre'] = $fila['MatrizConocimNombre'];  
				$elemento['MatrizConocimAbrev'] = $fila['MatrizConocimAbrev'];  
				$elemento['MatrizConocimOrden'] = $fila['MatrizConocimOrden'];  
				$elemento['ContDocumentoFecha'] = $fila['ContDocumentoFecha'];  
				$elemento['ContDocumentoNombre'] = $fila['ContDocumentoNombre'];  
				$elemento['ContDocumentoEstado'] = $fila['ContDocumentoEstado']; 
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
