<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_ACT_UBIGEOVISTA de la tabla PROY_ACT_UBIGEO
  //  Fecha           : lunes, 20 de noviembre de 2017 06:03:38 p.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_ACT_UBIGEO.js"></script>    


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
//                    $DatosPadre = '<table>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 20%">Código Proyecto:</th>';
//                    $DatosPadre .= '<td style="width: 80%"> ' . $VCOD_PROYECTO . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 20%">Unidad Ejecutora:</th>';
//                    $DatosPadre .= '<td style="width: 80%"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 20%">Descripción:</th>';
//                    $DatosPadre .= '<td style="width: 80%"> ' . $VDES_PROYECTO_ITEM . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 20%">Importe Proyecto:</th>';
//                    $DatosPadre .= '<td style="width: 80%"> ' . $VIMP_COSTO_ACTUAL . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '</table>';
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
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
                                <li><a href="#tabs-1">Listado de Ubicaciones Geográficas Intervenidas del Proyecto</a></li>
                                <li><a href="#tabs-2">Detalle de Ubicación Geográfica Intervenida </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">

                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>">   
                                    <input type="hidden" name="IDE_ENTIDAD_EJECUTORA" value="<?php echo $VIDE_ENTIDAD_EJECUTORA ?>">


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
                                                                    {display: 'Código', name: 'ID', width: GetColumnSize(5), sortable: true, align: 'center', hide: true},
                                                                    {display: 'UBIGEO', name: 'COD_UBIGEO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Región', name: 'DES_DEPARTAMENTO', width: GetColumnSize(14.9), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Provincia', name: 'DES_PROVINCIA', width: GetColumnSize(17), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Distrito', name: 'DES_DISTRITO', width: GetColumnSize(22), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Longitud Geografica', name: 'GEO_LONGITUD_UBICACION', width: GetColumnSize(13), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Latitud Geografica', name: 'GEO_LATITUD_UBICACION', width: GetColumnSize(13), sortable: true, align: 'center', hide: false},
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
                                                                    {display: 'Región', name: 'DES_DEPARTAMENTO'},
                                                                    {display: 'Provincia', name: 'DES_PROVINCIA'},
                                                                    {display: 'Distrito', name: 'DES_DISTRITO'}
                                                                ],

                                                                sortname: "COD_UBIGEO",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false


        /*EDGAR*/
        <?php if ($PIDE_PROYECTO_ACTIVIDAD > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE_PROYECTO_ACTIVIDAD);  ?>'    <?php } ?>
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


    $IDE_PROY_ACT_UBIGEO = $lCollection->Get('IDE_PROY_ACT_UBIGEO');
    $IDE_PROYECTO_ACTIVIDAD = $lCollection->Get('IDE_PROYECTO_ACTIVIDAD');

    $REGION = substr($lCollection->Get('COD_UBIGEO'), 0, 2);
    $PROVINCIA = substr($lCollection->Get('COD_UBIGEO'), 0, 4);
    $DISTRITO = $lCollection->Get('COD_UBIGEO');

    $COD_UBIGEO = $lCollection->Get('COD_UBIGEO');
    $GEO_LONGITUD_UBICACION = $lCollection->Get('GEO_LONGITUD_UBICACION');
    $GEO_LATITUD_UBICACION = $lCollection->Get('GEO_LATITUD_UBICACION');
    $EST_PROY_ACT_UBIGEO = $lCollection->Get('EST_PROY_ACT_UBIGEO');

    

    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
    $VIDE_ENTIDAD_EJECUTORA = $lCollection->Get('VIDE_ENTIDAD_EJECUTORA');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */
    $DataSet_GEN_UBIGEO_1 = $lCollection->Get('DataSet_GEN_UBIGEO_1');
    $DataSet_GEN_UBIGEO_2 = $lCollection->Get('DataSet_GEN_UBIGEO_2');
    $DataSet_GEN_UBIGEO_3 = $lCollection->Get('DataSet_GEN_UBIGEO_3');
    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');
    
    $DESCRIPCIONUBIGEO = $lCollection->Get('DESCRIPCIONUBIGEO');

    
    
    /* EDGAR */
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');   
    /* EDGAR */

    
    
    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Ubicaciones Geográficas Intervenidas"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Ubicaciones Geográficas Intervenidas"; //Nombre de la Tabla
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
        <input type="hidden" name="IDE_ENTIDAD_EJECUTORA" value="<?php echo $VIDE_ENTIDAD_EJECUTORA ?>">
        
        <input type="hidden" name="IDE_PROY_ACT_UBIGEO" value="<?php echo $SeleccionarID; ?>"/>
        <input type="hidden" name="IDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD; ?>">
        
        <input type="hidden" name="varBotonInvocador" value="">
        
        <legend><?php echo $TitulFormulario; ?></legend>  


<!--/*EDGAR*/-->
        <?php if ($PIDE_PROYECTO_ACTIVIDAD > 0) {  echo Tabla_Proyecto_Datos($PIDE_PROYECTO_ACTIVIDAD);  } ?>
<!--/*EDGAR*/-->

	<br>

        
        <div class="control-group" style="display:none">	
            <label class="control-label" for="COD_PROYECTO">Código Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $VCOD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <div class="control-group" style="display:none">	
            <label class="control-label" for="EJECUTORA">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="EJECUTORA" id="EJECUTORA" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>        
        <div class="control-group" style="display:none">	
            <label class="control-label" for="DES_PROYECTO_ITEM">Descripción: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_PROYECTO_ITEM" id="DES_PROYECTO_ITEM" value="<?php echo $VDES_PROYECTO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none">	
            <label class="control-label" for="IMP_COSTO_ACTUAL">Importe Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COSTO_ACTUAL" id="IMP_COSTO_ACTUAL" value="<?php echo $VIMP_COSTO_ACTUAL; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <!--
        <div class="control-group">
            <label class="control-label" for="REGION">Región:<span class="error">*</span></label>
            <div class="controls"> 
                <?php // comboREGION('REGION', $DataSet_GEN_UBIGEO_1, $REGION, 1, "onchange=\"return AjaxProvinciaList('$PaginaFormulario');\"") ?>                
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="PROVINCIA">Provincia:<span class="error">*</span></label>
            <div class="controls"> 
                <div class="span12" id="divProvincia">
                    <?php // comboPROVINCIA('PROVINCIA', $DataSet_GEN_UBIGEO_2, $PROVINCIA, 1, "onchange=\"return AjaxDistritoList('$PaginaFormulario');\"") ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="DISTRITO">Distrito:<span class="error">*</span></label>
            <div class="controls"> 
                <div class="span12" id="divDistrito">
                    <?php // comboDISTRITO('DISTRITO', $DataSet_GEN_UBIGEO_3, $DISTRITO, 1, "onchange=\"UBIGEO();\"") ?>				
                </div>
            </div>
        </div>  						
        -->
        
        <?php extraerIDEyValor_Text("COD_UBIGEO", $COD_UBIGEO, 'Coordenada', 'UBIGEO', 'UBIGEO', $DESCRIPCIONUBIGEO, 'UBIGEO', 'width: 50%;' ); ?>


        <div class="control-group">
            <label class="control-label" for="GEO_LONGITUD_UBICACION">Longitud Geográfica: <span class="error"></span></label>
            <div class="controls">
                <input  name="GEO_LONGITUD_UBICACION" id="GEO_LONGITUD_UBICACION" value="<?php echo $GEO_LONGITUD_UBICACION; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese la longitud de la ubicación geográfica" style='width:13%;' />					
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="GEO_LATITUD_UBICACION">Latitud Geográfica: <span class="error"></span></label>
            <div class="controls">
                <input  name="GEO_LATITUD_UBICACION" id="GEO_LATITUD_UBICACION" value="<?php echo $GEO_LATITUD_UBICACION; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese la latitud de la ubicación geográfica" style='width:13%;' />					
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="EST_PROY_ACT_UBIGEO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROY_ACT_UBIGEO('EST_PROY_ACT_UBIGEO', $DataSet_GEN_TABLAS_1, $EST_PROY_ACT_UBIGEO, 1, "") ?>
            </div>
        </div>


         

        <?php echo $crudGrabarCancelar; ?>

  
    </form>

    <?php
}

/** * ********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */
function comboREGION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>        
    <select data-trigger="hover" data-content="Seleccione el nombre de la Región " id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->COD_UBIGEO > 0)) {
                if (trim($lstDatos[$i]->COD_UBIGEO) == trim($valorInicial)) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_UBIGEO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_DEPARTAMENTO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_UBIGEO . "\">" . $lstDatos[$i]->DES_DEPARTAMENTO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboPROVINCIA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>
    <select data-trigger="hover" data-content="Seleccione el nombre de la Provincia" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->COD_UBIGEO > 0)) {
                if (trim($lstDatos[$i]->COD_UBIGEO) == trim($valorInicial)) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_UBIGEO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PROVINCIA . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_UBIGEO . "\">" . $lstDatos[$i]->DES_PROVINCIA . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboDISTRITO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el nombre de la Distrito" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->COD_UBIGEO > 0)) {
                if (trim($lstDatos[$i]->COD_UBIGEO) == trim($valorInicial)) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_UBIGEO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_DISTRITO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->COD_UBIGEO . "\">" . $lstDatos[$i]->DES_DISTRITO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_PROY_ACT_UBIGEO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Selecciona el estado de la ubicación geográfica" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA EL CARGADO DE DATOS DE TABLAS AUXILIARES     
 * ********************************************************************************* */

function LoadProvinciaAjax() {
    $lCollection = Collection::Singleton();
    $DataSet_GEN_UBIGEO_2 = $lCollection->Get('DataSet_GEN_UBIGEO_2');
    $PaginaFormulario = $lCollection->Get("PaginaFormulario");
    //var_dump($DataSet_GEN_UBIGEO_2);
    ?>   
    <select data-trigger="hover" data-content="Seleccione el nombre de la Provincia" id="PROVINCIA" class="required" name="PROVINCIA" onchange="return AjaxDistritoList('PROY_ACT_UBIGEO');">   
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($DataSet_GEN_UBIGEO_2); $i++) {
            if (strlen($DataSet_GEN_UBIGEO_2[$i]->COD_UBIGEO > 0)) {
                $lOption .= "<option value=\"" . $DataSet_GEN_UBIGEO_2[$i]->COD_UBIGEO . "\">" . $DataSet_GEN_UBIGEO_2[$i]->DES_PROVINCIA . "</option>\n\r";
            }
        }
        echo $lOption;
        ?>
    </select>    
    <?php
}

function LoadDistritoAjax() {
    $lCollection = Collection::Singleton();
    $DataSet_GEN_UBIGEO_3 = $lCollection->Get("DataSet_GEN_UBIGEO_3");
    $PaginaFormulario = $lCollection->Get("PaginaFormulario");
    //var_dump($DataSet_GEN_UBIGEO_3);
    ?>
    <select data-trigger="hover" data-content="Seleccione el nombre de la Distrito" name="DISTRITO" id="DISTRITO" onchange="" >    
        <option value="">Seleccione una Opción</option>
        <?php
        $lOption = "";
        for ($i = 0; $i < count($DataSet_GEN_UBIGEO_3); $i++) {
            $lOption .= "<option value=\"" . $DataSet_GEN_UBIGEO_3[$i]->COD_UBIGEO . "\">" . $DataSet_GEN_UBIGEO_3[$i]->DES_DISTRITO . "</option>\n\r";
        }
        echo $lOption;
        ?>
    </select>
    <?php
}
