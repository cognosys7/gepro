<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_PROY_COSTO_COMPONENTE
//  Fecha           : viernes, 9 de julio de 2021 12:50:20
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_COSTO_COMPONENTE(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			CostoCompIde ,
			ProyIde ,
			AvanceFisico ,
			FechaCambio ,
			CtoPlanCierre ,
			CtoPerfil ,
			CtoExpediente ,
			CtoEjecucionObra ,
			CtoSupervision ,
			CtoGestionProyecto ,
			CtoCapacitacion ,
			CtoPostCierre ,
			ComponenteNombre ,
			ComponenteIde ,
			ComponenteDescAct ,
			CostoCompEstado 
         FROM BIBD_PROY_COSTO_COMPONENTE order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['CostoCompIde'] = $fila['CostoCompIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['AvanceFisico'] = $fila['AvanceFisico'];  
				$elemento['FechaCambio'] = $fila['FechaCambio'];  
				$elemento['CtoPlanCierre'] = $fila['CtoPlanCierre'];  
				$elemento['CtoPerfil'] = $fila['CtoPerfil'];  
				$elemento['CtoExpediente'] = $fila['CtoExpediente'];  
				$elemento['CtoEjecucionObra'] = $fila['CtoEjecucionObra'];  
				$elemento['CtoSupervision'] = $fila['CtoSupervision'];  
				$elemento['CtoGestionProyecto'] = $fila['CtoGestionProyecto'];  
				$elemento['CtoCapacitacion'] = $fila['CtoCapacitacion'];  
				$elemento['CtoPostCierre'] = $fila['CtoPostCierre'];  
				$elemento['ComponenteNombre'] = $fila['ComponenteNombre'];  
				$elemento['ComponenteIde'] = $fila['ComponenteIde'];  
				$elemento['ComponenteDescAct'] = $fila['ComponenteDescAct'];  
				$elemento['CostoCompEstado'] = $fila['CostoCompEstado']; 
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
