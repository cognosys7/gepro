<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PLANVISTA de la tabla PLAN
  //  Fecha           : viernes, 5 de enero de 2018 14:49:52
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PLAN.js"></script>    


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
                                <li><a href="#tabs-1">Listado de PLANES DE PROYECTOS / ACTIVIDADES </a></li>
                                <li><a href="#tabs-2">Detalle de PLANES DE PROYECTOS / ACTIVIDADES </a></li>
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
                                                                    {display: 'Cód. Plan', name: 'CodPlan', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Descripción del Plan', name: 'DescripcionPlan', width: GetColumnSize(22.4), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo de Plan', name: 'TipoPlan', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fecha Aprobación', name: 'FecAprobacionDir', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Monto Aprobado', name: 'MontoAprobado', width: GetColumnSize(8), sortable: true, align: 'right', hide: false},
                                                                    {display: 'Intervención', name: 'Intervencion', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Entidad Solicitante', name: 'EntidadSolicitante', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo de Fuente', name: 'TipoFuente', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Estado', name: 'EstadoPlan', width: GetColumnSize(7), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Transferencias', name: 'Boton4', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Proyectos', name: 'Boton5', width: GetColumnSize(6), sortable: false, align: 'center'},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Cód. Plan', name: 'CodPlan'},
                                                                    {display: 'Descripción del Plan', name: 'DescripcionPlan'},
                                                                    {display: 'Tipo de Plan', name: 'TipoPlan'},
                                                                    {display: 'Intervención', name: 'Intervencion'},
                                                                    {display: 'Entidad Solicitante', name: 'EntidadSolicitante'},
                                                                    {display: 'Tipo de Fuente', name: 'TipoFuente'},
                                                                    {display: 'Estado', name: 'EstadoPlan'}
                                                                ],

                                                                sortname: "CodPlan",
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


                $IDE_PLAN = $lCollection->Get('IDE_PLAN');
                $IDE_DIRECTORIO = $lCollection->Get('IDE_DIRECTORIO');
                $IDE_ENTIDAD_SOLICITANTE = $lCollection->Get('IDE_ENTIDAD_SOLICITANTE');
                $IDE_ENTIDAD_EJECUTORA = $lCollection->Get('IDE_ENTIDAD_EJECUTORA');
                $IDE_INTERVENCION = $lCollection->Get('IDE_INTERVENCION');
                $TIP_PLAN = $lCollection->Get('TIP_PLAN');
                $COD_PLAN = $lCollection->Get('COD_PLAN');
                $DES_PLAN = $lCollection->Get('DES_PLAN');
                $TIP_FUENTE = $lCollection->Get('TIP_FUENTE');
                $IMP_APROBADO = $lCollection->Get('IMP_APROBADO');
                $TIP_GASTO = $lCollection->Get('TIP_GASTO');
                $EST_PLAN = $lCollection->Get('EST_PLAN');
                $DES_ALCANCE = $lCollection->Get('DES_ALCANCE');
                $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
                $FEC_OBSERVACION = $lCollection->Get('FEC_OBSERVACION');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_DIRECTORIO_1 = $lCollection->Get('DataSet_GEN_DIRECTORIO_1');


                $DataSet_GEN_ENTIDAD_1 = $lCollection->Get('DataSet_GEN_ENTIDAD_1');


                $DataSet_GEN_ENTIDAD_2 = $lCollection->Get('DataSet_GEN_ENTIDAD_2');


                $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


                $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar PLANES DE PROYECTOS / ACTIVIDADES"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de PLANES DE PROYECTOS / ACTIVIDADES"; //Nombre de la Tabla
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


            $('#FEC_OBSERVACION').datepicker({
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
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  





        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PLAN">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PLAN" id="IDE_PLAN" value="<?php echo $IDE_PLAN; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="IDE_DIRECTORIO">Nro Directorio:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_DIRECTORIO('IDE_DIRECTORIO', $DataSet_GEN_DIRECTORIO_1, $IDE_DIRECTORIO, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_ENTIDAD_SOLICITANTE">Entidad Solicitante:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_ENTIDAD_SOLICITANTE('IDE_ENTIDAD_SOLICITANTE', $DataSet_GEN_ENTIDAD_1, $IDE_ENTIDAD_SOLICITANTE, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_ENTIDAD_EJECUTORA">Entidad Ejecutora:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_ENTIDAD_EJECUTORA('IDE_ENTIDAD_EJECUTORA', $DataSet_GEN_ENTIDAD_2, $IDE_ENTIDAD_EJECUTORA, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_INTERVENCION">Intervención:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_INTERVENCION('IDE_INTERVENCION', $DataSet_GEN_INTERVENCION_1, $IDE_INTERVENCION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_PLAN">Tipo de Plan:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_PLAN('TIP_PLAN', $DataSet_GEN_TABLAS_1, $TIP_PLAN, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="COD_PLAN">Código de Plan: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_PLAN" id="COD_PLAN" value="<?php echo $COD_PLAN; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el código de plan"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_PLAN">Descripción del Plan: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_PLAN" id="DES_PLAN" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la Descripción del Plan" ><?php echo $DES_PLAN; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="TIP_FUENTE">Tipo de Fuente:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_FUENTE('TIP_FUENTE', $DataSet_GEN_TABLAS_2, $TIP_FUENTE, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IMP_APROBADO">Importe Aprobado: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_APROBADO" id="IMP_APROBADO" value="<?php echo $IMP_APROBADO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el Importe Aprobado"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="TIP_GASTO">Tipo de Gasto:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_GASTO('TIP_GASTO', $DataSet_GEN_TABLAS_3, $TIP_GASTO, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="EST_PLAN">Estado del  Plan:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_PLAN('EST_PLAN', $DataSet_GEN_TABLAS_4, $EST_PLAN, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_ALCANCE">Alcance: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_ALCANCE" id="DES_ALCANCE" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese el Alcance" ><?php echo $DES_ALCANCE; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese la Observación" ><?php echo $DES_OBSERVACION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_OBSERVACION">Fecha de Observación:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_OBSERVACION" id="FEC_OBSERVACION" style="width: 10%" value="<?php echo $FEC_OBSERVACION; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese la Fecha de Observación" placeholder="DD/MM/YYYY"/>					
                </div>
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

function comboIDE_DIRECTORIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Nro Directorio" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_DIRECTORIO > 0)) {
            if ($lstDatos[$i]->IDE_DIRECTORIO == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_DIRECTORIO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_DIRECTORIO . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_DIRECTORIO . "\">" . $lstDatos[$i]->DES_DIRECTORIO . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    function comboIDE_ENTIDAD_SOLICITANTE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione la Entidad Solicitante" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_ENTIDAD_EJECUTORA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciones la Entidad Ejecutora" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciones la Intervención" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Selecciones el Tipo de Plan" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_FUENTE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione el Tipo de Fuente" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_GASTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione el Tipo de Gasto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione el Estado del  Plan" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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