<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_ETAPA_INDIC_MENSUAL
//  Fecha           : sábado, 27 de julio de 2019 13:05:55
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_INDIC_MENSUAL(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			EtapaIndicadorAnioIde ,
			EtapaIndicadorMesIde ,
			ContIde ,
			EtapaIde ,
			EtapaPlan ,
			EtapaPlanInicio ,
			EtapaPlanTermino ,
			EtapaIndicadorNombre ,
			EtapaIndicadorUnidad ,
			EtapaIndicadorAnio ,
			EtapaIndicadorAnioValor ,
			EtapaIndicadorMesNum ,
			EtapaIndicadorMes ,
			EtapaIndicadorMesValor ,
			EtapaIndicadorTipo ,
			EtapaIndicadorPrioridad ,
			EtapaIndicadorPeriProg ,
			EtapaIndicadorPeriEjec 
         FROM BIBD_CONT_ETAPA_INDIC_MENSUAL order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['EtapaIndicadorAnioIde'] = $fila['EtapaIndicadorAnioIde'];
				$elemento['EtapaIndicadorMesIde'] = $fila['EtapaIndicadorMesIde'];
				$elemento['ContIde'] = $fila['ContIde'];
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['EtapaPlan'] = $fila['EtapaPlan'];  
				$elemento['EtapaPlanInicio'] = $fila['EtapaPlanInicio'];  
				$elemento['EtapaPlanTermino'] = $fila['EtapaPlanTermino'];  
				$elemento['EtapaIndicadorNombre'] = $fila['EtapaIndicadorNombre'];  
				$elemento['EtapaIndicadorUnidad'] = $fila['EtapaIndicadorUnidad'];  
				$elemento['EtapaIndicadorAnio'] = $fila['EtapaIndicadorAnio'];  
				$elemento['EtapaIndicadorAnioValor'] = $fila['EtapaIndicadorAnioValor'];  
				$elemento['EtapaIndicadorMesNum'] = $fila['EtapaIndicadorMesNum'];  
				$elemento['EtapaIndicadorMes'] = $fila['EtapaIndicadorMes'];
				$elemento['EtapaIndicadorMesValor'] = $fila['EtapaIndicadorMesValor'];  
				$elemento['EtapaIndicadorTipo'] = $fila['EtapaIndicadorTipo'];  
				$elemento['EtapaIndicadorPrioridad'] = $fila['EtapaIndicadorPrioridad'];  
				$elemento['EtapaIndicadorPeriProg'] = $fila['EtapaIndicadorPeriProg'];  
				$elemento['EtapaIndicadorPeriEjec'] = $fila['EtapaIndicadorPeriEjec']; 
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
