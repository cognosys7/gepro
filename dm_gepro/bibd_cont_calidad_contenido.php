<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_CALIDAD_CONTENIDO
//  Fecha           : sábado, 27 de julio de 2019 13:16:11
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_CALIDAD_CONTENIDO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContenidoIde ,
			ContEntregIde ,
			ContEntregCodInforme ,
			ContEntregFecha ,
			ContEntregNumObserv ,
			ContContenidoFaseComp ,
			ContenidoNombre ,
			ContenidoAbrev ,
			ContenidoNivel ,
			ContenidoNumOrden ,
			ContenidoObserva ,
			ContenidoEstado 
         FROM BIBD_CONT_CALIDAD_CONTENIDO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContenidoIde'] = $fila['ContenidoIde']; 
				$elemento['ContEntregIde'] = $fila['ContEntregIde']; 
				$elemento['ContEntregCodInforme'] = $fila['ContEntregCodInforme'];  
				$elemento['ContEntregFecha'] = $fila['ContEntregFecha'];  
				$elemento['ContEntregNumObserv'] = $fila['ContEntregNumObserv'];  
				$elemento['ContContenidoFaseComp'] = $fila['ContContenidoFaseComp'];  
				$elemento['ContenidoNombre'] = $fila['ContenidoNombre'];  
				$elemento['ContenidoAbrev'] = $fila['ContenidoAbrev'];  
				$elemento['ContenidoNivel'] = $fila['ContenidoNivel'];  
				$elemento['ContenidoNumOrden'] = $fila['ContenidoNumOrden'];  
				$elemento['ContenidoObserva'] = $fila['ContenidoObserva'];  
				$elemento['ContenidoEstado'] = $fila['ContenidoEstado']; 
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
