<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : JS de la tabla PROY_CONT_ETAPA_CONTROL y PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 14:03:14
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:03:14
//******************************************************************************/

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    
    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $Tabla = $lCollection->Get('Tabla');
    
    $BDES_ARCHIVO = $lCollection->Get('BDES_ARCHIVO');
    $BDES_RUTA = $lCollection->Get('BDES_RUTA');
    $BFEC_CARGA = $lCollection->Get('BFEC_CARGA');
    $BFEC_CARGA_fecha = $lCollection->Get('BFEC_CARGA_fecha');
    $BFEC_CARGA_hora = $lCollection->Get('BFEC_CARGA_hora');


    //echo 'pide:'. $PIDE . ' - Tabla:' .$Tabla  . '<br>'. 'BDES_ARCHIVO:' . $BDES_ARCHIVO . '<br>' . 'BDES_RUTA:' . $BDES_RUTA . '<br>'. 'BFEC_CARGA_fecha:' . $BFEC_CARGA_fecha. '<br>'. 'BFEC_CARGA_hora:' . $BFEC_CARGA_hora ;


    /* EDGAR */
    ?>

    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script> 
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <link rel="stylesheet" type="text/css" href="../recursos/css/include.css" />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/include/comun.js"></script> 
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/migrar_CONT_ETAPA_CONTROLvista.js"></script>    

    
    <script type="text/javascript">

        function salir() {
            parent.$.colorbox.close();
        }
        
        
        function abrirGEN_ARCHIVO(PIDE,Tabla)
        {
            OcultaBOx();
            $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=GEN_ARCHIVO&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE+"&Tabla=" + Tabla});
            $('#cboxClose').remove();
        }
        

        function migrarGEN_ARCHIVO(PIDE,Tabla)
        {
            OcultaBOx();
            $.colorbox({width: "100%", height: "100%", iframe: true, escKey: false, overlayClose: false, href: "mainpage.php?Pagina=migrar_Importar_SQLSERVER&Accion=muestraVista&AccionLocal=2&PIDE=" + PIDE+"&Tabla=" + Tabla});
            $('#cboxClose').remove();
        }

    </script>     
    
    <style>
    .padre {
        /*background: yellow;*/
        height: 100%;
        /*IMPORTANTE*/
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .hijo {
        /*background: red;*/
        width: 50%;
      }
   </style>     

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once '../../recursosAPP/recursos/ImpExcel/conexion_sqlserver.php';

function ejecutarSQL($CRUD){
    try { 	
            $db = Conexion::getConexion();
            $stmt = $db->prepare($CRUD);	
            $stmt->execute();

    } catch (PDOException $e) {
            //$db->rollback();
            $mensaje  = '<b>Consulta No Valida:</b> ' . $e->getMessage() . "<br/>";
            $mensaje .= '<b>Consulta: </b>' . $CRUD;
            die($mensaje);
    }
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once '../../recursosAPP/recursos/ImpExcel/PHPExcel/Classes/PHPExcel.php';
$archivo = $BDES_RUTA . $BDES_ARCHIVO ;
//echo '<br>archivo :'.$archivo ;

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

// Cargar nuestra hoja de excel
$excel = $objReader->load($archivo);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////// PROGRAMADO

$sql_delete = "TRUNCATE TABLE DBO.etl_OBR_PROG ;" ;
ejecutarSQL($sql_delete) ;
//echo '<br>despues de truncate' ;

$hoja = $excel->getSheet(0);            // Cargar la hoja de calculo que queremos
$filas = $hoja->getHighestRow();        // Obtener el numero de filas de nuestro archivo excel
$columnas = $hoja->getHighestColumn();  // Obtener el numero de columnas de nuestro archivo excel

$filas_vacias_PROG = 0 ; 
$filas_insertadas_PROG = 0 ; 
for ($i = 2; $i <= $filas; $i++){ 
    //echo '<br>entre :'.$i ;
    $CARGAR             = $hoja->getCell('A'.$i)->getCalculatedValue();
    $TIPO               = $hoja->getCell('B'.$i)->getCalculatedValue(); 
    $CONTRATO           = $hoja->getCell('C'.$i)->getCalculatedValue();
    $COD_GESTION_CAMBIO = $hoja->getCell('D'.$i)->getCalculatedValue(); 	
    $DESCRIPCION_GC     = $hoja->getCell('E'.$i)->getCalculatedValue(); 	
    $TIP_CONCEPTO       = $hoja->getCell('F'.$i)->getCalculatedValue(); 	
    $ITEM               = $hoja->getCell('G'.$i)->getCalculatedValue(); 	
    $ANIO               = $hoja->getCell('H'.$i)->getCalculatedValue(); 	
    $MES                = $hoja->getCell('I'.$i)->getCalculatedValue(); 		
    $CONCEPTO_PAGO      = $hoja->getCell('J'.$i)->getCalculatedValue(); 
    $AVANCE             = $hoja->getCell('K'.$i)->getCalculatedValue(); ////////////	
    $MONTO_BRUTO        = $hoja->getCell('L'.$i)->getCalculatedValue(); 
    $AMORTIZACION       = $hoja->getCell('M'.$i)->getCalculatedValue(); //////////// 	
    $SALDO_SIN_IGV      = $hoja->getCell('N'.$i)->getCalculatedValue();	////////////	
    $PCT_IGV            = $hoja->getCell('O'.$i)->getCalculatedValue();
    $MTO_IGV            = $hoja->getCell('P'.$i)->getCalculatedValue();
    $MTO_NETO           = $hoja->getCell('Q'.$i)->getCalculatedValue();

      
  if ($CONTRATO == "") { 
        $filas_vacias_PROG = $filas_vacias_PROG+1 ;
  } else {    
        $filas_insertadas_PROG = $filas_insertadas_PROG+1 ;  
        $sql_insert = "INSERT INTO dbo.etl_OBR_PROG ("
                . "CARGAR ,TIPO, "
                . "CONTRATO,COD_GESTION_CAMBIO,DESCRIPCION_GC,TIP_CONCEPTO,ITEM,ANIO,MES,CONCEPTO_PAGO, "
                . "AVANCE, MONTO_BRUTO, AMORTIZACION, SALDO_SIN_IGV, PCT_IGV,MTO_IGV,MTO_NETO"
                . ") VALUES ( "
                . "'$CARGAR', '$TIPO', "
                . "'$CONTRATO', '$COD_GESTION_CAMBIO', '$DESCRIPCION_GC', '$TIP_CONCEPTO', '$ITEM', '$ANIO', '$MES', '$CONCEPTO_PAGO', "
                . "'$AVANCE', '$MONTO_BRUTO', '$AMORTIZACION', '$SALDO_SIN_IGV', '$PCT_IGV', '$MTO_IGV', '$MTO_NETO' );" ;
        //echo '<br>'.$sql_insert ;
        ejecutarSQL($sql_insert) ;
    } 
}

//echo "<br><hr><br>";

//////////////////////// REAL

// Cargar la hoja de calculo que queremos
$hoja = $excel->getSheet(1); 

// Obtener el numero de filas de nuestro archivo excel
$filas = $hoja->getHighestRow(); 
//echo '<br>filas :'.$filas ;

// Obtener el numero de columnas de nuestro archivo excel
$columnas = $hoja->getHighestColumn();


$sql_delete = "TRUNCATE TABLE etl_OBR_REAL ;" ;
ejecutarSQL($sql_delete) ;

$filas_vacias_REAL = 0 ;
$filas_insertadas_REAL = 0 ;
for ($i = 2; $i <= $filas; $i++){ 
    //echo '<br>entre al for fila :'.$i ;
    $CARGAR             = $hoja->getCell('A'.$i)->getCalculatedValue(); //echo '<br>CARGAR :'.$CARGAR ;
    $TIPO               = $hoja->getCell('B'.$i)->getCalculatedValue(); //echo '<br>TIPO :'.$TIPO ;
    $CONTRATO           = $hoja->getCell('C'.$i)->getCalculatedValue(); //echo '<br>CONTRATO :'.$CONTRATO ;
    $COD_GESTION_CAMBIO = $hoja->getCell('D'.$i)->getCalculatedValue(); //echo '<br>COD_GESTION_CAMBIO :'.$COD_GESTION_CAMBIO ;
    $DESCRIPCION_GC     = $hoja->getCell('E'.$i)->getCalculatedValue(); //echo '<br>DESCRIPCION_GC :'.$DESCRIPCION_GC ;	
    $TIP_CONCEPTO       = $hoja->getCell('F'.$i)->getCalculatedValue(); //echo '<br>TIP_CONCEPTO :'.$TIP_CONCEPTO ;
    $ITEM               = $hoja->getCell('G'.$i)->getCalculatedValue(); //echo '<br>ITEM :'.$ITEM ;
    $ANIO               = $hoja->getCell('H'.$i)->getCalculatedValue(); //echo '<br>ANIO :'.$ANIO ;
    $MES                = $hoja->getCell('I'.$i)->getCalculatedValue(); //echo '<br>MES :'.$MES ;
    $CONCEPTO_PAGO      = $hoja->getCell('J'.$i)->getCalculatedValue(); //echo '<br>CONCEPTO_PAGO :'.$CONCEPTO_PAGO ;
    $AVANCE             = $hoja->getCell('K'.$i)->getCalculatedValue(); //echo '<br>AVANCE :'.$AVANCE ;
    $MONTO_BRUTO        = $hoja->getCell('L'.$i)->getCalculatedValue(); //echo '<br>MONTO_BRUTO :'.$MONTO_BRUTO ;	
    $REAJUSTE           = $hoja->getCell('M'.$i)->getCalculatedValue(); //echo '<br>REAJUSTE :'.$REAJUSTE ;	
    $AMORT_ADEL_DIR     = $hoja->getCell('N'.$i)->getCalculatedValue(); //echo '<br>AMORT_ADEL_DIR :'.$AMORT_ADEL_DIR ;	
    $AMORT_ADEL_MAT     = $hoja->getCell('O'.$i)->getCalculatedValue(); //echo '<br>AMORT_ADEL_MAT :'.$AMORT_ADEL_MAT ;	
    $AMORTIZACION       = $hoja->getCell('P'.$i)->getCalculatedValue(); //echo '<br>AMORTIZACION :'.$AMORTIZACION ;	
    $SALDO_SIN_IGV      = $hoja->getCell('Q'.$i)->getCalculatedValue(); //echo '<br>SALDO_SIN_IGV :'.$SALDO_SIN_IGV ;	
    $DEDUC_ADEL_DIR     = $hoja->getCell('R'.$i)->getCalculatedValue(); //echo '<br>DEDUC_ADEL_DIR :'.$DEDUC_ADEL_DIR ;	
    $DEDUC_ADEL_MAT     = $hoja->getCell('S'.$i)->getCalculatedValue(); //echo '<br>DEDUC_ADEL_MAT :'.$DEDUC_ADEL_MAT ;	
    $MTO_IMPONIBLE      = $hoja->getCell('T'.$i)->getCalculatedValue(); //echo '<br>MTO_IMPONIBLE :'.$MTO_IMPONIBLE ;	
    $PCT_IGV            = $hoja->getCell('U'.$i)->getCalculatedValue(); //echo '<br>PCT_IGV :'.$PCT_IGV ;	
    $MTO_IGV            = $hoja->getCell('V'.$i)->getCalculatedValue(); //echo '<br>MTO_IGV :'.$MTO_IGV ;	
    $MTO_NETO           = $hoja->getCell('W'.$i)->getCalculatedValue(); //echo '<br>MTO_NETO :'.$MTO_NETO ;	
    $IMP_PENALIDAD      = $hoja->getCell('X'.$i)->getCalculatedValue(); //echo '<br>IMP_PENALIDAD :'.$IMP_PENALIDAD ;	
    $IMP_RETENCION      = $hoja->getCell('Y'.$i)->getCalculatedValue(); //echo '<br>IMP_RETENCION :'.$IMP_RETENCION ;	
    $IMP_PAGO           = $hoja->getCell('Z'.$i)->getCalculatedValue(); //echo '<br>IMP_PAGO :'.$IMP_PAGO ;	

      
  if ($CONTRATO == "") { 
        $filas_vacias_REAL = $filas_vacias_REAL+1 ;
  } else {
        $filas_insertadas_REAL = $filas_insertadas_REAL+1 ;
        $sql_insert = "INSERT INTO dbo.etl_OBR_REAL ( "
                . "CARGAR, TIPO, "
                . "CONTRATO, COD_GESTION_CAMBIO, DESCRIPCION_GC, TIP_CONCEPTO, ITEM, ANIO, MES, CONCEPTO_PAGO, "
                . "AVANCE, MONTO_BRUTO, REAJUSTE, AMORT_ADEL_DIR, AMORT_ADEL_MAT , AMORTIZACION , SALDO_SIN_IGV, DEDUC_ADEL_DIR, DEDUC_ADEL_MAT, MTO_IMPONIBLE, "
                . "PCT_IGV, MTO_IGV, MTO_NETO , IMP_PENALIDAD , IMP_RETENCION , IMP_PAGO "
                . ") VALUES ( "
                . "'$CARGAR', '$TIPO', "
                . "'$CONTRATO', '$COD_GESTION_CAMBIO', '$DESCRIPCION_GC', '$TIP_CONCEPTO', '$ITEM', '$ANIO', '$MES', '$CONCEPTO_PAGO', "
                . "'$AVANCE','$MONTO_BRUTO', '$REAJUSTE', '$AMORT_ADEL_DIR', '$AMORT_ADEL_MAT', '$AMORTIZACION',  '$SALDO_SIN_IGV', '$DEDUC_ADEL_DIR', '$DEDUC_ADEL_MAT', '$MTO_IMPONIBLE', "
                . "'$PCT_IGV', '$MTO_IGV', '$MTO_NETO' , '$IMP_PENALIDAD', '$IMP_RETENCION', '$IMP_PAGO' );" ;
        //echo '<br>'.$sql_insert ;
        ejecutarSQL($sql_insert) ;
    } 
}

//echo "<br><hr><br>";




//////////////////////// REPROGRAMADO

$sql_delete = "TRUNCATE TABLE DBO.etl_OBR_FC ;" ;
ejecutarSQL($sql_delete) ;


$hoja = $excel->getSheet(2);            // Cargar la hoja de calculo que queremos
$filas = $hoja->getHighestRow();        // Obtener el numero de filas de nuestro archivo excel
$columnas = $hoja->getHighestColumn();  // Obtener el numero de columnas de nuestro archivo excel

$filas_vacias_FC = 0 ;
$filas_insertadas_FC = 0 ;
for ($i = 2; $i <= $filas; $i++){ 

    $CARGAR             = $hoja->getCell('A'.$i)->getCalculatedValue();
    $TIPO               = $hoja->getCell('B'.$i)->getCalculatedValue(); 
    $CONTRATO           = $hoja->getCell('C'.$i)->getCalculatedValue();
    $COD_GESTION_CAMBIO = $hoja->getCell('D'.$i)->getCalculatedValue(); 	
    $DESCRIPCION_GC     = $hoja->getCell('E'.$i)->getCalculatedValue(); 	
    $TIP_CONCEPTO       = $hoja->getCell('F'.$i)->getCalculatedValue(); 	
    $ITEM               = $hoja->getCell('G'.$i)->getCalculatedValue(); 	
    $ANIO               = $hoja->getCell('H'.$i)->getCalculatedValue(); 	
    $MES                = $hoja->getCell('I'.$i)->getCalculatedValue(); 		
    $CONCEPTO_PAGO      = $hoja->getCell('J'.$i)->getCalculatedValue(); 
    $AVANCE             = $hoja->getCell('K'.$i)->getCalculatedValue(); ////////////	
    $MONTO_BRUTO        = $hoja->getCell('L'.$i)->getCalculatedValue(); 
    $AMORTIZACION       = $hoja->getCell('M'.$i)->getCalculatedValue(); //////////// 	
    $SALDO_SIN_IGV      = $hoja->getCell('N'.$i)->getCalculatedValue();	////////////	
    $PCT_IGV            = $hoja->getCell('O'.$i)->getCalculatedValue();
    $MTO_IGV            = $hoja->getCell('P'.$i)->getCalculatedValue();
    $MTO_NETO           = $hoja->getCell('Q'.$i)->getCalculatedValue();

      
    if ($CONTRATO == "") { 
        $filas_vacias_FC = $filas_vacias_FC+1 ;
    } else {   
        $filas_insertadas_FC = $filas_insertadas_FC+1 ;
        $sql_insert = "INSERT INTO dbo.etl_OBR_FC ("
                . "CARGAR ,TIPO, "
                . "CONTRATO,COD_GESTION_CAMBIO,DESCRIPCION_GC,TIP_CONCEPTO,ITEM,ANIO,MES,CONCEPTO_PAGO, "
                . "AVANCE, MONTO_BRUTO, AMORTIZACION, SALDO_SIN_IGV, PCT_IGV,MTO_IGV,MTO_NETO"
                . ") VALUES ( "
                . "'$CARGAR', '$TIPO', "
                . "'$CONTRATO', '$COD_GESTION_CAMBIO', '$DESCRIPCION_GC', '$TIP_CONCEPTO', '$ITEM', '$ANIO', '$MES', '$CONCEPTO_PAGO', "
                . "'$AVANCE', '$MONTO_BRUTO', '$AMORTIZACION', '$SALDO_SIN_IGV', '$PCT_IGV', '$MTO_IGV', '$MTO_NETO' );" ;
        //echo '<br>'.$sql_insert ;
        ejecutarSQL($sql_insert) ;
    } 
  
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////// ejecutar ETL
$sql = " EXEC sp_ETL_ImportarControlCostos_OBR_PROG ; " ;
ejecutarSQL($sql) ;
//echo 'prog' ;

$sql = " EXEC sp_ETL_ImportarControlCostos_OBR_REAL ; " ;
ejecutarSQL($sql) ;
//echo 'real' ;

$sql = " EXEC sp_ETL_ImportarControlCostos_OBR_FC ; " ;
ejecutarSQL($sql) ;
//echo 'reprog' ;



//////////////////////// ejecutar ETL tu refrescadita
$sql = " EXEC sp_ETL_ImportarControlCostos_OBR_PROG ; " ;
ejecutarSQL($sql) ;
//echo 'prog' ;

$sql = " EXEC sp_ETL_ImportarControlCostos_OBR_REAL ; " ;
ejecutarSQL($sql) ;
//echo 'real' ;

$sql = " EXEC sp_ETL_ImportarControlCostos_OBR_FC ; " ;
ejecutarSQL($sql) ;
//echo 'reprog' ;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        
    <div class="padre">
        <div class="hijo" >
            
            <br>
           
            <div class="panel-heading">
                <h3 class="panel-title">Resultados de archivo de Excel.</h3>
            </div>
            
            <table style="border:1; width: 100%">  
                <tr class="tb_video_cabezera">
                    <td width="10%">
                        <button type=button  onclick="salir()" title = "Salir" id="salir16" ></button>
                    </td>
                    <td>
                        MIGRAR FICHA TECNICA<br>
                        <?php // echo 'pide:'. $PIDE . ' - Tabla:' .$Tabla . ' - BDES_ARCHIVO:' . $BDES_ARCHIVO . '<br>' ;?>
                        
                        <?php echo 'Ultimo Archivo : ' . substr( $BDES_ARCHIVO , 16 ) . '<br>Fecha: ' . $BFEC_CARGA_fecha . ' ' . $BFEC_CARGA_hora ;?>
                    </td>
                    <td width="10%">
                        <button type=button  onclick="salir()" title = "Salir" id="salir16" ></button>
                    </td>
                </tr>
            </table>
            
            <table class="table table-bordered" style="border:1; width: 100%;">
                <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Programado</th>
                    <th>Real</th>
                    <th>Reprogramado</th>
                </tr>
                </thead>
                <tbody>
           <!--     <tr>
                  <td>VACIAS</td>
                  <td><?php //echo $filas_vacias_PROG ;?></td>
                  <td><?php //echo $filas_vacias_REAL ;?></td>
                  <td><?php //echo $filas_vacias_FC ;?></td>
                </tr> -->
                <tr>
                  <td>INSERTADAS</td>
                  <td><?php echo $filas_insertadas_PROG ;?></td>
                  <td><?php echo $filas_insertadas_REAL ;?></td>
                  <td><?php echo $filas_insertadas_FC ;?></td>
                </tr>
                </tbody>
            </table>
            
        </div> 
    </div>  

    
<?php
}
