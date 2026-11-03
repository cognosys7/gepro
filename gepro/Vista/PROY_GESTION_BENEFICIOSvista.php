<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_BENEFICIOSVISTA de la tabla PROY_GESTION_BENEFICIOS
  //  Fecha           : domingo, 26 de mayo de 2019 21:34:12
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_GESTION_BENEFICIOS.js"></script>    


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
        $PPROYECTO = $lCollection->Get('PPROYECTO');
        $PINTERVENCION = $lCollection->Get('PINTERVENCION');
        $VDES_COMUNIDAD = $lCollection->Get('VDES_COMUNIDAD');
        $VDES_UBIGEO = $lCollection->Get('VDES_UBIGEO');
        $VNUM_BENEFICIARIOS = $lCollection->Get('VNUM_BENEFICIARIOS');        
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
                                <li><a href="#tabs-1">Listado de Gestión de Beneficiarios del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Gestión de Beneficiado del Proyecto </a></li>
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
                                    <input type="hidden" name="PPROYECTO" value="<?php echo $PPROYECTO; ?>">
                                    <input type="hidden" name="PINTERVENCION" value="<?php echo $PINTERVENCION; ?>">
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
                                                            {display: 'Grupo Actividad', name: 'GRUPO', width: GetColumnSize(24), sortable: true, align: 'left', hide: false},
                                                            {display: 'Actividad', name: 'ACTIVIDAD', width: GetColumnSize(30), sortable: true, align: 'left', hide: false},
                                                            {display: 'Cantidad', name: 'CAN_CONCEPTO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fec. Inicio', name: 'FEC_INICIO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fec. Término', name: 'FEC_TERMINO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
                                                            {display: 'Archivo', name: 'Adjuntos', width: GetColumnSize(4), sortable: false, align: 'center' },
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
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
                                                            {display: 'Grupo Actividad', name: 'GRUPO'},
                                                            {display: 'Estado', name: 'Estado'}
                                                    ],
                                                            sortname: "GRUPO, FEC_INICIO",
                                                            sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                            usepager: true, /* activa o descativa paginación */
                                                            singleSelect: true,
                                                            useRp: true,
                                                            rp: 10,
                                                            height: $("#datos").innerHeight,
                                                            query: '',
                                                            nowrap: false

                                                            /*EDGAR*/
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PPROYECTO).'<hr>'. Tabla_Intervencion_Datos($PINTERVENCION). Tabla_GestionSocial_Datos_vs2($VDES_COMUNIDAD,$VDES_UBIGEO,$VNUM_BENEFICIARIOS); ;  ?>'    <?php } ?>
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


                $IDE_BENEF_SOCIAL = $lCollection->Get('IDE_BENEF_SOCIAL');
                $IDE_GESTION_SOCIAL = $lCollection->Get('IDE_GESTION_SOCIAL');
                $IDE_CONCEPTO = $lCollection->Get('IDE_CONCEPTO');
                $CAN_CONCEPTO = $lCollection->Get('CAN_CONCEPTO');
                $FEC_INICIO = $lCollection->Get('FEC_INICIO');
                $FEC_TERMINO = $lCollection->Get('FEC_TERMINO');
                $EST_BENEF_SOCIAL = $lCollection->Get('EST_BENEF_SOCIAL');
                $DES_ACTIVIDAD = $lCollection->Get('DES_ACTIVIDAD');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $PPROYECTO = $lCollection->Get('PPROYECTO');
                $PINTERVENCION = $lCollection->Get('PINTERVENCION');
                $VDES_COMUNIDAD = $lCollection->Get('VDES_COMUNIDAD');
                $VDES_UBIGEO = $lCollection->Get('VDES_UBIGEO');
                $VNUM_BENEFICIARIOS = $lCollection->Get('VNUM_BENEFICIARIOS');
                /* para la herencia */
                $IDE_GESTION_SOCIAL = $PIDE; //codigo superior autocompleta

                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');

                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//                $VIDE_COMUNIDAD = $VDES_COMUNIDAD = "";
//                if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//                    $VIDE_COMUNIDAD = $PIDEbuscado;
//                    $VDES_COMUNIDAD = $lCollection->Get('VDES_COMUNIDAD');
//                }
                
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');  
                /* EDGAR */

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_CONCEPTO_SOCIAL_1 = $lCollection->Get('DataSet_GEN_CONCEPTO_SOCIAL_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Gestión de Beneficios"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Gestión de Beneficios"; //Nombre de la Tabla
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
        ////// para extraer datos
        function CompruebaPaseDatos()
                {
                var f = parent.document.formulario;
    //            alert('por a intervenciones'+'<?php // echo $VIDE_COMUNIDAD.'-<br>'.$VDES_COMUNIDAD ; ?>');
    //            f.IDE_COMUNIDAD.value = '<?php // echo $VIDE_COMUNIDAD; ?>';
    //            f.DES_COMUNIDAD.value = '<?php // echo $VDES_COMUNIDAD; ?>';

                parent.$.colorbox.close();
                }

    <?php if ($PIDEbuscado > 0) { ?>
//            CompruebaPaseDatos();
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
    <?php echo Tabla_Proyecto_Datos($PPROYECTO).'<hr>'. Tabla_Intervencion_Datos($PINTERVENCION).Tabla_GestionSocial_Datos_vs2($VDES_COMUNIDAD,$VDES_UBIGEO,$VNUM_BENEFICIARIOS); ;  ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor("COD_UBIGEO", $COD_UBIGEO, 'ESTANDAR', 'UBIGEO', 'DES_UBIGEO', $DES_UBIGEO, 'UBIGEO', '', 'width:50%');  ?>

	<br>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_BENEF_SOCIAL">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_BENEF_SOCIAL" id="IDE_BENEF_SOCIAL" value="<?php echo $IDE_BENEF_SOCIAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_GESTION_SOCIAL">IdeGestionSocial: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_GESTION_SOCIAL" id="IDE_GESTION_SOCIAL" value="<?php echo $IDE_GESTION_SOCIAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="IdeGestionSocial"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_CONCEPTO">Grupo Actividad:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_CONCEPTO('IDE_CONCEPTO', $DataSet_GEN_CONCEPTO_SOCIAL_1, $IDE_CONCEPTO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						

        <div class="control-group">
            <label class="control-label" for="DES_ACTIVIDAD">Actividad: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_ACTIVIDAD" id="DES_ACTIVIDAD" rows="3" maxlength="1000" class="xlarge  required show-popover" data-trigger="hover" data-content="Ingrese la desviacion identificada"><?php echo $DES_ACTIVIDAD; ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="CAN_CONCEPTO">Cantidad: <span class="error">*</span></label>
            <div class="controls">
                <input  name="CAN_CONCEPTO" id="CAN_CONCEPTO" value="<?php echo $CAN_CONCEPTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Cantidad" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="FEC_INICIO">Fecha Inicio:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_INICIO" id="FEC_INICIO" style="width: 10%" value="<?php echo $FEC_INICIO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Inicio" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_TERMINO">Fecha Término:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_TERMINO" id="FEC_TERMINO" style="width: 10%" value="<?php echo $FEC_TERMINO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Término" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_BENEF_SOCIAL">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_BENEF_SOCIAL('EST_BENEF_SOCIAL', $DataSet_GEN_TABLAS_1, $EST_BENEF_SOCIAL, 1, "") ?>				
            </div>
        </div>  						


          

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_CONCEPTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Concepto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_CONCEPTO > 0)) {
            if ($lstDatos[$i]->IDE_CONCEPTO == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CONCEPTO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CONCEPTO . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CONCEPTO . "\">" . $lstDatos[$i]->DES_CONCEPTO . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
    <?php
}

function comboEST_BENEF_SOCIAL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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