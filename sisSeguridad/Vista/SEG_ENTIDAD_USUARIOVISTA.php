<?php

require_once("mensajes.php");

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
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/SEG_ENTIDAD_USUARIO.js"></script>
        
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
                $("#tabs").tabs({active: 0});
                $("#tabs").tabs({disabled: [1]});
            });
            function CallFlexiGrid()
            {
                $('#flex1').flexReload();
            }
        </script>
    <div id="Mensajes"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {
                    $PIDE_USUARIO = $lCollection->Get('PIDE_USUARIO');
                    ?>
                    <div class="box-content">
<!--                        <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                            <tr>
                                <td style="text-align: left; width: 80%;">
                                </td>
                                <td style="text-align: right; width: 20%;">
                                    Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                                </td>
                            </tr>
                        </table>-->

                        <div id="tabs">
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                            <ul>
                                <li><a href="#tabs-1">LISTADO DE UNIDADES EJECUTORAS ASIGNADOS </a></li>
                                <li><a href="#tabs-2">DETALLE DE UNIDADES EJECUTORAS ASIGNADOS </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">                                
                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">
                                    <input type="hidden" name="PIDE_USUARIO" value="<?php echo $PIDE_USUARIO; ?>">
                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar 
                                        </div>
                                        <div id="datos">
                                            <table id="flex1" style="display:none">                                        
                                            </table>
                                        </div>                                        
                                        <script type="text/javascript">
                                            $("#flex1").flexigrid
                                                    (
                                                            {
                                                                /*Pagina php donde se realiza la consulta sql */   													                                                                
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonList&PIDE_USUARIO=<?php echo $PIDE_USUARIO; ?>',
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Unidad Ejecutora', name: 'UnidadEjecutora', width: GetColumnSize(40), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo de Acceso', name: 'TipoAcceso', width: GetColumnSize(27.8), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(12), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(8), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(8), sortable: false, align: 'center'}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Unidad Ejecutora', name: 'UnidadEjecutora'}
                                                                ],

                                                                sortname: "Id",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false
                                                                //,title: 'Listado de Personas'
                                                                //,showTableToggleBtn: true
                                                            }
                                                    );
                                            /* Debe seleccionar una fila antes de pulsar el boton */
                                            function test(com, grid)
                                            {
                                                var nId = $('.trSelected', grid).children('td:eq(0)').text();
                                                if (com == 'Nuevo')
                                                {
                                                    Nuevo('<?php echo $PaginaFormulario ?>');
                                                } else if (com == 'Salir')
                                                {
                                                    cerrarPopup()
                                                } else
                                                {
                                                    $('#mensaje').text('Debe Seleccionar un registro del listado').addClass('msjalerta')
                                                }
                                            }
                                        </script>
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


    $IDE_ENTIDAD_USUARIO = $lCollection->Get('IDE_ENTIDAD_USUARIO');
    $IDUSUARIO = $lCollection->Get('IDUSUARIO');
    $IDE_ENTIDAD = $lCollection->Get('IDE_ENTIDAD');
    $TIP_ACCESO = $lCollection->Get('TIP_ACCESO');
    $EST_ENTIDAD_USUARIO = $lCollection->Get('EST_ENTIDAD_USUARIO');
    $PIDE_USUARIO = $lCollection->Get('PIDE_USUARIO');

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */
    $DataSet_tsusuario_1 = $lCollection->Get('DataSet_tsusuario_1');
    $DataSet_GEN_ENTIDAD_1 = $lCollection->Get('DataSet_GEN_ENTIDAD_1');
    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');
    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');
    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar ACCESO A LAS UNIDADES EJECUTORAS"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de ACCESO A LAS UNIDADES EJECUTORAS"; //Nombre de la Tabla
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
                    AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                }
            });
            //ACTIVAR PARA TRABAJAR CON FECHAS
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
        <input type="hidden" name="IDE_ENTIDAD_USUARIO" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="IDUSUARIO" value="<?php echo $PIDE_USUARIO ?>">
        <legend><?php echo $TitulFormulario; ?></legend> 
        <div class="control-group">
            <label class="control-label" for="IDE_ENTIDAD">Unidad Ejecutora:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_ENTIDAD('IDE_ENTIDAD', $DataSet_GEN_ENTIDAD_1, $IDE_ENTIDAD, 1, "") ?>				
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="TIP_ACCESO">Tipo de Acceso:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_ACCESO('TIP_ACCESO', $DataSet_GEN_TABLAS_1, $TIP_ACCESO, 1, "") ?>				
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="EST_ENTIDAD_USUARIO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_ENTIDAD_USUARIO('EST_ENTIDAD_USUARIO', $DataSet_GEN_TABLAS_2, $EST_ENTIDAD_USUARIO, 1, "") ?>				
            </div>
        </div>
        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>
    <?php
}
/*************************************************************************************************
* (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
************************************************************************************************/
function comboIDUSUARIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el nombre del usuario" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->idusuario > 0)) {
                if ($lstDatos[$i]->idusuario == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->idusuario . "\" selected=\"selected\">" . $lstDatos[$i]->usunombre . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->idusuario . "\">" . $lstDatos[$i]->usunombre . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}
function comboIDE_ENTIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la unidad ejecutora" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_ENTIDAD > 0)) {
                if ($lstDatos[$i]->IDE_ENTIDAD == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ENTIDAD . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ENTIDAD . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ENTIDAD . "\">" . $lstDatos[$i]->DES_ENTIDAD . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

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

function comboEST_ENTIDAD_USUARIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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