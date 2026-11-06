<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_CALIDAD_ENTREGABLE
//  Fecha           : s�bado, 27 de julio de 2019 13:15:25
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_CALIDAD_ENTREGABLE(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContEntregIde ,
			ContIde ,
			ContEntregFaseComp ,
			EntregableNombre ,
			EntregableAbrev ,
			EntregableNivel ,
			EntregableNumOrden ,
			ContEntregNumRevision ,
			ContEntregCodInforme ,
			ContEntregFecInforme ,
			ContEntregComentario ,
			ContEntregNumObserv ,
			ContEntregEstado ,
			ContEntregAdminisTipo ,
			ContEntregAdminisCod ,
			ContEntregAdminisNombre ,
			ContEntregValidaTipo ,
			ContEntregValidaCod ,
			ContEntregValidaNombre ,
			ContEntregApruebaTipo ,
			ContEntregApruebaCod ,
			ContEntregApruebaNombre 
         FROM BIBD_CONT_CALIDAD_ENTREGABLE order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContEntregIde'] = $fila['ContEntregIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContEntregFaseComp'] = $fila['ContEntregFaseComp'];  
				$elemento['EntregableNombre'] = $fila['EntregableNombre'];  
				$elemento['EntregableAbrev'] = $fila['EntregableAbrev'];  
				$elemento['EntregableNivel'] = $fila['EntregableNivel'];  
				$elemento['EntregableNumOrden'] = $fila['EntregableNumOrden'];  
				$elemento['ContEntregNumRevision'] = $fila['ContEntregNumRevision'];  
				$elemento['ContEntregCodInforme'] = $fila['ContEntregCodInforme'];  
				$elemento['ContEntregFecInforme'] = $fila['ContEntregFecInforme'];  
				$elemento['ContEntregComentario'] = $fila['ContEntregComentario'];  
				$elemento['ContEntregNumObserv'] = $fila['ContEntregNumObserv'];  
				$elemento['ContEntregEstado'] = $fila['ContEntregEstado'];  
				$elemento['ContEntregAdminisTipo'] = $fila['ContEntregAdminisTipo'];  
				$elemento['ContEntregAdminisCod'] = $fila['ContEntregAdminisCod'];  
				$elemento['ContEntregAdminisNombre'] = $fila['ContEntregAdminisNombre'];  
				$elemento['ContEntregValidaTipo'] = $fila['ContEntregValidaTipo'];  
				$elemento['ContEntregValidaCod'] = $fila['ContEntregValidaCod'];  
				$elemento['ContEntregValidaNombre'] = $fila['ContEntregValidaNombre'];  
				$elemento['ContEntregApruebaTipo'] = $fila['ContEntregApruebaTipo'];  
				$elemento['ContEntregApruebaCod'] = $fila['ContEntregApruebaCod'];  
				$elemento['ContEntregApruebaNombre'] = $fila['ContEntregApruebaNombre']; 
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
