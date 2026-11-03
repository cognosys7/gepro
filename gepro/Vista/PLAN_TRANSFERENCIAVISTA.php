<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PLAN_TRANSFERENCIAVISTA de la tabla PLAN_TRANSFERENCIA
  //  Fecha           : viernes, 5 de enero de 2018 22:58:17
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PLAN_TRANSFERENCIA.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

<!--/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION *****/--> 
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


                    $PIDE_PLAN = $lCollection->Get('PIDE_PLAN');
                    $VCOD_PLAN = $lCollection->Get('VCOD_PLAN');
                    $VDES_PLAN = $lCollection->Get('VDES_PLAN');
                    $VIMP_APROBADO = $lCollection->Get('VIMP_APROBADO');


                    $DatosPadre = '<table>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 20%">Código Plan:</th>';
                    $DatosPadre .= '<td style="width: 80%"> ' . $VCOD_PLAN . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 20%">Descripción Plan:</th>';
                    $DatosPadre .= '<td style="width: 80%"> ' . $VDES_PLAN . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 20%">Importe Aprobado:</th>';
                    $DatosPadre .= '<td style="width: 80%"> ' . $VIMP_APROBADO . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '</table>';
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
                                <li><a href="#tabs-1">Listado de TRANSFERENCIAS DEL PLAN </a></li>
                                <li><a href="#tabs-2">Detalle de TRANSFERENCIAS DEL PLAN </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    


                                    <input type="hidden" name="PIDE_PLAN" value="<?php echo $PIDE_PLAN; ?>">    


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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PLAN=<?php echo $PIDE_PLAN; ?>',

                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Cód.Plan', name: 'CodPlan', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Tipo de Plan', name: 'TipoPlan', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Descripción del Plan', name: 'DescripcionPlan', width: GetColumnSize(30.1), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Importe Aprobado', name: 'ImporteAprobado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Decreto', name: 'Decreto', width: GetColumnSize(12), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Importe Transferido', name: 'ImporteTransferido', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'EstadoTransferencia', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Intervención', name: 'Boton5', width: GetColumnSize(5), sortable: false, align: 'center'},
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
                                                                    {display: 'Cód.Plan', name: 'CodPlan'},
                                                                    {display: 'Decreto', name: 'Decreto'}
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

                                                                , title: '<?php // echo $DatosPadre; ?>'


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


                $IDE_TRANSFERENCIA = $lCollection->Get('IDE_TRANSFERENCIA');
                $IDE_PLAN = $lCollection->Get('IDE_PLAN');
                $IDE_NORMATIVA = $lCollection->Get('IDE_NORMATIVA');
                $IMP_TRANSFERIDO = $lCollection->Get('IMP_TRANSFERIDO');
                $DES_ALCANCE = $lCollection->Get('DES_ALCANCE');
                $EST_TRANSFERENCIA = $lCollection->Get('EST_TRANSFERENCIA');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');



                $PIDE_PLAN = $lCollection->Get('PIDE_PLAN');
                $VCOD_PLAN = $lCollection->Get('VCOD_PLAN');
                $VDES_PLAN = $lCollection->Get('VDES_PLAN');
                $VIMP_APROBADO = $lCollection->Get('VIMP_APROBADO');


                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_NORMATIVA_1 = $lCollection->Get('DataSet_GEN_NORMATIVA_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar TRANSFERENCIAS DEL PLAN"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de TRANSFERENCIAS DEL PLAN"; //Nombre de la Tabla
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


        <input type="hidden" name="PIDE_PLAN" value="<?php echo $PIDE_PLAN ?>">


        <legend><?php echo $TitulFormulario; ?></legend>  



        <div class="control-group" style="display:none">	
            <label class="control-label" for="COD_PLAN">Código Plan: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="COD_PLAN" id="COD_PLAN" value="<?php echo $VCOD_PLAN; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none">	
            <label class="control-label" for="DES_PLAN">Descripción Plan: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_PLAN" id="DES_PLAN" value="<?php echo $VDES_PLAN; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none">	
            <label class="control-label" for="IMP_APROBADO">Importe Aprobado: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_APROBADO" id="IMP_APROBADO" value="<?php echo $VIMP_APROBADO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   





        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_TRANSFERENCIA">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_TRANSFERENCIA" id="IDE_TRANSFERENCIA" value="<?php echo $IDE_TRANSFERENCIA; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PLAN">IdePlan: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PLAN" id="IDE_PLAN" value="<?php echo $IDE_PLAN; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="IDE_NORMATIVA">Decreto:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIDE_NORMATIVA('IDE_NORMATIVA', $DataSet_GEN_NORMATIVA_1, $IDE_NORMATIVA, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IMP_TRANSFERIDO">Importe Transferido: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_TRANSFERIDO" id="IMP_TRANSFERIDO" value="<?php echo $IMP_TRANSFERIDO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese el Monto Transferido"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ALCANCE">Alcance: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_ALCANCE" id="DES_ALCANCE" value="<?php echo $DES_ALCANCE; ?>" onChange="conMayusculas(this)" maxlength="1000" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese el Alcance"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_TRANSFERENCIA">Estado:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboEST_TRANSFERENCIA('EST_TRANSFERENCIA', $DataSet_GEN_TABLAS_1, $EST_TRANSFERENCIA, 1, "") ?>				
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

function comboIDE_NORMATIVA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Decreto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_TRANSFERENCIA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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