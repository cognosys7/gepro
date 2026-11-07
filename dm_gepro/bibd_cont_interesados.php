<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION DE PROYECTOS DE REMEDIACI�N DE PASIVOS AMBIENTALES - ACTIVOS MINEROS
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio C�sar Meza Yangali - mezayangali@gmail.com - 
//                    Ing. Jose Garay                
//  Prop�sito       : BIBD_CONT_INTERESADOS
//  Fecha           : s�bado, 27 de julio de 2019 13:14:44
//  Desde el Modelo : PDM - INTERFACE FINANCIERO SPRING (2)_edgarEtiqueta
//  Modificado      : 12 de Julio 2017
//******************************************************************************/

 function BIBD_CONT_INTERESADOS(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
			ContInteresadoIde ,
			ContIde ,
			ContCodigoUnicoOrden ,
			
			InteresadoNombre ,
			InteresadoTipo ,
			InteresadoRol ,
			InteresadoCargo ,
			ContIntrsaLocaliza ,
			ContIntrsaEmail ,
			ContIntrsaTelf ,
			ContIntrsaPertenece ,
			ContIntrsaRequiere ,
			ContIntrsaExpectativa ,
			ContIntrsaEstrategia ,
			ContIntrsaTipo ,
			ContIntrsaInfluencia ,
			ContIntrsaImpactoEvalu ,
			ContIntrsaInteresProy ,
			ContIntrsaFaseInteres ,
			ContIntrsaObservacion ,
			ContIntrsaEstado 
         FROM BIBD_CONT_INTERESADOS order by 1");	
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
				$elemento['ContInteresadoIde'] = $fila['ContInteresadoIde'];  
				$elemento['ContIde'] = $fila['ContIde'];  
				$elemento['ContCodigoUnicoOrden'] = $fila['ContCodigoUnicoOrden'];  
				
				$elemento['InteresadoNombre'] = $fila['InteresadoNombre'];  
				$elemento['InteresadoTipo'] = $fila['InteresadoTipo'];  
				$elemento['InteresadoRol'] = $fila['InteresadoRol'];  
				$elemento['InteresadoCargo'] = $fila['InteresadoCargo'];  
				$elemento['ContIntrsaLocaliza'] = $fila['ContIntrsaLocaliza'];  
				$elemento['ContIntrsaEmail'] = $fila['ContIntrsaEmail'];  
				$elemento['ContIntrsaTelf'] = $fila['ContIntrsaTelf'];  
				$elemento['ContIntrsaPertenece'] = $fila['ContIntrsaPertenece'];  
				$elemento['ContIntrsaRequiere'] = $fila['ContIntrsaRequiere'];  
				$elemento['ContIntrsaExpectativa'] = $fila['ContIntrsaExpectativa'];  
				$elemento['ContIntrsaEstrategia'] = $fila['ContIntrsaEstrategia'];  
				$elemento['ContIntrsaTipo'] = $fila['ContIntrsaTipo'];  
				$elemento['ContIntrsaInfluencia'] = $fila['ContIntrsaInfluencia'];  
				$elemento['ContIntrsaImpactoEvalu'] = $fila['ContIntrsaImpactoEvalu'];  
				$elemento['ContIntrsaInteresProy'] = $fila['ContIntrsaInteresProy'];  
				$elemento['ContIntrsaFaseInteres'] = $fila['ContIntrsaFaseInteres'];  
				$elemento['ContIntrsaObservacion'] = $fila['ContIntrsaObservacion'];  
				$elemento['ContIntrsaEstado'] = $fila['ContIntrsaEstado']; 
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
