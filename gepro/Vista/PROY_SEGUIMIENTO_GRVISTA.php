<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_SEGUIMIENTO_GRVISTA de la tabla PROY_SEGUIMIENTO_GR
  //  Fecha           : domingo, 16 de setiembre de 2018 01:28:27
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_SEGUIMIENTO_GR.js"></script>    


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


                    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
                    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
                    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');
                    

                    /* EDGAR */
                    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
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
                                <li><a href="#tabs-1">Listado de Seguimiento del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Seguimiento del Contrato </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    


                                    <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>">    


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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROYECTO_ACTIVIDAD=<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Còdigo', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Contingencia Advertida', name: 'DES_ADVERTENCIA', width: GetColumnSize(35), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Medida Adoptada', name: 'DES_MEDIDA', width: GetColumnSize(34), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Fecha seguimiento', name: 'FEC_SEGUIMIENTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'EST_PROY_SEGUIMIENTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: true, align: 'center', hide: <?php echo $crudEliminar; ?> },
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Contingencia Advertida', name: 'DES_ADVERTENCIA'},
                                                                    {display: 'Medida Adoptada', name: 'DES_MEDIDA'}
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

                                                                , title: '<?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($VIDE_INTERVENCION); ?>'


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


    $IDE_SEGUIMIENTO = $lCollection->Get('IDE_SEGUIMIENTO');
    $IDE_PROYECTO_ACTIVIDAD = $lCollection->Get('IDE_PROYECTO_ACTIVIDAD');
    $DES_ADVERTENCIA = $lCollection->Get('DES_ADVERTENCIA');
    $DES_MEDIDA = $lCollection->Get('DES_MEDIDA');
    $FEC_SEGUIMIENTO = $lCollection->Get('FEC_SEGUIMIENTO');
    $EST_PROY_SEGUIMIENTO = $lCollection->Get('EST_PROY_SEGUIMIENTO');



    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');



    /* EDGAR */
    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Seguimiento de Proyecto"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Seguimiento de Proyecto"; //Nombre de la Tabla
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


            $('#FEC_SEGUIMIENTO').datepicker({
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
        <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD ?>">
        <input type="hidden" name="IDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>" />
        <input type="hidden" name="IDE_SEGUIMIENTO" value="<?php echo $SeleccionarID; ?>" />


        <legend><?php echo $TitulFormulario; ?></legend>  

        <?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ; ?>
        <br>

        <div class="control-group" style="display:none">	
            <label class="control-label" for="COD_PROYECTO">Código: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $VCOD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <div class="control-group" style="display:none">	
            <label class="control-label" for="EJECUTORA">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly  name="EJECUTORA" id="EJECUTORA" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>        
        <div class="control-group" style="display:none">	
            <label class="control-label" for="DES_PROYECTO_ITEM">Descripción: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly name="DES_PROYECTO_ITEM" id="DES_PROYECTO_ITEM" value="<?php echo $VDES_PROYECTO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge" data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none">	
            <label class="control-label" for="IMP_COSTO_ACTUAL">Importe Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input readonly name="IMP_COSTO_ACTUAL" id="IMP_COSTO_ACTUAL" value="<?php echo $VIMP_COSTO_ACTUAL; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   

        <div class="control-group">
            <label class="control-label" for="DES_ADVERTENCIA">Contingencia Advertida: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_ADVERTENCIA" id="DES_ADVERTENCIA" rows="5" onChange="conMayusculas(this)" maxlength="5000" class="xlarge alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la contingencia advertida" ><?php echo $DES_ADVERTENCIA; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="DES_MEDIDA">Medida Adoptada: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_MEDIDA" id="DES_MEDIDA" rows="5" onChange="conMayusculas(this)" maxlength="5000" class="xlarge alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la meida adoptada" ><?php echo $DES_MEDIDA; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_SEGUIMIENTO">Fecha de Seguimiento:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_SEGUIMIENTO" id="FEC_SEGUIMIENTO" style="width: 10%" value="<?php echo $FEC_SEGUIMIENTO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la fecha" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_PROY_SEGUIMIENTO">Estado de Seguimiento:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROY_SEGUIMIENTO('EST_PROY_SEGUIMIENTO', $DataSet_GEN_TABLAS_1, $EST_PROY_SEGUIMIENTO, 1, "") ?>				
            </div>
        </div>  						


 

        <?php echo $crudGrabarCancelar; ?> 

  
        
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_PROY_SEGUIMIENTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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