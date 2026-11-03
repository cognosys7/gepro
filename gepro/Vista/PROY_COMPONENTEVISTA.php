<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMPONENTEVISTA de la tabla PROY_COMPONENTE
  //  Fecha           : lunes, 20 de noviembre de 2017 10:15:37 a.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMPONENTE.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

<!--/*EDGAR*/-->
    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />
<!--/*EDGAR*/-->
    
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
                    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
                    $PIDE_INTERVENCION = $lCollection->Get('PIDE_INTERVENCION');

                    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
                    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');
                    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
                    
                    
                    /* EDGAR */
                    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
                    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
                    
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
                                <li><a href="#tabs-1">Listado de Etapas del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Etapas del Contrato </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">
                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value=""> 
                                    <input type="hidden" name="PIDE_INTERVENCION" value="<?php echo $PIDE_INTERVENCION; ?>">
                                    <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>">    
                                    <input type="hidden" name="IDE_ENTIDAD_EJECUTORA" value="<?php echo $VIDE_ENTIDAD_EJECUTORA ?>">
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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROYECTO_ACTIVIDAD=<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>',

                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Código de Proyecto', name: 'IDE_PROYECTO_ACTIVIDAD', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Etapa del Componente', name: 'DES_COMPONENTE', width: GetColumnSize(16), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Sec.', name: 'NUM_SEC_COMPONENTE', width: GetColumnSize(3), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Etapa Contractual', name: 'DES_CARTERA', width: GetColumnSize(16.1), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Modo de Ejecución', name: 'DES_MODO_EJECUCION', width: GetColumnSize(11), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'DES_ESTADO', width: GetColumnSize(8), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Fecha Inicio', name: 'FEC_INICIO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fecha Fin', name: 'FEC_TERMINO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Importe', name: 'IMP_COMPONENTE', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Planes', name: 'Planes de Ejecuciòn', width: GetColumnSize(6), sortable: false, align: 'center', hide: true},
                                                                    {display: 'Hitos', name: 'Alcance y tiempo de los proyectos', width: GetColumnSize(6), sortable: false, align: 'center', hide: true},
                                                                    {display: 'Indicadores', name: 'Indicadores físicos y financieros', width: GetColumnSize(6), sortable: false, align: 'center', hide: true},
                                                                    {display: 'Control', name: 'Control', width: GetColumnSize(6), sortable: false, align: 'center', hide: false},
                                                                    {display: 'Recurso', name: 'Recurso', width: GetColumnSize(6), sortable: false, align: 'center', hide: false},
                                                                    {display: 'Fotos', name: 'Seguimiento', width: GetColumnSize(6), sortable: false, align: 'center', hide: true},
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(5), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(5), sortable: false, align: 'center', hide: false}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Componente', name: 'DES_COMPONENTE'},
                                                                    {display: 'Modo de Ejecución', name: 'DES_MODO_EJECUCION'}
                                                                ],

                                                                sortname: "DES_COMPONENTE",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false

                                                                , title: '<?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ; ?>'


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


    $IDE_PROY_COMPONENTE = $lCollection->Get('IDE_PROY_COMPONENTE');
    $IDE_PROYECTO_ACTIVIDAD = $lCollection->Get('IDE_PROYECTO_ACTIVIDAD');
    $PIDE_INTERVENCION = $lCollection->Get('PIDE_INTERVENCION');
    $IDE_COMPONENTE = $lCollection->Get('IDE_COMPONENTE');
    $NUM_SEC_COMPONENTE = $lCollection->Get('NUM_SEC_COMPONENTE');
    $IDE_CARTERA = $lCollection->Get('IDE_CARTERA');
    $IDE_MODO_EJECUCION = $lCollection->Get('IDE_MODO_EJECUCION');
    $IDE_PROC_ITEM = $lCollection->Get('IDE_PROC_ITEM');
    $IMP_COMPONENTE = $lCollection->Get('IMP_COMPONENTE');
    $IDE_ESTADO = $lCollection->Get('IDE_ESTADO');



    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');


    /* EDGAR */
    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */
    
    
    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */
    $DataSet_GEN_COMPONENTE_1 = $lCollection->Get('DataSet_GEN_COMPONENTE_1');
    $DataSet_PROY_CARTERA_1 = $lCollection->Get('DataSet_PROY_CARTERA_1');
    $DataSet_GEN_MODO_EJECUCION_1 = $lCollection->Get('DataSet_GEN_MODO_EJECUCION_1');
    $DataSet_PROC_ITEM_1 = $lCollection->Get('DataSet_PROC_ITEM_1');
    $DataSet_GEN_ESTADO_1 = $lCollection->Get('DataSet_GEN_ESTADO_1');

    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Componentes del Proyecto"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Componentes del Proyecto"; //Nombre de la Tabla
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
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD ?>">
        <input type="hidden" name="IDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD ?>">
        <input type="hidden" name="IDE_ENTIDAD_EJECUTORA" value="<?php echo $VIDE_ENTIDAD_EJECUTORA ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  
        
        <?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ; ?>
        
        <br>
        <div class="control-group" style="display:none">	
            <label class="control-label" for="COD_PROYECTO">Código Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $VCOD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>	
        <div class="control-group" style="display:none">	
            <label class="control-label" for="EJECUTORA">Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="EJECUTORA" id="EJECUTORA" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>        
        <div class="control-group" style="display:none">	
            <label class="control-label" for="DES_PROYECTO_ITEM">Contrato: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_PROYECTO_ITEM" id="DES_PROYECTO_ITEM" value="<?php echo $VDES_PROYECTO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none">	
            <label class="control-label" for="IMP_COSTO_ACTUAL">Importe Contrato: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COSTO_ACTUAL" id="IMP_COSTO_ACTUAL" value="<?php echo $VIMP_COSTO_ACTUAL; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">
            <label class="control-label" for="IDE_COMPONENTE">Etapa de Componente:<span class="error">*</span></label>
            <div class="controls">                 
                <?php 
                if (strlen($SeleccionarID) > 0) {
                    comboIDE_COMPONENTE('IDE_COMPONENTE', $DataSet_GEN_COMPONENTE_1, $IDE_COMPONENTE, 0, "");
                }
                else{
                    comboIDE_COMPONENTE('IDE_COMPONENTE', $DataSet_GEN_COMPONENTE_1, $IDE_COMPONENTE, 1, "");
                }
                ?>                
            </div>
        </div>          



        <div class="control-group" style="display:none">
            <label class="control-label" for="NUM_SEC_COMPONENTE">Secuencia: <span class="error"></span></label>
            <div class="controls">
                <input <?php echo strlen($SeleccionarID) > 0 ?"disabled":""; ?>  name="NUM_SEC_COMPONENTE" id="NUM_SEC_COMPONENTE" value="<?php echo $NUM_SEC_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer show-popover"  data-trigger="hover" data-content="Ingrese la secuencia del componente" style='width:13.3%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_CARTERA">Etapa Contractual:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_CARTERA('IDE_CARTERA', $DataSet_PROY_CARTERA_1, $IDE_CARTERA, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_MODO_EJECUCION">Modo de Ejecución:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_MODO_EJECUCION('IDE_MODO_EJECUCION', $DataSet_GEN_MODO_EJECUCION_1, $IDE_MODO_EJECUCION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROC_ITEM">Proceso Item:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboIDE_PROC_ITEM('IDE_PROC_ITEM', $DataSet_PROC_ITEM_1, $IDE_PROC_ITEM, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IMP_COMPONENTE">Monto Inversión: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_COMPONENTE" id="IMP_COMPONENTE" value="<?php echo FormatoMonedas($IMP_COMPONENTE); ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el monto de inversión del componente" style='width:13.3%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_ESTADO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_ESTADO('IDE_ESTADO', $DataSet_GEN_ESTADO_1, $IDE_ESTADO, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_COMPONENTE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el componente del proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_COMPONENTE > 0)) {
                if ($lstDatos[$i]->IDE_COMPONENTE == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_COMPONENTE . "\" selected=\"selected\">" . $lstDatos[$i]->DES_COMPONENTE . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_COMPONENTE . "\">" . $lstDatos[$i]->DES_COMPONENTE . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_CARTERA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la cartera de proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_CARTERA > 0)) {
                if ($lstDatos[$i]->IDE_CARTERA == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CARTERA . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CARTERA . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CARTERA . "\">" . $lstDatos[$i]->DES_CARTERA . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_MODO_EJECUCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el modo de ejecución" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_MODO_EJECUCION > 0)) {
                if ($lstDatos[$i]->IDE_MODO_EJECUCION == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_MODO_EJECUCION . "\" selected=\"selected\">" . $lstDatos[$i]->DES_MODO_EJECUCION . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_MODO_EJECUCION . "\">" . $lstDatos[$i]->DES_MODO_EJECUCION . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_PROC_ITEM($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Item del Proceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_PROC_ITEM > 0)) {
                if ($lstDatos[$i]->IDE_PROC_ITEM == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROC_ITEM . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ITEM . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROC_ITEM . "\">" . $lstDatos[$i]->DES_ITEM . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_ESTADO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del componente" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_ESTADO > 0)) {
                if ($lstDatos[$i]->IDE_ESTADO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ESTADO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ESTADO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ESTADO . "\">" . $lstDatos[$i]->DES_ESTADO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}
