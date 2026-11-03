<?php
/********************************************************************************
//  ==========================================
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : PROY_CONT_ETAPA_CONTROLvista de la tabla PROY_CONT_ETAPA_CONTROL
//  Fecha           : martes, 25 de mayo de 2021 13:55:29
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 13:55:29
//******************************************************************************/

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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_CONT_ETAPA_CONTROL.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <link rel="stylesheet" type="text/css" href="../recursos/css/include.css" />
    <!--/*EDGAR*/-->

    <script type="text/javascript">
        function cerrarPopup()
        {
        parent.$.colorbox.close();
        parent.$('#flex1').flexReload();
        }
        $(function(){
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
                    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
                    $Recursiva_hide = $lCollection->Get('Recursiva_hide');
                    $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');

                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = '';
                    $Pedido = $lCollection->Get('Pedido');
                    if ($Pedido == 'Busqueda') {
                        $FormularioAccion = 'PasarDatos';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }

                    $crud = $lCollection->Get('crud');
                    /* ------------------------------------ */
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


                    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');

                    $VTIP_PROYECTO_ACTIVIDAD = $lCollection->Get('VTIP_PROYECTO_ACTIVIDAD');

                    //$DatosPadre = Tabla_ProyectoComponente_Datos($VCOD_PROYECTO . ' - ' . $VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE);
                    $DatosPadre = Tabla_ProyectoComponente_Datos($VCOD_PROYECTO . ' - ' . $VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE, $VTIP_PROYECTO_ACTIVIDAD , $PIDE);

                    $crudEliminar = $lCollection->Get('crudEliminar');
                    /* ------------------------------------ */
                    /* EDGAR */
                    ?>
                    <!--<div class="box-content">-->
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
                            <li><a href="#tabs-1">Listado de Control Anual de Etapa del Contrato </a></li>
                            <li><a href="#tabs-2">Detalle de Control Anual de Etapa del Contrato </a></li>
                        </ul>
                        <!--CONTENIDO DE LA PESTAÑA 1-->
                        <div id="tabs-1">


                            <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                <!-- <input type="hidden" name="ActionForm" value=""> -->                               
                                <input type="hidden" name="SeleccionarID" value="">                                    

                                <!--/*EDGAR*/-->
                                <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                <input type="hidden" name="PIDEbuscado" value="">
                                <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                <input type="hidden" name="Recursiva_Nivel_Actual" value="<?php echo $Recursiva_Nivel_Actual; ?>">

                                <!--/*EDGAR*/-->

                                <div id="contenedor">        
                                    <div id="fila1">
                                        <div class="limpiar"></div>
                                    </div>   

                                    <div class="msjListado" id="mensaje">
                                        Seleccione un registro para editar <?php echo ' - ' . $Pedido; ?>
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
                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>&Recursiva_Nivel_Actual=<?php echo $Recursiva_Nivel_Actual; ?>',
                                                        /* Tipo de datos devuelto json, xml */
                                                        dataType: 'json',
                                                        /* Metodo de Envio de  Datos*/
                                                        method: 'POST',
                                                        /* Lista de campo a mostrar en cada columna */
                                                        colModel: [
                                                        {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'IdeProyectoComponente', name: 'IDE_PROY_COMPONENTE', width: GetColumnSize(3), sortable: true, align: 'center', hide: true},
                                                        {display: 'Plan', name: 'DES_PLAN', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                        {display: 'Concepto', name: 'TIP_CONCEPTO', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                        {display: 'Año', name: 'NUM_ANIO', width: GetColumnSize(5.5), sortable: true, align: 'center', hide: true},
                                                        {display: 'Monto  Bruto', name: 'IMP_BRUTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                        {display: 'Importe Imponible', name: 'IMP_IMPONIBLE', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                        {display: 'Porcentaje IGV', name: 'PCT_IGV', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                        {display: 'Importe IGV (18%)', name: 'IMP_IGV', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                        {display: 'Monto Neto Facturado', name: 'IMP_NETO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                        {display: 'Importe Penalidad', name: 'IMP_PENALIDAD', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                        {display: 'Monto a Pagar', name: 'IMP_PAGO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                        {display: 'Estado', name: 'EST_ETAPA_CONTROL', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                        {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                /*EDGAR*/
                                                                {display: 'Ver', name: 'Recursiva', width: GetColumnSize(7), sortable: false, align: 'center', hide:<?php echo $Recursiva_hide; ?>},
                                                        {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $crud['Seleccion']; ?>},
                                                        {display: 'Detalle', name: 'Detalle', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $crud['Modificar']; ?>},
                                                        {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $crud['Modificar']; ?>},
                                                        {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $crud['Eliminar']; ?>}
                                                        /*EDGAR*/
                                                        ],
                                                        /*Botones de Enlace*/
                                                        buttons: [
        <?php if ($crud['Nuevo'] == 'true') { ?>                        {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                        {separator: true},
                                                        {name: 'Salir', bclass: 'salir', onpress: test}
                                                        ],
                                                        /*Lista de campo que se podra hacer busqueda */

                                                        searchitems: [
                                                        {display: 'Plan', name: 'DES_PLAN'},
                                                        {display: 'Año', name: 'NUM_ANIO'},
                                                        {display: 'Concepto', name: 'TIP_CONCEPTO'}
                                                        ],
                                                        sortname: "DES_PLAN,TIP_CONCEPTO",
                                                        sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                        usepager: true, /* activa o descativa paginación */
                                                        singleSelect: true,
                                                        useRp: true,
                                                        rp: 10,
                                                        height: $("#datos").innerHeight,
                                                        query: '',
                                                        nowrap: false

                                                        /*EDGAR*/
                                                        , title: '<?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) . '<hr>' . $DatosPadre; ?>'
                                                        /*EDGAR*/
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
                                        }
                                        else
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
                    <!--</div>-->
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


    $IDE_CONT_ETAPA_CONTROL = $lCollection->Get('IDE_CONT_ETAPA_CONTROL');
    $IDE_PROY_COMPONENTE = $lCollection->Get('IDE_PROY_COMPONENTE');
    $IDE_PLAN = $lCollection->Get('IDE_PLAN');
    $NUM_ANIO = $lCollection->Get('NUM_ANIO');
    $TIP_CONCEPTO = $lCollection->Get('TIP_CONCEPTO');
    $IMP_BRUTO = $lCollection->Get('IMP_BRUTO');
    $IMP_IMPONIBLE = $lCollection->Get('IMP_IMPONIBLE');
    $PCT_IGV = $lCollection->Get('PCT_IGV');
    $IMP_IGV = $lCollection->Get('IMP_IGV');
    $IMP_NETO = $lCollection->Get('IMP_NETO');
    $IMP_PENALIDAD = $lCollection->Get('IMP_PENALIDAD');
    $IMP_PAGO = $lCollection->Get('IMP_PAGO');
    $EST_ETAPA_CONTROL = $lCollection->Get('EST_ETAPA_CONTROL');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');

    /* para la herencia */
    $IDE_PROY_COMPONENTE = $PIDE; //codigo superior autocompleta
    $PCT_IGV = '0.18';

    /* para la visualizacion de busqueda */
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    /* para el padre buscado */
    //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//        $BIDE = $Bdescripcion = "";
//        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//          $BIDE = $lCollection->Get('BIDE');;
//          $Bdescripcion = $lCollection->Get('Bdescripcion');
//        }
    $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');
    //$NUM_NIVEL = intval($Recursiva_Nivel_Actual) ;                
    $crud = $lCollection->Get('crud');

    /* ------------------------------------ */
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


    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');

    $DatosPadre = Tabla_ProyectoComponente_Datos($VCOD_PROYECTO . ' - ' . $VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE , $PIDE);

    /* ------------------------------------ */
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_PLAN_1 = $lCollection->Get('DataSet_GEN_PLAN_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


    $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');



    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Control de Etapa del Contrato"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Control de Etapa del Contrato"; //Nombre de la Tabla

        $EST_ETAPA_CONTROL = 11;
        $IMP_BRUTO = 0;
        $IMP_IMPONIBLE = 0;
        $PCT_IGV = '0.18';
        $IMP_IGV = 0;
        $IMP_NETO = 0;
        $IMP_PENALIDAD = 0;
        $IMP_PAGO = 0;
    }
    ?>
    <script type="text/javascript">
        $(function(){
        //ACTIVA LOS TOOLTIPS
        $('*[data-content]').hover(function()
        {
        $(this).popover('show');
        });
        //VALIDACION DE FORMULARIO
        $("#BtnForm01").on("click", function() {
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
        ////// para extraer datos
        function CompruebaPaseDatos()
        {
        var f = parent.document.formulario;
        //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;    ?>');
        //            f.IDE.value = '<?php //echo $BIDE;    ?>';
        //            f.DES.value = '<?php //echo $Bdescripcion;    ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            //CompruebaPaseDatos();
    <?php } ?>



        function Filtrar_TipoConcepto ( VIDE_INTERVENCION ) {

            var lst_TIP_CONCEPTO = document.formulario.TIP_CONCEPTO ;
            var lst_IDE_PLAN = document.formulario.IDE_PLAN.value ;
            var verSI = 'block' ;
            var verNO = 'none' ;
            lst_TIP_CONCEPTO.options[0].style.display = verNO ;
            lst_TIP_CONCEPTO.options[1].style.display = verNO ; // 1. ADELANTO DIRECTO
            lst_TIP_CONCEPTO.options[2].style.display = verNO ; // 2. ADELANTO DE MATERIAL
            lst_TIP_CONCEPTO.options[3].style.display = verNO ; // 3. VALORIZACION
            lst_TIP_CONCEPTO.options[4].style.display = verNO ;
            lst_TIP_CONCEPTO.options[5].style.display = verNO ;
            lst_TIP_CONCEPTO.options[6].style.display = verNO ;
            lst_TIP_CONCEPTO.options[7].style.display = verNO ;
            lst_TIP_CONCEPTO.options[8].style.display = verNO ;
            lst_TIP_CONCEPTO.options[9].style.display = verNO ;
            lst_TIP_CONCEPTO.options[10].style.display = verNO ;
            lst_TIP_CONCEPTO.options[11].style.display = verNO ;
            lst_TIP_CONCEPTO.options[12].style.display = verNO ;
            //alert('busquedas : '+ VIDE_INTERVENCION );
            //alert('PLAN : '+ lst_IDE_PLAN );
            if ( VIDE_INTERVENCION==151 || VIDE_INTERVENCION==154 ||  VIDE_INTERVENCION==168 ||  VIDE_INTERVENCION==163 ) {
                //alert('busquedas OBRAS : '+ VIDE_INTERVENCION );
                if ( lst_IDE_PLAN==1 ) {         // planificado 
                    lst_TIP_CONCEPTO.options[4].style.display = verSI ;
                } else if ( lst_IDE_PLAN==2 ) {  // real  
                    lst_TIP_CONCEPTO.options[1].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[2].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[3].style.display = verSI ; 
                } else if ( lst_IDE_PLAN==3 ) {  // reprogramado
                    lst_TIP_CONCEPTO.options[5].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[6].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[7].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[8].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[9].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[10].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[11].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[12].style.display = verSI ;
                } 
            } else if ( VIDE_INTERVENCION==155 || VIDE_INTERVENCION==174 || VIDE_INTERVENCION==161 || VIDE_INTERVENCION==160 || VIDE_INTERVENCION==159 || VIDE_INTERVENCION==169 || VIDE_INTERVENCION==152 || VIDE_INTERVENCION==163 ) {
                //alert('busquedas ESTUDIOS : '+ VIDE_INTERVENCION );
                if ( lst_IDE_PLAN==1 ) {            // planificado
                    lst_TIP_CONCEPTO.options[4].style.display = verSI ; 
                } else if ( lst_IDE_PLAN==2 ) {     // real   
                    lst_TIP_CONCEPTO.options[3].style.display = verSI ;  
                } else if ( lst_IDE_PLAN==3 ) {    // reprogramado 
                    lst_TIP_CONCEPTO.options[5].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[6].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[7].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[8].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[9].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[10].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[11].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[12].style.display = verSI ;
                } 
            } else if ( VIDE_INTERVENCION==153 ) {
                //alert('busquedas SUPERVISON : '+ VIDE_INTERVENCION );
                if ( lst_IDE_PLAN==1 ) {         // planificado 
                    lst_TIP_CONCEPTO.options[4].style.display = verSI ;
                } else if ( lst_IDE_PLAN==2 ) {  // real  
                    lst_TIP_CONCEPTO.options[1].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[2].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[3].style.display = verSI ; 
                } else if ( lst_IDE_PLAN==3 ) {  // reprogramado
                    lst_TIP_CONCEPTO.options[5].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[6].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[7].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[8].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[9].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[10].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[11].style.display = verSI ;
                    lst_TIP_CONCEPTO.options[12].style.display = verSI ;
                } 
            } else {
                lst_TIP_CONCEPTO.options[0].style.display = verSI ;
                lst_TIP_CONCEPTO.options[1].style.display = verSI ; // 1. ADELANTO DIRECTO
                lst_TIP_CONCEPTO.options[2].style.display = verSI ; // 2. ADELANTO DE MATERIAL
                lst_TIP_CONCEPTO.options[3].style.display = verSI ; // 3. VALORIZACION
                lst_TIP_CONCEPTO.options[4].style.display = verSI ;
                lst_TIP_CONCEPTO.options[5].style.display = verSI ;
                lst_TIP_CONCEPTO.options[6].style.display = verSI ;
                lst_TIP_CONCEPTO.options[7].style.display = verSI ;
                lst_TIP_CONCEPTO.options[8].style.display = verSI ;
                lst_TIP_CONCEPTO.options[9].style.display = verSI ;
                lst_TIP_CONCEPTO.options[10].style.display = verSI ;
                lst_TIP_CONCEPTO.options[11].style.display = verSI ;
                lst_TIP_CONCEPTO.options[12].style.display = verSI ;
            }
        }
        
        Filtrar_TipoConcepto ( <?php echo $VIDE_INTERVENCION ;?> ) ;

    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>"> 
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
        <?php
        if ($PIDE > 0) {
            echo $DatosPadre . '<br>';
        }
        ?>
        <!--/*EDGAR*/-->

        <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_ETAPA_CONTROL">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONT_ETAPA_CONTROL" id="IDE_CONT_ETAPA_CONTROL" value="<?php echo $IDE_CONT_ETAPA_CONTROL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROY_COMPONENTE">IdeProyectoComponente: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_PROY_COMPONENTE" id="IDE_PROY_COMPONENTE" value="<?php echo $IDE_PROY_COMPONENTE; ?>"  maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="IdeProyectoComponente"/>					
            </div>
        </div>							


        <div class="control-group" style="display:none" >
            <label class="control-label" for="NUM_ANIO">Año: <span class="error">*</span></label>
            <div class="controls">
                <!--<input  name="NUM_ANIO" id="NUM_ANIO" value="<?php // echo $NUM_ANIO; ?>"  maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Año"/>-->
                <?php comboNUM_ANIO('NUM_ANIO',$DataSet_GEN_TABLAS_3,$NUM_ANIO,1,"")?>	
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_PLAN">Plan:<span class="error">*</span></label>
            <div class="controls"> 
                <?php $filtrar =  'onchange="Filtrar_TipoConcepto('.$VIDE_INTERVENCION.')"' ?>
                <?php comboIDE_PLAN('IDE_PLAN', $DataSet_GEN_PLAN_1, $IDE_PLAN, 1, $filtrar ) ?>				
            </div>
        </div>  							


        <div class="control-group">
            <label class="control-label" for="TIP_CONCEPTO">Concepto:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_CONCEPTO('TIP_CONCEPTO', $DataSet_GEN_TABLAS_1, $TIP_CONCEPTO, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IMP_BRUTO">Monto Bruto : <span class="error"></span></label>
            <div class="controls">
                <input readonly name="IMP_BRUTO" id="IMP_BRUTO" value="<?php echo $IMP_BRUTO; ?>"  maxlength="25" type="text" class="number show-popover"  data-trigger="hover" data-content="Ingrese Importe Bruto" style="width :13.5%;" />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="IMP_IMPONIBLE">Monto Imponible: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_IMPONIBLE" id="IMP_IMPONIBLE" value="<?php echo $IMP_IMPONIBLE; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content=" Importe Imponible" style="width :13.5%" />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="PCT_IGV">Porcentaje IGV: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="PCT_IGV" id="PCT_IGV" value="<?php echo $PCT_IGV; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content=" Porcentaje IGV" style="width :13.5%" />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="IMP_IGV">IGV (18%): <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_IGV" id="IMP_IGV" value="<?php echo $IMP_IGV; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content=" Importe IGV" style="width :13.5%" />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_NETO">Monto Neto Facturado : <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_NETO" id="IMP_NETO" value="<?php echo $IMP_NETO; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content=" Importe Neto" style="width :13.5%" />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="IMP_PENALIDAD">Penalidad: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_PENALIDAD" id="IMP_PENALIDAD" value="<?php echo $IMP_PENALIDAD; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content=" Importe Penalidad" style="width :13.5%" />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_PAGO">Monto a Pagar : <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_PAGO" id="IMP_PAGO" value="<?php echo $IMP_PAGO; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content=" Importe Pago" style="width :13.5%" />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_ETAPA_CONTROL">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_ETAPA_CONTROL('EST_ETAPA_CONTROL', $DataSet_GEN_TABLAS_2, $EST_ETAPA_CONTROL, 1, "") ?>				
            </div>
        </div>  						















        <?php echo $crud['Grabar']; ?>

        <!--
              <div class="form-actions">
                  <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
              </div>
        -->

    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_PLAN($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Plan" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_CONCEPTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Concepto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboNUM_ANIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Año" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_ETAPA_CONTROL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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