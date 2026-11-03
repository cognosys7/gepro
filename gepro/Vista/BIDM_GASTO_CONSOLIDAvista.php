<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : BIDM_GASTO_CONSOLIDAvista de la tabla BIDM_GASTO_CONSOLIDA
//  Fecha           : martes, 25 de mayo de 2021 14:03:14
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:03:14
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/BIDM_GASTO_CONSOLIDA.js"></script>    


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
                            <li><a href="#tabs-1">Listado de Gasto Consolidado del Contrato </a></li>
                            <li><a href="#tabs-2">Detalle de Gasto Consolidado del Contrato </a></li>
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
                                                        {display: 'Asiento Periodo', name: 'AsientoPeriodo', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                        {display: 'Asiento', name: 'AsientoIde', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                        {display: 'Documento', name: 'AsientoNumDocumento', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                        {display: 'Monto (S/.)', name: 'AsientoMontoSoles', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                        {display: 'Año', name: 'AsientoAnio', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'CencoCodigo', name: 'CencoCodigo', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'CencoNombre', name: 'CencoNombre', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Contrato / Orden', name: 'ContratoOrden', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                        {display: 'Entregable', name: 'OrdenCodigo', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                        {display: 'ActorDocumento', name: 'ActorDocumento', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Proveedor', name: 'ActorNombre', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                        {display: 'ProyectoCodigo', name: 'ProyectoCodigo', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Componente', name: 'Componente', width: GetColumnSize(12), sortable: true, align: 'left', hide: false},
                                                        {display: 'Proyecto', name: 'ProyectoNombreCorto', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                        {display: 'Fuente', name: 'FuenteAbrev', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                        {display: 'ProyGrupoCodigo', name: 'ProyGrupoCodigo', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'CtaCodigo', name: 'CtaCodigo', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Partida', name: 'CtaNomPartida', width: GetColumnSize(12), sortable: true, align: 'center', hide: false},
                                                        {display: 'CtaNomClase', name: 'CtaNomClase', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'CtaNombre', name: 'CtaNombre', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Fase', name: 'Fase', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Estado', name: 'Estado', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                        {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                /*EDGAR*/
                                                                {display: 'Ver', name: 'Recursiva', width: GetColumnSize(7), sortable: false, align: 'center', hide:<?php echo $Recursiva_hide; ?>},
                                                        {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $crud['Seleccion']; ?>},
//                                                        {display: 'Editar', name: 'Boton1', width: GetColumnSize(4.5), sortable: false, align: 'center', hide:<?php echo $crud['Modificar']; ?>},
//                                                        {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4.5), sortable: false, align: 'center', hide:<?php echo $crud['Eliminar']; ?>}
                                                        /*EDGAR*/
                                                        ],
                                                        /*Botones de Enlace*/
                                                        buttons: [
        <?php if ($crud['Nuevo'] == 'true') { ?>                     /*   {name: 'Nuevo', bclass: 'nuevo', onpress: test},*/ <?php } ?>
                                                        {separator: true},
                                                        {name: 'Salir', bclass: 'salir', onpress: test}
                                                        ],
                                                        /*Lista de campo que se podra hacer busqueda */

                                                        searchitems: [
                                                        {display: 'Asiento', name: 'AsientoIde'},
                                                        {display: 'Documento', name: 'AsientoNumDocumento'},
                                                        {display: 'Asiento Periodo', name: 'AsientoPeriodo'},
                                                        {display: 'Contrato / Orden', name: 'ContratoOrden'},
                                                        {display: 'Entregable', name: 'OrdenCodigo'},
                                                        {display: 'Proveedor', name: 'ActorNombre'},
                                                        {display: 'Proyecto', name: 'ProyectoNombreCorto'},
                                                        {display: 'Partida', name: 'CtaNomPartida'},
                                                        {display: 'Fuente', name: 'FuenteAbrev'},
                                                        {display: 'Monto', name: 'AsientoMontoSoles'},
                                                        {display: 'Componente', name: 'Componente'}
                                                        ],
                                                        sortname: "AsientoPeriodo",
                                                        sortorder: "desc", /* ordenaor ascendente o descendente */

                                                        usepager: true, /* activa o descativa paginación */
                                                        singleSelect: true,
                                                        useRp: true,
                                                        rp: 10,
                                                        height: $("#datos").innerHeight,
                                                        query: '',
                                                        nowrap: false

                                                        /*EDGAR*/
                                                        , title: '<?php echo $Tabla_DatosPadre; ?>'
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
                        <div id="tabs-2" style="display:none">                           
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


    $IDE_BIDM_GASTO_CONSOLIDA = $lCollection->Get('IDE_BIDM_GASTO_CONSOLIDA');
    $AsientoIde = $lCollection->Get('AsientoIde');
    $AsientoNumDocumento = $lCollection->Get('AsientoNumDocumento');
    $AsientoAnio = $lCollection->Get('AsientoAnio');
    $AsientoPeriodo = $lCollection->Get('AsientoPeriodo');
    $CencoCodigo = $lCollection->Get('CencoCodigo');
    $CencoNombre = $lCollection->Get('CencoNombre');
    $ContratoOrden = $lCollection->Get('ContratoOrden');
    $OrdenCodigo = $lCollection->Get('OrdenCodigo');
    $ActorDocumento = $lCollection->Get('ActorDocumento');
    $ActorNombre = $lCollection->Get('ActorNombre');
    $ProyectoCodigo = $lCollection->Get('ProyectoCodigo');
    $ProyectoNombreCorto = $lCollection->Get('ProyectoNombreCorto');
    $ProyGrupoCodigo = $lCollection->Get('ProyGrupoCodigo');
    $CtaCodigo = $lCollection->Get('CtaCodigo');
    $CtaNomPartida = $lCollection->Get('CtaNomPartida');
    $CtaNomClase = $lCollection->Get('CtaNomClase');
    $CtaNombre = $lCollection->Get('CtaNombre');
    $FuenteAbrev = $lCollection->Get('FuenteAbrev');
    $AsientoMontoSoles = $lCollection->Get('AsientoMontoSoles');
    $Fase = $lCollection->Get('Fase');
    $Componente = $lCollection->Get('Componente');
    $EST_BIDM_GASTO_CONSOLIDA = $lCollection->Get('EST_BIDM_GASTO_CONSOLIDA');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');

    /* para la herencia */
    //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta

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
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Gasto Consolidado del Contrato"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Gasto Consolidado del Contrato"; //Nombre de la Tabla
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
    //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;  ?>');
    //            f.IDE.value = '<?php //echo $BIDE;  ?>';
    //            f.DES.value = '<?php //echo $Bdescripcion;  ?>';

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
    <?php
    if ($PIDE > 0) {
        echo $Tabla_DatosPadre . '<br>';
    }
    ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_BIDM_GASTO_CONSOLIDA">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_BIDM_GASTO_CONSOLIDA" id="IDE_BIDM_GASTO_CONSOLIDA" value="<?php echo $IDE_BIDM_GASTO_CONSOLIDA; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="AsientoIde">AsientoIde: <span class="error"></span></label>
            <div class="controls">
                <input  name="AsientoIde" id="AsientoIde" value="<?php echo $AsientoIde; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese AsientoIde"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="AsientoNumDocumento">AsientoNumDocumento: <span class="error"></span></label>
            <div class="controls">
                <input  name="AsientoNumDocumento" id="AsientoNumDocumento" value="<?php echo $AsientoNumDocumento; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese AsientoNumDocumento"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="AsientoAnio">AsientoAnio: <span class="error"></span></label>
            <div class="controls">
                <input  name="AsientoAnio" id="AsientoAnio" value="<?php echo $AsientoAnio; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese AsientoAnio"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="AsientoPeriodo">AsientoPeriodo: <span class="error"></span></label>
            <div class="controls">
                <input  name="AsientoPeriodo" id="AsientoPeriodo" value="<?php echo $AsientoPeriodo; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese AsientoPeriodo"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="CencoCodigo">CencoCodigo: <span class="error"></span></label>
            <div class="controls">
                <input  name="CencoCodigo" id="CencoCodigo" value="<?php echo $CencoCodigo; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese CencoCodigo"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="CencoNombre">CencoNombre: <span class="error"></span></label>
            <div class="controls">
                <textarea name="CencoNombre" id="CencoNombre" rows="5"  maxlength="500" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese CencoNombre" ><?php echo $CencoNombre; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="ContratoOrden">ContratoOrden: <span class="error"></span></label>
            <div class="controls">
                <input  name="ContratoOrden" id="ContratoOrden" value="<?php echo $ContratoOrden; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese ContratoOrden"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="OrdenCodigo">OrdenCodigo: <span class="error"></span></label>
            <div class="controls">
                <input  name="OrdenCodigo" id="OrdenCodigo" value="<?php echo $OrdenCodigo; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese OrdenCodigo"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="ActorDocumento">ActorDocumento: <span class="error"></span></label>
            <div class="controls">
                <input  name="ActorDocumento" id="ActorDocumento" value="<?php echo $ActorDocumento; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese ActorDocumento"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="ActorNombre">ActorNombre: <span class="error"></span></label>
            <div class="controls">
                <textarea name="ActorNombre" id="ActorNombre" rows="5"  maxlength="500" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese ActorNombre" ><?php echo $ActorNombre; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="ProyectoCodigo">ProyectoCodigo: <span class="error"></span></label>
            <div class="controls">
                <input  name="ProyectoCodigo" id="ProyectoCodigo" value="<?php echo $ProyectoCodigo; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese ProyectoCodigo"/>					
            </div>
        </div>								





        <div class="control-group">
            <label class="control-label" for="ProyGrupoCodigo">ProyGrupoCodigo: <span class="error"></span></label>
            <div class="controls">
                <input  name="ProyGrupoCodigo" id="ProyGrupoCodigo" value="<?php echo $ProyGrupoCodigo; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese ProyGrupoCodigo"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="CtaCodigo">CtaCodigo: <span class="error"></span></label>
            <div class="controls">
                <input  name="CtaCodigo" id="CtaCodigo" value="<?php echo $CtaCodigo; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese CtaCodigo"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="CtaNomPartida">CtaNomPartida: <span class="error"></span></label>
            <div class="controls">
                <textarea name="CtaNomPartida" id="CtaNomPartida" rows="5"  maxlength="500" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese CtaNomPartida" ><?php echo $CtaNomPartida; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="CtaNomClase">CtaNomClase: <span class="error"></span></label>
            <div class="controls">
                <input  name="CtaNomClase" id="CtaNomClase" value="<?php echo $CtaNomClase; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese CtaNomClase"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="CtaNombre">CtaNombre: <span class="error"></span></label>
            <div class="controls">
                <textarea name="CtaNombre" id="CtaNombre" rows="5"  maxlength="500" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese CtaNombre" ><?php echo $CtaNombre; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FuenteAbrev">FuenteAbrev: <span class="error"></span></label>
            <div class="controls">
                <input  name="FuenteAbrev" id="FuenteAbrev" value="<?php echo $FuenteAbrev; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese FuenteAbrev"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="AsientoMontoSoles">AsientoMontoSoles: <span class="error"></span></label>
            <div class="controls">
                <input  name="AsientoMontoSoles" id="AsientoMontoSoles" value="<?php echo $AsientoMontoSoles; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese AsientoMontoSoles"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="Fase">Fase: <span class="error"></span></label>
            <div class="controls">
                <input  name="Fase" id="Fase" value="<?php echo $Fase; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Fase"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="Componente">Componente: <span class="error"></span></label>
            <div class="controls">
                <input  name="Componente" id="Componente" value="<?php echo $Componente; ?>"  maxlength="50" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Componente"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_BIDM_GASTO_CONSOLIDA">Estado:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboEST_BIDM_GASTO_CONSOLIDA('EST_BIDM_GASTO_CONSOLIDA', $DataSet_GEN_TABLAS_1, $EST_BIDM_GASTO_CONSOLIDA, 1, "") ?>				
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

function comboEST_BIDM_GASTO_CONSOLIDA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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