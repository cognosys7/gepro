<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : Interfaz se elección de archivo para migrar a la tabla MON_PLANIFICACION y MON_PLANIF_MEDICION
//  Fecha           : martes, 01 de julio de 2021 14:03:14
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 01 de julio de 2021 14:03:14
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
        width: 30%;
        /*display: flex;*/
        justify-content: center;
        align-items: center;
      }
   </style>     

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->


<?php
//$BDES_RUTA = '../../archivos/etl_MONITOREO_INDICADORES/' ;
//$BDES_ARCHIVO = 'base_MONITOREO_INDICADORES.xlsx' ; 

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

$sql_delete = "TRUNCATE TABLE dbo.etl_INTERESADOS ;" ;
ejecutarSQL($sql_delete) ;
//echo '<br>despues de truncate' ;

$hoja = $excel->getSheet(0);            // Cargar la hoja de calculo que queremos
$filas = $hoja->getHighestRow();        // Obtener el numero de filas de nuestro archivo excel
$columnas = $hoja->getHighestColumn();  // Obtener el numero de columnas de nuestro archivo excel

$filas_vacias = 0 ; 
$filas_insertadas = 0 ; 
for ($i = 2; $i <= $filas; $i++){ 
    //echo '<br>entre :'.$i ;
    $CARGAR                             = $hoja->getCell('A'.$i)->getCalculatedValue();
    $COD_UNICO		                    = $hoja->getCell('B'.$i)->getCalculatedValue(); 
    $COD_CONTRATO     		            = $hoja->getCell('C'.$i)->getCalculatedValue();
    $DES_COMUNIDAD                      = $hoja->getCell('D'.$i)->getCalculatedValue(); 	
    $DES_RECURSO          	            = $hoja->getCell('E'.$i)->getCalculatedValue(); 	
    $DES_CARGO     			            = $hoja->getCell('F'.$i)->getCalculatedValue(); 	
    $DES_LOCALIZACION                   = $hoja->getCell('G'.$i)->getCalculatedValue(); 	
    $DES_ROL              	            = $hoja->getCell('H'.$i)->getCalculatedValue(); 	
    $DES_TELEFONO          	            = $hoja->getCell('I'.$i)->getCalculatedValue(); 	
    $DES_MAIL    			            = $hoja->getCell('J'.$i)->getCalculatedValue(); 		
    $DES_DIRECCION                      = $hoja->getCell('K'.$i)->getCalculatedValue(); 
    $DES_REQUERIMIENTOS_PRIMORDIALES    = $hoja->getCell('L'.$i)->getCalculatedValue(); ////////////	
    $DES_EXPECTATIVAS_PRINCIPALES       = $hoja->getCell('M'.$i)->getCalculatedValue(); 
    $TIP_INFLUENCIA_POTENCIAL           = $hoja->getCell('N'.$i)->getCalculatedValue(); //////////// 	
    $DES_FASE_MAYOR_INTERES     	    = $hoja->getCell('O'.$i)->getCalculatedValue();	////////////	
    $TIP_INTERNO_EXTERNO 			    = $hoja->getCell('P'.$i)->getCalculatedValue();
    $TIP_CLASIFICACION     			    = $hoja->getCell('Q'.$i)->getCalculatedValue();
    $DES_ESTRATEGIA_PRINCIPAL           = $hoja->getCell('R'.$i)->getCalculatedValue();
   

      
  if ($COD_UNICO == "") { 
        $filas_vacias = $filas_vacias+1 ;
  } else {    
        $filas_insertadas = $filas_insertadas+1 ;  
        $sql_insert = "INSERT INTO [dbo].[etl_INTERESADOS]
           ([CARGAR]
           ,[COD_UNICO]
           ,[COD_CONTRATO]
           ,[DES_COMUNIDAD]
           ,[DES_RECURSO]
           ,[DES_CARGO]
           ,[DES_LOCALIZACION]
           ,[DES_ROL]
           ,[DES_TELEFONO]
           ,[DES_MAIL]
           ,[DES_DIRECCION]
           ,[DES_REQUERIMIENTOS_PRIMORDIALES]
           ,[DES_EXPECTATIVAS_PRINCIPALES]
           ,[TIP_INFLUENCIA_POTENCIAL]
           ,[DES_FASE_MAYOR_INTERES]
           ,[TIP_INTERNO_EXTERNO]
           ,[TIP_CLASIFICACION]
           ,[DES_ESTRATEGIA_PRINCIPAL]
           ) VALUES ( "
                . "'$CARGAR', '$COD_UNICO', "
                . "'$COD_CONTRATO', '$DES_COMUNIDAD', '$DES_RECURSO', '$DES_CARGO', "
                . "'$DES_LOCALIZACION', '$DES_ROL', '$DES_TELEFONO', '$DES_MAIL', '$DES_DIRECCION', "
                . "'$DES_REQUERIMIENTOS_PRIMORDIALES', '$DES_EXPECTATIVAS_PRINCIPALES', "
                . "'$TIP_INFLUENCIA_POTENCIAL', '$DES_FASE_MAYOR_INTERES', '$TIP_INTERNO_EXTERNO', "
                . "'$TIP_CLASIFICACION', '$DES_ESTRATEGIA_PRINCIPAL' "
                . ");" ;
        //echo '<br>'.$sql_insert ;
        ejecutarSQL($sql_insert) ;
    } 
}

//echo "<br><hr><br>";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////// ejecutar ETL

$sql = " EXEC sp_ETL_ImportarInteresados ; " ;
ejecutarSQL($sql) ;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>



<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        
    <div class="padre">
        <div class="hijo" >
            
            <br>
           
            <div class="panel-heading">
                <h3 class="panel-title">Resultados de archivo de Excel.</h3>
            </div>
            
            <table style="border:1; width: 100% ">  
                <tr class="tb_video_cabezera">
                    <td width="10%">
                        <button type=button  onclick="salir()" title = "Salir" id="salir16" ></button>
                    </td>
                    <td>
                        CARGAR INTERESADOS DEL CONTRATO PRINCIPAL<br>
                        
                        <?php echo 'Ultimo Archivo : ' . substr( $BDES_ARCHIVO , 16 ) . '<br>Fecha: ' . $BFEC_CARGA_fecha . ' ' . $BFEC_CARGA_hora ;?>
                    </td>
                    <td width="10%">
                        <button type=button  onclick="salir()" title = "Salir" id="salir16" ></button>
                    </td>
                </tr>
            </table>
            
            <table class="table table-bordered" style="border:1; width: 100%;">
                <thead>
<!--                <tr>
                    <th>Acción</th>
                    <th>Total</th>
                    <th>Cargados ( CARGAR = 1 )</th>
                    <th>No Cargados ( CARGAR = 0 )</th>
                </tr>-->
                </thead>
                <tbody>
                <tr>
                  <th>Registros Leidos</th>
                  <th><?php echo $filas_insertadas ;?></th>
<!--                  <td><?php // echo $filas_Cargar ;?></td>
                  <td><?php // echo $filas_NoCargar ;?></td>-->
                </tr>
                </tbody>
            </table>
            
        </div> 
    </div>  

    
<?php
}

