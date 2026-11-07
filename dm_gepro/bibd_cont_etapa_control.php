<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -             
//  Propósito       : BIBD_CONT_ETAPA_CONTROL
//  Fecha           : sábado, 27 de julio de 2019 13:06:29
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_CONTROL(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			CtlDetIde ,
			CtlIde ,
			EtapaIde ,
			CtlTipoPlan ,
			CtlConceptoPlan ,
			CtlEstado ,
			CtlDetAnio ,
			CtlDetMes ,
			CtlDetConceptoPago ,
			CtlDetPorcentajeAvance ,
			CtlDetMontoBruto ,
			CtlDetReajuste ,
			CtlDetAmortAdelantoDirecto ,
			CtlDetAmortAdelantoMaterial ,
			CtlDetAmortizacion ,
			CtlDetSaldoSinIGV ,
			CtlDetDeductivoAdelantoDirecto ,
			CtlDetDeductivoAdelantoMaterial ,
			CtlDetMontoImponible ,
			CtlDetPorcentajeIGV ,
			CtlDetMontoIGV ,
			CtlDetMontoNeto ,
			CtlDetPenalidad ,
			CtlDetRetencion ,
			CtlDetMontoPago ,
			CtlDetEstado 
         FROM BIBD_CONT_ETAPA_CONTROL order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['CtlDetIde'] = $fila['CtlDetIde'];  
				$elemento['CtlIde'] = $fila['CtlIde'];  
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['CtlTipoPlan'] = $fila['CtlTipoPlan'];  
				$elemento['CtlConceptoPlan'] = $fila['CtlConceptoPlan'];  
				$elemento['CtlEstado'] = $fila['CtlEstado'];  
				$elemento['CtlDetAnio'] = $fila['CtlDetAnio'];  
				$elemento['CtlDetMes'] = $fila['CtlDetMes'];  
				$elemento['CtlDetConceptoPago'] = $fila['CtlDetConceptoPago'];  
				$elemento['CtlDetPorcentajeAvance'] = $fila['CtlDetPorcentajeAvance'];  
				$elemento['CtlDetMontoBruto'] = $fila['CtlDetMontoBruto'];  
				$elemento['CtlDetReajuste'] = $fila['CtlDetReajuste'];  
				$elemento['CtlDetAmortAdelantoDirecto'] = $fila['CtlDetAmortAdelantoDirecto'];  
				$elemento['CtlDetAmortAdelantoMaterial'] = $fila['CtlDetAmortAdelantoMaterial'];  
				$elemento['CtlDetAmortizacion'] = $fila['CtlDetAmortizacion'];  
				$elemento['CtlDetSaldoSinIGV'] = $fila['CtlDetSaldoSinIGV'];  
				$elemento['CtlDetDeductivoAdelantoDirecto'] = $fila['CtlDetDeductivoAdelantoDirecto'];  
				$elemento['CtlDetDeductivoAdelantoMaterial'] = $fila['CtlDetDeductivoAdelantoMaterial'];  
				$elemento['CtlDetMontoImponible'] = $fila['CtlDetMontoImponible'];  
				$elemento['CtlDetPorcentajeIGV'] = $fila['CtlDetPorcentajeIGV'];  
				$elemento['CtlDetMontoIGV'] = $fila['CtlDetMontoIGV'];  
				$elemento['CtlDetMontoNeto'] = $fila['CtlDetMontoNeto'];  
				$elemento['CtlDetPenalidad'] = $fila['CtlDetPenalidad'];  
				$elemento['CtlDetRetencion'] = $fila['CtlDetRetencion'];  
				$elemento['CtlDetMontoPago'] = $fila['CtlDetMontoPago'];  
				$elemento['CtlDetEstado'] = $fila['CtlDetEstado']; 
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
