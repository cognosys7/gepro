<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_ACCION_CORRECTIVA
//  Fecha           : lunes, 12 de julio de 2021 21:41:12
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRINGEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_ACCION_CORRECTIVA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			AccionIde ,
			ProyIde ,
			AccionFecha ,
			DesviacionAutomatica ,
			AccionCorrectiva ,
			AccionEstado,
			T105.DES_ITEM AS Componente
         FROM BIBD_PROY_ACCION_CORRECTIVA AS V
         LEFT JOIN dbo.PROY_ACCION_CORRECTIVA AS T ON T.IDE_PROY_ACCION_CORRECTIVA = V.AccionIde
         LEFT JOIN dbo.GEN_TABLAS AS T105 ON T105.COD_TABLA = 105 AND T105.COD_ITEM = T.TIP_COMPONENTE
         order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['AccionIde'] = $fila['AccionIde'];  
				$elemento['ProyIde'] = $fila['ProyIde'];  
				$elemento['AccionFecha'] = $fila['AccionFecha'];  
				$elemento['DesviacionAutomatica'] = $fila['DesviacionAutomatica'];  
				$elemento['AccionCorrectiva'] = $fila['AccionCorrectiva'];  
				$elemento['AccionEstado'] = $fila['AccionEstado']; 
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
