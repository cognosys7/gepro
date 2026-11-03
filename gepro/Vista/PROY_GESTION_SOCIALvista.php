<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_SOCIALVISTA de la tabla PROY_GESTION_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 4:35:47
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_GESTION_SOCIAL.js"></script>    


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
                                <li><a href="#tabs-1">Listado de Gestión Social del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Gestión Social del Proyecto </a></li>
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
                                                            {display: 'Proyecto', name: 'DES_LARGA_PROYECTO', width: GetColumnSize(23), sortable: true, align: 'left', hide: true},
                                                            {display: 'Comunidad / CC.PP.', name: 'DES_COMUNIDAD', width: GetColumnSize(21), sortable: true, align: 'left', hide: false},
                                                            {display: 'Fase - Componente', name: 'DES_INTERVENCION', width: GetColumnSize(17.5), sortable: true, align: 'left', hide: false},
                                                            {display: 'Beneficiarios', name: 'NUM_BENEFICIARIOS', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Tipo Beneficiario', name: 'TipoBeneficiario', width: GetColumnSize(6.5), sortable: true, align: 'center', hide: true},
                                                            {display: 'Descripción de Beneficiarios', name: 'DES_UNIDAD_BENEFICIARIO', width: GetColumnSize(11.2), sortable: true, align: 'left', hide: true},
                                                            {display: 'Mapa Actores Soc.', name: 'EST_MATRIZ_RC', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Acta Comf.?', name: 'EST_ACTA_APROBACION', width: GetColumnSize(5), sortable: true, align: 'center', hide: true},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
                                                            {display: 'Beneficios', name: 'GestBeneficios', width: GetColumnSize(8), sortable: false, align: 'center'}, 
                                                            {display: 'Interesados', name: 'GestInteresados', width: GetColumnSize(8), sortable: false, align: 'center'},  
                                                            {display: 'Quejas', name: 'GestQuejas', width: GetColumnSize(8), sortable: false, align: 'center'},  
                                                            {display: 'Actividades', name: 'GestActividades', width: GetColumnSize(8), sortable: false, align: 'center'},  
                                                            
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(7), sortable: false, align: 'center'}
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
                                                            {display: 'Proyecto', name: 'DES_LARGA_PROYECTO'},
                                                            {display: 'Comunidad / CC.PP.', name: 'DES_COMUNIDAD'},
                                                            {display: 'Fase - Componente', name: 'DES_INTERVENCION'},
                                                            {display: 'Tipo Benefi.', name: 'TipoBeneficiario'},
                                                            {display: 'Descripción de Beneficiarios', name: 'DES_UNIDAD_BENEFICIARIO'},
                                                            {display: 'Matriz RC?', name: 'EST_MATRIZ_RC'},
                                                            {display: 'Acta Comf.?', name: 'EST_ACTA_APROBACION'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE);  ?>'    <?php } ?>
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


                $IDE_GESTION_SOCIAL = $lCollection->Get('IDE_GESTION_SOCIAL');
                $IDE_PROYECTO = $lCollection->Get('IDE_PROYECTO');
                $IDE_COMUNIDAD = $lCollection->Get('IDE_COMUNIDAD');
                $IDE_ETAPA_CONTRATO = $lCollection->Get('IDE_ETAPA_CONTRATO');
                $NUM_BENEFICIARIOS = $lCollection->Get('NUM_BENEFICIARIOS');
                $TIP_UNIDAD_BENEFICIARIO = $lCollection->Get('TIP_UNIDAD_BENEFICIARIO');
                $DES_UNIDAD_BENEFICIARIO = $lCollection->Get('DES_UNIDAD_BENEFICIARIO');
                $EST_MATRIZ_RC = $lCollection->Get('EST_MATRIZ_RC');
                $EST_ACTA_APROBACION = $lCollection->Get('EST_ACTA_APROBACION');
                $EST_GESTION_SOCIAL = $lCollection->Get('EST_GESTION_SOCIAL');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                
                /* para la herencia */
                $IDE_PROYECTO = $PIDE; //codigo superior autocompleta

                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
                $B_COMUNIDAD = $lCollection->Get('Bdescripcion');
                
                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//                $VIDE_COMUNIDAD = $VDES_COMUNIDAD = "";
//                if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//                    $VIDE_COMUNIDAD = $PIDEbuscado;
//                    $VDES_COMUNIDAD = $lCollection->Get('VDES_COMUNIDAD');
//                }
                
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');   
                /* EDGAR */

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


                $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Gestión Social"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Gestión Social"; //Nombre de la Tabla
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
    //            alert('por a intervenciones'+'<?php // echo $VIDE_COMUNIDAD.'-<br>'.$VDES_COMUNIDAD ; ?>');
    //            f.IDE_COMUNIDAD.value = '<?php // echo $VIDE_COMUNIDAD; ?>';
    //            f.DES_COMUNIDAD.value = '<?php // echo $VDES_COMUNIDAD; ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
//            CompruebaPaseDatos();
    <?php } ?>

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
    <?php echo Tabla_Proyecto_Datos($PIDE);  ?>
        <!--/*EDGAR*/-->



	<br>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_GESTION_SOCIAL">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_GESTION_SOCIAL" id="IDE_GESTION_SOCIAL" value="<?php echo $IDE_GESTION_SOCIAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">Proyecto: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Proyecto"/>					
            </div>
        </div>								



<!--        <div class="control-group">
            <label class="control-label" for="IDE_COMUNIDAD">Comunidad - CC.PP.: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_COMUNIDAD" id="IDE_COMUNIDAD" value="<?php // echo $IDE_COMUNIDAD; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Seleccione Comunidad - CC.PP."/>					
            </div>
        </div>								-->

    <?php extraerIDEyValor_Text("IDE_COMUNIDAD", $IDE_COMUNIDAD, 'ESTANDAR', 'Comunidad', 'B_COMUNIDAD', $B_COMUNIDAD, 'COMUNIDAD' );  ?>



        <div class="control-group">
            <label class="control-label" for="IDE_ETAPA_CONTRATO">Fase - Componente : <span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_ETAPA_CONTRATO('IDE_ETAPA_CONTRATO', $DataSet_GEN_INTERVENCION_1, $IDE_ETAPA_CONTRATO, 1, " style='width: 51%;'") ?>				
            </div>
        </div>  						


        
        <div class="control-group">
            <label class="control-label" for="NUM_BENEFICIARIOS">Num. Beneficiarios: <span class="error"></span></label>
            <div class="controls">
                <input  name="NUM_BENEFICIARIOS" id="NUM_BENEFICIARIOS" value="<?php echo $NUM_BENEFICIARIOS; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Num. Beneficiarios" style='width:13%;' />					
            </div>
        </div>								

        

        <div class="control-group">
            <label class="control-label" for="TIP_UNIDAD_BENEFICIARIO">Tipo Beneficiarios:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_UNIDAD_BENEFICIARIO('TIP_UNIDAD_BENEFICIARIO', $DataSet_GEN_TABLAS_1, $TIP_UNIDAD_BENEFICIARIO, 1, "") ?>				
            </div>
        </div>  						

        
        
        <div class="control-group" style="display:none">
            <label class="control-label" for="DES_UNIDAD_BENEFICIARIO">Descripción Beneficiarios: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_UNIDAD_BENEFICIARIO" id="DES_UNIDAD_BENEFICIARIO" value="<?php echo $DES_UNIDAD_BENEFICIARIO; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric  show-popover"  data-trigger="hover" data-content="Ingrese Descripción Beneficiarios"/>					
            </div>
        </div>								


        
        <div class="control-group">
            <label class="control-label" for="EST_MATRIZ_RC">Mapa de Actores Sociales :<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_MATRIZ_RC('EST_MATRIZ_RC', $DataSet_GEN_TABLAS_2, $EST_MATRIZ_RC, 1, "") ?>				
            </div>
        </div>  						



        <div class="control-group">
            <label class="control-label" for="EST_ACTA_APROBACION">Existencias de Actas :<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_ACTA_APROBACION('EST_ACTA_APROBACION', $DataSet_GEN_TABLAS_3, $EST_ACTA_APROBACION, 1, "") ?>				
            </div>
        </div>  						



        <div class="control-group">
            <label class="control-label" for="EST_GESTION_SOCIAL">Estado:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboEST_GESTION_SOCIAL('EST_GESTION_SOCIAL', $DataSet_GEN_TABLAS_4, $EST_GESTION_SOCIAL, 1, "") ?>				
            </div>
        </div>  						


        
        <?php echo $crudGrabarCancelar; ?> 

    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_ETAPA_CONTRATO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Etapa de Contrato" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_UNIDAD_BENEFICIARIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Beneficiarios" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_MATRIZ_RC($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione SI Tiene Matriz Relaciones Comunitarias" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_ACTA_APROBACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione SI Tiene Acta de Aprobación" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_GESTION_SOCIAL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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