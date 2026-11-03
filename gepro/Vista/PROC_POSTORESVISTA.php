<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_POSTORESVISTA de la tabla PROC_POSTORES
  //  Fecha           : miércoles, 08 de noviembre de 2017 05:04:38 p.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROC_POSTORES.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>


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


                    $PIDE_PROC_ITEM = $lCollection->Get('PIDE_PROC_ITEM');

                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                    $VDES_ITEM = $lCollection->Get('VDES_ITEM');
                    $VIMP_VAL_REFERENCIAL_ITEM = $lCollection->Get('VIMP_VAL_REFERENCIAL_ITEM');


                    $DatosPadre = '<table>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 20%">Código Proyecto:</th>';
                    $DatosPadre .= '<td style="width: 80%"> ' . $VCOD_PROYECTO . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 20%">Item del Proceso:</th>';
                    $DatosPadre .= '<td style="width: 80%"> ' . $VDES_ITEM . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 20%">Valor Referencial:</th>';
                    $DatosPadre .= '<td style="width: 80%"> ' . $VIMP_VAL_REFERENCIAL_ITEM . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '</table>';
                    
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
                                <li><a href="#tabs-1">Listado de Postores del Proceso </a></li>
                                <li><a href="#tabs-2">Detalle de Postores del Proceso </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">
                                    <input type="hidden" name="PIDE_PROC_ITEM" value="<?php echo $PIDE_PROC_ITEM; ?>">    


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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROC_ITEM=<?php echo $PIDE_PROC_ITEM; ?>',

                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Codigo Item', name: 'IDE_PROC_ITEM', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº de RUC', name: 'RUC_POSTOR', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Razon Social', name: 'DES_POSTOR', width: GetColumnSize(40), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Valor Referencial', name: 'VAL_REFERENCIAL_ITEM', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Valor Ofertado', name: 'VAL_OFERTADO_ITEM', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fecha de Propuesta', name: 'FEC_REG_PROPUESTA', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

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
                                                                    {display: 'Nº de RUC', name: 'RUC_POSTOR'},
                                                                    {display: 'Razon Social', name: 'DES_POSTOR'}
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
                                                }
                                                else if (com == 'Salir')
                                                {
                                                    cerrarPopup()
                                                }
                                                else
                                                {
                                                $('#mensaje')
                                                        .text('Debe Seleccionar un registro del listado')
                                                        .addClass('msjalerta')
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


    $IDE_POSTOR = $lCollection->Get('IDE_POSTOR');
    $IDE_PROC_ITEM = $lCollection->Get('IDE_PROC_ITEM');
    $RUC_POSTOR = $lCollection->Get('RUC_POSTOR');
    $DES_POSTOR = $lCollection->Get('DES_POSTOR');
    $TIP_POSTOR = $lCollection->Get('TIP_POSTOR');
    $VAL_REFERENCIAL_ITEM = $lCollection->Get('VAL_REFERENCIAL_ITEM');
    $VAL_OFERTADO_ITEM = $lCollection->Get('VAL_OFERTADO_ITEM');
    $FEC_REG_PROPUESTA = $lCollection->Get('FEC_REG_PROPUESTA');
    $EST_POSTOR = $lCollection->Get('EST_POSTOR');


    
    $PIDE_PROC_ITEM = $lCollection->Get('PIDE_PROC_ITEM');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VDES_ITEM = $lCollection->Get('VDES_ITEM');
    $VIMP_VAL_REFERENCIAL_ITEM = $lCollection->Get('VIMP_VAL_REFERENCIAL_ITEM');
    
    
    /* EDGAR */
    $IDE_PROC_ITEM = $PIDE_PROC_ITEM;
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */
    
    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Postores del Proceso"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Postores del Proceso"; //Nombre de la Tabla
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


            $('#FEC_REG_PROPUESTA').datepicker({
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
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="PIDE_PROC_ITEM" value="<?php echo $PIDE_PROC_ITEM ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group">	
            <label class="control-label" for="COD_PROYECTO">Código Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $VCOD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_ITEM">Item del Proceso: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ITEM" id="DES_ITEM" value="<?php echo $VDES_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="IMP_VAL_REFERENCIAL_ITEM">Valor Referencial: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_VAL_REFERENCIAL_ITEM" id="IMP_VAL_REFERENCIAL_ITEM" value="<?php echo $VIMP_VAL_REFERENCIAL_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROC_ITEM">Código de Item: <span class="error">*</span></label>
            <div class="controls">						
                <input  name="IDE_PROC_ITEM" id="IDE_PROC_ITEM" value="<?php echo $IDE_PROC_ITEM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el código de Item"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="RUC_POSTOR">Nº de RUC: <span class="error">*</span></label>
            <div class="controls">						
                <input  name="RUC_POSTOR" id="RUC_POSTOR" value="<?php echo $RUC_POSTOR; ?>" onChange="conMayusculas(this)" maxlength="15" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el nùmero de RUC del Postor"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_POSTOR">Razón Social: <span class="error">*</span></label>
            <div class="controls">						
                <input  name="DES_POSTOR" id="DES_POSTOR" value="<?php echo $DES_POSTOR; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la Razón Social del Postor"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="TIP_POSTOR">Tipo de Postor:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_POSTOR('TIP_POSTOR', $DataSet_GEN_TABLAS_1, $TIP_POSTOR, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="VAL_REFERENCIAL_ITEM">Valor Referencial: <span class="error">*</span></label>
            <div class="controls">						
                <input  name="VAL_REFERENCIAL_ITEM" id="VAL_REFERENCIAL_ITEM" value="<?php echo $VAL_REFERENCIAL_ITEM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el valor referencial del proceso"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="VAL_OFERTADO_ITEM">Valor Ofertado: <span class="error"></span></label>
            <div class="controls">						
                <input  name="VAL_OFERTADO_ITEM" id="VAL_OFERTADO_ITEM" value="<?php echo $VAL_OFERTADO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese el valor ofertado por el postor"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="FEC_REG_PROPUESTA">Propuesta Presentado el::<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                            
                    <input name="FEC_REG_PROPUESTA" id="FEC_REG_PROPUESTA" style="width: 10%" value="<?php echo $FEC_REG_PROPUESTA; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese la fecha de propuesta presentado" placeholder="DD/MM/YYYY"/>					</div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_POSTOR">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_POSTOR('EST_POSTOR', $DataSet_GEN_TABLAS_2, $EST_POSTOR, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboTIP_POSTOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciones el Tipo de Postor" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_POSTOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del postor" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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