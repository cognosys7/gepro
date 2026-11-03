<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio Cósar Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROYECTO_ACTIVIDADVISTA de la tabla PROYECTO_ACTIVIDAD
  //  Fecha           : martes, 7 de noviembre de 2017 16:13:23
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROYECTO_ACTIVIDAD.js"></script>    


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
                    $Opcion = $lCollection->Get('Opcion');

                    /* EDGAR */
                    $PIDE = $lCollection->Get('PIDE');
                    $BotonVer = Grilla_verBotones_ProyectoActividad($Opcion);
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    $Pfiltro = $lCollection->Get('Pfiltro');
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
                                <li><a href="#tabs-1">Listado de Contratos por Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Contrato por Proyecto </a></li>                                
                            </ul>
                            <!--CONTENIDO DE LA PESTAóA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PóGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <!--/*EDGAR*/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                    <input type="hidden" name="Pfiltro" value="<?php echo $Pfiltro; ?>">
                                    <!--/*EDGAR*/-->

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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pfiltro=<?php echo $Pfiltro; ?>', /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [

    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
    {display: 'Cod.Orden Det.', name: 'COD_PROYECTO', width: GetColumnSize(7.5), sortable: true, align: 'left', hide: false},
    {display: 'Cod.Contrato', name: 'COD_CONTRATO_ENTIDAD', width: GetColumnSize(8), sortable: true, align: 'left', hide: false},
    {display: 'Descripción del Servicio', name: 'DES_PROYECTO', width: GetColumnSize(19.5), sortable: true, align: 'left', hide: false},
    {display: 'Costo Actual (S/.)', name: 'IMP_PROYECTO', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
    {display: 'Ord.', name: 'IMP_COSTO_ACTUAL', width: GetColumnSize(3), sortable: true, align: 'left', hide: true},
    {display: 'Inicio', name: 'FEC_INICIO', width: GetColumnSize(5.3), sortable: true, align: 'center', hide: false},
    {display: 'Término', name: 'FEC_TERMINO', width: GetColumnSize(5.3), sortable: true, align: 'center', hide: false},
//    {display: 'Cierre', name: 'FEC_CIERRE', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
    {display: 'Fase - Componente', name: 'INTERVENCION', width: GetColumnSize(8), sortable: true, align: 'left', hide: false},
    {display: 'Mod. Gestión', name: 'TIPO_CONTRATO', width: GetColumnSize(7), sortable: true, align: 'left', hide: false},            
    {display: 'Estado', name: 'ESTADO_PROYECTO', width: GetColumnSize(6), sortable: true, align: 'left', hide: false},
    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
    
    {display: 'Etapas', name: 'Componente', width: GetColumnSize(4.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Componente']; ?>},
    {display: 'Det. Cont.', name: 'Contrato', width: GetColumnSize(5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato']; ?>},
    {display: 'Amp.Plazo', name: 'Ampliacion', width: GetColumnSize(5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Ampliacion']; ?>},
//    {display: 'Presupuesto', name: 'Presupuesto', width: GetColumnSize(8), sortable: false, align: 'center', hide:<?php //echo $BotonVer['Presupuesto']; ?>},
    {display: 'Riesgo', name: 'Riesgo', width: GetColumnSize(4.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Riesgo']; ?>},
    {display: 'Interesados', name: 'Interesado', width: GetColumnSize(5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Interesado']; ?>},
//    {display: 'Ind.', name: 'Indicador', width: GetColumnSize(4), sortable: false, align: 'center', hide:<?php // echo $BotonVer['Editar']; ?>},
//    {display: 'Seguimiento', name: 'Seguimiento', width: GetColumnSize(6), sortable: false, align: 'center', hide:true},
    {display: 'Adquisición', name: 'ProcAdq', width: GetColumnSize(5.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['ProcAdq']; ?>},
    {display: 'Documentos', name: 'Documentacion', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $BotonVer['Documentacion']; ?>},
    {display: 'Calidad Entregables', name: 'Entregable', width: GetColumnSize(8), sortable: false, align: 'center', hide:<?php echo $BotonVer['Entregable']; ?>},
    {display: 'Migrar', name: 'Migrar', width: GetColumnSize(4), sortable: false, align: 'center', hide:<?php echo $BotonVer['Componente']; ?>},
    {display: 'Editar', name: 'Editar', width: GetColumnSize(4), sortable: false, align: 'center', hide: <?php echo $BotonVer['Editar']; ?>},
    {display: 'Eliminar', name: 'eliminar', width: GetColumnSize(4), sortable: false, align: 'center', hide: <?php echo $BotonVer['Editar']; ?>}


                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
    <?php if( $BotonVer['Nuevo'] == 'true') { ?>                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
    <?php } ?>                                                      {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Cod.Contrato', name: 'COD_CONTRATO_ENTIDAD'},
                                                                    {display: 'Cod.Orden Det.', name: 'COD_PROYECTO'},
                                                                    {display: 'Descripción del Servicio', name: 'DES_PROYECTO'},
                                                                    {display: 'Fase - Componente', name: 'INTERVENCION'},
                                                                    {display: 'Mod. Gestión', name: 'TIPO_CONTRATO'},
                                                                    {display: 'Estado', name: 'ESTADO_PROYECTO'},
                                                                    {display: 'Inicio', name: 'FEC_INICIO'},
                                                                    {display: 'Término', name: 'FEC_TERMINO'}
//                                                                    {display: 'Unidad Ejecutora', name: 'UNIDAD_EJECUTORA'},
//                                                                    {display: 'Estado Proceso', name: 'ESTADO_PROCESO'}
                                                                ],
                                                                sortname: "IMP_COSTO_ACTUAL",
                                                                sortorder: "DESC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 100,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false

                                                                , title: '<?php echo Tabla_Proyecto_Datos($PIDE); ?>'
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
                                                } else if (com == 'Imprimir')
                                                {
                                                    LINK_RPT_INTERVENCIONES();
                                                } else if (com == 'Salir')
                                                {
                                                    cerrarPopup();
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


    $IDE_PROYECTO_ACTIVIDAD = $lCollection->Get('IDE_PROYECTO_ACTIVIDAD');
    $COD_PROYECTO = $lCollection->Get('COD_PROYECTO');
    $IDE_ENTIDAD_EJECUTORA = $lCollection->Get('IDE_ENTIDAD_EJECUTORA');
    $IDE_PROCESO_ITEM = $lCollection->Get('IDE_PROCESO_ITEM');
    $IDE_PRIORIZACION = $lCollection->Get('IDE_PRIORIZACION');
    $IDE_INTERVENCION = $lCollection->Get('IDE_INTERVENCION');
    $GRUPO_TIPO_INTERVENCION = $lCollection->Get('GRUPO_TIPO_INTERVENCION');
    $TIP_PROYECTO_ACTIVIDAD = $lCollection->Get('TIP_PROYECTO_ACTIVIDAD');
    $DES_PROYECTO = $lCollection->Get('DES_PROYECTO');
    $DES_PROYECTO_ITEM = $lCollection->Get('DES_PROYECTO_ITEM');
    $DES_PROYECTO_ABREV = $lCollection->Get('DES_PROYECTO_ABREV');
    $IMP_INVERSION = $lCollection->Get('IMP_INVERSION');
    $IMP_FINANCIADO = $lCollection->Get('IMP_FINANCIADO');
    $IMP_TRANSFERIDO = $lCollection->Get('IMP_TRANSFERIDO');
    $IMP_VALOR_REFERENCIAL = $lCollection->Get('IMP_VALOR_REFERENCIAL');
    $IMP_COSTO_ACTUAL = $lCollection->Get('IMP_COSTO_ACTUAL');
    $IMP_LIQUIDADO = $lCollection->Get('IMP_LIQUIDADO');
    $DES_UBICACION = $lCollection->Get('DES_UBICACION');
    $GEO_LONGITUD_UBICACION = $lCollection->Get('GEO_LONGITUD_UBICACION');
    $GEO_LATITUD_UBICACION = $lCollection->Get('GEO_LATITUD_UBICACION');
    $EST_PROYECTO_ACTIVIDAD = $lCollection->Get('EST_PROYECTO_ACTIVIDAD');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');



    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $IDE_PROYECTO = $PIDE; //codigo superior autocompleta

    $BPROCESO = $lCollection->Get('BProcesoAdquisicion');
    $bCOD_CONTRATO_ENTIDAD = $lCollection->Get('bCOD_CONTRATO_ENTIDAD');
    
    $PIDEvisualiza = 'style="display:none"'; //'style="display:none"'
    
    $blokeado_no = '' ;
    $blokeado_si = ' readonly ' ;
    $MontoBruto_blokeado = $blokeado_no ;
    $MontoIGV_blokeado = $blokeado_no ;
    
    
    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        if ( $EST_PROYECTO_ACTIVIDAD==98 ) {
            $Control_Bloqueo = Control_BloqueoACT('');
        } else {
            $Control_Bloqueo = Control_BloqueoACT('SPRING1');
        }
        
    } else {
        //INSERT
        $Control_Bloqueo = Control_BloqueoACT('');
        $EST_PROYECTO_ACTIVIDAD = 98 ;
        
//        $MontoBruto_blokeado = $blokeado_no ;
//        $MontoIGV_blokeado = $blokeado_no ;
    }
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */



    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_ENTIDAD_1 = $lCollection->Get('DataSet_GEN_ENTIDAD_1');


    $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');

    $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Contrato. " . SPRING_msgDatosActualizados() ; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Contrato. " . SPRING_msgDatosActualizados(); //Nombre de la Tabla
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
        
        
        function readonly_Montos() {
            var var_ModGes = document.formulario.TIP_PROYECTO_ACTIVIDAD.value ;     //       alert('TIP_PROYECTO_ACTIVIDAD ' + var_ModGes );
            var blokearSI = true ;
            var blokearNO = false ;
            var verSI = 'inline' ;
            var verNO = 'none' ;
            

            document.getElementById('IMP_INVERSION').readOnly = blokearSI ;
            document.getElementById('IMP_FINANCIADO').readOnly = blokearSI ;
            document.getElementById('IMP_COSTO_ACTUAL').readOnly = blokearSI ;
            document.getElementById('add16').style.display = verNO ;

            if ( var_ModGes==27 || var_ModGes==28 || var_ModGes==29 || var_ModGes==30 || var_ModGes==31 || var_ModGes==32 || var_ModGes==33 || var_ModGes==34 || var_ModGes==36 || var_ModGes==37 || var_ModGes==38 || var_ModGes==39 || var_ModGes==40) {
                document.getElementById('IMP_INVERSION').readOnly = blokearNO ;
//                document.getElementById('IMP_FINANCIADO').readOnly = blokearNO ;
//                document.getElementById('IMP_COSTO_ACTUAL').readOnly = blokearNO ; 
                document.getElementById('add16').style.display = verSI ;
            }
        }
        
        readonly_Montos();
        
        
        function ver_control() {
            var verSI = 'inline' ;
            var verNO = 'none' ;
            var v_IMP_INVERSION ;
//            var v_IMP_FINANCIADO ;
            var va_IMP_INVERSION ;
//            var va_IMP_FINANCIADO ;
            var v_IMP_COSTO_ACTUAL ;
            
            document.getElementById('IMP_COSTO_ACTUAL').style.display = verNO ;
            
            v_IMP_INVERSION = document.getElementById('IMP_INVERSION').value ; //            alert('IMP_INVERSION: '+v_IMP_INVERSION) ;
//            v_IMP_FINANCIADO = document.getElementById('IMP_FINANCIADO').value ;

            va_IMP_INVERSION =  parseFloat(v_IMP_INVERSION) ;
            va_IMP_FINANCIADO = va_IMP_INVERSION * 0.18 ;
         
            v_IMP_COSTO_ACTUAL = va_IMP_INVERSION + va_IMP_FINANCIADO ;
            
            if ( v_IMP_INVERSION!=0  ) {          //      alert('entre: '+v_IMP_COSTO_ACTUAL) ;
                document.getElementById('IMP_FINANCIADO').value =  parseFloat(va_IMP_FINANCIADO).toFixed(2) ;
                document.getElementById('IMP_COSTO_ACTUAL').style.display = verSI ;
                document.getElementById('IMP_COSTO_ACTUAL').value =  parseFloat(v_IMP_COSTO_ACTUAL).toFixed(2) ;
            }
        }
        
        ver_control();
        
        
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>">
        <input type="hidden" name="varBotonInvocador" value="">
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  


<!--/*EDGAR*/-->
        <?php if ($PIDE > 0) {  echo Tabla_Proyecto_Datos($PIDE);  } ?>
<!--/*EDGAR*/-->

	<br>



        <h5>Datos Generales del Contrato del Proyecto:</h5>

        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO_ACTIVIDAD">Ide: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_PROYECTO_ACTIVIDAD" id="IDE_PROYECTO_ACTIVIDAD" value="<?php echo $IDE_PROYECTO_ACTIVIDAD; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>
            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">IdeProyecto:<span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="" class="input-integer required show-popover"/>
            </div>
        </div>	


<!--        <div class="control-group">
            <label class="control-label" for="COD_PROYECTO">Número: <span class="error">*</span></label>
            <div class="controls">						
                <input <?php // echo (!empty($SeleccionarID)) ? "READONLY" : ""; ?>  name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $COD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="input-alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el código Contrato"/>                
            </div>
        </div>	
-->

<!--        <div class="control-group">
            <label class="control-label" for="IDE_CONTRATO">Número : <span class="error">*</span></label>
            <div class="controls">
                <input type="text" name="IDE_CONTRATO" id="IDE_CONTRATO" value="<?php // echo $IDE_CONTRATO; ?>"  style='width:13%;' />
                <input name="COD_PROYECTO" id="COD_PROYECTO" value="<?php // echo $COD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Agrege la Código de Contrato con el boton agregar(+)"   style='width:13%; background-color:#dddddd'  />
                <input name="Submit2" type="button" value="" id="add16" title="Seleccionar Contrato" onclick=" AddContrato ('COD_PROYECTO')"/>
            </div>
        </div>	-->

<?php extraerIDEyValor_Text ("IDE_CONTRATO",$COD_PROYECTO,'PROYECTO_ACTIVIDAD','Cod.Orden Detalle','COD_PROYECTO' ,$COD_PROYECTO, 'Contrato' , " width:13%;",$Control_Bloqueo['COD_PROYECTO'],'',''  ); ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ENTIDAD_EJECUTORA">Unidad Ejecutora:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIDE_ENTIDAD_EJECUTORA('IDE_ENTIDAD_EJECUTORA', $DataSet_GEN_ENTIDAD_1, $IDE_ENTIDAD_EJECUTORA, 1, " style='width: 92%;' ") ?>				
            </div>
        </div>  						


<!--        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROCESO">Ide Proceso: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_PROCESO" id="IDE_PROCESO" value="<?php // echo $IDE_PROCESO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>
            </div>
        </div>		-->

<?php   extraerIDEyValor_Area('IDE_PROCESO_ITEM', $IDE_PROCESO_ITEM, 'ESTANDAR', 'Proceso Adquisición', 'BPROCESO', $BPROCESO, 'PROCESO', 2 ,'VerValor','',''  );        ?>

        <div class="control-group"  style="display:none">
            <label class="control-label" for="IDE_PRIORIZACION">Priorización: <span class="error"></span></label>
            <div class="controls">						
                <input  name="IDE_PRIORIZACION" id="IDE_PRIORIZACION" value="<?php echo $IDE_PRIORIZACION; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="input-integer show-popover"  data-trigger="hover" data-content="Seleccione la priorización del proyecto"/>                
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="GRUPO_TIPO_INTERVENCION">Programa de Proyectos:<span class="error">(GRUPO_TIPO_INTERVENCION)</span></label>
            <div class="controls"> 
    <?php comboGRUPO_TIPO_INTERVENCION('GRUPO_TIPO_INTERVENCION', $DataSet_GEN_TABLAS_3, $GRUPO_TIPO_INTERVENCION, 1, "") ?>				
            </div>
        </div>  
    </div>  
	
				

    
    <div class="control-group">
        <label class="control-label" for="DES_PROYECTO">Desc. Servicio : <span class="error">*</span></label>
        <div class="controls">                    
            <textarea <?php echo $Control_Bloqueo['DES_PROYECTO'] ; ?> name="DES_PROYECTO" id="DES_PROYECTO" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="input-xlarge required show-popover"  data-trigger="hover" data-content="Ingrese el nombre del proceso principal" ><?php echo $DES_PROYECTO; ?></textarea>                
        </div>
    </div>
    
    
    <div class="control-group">
        <label class="control-label" for="IDE_INTERVENCION">Fase - Componente :<span class="error">*</span></label>
        <div class="controls"> 
    <?php comboIDE_INTERVENCION('IDE_INTERVENCION', $DataSet_GEN_INTERVENCION_1, $IDE_INTERVENCION, 1, " style='width: 51%;' ") ?>				
        </div>
    </div> 
    
    
    <div class="control-group">
        <label class="control-label" for="TIP_PROYECTO_ACTIVIDAD">Modalidad de Gestión :<span class="error"></span></label>
        <div class="controls"> 
    <?php comboTIP_PROYECTO_ACTIVIDAD('TIP_PROYECTO_ACTIVIDAD', $DataSet_GEN_TABLAS_1, $TIP_PROYECTO_ACTIVIDAD, 1, " style='width: 51%;'  onchange='readonly_Montos()'  ") ?>				
        </div>
    </div>   						
								

    
    <div class="control-group">
        <label class="control-label" for="DES_PROYECTO_ABREV">Gestión de Cambio : <span class="error"></span></label>
        <div class="controls">						
            <input  name="DES_PROYECTO_ABREV" id="DES_PROYECTO_ABREV" value="<?php echo $DES_PROYECTO_ABREV; ?>" onChange="conMayusculas(this)" maxlength="120" type="text" class="input-  show-popover" data-trigger="hover" data-content="Ingrese una descripción corta"/>                
        </div>
    </div>								

    
    
    
    <div class="control-group" style="display:none">
        <label class="control-label" for="DES_PROYECTO_ITEM">N° Resolución : <span class="error"></span></label>
        <div class="controls">                    
            <textarea name="DES_PROYECTO_ITEM" id="DES_PROYECTO_ITEM" rows="1" onChange="conMayusculas(this)" maxlength="500" class="input-xlarge  show-popover"  data-trigger="hover" data-content="Ingrese la descripción del proyecto" ><?php echo $DES_PROYECTO_ITEM; ?></textarea>                
        </div>
    </div>
    
    
    <div class="control-group">
        <label class="control-label" for="DES_UBICACION">N° Resolución : <span class="error"></span></label>
        <div class="controls">						
            <input  name="DES_UBICACION" id="DES_UBICACION" value="<?php echo $DES_UBICACION; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-alphanumeric show-popover" data-trigger="hover" data-content="Ingrese la ubicación del proyecto"/>                
        </div>
    </div>								
    <!--<br>-->
<!--    <hr>
    <h5>Montos (S/.):</h5>-->


    <div class="control-group" >
        <label class="control-label" for="IMP_INVERSION">Monto Bruto : <span class="error">*</span></label>
        <div class="controls">
            <input  name="IMP_INVERSION" id="IMP_INVERSION" value="<?php echo $IMP_INVERSION; ?>" onChange="ver_control()" maxlength="25" type="text" class="number  show-popover"  data-trigger="hover" data-content="Ingrese el monto de inversión según Banco de Inversiones" style='width:13%;' />					
        </div>
    </div>								


    <div class="control-group" >
        <label class="control-label" for="IMP_FINANCIADO">Monto IGV : <span class="error">*</span></label>
        <div class="controls">
            <input name="IMP_FINANCIADO" id="IMP_FINANCIADO" value="<?php echo $IMP_FINANCIADO; ?>" onChange="ver_control()" maxlength="25" type="text" class="number  show-popover"  data-trigger="hover" data-content="Ingrese el monto según la solicitud de financiamiento" style='width:13%;' />					
        </div>
    </div>								

    <div class="control-group" style="display:none">
        <label class="control-label" for="IMP_TRANSFERIDO">Monto Total Transferido: <span class="error">*</span></label>
        <div class="controls">
            <input  name="IMP_TRANSFERIDO" id="IMP_TRANSFERIDO" value="<?php echo $IMP_TRANSFERIDO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number  show-popover"  data-trigger="hover" data-content="Ingrese el monto total transferido mediante D.S."/>					
        </div>
    </div>								


    <div class="control-group" style="display:none">
        <label class="control-label" for="IMP_VALOR_REFERENCIAL">Monto Referencial: <span class="error"></span></label>
        <div class="controls">
            <input  name="IMP_VALOR_REFERENCIAL" id="IMP_VALOR_REFERENCIAL" value="<?php echo $IMP_VALOR_REFERENCIAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese el monto del valor referencial"/>					
        </div>
    </div>								


    <div class="control-group">
        <label class="control-label" for="IMP_COSTO_ACTUAL">Monto Neto : <span class="error">*</span></label>
        <div class="controls">
            <input  name="IMP_COSTO_ACTUAL" id="IMP_COSTO_ACTUAL" value="<?php echo $IMP_COSTO_ACTUAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number  show-popover"  data-trigger="hover" data-content="Ingrese el Monto Neto" style='width:13%;' />					
        </div>
    </div>								


    <div class="control-group" style="display:none">
        <label class="control-label" for="IMP_LIQUIDADO">Monto Liquidado: <span class="error"></span></label>
        <div class="controls">
            <input  name="IMP_LIQUIDADO" id="IMP_LIQUIDADO" value="<?php echo FormatoMonedas($IMP_LIQUIDADO); ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese el monto liquidado del proyecto"/>					
        </div>
    </div>								




    <div class="control-group" style="display:none">
        <label class="control-label" for="GEO_LONGITUD_UBICACION">Longitud Ubicación: <span class="error"></span></label>
        <div class="controls">
            <input  name="GEO_LONGITUD_UBICACION" id="GEO_LONGITUD_UBICACION" value="<?php echo $GEO_LONGITUD_UBICACION; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" data-trigger="hover" data-content=""/>
        </div>
    </div>		


    <div class="control-group" style="display:none">
        <label class="control-label" for="GEO_LATITUD_UBICACION">Latitud Ubicación: <span class="error"></span></label>
        <div class="controls">
            <input  name="GEO_LATITUD_UBICACION" id="GEO_LATITUD_UBICACION" value="<?php echo $GEO_LATITUD_UBICACION; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" data-trigger="hover" data-content=""/>
        </div>
    </div>

    <br>
<!--    <hr>
    <h5>Información de Seguimiento:</h5>-->

    <div class="control-group">
        <label class="control-label" for="EST_PROYECTO_ACTIVIDAD">Estado Seguimiento :<span class="error">*</span></label>
        <div class="controls"> 
    <?php comboEST_PROYECTO_ACTIVIDAD('EST_PROYECTO_ACTIVIDAD', $DataSet_GEN_TABLAS_2, $EST_PROYECTO_ACTIVIDAD, 1, ''  ) ?>				
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

function comboIDE_ENTIDAD_EJECUTORA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la ejecutora" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboGRUPO_TIPO_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el grupo de intevención" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la Etapa-Fase" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_PROYECTO_ACTIVIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el tipo de Gestión de Cambio del Contrato" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_PROYECTO_ACTIVIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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
