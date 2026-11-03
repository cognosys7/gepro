<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA
  
  //  Propósito       : PLAN_GESTION_TRANSFERENCIAVISTA de la tabla PLAN_GESTION_TRANSFERENCIA
  //  Fecha           : lunes, 09 de julio de 2018 11:06:54 a.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PLAN_GESTION_TRANSFERENCIA.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

<!--/***EDGAR---**************/--> 
    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />
<!--/***EDGAR---**************/--> 

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
                                <li><a href="#tabs-1">Listado de  </a></li>
                                <li><a href="#tabs-2">Detalle de  </a></li>
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
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fecha Formulación', name: 'FechaFormulacion', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cód. Trámite', name: 'CodigoTramite', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Decreto Supremo', name: 'DecretoSupremo', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Monto Total', name: 'MontoTotal', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Observación', name: 'Observacion', width: GetColumnSize(37), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Proyecto', name: 'Boton4', width: GetColumnSize(6), sortable: false, align: 'center'},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'}
                                                                    ,{display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Cód. Trámite', name: 'CodigoTramite'},
                                                                    {display: 'Estado', name: 'Estado'}
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
                                              }
                                                else if (com == 'Salir')
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


                $IDE_PLAN_GESTION_TRANS = $lCollection->Get('IDE_PLAN_GESTION_TRANS');
                $IDE_NORMATIVA = $lCollection->Get('IDE_NORMATIVA');
                $FEC_FORMULACION = $lCollection->Get('FEC_FORMULACION');
                $COD_TRAMITE = $lCollection->Get('COD_TRAMITE');
                $IMP_TOTAL = $lCollection->Get('IMP_TOTAL');
                $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
                $EST_SOLICITUD = $lCollection->Get('EST_SOLICITUD');
                $EST_PLAN_GESTION_TRANS = $lCollection->Get('EST_PLAN_GESTION_TRANS');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_NORMATIVA_1 = $lCollection->Get('DataSet_GEN_NORMATIVA_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar "; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de "; //Nombre de la Tabla
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


            $('#FEC_FORMULACION').datepicker({
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
            <label class="control-label" for="IDE_PLAN_GESTION_TRANS">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PLAN_GESTION_TRANS" id="IDE_PLAN_GESTION_TRANS" value="<?php echo $IDE_PLAN_GESTION_TRANS; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="FEC_FORMULACION">Fecha Formulación:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_FORMULACION" id="FEC_FORMULACION" style="width: 10%" value="<?php echo $FEC_FORMULACION; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Formulación" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="COD_TRAMITE">Codigo Trámite: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_TRAMITE" id="COD_TRAMITE" value="<?php echo $COD_TRAMITE; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Codigo Trámite"/>					
            </div>
        </div>								



        <div class="control-group">
            <label class="control-label" for="IDE_NORMATIVA">Decreto Supremo:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_NORMATIVA('IDE_NORMATIVA', $DataSet_GEN_NORMATIVA_1, $IDE_NORMATIVA, 1, "") ?>				
            </div>
        </div> 
        
        
        <div class="control-group" >
            <label class="control-label" for="IMP_TOTAL">Monto Total: <span class="error"></span></label>
            <div class="controls">

                <input disabled <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IMP_TOTAL" id="IMP_TOTAL" value="<?php echo $IMP_TOTAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Monto Total"/>

            </div>
        </div>												


        <div class="control-group">
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Observación" ><?php echo $DES_OBSERVACION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_SOLICITUD">Estado de Solicitud:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_SOLICITUD('EST_SOLICITUD', $DataSet_GEN_TABLAS_1, $EST_SOLICITUD, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="EST_PLAN_GESTION_TRANS">Estado Registro:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_PLAN_GESTION_TRANS('EST_PLAN_GESTION_TRANS', $DataSet_GEN_TABLAS_2, $EST_PLAN_GESTION_TRANS, 1, "") ?>				
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

function comboIDE_NORMATIVA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Decreto Supremo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_NORMATIVA > 0)) {
            if ($lstDatos[$i]->IDE_NORMATIVA == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_NORMATIVA . "\" selected=\"selected\">" . $lstDatos[$i]->COD_NORMATIVA . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_NORMATIVA . "\">" . $lstDatos[$i]->COD_NORMATIVA . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    function comboEST_SOLICITUD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Estado de Solicitud" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_PLAN_GESTION_TRANS($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado Registro" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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