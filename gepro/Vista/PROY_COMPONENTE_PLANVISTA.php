<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMPONENTE_PLANVISTA de la tabla PROY_COMPONENTE_PLAN
  //  Fecha           : miércoles, 22 de noviembre de 2017 07:27:24 p.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMPONENTE_PLAN.js"></script>    
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
                    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
                    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
                    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
                    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
                    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
                    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
                    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
                    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
                    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
                    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');

//
//                    $DatosPadre = '<table width="100%">';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Código Proyecto:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO . '</td>';
//                    $DatosPadre .= '</tr>';
//
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Unidad Ejecutora:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
//
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Intervención:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_INTERVENCION . '</td>';
//                    $DatosPadre .= '<td style="width: 00%">Ejecución contractual:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . '</td>';
//                    $DatosPadre .= '</tr>';
//
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Estado:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_ESTADO . '</td>';
//                    $DatosPadre .= '<td style="width: 00%">Cartera:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_CARTERA . '</td>';
//                    $DatosPadre .= '</tr>';
//
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Componente:</td>';
//                    $DatosPadre .= '<td style="width: 50%"><span style="color: #D1542F;"> ' . $VDES_COMPONENTE . '</span></td>';
//                    
//                    $DatosPadre .= '<td style="width: 00%">Monto de Inversión:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '</table>';
                    
                    $DatosPadre = ProyectoComponente_DatosPadre ( $VDES_PROYECTO, $VDES_INTERVENCION,$VFEC_INICIO_CONTRATO,$VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE ) ;
                    
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
                                <li><a href="#tabs-1">Listado de Planes del Componente del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Planes del Componente del Proyecto </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value=""> 
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
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Tipo de Plan', name: 'DES_PLAN', width: GetColumnSize(35), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Fecha de Inicio', name: 'FEC_INICIO', width: GetColumnSize(18), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fecha de Finalización', name: 'FEC_TERMINO', width: GetColumnSize(18), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'EST_COMPONENTE_PLAN', width: GetColumnSize(18), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(11), sortable: false, align: 'center'}
                                                                    
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Tipo de Plan', name: 'DES_PLAN'}
                                                                ],

                                                                sortname: "DES_PLAN",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false

                                                                , title: '<?php echo $DatosPadre; ?>'


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


    $IDE_COMPONENTE_PLAN = $lCollection->Get('IDE_COMPONENTE_PLAN');
    $IDE_PROY_COMPONENTE = $lCollection->Get('IDE_PROY_COMPONENTE');
    $IDE_PLAN = $lCollection->Get('IDE_PLAN');
    $FEC_INICIO = $lCollection->Get('FEC_INICIO');
    $FEC_TERMINO = $lCollection->Get('FEC_TERMINO');
    $EST_COMPONENTE_PLAN = $lCollection->Get('EST_COMPONENTE_PLAN');



    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_PLAN_1 = $lCollection->Get('DataSet_GEN_PLAN_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Planes del Componente del Proyecto"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Planes del Componente del Proyecto"; //Nombre de la Tabla
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


            $('#FEC_INICIO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO').datepicker({
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
        <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">
        <input type="hidden" name="IDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">        
        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group">	
            <label class="control-label" for="IDE_CONVOCATORIA">Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IDE_CONVOCATORIA" id="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_ENTIDAD">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ENTIDAD" id="DES_ENTIDAD" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_INTERVENCION">Intervención: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_INTERVENCION" id="DES_INTERVENCION" value="<?php echo $VDES_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   

        <div class="control-group">	
            <label class="control-label" for="DES_COMPONENTE">Componente: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_COMPONENTE" id="DES_COMPONENTE" value="<?php echo $VDES_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <!--
        <div class="control-group">	
            <label class="control-label" for="DES_CARTERA">Cartera: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_CARTERA" id="DES_CARTERA" value="<?php echo $VDES_CARTERA; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>        
        <div class="control-group">	
            <label class="control-label" for="DES_ESTADO">Estado: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ESTADO" id="DES_ESTADO" value="<?php echo $VDES_ESTADO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
                                   
        <div class="control-group">	
            <label class="control-label" for="IMP_COMPONENTE">Monto de Inversión: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COMPONENTE" id="IMP_COMPONENTE" value="<?php echo $VIMP_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        
        <div class="control-group" >
            <label class="control-label" for="IDE_COMPONENTE_PLAN">Código: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IDE_COMPONENTE_PLAN" id="IDE_COMPONENTE_PLAN" value="<?php echo $SeleccionarID; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ingrese el código del plan"/>

            </div>
        </div>												
                
        -->
        <div class="control-group">	
            <label class="control-label" for="FEC_INICIO_CONTRATO">Ejecución Contractual: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" value="<?php echo 'del ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   


        <div class="control-group">
            <label class="control-label" for="IDE_PLAN">Tipo de Plan:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_PLAN('IDE_PLAN', $DataSet_GEN_PLAN_1, $IDE_PLAN, 1, "") ?>				
            </div>
        </div>  						

<!--
        <div class="control-group">
            <label class="control-label" for="FEC_INICIO">Fecha de Inicio:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input readonly name="FEC_INICIO" id="FEC_INICIO" onchange="ValidarFechaFinal(document.formulario.FEC_INICIO.value, document.formulario.FEC_TERMINO.value,'1')" style="width: 10%" value="<?php echo $FEC_INICIO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric  show-popover"  data-trigger="hover" data-content="Ingrese la fecha de inicio de ejecución del componente" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_TERMINO">Fecha de Finalización:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input readonly name="FEC_TERMINO" id="FEC_TERMINO" onchange="ValidarFechaFinal(document.formulario.FEC_INICIO.value, document.formulario.FEC_TERMINO.value,'2')" style="width: 10%" value="<?php echo $FEC_TERMINO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric  show-popover"  data-trigger="hover" data-content="Ingrese la fecha de finalización de ejecución del componente" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						
        
-->
        <div class="control-group">
            <label class="control-label" for="EST_COMPONENTE_PLAN">Estado del Plan:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_COMPONENTE_PLAN('EST_COMPONENTE_PLAN', $DataSet_GEN_TABLAS_1, $EST_COMPONENTE_PLAN, 1, "") ?>				
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

function comboIDE_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de plan" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_COMPONENTE_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciones el estado actual del componente" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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