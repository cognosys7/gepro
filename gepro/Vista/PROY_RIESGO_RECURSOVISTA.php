<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_RIESGO_RECURSOVISTA de la tabla PROY_RIESGO_RECURSO
  //  Fecha           : domingo, 24 de junio de 2018 20:44:02
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_RIESGO_RECURSO.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />

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
                    $PIDE_RIESGO_PROB = $lCollection->Get('PIDE_RIESGO_PROB');
                    $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');
                    
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                    $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
                    $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');
                    $DES_NOMBRE = $lCollection->Get('DES_NOMBRE');
                    $DatosPadre = '<table class="tbDatoPadre">';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 10%">Cod. Orden Detalle:</th>';
                    $DatosPadre .= '<td style="width: 90%"> ' . $VCOD_PROYECTO . '</td>';
                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 20%">Unidad Ejecutora:</th>';
//                    $DatosPadre .= '<td style="width: 80%"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 20%">Descripción:</th>';
//                    $DatosPadre .= '<td style="width: 80%"> ' . $VDES_PROYECTO_ITEM . '</td>';
//                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td>Importe :</th>';
                    $DatosPadre .= '<td> ' . $VIMP_COSTO_ACTUAL . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td><span style="color: #D1542F;">Riesgo :</span></th>';
                    $DatosPadre .= '<td><span style="color: #D1542F;"> ' . $DES_NOMBRE . '</span></td>';
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
                                <li><a href="#tabs-1">Listado de Recursos del riesgo </a></li>
                                <li><a href="#tabs-2">Detalle de Recursos del riesgo </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    
                                    <input type="hidden" name="PIDE_RIESGO_PROB" value="<?php echo $PIDE_RIESGO_PROB; ?>">    
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_RIESGO_PROB=<?php echo $PIDE_RIESGO_PROB;?>&PIDE_PROYECTO_ACTIVIDAD=<?php echo $PIDE_PROYECTO_ACTIVIDAD;?>',
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Código', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nombre del recurso', name: 'DES_RECURSO', width: GetColumnSize(73.5), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'EST_RECURSO_RIESGO', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
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
                                                                    {display: 'Nombre del recurso', name: 'DES_RECURSO'}
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
                $PIDE_RIESGO_PROB = $lCollection->Get('PIDE_RIESGO_PROB');
                $PIDE_PROYECTO_ACTIVIDAD = $lCollection->Get('PIDE_PROYECTO_ACTIVIDAD');

                $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                $VDES_PROYECTO_ITEM = $lCollection->Get('VDES_PROYECTO_ITEM');
                $VIMP_COSTO_ACTUAL = $lCollection->Get('VIMP_COSTO_ACTUAL');
                $DES_NOMBRE = $lCollection->Get('DES_NOMBRE');


                $IDE_RECURSO_RIESGO = $lCollection->Get('IDE_RECURSO_RIESGO');
                $IDE_RIESGO_PROB = $lCollection->Get('IDE_RIESGO_PROB');
                $IDE_RECURSO = $lCollection->Get('IDE_RECURSO');
                $EST_RECURSO_RIESGO = $lCollection->Get('EST_RECURSO_RIESGO');
    
    /* EDGAR */
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                $B_RECURSO = $lCollection->Get('Bdescripcion');
    /* EDGAR */

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */
                $DataSet_GEN_RECURSO_1 = $lCollection->Get('DataSet_GEN_RECURSO_1');
                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Recursos del riesgo"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Recursos del riesgo"; //Nombre de la Tabla
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
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">        
        <input type="hidden" name="PIDE_PROYECTO_ACTIVIDAD" value="<?php echo $PIDE_PROYECTO_ACTIVIDAD ?>">
        <input type="hidden" name="PIDE_RIESGO_PROB" value="<?php echo $PIDE_RIESGO_PROB ?>">                
        <input type="hidden" name="IDE_RIESGO_PROB" value="<?php echo $PIDE_RIESGO_PROB ?>" />
        <input type="hidden" name="IDE_RECURSO_RIESGO" value="<?php echo $SeleccionarID; ?>"/>
        
        <!--/*EDGAR*/-->
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->

        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group">	
            <label class="control-label" for="COD_PROYECTO">Contrato: <span class="error">*</span></label>				
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
        
        <div class="control-group">	
            <label class="control-label" for="IMP_COSTO_ACTUAL">Importe : <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COSTO_ACTUAL" id="IMP_COSTO_ACTUAL" value="<?php echo $VIMP_COSTO_ACTUAL; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        
        <div class="control-group" >	
            <label class="control-label" for="DES_NOMBRE">Cod.Orden Detalle: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_NOMBRE" id="DES_NOMBRE" value="<?php echo $DES_NOMBRE; ?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        												


<!--        <div class="control-group">
            <label class="control-label" for="IDE_RECURSO">Nombre del recurso:<span class="error">*</span></label>
            <div class="controls"> 
    <?php // comboIDE_RECURSO('IDE_RECURSO', $DataSet_GEN_RECURSO_1, $IDE_RECURSO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  -->
        
        <?php extraerIDEyValor_Text("IDE_RECURSO", $IDE_RECURSO, 'ESTANDAR', 'Recurso', 'DESCRIPCIONRECURSO', $B_RECURSO, 'RECURSO' );   ?>


        <div class="control-group">
            <label class="control-label" for="EST_RECURSO_RIESGO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_RECURSO_RIESGO('EST_RECURSO_RIESGO', $DataSet_GEN_TABLAS_1, $EST_RECURSO_RIESGO, 1, "") ?>				
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
    <select data-trigger="hover" data-content="Seleccione el nombre de recurso humano" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_RECURSO_RIESGO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccion el estado del proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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