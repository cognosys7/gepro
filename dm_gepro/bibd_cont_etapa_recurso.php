<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_ETAPA_RECURSO
//  Fecha           : sábado, 27 de julio de 2019 13:06:29
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_RECURSO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			EtapaRecursoIde ,
			ContIde ,
			EtapaIde ,
			EtapaRecursoCodigo ,
			EtapaRecursoNombre ,
			EtapaRecursoTipo ,
			EtapaRecursoRol ,
			EtapaRecursoSede,
			EtapaRecursoSedeRUC ,
			EtapaRecursoFase ,
			EtapaRecursoCiclo ,
			EtapaRecursoEstado 
         FROM BIBD_CONT_ETAPA_RECURSO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['EtapaRecursoIde'] = $fila['EtapaRecursoIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['EtapaRecursoCodigo'] = $fila['EtapaRecursoCodigo'];  
				$elemento['EtapaRecursoNombre'] = $fila['EtapaRecursoNombre'];  
				$elemento['EtapaRecursoTipo'] = $fila['EtapaRecursoTipo'];  
				$elemento['EtapaRecursoRol'] = $fila['EtapaRecursoRol']; 
				$elemento['EtapaRecursoSede'] = $fila['EtapaRecursoSede']; 
				$elemento['EtapaRecursoSedeRUC'] = $fila['EtapaRecursoSedeRUC']; 
				$elemento['EtapaRecursoFase'] = $fila['EtapaRecursoFase'];  
				$elemento['EtapaRecursoCiclo'] = $fila['EtapaRecursoCiclo'];  
				$elemento['EtapaRecursoEstado'] = $fila['EtapaRecursoEstado']; 
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
