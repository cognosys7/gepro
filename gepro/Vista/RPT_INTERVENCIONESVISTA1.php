<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Hector Lopez Sanchez
  //  Propósito       : GEN_NORMATIVAVISTA de la tabla GEN_NORMATIVA
  //  Fecha           : viernes, 5 de enero de 2018 14:38:20
  //  Desde el Modelo : PDM - AMSACEtiqueta
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/RPT_INTERVENCIONES.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>


    <script type="text/javascript">
        function cerrarPopup()
        {
            parent.$.colorbox.close();
            parent.$('#flex1').flexReload();
        }
        $(function () {
            $("#tabs").tabs({active: 0});
            $("#tabs").tabs({disabled: [1]});
        });

        function CallFlexiGrid()
        {
            $('#flex1').flexReload();
        }

        $(function () {
            //ACTIVA LOS TOOLTIPS
            $('*[data-content]').hover(function ()
            {
                $(this).popover('show');
            });
            //VALIDACION DE FORMULARIO
            $("#BtnForm01").on("click", function () {
                if ($("#formulario").valid()) {
                    //AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                    Nuevo('<?php echo $PaginaFormulario ?>');
                }
            });

        });
    </script>  
    
    <div id="Mensajes"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {
                    $SeleccionarID = $lCollection->Get('SeleccionarID');                    
                    $TIP_ACCESO = $lCollection->Get('TIP_ACCESO');                    
                    $DataSet_tsusuario_1 = $lCollection->Get('DataSet_tsusuario_1');
                    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');
                    if (strlen($SeleccionarID) == 0){
                        
                        $ActionFormulario = "ImprimirReporte";
                        $Btn = "Imprimir";
                        $TitulFormulario = ""; //Nombre de la Tabla
                    }
                    
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
                                <li><a href="#tabs-1">Impresión de Reportes de Ejecución Física y Financiera </a></li>
                                <li><a href="#tabs-2">Archivo Ggenerado </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">
                                <form action="mainpage.php" class="validform form-horizontal" id="formularioGrid" name="formularioGrid" method="post">
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
                                        
                                        <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                        <input type="text" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                        <input type="text" name="ActionForm" value="">                                
                                        <input type="text" name="SeleccionarID" value="">                                    

                                    
                                         <div class="control-group">
                                        <label class="control-label" for="TIP_ACCESO">Imprimir:<span class="error">*</span></label>
                                        <div class="controls"> 
                                            <?php comboTIP_ACCESO('TIP_ACCESO', $DataSet_GEN_TABLAS_1, $TIP_ACCESO, 1, "") ?>				
                                        </div>
                                    </div>        
                                    <div class="form-actions">                                        
                                        <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="Imprimir">
                                        <button type="button" onclick="cerrarPopup()" class="btn">Cancelar</button>   
                                    </div>
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
                //Recuperando valores para Mostrar en el Formulario
                $SeleccionarID = $lCollection->Get('SeleccionarID');
                //$IdPersona        = $lCollection->Get('Id');


                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar DECRETOS DE TRANSFERENCIA"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de DECRETOS DE TRANSFERENCIA"; //Nombre de la Tabla
                }
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
                    //AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                    
                }
            });
            //ACTIVAR PARA TRABAJAR CON FECHAS


            $('#FEC_PUBLICACION').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FECHA_INSERT').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FECHA_UPDATE').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });

            /*
             $('#FechaNacimiento, #FechaHoraRegistro').datepicker({
             changeMonth: true,
             changeYear: true,
             showOn: 'button',
             maxDate: '1095',
             buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
             shortYearCutoff: '+100'
             });
             */
        });
    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  





        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_NORMATIVA">: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_NORMATIVA" id="IDE_NORMATIVA" value="<?php echo $IDE_NORMATIVA; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="COD_NORMATIVA">Decreto: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_NORMATIVA" id="COD_NORMATIVA" value="<?php echo $COD_NORMATIVA; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese decreto supremo"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="FEC_PUBLICACION">Fecha de Publicación:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_PUBLICACION" id="FEC_PUBLICACION" style="width: 10%" value="<?php echo $FEC_PUBLICACION; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese fecha de publicación" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="IMP_NORMATIVA">Importe Decreto: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_NORMATIVA" id="IMP_NORMATIVA" value="<?php echo $IMP_NORMATIVA; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese importe del decreto"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_NORMATIVA">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_NORMATIVA('EST_NORMATIVA', $DataSet_GEN_TABLAS_1, $EST_NORMATIVA, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="USER_INSERT">: <span class="error"></span></label>
            <div class="controls">

                <input  name="USER_INSERT" id="USER_INSERT" value="<?php echo $USER_INSERT; ?>" onChange="conMayusculas(this)" maxlength="32" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="FECHA_INSERT">: <span class="error"></span></label>
            <div class="controls">

                <input  name="FECHA_INSERT" id="FECHA_INSERT" value="<?php echo $FECHA_INSERT; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="USER_UPDATE">: <span class="error"></span></label>
            <div class="controls">

                <input  name="USER_UPDATE" id="USER_UPDATE" value="<?php echo $USER_UPDATE; ?>" onChange="conMayusculas(this)" maxlength="32" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="FECHA_UPDATE">: <span class="error"></span></label>
            <div class="controls">

                <input  name="FECHA_UPDATE" id="FECHA_UPDATE" value="<?php echo $FECHA_UPDATE; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */
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
