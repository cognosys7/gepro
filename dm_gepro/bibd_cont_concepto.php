<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_CONCEPTO
//  Fecha           : s�bado, 27 de julio de 2019 13:19:54
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_CONCEPTO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContConcepIde ,
			ContratoIde ,
			ContCodigoUnicoOrden ,
			ContCodigo ,
			ContCodigoEntidad ,
			ContNombre ,
			ContConcepTipo ,
			ContConcepNumDocu ,
			ContConcepTipDocu ,
			BancoCodInterno ,
			BancoNombre ,
			BancoRuc ,
			BancoComentario ,
			ContConcepMonto ,
			ContConcepFecEmision ,
			ContConcepFecInicio ,
			ContConcepFecTermino ,
			ContConcepObservacion ,
			ContConcepEstado ,
                        
                        ContConcepAlertaDias ,
                        ContConcepAlertaColor ,
                        ContConcepAlertaTitulo ,
                        ContConcepAlertaMensaje

         FROM BIBD_CONT_CONCEPTO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContConcepIde'] = $fila['ContConcepIde'];  
				$elemento['ContratoIde'] = $fila['ContratoIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['ContCodigo'] = $fila['ContCodigo'];  
				$elemento['ContCodigoEntidad'] = $fila['ContCodigoEntidad'];  
				$elemento['ContNombre'] = $fila['ContNombre'];  
				$elemento['ContConcepTipo'] = $fila['ContConcepTipo'];  
				$elemento['ContConcepNumDocu'] = $fila['ContConcepNumDocu'];  
				$elemento['ContConcepTipDocu'] = $fila['ContConcepTipDocu'];  
				$elemento['BancoCodInterno'] = $fila['BancoCodInterno'];  
				$elemento['BancoNombre'] = $fila['BancoNombre'];  
				$elemento['BancoRuc'] = $fila['BancoRuc'];  
				$elemento['BancoComentario'] = $fila['BancoComentario'];  
				$elemento['ContConcepMonto'] = $fila['ContConcepMonto'];  
				$elemento['ContConcepFecEmision'] = $fila['ContConcepFecEmision'];  
				$elemento['ContConcepFecInicio'] = $fila['ContConcepFecInicio'];  
				$elemento['ContConcepFecTermino'] = $fila['ContConcepFecTermino'];  
				$elemento['ContConcepObservacion'] = $fila['ContConcepObservacion'];  
				$elemento['ContConcepEstado'] = $fila['ContConcepEstado']; 
                                
                                $elemento['ContConcepAlertaDias'] = $fila['ContConcepAlertaDias'];  
				$elemento['ContConcepAlertaColor'] = $fila['ContConcepAlertaColor'];  
				$elemento['ContConcepAlertaTitulo'] = $fila['ContConcepAlertaTitulo'];  
				$elemento['ContConcepAlertaMensaje'] = $fila['ContConcepAlertaMensaje']; 
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
