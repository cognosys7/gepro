<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_PROY_GESTION_SOCIAL_QUEJA
//  Fecha           : s�bado, 27 de julio de 2019 12:58:46
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_PROY_GESTION_SOCIAL_QUEJA(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			SocialQuejaIde ,
			SocialIde ,
			SocialQuejaDescribe ,
			SocialQuejaImpacto ,
			SocialQuejaCanaliza ,

			SocialQuejaFecRegis ,
			SocialQuejaEstAtenc ,
			SocialQuejaFecAtenc ,
			SocialQuejaEstado ,
                        
                        SocialIntrsaNombre ,
                        SocialIntrsaTipo ,
                        SocialIntrsaRol ,
                        SocialIntrsaCargo
                        
         FROM BIBD_PROY_GESTION_SOCIAL_QUEJA order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['SocialQuejaIde'] = $fila['SocialQuejaIde']; 
				$elemento['SocialIde'] = $fila['SocialIde'];  
				$elemento['SocialQuejaDescribe'] = $fila['SocialQuejaDescribe'];  
				$elemento['SocialQuejaImpacto'] = $fila['SocialQuejaImpacto'];  
				$elemento['SocialQuejaCanaliza'] = $fila['SocialQuejaCanaliza'];  

				$elemento['SocialQuejaFecRegis'] = $fila['SocialQuejaFecRegis'];  
				$elemento['SocialQuejaEstAtenc'] = $fila['SocialQuejaEstAtenc'];  
				$elemento['SocialQuejaFecAtenc'] = $fila['SocialQuejaFecAtenc'];  
				$elemento['SocialQuejaEstado'] = $fila['SocialQuejaEstado']; 
                                
                                $elemento['SocialIntrsaNombre'] = $fila['SocialIntrsaNombre']; 
                                $elemento['SocialIntrsaTipo'] = $fila['SocialIntrsaTipo']; 
                                $elemento['SocialIntrsaRol'] = $fila['SocialIntrsaRol']; 
                                $elemento['SocialIntrsaCargo'] = $fila['SocialIntrsaCargo']; 
                                
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
