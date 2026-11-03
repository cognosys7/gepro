<?php
require_once("mensajes.php");
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Hector Lopez Sanchez
  //  Propósito       : SEG_ENTIDAD_USUARIOVISTA de la tabla SEG_ENTIDAD_USUARIO
  //  Fecha           : martes, 10 de abril de 2018 04:36:22 p.m.
  //  Desde el Modelo : PDM - AMSACEtiqueta
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

function muestraVista() {    
    $lCollection = Collection::Singleton();
    $descmsje         = "";
    $PIDE_USUARIO = $lCollection->Get('PIDE_USUARIO');
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $Tabs             = $lCollection->Get('Tabs');
    $PermisoOK        = $lCollection->Get('PermisoOK');
    $DatosPersona     = $lCollection->Get('DatosPersona');
    $Codigo           = $lCollection->Get('Codigo');
    $CodigoM          = $lCollection->Get('CodigoM');
    $CargaAsignacion  = $lCollection->Get('CargaAsignacion');
    $mensaje          = $lCollection->Get('Mensaje');
    /*
    if ($mensaje <> "") 
    {
        $descmsje = mensajesistema($mensaje);
    }
    */
?>
 <!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <title><?php echo PRONIED;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--ESTILOS POR DEFAULT-->
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/css/estilos.css"  type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/flaty_rojo.css">
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.core.css"  type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.theme.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.tabs.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.deshab.css" type="text/css" media="screen"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/estilos_lightbox.css"  />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/colorbox/colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
        
        <!--JQUERY POR DEFAULT-->
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery/jquery.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/RPT_INTERVENCIONES.js"></script>
        
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.core.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.widget.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.tabs.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid.js"></script>        
        <!--VALIDACION-->
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/validacion/jquery.validate.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/validacion/reglas.js"></script>
        
        <script type="text/javascript">
            function cerrarPopup()
            {
                parent.$.colorbox.close();
                parent.$('#flex1').flexReload();
            }
            $(function () {
                $("#tabs").tabs({active: 1});
                $("#tabs").tabs({disabled: [0]});
				//Nuevo(Pagina);
            });
            function CallFlexiGrid()
            {
                $('#flex1').flexReload();
            }
        </script>
    <div id="Mensajes" onload="Nuevoss('<?php echo $PaginaFormulario ?>');"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {                    
                    ?>
                    <div class="box-content">
                        <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                            <tr>
                                <td style="text-align: left; width: 80%;">
                                </td>
                                <td style="text-align: right; width: 20%;">
                                    Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                                </td>
                            </tr>
                        </table>

                        <div id="tabs">
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                            <ul>
                                <li><a href="#tabs-1">Descargar Archivo Generado </a></li>
                                <li><a href="#tabs-2">Impresión de Reportes de Ejecución Física y Financiera</a></li>
                                
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">                                
                                <form name="formularioGrid" class="validform fm-form" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    
                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione una opción de la lista desplegable 
                                        </div>
                                        <div id="datos">
                                            <table id="flex1" style="display:none">                                        
                                            </table>
                                        </div>                                        
                                        
                                        <script type="text/javascript">
                                            
                                            Nuevo('<?php echo $PaginaFormulario ?>');
                                            
                                        </script>
                                        
                                        
                                        <?PHP 	
                                        $lCollection = Collection::Singleton();
                                        $Reporte= $lCollection->Get('DataSet_RPT_INTERVENCIONES');                                        
                                        // RECUPERANDO LOS DATOS                                    
                                        //var_dump($Reporte);
                                        
                                        set_include_path(get_include_path() . PATH_SEPARATOR . '../_lib/PHPExcel/');
                                        require_once '../lib/PHPExcel/PHPExcel.php';
                                        $file = "seguimiento/ReporteGerencial.xlsx";
                                        
                                        $objPHPExcel = PHPExcel_IOFactory::load($file);
                                        
                                        
                                        //if ($objPHPExcel->getProperties()->getCreator() == 'HLOPEZ' or $objPHPExcel->getProperties()->getCreator() == 'Administradores') {
                                            
                                            $i=4;
                                            for ($ii = 0; $ii < count($Reporte); $ii++) 
                                            {												
                                                $objPHPExcel->setActiveSheetIndexByName('Listado')	
                                                    ->setCellValue('A'.$i, $Reporte[$ii]->CodProyecto)
                                                    ->setCellValue('B'.$i, $Reporte[$ii]->Region)
                                                    ->setCellValue('C'.$i, $Reporte[$ii]->Sector)
                                                    ->setCellValue('D'.$i, $Reporte[$ii]->EntidadEjecutora)
                                                    ->setCellValue('E'.$i, $Reporte[$ii]->CodigoUnico)
                                                    ->setCellValue('F'.$i, $Reporte[$ii]->NombreProyecto)
                                                    ->setCellValue('G'.$i, $Reporte[$ii]->DecretoSupremo)
                                                    ->setCellValue('H'.$i, $Reporte[$ii]->GrupoTipoIntervencion)
                                                    ->setCellValue('I'.$i, $Reporte[$ii]->MontoReferencial)                                                
                                                    ->setCellValue('J'.$i, $Reporte[$ii]->Intervencion)
                                                    ->setCellValue('K'.$i, $Reporte[$ii]->TipoProceso)
                                                    ->setCellValue('L'.$i, $Reporte[$ii]->EstadoProyecto)
                                                    ->setCellValue('M'.$i, $Reporte[$ii]->MetaFisica)
                                                    ->setCellValue('N'.$i, $Reporte[$ii]->AvanceFisico)
                                                    ->setCellValue('O'.$i, $Reporte[$ii]->FechaReporteAvanceFisico)
                                                    ->setCellValue('P'.$i, $Reporte[$ii]->MetaFinanciera)
                                                    ->setCellValue('Q'.$i, $Reporte[$ii]->AvanceFinanciero)
                                                    ->setCellValue('R'.$i, $Reporte[$ii]->FechaReporteAvanceFinanciero)
                                                    ->setCellValue('S'.$i, $Reporte[$ii]->ContingenciaAdvertida)
                                                    ->setCellValue('T'.$i, $Reporte[$ii]->MedidasAdptadas);
                                                $i++;                                                
                                            }
                                        
                                                                                                                                                                            
                                            
                                            try {					
                                                //GUARDA EL ARCHIVO									
                                                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');					
                                                $Archivo='Reporte';
                                                $objWriter->save("reportes/".$Archivo.".xlsx");                                                
                                                //ob_end_clean();
                                                echo "<center>".		
                                                    'El Registro: <br><b>'.$Archivo.'.xlsx</b><br> se generó correctamente.<br>'.
                                                    'Puede descargarlo haciendo click en el siguiente enlace.<br>'.
                                                    '<a href="reportes/'.$Archivo.'.xlsx" target="_blank" onclick="self.parent.tb_remove();">'.
                                                    '<img src="'.HTML_PATH_IMAGES.'/ExportarExcel.png"></a><br></center>';

                                            } catch (Exception $e) {
                                                    sc_alert("!! ... ERROR ... !!, NO se puede GENERAR el archivo: nombre de archivo");
                                            }
                                             
                                             
                                        /*
                                        } else {
                                            echo '<center><br>Error al cargar los datos.<br>' ;
                                            //echo "<center><br><b><input id='Salir' value='Sair' onClick='redireciona();' type='submit'></center>";
                                        }
                                        */


                
                                    ?>
                                    </div>
                                </form>
                            </div>
                            <!--PESTAÑA 2-->
                            <div id="tabs-2">                           
                                <div id="FormularioDiv">
                                    <!-- En esta seccion se muestra todos los datos recuperados del foumulario -->                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<br><br><center>UD. NO TIENE ACCESO A ESTE MÓDULO</center><br>";
                }
                ?>
            </div>
        </div>
    </div>
    <br><br>
    <?php
}

//FUNCION PARA PROCESAR LOS MENSAJES DE LAS ACCIONES

function ProcesaMensaje() {
    $lCollection = Collection::Singleton();
    $descmsje = "";
    $sCodMensaje = $lCollection->Get('CodMensaje');
    $sMensaje = $lCollection->Get('Mensaje');
    if ($sCodMensaje <> "") {
        $descmsje = mensajesistema($sCodMensaje, $sMensaje);
    } else {
        $descmsje = mensajesistema($sMensaje);
    }
    echo $descmsje . "<br>";
}

//FUNCION UTILIZADA CUANDO SE REGISTRA O EDITA INFORMACIÓN
function GeneraForm() {
    $lCollection = Collection::Singleton();
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');    
    $TIP_ACCESO = $lCollection->Get('TIP_ACCESO');    
    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');
    
    //INSERT
    $ActionFormulario = "ImprimirReporte";
    $Btn = "Imprimir";
    $TitulFormulario = "Opciones de impresión"; //Nombre de la Tabla
    
    
    ?>
    <script type="text/javascript">
        $(function () {
            //ACTIVA LOS TOOLTIPS
            $('*[data-content]').hover(function ()
            {
                $(this).popover('show');
            });
            //VALIDACION DE FORMULARIO
            $("#BtnForm01").on("click", function () {
                if ($("#formulario").valid()) {
                    AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                }
            });            
        });
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">        
        <legend><?php echo $TitulFormulario; ?></legend>         
        <div class="control-group">
            <label class="control-label" for="TIP_ACCESO">Imprimir:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_ACCESO('TIP_ACCESO', $DataSet_GEN_TABLAS_1, $TIP_ACCESO, 1, "") ?>				
            </div>
        </div>        
        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="IMPRIMIR">
    <!--        <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>   -->
        </div>
    </form>
    <?php
}
/*************************************************************************************************
* (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
************************************************************************************************/

function comboTIP_ACCESO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de acceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->COD_ITEM > 0)) {
                if ($lstDatos[$i]->COD_ITEM == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_ITEM . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ITEM . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_ITEM . "\">" . $lstDatos[$i]->DES_ITEM . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}
