<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ENTREGABLEVISTA de la tabla GEN_ENTREGABLE
  //  Fecha           : martes, 4 de junio de 2019 20:06:50
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_ENTREGABLE.js"></script>    


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
                    $pAuxiliar = $lCollection->Get('pAuxiliar');
                    
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
                                <li><a href="#tabs-1">Listado de Tipo de Entregables del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Tipo de Entregables del Contrato </a></li>
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
                                                            {display: 'Fase - Componente', name: 'IDE_FASE_COMPONENTE', width: GetColumnSize(24), sortable: true, align: 'left', hide: false},
                                                            {display: 'Definición de Registro', name: 'DES_ENTREGABLE', width: GetColumnSize(31.5), sortable: true, align: 'left', hide: false},
                                                            {display: 'Abreviatura', name: 'DES_ABREVIATURA', width: GetColumnSize(8), sortable: true, align: 'left', hide: false},
                                                            {display: 'Nivel', name: 'NUM_NIVEL', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Orden Visual', name: 'NUM_ORDEN', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
     
        <?php if( $pAuxiliar=='Anidado' && $VerSeleccion <> 'SI') {  ?>             {display: 'Valores', name: 'Anidado', width: GetColumnSize(6), sortable: false, align: 'center'},   <?php }  ?>
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
        
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php if ($VerSeleccion <> 'SI') { ?>{name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                            {separator: true}
                                                            ,{name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Fase - Componente', name: 'IDE_FASE_COMPONENTE'},
                                                            {display: 'Definición de Entregable', name: 'DES_ENTREGABLE'},
                                                            {display: 'Abreviatura', name: 'DES_ABREVIATURA'},
        <?php if ($VerSeleccion <> 'SI') { ?>               {display: 'Nivel', name: 'NUM_NIVEL'},  <?php } ?>
                                                            {display: 'Estado', name: 'Estado'}
                                                    ],
                                                            sortname: "IDE_FASE_COMPONENTE",
                                                            sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                            usepager: true, /* activa o descativa paginación */
                                                            singleSelect: true,
                                                            useRp: true,
                                                            rp: 10,
                                                            height: $("#datos").innerHeight,
                                                            query: '',
                                                            nowrap: false

                                                    /*EDGAR*/
        <?php if ($PIDE > 0) { ?>                   , title: '<?php echo Tabla_Entregable_Datos($PIDE);  ?>'    <?php } ?>
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


                $IDE_ENTREGABLE = $lCollection->Get('IDE_ENTREGABLE');
                $IDE_FASE_COMPONENTE = $lCollection->Get('IDE_FASE_COMPONENTE');
                $GEN_IDE_ENTREGABLE = $lCollection->Get('GEN_IDE_ENTREGABLE');
                $DES_ENTREGABLE = $lCollection->Get('DES_ENTREGABLE');
                $DES_ABREVIATURA = $lCollection->Get('DES_ABREVIATURA');
                $NUM_NIVEL = $lCollection->Get('NUM_NIVEL');
                $NUM_ORDEN = $lCollection->Get('NUM_ORDEN');
                $EST_ENTREGABLE = $lCollection->Get('EST_ENTREGABLE');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                if ($PIDE > 0) { $IDE_FASE_COMPONENTE = $lCollection->Get('VIDE_FASE_COMPONENTE_superior'); }
                /* para la herencia */
                $GEN_IDE_ENTREGABLE = $PIDE; //codigo superior autocompleta
                $NUM_NIVEL =  $lCollection->Get('VNUM_NIVEL'); 
                
                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');

                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
                
                
                
                $BIDE = $Bdescripcion = "";
                if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
                  $BIDE = $lCollection->Get('BIDE');;
                  $Bdescripcion = $lCollection->Get('Bdescripcion');
                }
                
                
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                /* EDGAR */

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


                $DataSet_GEN_ENTREGABLE_1 = $lCollection->Get('DataSet_GEN_ENTREGABLE_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Tipo de Entregables"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Tipo de Entregables"; //Nombre de la Tabla
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
//                alert('busquedas '+'<?php echo $BIDE.'-<br>-'.$Bdescripcion ;  ?>');
                f.IDE_ENTREGABLE.value = '<?php echo $BIDE;  ?>';
                f.DES_ENTREGABLE.value = '<?php echo $Bdescripcion;  ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            CompruebaPaseDatos();
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
    <?php
    if ($PIDE > 0) {
        //Tabla_Proyecto_Datos($PIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($PINTERVENCION);  
        echo '<br>';
    }
    ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ENTREGABLE">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_ENTREGABLE" id="IDE_ENTREGABLE" value="<?php echo $IDE_ENTREGABLE; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" <?php echo ( $NUM_NIVEL>1 ? ' style="display:none" ' : '' ); ?>>
            <label class="control-label" for="IDE_FASE_COMPONENTE">Fase - Componente:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_FASE_COMPONENTE('IDE_FASE_COMPONENTE', $DataSet_GEN_INTERVENCION_1, $IDE_FASE_COMPONENTE, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="GEN_IDE_ENTREGABLE">Entregable Superior:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboGEN_IDE_ENTREGABLE('GEN_IDE_ENTREGABLE', $DataSet_GEN_ENTREGABLE_1, $GEN_IDE_ENTREGABLE, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_ENTREGABLE">Definición Registro: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_ENTREGABLE" id="DES_ENTREGABLE" value="<?php echo $DES_ENTREGABLE; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Definición de Entregable"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ABREVIATURA">Abreviatura: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_ABREVIATURA" id="DES_ABREVIATURA" value="<?php echo $DES_ABREVIATURA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="IngreseAbreviatura" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="NUM_NIVEL">Nivel: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_NIVEL" id="NUM_NIVEL" value="<?php echo $NUM_NIVEL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number  show-popover"  data-trigger="hover" data-content="IngreseNivel" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="NUM_ORDEN">Orden Visual: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_ORDEN" id="NUM_ORDEN" value="<?php echo $NUM_ORDEN; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="IngreseOrden Visual" style='width:14.5%;' />					
            </div>
        </div>								


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

            function comboIDE_FASE_COMPONENTE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
                ?>    
    <select data-trigger="hover" data-content="Seleccione Fase - Componente" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboGEN_IDE_ENTREGABLE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Entregable Superior" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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