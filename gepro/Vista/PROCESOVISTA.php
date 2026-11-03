<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROCESOVISTA de la tabla PROCESO
  //  Fecha           : jueves, 2 de noviembre de 2017 23:30:03
  //  Desde el Modelo : PDM - AMSAC
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROCESO.js"></script>    


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

                    /* EDGAR */
                    $PIDE = $lCollection->Get('PIDE');

                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido') == 'Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if (strlen($Pedido) > 0) {
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    /* EDGAR */
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
                                <li><a href="#tabs-1">Listado de Procesos de Adquisión </a></li>
                                <li><a href="#tabs-2">Detalle de Proceso de Adquisión  </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <!--<input type="hidden" name="ActionForm" value="">-->                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <!--/*EDGAR*/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                    <input type="hidden" name="PIDEbuscado" value="">
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                    <!--/*EDGAR*/-->

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   
                                        <!--ACTIVA ESTA SECCION CUANDO LA TABLA DEPENDE DE OTRA TABLA Y SE DESEA VER EL DETALLE DE LOS DATOS
                                        <table class="table table-hover table-nomargin table-bordered">
                                            <tr>
                                                <th style="width: 25%">NOMBRE DEL CERRO DE PASCO</th>
                                                <td style="width: 75%"><?php //echo $IdProveedorR;      ?></td>
                                            </tr>
                                        </table>                                
                                        -->
                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar  <?php echo ' - ' . $Pedido; ?>
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Nº Proceso', name: 'ID', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                            {display: 'Unidad Ejecutora', name: 'DES_ENTIDAD', width: GetColumnSize(16), sortable: true, align: 'left', hide: false},
                                                            {display: 'Código Proc.', name: 'PROCESO', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Descripción del proceso', name: 'DES_OBJETO', width: GetColumnSize(33), sortable: true, align: 'left', hide: false},
                                                            {display: 'Val.Referencial', name: 'IMP_VAL_REFERENCIAL', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                            {display: 'Cant.ITEM', name: 'NUM_ITEMS', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: '', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'OSCE', name: 'OSCE', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Items', name: 'Boton4', width: GetColumnSize(5), sortable: false, align: 'center'},
                                                            {display: 'Crono', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},
                                                            
                                                                    /*EDGAR*/
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center' }, <?php  } ?>
                                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(5), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(5), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php //if ($VerSeleccion <> 'SI') { 
        //if ( $PIDE == 0 ) { ?>                            {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php // } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Nº Proceso', name: 'PROCESO'},
                                                            {display: 'Unidad Ejecutora', name: 'DES_ENTIDAD'},
                                                            {display: 'Descripción del proceso', name: 'DES_OBJETO'}
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
                                            $('#mensaje')
                                                    .text('Debe Seleccionar un registro del listado')
                                                    .addClass('msjalerta')
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


    $IDE_CONVOCATORIA = $lCollection->Get('IDE_CONVOCATORIA');
    $IDE_TIPO_PROC = $lCollection->Get('IDE_TIPO_PROC');
    $IDE_PLAN = $lCollection->Get('IDE_PLAN');
    $IDE_ENTIDAD_EJECUTORA = $lCollection->Get('IDE_ENTIDAD_EJECUTORA');

    $IDE_CENCOSTO = $lCollection->Get('IDE_CENCOSTO');
    $COD_PAC = $lCollection->Get('COD_PAC');

    $DES_DEPTO_EJECUTORA = $lCollection->Get('DES_DEPTO_EJECUTORA');
    $DES_PROV_EJECUTORA = $lCollection->Get('DES_PROV_EJECUTORA');
    $DES_DIST_EJECUTORA = $lCollection->Get('DES_DIST_EJECUTORA');
    $NUM_ANO_EJE = $lCollection->Get('NUM_ANO_EJE');
    $NUM_PROC_ESPECIFICO = $lCollection->Get('NUM_PROC_ESPECIFICO');
    $DES_OBJETO = $lCollection->Get('DES_OBJETO');
    $TIP_OBJETO = $lCollection->Get('TIP_OBJETO');
    $IMP_VAL_REFERENCIAL = $lCollection->Get('IMP_VAL_REFERENCIAL');
    $DES_URL_PROCESO = $lCollection->Get('DES_URL_PROCESO');
    $EST_PROCESO = $lCollection->Get('EST_PROCESO');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


    /* EDGAR */
    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    $BIDE = $Bdescripcion = "";
    if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
        $BIDE = $lCollection->Get('BIDE');
        ;
        $Bdescripcion = $lCollection->Get('Bdescripcion');
    }
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_PROC_TIPO_1 = $lCollection->Get('DataSet_PROC_TIPO_1');


    $DataSet_PLAN_1 = $lCollection->Get('DataSet_PLAN_1');


    $DataSet_GEN_ENTIDAD_1 = $lCollection->Get('DataSet_GEN_ENTIDAD_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


    $DataSet_GEN_CENTRO_COSTO_1 = $lCollection->Get('DataSet_GEN_CENTRO_COSTO_1');



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
        /*
         $('#FechaNacimiento, #FechaHoraRegistro').datepicker({
         changeMonth: true,
         changeYear: true,
         showOn: 'button',
         maxDate: '1095',
         buttonImage: '<?php // echo RECURSOSGEN_RECURSOS  ?>/js/jquery-ui/images/calendar.gif',
         shortYearCutoff: '+100'
         });
         */
        });
        ////// para extraer datos
        function CompruebaPaseDatos()
        {
        var f = parent.document.formulario;
    //            alert('por a intervenciones' + '<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;   ?>');
        f.IDE_PROCESO_ITEM.value = '<?php echo $BIDE; ?>';
        f.BPROCESO.value = '<?php echo $Bdescripcion; ?>';
        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            CompruebaPaseDatos();
    <?php } ?>

    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <legend><?php echo $TitulFormulario; ?></legend>  



        <div class="control-group">
            <label class="control-label" for="IDE_CONVOCATORIA">Código Proceso: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_CONVOCATORIA" id="IDE_CONVOCATORIA" value="<?php echo $SeleccionarID; ?>" class="required integer" onChange="conMayusculas(this)" maxlength="10" type="text" data-trigger="hover" data-content="Ingrese el número de proceso o convocatoria" style='width:14.5%;' />
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="IDE_TIPO_PROC">Tipo de Proceso:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_TIPO_PROC('IDE_TIPO_PROC', $DataSet_PROC_TIPO_1, $IDE_TIPO_PROC, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						

        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PLAN">Plan:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboIDE_PLAN('IDE_PLAN', $DataSet_PLAN_1, $IDE_PLAN, 1, "") ?>				
            </div>
        </div>  



        <div class="control-group">
            <label class="control-label" for="IDE_ENTIDAD_EJECUTORA">Unidad Ejecutora:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_ENTIDAD_EJECUTORA('IDE_ENTIDAD_EJECUTORA', $DataSet_GEN_ENTIDAD_1, $IDE_ENTIDAD_EJECUTORA, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_CENCOSTO">Centro de Costo:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboIDE_CENCOSTO('IDE_CENCOSTO', $DataSet_GEN_CENTRO_COSTO_1, $IDE_CENCOSTO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="COD_PAC">Código PAC: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_PAC" id="COD_PAC" value="<?php echo $COD_PAC; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class=" required show-popover"  data-trigger="hover" data-content="Ingrese el Código PAC" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_DEPTO_EJECUTORA">Departamento: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_DEPTO_EJECUTORA" id="DES_DEPTO_EJECUTORA" value="<?php echo $DES_DEPTO_EJECUTORA; ?>" class="required alphanumeric" onChange="conMayusculas(this)" maxlength="100" type="text" data-trigger="hover" data-content="Ingrese el nombre del departamento"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_PROV_EJECUTORA">Provincia: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_PROV_EJECUTORA" id="DES_PROV_EJECUTORA" value="<?php echo $DES_PROV_EJECUTORA; ?>" class="required alphanumeric" onChange="conMayusculas(this)" maxlength="100" type="text" data-trigger="hover" data-content="Ingreso el nombre de la provincia"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_DIST_EJECUTORA">Distrito: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_DIST_EJECUTORA" id="DES_DIST_EJECUTORA" value="<?php echo $DES_DIST_EJECUTORA; ?>" class="required alphanumeric" onChange="conMayusculas(this)" maxlength="100" type="text" data-trigger="hover" data-content="Ingrese el nombre del distrito"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="NUM_ANO_EJE">Año de Ejecución: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_ANO_EJE" id="NUM_ANO_EJE" value="<?php echo $NUM_ANO_EJE; ?>" class="required integer" onChange="conMayusculas(this)" maxlength="10" type="text" data-trigger="hover" data-content="Ingresel el año de ejecución del proceso" style='width:14.5%;' />
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="NUM_PROC_ESPECIFICO">Nº de Proceso: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_PROC_ESPECIFICO" id="NUM_PROC_ESPECIFICO" class="required alphanumeric" value="<?php echo $NUM_PROC_ESPECIFICO; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" data-trigger="hover" data-content="Ingrese especifico del proceso Ejem: 41-2017-MINAGRI/AGRORUR-1" style='width:14.5%;' />
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_OBJETO">Objeto de Contratación: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_OBJETO" id="DES_OBJETO" rows="5" class="required alphanumeric" onChange="conMayusculas(this)" maxlength="1000" data-trigger="hover" data-content="Ingrese el objeto de contratación" ><?php echo $DES_OBJETO; ?></textarea>

            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="TIP_OBJETO">Tipo de Objeto:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_OBJETO('TIP_OBJETO', $DataSet_GEN_TABLAS_1, $TIP_OBJETO, 1, "") ?>				
            </div>
        </div>  						

        <div class="control-group">
            <label class="control-label" for="IMP_VAL_REFERENCIAL">Valor Referencial: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_VAL_REFERENCIAL" id="IMP_VAL_REFERENCIAL" value="<?php echo $IMP_VAL_REFERENCIAL; ?>" class="required number" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ingrese el valor referencial" style='width:14.5%;' />
            </div>
        </div>								

        <div class="control-group"  style="display:none">
            <label class="control-label" for="DES_URL_PROCESO">URL: <span class="error"></span></label>
            <div class="controls">
                <input name="DES_URL_PROCESO" id="DES_URL_PROCESO" value="<?php echo $DES_URL_PROCESO; ?>" class="" onChange="conMayusculas(this)" maxlength="500" type="text" data-trigger="hover" data-content="Ingrese el dirección URL del proceso"/>
            </div>
        </div>												

        <div class="control-group">
            <label class="control-label" for="EST_PROCESO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROCESO('EST_PROCESO', $DataSet_GEN_TABLAS_2, $EST_PROCESO, 1, "") ?>				
            </div>
        </div>  						

 

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_TIPO_PROC($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de proceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_TIPO_PROC > 0)) {
                if ($lstDatos[$i]->IDE_TIPO_PROC == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_TIPO_PROC . "\" selected=\"selected\">" . $lstDatos[$i]->TIPO_PROC . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_TIPO_PROC . "\">" . $lstDatos[$i]->TIPO_PROC . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Plan" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_PLAN > 0)) {
                if ($lstDatos[$i]->IDE_PLAN == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PLAN . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PLAN . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PLAN . "\">" . $lstDatos[$i]->DES_PLAN . "</option>\n\r";
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
    <select data-trigger="hover" data-content="Seleccion la Unidad Ejecutora" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_OBJETO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese el tipo de objeto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_PROCESO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciona el estado del proceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_CENCOSTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccion el Centro de Costo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_CENCOSTO > 0)) {
                if ($lstDatos[$i]->IDE_CENCOSTO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CENCOSTO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CENCOSTO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CENCOSTO . "\">" . $lstDatos[$i]->DES_CENCOSTO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
        <?php
    }

    /*	*/