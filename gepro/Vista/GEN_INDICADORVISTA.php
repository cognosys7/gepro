<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_INDICADORVISTA de la tabla GEN_INDICADOR
  //  Fecha           : miércoles, 03 de enero de 2018 05:08:35 p.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_INDICADOR.js"></script>    


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

    </script>
    <div id="Mensajes"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    ?>
                    <div class="box-content">
                        <!--
        <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
        <tr>
        <td style="text-align: left; width: 80%;">
        </td>
        <td style="text-align: right; width: 20%;">
        Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
        </td>
        </tr>
        </table>
                        -->
                        <div id="tabs">
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                            <ul>
                                <li><a href="#tabs-1">Listado de Indicadores </a></li>
                                <li><a href="#tabs-2">Detalle de Indicadores </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

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
                                                                /*Pagina php donde se realiza la consulta sql */   													url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList', /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Código', name: 'ID', width: GetColumnSize(5), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fase', name: 'DES_INTERVENCION', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Nombre del Indicador', name: 'DES_INDICADOR', width: GetColumnSize(20), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo de Indicador', name: 'TIPO_INDICADOR', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Periodo de Prog.', name: 'PERIODO_PROGRAMACION', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Periodo de Ejec.', name: 'PERIODO_EJECUCION', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Unid. Med.', name: 'DES_UNIDAD_MEDIDA', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    //{separator: true},
                                                                    //{name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Nombre del Indicador', name: 'DES_INDICADOR'}
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


                $IDE_INDICADOR = $lCollection->Get('IDE_INDICADOR');
                $IDE_INTERVENCION = $lCollection->Get('IDE_INTERVENCION');
                $DES_INDICADOR = $lCollection->Get('DES_INDICADOR');
                $TIP_INDICADOR = $lCollection->Get('TIP_INDICADOR');
                $TIP_PRIORIDAD = $lCollection->Get('TIP_PRIORIDAD');
                $TIP_PERIODO_PROGRAMACION = $lCollection->Get('TIP_PERIODO_PROGRAMACION');
                $TIP_PERIODO_EJECUCION = $lCollection->Get('TIP_PERIODO_EJECUCION');
                $DES_UNIDAD_MEDIDA = $lCollection->Get('DES_UNIDAD_MEDIDA');
                $EST_INDICADOR = $lCollection->Get('EST_INDICADOR');


    /* EDGAR */
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */


                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


                $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');


                $DataSet_GEN_TABLAS_5 = $lCollection->Get('DataSet_GEN_TABLAS_5');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Indicadores"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Indicadores"; //Nombre de la Tabla
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

        <legend><?php echo $TitulFormulario; ?></legend>  




        <?php        
        if(strlen($SeleccionarID) > 0)
        {
        ?>
        <div class="control-group" >
            <label class="control-label" for="IDE_INDICADOR">Código: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IDE_INDICADOR" id="IDE_INDICADOR" value="<?php echo $SeleccionarID; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content="Ingrese el Código"/>

            </div>
        </div>												
        
            <?php }?>

        <div class="control-group">
            <label class="control-label" for="IDE_INTERVENCION">Fase:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_INTERVENCION('IDE_INTERVENCION', $DataSet_GEN_INTERVENCION_1, $IDE_INTERVENCION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_INDICADOR">Nombre del Indicador: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_INDICADOR" id="DES_INDICADOR" value="<?php echo $DES_INDICADOR; ?>" onChange="conMayusculas(this)" maxlength="80" type="text" class="required show-popover"  data-trigger="hover" data-content="Ingrese el nombre del indicador"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="TIP_INDICADOR">Tipo de Indicador:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_INDICADOR('TIP_INDICADOR', $DataSet_GEN_TABLAS_1, $TIP_INDICADOR, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_PRIORIDAD">Prioridad del Indicador:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_PRIORIDAD('TIP_PRIORIDAD', $DataSet_GEN_TABLAS_2, $TIP_PRIORIDAD, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_PERIODO_PROGRAMACION">Periodo de Program.:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_PERIODO_PROGRAMACION('TIP_PERIODO_PROGRAMACION', $DataSet_GEN_TABLAS_3, $TIP_PERIODO_PROGRAMACION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_PERIODO_EJECUCION">Periodo de Ejecución:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_PERIODO_EJECUCION('TIP_PERIODO_EJECUCION', $DataSet_GEN_TABLAS_4, $TIP_PERIODO_EJECUCION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_UNIDAD_MEDIDA">Unidad de Medida: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_UNIDAD_MEDIDA" id="DES_UNIDAD_MEDIDA" value="<?php echo $DES_UNIDAD_MEDIDA; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="required show-popover"  data-trigger="hover" data-content="Seleccione la unidad de medida" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_INDICADOR">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_INDICADOR('EST_INDICADOR', $DataSet_GEN_TABLAS_5, $EST_INDICADOR, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciona el tipo de intervencion" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_INTERVENCION > 0)) {
            if ($lstDatos[$i]->IDE_INTERVENCION == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_INTERVENCION . "\" selected=\"selected\">" . $lstDatos[$i]->DES_INTERVENCION . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_INTERVENCION . "\">" . $lstDatos[$i]->DES_INTERVENCION . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
    <?php
}

function comboTIP_INDICADOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de indicador" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_PRIORIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la prioridad del indicador" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_PERIODO_PROGRAMACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione el periodo de programación" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_PERIODO_EJECUCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione el periodo de ejecución" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_INDICADOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del indicador" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    /*	*/