<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACIÓN DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Propósito       : BIBD_CONT_ETAPA_ACTIVIDAD
//  Fecha           : lunes, 9 de setiembre de 2019 20:23:47
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (3)_edga_v1-01Etiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_ETAPA_ACTIVIDAD(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContIde ,
			ContCodigoUnicoOrden ,
			EtapaIde ,
			EtapaHitoActividadIde ,
			EtapaHitoActividad ,
			EtapaHitoActividadOrd ,
			EtapaHitoAbrev ,
			EtapaHitoJerarquia ,
			EtapaHitoJerarqNivel ,
			EtapaHitoPLANIFIde ,
			EtapaHitoPLANIFI ,
			EtapaHitoEJECUTide ,
			EtapaHitoEJECUT ,
			EtapaHitoEJECUTCalertaDias ,
			EtapaHitoREPROGide ,
			EtapaHitoREPROG ,
			EtapaHitoREPROGalertaDias ,
			ContConcepAlertaColor ,
			ContConcepAlertaTitulo ,
			ContConcepAlertaMensaje 
         FROM BIBD_CONT_ETAPA_ACTIVIDAD order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				$elemento['EtapaIde'] = $fila['EtapaIde'];  
				$elemento['EtapaHitoActividadIde'] = $fila['EtapaHitoActividadIde'];  
				$elemento['EtapaHitoActividad'] = $fila['EtapaHitoActividad'];  
				$elemento['EtapaHitoActividadOrd'] = $fila['EtapaHitoActividadOrd'];  
				$elemento['EtapaHitoAbrev'] = $fila['EtapaHitoAbrev'];  
				$elemento['EtapaHitoJerarquia'] = $fila['EtapaHitoJerarquia'];  
				$elemento['EtapaHitoJerarqNivel'] = $fila['EtapaHitoJerarqNivel'];  
				$elemento['EtapaHitoPLANIFIde'] = $fila['EtapaHitoPLANIFIde'];  
				$elemento['EtapaHitoPLANIFI'] = $fila['EtapaHitoPLANIFI'];  
				$elemento['EtapaHitoEJECUTide'] = $fila['EtapaHitoEJECUTide'];  
				$elemento['EtapaHitoEJECUT'] = $fila['EtapaHitoEJECUT'];  
				$elemento['EtapaHitoEJECUTCalertaDias'] = $fila['EtapaHitoEJECUTCalertaDias'];  
				$elemento['EtapaHitoREPROGide'] = $fila['EtapaHitoREPROGide'];  
				$elemento['EtapaHitoREPROG'] = $fila['EtapaHitoREPROG'];  
				$elemento['EtapaHitoREPROGalertaDias'] = $fila['EtapaHitoREPROGalertaDias'];  
				$elemento['ContConcepAlertaColor'] = $fila['ContConcepAlertaColor'];  
				$elemento['ContConcepAlertaTitulo'] = $fila['ContConcepAlertaTitulo'];  
				$elemento['ContConcepAlertaMensaje'] = $fila['ContConcepAlertaMensaje']; 
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
