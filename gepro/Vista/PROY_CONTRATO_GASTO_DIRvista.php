<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_CONTRATO_GASTO_DIRVISTA de la tabla PROY_CONTRATO_GASTO_DIR
  //  Fecha           : martes, 28 de mayo de 2019 21:00:04
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-IEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_CONTRATO_GASTO_DIR.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <!--<link rel="stylesheet" type="text/css" href="../lib/css/include.css" />-->
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
                    $VIDE_CONTRATO_ETAPA = $lCollection->Get('VIDE_CONTRATO_ETAPA');
                    //$pAuxiliar = $lCollection->Get('pAuxiliar');
                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido') == 'Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if (strlen($Pedido) > 0) {
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
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
                                <li><a href="#tabs-1">Listado de Gasto Directos del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Gasto Directos del Contrato </a></li>
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
                                    <!--/*EDGAR*/-->

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Año', name: 'COD_ANHO_EJECUCION', width: GetColumnSize(4), sortable: true, align: 'center', hide: false},
                                                            {display: 'Centro de Costo', name: 'IDE_CENCOSTO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Cod. Espec', name: 'COD_ESPECIFICA_GASTO', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                            {display: 'Específica de Gasto', name: 'DES_ESPECIFICA_GASTO', width: GetColumnSize(12), sortable: true, align: 'left', hide: false},
                                                            {display: 'Cuenta Contable', name: 'IDE_CUENTA_CONTABLE', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                            {display: 'Fuente de Financiamiento', name: 'IDE_FTE_FTO', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                            {display: 'PIA', name: 'IMP_PIA', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'PIM', name: 'IMP_PIM', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Comprometido', name: 'IMP_COMPROMISO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Devengado', name: 'IMP_DEVENGADO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Pagado', name: 'IMP_GIRADO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
                                                                    /*<?php //if( $pAuxiliar=='Anidado' ) {   ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},   <?php //}   ?>   */
        <?php if ($VerSeleccion == 'SI') { ?>        {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'}
        <?php } else { ?>                              {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
                                                            {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Año', name: 'COD_ANHO_EJECUCION'},
                                                            {display: 'Centro de Costo', name: 'IDE_CENCOSTO'},
                                                            {display: 'Cod. Especifica', name: 'COD_ESPECIFICA_GASTO'},
                                                            {display: 'Específica de Gasto', name: 'DES_ESPECIFICA_GASTO'},
                                                            {display: 'Cuenta Contable', name: 'IDE_CUENTA_CONTABLE'},
                                                            {display: 'Fuente de Financiamiento', name: 'IDE_FTE_FTO'},
                                                            {display: 'Estado', name: 'Estado'}
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

                                                            /*EDGAR*/
        <?php if ($PIDE > 0) { ?>, title: '<?php //visTabla_DatosPadre($DatosPadre);   ?>'    <?php } ?>
                                                    /*EDGAR*/

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


    $IDE_CONTRATO_ETAPA = $lCollection->Get('IDE_CONTRATO_ETAPA');
    $COD_ANHO_EJECUCION = $lCollection->Get('COD_ANHO_EJECUCION');
    $IDE_CENCOSTO = $lCollection->Get('IDE_CENCOSTO');
    $IDE_ESPECIFICA_GASTO = $lCollection->Get('IDE_ESPECIFICA_GASTO');
    $IDE_CUENTA_CONTABLE = $lCollection->Get('IDE_CUENTA_CONTABLE');
    $IDE_FTE_FTO = $lCollection->Get('IDE_FTE_FTO');
    $IMP_PIA = $lCollection->Get('IMP_PIA');
    $IMP_PIM = $lCollection->Get('IMP_PIM');
    $IMP_COMPROMISO = $lCollection->Get('IMP_COMPROMISO');
    $IMP_DEVENGADO = $lCollection->Get('IMP_DEVENGADO');
    $IMP_GIRADO = $lCollection->Get('IMP_GIRADO');
    $EST_CONT_PRESUPUESTO = $lCollection->Get('EST_CONT_PRESUPUESTO');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');

    /* para la herencia */
    //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta

    /* para la visualizacion de busqueda */
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    /* para el padre buscado */
    //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');

    $B_CUENTA_CONTABLE = $lCollection->Get('B_CUENTA_CONTABLE');
    $B_ESPECIFICA_GASTO = $lCollection->Get('B_ESPECIFICA_GASTO');
    
    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    //$VIDE_COMUNIDAD = $VDES_COMUNIDAD = "";
    //if($PIDEbuscado>0) {  //echo 'es un echo';exit;
    // $VIDE_COMUNIDAD = $PIDEbuscado;
    // $VDES_COMUNIDAD = $lCollection->Get('VDES_COMUNIDAD');
    //}
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_CENTRO_COSTO_1 = $lCollection->Get('DataSet_GEN_CENTRO_COSTO_1');


    $DataSet_GEN_FUENTE_FINANCIAMIENTO_1 = $lCollection->Get('DataSet_GEN_FUENTE_FINANCIAMIENTO_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Gasto Directos del Contrato"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Gasto Directos del Contrato"; //Nombre de la Tabla
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
    //            alert('por a intervenciones'+'<?php // echo $VIDE_COMUNIDAD.'-<br>'.$VDES_COMUNIDAD ;  ?>');
    //            f.IDE_COMUNIDAD.value = '<?php //echo $VIDE_COMUNIDAD;  ?>';
    //            f.DES_COMUNIDAD.value = '<?php //echo $VDES_COMUNIDAD;  ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            //CompruebaPaseDatos();
    <?php } ?>

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
        <?php //visTabla_DatosPadre($DatosPadre);  ?>
        <!--/*EDGAR*/-->

        <?php //extraerIDEyValor("COD_UBIGEO", $COD_UBIGEO, 'ESTANDAR', 'UBIGEO', 'DES_UBIGEO', $DES_UBIGEO, 'UBIGEO', '', 'width:50%');  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONTRATO_ETAPA">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONTRATO_ETAPA" id="IDE_CONTRATO_ETAPA" value="<?php echo $IDE_CONTRATO_ETAPA; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="COD_ANHO_EJECUCION">Año Ejecución: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_ANHO_EJECUCION" id="COD_ANHO_EJECUCION" value="<?php echo $COD_ANHO_EJECUCION; ?>" onChange="conMayusculas(this)" maxlength="4" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Año Ejecución" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_CENCOSTO">Centro de Costo:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_CENCOSTO('IDE_CENCOSTO', $DataSet_GEN_CENTRO_COSTO_1, $IDE_CENCOSTO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


<!--        <div class="control-group">
            <label class="control-label" for="IDE_ESPECIFICA_GASTO">Especifica de Gasto: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_ESPECIFICA_GASTO" id="IDE_ESPECIFICA_GASTO" value="<?php // echo $IDE_ESPECIFICA_GASTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Seleccione Especifica de Gasto"/>					
            </div>
        </div>								-->
<?php extraerIDEyValor_Text("IDE_ESPECIFICA_GASTO", $IDE_ESPECIFICA_GASTO, 'ESTANDAR', 'Especifica de Gasto', 'B_ESPECIFICA_GASTO', $B_ESPECIFICA_GASTO, 'ESPECIFICA_GASTO' );   ?>


<!--        <div class="control-group">
            <label class="control-label" for="IDE_CUENTA_CONTABLE">Cuenta Contable: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_CUENTA_CONTABLE" id="IDE_CUENTA_CONTABLE" value="<?php // echo $IDE_CUENTA_CONTABLE; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Seleccione Cuenta Contable"/>					
            </div>
        </div>								-->
<?php extraerIDEyValor_Text("IDE_CUENTA_CONTABLE", $IDE_CUENTA_CONTABLE, 'ESTANDAR', 'Cuenta Contable', 'B_CUENTA_CONTABLE', $B_CUENTA_CONTABLE, 'CUENTA_CONTABLE' );   ?>

        <div class="control-group">
            <label class="control-label" for="IDE_FTE_FTO">Fuente de Financiamiento:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_FTE_FTO('IDE_FTE_FTO', $DataSet_GEN_FUENTE_FINANCIAMIENTO_1, $IDE_FTE_FTO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IMP_PIA">PIA: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_PIA" id="IMP_PIA" value="<?php echo $IMP_PIA; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese PIA" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_PIM">PIM: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_PIM" id="IMP_PIM" value="<?php echo $IMP_PIM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese PIM" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_COMPROMISO">Monto Comprometido: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_COMPROMISO" id="IMP_COMPROMISO" value="<?php echo $IMP_COMPROMISO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Comprometido" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_DEVENGADO">Monto Devengado: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_DEVENGADO" id="IMP_DEVENGADO" value="<?php echo $IMP_DEVENGADO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Devengado" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_GIRADO">Monto Pagado: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_GIRADO" id="IMP_GIRADO" value="<?php echo $IMP_GIRADO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Pagado" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_CONT_PRESUPUESTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_CONT_PRESUPUESTO('EST_CONT_PRESUPUESTO', $DataSet_GEN_TABLAS_1, $EST_CONT_PRESUPUESTO, 1, "") ?>				
            </div>
        </div>  						


        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_CENCOSTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Centro de Costo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_FTE_FTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Fuente de Financiamiento" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_FTE_FTO > 0)) {
                if ($lstDatos[$i]->IDE_FTE_FTO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_FTE_FTO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_FTE_FTO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_FTE_FTO . "\">" . $lstDatos[$i]->DES_FTE_FTO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_CONT_PRESUPUESTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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