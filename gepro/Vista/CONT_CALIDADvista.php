<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_CALIDADVISTA de la tabla CONT_CALIDAD
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-JEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/CONT_CALIDAD.js"></script>    


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
                    
                    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
                    
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
                                <li><a href="#tabs-1">Listado de Calidad de Entregables del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Calidad de Entregables del Contrato </a></li>
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&PIDE_PROYECTO=<?php echo $PIDE_PROYECTO; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'IdeContrato', name: 'IDE_CONTRATO', width: GetColumnSize(5), sortable: true, align: 'center', hide: true},
                                                            {display: 'Entregable', name: 'DES_ENTREGABLE', width: GetColumnSize(15.6), sortable: true, align: 'left', hide: false},
                                                            {display: 'Nº Revisión', name: 'NUM_REVISION', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Código Informe', name: 'COD_INFORME', width: GetColumnSize(8), sortable: true, align: 'left', hide: false},
                                                            {display: 'Fecha Informe', name: 'FEC_INFORME', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Administrador del Contrato', name: 'IDE_REC_REVISADO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Persona que Validó', name: 'IDE_REC_VALIDADO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Persona que Aprobó', name: 'IDE_REC_APROBADO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                            {display: 'Nº Obser.', name: 'CAN_OBSERVACIONES', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            /*EDGAR*/
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(8), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Contenido', name: 'EntregableObservado', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Adjuntos', name: 'Adjuntos', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php if ($VerSeleccion <> 'SI') { ?>               {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Nº Revisión', name: 'NUM_REVISION'},
                                                            {display: 'Código Informe', name: 'COD_INFORME'},
                                                            {display: 'Fecha Informe', name: 'FEC_INFORME'},
                                                            {display: 'Administrador del Contrato', name: 'IDE_REC_REVISADO'},
                                                            {display: 'Persona que Validó', name: 'IDE_REC_VALIDADO'},
                                                            {display: 'Persona que Aprobó', name: 'IDE_REC_APROBADO'},
                                                            {display: 'Nº Observ.', name: 'CAN_OBSERVACIONES'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION);  ?>'    <?php } ?>
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


                $IDE_CONT_CALIDAD = $lCollection->Get('IDE_CONT_CALIDAD');
                $IDE_CONTRATO = $lCollection->Get('IDE_CONTRATO');
                $IDE_ENTREGABLE = $lCollection->Get('IDE_ENTREGABLE');
                $NUM_REVISION = $lCollection->Get('NUM_REVISION');
                $COD_INFORME = $lCollection->Get('COD_INFORME');
                $FEC_INFORME = $lCollection->Get('FEC_INFORME');
                $IDE_REC_REVISADO = $lCollection->Get('IDE_REC_REVISADO');
                $IDE_REC_VALIDADO = $lCollection->Get('IDE_REC_VALIDADO');
                $IDE_REC_APROBADO = $lCollection->Get('IDE_REC_APROBADO');
                $DES_OBSERV_INFORME = $lCollection->Get('DES_OBSERV_INFORME');
                $CAN_OBSERVACIONES = $lCollection->Get('CAN_OBSERVACIONES');
                $EST_ENTREGABLE = $lCollection->Get('EST_ENTREGABLE');


                
                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $PIDE_PROYECTO = $lCollection->Get('PIDE_PROYECTO');
                $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');

                /* para la herencia */
                $IDE_CONTRATO = $PIDE;
                //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta

                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');
                
                $DES_ENTREGABLE = $lCollection->Get('DES_ENTREGABLE');
                
                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//        $BIDE = $Bdescripcion = "";
//        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//          $BIDE = $lCollection->Get('BIDE');;
//          $Bdescripcion = $lCollection->Get('Bdescripcion');
//        }
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                /* EDGAR */

                
                
                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_ENTREGABLE_1 = $lCollection->Get('DataSet_GEN_ENTREGABLE_1');


                $DataSet_GEN_RECURSO_1 = $lCollection->Get('DataSet_GEN_RECURSO_1');


                $DataSet_GEN_RECURSO_2 = $lCollection->Get('DataSet_GEN_RECURSO_2');


                $DataSet_GEN_RECURSO_3 = $lCollection->Get('DataSet_GEN_RECURSO_3');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Calidad de Entregables del Contrato"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Calidad de Entregables del Contrato"; //Nombre de la Tabla
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


        $('#FEC_INFORME').datepicker({
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
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>"> 
        <input type="hidden" name="PIDE_PROYECTO" value="<?php echo $PIDE_PROYECTO; ?>">
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
    <?php
    if ($PIDE > 0) {
        echo Tabla_Proyecto_Datos($PIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($VIDE_INTERVENCION);  
        echo '<br>';
    }
    ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_CALIDAD">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONT_CALIDAD" id="IDE_CONT_CALIDAD" value="<?php echo $IDE_CONT_CALIDAD; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONTRATO">Contrato: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_CONTRATO" id="IDE_CONTRATO" value="<?php echo $IDE_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Contrato"/>					
            </div>
        </div>								


<!--        <div class="control-group">
            <label class="control-label" for="IDE_ENTREGABLE">Entregable:<span class="error">*</span></label>
            <div class="controls"> 
    <?php // comboIDE_ENTREGABLE('IDE_ENTREGABLE', $DataSet_GEN_ENTREGABLE_1, $IDE_ENTREGABLE, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						-->

        
        <?php extraerIDEyValor_Text("IDE_ENTREGABLE", $IDE_ENTREGABLE, 'ESTANDAR', 'Entregable', 'DES_ENTREGABLE', $DES_ENTREGABLE, 'CONT_CALIDAD', 'width:50%','VerValor','','required','readonly' );  ?>


        <div class="control-group">
            <label class="control-label" for="NUM_REVISION">Num. Revisión : <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_REVISION" id="NUM_REVISION" value="<?php echo $NUM_REVISION; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Numero Revisión" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_INFORME">Código de Informe: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_INFORME" id="COD_INFORME" value="<?php echo $COD_INFORME; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class=" required show-popover"  data-trigger="hover" data-content="Ingrese Código de Informe" style='width:13.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="FEC_INFORME">Fecha de Informe:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_INFORME" id="FEC_INFORME" style="width: 10%" value="<?php echo $FEC_INFORME; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric required show-popover"  data-trigger="hover" data-content="Seleccione Fecha de Informe" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="IDE_REC_REVISADO">Administrador del Contrato:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_REC_REVISADO('IDE_REC_REVISADO', $DataSet_GEN_RECURSO_1, $IDE_REC_REVISADO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_REC_VALIDADO">Personal que Validó:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIDE_REC_VALIDADO('IDE_REC_VALIDADO', $DataSet_GEN_RECURSO_2, $IDE_REC_VALIDADO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_REC_APROBADO">Personal que Aprobó:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIDE_REC_APROBADO('IDE_REC_APROBADO', $DataSet_GEN_RECURSO_3, $IDE_REC_APROBADO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_OBSERV_INFORME">Comentarios: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERV_INFORME" id="DES_OBSERV_INFORME" rows="5" onChange="conMayusculas(this)" maxlength="1500" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Describa Observaciones del Informe" ><?php echo $DES_OBSERV_INFORME; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="CAN_OBSERVACIONES">Num. Observaciones: <span class="error"></span></label>
            <div class="controls">
                <input  name="CAN_OBSERVACIONES" id="CAN_OBSERVACIONES" value="<?php echo $CAN_OBSERVACIONES; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Número Observaciones del Informe" style='width:13.5%;' />					
            </div>
        </div>								


        <legend></legend>
         
        <div class="control-group">
            <label class="control-label" for="EST_ENTREGABLE">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_ENTREGABLE('EST_ENTREGABLE', $DataSet_GEN_TABLAS_1, $EST_ENTREGABLE, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

                <?php
            }

            /*             * *********************************************************************************
             * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
             * ********************************************************************************* */

            function comboIDE_ENTREGABLE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
                ?>    
    <select data-trigger="hover" data-content="Entregable" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_ENTREGABLE > 0)) {
            if ($lstDatos[$i]->IDE_ENTREGABLE == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ENTREGABLE . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ENTREGABLE . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ENTREGABLE . "\">" . $lstDatos[$i]->DES_ENTREGABLE . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    function comboIDE_REC_REVISADO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Personal que Revisó el Informe" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_REC_VALIDADO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Personal que Validó el Informe" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_REC_APROBADO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Personal que Aprobó el Informe" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_ENTREGABLE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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