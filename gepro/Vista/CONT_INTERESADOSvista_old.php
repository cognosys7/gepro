<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : CONT_INTERESADOSVISTA de la tabla CONT_INTERESADOS
  //  Fecha           : sábado, 25 de mayo de 2019 1:43:02
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-GEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/CONT_INTERESADOS.js"></script>    


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
                    $PIDE_PROYECTO = $lCollection->Get('PIDE_PROYECTO');
                    $PINTERVENCION = $lCollection->Get('PINTERVENCION');
                    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
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
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    $ProyectoExtractor = $lCollection->Get('ProyectoExtractor');
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
                                <li><a href="#tabs-1">Listado de Interesados del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Interesados del Contrato </a></li>
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
                                    <input type="hidden" name="PIDE_PROYECTO" value="<?php echo $PIDE_PROYECTO; ?>">
                                    <input type="hidden" name="PINTERVENCION" value="<?php echo $PINTERVENCION; ?>">
                                    <input type="hidden" name="PIDEbuscado" value="">
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                    <!--/*EDGAR*/-->

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar <?php echo ' - ' . $Pedido; ?><?php echo ' - '/*.$ProyectoExtractor*/; ?>
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&PIDE_PROYECTO=<?php echo $PIDE_PROYECTO; ?>&Pedido=<?php echo $Pedido; ?>&ProyectoExtractor=<?php echo $ProyectoExtractor; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
        <?php if ($Pedido == 'Busqueda') { ?>               {display: 'Contrato', name: 'COD_CONTRATO_ENTIDAD', width: GetColumnSize(7), sortable: false, align: 'left'},
                                                            {display: 'Fase-Componente', name: 'DES_INTERVENCION', width: GetColumnSize(8), sortable: false, align: 'left'},
        <?php } ?> 
                                                            {display: 'Personal', name: 'DES_RECURSO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Rol', name: 'DES_ROL', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Cargo', name: 'DES_CARGO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Localización', name: 'DES_LOCALIZACION', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                            {display: 'E-Mail', name: 'DES_MAIL', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                            {display: 'Telefono', name: 'DES_TELEFONO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Requerimientos', name: 'DES_REQUERIMIENTOS_PRIMORDIALES', width: GetColumnSize(16), sortable: true, align: 'left', hide: false},
                                                            {display: 'Expectativas', name: 'DES_EXPECTATIVAS_PRINCIPALES', width: GetColumnSize(16), sortable: true, align: 'left', hide: false},
                                                            {display: 'Tipo', name: 'Tipo', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                            {display: 'FIla', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            /*EDGAR*/
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(5), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(5), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
<?php if( $VerSeleccion <> 'SI' ) {   ?>                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},    <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
        <?php if ($Pedido == 'Busqueda') { ?>               {display: 'Contrato', name: 'COD_CONTRATO_ENTIDAD'},
                                                            {display: 'Fase-Componente', name: 'DES_INTERVENCION'},
        <?php } ?> 
                                                            {display: 'Personal', name: 'DES_RECURSO'},
                                                            {display: 'Rol', name: 'DES_ROL'},
                                                            {display: 'Cargo', name: 'DES_CARGO'},
                                                            {display: 'Localización', name: 'DES_LOCALIZACION'},
                                                            {display: 'E-Mail', name: 'DES_MAIL'},
                                                            {display: 'Requerimientos', name: 'DES_REQUERIMIENTOS_PRIMORDIALES'},
                                                            {display: 'Expectativas', name: 'DES_EXPECTATIVAS_PRINCIPALES'},
                                                            {display: 'Tipo', name: 'Tipo'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($PINTERVENCION); ?>'    <?php } ?>
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


    $IDE_CONT_INTERESADO = $lCollection->Get('IDE_CONT_INTERESADO');
    $IDE_CONTRATO = $lCollection->Get('IDE_CONTRATO');
    $IDE_RECURSO = $lCollection->Get('IDE_RECURSO');
    $IDE_ROL = $lCollection->Get('IDE_ROL');
    $IDE_PUESTO = $lCollection->Get('IDE_PUESTO');
    $DES_LOCALIZACION = $lCollection->Get('DES_LOCALIZACION');
    $DES_MAIL = $lCollection->Get('DES_MAIL');
    $DES_TELEFONO = $lCollection->Get('DES_TELEFONO');
    $DES_REQUERIMIENTOS_PRIMORDIALES = $lCollection->Get('DES_REQUERIMIENTOS_PRIMORDIALES');
    $DES_EXPECTATIVAS_PRINCIPALES = $lCollection->Get('DES_EXPECTATIVAS_PRINCIPALES');
    $TIP_INFLUENCIA_POTENCIAL = $lCollection->Get('TIP_INFLUENCIA_POTENCIAL');
    $DES_FASE_MAYOR_INTERES = $lCollection->Get('DES_FASE_MAYOR_INTERES');
    $TIP_INTERNO_EXTERNO = $lCollection->Get('TIP_INTERNO_EXTERNO');
    $TIP_CLASIFICACION = $lCollection->Get('TIP_CLASIFICACION');
    $DES_INTERES_PROYECTO = $lCollection->Get('DES_INTERES_PROYECTO');
    $TIP_EVALUACION_IMPACTO = $lCollection->Get('TIP_EVALUACION_IMPACTO');
    $DES_ESTRATEGIA_PRINCIPAL = $lCollection->Get('DES_ESTRATEGIA_PRINCIPAL');
    $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
    $EST_CONT_INTERESADO = $lCollection->Get('EST_CONT_INTERESADO');
    $USER_INSERT = $lCollection->Get('USER_INSERT');
    $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
    $USER_UPDATE = $lCollection->Get('USER_UPDATE');
    $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $PIDE_PROYECTO = $lCollection->Get('PIDE_PROYECTO');
    $PINTERVENCION = $lCollection->Get('PINTERVENCION');
    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');

    /* para la herencia */
    if ($PIDE > 0) {     $IDE_CONTRATO = $PIDE; } //codigo superior autocompleta

    /* para la visualizacion de busqueda */
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    /* para el padre buscado */
    //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
    $B_RECURSO = $lCollection->Get('Bdescripcion');

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    $BIDE = $Bdescripcion = "";
    if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
        $BIDE = $lCollection->Get('BIDE');;
        $Bdescripcion = $lCollection->Get('Bdescripcion');
    }
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    
    
    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_RECURSO_1 = $lCollection->Get('DataSet_GEN_RECURSO_1');


    $DataSet_GEN_ROLES_1 = $lCollection->Get('DataSet_GEN_ROLES_1');


    $DataSet_GEN_CARGO_1 = $lCollection->Get('DataSet_GEN_CARGO_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


    $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


    $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');


    $DataSet_GEN_TABLAS_5 = $lCollection->Get('DataSet_GEN_TABLAS_5');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Interesados del Proyecto"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Interesados del Proyecto"; //Nombre de la Tabla
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
         buttonImage: '<?php // echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
         shortYearCutoff: '+100'
         });
         */
        });
        ////// para extraer datos
        function CompruebaPaseDatos()
        {
            var f = parent.document.formulario;
//            alert('por a intervenciones' + '<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;  ?>');
            f.IDE_CONT_INTERESADO.value = '<?php echo $BIDE;  ?>';
            f.BCONT_INTERESADO.value = '<?php echo $Bdescripcion;  ?>';

            parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            CompruebaPaseDatos();
    <?php } ?>

    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <!--<input type="hidden" name="PIDE" value="<?php // echo $PIDE  ?>">-->
        <!--<input type="hidden" name="PIDE_PROYECTO" value="<?php // echo $PIDE_PROYECTO;  ?>">-->
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
<?php   if ($PIDE > 0) {  
            echo Tabla_Proyecto_Datos($PIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($PINTERVENCION);  
            echo '<br>'; 
        }
?>
        <!--/*EDGAR*/-->

        <table width='100%'>
            <tr>
                <td><strong>I. DATOS DEL INTERESADO EN EL PROYECTO</strong> 
                    <!--                <br>
                                    ( Gestión de Consultorias, Ejecución de Consultorias, Ejecución de Obra, Supervisión de Obras, Operación, Mantenimiento y Post Cierre )-->
                </td>
            </tr>

            <tr>
                <td>   


                    

                    <div class="control-group" style="display:none">
                        <label class="control-label" for="IDE_CONT_INTERESADO">Ide: <span class="error"></span></label>
                        <div class="controls">

                            <input  name="IDE_CONT_INTERESADO" id="IDE_CONT_INTERESADO" value="<?php echo $IDE_CONT_INTERESADO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

                        </div>
                    </div>		




                    <div class="control-group" style="display:none">
                        <label class="control-label" for="IDE_CONTRATO">Contrato: <span class="error">*</span></label>
                        <div class="controls">
                            <input  name="IDE_CONTRATO" id="IDE_CONTRATO" value="<?php echo $IDE_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Contrato"/>					
                        </div>
                    </div>								



<!--                    <div class="control-group">
                        <label class="control-label" for="IDE_RECURSO">Recurso:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php // comboIDE_RECURSO('IDE_RECURSO', $DataSet_GEN_RECURSO_1, $IDE_RECURSO, 1, " style='width: 51%;' ") ?>				
                        </div>
                    </div>  						-->
                    <?php extraerIDEyValor_Text("IDE_RECURSO", $IDE_RECURSO, 'ESTANDAR', 'Recurso', 'DESCRIPCIONRECURSO', $B_RECURSO, 'RECURSO' );   ?>


                    <div class="control-group">
                        <label class="control-label" for="IDE_ROL">Rol:<span class="error"></span></label>
                        <div class="controls"> 
                            <?php comboIDE_ROL('IDE_ROL', $DataSet_GEN_ROLES_1, $IDE_ROL, 1, " style='width: 51%;' ") ?>				
                        </div>
                    </div>  						



                    <div class="control-group">
                        <label class="control-label" for="IDE_PUESTO">Cargo:<span class="error"></span></label>
                        <div class="controls"> 
                            <?php comboIDE_PUESTO('IDE_PUESTO', $DataSet_GEN_CARGO_1, $IDE_PUESTO, 1, " style='width: 51%;' ") ?>				
                        </div>
                    </div>  						



                    <div class="control-group">
                        <label class="control-label" for="DES_LOCALIZACION">Localización: <span class="error">*</span></label>
                        <div class="controls">
                            <input  name="DES_LOCALIZACION" id="DES_LOCALIZACION" value="<?php echo $DES_LOCALIZACION; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Localización"/>					
                        </div>
                    </div>								




                    <div class="control-group">
                        <label class="control-label" for="DES_MAIL">E-Mail: <span class="error"></span></label>
                        <div class="controls">
                            <input  name="DES_MAIL" id="DES_MAIL" value="<?php echo $DES_MAIL; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class=" show-popover" data-trigger="hover" data-content="Ingrese E-Mail"/>					
                        </div>
                    </div>								




                    <div class="control-group">
                        <label class="control-label" for="DES_TELEFONO">Telefono: <span class="error"></span></label>
                        <div class="controls">
                            <input  name="DES_TELEFONO" id="DES_TELEFONO" value="<?php echo $DES_TELEFONO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="  show-popover"  data-trigger="hover" data-content="Ingrese Telefono"/>					
                        </div>
                    </div>								



                    <div class="control-group">
                        <label class="control-label" for="TIP_INTERNO_EXTERNO">Pertenecia Institucional:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboTIP_INTERNO_EXTERNO('TIP_INTERNO_EXTERNO', $DataSet_GEN_TABLAS_2, $TIP_INTERNO_EXTERNO, 1, "") ?>				
                        </div>
                    </div>  						




                </td>
            </tr>
        </table> 



        <legend></legend>

        <table width='100%'>
            <tr>
                <td><strong>II. ASPECTOS PRINCIPALES DEL INTERESADO EN EL PROYECTO</strong> 
                    <!--                <br>
                                    ( Gestión de Consultorias, Ejecución de Consultorias, Ejecución de Obra, Supervisión de Obras, Operación, Mantenimiento y Post Cierre )-->
                </td>
            </tr>

            <tr>
                <td>        



                    <div class="control-group">
                        <label class="control-label" for="DES_REQUERIMIENTOS_PRIMORDIALES">Requerimientos : <span class="error">*</span></label>
                        <div class="controls">
                            <textarea name="DES_REQUERIMIENTOS_PRIMORDIALES" id="DES_REQUERIMIENTOS_PRIMORDIALES" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese Requerimientos Principales" ><?php echo $DES_REQUERIMIENTOS_PRIMORDIALES; ?></textarea>				
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="DES_EXPECTATIVAS_PRINCIPALES">Expectativas : <span class="error">*</span></label>
                        <div class="controls">
                            <textarea name="DES_EXPECTATIVAS_PRINCIPALES" id="DES_EXPECTATIVAS_PRINCIPALES" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese Expectativas Principales" ><?php echo $DES_EXPECTATIVAS_PRINCIPALES; ?></textarea>				
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="DES_ESTRATEGIA_PRINCIPAL">Estrategia : <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_ESTRATEGIA_PRINCIPAL" id="DES_ESTRATEGIA_PRINCIPAL" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Estrategia Principal" ><?php echo $DES_ESTRATEGIA_PRINCIPAL; ?></textarea>				
                        </div>
                    </div>						



                </td>
            </tr>
        </table> 



        <legend></legend>



        <table width='100%'>
            <tr>
                <td><strong>III. INFLUENCIA E IMPACTO DEL INTERESADO EN EL PROYECTO</strong> 
                    <!--                <br>
                                    ( Gestión de Consultorias, Ejecución de Consultorias, Ejecución de Obra, Supervisión de Obras, Operación, Mantenimiento y Post Cierre )-->
                </td>
            </tr>

            <tr>
                <td> 




                    <div class="control-group">
                        <label class="control-label" for="TIP_CLASIFICACION">Tipo de Interesado:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboTIP_CLASIFICACION('TIP_CLASIFICACION', $DataSet_GEN_TABLAS_3, $TIP_CLASIFICACION, 1, "") ?>				
                        </div>
                    </div>  						


                    <div class="control-group">
                        <label class="control-label" for="TIP_INFLUENCIA_POTENCIAL">Tipo Influencia:<span class="error"></span></label>
                        <div class="controls"> 
                            <?php comboTIP_INFLUENCIA_POTENCIAL('TIP_INFLUENCIA_POTENCIAL', $DataSet_GEN_TABLAS_1, $TIP_INFLUENCIA_POTENCIAL, 1, "") ?>				
                        </div>
                    </div>  						


                    <div class="control-group">
                        <label class="control-label" for="TIP_EVALUACION_IMPACTO">Impacto de su evaluación:<span class="error"></span></label>
                        <div class="controls"> 
                            <?php comboTIP_EVALUACION_IMPACTO('TIP_EVALUACION_IMPACTO', $DataSet_GEN_TABLAS_4, $TIP_EVALUACION_IMPACTO, 1, "") ?>				
                        </div>
                    </div>  



                    <div class="control-group">
                        <label class="control-label" for="DES_INTERES_PROYECTO">Interés del Proyecto: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_INTERES_PROYECTO" id="DES_INTERES_PROYECTO" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Interés del Proyecto" ><?php echo $DES_INTERES_PROYECTO; ?></textarea>				
                        </div>
                    </div>	



                    <div class="control-group">
                        <label class="control-label" for="DES_FASE_MAYOR_INTERES">Fase de mayor Interés: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_FASE_MAYOR_INTERES" id="DES_FASE_MAYOR_INTERES" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Fase de mayor Interés" ><?php echo $DES_FASE_MAYOR_INTERES; ?></textarea>				
                        </div>
                    </div>						


                </td>
            </tr>
        </table> 



        <legend></legend>




        <div class="control-group">
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Observación" ><?php echo $DES_OBSERVACION; ?></textarea>				
            </div>
        </div>						





        <div class="control-group">
            <label class="control-label" for="EST_CONT_INTERESADO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_CONT_INTERESADO('EST_CONT_INTERESADO', $DataSet_GEN_TABLAS_5, $EST_CONT_INTERESADO, 1, "") ?>				
            </div>
        </div>  						



 

        <?php echo $crudGrabarCancelar; ?> 

  
        
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_RECURSO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Recurso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_RECURSO > 0)) {
                if ($lstDatos[$i]->IDE_RECURSO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_RECURSO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_RECURSO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_RECURSO . "\">" . $lstDatos[$i]->DES_RECURSO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_ROL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Rol" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_ROL > 0)) {
                if ($lstDatos[$i]->IDE_ROL == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ROL . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ROL . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ROL . "\">" . $lstDatos[$i]->DES_ROL . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_PUESTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Cargo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_CARGO > 0)) {
                if ($lstDatos[$i]->IDE_CARGO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CARGO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CARGO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CARGO . "\">" . $lstDatos[$i]->DES_CARGO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboTIP_INFLUENCIA_POTENCIAL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Influencia" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_INTERNO_EXTERNO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Pertenecia Institucional" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_CLASIFICACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Clasificación de Interes" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_EVALUACION_IMPACTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Evaluación de Impacto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_CONT_INTERESADO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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