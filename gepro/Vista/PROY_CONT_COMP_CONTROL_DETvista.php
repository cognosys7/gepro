<?php
/********************************************************************************
//  ==========================================
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : PROY_CONT_COMP_CONTROL_DETvista de la tabla PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 13:56:22
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 13:56:22
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_CONT_COMP_CONTROL_DET.js"></script>    


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
                    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
                    $VIDE_PLAN = $lCollection->Get('VIDE_PLAN');
                    $VTIP_CONCEPTO = $lCollection->Get('VTIP_CONCEPTO') ;

                    $VTIP_PROYECTO_ACTIVIDAD = $lCollection->Get('VTIP_PROYECTO_ACTIVIDAD');

                    $DatosPadre = Tabla_ProyectoComponente_Datos($VCOD_PROYECTO . ' - ' . $VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE , $VTIP_PROYECTO_ACTIVIDAD , $PIDE_PROY_COMPONENTE);

                    $crudEliminar = $lCollection->Get('crudEliminar');
                    $Grilla_verBotones_montos = Grilla_verBotones_montos( $VIDE_INTERVENCION , $VIDE_PLAN , $VTIP_CONCEPTO ) ;
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
                            <li><a href="#tabs-1">Listado de Control Mensual de Etapa del Contrato </a></li>
                            <li><a href="#tabs-2">Detalle de Control Mensual de Etapa del Contrato </a></li>
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
                                                        {display: 'IdeContratoEtapaControl', name: 'IDE_CONT_ETAPA_CONTROL', width: GetColumnSize(3), sortable: true, align: 'center', hide: true},
                                                        {display: 'Item', name: 'NUM_ITEM', width: GetColumnSize(4), sortable: true, align: 'center', hide: true},
                                                        {display: 'Año', name: 'NUM_ANIO', width: GetColumnSize(4), sortable: true, align: 'center', hide: false},
                                                        {display: 'Mes', name: 'NUM_MES', width: GetColumnSize(5), sortable: true, align: 'left', hide: false},
                                                        {display: 'Año-Mes Prov.', name: 'ANIO_MES_PROVISION', width: GetColumnSize(6), sortable: true, align: 'left', hide: <?php echo $Grilla_verBotones_montos['NUM_MES_PROVISION'] ; ?>},
                                                        {display: 'Concepto de Pago', name: 'DES_CONCEPTO_PAGO', width: GetColumnSize(8), sortable: true, align: 'left', hide: false},
                                                        {display: 'Avance (%)', name: 'PCT_AVANCE', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['PCT_AVANCE'] ; ?>},
                                                        {display: 'Mto.Bruto', name: 'IMP_BRUTO', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_BRUTO'] ; ?>},
                                                        {display: 'Reajustes', name: 'IMP_REAJUSTE', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_REAJUSTE'] ; ?>},
                                                        {display: 'Amort.Adel.Dir.', name: 'IMP_AMORT_ADEL_DIR', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_AMORT_ADEL_DIR'] ; ?>},
                                                        {display: 'Amort.Adel.Mat.', name: 'IMP_AMORT_ADEL_MAT', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_AMORT_ADEL_MAT'] ; ?>},
                                                        {display: 'Amortización', name: 'IMP_AMORTIZACION', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_AMORTIZACION'] ; ?>},
                                                        {display: 'Saldo sin IGV', name: 'IMP_SALDO_SIN_IGV', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_SALDO_SIN_IGV'] ; ?>},
                                                        {display: 'Ded.Adel.Dir.', name: 'IMP_DEDUC_ADEL_DIR', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_DEDUC_ADEL_DIR'] ; ?>},
                                                        {display: 'Ded.Adel.Mat.', name: 'IMP_DEDUC_ADEL_MAT', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_DEDUC_ADEL_MAT'] ; ?>},
                                                        {display: 'Mto.Imponible', name: 'IMP_IMPONIBLE', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_IMPONIBLE'] ; ?>},
                                                        //{display: 'IGV (%)', name: 'PCT_IGV', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                        {display: 'IGV (18%)', name: 'IMP_IGV', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_IGV'] ; ?>},
                                                        {display: 'Neto Fact.', name: 'IMP_NETO', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_NETO'] ; ?>},
                                                        {display: 'Penalidad', name: 'IMP_PENALIDAD', width: GetColumnSize(4), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_PENALIDAD'] ; ?>},
                                                        {display: 'Retención', name: 'IMP_RETENCION', width: GetColumnSize(4), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_RETENCION'] ; ?>},
                                                        {display: 'Mto. Pagar', name: 'IMP_PAGO', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $Grilla_verBotones_montos['IMP_PAGO'] ; ?>},
                                                        {display: 'Estado', name: 'EST_ETAPA_CONTROL_DET', width: GetColumnSize(3), sortable: true, align: 'center', hide: true},
                                                        {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                /*EDGAR*/
                                                        {display: 'Archivo', name: 'Boton5', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                        {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(4), sortable: false, align: 'center', hide:<?php echo $crud['Seleccion']; ?>},
                                                        {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center', hide:<?php echo $crud['Modificar']; ?>},
                                                        {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center', hide:<?php echo $crud['Eliminar']; ?>}
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
                                                        //{display: 'Item', name: 'NUM_ITEM'},
                                                        {display: 'Año', name: 'NUM_ANIO'},
//                                                        {display: 'Mes', name: 'NUM_MES'},
                                                        {display: 'Concepto de Pago', name: 'DES_CONCEPTO_PAGO'}
                                                        ],
                                                        sortname: "NUM_ANIO,NUM_MES",
                                                        sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                        usepager: true, /* activa o descativa paginación */
                                                        singleSelect: true,
                                                        useRp: true,
                                                        rp: 100,
                                                        height: $("#datos").innerHeight,
                                                        query: '',
                                                        nowrap: false

                                                        /*EDGAR*/
                                                        , title: '<?php echo  $DatosPadre . '<hr>' . $Tabla_DatosPadre; ?>'
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


    $IDE_CONT_ETAPA_CONTROL_DET = $lCollection->Get('IDE_CONT_ETAPA_CONTROL_DET');
    $IDE_CONT_ETAPA_CONTROL = $lCollection->Get('IDE_CONT_ETAPA_CONTROL');
    $NUM_ITEM = $lCollection->Get('NUM_ITEM');
    $NUM_ANIO = $lCollection->Get('NUM_ANIO');
    $NUM_MES = $lCollection->Get('NUM_MES');
    $NUM_MES_PROVISION = $lCollection->Get('NUM_MES_PROVISION');
    $NUM_ANIO_PROVISION = $lCollection->Get('NUM_ANIO_PROVISION');
    $DES_CONCEPTO_PAGO = $lCollection->Get('DES_CONCEPTO_PAGO');
    $PCT_AVANCE = $lCollection->Get('PCT_AVANCE');
    $IMP_BRUTO = $lCollection->Get('IMP_BRUTO');
    $IMP_REAJUSTE = $lCollection->Get('IMP_REAJUSTE');
    $IMP_AMORT_ADEL_DIR = $lCollection->Get('IMP_AMORT_ADEL_DIR');
    $IMP_AMORT_ADEL_MAT = $lCollection->Get('IMP_AMORT_ADEL_MAT');
    $IMP_AMORTIZACION = $lCollection->Get('IMP_AMORTIZACION');
    $IMP_SALDO_SIN_IGV = $lCollection->Get('IMP_SALDO_SIN_IGV');
    $IMP_DEDUC_ADEL_DIR = $lCollection->Get('IMP_DEDUC_ADEL_DIR');
    $IMP_DEDUC_ADEL_MAT = $lCollection->Get('IMP_DEDUC_ADEL_MAT');
    $IMP_IMPONIBLE = $lCollection->Get('IMP_IMPONIBLE');
    $PCT_IGV = $lCollection->Get('PCT_IGV');
    $IMP_IGV = $lCollection->Get('IMP_IGV');
    $IMP_NETO = $lCollection->Get('IMP_NETO');
    $IMP_PENALIDAD = $lCollection->Get('IMP_PENALIDAD');
    $IMP_RETENCION = $lCollection->Get('IMP_RETENCION');
    $IMP_PAGO = $lCollection->Get('IMP_PAGO');
    $EST_ETAPA_CONTROL_DET = $lCollection->Get('EST_ETAPA_CONTROL_DET');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');

    /* para la herencia */
    $IDE_CONT_ETAPA_CONTROL = $PIDE; //codigo superior autocompleta
    $EST_ETAPA_CONTROL_DET = 1;
    $PCT_IGV = $lCollection->Get('BPCT_IGV');

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
    $VIDE_PLAN = $lCollection->Get('VIDE_PLAN');
    $VTIP_CONCEPTO = $lCollection->Get('VTIP_CONCEPTO');// echo 'VIDE_PLAN:'.$VIDE_PLAN.'<br>' ;

    $DatosPadre = Tabla_ProyectoComponente_Datos($VCOD_PROYECTO . ' - ' . $VDES_PROYECTO, $VDES_INTERVENCION, $VFEC_INICIO_CONTRATO, $VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE , $PIDE_PROY_COMPONENTE);

    $crudEliminar = $lCollection->Get('crudEliminar');
    /* ------------------------------------ */
    
    $Control_visualizar = Control_visualizar( $VIDE_INTERVENCION , $VIDE_PLAN , $VTIP_CONCEPTO );
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');
    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');
    $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');
    $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');
    $DataSet_GEN_TABLAS_5 = $lCollection->Get('DataSet_GEN_TABLAS_5');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Control Mensual de Etapa del Contrato"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Control Mensual de Etapa del Contrato"; //Nombre de la Tabla
        $NUM_ANIO = 21 ;
        $PCT_AVANCE = 0 ;
        $IMP_BRUTO = 0 ;
        $IMP_REAJUSTE = 0 ;
        $IMP_AMORT_ADEL_DIR = 0 ;
        $IMP_AMORT_ADEL_MAT = 0 ;
        $IMP_AMORTIZACION = 0 ;
        $IMP_SALDO_SIN_IGV = 0 ;
        $IMP_DEDUC_ADEL_DIR = 0 ;
        $IMP_DEDUC_ADEL_MAT = 0 ;
        $IMP_IMPONIBLE = 0 ;
        $IMP_IGV = 0 ;
        $IMP_NETO = 0 ;
        $IMP_PENALIDAD = 0 ;
        $IMP_RETENCION = 0 ;
        $IMP_PAGO = 0 ;
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

        function Equal_Anio_Provision(VAnio)
        {
            if (VAnio == 1) {
                var f = document.formulario.NUM_ANIO.value;
                document.formulario.NUM_ANIO_PROVISION.value = f;
            }
        

         }

        Equal_Anio_Provision(0);

        function Equal_Mes_Provision(VMes)
        {
            if (VMes == 1) {
                var f = document.formulario.NUM_MES.value;
                document.formulario.NUM_MES_PROVISION.value = f;
            }
        

         }

       
        Equal_Mes_Provision(0);
       


        
        function calcularPrioridad( VIDE_PLAN )
        {
            var color_open = '#b5e5ae' ;
            var color_close = '#eeacab' ;
            var color_chek = '' ;
            var check_AutoCalcular = document.formulario.chk_AutoCalcularMontos.checked ;
            
            var readonly_open = true ;
            var readonly_close = false ;
            var readonly_chek = null ;
            
            var v_IMP_BRUTO = 1*(document.formulario.IMP_BRUTO.value) ;
            var v_IMP_REAJUSTE = 1*(document.formulario.IMP_REAJUSTE.value) ;
            var v_IMP_AMORT_ADEL_DIR = 1*(document.formulario.IMP_AMORT_ADEL_DIR.value) ;
            var v_IMP_AMORT_ADEL_MAT = 1*(document.formulario.IMP_AMORT_ADEL_MAT.value) ;
            var v_IMP_AMORTIZACION = 1*(document.formulario.IMP_AMORTIZACION.value) ;
            var v_IMP_SALDO_SIN_IGV = 1*(document.formulario.IMP_SALDO_SIN_IGV.value) ; //

            var v_IMP_DEDUC_ADEL_DIR = 1*(document.formulario.IMP_DEDUC_ADEL_DIR.value) ;
            var v_IMP_DEDUC_ADEL_MAT = 1*(document.formulario.IMP_DEDUC_ADEL_MAT.value) ;
            var v_IMP_IMPONIBLE = 1*(document.formulario.IMP_IMPONIBLE.value) ; //

            var v_PCT_IGV = 1*(document.formulario.PCT_IGV.value) ;
            var v_IMP_IGV = 1*(document.formulario.IMP_IGV.value) ; //

            var v_IMP_NETO = 1*(document.formulario.IMP_NETO.value) ; //
            
            var v_IMP_PENALIDAD = 1*(document.formulario.IMP_PENALIDAD.value) ;
            var v_IMP_RETENCION = 1*(document.formulario.IMP_RETENCION.value) ;
            var v_IMP_PAGO = 1*(document.formulario.IMP_PAGO.value) ; //

            //alert('chek: '+ check_AutoCalcular ) ;
            if(check_AutoCalcular == true) {
                color_chek = color_open ;  // alert('chekSI: '+ check_AutoCalcular ) ;
                readonly_chek = readonly_open ;
                v_IMP_SALDO_SIN_IGV = v_IMP_BRUTO + v_IMP_REAJUSTE - (v_IMP_AMORT_ADEL_DIR + v_IMP_AMORT_ADEL_MAT) - v_IMP_AMORTIZACION ;
                v_IMP_IMPONIBLE = v_IMP_SALDO_SIN_IGV - v_IMP_DEDUC_ADEL_DIR - v_IMP_DEDUC_ADEL_MAT ;

                if (VIDE_PLAN==2){//EJECUTADO
                        v_IMP_IGV = v_PCT_IGV * v_IMP_IMPONIBLE ;
                        v_IMP_NETO = v_IMP_IMPONIBLE + v_IMP_IGV ;
                } else {//PROGRAMADO Y REPROGRAMADO
                        v_IMP_IGV = v_IMP_SALDO_SIN_IGV * v_PCT_IGV ;
                        
                        if( v_IMP_AMORTIZACION>0 ){
                            v_IMP_NETO = v_IMP_SALDO_SIN_IGV + v_IMP_IGV ;
                        } else {
                            v_IMP_NETO = v_IMP_BRUTO + v_IMP_IGV ;
                        }
                }

                v_IMP_PAGO = v_IMP_NETO - v_IMP_PENALIDAD - v_IMP_RETENCION ;


            } else {
                color_chek = color_close ;
                readonly_chek = readonly_close ;
            }
            
            //////// color 
            document.formulario.IMP_SALDO_SIN_IGV.style.background = color_chek ;
            document.formulario.IMP_IMPONIBLE.style.background = color_chek ;
            document.formulario.IMP_IGV.style.background = color_chek ;
            document.formulario.IMP_NETO.style.background = color_chek ;
            document.formulario.IMP_PAGO.style.background = color_chek ;
            
            //////// valores 
            document.formulario.IMP_SALDO_SIN_IGV.value = v_IMP_SALDO_SIN_IGV.toFixed(2) ;
            document.formulario.IMP_IMPONIBLE.value = v_IMP_IMPONIBLE.toFixed(2) ;
            document.formulario.IMP_IGV.value = v_IMP_IGV.toFixed(2) ;
            document.formulario.IMP_NETO.value = v_IMP_NETO.toFixed(2) ;
            document.formulario.IMP_PAGO.value = v_IMP_PAGO.toFixed(2) ;
            
            //////// valores 
            document.formulario.IMP_SALDO_SIN_IGV.readOnly = readonly_chek ;
            document.formulario.IMP_IMPONIBLE.readOnly = readonly_chek ;
            document.formulario.IMP_IGV.readOnly = readonly_chek ;
            document.formulario.IMP_NETO.readOnly = readonly_chek ;
            document.formulario.IMP_PAGO.readOnly = readonly_chek ;

        }
        


        calcularPrioridad(<?php echo $VIDE_PLAN ;?>);
        
        



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
            echo $DatosPadre . '<hr>' . $Tabla_DatosPadre . '<br>';
        }
        ?>
        <!--/*EDGAR*/-->

        <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_ETAPA_CONTROL_DET">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONT_ETAPA_CONTROL_DET" id="IDE_CONT_ETAPA_CONTROL_DET" value="<?php echo $IDE_CONT_ETAPA_CONTROL_DET; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_ETAPA_CONTROL">IdeContratoEtapaControl: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_CONT_ETAPA_CONTROL" id="IDE_CONT_ETAPA_CONTROL" value="<?php echo $IDE_CONT_ETAPA_CONTROL; ?>"  maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="IdeContratoEtapaControl"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="NUM_ITEM">Item: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_ITEM" id="NUM_ITEM" value="<?php echo $NUM_ITEM; ?>"  maxlength="25" type="text" class="number show-popover"  data-trigger="hover" data-content="Ingrese Item" style="width :14%" />					
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="NUM_ANIO">Año: <span class="error">*</span></label>
            <div class="controls" onchange = "Equal_Anio_Provision(1)">
                <!--<input  name="NUM_ANIO" id="NUM_ANIO" value="<?php // echo $NUM_ANIO; ?>"  maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Año"/>-->
                <?php comboNUM_ANIO('NUM_ANIO',$DataSet_GEN_TABLAS_3,$NUM_ANIO,1,"")?>	
            </div>
        </div>							


        <div class="control-group">
            <label class="control-label" for="NUM_MES">Mes: <span class="error">*</span></label>
            <div class="controls"  onchange = "Equal_Mes_Provision(1)"> 
                <!--<input  name="NUM_MES" id="NUM_MES" value="<?php // echo $NUM_MES;  ?>"  maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Mes"/>-->					
                <?php comboNUM_MES('NUM_MES', $DataSet_GEN_TABLAS_2, $NUM_MES, 1, "")  ?>	
            </div>
        </div>								

        <div class="control-group" style="<?php echo $Control_visualizar['NUM_ANIO_PROVISION'] ; ?>">
            <label class="control-label" for="NUM_ANIO_PROVISION">Año Provisión: <span class="error">*</span></label>
            <div class="controls">
                <?php comboNUM_ANIO_PROVISION('NUM_ANIO_PROVISION', $DataSet_GEN_TABLAS_5, $NUM_ANIO_PROVISION, 1, "") ?>	
            </div>
        </div>								

        <div class="control-group" style="<?php echo $Control_visualizar['NUM_MES_PROVISION'] ; ?>">
            <label class="control-label" for="NUM_MES_PROVISION">Mes Provisión: <span class="error">*</span></label>
            <div class="controls">
                <!--<input  name="NUM_MES_PROVISION" id="NUM_MES_PROVISION" value="<?php // echo $NUM_MES_PROVISION;  ?>"  maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Mes Provision 2"/>-->					
                <?php comboNUM_MES_PROVISION('NUM_MES_PROVISION', $DataSet_GEN_TABLAS_4, $NUM_MES_PROVISION, 1, "") ?>	
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_CONCEPTO_PAGO">Concepto de Pago: <span class="error">*</span></label>
            <div class="controls">
                <!--<textarea name="DES_CONCEPTO_PAGO" id="DES_CONCEPTO_PAGO" rows="5"  maxlength="150" class="xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese Concepto de pago" ><?php // echo $DES_CONCEPTO_PAGO; ?></textarea>-->				
                <input  name="DES_CONCEPTO_PAGO" id="DES_CONCEPTO_PAGO" value="<?php echo $DES_CONCEPTO_PAGO;?>"  maxlength="150" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Concepto de pago"/>
            </div>
        </div>						

        <legend>
            <label for="chk_AutoCalcularMontos"><input type="checkbox" checked id="chk_AutoCalcularMontos" name="chk_AutoCalcularMontos" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)" >Auto calcular montos (Verde)</label>
        </legend>





        <div class="control-group" style="<?php echo $Control_visualizar['PCT_AVANCE'] ; ?>" >
            <label class="control-label" for="PCT_AVANCE">Avance (%): <span class="error"></span></label>
            <div class="controls">
                <input  name="PCT_AVANCE" id="PCT_AVANCE" value="<?php echo $PCT_AVANCE; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Porcentaje" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>   
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_BRUTO'] ; ?>" >
            <label class="control-label" for="IMP_BRUTO">Monto Bruto : <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_BRUTO" id="IMP_BRUTO" value="<?php echo $IMP_BRUTO; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Bruto" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />			
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_REAJUSTE'] ; ?>" >
            <label class="control-label" for="IMP_REAJUSTE">Reajustes : <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_REAJUSTE" id="IMP_REAJUSTE" value="<?php echo $IMP_REAJUSTE; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Reajuste" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_AMORT_ADEL_DIR'] ; ?>" >
            <label class="control-label" for="IMP_AMORT_ADEL_DIR">Amort Adel. Directo : <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_AMORT_ADEL_DIR" id="IMP_AMORT_ADEL_DIR" value="<?php echo $IMP_AMORT_ADEL_DIR; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Amortización de Adelanto Directo" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_AMORT_ADEL_MAT'] ; ?>" >
            <label class="control-label" for="IMP_AMORT_ADEL_MAT">Amort. Adel. Materiales: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_AMORT_ADEL_MAT" id="IMP_AMORT_ADEL_MAT" value="<?php echo $IMP_AMORT_ADEL_MAT; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Amortización de Adelanto Materiales" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_AMORTIZACION'] ; ?>" >
            <label class="control-label" for="IMP_AMORTIZACION">Amortización : <span class="error"></span></label>
            <div class="controls">
                <input   name="IMP_AMORTIZACION" id="IMP_AMORTIZACION" value="<?php echo $IMP_AMORTIZACION; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Amortización" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_SALDO_SIN_IGV'] ; ?>" >
            <label class="control-label" for="IMP_SALDO_SIN_IGV">Saldo sin IGV : <span class="error"></span></label>
            <div class="controls">
                <input   name="IMP_SALDO_SIN_IGV" id="IMP_SALDO_SIN_IGV" value="<?php echo $IMP_SALDO_SIN_IGV; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Saldo sin IGV" style="width :14%; background-color:#b5e5ae;" />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_DEDUC_ADEL_DIR'] ; ?>" >
            <label class="control-label" for="IMP_DEDUC_ADEL_DIR">Deduc. Adel. Directo: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_DEDUC_ADEL_DIR" id="IMP_DEDUC_ADEL_DIR" value="<?php echo $IMP_DEDUC_ADEL_DIR; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Deductible de Adelanto Directo" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_DEDUC_ADEL_MAT'] ; ?>" >
            <label class="control-label" for="IMP_DEDUC_ADEL_MAT">Deduc. Adel. Materiales: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_DEDUC_ADEL_MAT" id="IMP_DEDUC_ADEL_MAT" value="<?php echo $IMP_DEDUC_ADEL_MAT; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Deductible de Adelanto Materiales" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_IMPONIBLE'] ; ?>" >
            <label class="control-label" for="IMP_IMPONIBLE">Monto Imponible: <span class="error"></span></label>
            <div class="controls">
                <input   name="IMP_IMPONIBLE" id="IMP_IMPONIBLE" value="<?php echo $IMP_IMPONIBLE; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Imponible" style="width :14%; background-color:#b5e5ae;" />					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="PCT_IGV">Porcentaje IGV: <span class="error"></span></label>
            <div class="controls">
                <input  name="PCT_IGV" id="PCT_IGV" value="<?php echo $PCT_IGV; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Porcentaje IGV" style="width :14%" />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_IGV'] ; ?>" >
            <label class="control-label" for="IMP_IGV">IGV (18%): <span class="error"></span></label>
            <div class="controls">
                <input   name="IMP_IGV" id="IMP_IGV" value="<?php echo $IMP_IGV; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe IGV" style="width :14%; background-color:#b5e5ae;" />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_NETO'] ; ?>" >
            <label class="control-label" for="IMP_NETO">Monto Neto Facturado : <span class="error"></span></label>
            <div class="controls">
                <input   name="IMP_NETO" id="IMP_NETO" value="<?php echo $IMP_NETO; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Neto" style="width :14%; background-color:#b5e5ae;" />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_PENALIDAD'] ; ?>" >
            <label class="control-label" for="IMP_PENALIDAD">Penalidad : <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_PENALIDAD" id="IMP_PENALIDAD" value="<?php echo $IMP_PENALIDAD; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Penalidad" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_RETENCION'] ; ?>" >
            <label class="control-label" for="IMP_RETENCION">Retención : <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_RETENCION" id="IMP_RETENCION" value="<?php echo $IMP_RETENCION; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Retención" style="width :14%" onchange="calcularPrioridad(<?php echo $VIDE_PLAN ; ?>)"  />					
            </div>
        </div>								


        <div class="control-group" style="<?php echo $Control_visualizar['IMP_PAGO'] ; ?>" >
            <label class="control-label" for="IMP_PAGO">Monto a Pagar : <span class="error"></span></label>
            <div class="controls">
                <input   name="IMP_PAGO" id="IMP_PAGO" value="<?php echo $IMP_PAGO; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Importe Pago" style="width :14%; background-color:#b5e5ae;" />					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="EST_ETAPA_CONTROL_DET">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_ETAPA_CONTROL_DET('EST_ETAPA_CONTROL_DET', $DataSet_GEN_TABLAS_1, $EST_ETAPA_CONTROL_DET, 1, "") ?>				
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

function comboNUM_MES($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Mes" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="" >Seleccione una Opción</option>        
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

function comboNUM_MES_PROVISION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Mes Provisión" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboNUM_ANIO_PROVISION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Año Provisión" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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


function comboEST_ETAPA_CONTROL_DET($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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

    

function comboNUM_ANIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Año" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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