<?php

/********************************************************************************
//  ==========================================
//  Empresa         : www.cognosys.com.pe
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                   
//  Propósito       : PROY_CONT_AMPLIACIONvista de la tabla PROY_CONT_AMPLIACION
//  Fecha           : martes, 25 de mayo de 2021 13:56:22
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 13:56:22
//******************************************************************************/

function muestraVista()
{
    $lCollection = Collection::Singleton();
    //INFORMACI�N DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK        = $lCollection->Get('PermisoOK');
?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css" />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_CONT_AMPLIACION.js"></script>


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen" />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <link rel="stylesheet" type="text/css" href="../recursos/css/include.css" />
    <!--/*EDGAR*/-->

    <script type="text/javascript">
        function cerrarPopup() {
            parent.$.colorbox.close();
            parent.$('#flex1').flexReload();
        }
        $(function() {
            $("#tabs").tabs({
                active: 0
            });
            $("#tabs").tabs({
                disabled: [1]
            });
        });

        function CallFlexiGrid() {
            $('#flex1').flexReload();
        }
    </script>
    <div id="Mensajes"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {

                    /*EDGAR*/
                    /* Inicializaci�n de variables auxiliares */
                    $PIDE = $lCollection->Get('PIDE');   // identificador de la tabla padre
                    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
                    $Recursiva_hide = $lCollection->Get('Recursiva_hide');
                    $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');

                    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
                    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                    //$VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');

                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = '';
                    $Pedido = $lCollection->Get('Pedido');
                    if ($Pedido == 'Busqueda') {
                        $FormularioAccion = 'PasarDatos';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
                    /* Obtiene el comportamiento de acceso CRUD segun el rol del usuario */
                    $crud = $lCollection->Get('crud');
                    /*EDGAR*/
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
                        <!-- CAMBIAR ETIQUETAS DE LAS PESTA�AS-->
                        <ul>
                            <li><a href="#tabs-1">Listado de Ampliación de Plazo </a></li>
                            <li><a href="#tabs-2">Detalle de Ampliación de Plazo </a></li>
                        </ul>
                        <!--CONTENIDO DE LA PESTA�A 1-->
                        <div id="tabs-1">


                            <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                <!-- PASO DE VARIABLES A OTRA P�GINA -->
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
                                        $("#flex1").flexigrid({
                                            /*Pagina php donde se realiza la consulta sql */
                                            url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>&Recursiva_Nivel_Actual=<?php echo $Recursiva_Nivel_Actual; ?>',
                                            /* Tipo de datos devuelto json, xml */
                                            dataType: 'json',
                                            /* Metodo de Envio de  Datos*/
                                            method: 'POST',
                                            /* Lista de campo a mostrar en cada columna */
                                            colModel: [{
                                                    display: 'Ide',
                                                    name: 'ID',
                                                    width: GetColumnSize(0),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: true
                                                },
                                                {
                                                    display: 'Orden',
                                                    name: 'NUM_ORDEN',
                                                    width: GetColumnSize(6),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Tipo Ampliación',
                                                    name: 'TIP_AMPLIACION',
                                                    width: GetColumnSize(15),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Nro. Amp / Susp',
                                                    name: 'NUM_AMPLIACION',
                                                    width: GetColumnSize(10),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Inicio',
                                                    name: 'FEC_INICIO',
                                                    width: GetColumnSize(8),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'DÍas Calendario',
                                                    name: 'DIAS_CALENDARIO',
                                                    width: GetColumnSize(8),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Término',
                                                    name: 'FEC_TERMINO',
                                                    width: GetColumnSize(8),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Nro Documento',
                                                    name: 'RESOLUCION',
                                                    width: GetColumnSize(20),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Estado',
                                                    name: 'Estado',
                                                    width: GetColumnSize(10),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Fila',
                                                    name: 'NFILA',
                                                    width: GetColumnSize(0),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: true
                                                },


                                                /*EDGAR*/
                                                {   display: 'Archivo', 
                                                    name: 'Adjuntos', 
                                                    width: GetColumnSize(4), 
                                                    sortable: false, 
                                                    align: 'center'
                                                },
                                                {
                                                    display: 'Ver',
                                                    name: 'Recursiva',
                                                    width: GetColumnSize(7),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $Recursiva_hide; ?>
                                                },
                                                {
                                                    display: 'Seleccionar',
                                                    name: 'Seleccionar',
                                                    width: GetColumnSize(6),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $crud['Seleccion']; ?>
                                                },
                                                {
                                                    display: 'Editar',
                                                    name: 'Boton1',
                                                    width: GetColumnSize(6),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $crud['Modificar']; ?>
                                                },
                                                {
                                                    display: 'Eliminar',
                                                    name: 'Boton2',
                                                    width: GetColumnSize(6),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $crud['Eliminar']; ?>
                                                }
                                                /*EDGAR*/
                                            ],
                                            /*Botones de Enlace*/
                                            buttons: [
                                                <?php if ($crud['Nuevo'] == 'true') { ?> {
                                                        name: 'Nuevo',
                                                        bclass: 'nuevo',
                                                        onpress: test
                                                    },
                                                <?php } ?> {
                                                    separator: true
                                                },
                                                {
                                                    name: 'Salir',
                                                    bclass: 'salir',
                                                    onpress: test
                                                }
                                            ],
                                            /*Lista de campo que se podra hacer busqueda */

                                            searchitems: [{
                                                display: 'Tipo Ampliacion',
                                                name: 'TIP_AMPLIACION'
                                            }],


                                            sortname: "NUM_ORDEN, FEC_TERMINO",
                                            sortorder: "ASC",
                                            /* ordenaor ascendente o descendente */

                                            usepager: true,
                                            /* activa o descativa paginaci�n */
                                            singleSelect: true,
                                            useRp: true,
                                            rp: 50,
                                            height: $("#datos").innerHeight,
                                            query: '',
                                            nowrap: false

                                                /*EDGAR*/

                                            , title: '<?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO).'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO); ?>'
                                            /*EDGAR*/
                                            //,showTableToggleBtn: true

                                        });
                                        /* Debe seleccionar una fila antes de pulsar el boton */
                                        function test(com, grid) {
                                            var nId = $('.trSelected', grid).children('td:eq(0)').text();
                                            if (com == 'Nuevo') {
                                                Nuevo('<?php echo $PaginaFormulario ?>');
                                            } else if (com == 'Salir') {
                                                cerrarPopup()
                                            } else {
                                                $('#mensaje').text('Debe Seleccionar un registro del listado').addClass('msjalerta')
                                            }
                                        }
                                    </script>
                                </div>
                            </form>
                        </div>
                        <!--PESTA�A 2-->
                        <div id="tabs-2">
                            <div id="FormularioDiv">
                                <!-- En esta seccion se muestra todos los datos recuperados del foumulario -->
                            </div>
                        </div>
                    </div>
                    <!--</div>-->
                <?php
                } else {
                    echo "<br><br><center>UD. NO TIENE ACCESO A ESTE M�DULO</center><br>";
                }
                ?>
            </div>
        </div>
    </div>
    <br><br>
<?php
}
//FUNCION PARA PROCESAR LOS MENSAJES DE LAS ACCIONES
function ProcesaMensaje()
{
    $lCollection = Collection::Singleton();
    $descmsje           = "";
    $sCodMensaje         = $lCollection->Get('CodMensaje');
    $sMensaje            = $lCollection->Get('Mensaje');
    if ($sCodMensaje <> "") {
        $descmsje = mensajesistema($sCodMensaje, $sMensaje);
    } else {
        $descmsje = mensajesistema($sMensaje);
    }
    echo $descmsje . "<br>";
}
//FUNCION UTILIZADA CUANDO SE REGISTRA O EDITA INFORMACI�N
function GeneraForm()
{
    $lCollection        = Collection::Singleton();
    $PaginaFormulario   = $lCollection->Get('PaginaFormulario');
    $PermisoOK          = $lCollection->Get('PermisoOK');

    //Recuperando valores para Mostrar en el Formulario
    $SeleccionarID    = $lCollection->Get('SeleccionarID');
    //$IdPersona        = $lCollection->Get('Id');


    $IDE_CONT_AMPLIACION     = $lCollection->Get('IDE_CONT_AMPLIACION');
    $NUM_ORDEN               = $lCollection->Get('NUM_ORDEN');
    $IDE_PROYECTO_ACTIVIDAD     = $lCollection->Get('IDE_PROYECTO_ACTIVIDAD');
    $TIP_AMPLIACION     = $lCollection->Get('TIP_AMPLIACION');
    $NUM_AMPLIACION     = $lCollection->Get('NUM_AMPLIACION');
    $FEC_INICIO_AMP     = $lCollection->Get('FEC_INICIO_AMP');
    $CAN_DIAS_CALENDARIO     = $lCollection->Get('CAN_DIAS_CALENDARIO');
    $FEC_TERMINO_AMP     = $lCollection->Get('FEC_TERMINO_AMP');
    $COD_RESOLUCION     = $lCollection->Get('COD_RESOLUCION');
    $EST_CONT_AMPLIACION     = $lCollection->Get('EST_CONT_AMPLIACION');


    /*EDGAR*/
    $PIDE = $lCollection->Get('PIDE');
    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
    /* EDGAR */

    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');

    /* para la herencia */
    $IDE_PROYECTO_ACTIVIDAD = $PIDE; //codigo superior autocompleta	

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    //        $BIDE = $Bdescripcion = "";
    //        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
    //          $BIDE = $lCollection->Get('BIDE');;
    //          $Bdescripcion = $lCollection->Get('Bdescripcion');
    //        }
    $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');
    //$NUM_NIVEL = intval($Recursiva_Nivel_Actual) ;                
    $crud = $lCollection->Get('crud');
    /*EDGAR*/

    /*LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX*/


    $DataSet_GEN_TABLAS_1    = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2    = $lCollection->Get('DataSet_GEN_TABLAS_2');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario   = "ActualizarForm";
        $Btn                = "Actualizar";
        $TitulFormulario    = "Actualizar Ampliación de Plazo"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario   = "RegistraDatos";
        $Btn                = "Registrar";
        $TitulFormulario    = "Registro de Ampliación de Plazo"; //Nombre de la Tabla
        $EST_CONT_AMPLIACION = 1 ;
    }
?>
    <script type="text/javascript">
        $(function() {
            //ACTIVA LOS TOOLTIPS
            $('*[data-content]').hover(function() {
                $(this).popover('show');
            });
            //VALIDACION DE FORMULARIO
            $("#BtnForm01").on("click", function() {
                if ($("#formulario").valid()) {
                    AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                }
            });
            //ACTIVAR PARA TRABAJAR CON FECHAS


            $('#FEC_INICIO_AMP').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO_AMP').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });



        });


        // Permite obtener los datos del formulario actual en modo modal y asignar al formulario que lo invoc�
        // La nomenclatura de las variables deben tomar el valor del formulario que invoc�
        function CompruebaPaseDatos() {
            var f = parent.document.formulario;
            //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ; 
                                                ?>');
            //            f.IDE.value = '<?php //echo $BIDE; 
                                            ?>';
            //            f.DES.value = '<?php //echo $Bdescripcion; 
                                            ?>';

            parent.$.colorbox.close();
        }

        <?php if ($PIDEbuscado > 0) {  ?>
            //CompruebaPaseDatos();
        <?php   }   ?>


        ////////// Función para calcular la fecha de término
        function calTermino() {
            var f                       = new String(document.formulario);
            var v_INI                   = new String(document.formulario.FEC_INICIO_AMP.value);
            var v_DC                    = Number(document.formulario.CAN_DIAS_CALENDARIO.value);
            var v_TER                   = new Date(Number(v_INI.substr(6,4).trim()),Number(v_INI.substr(3,2).trim())-1,Number(v_INI.substr(0,2).trim()));
            var check_AutoCalcular = document.formulario.chk_AutoCalcularFechaTermino.checked ;

            if (check_AutoCalcular == true) {
                if (v_INI == "") {
                    //document.formulario.FEC_TERMINO_AMP.value = " /  /    ";
                } else {
                    v_TER.setDate(v_TER.getDate()+v_DC);
                    //document.formulario.FEC_TERMINO_AMP.value = v_TER.getDate().toString().padStart(2,0) + "/" + v_TER.getMonth().toString().padStart(2,0)+ "/"+v_TER.getFullYear().toString(); 
                    document.formulario.FEC_TERMINO_AMP.value = v_TER.getDate().toString().padStart(2,0) + "/" + (v_TER.getMonth()+1).toString().padStart(2,0)+ "/"+v_TER.getFullYear().toString(); 
                } 
            }
        }  
        
        ////////// Función para habilitar la fecha de término
        function habilitar_FEC_TERMINO_AMP () {
            
            var check_AutoCalcular = document.formulario.chk_AutoCalcularFechaTermino.checked ;
            var color_open = '#b5e5ae' ;
            var color_close = '#eeacab' ;
            var color_chek = '' ;
            var readonly_open = true ;
            var readonly_close = false ;
            var readonly_chek = null ;
            var var_TIP_AMPLIACION = document.formulario.TIP_AMPLIACION.value ; 
            
            document.formulario.FEC_TERMINO_AMP.readOnly = readonly_close ;
            document.formulario.FEC_TERMINO_AMP.style.background = '#ffffff' ;
            color_chek = ( check_AutoCalcular == true ? color_open : color_close ) ;
            readonly_chek = ( check_AutoCalcular == true ? readonly_open : readonly_close ) ;
            
            if ( var_TIP_AMPLIACION =='3' ) {
                document.formulario.FEC_TERMINO_AMP.style.background = color_chek ;
                document.formulario.FEC_TERMINO_AMP.readOnly = readonly_chek ;
            } //alert('g'+var_TIP_AMPLIACION);
        }
        
        
        ////////// Función para calcular los días transcurridos entre dos fechas
        function calDiasCalendario () {
            
            var v_INI  = new String(document.formulario.FEC_INICIO_AMP.value) ;
            var v_TER  = new String(document.formulario.FEC_TERMINO_AMP.value) ;
            var check_AutoCalcular = document.formulario.chk_AutoCalcularFechaTermino.checked ;
            
            if (check_AutoCalcular == true) {
                if (v_INI != "") {
                    var aFecha1 = v_INI.split('/') ;
                    var aFecha2 = v_TER.split('/') ;
                    var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]) ;
                    var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]) ;
                    var dif = fFecha2 - fFecha1 ;
                    var v_DC = Math.floor(dif / (1000 * 60 * 60 * 24)) ;

                    document.formulario.CAN_DIAS_CALENDARIO.value = v_DC ;
                    //return v_DC ;
                }
            }
        }  
            //alert(calDiasCalendario());
          

        function filtrar_TIP_AMPLIACION () {
            var var_TIP_AMPLIACION = document.formulario.TIP_AMPLIACION.value ;         //   alert('TIP_AMPLIACION' + var_TIP_AMPLIACION);
            var verSI = 'block' ;
            var verNO = 'none' ;
            var checked_SI = true ;
            var checked_NO = false ;

            document.getElementById('div_NUM_ORDEN').style.display = verNO ;    
            document.getElementById('div_NUM_AMPLIACION').style.display = verNO ;
            document.getElementById('div_FEC_INICIO_AMP').style.display = verNO ;
            document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verNO ;
            document.getElementById('div_FEC_TERMINO_AMP').style.display = verNO ;
            document.getElementById('div_COD_RESOLUCION').style.display = verNO ;
            document.getElementById('div_chk_AutoCalcularFechaTermino').style.display = verNO ;

            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
            document.getElementById('txt_NUM_AMPLIACION').value = 'Nro. Ampliación' ;
            document.getElementById('txt_FEC_INICIO_AMP').value = 'Fecha Inicio' ;
            document.getElementById('txt_CAN_DIAS_CALENDARIO').value = 'Dias Calendario' ;
            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Fecha Término' ;
            document.getElementById('txt_COD_RESOLUCION').value = 'Nro. Resolución' ;
            
            document.getElementById('chk_AutoCalcularFechaTermino').checked = checked_NO ;

            switch ( var_TIP_AMPLIACION ) {
                case '1' :  
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Fecha Término' ;
                    break;
                case '2' :   
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Fecha Término' ;
                    break;
                case '3' :  
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_FEC_INICIO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_INICIO_AMP').value = 'Inicio Contractual' ;
                            document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Contractual' ;
                            document.getElementById('div_chk_AutoCalcularFechaTermino').style.display = verSI ;
                            document.getElementById('chk_AutoCalcularFechaTermino').checked = checked_SI ;
                    break;
                case '4' : 
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_NUM_AMPLIACION').style.display = verSI ;
                            document.getElementById('txt_NUM_AMPLIACION').value = 'Nro. Ampliación' ;
                            document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                            document.getElementById('txt_CAN_DIAS_CALENDARIO').value = 'Dias Calendario' ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Vigente' ;
                            document.getElementById('div_COD_RESOLUCION').style.display = verSI ;
                            document.getElementById('txt_COD_RESOLUCION').value = 'Nro. Resolución' ;
                    break;
                case '5' : 
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_NUM_AMPLIACION').style.display = verSI ;
                            document.getElementById('txt_NUM_AMPLIACION').value = 'Nro. Suspensión' ;
                            document.getElementById('div_FEC_INICIO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_INICIO_AMP').value = 'Inicio Suspensión' ;
                            document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                            document.getElementById('txt_CAN_DIAS_CALENDARIO').value = 'Dias Calendario' ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Suspensión' ;
                            document.getElementById('div_COD_RESOLUCION').style.display = verSI ;
                            document.getElementById('txt_COD_RESOLUCION').value = 'Acta de Suspensión' ;
                                                    
                    break;
                case '6' : 
                        document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                        document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                        document.getElementById('div_NUM_AMPLIACION').style.display = verSI ;
                        document.getElementById('txt_NUM_AMPLIACION').value = 'Nro. Reducción' ;
                        document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                        document.getElementById('txt_CAN_DIAS_CALENDARIO').value = 'Dias Calendario' ;
                        document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                        document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Vigente' ;
                        document.getElementById('div_COD_RESOLUCION').style.display = verSI ;
                        document.getElementById('txt_COD_RESOLUCION').value = 'Nro. Resolución' ;
                break;
                case '7' : 
                        document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                        document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                        document.getElementById('div_NUM_AMPLIACION').style.display = verSI ;
                        document.getElementById('txt_NUM_AMPLIACION').value = 'Nro. Ampliación' ;
                        document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                        document.getElementById('txt_CAN_DIAS_CALENDARIO').value = 'Dias Calendario' ;
                        document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                        document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Vigente' ;
                        document.getElementById('div_COD_RESOLUCION').style.display = verSI ;
                        document.getElementById('txt_COD_RESOLUCION').value = 'Nro. Resolución' ;
                break;
                case '8' :  
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_FEC_INICIO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_INICIO_AMP').value = 'Inicio Recepción' ;
                            document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Recepción' ;
                            document.getElementById('div_chk_AutoCalcularFechaTermino').style.display = verSI ;
                            document.getElementById('chk_AutoCalcularFechaTermino').checked = checked_SI ;
                            document.getElementById('div_COD_RESOLUCION').style.display = verSI ;
                            document.getElementById('txt_COD_RESOLUCION').value = 'Nro. Resolución' ;
                break;
                case '9' :  
                            document.getElementById('div_NUM_ORDEN').style.display = verSI ;
                            document.getElementById('txt_NUM_ORDEN').value = 'Nro. Orden' ;
                            document.getElementById('div_FEC_INICIO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_INICIO_AMP').value = 'Inicio Liquidación' ;
                            document.getElementById('div_CAN_DIAS_CALENDARIO').style.display = verSI ;
                            document.getElementById('div_FEC_TERMINO_AMP').style.display = verSI ;
                            document.getElementById('txt_FEC_TERMINO_AMP').value = 'Término Liquidación' ;
                            document.getElementById('div_chk_AutoCalcularFechaTermino').style.display = verSI ;
                            document.getElementById('chk_AutoCalcularFechaTermino').checked = checked_SI ;
                            document.getElementById('div_COD_RESOLUCION').style.display = verSI ;
                            document.getElementById('txt_COD_RESOLUCION').value = 'Nro. Resolución' ;
                break;
            }
            habilitar_FEC_TERMINO_AMP();

        }

        filtrar_TIP_AMPLIACION() ;



        
        function border_text () {
            document.getElementById("txt_FEC_TERMINO_AMP").style.border = "thick solid #0000FF"; 
        }
        


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

        <?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO); ?>

        <!--/*EDGAR*/-->
        <?php if ($PIDE > 0) {
            echo $Tabla_DatosPadre . '<br>';
        }
        ?>
        <style>
            .txtLabel { color: #FF0000; }
        </style>

        <!--/*EDGAR*/-->




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_AMPLIACION">Ide: <span class="error"></span></label>
            <div class="controls">

                <input name="IDE_CONT_AMPLIACION" id="IDE_CONT_AMPLIACION" value="<?php echo $IDE_CONT_AMPLIACION; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide" />

            </div>
        </div>

        <div class="control-group" id="div_NUM_ORDEN" >
            <label class="control-label" for="NUM_ORDEN"><input disabled name="txt_NUM_ORDEN" id="txt_NUM_ORDEN" value="" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /> <span class="error">*</span></label>
            <div class="controls">
                <input name="NUM_ORDEN" id="NUM_ORDEN" style="width: 5%" value="<?php echo $NUM_ORDEN; ?>" maxlength="2" type="text" class="number  show-popover" data-trigger="hover" data-content="Ingrese el Nro de Orden" />
            </div>
        </div>

        <div class="control-group" style="display:none"> 
            <label class="control-label" for="IDE_PROYECTO_ACTIVIDAD">IdeProyectoActividad: <span class="error">*</span></label>
            <div class="controls">
                <input name="IDE_PROYECTO_ACTIVIDAD" id="IDE_PROYECTO_ACTIVIDAD" value="<?php echo $IDE_PROYECTO_ACTIVIDAD; ?>" maxlength="25" type="text" class="number required show-popover" data-trigger="hover" data-content="IdeProyectoActividad" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="TIP_AMPLIACION" ><input disabled name="txt_TIP_AMPLIACION" id="txt_TIP_AMPLIACION" value="Tipo de Ampliación" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /><span class="error">*</span></label>
            <div class="controls">
                <?php comboTIP_AMPLIACION('TIP_AMPLIACION', $DataSet_GEN_TABLAS_1, $TIP_AMPLIACION, 1, ' onchange="filtrar_TIP_AMPLIACION()" ') ?>
            </div>
        </div>


        <div class="control-group" id="div_NUM_AMPLIACION" >
            <label class="control-label" for="NUM_AMPLIACION"><input disabled name="txt_NUM_AMPLIACION" id="txt_NUM_AMPLIACION" value="" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /> <span class="error">*</span></label>
            <div class="controls">
                <input name="NUM_AMPLIACION" id="NUM_AMPLIACION" style="width: 5%" value="<?php echo $NUM_AMPLIACION; ?>" maxlength="2" type="text" class="number  show-popover" data-trigger="hover" data-content="Ingrese el Nro de ampliación" />
            </div>
        </div>


        <div class="control-group" id="div_FEC_INICIO_AMP" >
            <label class="control-label" for="FEC_INICIO_AMP"><input disabled name="txt_FEC_INICIO_AMP" id="txt_FEC_INICIO_AMP" value="" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /> <span class="error">*</span></label>
            <div class="controls">
                <div class="span12">
                    <input name="FEC_INICIO_AMP" id="FEC_INICIO_AMP" style="width: 10%" value="<?php echo $FEC_INICIO_AMP; ?>" minlength="1" maxlength="10" type="text" class="alphanumeric  show-popover" data-trigger="hover" data-content="Selecione la fecha de inicio" onchange="calTermino()" placeholder="DD/MM/YYYY" />
                </div>
            </div>
        </div>


        <div class="control-group" id="div_CAN_DIAS_CALENDARIO" >
            <label class="control-label" for="CAN_DIAS_CALENDARIO"><input disabled name="txt_CAN_DIAS_CALENDARIO" id="txt_CAN_DIAS_CALENDARIO" value="" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /> <span class="error"></span></label>
            <div class="controls">
                <input name="CAN_DIAS_CALENDARIO" id="CAN_DIAS_CALENDARIO" style="width: 5%" value="<?php echo $CAN_DIAS_CALENDARIO; ?>" maxlength="4" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Días calendario"  onchange="calTermino()"/>
            </div>
        </div>


        <div class="control-group" id="div_FEC_TERMINO_AMP" >
            
            
            <label class="control-label" for="FEC_TERMINO_AMP" style="width:140px;"><input disabled name="txt_FEC_TERMINO_AMP" id="txt_FEC_TERMINO_AMP" value="" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /><span class="error">*</span></label>
            <div class="controls">
                <div class="span12">
                    <input name="FEC_TERMINO_AMP" id="FEC_TERMINO_AMP" style="width: 10%; " value="<?php echo $FEC_TERMINO_AMP; ?>" minlength="1" maxlength="10" type="text" class="alphanumeric  show-popover" data-trigger="hover" data-content="Selecione la fecha de inicio" onchange="calDiasCalendario()" placeholder="DD/MM/YYYY"  />
                </div>
                <div id="div_chk_AutoCalcularFechaTermino">
                    <label for="chk_AutoCalcularFechaTermino"><input type="checkbox"  id="chk_AutoCalcularFechaTermino" name="chk_AutoCalcularFechaTermino" onchange="calTermino(); habilitar_FEC_TERMINO_AMP();"  > Auto calcular Fecha Término</label>
                </div>
            </div>
        </div>


        <div class="control-group" id="div_COD_RESOLUCION" >
            <label class="control-label" for="COD_RESOLUCION"><input disabled name="txt_COD_RESOLUCION" id="txt_COD_RESOLUCION" value="" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /> <span class="error">*</span></label>
            <div class="controls">
                <input name="COD_RESOLUCION" id="COD_RESOLUCION" style="width: 20%" value="<?php echo $COD_RESOLUCION; ?>" maxlength="100" type="text" class="alphanumeric  show-popover" data-trigger="hover" data-content="Ingrese el Nro de Resolución" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="EST_CONT_AMPLIACION"><input disabled name="txt_EST_CONT_AMPLIACION" id="txt_EST_CONT_AMPLIACION" value="Estado" type="text" style="border:0; color:black; width:110px; background:white; cursor: pointer" /> <span class="error">*</span></label>
            <div class="controls">
                <?php comboEST_CONT_AMPLIACION('EST_CONT_AMPLIACION', $DataSet_GEN_TABLAS_2, $EST_CONT_AMPLIACION, 1, "") ?>
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
/***********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 ***********************************************************************************/



function comboTIP_AMPLIACION($nombre, $lstDatos, $valorInicial, $habil, $estilo)
{
?>
    <select data-trigger="hover" data-content="Seleccione el tipo de ampliación" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled" <?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
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

function comboEST_CONT_AMPLIACION($nombre, $lstDatos, $valorInicial, $habil, $estilo)
{
?>
    <select data-trigger="hover" data-content="Seleccione el estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled" <?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
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
