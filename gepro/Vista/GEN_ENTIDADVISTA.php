<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ENTIDADVISTA de la tabla GEN_ENTIDAD
  //  Fecha           : miércoles, 1 de noviembre de 2017 15:50:32
  //  Desde el Modelo : PDM AMSAC
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_ENTIDAD.js"></script>    


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
                                <li><a href="#tabs-1">Listado de Sedes Ejecutoras</a></li>
                                <li><a href="#tabs-2">Detalle de Sede Ejecutora</a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <!--<input type="hidden" name="ActionForm" value="">-->                                
                                    <input type="hidden" name="SeleccionarID" value="">    
                                    <!--/****** PARA BUSCAR EL PLANIFICACION PARA INTERVENCIONES ARCCC *********/-->
                                    <input type="hidden" name="ActionForm" value="PasarDatos">
                                    <input type="hidden" name="PIDE_ENTIDAD" value="">



                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   
                                        <!--ACTIVA ESTA SECCION CUANDO LA TABLA DEPENDE DE OTRA TABLA Y SE DESEA VER EL DETALLE DE LOS DATOS
                                        <table class="table table-hover table-nomargin table-bordered">
                                            <tr>
                                                <th style="width: 25%">NOMBRE DEL CERRO DE PASCO</th>
                                                <td style="width: 75%"><?php //echo $IdProveedorR;               ?></td>
                                            </tr>
                                        </table>                                
                                        -->
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Sector', name: 'DES_SECTOR', width: GetColumnSize(20), sortable: true, align: 'center', hide: true},
                                                                    {display: 'RUC', name: 'COD_RUC', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Código Sector', name: 'SEC_EJEC', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Sede', name: 'DES_ENTIDAD', width: GetColumnSize(66), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo de UE', name: 'TIP_ENTIDAD', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'EST_ENTIDAD', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> },
                                                                    {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center', hide: true}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true}
//                                                                    ,{name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Sede Ejecutora', name: 'DES_ENTIDAD'},
                                                                    {display: 'RUC', name: 'COD_RUC'},
                                                                    {display: 'Sector', name: 'DES_SECTOR'}
                                                                ],

                                                                sortname: "Id",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: ''
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


    $IDE_ENTIDAD = $lCollection->Get('IDE_ENTIDAD');
    $IDE_ENTIDAD_SUP = $lCollection->Get('IDE_ENTIDAD_SUP');
    $IDE_SECTOR = $lCollection->Get('IDE_SECTOR');
    $COD_RUC = $lCollection->Get('COD_RUC');
    $SEC_EJEC = $lCollection->Get('SEC_EJEC');
    $DES_ENTIDAD = $lCollection->Get('DES_ENTIDAD');
    $TIP_ENTIDAD = $lCollection->Get('TIP_ENTIDAD');
    $NUM_NIVEL = $lCollection->Get('NUM_NIVEL');
    $EST_ENTIDAD = $lCollection->Get('EST_ENTIDAD');
/***EDGAR---**************/
    $TIP_GOBIERNO = $lCollection->Get('TIP_GOBIERNO');
    $COD_UBIGEO = $lCollection->Get('COD_UBIGEO');
    $DES_UBIGEO = $lCollection->Get('DES_UBIGEO');
    
    // por defecto es nergia y minas
    $IDE_SECTOR = 14;
    $SEC_EJEC = 16;
    //$TIP_ENTIDAD = 3;
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
/***EDGAR---**************/

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_SECTOR = $lCollection->Get('DataSet_GEN_SECTOR');


    $DataSet_GEN_TABLAS = $lCollection->Get('DataSet_GEN_TABLAS');
    
    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar GEN_ENTIDAD"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de GEN_ENTIDAD"; //Nombre de la Tabla
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
        
        /************** PARA BUSCAR EL UNIDAD EJECUTORA    *************/
        function CompruebaPaseDatos()
        {            
            var f = parent.document.formulario;            
            
            switch(f.btnUnidadEjecutora.value) {
                case 'EJECUTORA_DESTINO':
                    f.EJECUTORA_DESTINO.value = '<?php echo $DES_ENTIDAD ; ?>';
                    f.IDE_EJECUTORA_DESTINO.value = '<?php echo $IDE_ENTIDAD; ?>';
                    break;
                case "EJECUTORA_ORIGEN":
                    f.EJECUTORA_ORIGEN.value = '<?php echo $DES_ENTIDAD ; ?>';
                    f.IDE_EJECUTORA_ORIGEN.value = '<?php echo $IDE_ENTIDAD; ?>';
                    break;
                case "ENTIDAD_SOLICITANTE":
                    f.ENTIDAD_SOLICITANTE.value = '<?php echo $DES_ENTIDAD ; ?>';
                    f.IDE_ENTIDAD_SOLICITANTE.value = '<?php echo $IDE_ENTIDAD; ?>';
                    f.TIP_NIVEL_GOBIERNO.value = '<?php echo $TIP_GOBIERNO; ?>';
                    f.COD_UBIGEO_SOLICITANTE.value = '<?php echo $COD_UBIGEO; ?>';
                    f.PlanSolicitudFFTO_UBIGEO.value = '<?php echo $DES_UBIGEO; ?>';
                    break;
                case "ENTIDAD_UNIDAD_EJECUTORA":
                    f.ENTIDAD_UNIDAD_EJECUTORA.value = '<?php echo $DES_ENTIDAD ; ?>';
                    f.IDE_ENTIDAD.value = '<?php echo $IDE_ENTIDAD; ?>';
                    break;
                case "ENTIDAD_PIRCC":
                    f.UNIDAD_EJECUTORA.value = '<?php echo $DES_ENTIDAD ; ?>';
                    f.IDE_ENTIDAD.value = '<?php echo $IDE_ENTIDAD; ?>';
                    f.COD_UBIGEO.value = '<?php echo $COD_UBIGEO; ?>';
                    f.PlanIntervencion_UBIGEO.value = '<?php echo $DES_UBIGEO; ?>';
                    break;
            }

            parent.$.colorbox.close();            
        
        }
        
        <?php
        if ((strlen($IDE_ENTIDAD) > 0) and ( $IDE_ENTIDAD <> "")) {
            ?>
                CompruebaPaseDatos();
            <?php
        }
        ?>



        
    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <legend><?php echo $TitulFormulario; ?></legend>  



        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ENTIDAD_SUP">Pliego: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_ENTIDAD_SUP" id="IDE_ENTIDAD_SUP" value="<?php echo $IDE_ENTIDAD_SUP; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="input-xlarge alphanumeric" data-trigger="hover" data-content="Ingrese el nombre del pliego"/>
            </div>
        </div>		
        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_SECTOR">Sector:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_SECTOR('IDE_SECTOR', $DataSet_GEN_SECTOR, $IDE_SECTOR, 1, "") ?>				
            </div>
        </div>  				
        <div class="control-group" style="display:none">
            <label class="control-label" for="COD_RUC">RUC: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_RUC" id="COD_RUC" value="<?php echo $COD_RUC='20103030791'; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content="Ingrese el Nº de RUC de la UE" style='width:14.5%;' />
            </div>
        </div>		
        <div class="control-group" style="display:none">
            <label class="control-label" for="SEC_EJEC">Codigo Sector: <span class="error">*</span></label>
            <div class="controls">
                <input  name="SEC_EJEC" id="SEC_EJEC" value="<?php echo $SEC_EJEC; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="input-xlarge alphanumeric required" data-trigger="hover" data-content="Ingrese el código del sector de ejecución de la UE"/>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="DES_ENTIDAD">Sede: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_ENTIDAD" id="DES_ENTIDAD" value="<?php echo $DES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric required" data-trigger="hover" data-content="Ingrese la Sede Ejecutora"/>
            </div>
        </div>		
        <div class="control-group" >
            <label class="control-label" for="TIP_ENTIDAD">Tipo Entidad: <span class="error">*</span></label>
            <div class="controls">
                <!--<input  name="TIP_ENTIDAD" id="TIP_ENTIDAD" value="<?php // echo $TIP_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="input-xlarge alphanumeric required" data-trigger="hover" data-content="Selecciona el tipo de entidad al que pertenece"/>-->
                <?php comboTIP_ENTIDAD('TIP_ENTIDAD', $DataSet_GEN_TABLAS_1, $TIP_ENTIDAD, 1, "") ?>
            </div>
        </div>		

        <div class="control-group">
            <label class="control-label" for="EST_ENTIDAD">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_ENTIDAD('EST_ENTIDAD', $DataSet_GEN_TABLAS, $EST_ENTIDAD, 1, "") ?>				
            </div>
        </div>  				


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_SECTOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciona el sector al que pertenece la UE" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_SECTOR > 0)) {
                if ($lstDatos[$i]->IDE_SECTOR == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_SECTOR . "\" selected=\"selected\">" . $lstDatos[$i]->DES_SECTOR . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_SECTOR . "\">" . $lstDatos[$i]->DES_SECTOR . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_ENTIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado de la Sede Ejecutora" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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



function comboTIP_ENTIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Tipo Entidad al que pertenece la Sede Ejecutora" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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