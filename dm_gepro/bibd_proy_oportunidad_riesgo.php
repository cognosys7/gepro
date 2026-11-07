<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_OPORTUNIDAD_RIESGO
//  Fecha           : viernes, 9 de julio de 2021 12:49:37
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_OPORTUNIDAD_RIESGO(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			RiesgoIde ,
			ProyIde ,
			RiesgoFecha ,
			RiesgoDesc ,
			ProbabilidadValor ,
			ProbabilidadDesc ,
			ImpactoValor ,
			ImpactoDesc ,
			ValoracionValor ,
			ValoracionRango ,
			ValoracionDesc ,
			AccionProcesoDesc ,
			RiesgoEstado,
			T105.DES_ITEM AS Componente
         FROM BIBD_PROY_OPORTUNIDAD_RIESGO AS V
         LEFT JOIN dbo.PROY_OPORTUNIDAD_RIESGO AS T ON T.IDE_PROY_OPORTUNIDAD = V.RiesgoIde
         LEFT JOIN dbo.GEN_TABLAS AS T105 ON T105.COD_TABLA = 105 AND T105.COD_ITEM = T.TIP_COMPONENTE
         order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['RiesgoIde'] = $fila['RiesgoIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['RiesgoFecha'] = $fila['RiesgoFecha'];  
				$elemento['RiesgoDesc'] = $fila['RiesgoDesc'];  
				$elemento['ProbabilidadValor'] = $fila['ProbabilidadValor'];  
				$elemento['ProbabilidadDesc'] = $fila['ProbabilidadDesc'];  
				$elemento['ImpactoValor'] = $fila['ImpactoValor'];  
				$elemento['ImpactoDesc'] = $fila['ImpactoDesc'];  
				$elemento['ValoracionValor'] = $fila['ValoracionValor'];  
				$elemento['ValoracionRango'] = $fila['ValoracionRango'];  
				$elemento['ValoracionDesc'] = $fila['ValoracionDesc'];  
				$elemento['AccionProcesoDesc'] = $fila['AccionProcesoDesc'];  
				$elemento['RiesgoEstado'] = $fila['RiesgoEstado']; 
				$elemento['Componente'] = $fila['Componente']; 
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
