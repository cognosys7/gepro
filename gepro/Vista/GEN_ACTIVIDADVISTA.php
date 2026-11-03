<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ACTIVIDADVISTA de la tabla GEN_ACTIVIDAD
  //  Fecha           : jueves, 17 de mayo de 2018 12:14:20
  //  Desde el Modelo : PDM - AMSACEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_ACTIVIDAD.js"></script>    


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
        $(function () {
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


                    $PIDE_INTERVENCION_COMP = $lCollection->Get('PIDE_INTERVENCION_COMP');
//                    $VTipoIntervencion = $lCollection->Get('VTipoIntervencion');
//                    $VComponente = $lCollection->Get('VComponente');
//                    $VModalidad = $lCollection->Get('VModalidad');
                    $DatosPadre = $lCollection->Get('DatosPadre');

    /* EDGAR */
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
                                <li><a href="#tabs-1">Listado de Hitos del Fase - Componente </a></li>
                                <li><a href="#tabs-2">Detalle de Hitos del Fase - Componente </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    


                                    <input type="hidden" name="PIDE_INTERVENCION_COMP" value="<?php echo $PIDE_INTERVENCION_COMP; ?>">    


                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar 
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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_INTERVENCION_COMP=<?php echo $PIDE_INTERVENCION_COMP; ?>',

                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'IdeIntCmp', name: 'IdeIntervComponente', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Tipo Intervención', name: 'TipoIntervencion', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Componente', name: 'Componente', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Modalidad', name: 'Modalidad', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Orden', name: 'Orden', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Actividad', name: 'Actividad', width: GetColumnSize(46), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Nivel', name: 'Nivel', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Hito', name: 'Hito', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Dias de Plazo', name: 'ParametroDias', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Actividad', name: 'Actividad'},
                                                                    {display: 'Nivel', name: 'Nivel'},
                                                                    {display: 'Hito', name: 'Hito'}
                                                                ],

                                                                sortname: "NFILA",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false

                                                                , title: '<?php echo $DatosPadre; ?>'


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
                                                } else if (com == 'Salir')
                                                {
                                                    cerrarPopup()
                                                } else
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


                $IDE_ACTIVIDAD = $lCollection->Get('IDE_ACTIVIDAD');
                $IDE_INTERVENCION_COMP = $lCollection->Get('IDE_INTERVENCION_COMP');
                $IDE_ACTIVIDAD_SUP = $lCollection->Get('IDE_ACTIVIDAD_SUP');
                $DES_ACTIVIDAD = $lCollection->Get('DES_ACTIVIDAD');
                $DES_ABREVIATURA = $lCollection->Get('DES_ABREVIATURA');
                $NUM_NIVEL = $lCollection->Get('NUM_NIVEL');
                $NUM_DIAS = $lCollection->Get('NUM_DIAS');
                $IND_HITO = $lCollection->Get('IND_HITO');
                $COD_ORDEN = $lCollection->Get('COD_ORDEN');
                $EST_ACTIVIDAD = $lCollection->Get('EST_ACTIVIDAD');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');



                $PIDE_INTERVENCION_COMP = $lCollection->Get('PIDE_INTERVENCION_COMP');
//                $VTipoIntervencion = $lCollection->Get('VTipoIntervencion');
//                $VComponente = $lCollection->Get('VComponente');
//                $VModalidad = $lCollection->Get('VModalidad');
                $DatosPadre = $lCollection->Get('DatosPadre');
    
    
    /* EDGAR */
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

 

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Hitos del Fase - Componente"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Hitos del Fase - Componente"; //Nombre de la Tabla
                }
                ?>
    <script type="text/javascript">
        $(function () {
            //ACTIVA LOS TOOLTIPS
            $('*[data-content]').hover(function ()
            {
                $(this).popover('show');
            });
            //VALIDACION DE FORMULARIO
            $("#BtnForm01").on("click", function () {
                if ($("#formulario").valid()) {
                    AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                }
            });
            //ACTIVAR PARA TRABAJAR CON FECHAS


            $('#FECHA_INSERT').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FECHA_UPDATE').datepicker({
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
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">


        <input type="hidden" name="PIDE_INTERVENCION_COMP" value="<?php echo $PIDE_INTERVENCION_COMP ?>">


        <legend><?php echo $TitulFormulario; ?></legend>  

        <?php echo $DatosPadre . '<br>'; ?>

        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ACTIVIDAD">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_ACTIVIDAD" id="IDE_ACTIVIDAD" value="<?php echo $IDE_ACTIVIDAD; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_INTERVENCION_COMP">Tipo de Intervención: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_INTERVENCION_COMP" id="IDE_INTERVENCION_COMP" value="<?php echo $PIDE_INTERVENCION_COMP; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ACTIVIDAD_SUP">Hito Supremo: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_ACTIVIDAD_SUP" id="IDE_ACTIVIDAD_SUP" value="<?php echo $IDE_ACTIVIDAD_SUP; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="DES_ACTIVIDAD">Hito: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_ACTIVIDAD" id="DES_ACTIVIDAD" value="<?php echo $DES_ACTIVIDAD; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la descripción del Hito"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ABREVIATURA">Abreviatura: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_ABREVIATURA" id="DES_ABREVIATURA" value="<?php echo $DES_ABREVIATURA; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese la abreviatura"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="NUM_NIVEL">Nivel de Jerarquía:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboNUM_NIVEL('NUM_NIVEL', $DataSet_GEN_TABLAS_1, $NUM_NIVEL, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="NUM_DIAS">Días de Plazo: <span class="error"></span></label>
            <div class="controls">
                <input  name="NUM_DIAS" id="NUM_DIAS" value="<?php echo $NUM_DIAS; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer show-popover" data-trigger="hover" data-content="Ingrese la cantidad de dìas para lograr el hito" style='width:12.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IND_HITO">Indicador de Jerarquía:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIND_HITO('IND_HITO', $DataSet_GEN_TABLAS_2, $IND_HITO, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="COD_ORDEN">Orden: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_ORDEN" id="COD_ORDEN" value="<?php echo $COD_ORDEN; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer required show-popover"  data-trigger="hover" data-content="Ingrese el Orden del Hito" style='width:12.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_ACTIVIDAD">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_ACTIVIDAD('EST_ACTIVIDAD', $DataSet_GEN_TABLAS_3, $EST_ACTIVIDAD, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="USER_INSERT">: <span class="error"></span></label>
            <div class="controls">

                <input  name="USER_INSERT" id="USER_INSERT" value="<?php echo $USER_INSERT; ?>" onChange="conMayusculas(this)" maxlength="32" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="FECHA_INSERT">: <span class="error"></span></label>
            <div class="controls">

                <input  name="FECHA_INSERT" id="FECHA_INSERT" value="<?php echo $FECHA_INSERT; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="USER_UPDATE">: <span class="error"></span></label>
            <div class="controls">

                <input  name="USER_UPDATE" id="USER_UPDATE" value="<?php echo $USER_UPDATE; ?>" onChange="conMayusculas(this)" maxlength="32" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="FECHA_UPDATE">: <span class="error"></span></label>
            <div class="controls">

                <input  name="FECHA_UPDATE" id="FECHA_UPDATE" value="<?php echo $FECHA_UPDATE; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


 

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboNUM_NIVEL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Nivel de la Jerarquía" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIND_HITO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Indicador de la Jerarquía" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            //if (strlen($lstDatos[$i]->COD_ITEM > 0)) {
                if ($lstDatos[$i]->COD_ITEM == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_ITEM . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ITEM . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_ITEM . "\">" . $lstDatos[$i]->DES_ITEM . "</option>\n\r";
                }
            //}
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_ACTIVIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el Estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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