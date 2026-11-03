<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_RECURSOVISTA de la tabla GEN_RECURSO
  //  Fecha           : martes, 16 de enero de 2018 12:58:57 p.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_RECURSO.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>


    <!--/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION *****/--> 
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/include/Comun.js"></script> 
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

                    /*                     * *EDGAR---************* */
                    $FormularioTipo = $FormularioAccion = $FormularioTipo2 = '';

                    $Pedido = $lCollection->Get('Pedido');
                    if (strlen($Pedido) > 0) {
                        $FormularioTipo = $Pedido;
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = true;
                    } else {
                        $FormularioTipo2 = 'Mantenimiento';
                        $VerSeleccion = false;
                    }
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    /*                     * *EDGAR---************* */
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
                                <li><a href="#tabs-1">Listado de Recursos  <?php echo $Pedido; ?></a></li>
                                <li><a href="#tabs-2">Detalle de Recursos </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <!--/***EDGAR---**************/-->
                                    <!--<input type="hidden" name="ActionForm" value="">-->
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                    <input type="hidden" name="PIDE_RECURSO" value="">
                                    <!--/***EDGAR---**************/-->
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar 
                                            <?php echo $FormularioTipo . '-' . $FormularioTipo2; ?>
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&Pedido=<?php echo $Pedido; ?>', /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Nº', name: 'NFILA', width: GetColumnSize(5), sortable: true, align: 'center', hide: true},
                                                            {display: 'Tipo de Recursos', name: 'TIPO_RECURSO', width: GetColumnSize(18), sortable: true, align: 'left', hide: false},
                                                            {display: 'Sede Ejecutora', name: 'ENTIDAD', width: GetColumnSize(23), sortable: true, align: 'left', hide: false},
                                                            {display: 'Nombre del Recurso', name: 'NOMBRE_RECURSO', width: GetColumnSize(38), sortable: true, align: 'left', hide: false},
//                                                            {display: 'Código', name: 'COD_RECURSO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'EST_RECURSO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    /*EDGAR*/
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/

                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php if ($FormularioTipo == 'Mantenimiento') { ?>                    {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Nombre del Recurso', name: 'NOMBRE_RECURSO'},
                                                            {display: 'Tipo de Recursos', name: 'TIPO_RECURSO'},
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


    $IDE_RECURSO = $lCollection->Get('IDE_RECURSO');
    $IDE_ENTIDAD = $lCollection->Get('IDE_ENTIDAD');
    $TIP_RECURSO = $lCollection->Get('TIP_RECURSO');
    $COD_RECURSO = $lCollection->Get('COD_RECURSO');
    $DES_RECURSO = $lCollection->Get('DES_RECURSO');
    $EST_RECURSO = $lCollection->Get('EST_RECURSO');


    /* EDGAR */
//    $BIDE = $lCollection->Get('BIDE');//IDE_RECURSO
//    $Bdescripcion = $lCollection->Get('Bdescripcion');

    $PIDE_RECURSO = $lCollection->Get('PIDE_RECURSO');
    $BIDE = $Bdescripcion = "";
    if ($PIDE_RECURSO > 0) {  //echo 'es un echo';exit;
        $BIDE = $lCollection->Get('BIDE');
        ;
        $Bdescripcion = $lCollection->Get('Bdescripcion');
    }
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');   
    //echo 'entre'; die;
    /* EDGAR */


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_ENTIDAD_1 = $lCollection->Get('DataSet_GEN_ENTIDAD_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');

    /*     * *EDGAR---************* */
    $DESCRIPCION_ENTIDAD_SOLICITANTE = $lCollection->Get('DESCRIPCION_ENTIDAD_SOLICITANTE');
    /*     * *EDGAR---************* */


    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Recursos"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Recursos"; //Nombre de la Tabla
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
        function CompruebaPaseDatos()
        {
        var f = parent.document.formulario;
    //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;   ?>');
        f.DESCRIPCIONRECURSO.value = '<?php echo $Bdescripcion; ?>';
        f.IDE_RECURSO.value = '<?php echo $BIDE; ?>';
        parent.$.colorbox.close();
        }
    <?php
    if ($PIDE_RECURSO > 0) { //echo 'entre ps';
        ?>
            CompruebaPaseDatos();
        <?php
    }
    ?>
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/***EDGAR---******************/-->
        <input type="hidden" name="btnUnidadEjecutora" value="">
        <input type="hidden" name="varBotonInvocador" value="">
        <!--/***EDGAR---************** **/--> 

        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group" >
            <label class="control-label" for="IDE_ENTIDAD">Sede Ejecutora:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_ENTIDAD('IDE_ENTIDAD', $DataSet_GEN_ENTIDAD_1, $IDE_ENTIDAD, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  



        <div class="control-group">
            <label class="control-label" for="TIP_RECURSO">Tipo de Recurso:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_RECURSO('TIP_RECURSO', $DataSet_GEN_TABLAS_1, $TIP_RECURSO, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="COD_RECURSO">Código del Recurso: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_RECURSO" id="COD_RECURSO" value="<?php echo $COD_RECURSO; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric  show-popover"  data-trigger="hover" data-content="Ingrese el código de recurso" />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_RECURSO">Nombre o Descripción : <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_RECURSO" id="DES_RECURSO" value="<?php echo $DES_RECURSO; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese le nombre o descripción del recurso"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_RECURSO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_RECURSO('EST_RECURSO', $DataSet_GEN_TABLAS_2, $EST_RECURSO, 1, "") ?>				
            </div>
        </div>  						


  

        <?php echo $crudGrabarCancelar; ?>

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_ENTIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la Unidad ejecutora del recurso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_RECURSO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de recurso " id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_RECURSO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del recurso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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
