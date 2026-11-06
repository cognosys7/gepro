<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_ETAPA_SEGUIMIENTO
//  Fecha           : s�bado, 27 de julio de 2019 13:07:13
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_SEGUIMIENTO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			EtapaSeguimIde ,
			ContIde ,
			EtapaIde ,
			EtapaSeguimFecha ,
			EtapaSeguimDescrip ,
			EtapaSeguimEstado 
                        
         FROM BIBD_CONT_ETAPA_SEGUIMIENTO order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['EtapaSeguimIde'] = $fila['EtapaSeguimIde'];
				$elemento['ContIde'] = $fila['ContIde'];
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['EtapaSeguimFecha'] = $fila['EtapaSeguimFecha'];  
				$elemento['EtapaSeguimDescrip'] = $fila['EtapaSeguimDescrip'];  
				$elemento['EtapaSeguimEstado'] = $fila['EtapaSeguimEstado'];  
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
