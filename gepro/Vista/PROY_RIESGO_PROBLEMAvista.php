<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio Cósar Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_RIESGO_PROBLEMAVISTA de la tabla PROY_RIESGO_PROBLEMA
  //  Fecha           : martes, 7 de noviembre de 2017 16:13:06
  //  Desde el Modelo : PDM - AMSACEtiqueta
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIóN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_RIESGO_PROBLEMA.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />
    
    <script type="text/javascript">
        function cerrarPopup()
        {
            parent.$.colorbox.close();
            parent.$('#flex1').flexReload();
        }
        $(function () {
            $("#tabs").tabs({active: 0});
            $("#tabs").tabs({readonly: [1]});
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
                    $PIDE_PROYECTO = $lCollection->Get('PIDE_PROYECTO');
                    
                    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
                    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
                    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');

                    
                    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
                    
    /* EDGAR */
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
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAóAS-->
                            <ul>
                                <li><a href="#tabs-1">Listado de Riesgo / Problema del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Riesgo / Problema del Contrato </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAóA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PóGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    


                                    <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>">
                                    <input type="hidden" name="PIDE_PROYECTO" value="<?php echo $PIDE_PROYECTO; ?>">
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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROYECTO_ACTIVIDAD=<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>&PIDE_PROYECTO=<?php echo $PIDE_PROYECTO; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'IDE R/P', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Uni.Ejecutora', name: 'EJECUTORA', width: GetColumnSize(0), sortable: true, align: 'left', hide: true},
                                                                    {display: 'Código de Contrato', name: 'COD_PROYECTO', width: GetColumnSize(7), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Proyecto', name: 'PROYECTO', width: GetColumnSize(35), sortable: true, align: 'left', hide: true},
                                                                    {display: 'Tipo Riesgo', name: 'TIPO_RIESGO', width: GetColumnSize(12), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo de Estratégia', name: 'RIESGO_PROBLEMA', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Código del Riesgo', name: 'NOMBRE', width: GetColumnSize(11), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Descripción del Riesgo', name: 'DES_DETALLE', width: GetColumnSize(30.5), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Impacto', name: 'IMPACTO', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Probabilidad', name: 'PROBABILIDAD', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Prioridad', name: 'PRIORIDAD', width: GetColumnSize(14), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Inicio Solución', name: 'FEC_INI_SOLUCION', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fin Solución', name: 'FEC_FIN_SOLUCION', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Estado', name: 'ESTADO_RIESGO', width: GetColumnSize(7), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Recurso', name: 'Boton5', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'IDE R/P', name: 'ID'},
                                                                    {display: 'COD. PROY.', name: 'COD_PROYECTO'},
                                                                    {display: 'PROYECTO', name: 'PROYECTO'},
                                                                    {display: 'TIPO DE RIESGO', name: 'TIPO_RIESGO'},
                                                                    {display: 'R/P', name: 'RIESGO_PROBLEMA'},
                                                                    {display: 'NOMBRE', name: 'NOMBRE'},
                                                                    {display: 'ESTADO', name: 'ESTADO_RIESGO'}
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

                                                                , title: '<?php echo Tabla_Proyecto_Datos($PIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ; ?>'


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
                            <!--PESTAóA 2-->
                            <div id="tabs-2">                           
                                <div id="FormularioDiv">
                                    <!-- En esta seccion se muestra todos los datos recuperados del foumulario -->                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<br><br><center>UD. NO TIENE ACCESO A ESTE MóDULO</center><br>";
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

//FUNCION UTILIZADA CUANDO SE REGISTRA O EDITA INFORMACIóN
function GeneraForm() {
    $lCollection = Collection::Singleton();
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');

    //Recuperando valores para Mostrar en el Formulario
    $SeleccionarID = $lCollection->Get('SeleccionarID');
    //$IdPersona        = $lCollection->Get('Id');


    $IDE_RIESGO_PROB = $lCollection->Get('IDE_RIESGO_PROB');
    $IDE_PROYECTO_ACTIVIDAD = $lCollection->Get('IDE_PROYECTO_ACTIVIDAD');
    $IDE_PROC_ITEM = $lCollection->Get('IDE_PROC_ITEM');
    $IDE_TIPO_RIESGO_PROB = $lCollection->Get('IDE_TIPO_RIESGO_PROB');
    $TIP_RIESGO_PROB = $lCollection->Get('TIP_RIESGO_PROB');
    $DES_NOMBRE = $lCollection->Get('DES_NOMBRE');
    $DES_DETALLE = $lCollection->Get('DES_DETALLE');
    $IDE_IMPACTO = $lCollection->Get('IDE_IMPACTO');
    $IDE_PROBABILIDAD = $lCollection->Get('IDE_PROBABILIDAD');
    $IDE_PRIORIDAD = $lCollection->Get('IDE_PRIORIDAD');
    $DES_CAUSA_PROBLEMA = $lCollection->Get('DES_CAUSA_PROBLEMA');
    $DES_CONSECUENCIA_RIESGO = $lCollection->Get('DES_CONSECUENCIA_RIESGO');
    $DES_SOLUCION = $lCollection->Get('DES_SOLUCION');
    $FEC_INICIO_SOLUCION = $lCollection->Get('FEC_INICIO_SOLUCION');
    $FEC_TERMINO_SOLUCION = $lCollection->Get('FEC_TERMINO_SOLUCION');
    $EST_RIESGO = $lCollection->Get('EST_RIESGO');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');



    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');



    /* EDGAR */
    $PIDE_PROYECTO = $lCollection->Get('PIDE_PROYECTO');
    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TIPO_RIESGO_1 = $lCollection->Get('DataSet_GEN_TIPO_RIESGO_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_IMPACTO_RIESGO_1 = $lCollection->Get('DataSet_GEN_IMPACTO_RIESGO_1');


    $DataSet_GEN_PROBABILIDAD_RIESGO_1 = $lCollection->Get('DataSet_GEN_PROBABILIDAD_RIESGO_1');


    $DataSet_GEN_PRIORIDAD_RIESGO_1 = $lCollection->Get('DataSet_GEN_PRIORIDAD_RIESGO_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Riesgo / Problema"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Riesgo / Problema"; //Nombre de la Tabla
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


            $('#FEC_INICIO_SOLUCION').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO_SOLUCION').datepicker({
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
        
        /*
        var aProbabilidad = [ 0, 0.1 , 0.3, 0.5, 0.7, 0.9 ] ; 
        var aImpacto = [ 0, 0.05 , 0.1, 0.2, 0.4, 0.8 ] ; 
        var aPrioridad = [ 0, 0.05 , 0.14, 0.72 ] ;
        var aPrioridad_text = [ 'Indefinido', 'BAJA [0,005 - 0.050]' , 'MODERADO [0.06 - 0.14]', 'ALTA [0.20 - 0.72]' ] ;
        */

        var aProbabilidad   = [ 0, 0.2 , 0.4, 0.6, 0.8, 1 ] ;
        var aImpacto        = [ 0, 2 , 4, 6, 8, 10 ] ; 
        var aPrioridad      = [ 0, 1.6 , 4.8 , 6 ] ;
        var aPrioridad_text = [ 'Indefinido', 'BAJA [0.4 - 1.6]' , 'MODERADA [2 - 4.8]', 'ALTA [6 - 10]' ] ;
      
        
        function calcularPrioridad(valor)
        {
            var Probabilidad    = aProbabilidad[document.formulario.IDE_PROBABILIDAD.value] ;
            var Impacto         = aImpacto[document.formulario.IDE_IMPACTO.value] ;
            var Prioridad       = Probabilidad*Impacto ;
            var Prioridad_redondeo =  Prioridad.toFixed(3) ;
            
            var Prioridad_text = '' ;
            var Resultado_text = '' ;
            var select=document.getElementById("IDE_PRIORIDAD");
            
            
//            if( isNaN(Prioridad) ) {
                
                if(Prioridad <= aPrioridad[1]){
                        Prioridad_text = aPrioridad_text[1] ;
                        select.selectedIndex=1 ;
                        document.formulario.DES_PRIORIDAD.style.background = '#8bf765';
                        
                } else if(Prioridad >= aPrioridad[3]){
                        Prioridad_text = aPrioridad_text[3] ;
                        select.selectedIndex=3 ;
                        document.formulario.DES_PRIORIDAD.style.background = '#f70002';
                        
                } else if( Prioridad > aPrioridad[1] && Prioridad < aPrioridad[3] ) {
                        Prioridad_text = aPrioridad_text[2] ;
                        select.selectedIndex=2 ;
                        document.formulario.DES_PRIORIDAD.style.background = '#f8f801';
                } else {
                    document.formulario.DES_PRIORIDAD.style.background = '#dddddd';
                    select.selectedIndex=0 ;
                    Resultado_text = '';
                }

                if( isNaN(Prioridad)==false ) {
                    Resultado_text = Prioridad_text + '. Rango hayado es ' + Prioridad_redondeo.toString() ;
                }
//            }
            
            document.formulario.DES_PRIORIDAD.value = Resultado_text  ;
        }
        
        calcularPrioridad();
        

    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD ?>">
        <input type="hidden" name="IDE_ENTIDAD_EJECUTORA" value="<?php echo $VIDE_ENTIDAD_EJECUTORA ?>">
        <input type="hidden" name="IDE_RIESGO_PROB" value="<?php echo $SeleccionarID; ?>"/>
        <input type="hidden" name="IDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>" />        

        
        
        <input type="hidden" name="PIDE_PROYECTO" value="<?php echo $PIDE_PROYECTO; ?>">
        
        <legend>
            <?php echo $TitulFormulario; ?>
            <input type=button onclick="abrirArchivo('ContratoRiesgos_Ejemplo.pdf')" style="background:#d1f5e7;" value="Ver Ejemplo de llenado de Registro">
        </legend>  

        
        
        
        <table width='100%'>
            <tr>
                <td><strong>II. DATOS GENERALES DEL PROYECTO</strong> 
<!--                    <br>
                    (Úbicación, Área de Intervención, Cuenca Hidrográfica, Número de PAM's, Stake Holder, etc )-->
                </td>
            </tr>

            <tr>
                <td> 

                    <?php echo Tabla_Proyecto_Datos($PIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ; ?>

                </td>
            </tr>
        </table>
        




<!--        <div class="control-group">	
            <label class="control-label" for="COD_PROYECTO">Código Contrato: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly name="COD_PROYECTO" id="COD_PROYECTO" value="<?php // echo $VCOD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>-->




        <legend></legend>


        <table width='100%'>
            <tr>
                <td><strong>III. IDENTIFICACIÓN DE RIESGOS</strong> 
                    <!--                <br>
                                    (Úbicación, Área de Intervención, Cuenca Hidrográfica, Número de PAM's, Stake Holder, etc )-->
                </td>
            </tr>

            <tr>
                <td>        

                    <div class="control-group">
                        <label class="control-label" for="IDE_TIPO_RIESGO_PROB">Tipo de Riesgo:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboIDE_TIPO_RIESGO_PROB('IDE_TIPO_RIESGO_PROB', $DataSet_GEN_TIPO_RIESGO_1, $IDE_TIPO_RIESGO_PROB, 1, " style='width: 51%;' ") ?>				
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="DES_NOMBRE">Código del Riesgo: <span class="error">*</span></label>
                        <div class="controls">						
                            <input  name="DES_NOMBRE" id="DES_NOMBRE" value="<?php echo $DES_NOMBRE; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="input-alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el nombre de riesgo o problema"/>                
                        </div>
                    </div>	


                    <div class="control-group" style="display:none">	
                        <label class="control-label" for="DES_PROYECTO_ITEM">Descripción: <span class="error">*</span></label>				
                        <div class="controls">
                            <input readonly name="DES_PROYECTO_ITEM" id="DES_PROYECTO_ITEM" value="<?php echo $VDES_PROYECTO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge" data-trigger="hover" data-content=""/>
                        </div>			
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="DES_DETALLE">Descripción del Riesgo: <span class="error">*</span></label>
                        <div class="controls">                    
                            <textarea name="DES_DETALLE" id="DES_DETALLE" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="input-xlarge required show-popover"  data-trigger="hover" data-content="Ingrese Descripción del riesgo o problema" ><?php echo $DES_DETALLE; ?></textarea>               
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="DES_CAUSA_PROBLEMA">Causa Generadora(s): <span class="error"></span></label>
                        <div class="controls">                    
                            <textarea name="DES_CAUSA_PROBLEMA" id="DES_CAUSA_PROBLEMA" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="input-xlarge  show-popover"  data-trigger="hover" data-content="Ingrese la Descripción causa si es problema" ><?php echo $DES_CAUSA_PROBLEMA; ?></textarea>                
                        </div>
                    </div>						



                </td>
            </tr>
        </table>



        <legend></legend>


        

        <table width='100%'>
            <tr>
                <td><strong>IV. ANÁLISIS CUALITATIVO DE RIESGOS</strong> 
                    <!--                <br>
                                    (Úbicación, Área de Intervención, Cuenca Hidrográfica, Número de PAM's, Stake Holder, etc )-->
                </td>
            </tr>

            <tr>
                <td> 


                    <div class="control-group">
                        <label class="control-label" for="IDE_PROBABILIDAD">Probabilidad Ocurrencia:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboIDE_PROBABILIDAD('IDE_PROBABILIDAD', $DataSet_GEN_PROBABILIDAD_RIESGO_1, $IDE_PROBABILIDAD, 1, 'onchange="calcularPrioridad()"') ?>				
                        </div>
                    </div>  						


                    <div class="control-group">
                        <label class="control-label" for="IDE_IMPACTO">Impacto :<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboIDE_IMPACTO('IDE_IMPACTO', $DataSet_GEN_IMPACTO_RIESGO_1, $IDE_IMPACTO, 1, 'onchange="calcularPrioridad()"') ?>				
                        </div>
                    </div>	


                    <div class="control-group">
                        <label class="control-label" for="IDE_PRIORIDAD">Priorización del Riesgo :<span class="error">*</span></label>
                        <div class="controls" style="display:none" > 
                            <?php comboIDE_PRIORIDAD('IDE_PRIORIDAD', $DataSet_GEN_PRIORIDAD_RIESGO_1, $IDE_PRIORIDAD, 1, "") ?>				
                        </div>
                        <input readonly  name="DES_PRIORIDAD" id="DES_PRIORIDAD" value="" type="text"  style='width:16%; font-weight:bold '/>
                    </div>  


                    <div class="control-group">
                        <label class="control-label" for="TIP_RIESGO_PROB">Tipo de Estratégia:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboTIP_RIESGO_PROB('TIP_RIESGO_PROB', $DataSet_GEN_TABLAS_1, $TIP_RIESGO_PROB, 1, "") ?>				
                        </div>
                    </div>  						

                    
                </td>
            </tr>
        </table>



        <legend></legend>


        <table width='100%'>
            <tr>
                <td><strong>V. RESPUESTA A LOS RIESGOS</strong> 
                    <!--                <br>
                                    (Úbicación, Área de Intervención, Cuenca Hidrográfica, Número de PAM's, Stake Holder, etc )-->
                </td>
            </tr>

            <tr>
                <td> 


                    <div class="control-group">
                        <label class="control-label" for="DES_CONSECUENCIA_RIESGO">Disparador de Riesgo : <span class="error"></span></label>
                        <div class="controls">                    
                            <textarea name="DES_CONSECUENCIA_RIESGO" id="DES_CONSECUENCIA_RIESGO" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="input-xlarge  show-popover"  data-trigger="hover" data-content="Ingrese la Descripción consecuencia si es riesgo" ><?php echo $DES_CONSECUENCIA_RIESGO; ?></textarea>                
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="DES_SOLUCION">Acción para dar respuesta al Riesgo: <span class="error">*</span></label>
                        <div class="controls">                    
                            <textarea name="DES_SOLUCION" id="DES_SOLUCION" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="input-xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese la solución o acción" ><?php echo $DES_SOLUCION; ?></textarea>                
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="FEC_INICIO_SOLUCION">Inicio Acción:<span class="error">*</span></label>
                        <div class="controls">
                            <div class="span12">                            
                                <input name="FEC_INICIO_SOLUCION" id="FEC_INICIO_SOLUCION" style="width: 10%" value="<?php echo $FEC_INICIO_SOLUCION; ?>" minlength="1" maxlength="10" type="text"  class="input-date required show-popover"  data-trigger="hover" data-content="Ingrese la fecha de inicio de la solución" placeholder="DD/MM/YYYY"/>					
                            </div>
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="FEC_TERMINO_SOLUCION">Término Acción:<span class="error"></span></label>
                        <div class="controls">
                            <div class="span12">                            
                                <input name="FEC_TERMINO_SOLUCION" id="FEC_TERMINO_SOLUCION" style="width: 10%" value="<?php echo $FEC_TERMINO_SOLUCION; ?>" minlength="1" maxlength="10" type="text"  class="input-date  show-popover"  data-trigger="hover" data-content="Ingrese la fecha de tórmino de la solución" placeholder="DD/MM/YYYY"/>					
                            </div>
                        </div>
                    </div>						


                </td>
            </tr>
        </table>

        <div class="control-group" style="display:none">	
            <label class="control-label" for="EJECUTORA">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly  name="EJECUTORA" id="EJECUTORA" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>        

        <div class="control-group" style="display:none">	
            <label class="control-label" for="IMP_COSTO_ACTUAL">Importe Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly name="IMP_COSTO_ACTUAL" id="IMP_COSTO_ACTUAL" value="<?php echo $VIMP_COSTO_ACTUAL; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROC_ITEM">Proceso convocatoria: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_PROC_ITEM" id="IDE_PROC_ITEM" value="<?php echo $IDE_PROC_ITEM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>
            </div>
        </div>		





        <legend></legend>						




        <div class="control-group">
            <label class="control-label" for="EST_RIESGO">Estado Riesgo:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_RIESGO('EST_RIESGO', $DataSet_GEN_TABLAS_2, $EST_RIESGO, 1, "") ?>				
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


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_TIPO_RIESGO_PROB($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de riesgo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>readonly="readonly"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_TIPO_RIESGO > 0)) {
                if ($lstDatos[$i]->IDE_TIPO_RIESGO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_TIPO_RIESGO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_TIPO_RIESGO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_TIPO_RIESGO . "\">" . $lstDatos[$i]->DES_TIPO_RIESGO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboTIP_RIESGO_PROB($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione si es riesgo o problema" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>readonly="readonly"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_IMPACTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el impacto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>readonly="readonly"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_IMPACTO > 0)) {
                if ($lstDatos[$i]->IDE_IMPACTO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_IMPACTO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_IMPACTO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_IMPACTO . "\">" . $lstDatos[$i]->DES_IMPACTO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_PROBABILIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la probabilidad de ocurrencia" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>readonly="readonly"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_PROBABILIDAD > 0)) {
                if ($lstDatos[$i]->IDE_PROBABILIDAD == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROBABILIDAD . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PROBABILIDAD . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROBABILIDAD . "\">" . $lstDatos[$i]->DES_PROBABILIDAD . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_PRIORIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la prioridad" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>readonly="readonly"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_PRIORIDAD > 0)) {
                if ($lstDatos[$i]->IDE_PRIORIDAD == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PRIORIDAD . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PRIORIDAD . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PRIORIDAD . "\">" . $lstDatos[$i]->DES_PRIORIDAD . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_RIESGO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del riesgo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>readonly="readonly"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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
