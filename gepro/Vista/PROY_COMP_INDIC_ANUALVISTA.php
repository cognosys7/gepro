<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_INDIC_ANUALVISTA de la tabla PROY_COMP_INDIC_ANUAL
  //  Fecha           : sábado, 6 de enero de 2018 22:17:28
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMP_INDIC_ANUAL.js"></script>    


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

                    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
                    $PIDE_PLAN_FORECAST = $lCollection->Get('PIDE_PLAN_FORECAST');
                    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
                    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION'); //-
                    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');

                    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO'); //-

                    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE'); //-
                    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA'); //-
                    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO'); //-
                    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO'); //-
                    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO'); //-
                    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE'); //
                    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');
//                    $DatosPadre = '<table width="100%">';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Proyecto:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Contrato:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO_ITEM . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Fase:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_INTERVENCION . '</td>';
//                    $DatosPadre .= '<td style="width: 00%">Ejecución contractual:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . ' (' . $VDIAS_CONTRACTUALES . ' días)' . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Estado:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_ESTADO . '</td>';
//                    $DatosPadre .= '<td style="width: 00%">Elemento:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_CARTERA . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Componente:</td>';
//                    $DatosPadre .= '<td style="width: 50%"><span style="color: #D1542F;"> ' . $VDES_COMPONENTE . '</span></td>';
//                    $DatosPadre .= '<td style="width: 00%">Monto de Inversión:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '</table>';

                    /* EDGAR */
                    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');

                    $DatosPadre = Tabla_ProyectoComponente_Datos($VCOD_PROYECTO . ' - ' . $VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE);

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
                                <li><a href="#tabs-1">Listado de Indicadores Anuales </a></li>
                                <li><a href="#tabs-2">Detalle de Indicadores Anuales </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">

                                    <input type="hidden" name="IDE_PROY_COMPONENTE" value="">
                                    <input type="hidden" name="IDE_INDICADOR" value="">
                                    <input type="hidden" name="COD_ANHO" value="">


                                    <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE; ?>">    


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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROY_COMPONENTE=<?php echo $PIDE_PROY_COMPONENTE; ?>',

                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'IDE', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: '', name: 'IDE_INDICADOR', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Indicador', name: 'INDICADOR', width: GetColumnSize(35.9), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Año', name: 'COD_ANHO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Lìnea Base', name: 'LINEA_BASE', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Ejecutado', name: 'EJECUTADO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Forecast', name: 'FORECAST', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Tipo Ejecución', name: 'TIPO_PERIODO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Mensual', name: 'Boton1', width: GetColumnSize(8), sortable: false, align: 'center'},

                                                                    {display: 'Quincena', name: 'Boton2', width: GetColumnSize(10), sortable: false, align: 'center', hide: true},

                                                                    {display: 'Eliminar', name: 'Eliminar', width: GetColumnSize(8), sortable: false, align: 'center', hide: false}

                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Indicador', name: 'INDICADOR'}
                                                                ],

                                                                sortname: "INDICADOR",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false

                                                                , title: '<?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) . '<hr>' . $DatosPadre; ?>'


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


    $IDE_COMP_INDIC_ANUAL = $lCollection->Get('IDE_COMP_INDIC_ANUAL');
    $IDE_COMPONENTE_PLAN = $lCollection->Get('IDE_COMPONENTE_PLAN');
    $IDE_COMP_ACTIVIDAD = $lCollection->Get('IDE_COMP_ACTIVIDAD');
    $COD_ANHO = $lCollection->Get('COD_ANHO');
    $IDE_INDICADOR = $lCollection->Get('IDE_INDICADOR');
    $NUM_VALOR = $lCollection->Get('NUM_VALOR');
    $EST_COMP_INDIC_ANUAL = $lCollection->Get('EST_COMP_INDIC_ANUAL');



    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');

    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');

    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');
    $VFEC_INICIO_PLAN = $lCollection->Get('VFEC_INICIO_PLAN');
    $VFEC_TERMINO_PLAN = $lCollection->Get('VFEC_TERMINO_PLAN');
    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');


    /* EDGAR */
    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
    $DatosPadre = Tabla_ProyectoComponente_Datos($VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE);
    $EST_COMP_INDIC_ANUAL = 1;

    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');
    /* EDGAR */


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */
    $DataSet_PROY_COMPONENTE_PLAN_1 = $lCollection->Get('DataSet_PROY_COMPONENTE_PLAN_1');
    $DataSet_PROY_COMP_ACTIVIDAD_1 = $lCollection->Get('DataSet_PROY_COMP_ACTIVIDAD_1');
    $DataSet_GEN_INDICADOR_1 = $lCollection->Get('DataSet_GEN_INDICADOR_1');
    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Indicadores Anuales"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Indicadores Anuales"; //Nombre de la Tabla
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
        <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">


        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group" style="display:none" >	
            <label class="control-label" for="IDE_CONVOCATORIA">Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IDE_CONVOCATORIA" id="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_ENTIDAD">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ENTIDAD" id="DES_ENTIDAD" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_INTERVENCION">Intervención: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_INTERVENCION" id="DES_INTERVENCION" value="<?php echo $VDES_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_COMPONENTE">Componente: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_COMPONENTE" id="DES_COMPONENTE" value="<?php echo $VDES_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="FEC_INICIO_CONTRATO">Ejecución Contractual: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" value="<?php echo 'del ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . '(' . $VDIAS_CONTRACTUALES . ' días)'; ?> )" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="IMP_COMPONENTE">Monto de Inversión: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COMPONENTE" id="IMP_COMPONENTE" value="<?php echo $VIMP_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>        

        <!--
         <div class="control-group" >
             <label class="control-label" for="IDE_COMP_INDIC_ANUAL">Código Indicador: <span class="error"></span></label>
             <div class="controls">

                 <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IDE_COMP_INDIC_ANUAL" id="IDE_COMP_INDIC_ANUAL" value="<?php echo $SeleccionarID; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ingrese el Còdigo del Inficador"/>

             </div>
         </div>												


         <div class="control-group">
             <label class="control-label" for="IDE_COMPONENTE_PLAN">Tipo de Plan:<span class="error">*</span></label>
             <div class="controls"> 
        <?php comboIDE_COMPONENTE_PLAN('IDE_COMPONENTE_PLAN', $DataSet_PROY_COMPONENTE_PLAN_1, $IDE_COMPONENTE_PLAN, 1, "") ?>				
             </div>
         </div>  						
        -->

        <?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) . '<hr>' . $DatosPadre . '<br>'; ?>


        <div class="control-group">
            <label class="control-label" for="IDE_INDICADOR">Tipo de Indicador:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_INDICADOR('IDE_INDICADOR', $DataSet_GEN_INDICADOR_1, $IDE_INDICADOR, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <!--
        <div class="control-group">
            <label class="control-label" for="IDE_COMP_ACTIVIDAD">Componente Atividad:<span class="error"></span></label>
            <div class="controls"> 
        <?php comboIDE_COMP_ACTIVIDAD('IDE_COMP_ACTIVIDAD', $DataSet_PROY_COMP_ACTIVIDAD_1, $IDE_COMP_ACTIVIDAD, 1, "") ?>				
            </div>
        </div> 

        <div class="control-group">
            <label class="control-label" for="NUM_VALOR">Valor: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_VALOR" id="NUM_VALOR" value="<?php echo $NUM_VALOR; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el valor del indicador"/>					
            </div>
        </div>	        
        -->

        <div class="control-group">
            <label class="control-label" for="COD_ANHO">Año: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_ANHO" id="COD_ANHO" value="<?php echo $COD_ANHO; ?>" onChange="conMayusculas(this)" maxlength="4" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el Año" style='width:13.5%;' />					
            </div>
        </div>								

        <div class="control-group" style="display:none" >
            <label class="control-label" for="EST_COMP_INDIC_ANUAL">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_COMP_INDIC_ANUAL('EST_COMP_INDIC_ANUAL', $DataSet_GEN_TABLAS_1, $EST_COMP_INDIC_ANUAL, 1, "") ?>				
            </div>
        </div>  						




        <?php echo $crudGrabarCancelar; ?> 


    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_COMPONENTE_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el plan " id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_COMPONENTE_PLAN > 0)) {
                if ($lstDatos[$i]->IDE_COMPONENTE_PLAN == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_COMPONENTE_PLAN . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PLAN . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_COMPONENTE_PLAN . "\">" . $lstDatos[$i]->DES_PLAN . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_COMP_ACTIVIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de actividad del componente " id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_COMP_ACTIVIDAD > 0)) {
                if ($lstDatos[$i]->IDE_COMP_ACTIVIDAD == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_COMP_ACTIVIDAD . "\" selected=\"selected\">" . $lstDatos[$i]->NUM_DIAS . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_COMP_ACTIVIDAD . "\">" . $lstDatos[$i]->NUM_DIAS . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_INDICADOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de indicador" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_INDICADOR > 0)) {
                if ($lstDatos[$i]->IDE_INDICADOR == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_INDICADOR . "\" selected=\"selected\">" . $lstDatos[$i]->DES_INDICADOR . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_INDICADOR . "\">" . $lstDatos[$i]->DES_INDICADOR . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_COMP_INDIC_ANUAL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciona el estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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