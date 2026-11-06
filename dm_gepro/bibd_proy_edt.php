<?php

 function BIBD_PROY_EDT(){
 	try { 	
		$db = Conexion::getConexion();
        $stmt = $db->prepare("select 
            IDE_EDT,
            IDE_PROYECTO,
            COD_EDT,
            DES_EDT,
            FEC_INICIO_PROG,
            FEC_TERMINO_PROG,
            FEC_INICIO_REAL,
            FEC_TERMINO_REAL,
            PORC_AVANCE_PROG,
            PORC_AVANCE_REAL,
            VARIACION,
            SPI,
            CPI,
            EST_EDT
         FROM dbo.BIBD_PROY_EDT order by COD_EDT");
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		      $elemento = array();
                $elemento['IDE_EDT'] = $fila['IDE_EDT'];
                $elemento['IDE_PROYECTO'] = $fila['IDE_PROYECTO'];
                $elemento['COD_EDT'] = $fila['COD_EDT'];
                $elemento['DES_EDT'] = $fila['DES_EDT'];
                $elemento['FEC_INICIO_PROG'] = $fila['FEC_INICIO_PROG'];
                $elemento['FEC_TERMINO_PROG'] = $fila['FEC_TERMINO_PROG'];
                $elemento['FEC_INICIO_REAL'] = $fila['FEC_INICIO_REAL'];
                $elemento['FEC_TERMINO_REAL'] = $fila['FEC_TERMINO_REAL'];
                $elemento['PORC_AVANCE_PROG'] = $fila['PORC_AVANCE_PROG'];
                $elemento['PORC_AVANCE_REAL'] = $fila['PORC_AVANCE_REAL'];
                $elemento['VARIACION'] = $fila['VARIACION'];
                $elemento['SPI'] = $fila['SPI'];
                $elemento['CPI'] = $fila['CPI'];
                $elemento['EST_EDT'] = $fila['EST_EDT'];
				
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
