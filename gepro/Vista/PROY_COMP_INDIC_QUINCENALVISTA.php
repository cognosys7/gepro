<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMP_INDIC_QUINCENAL.js"></script>    
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
                    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
                    $PIDE_INDICADOR = $lCollection->Get('PIDE_INDICADOR');
                    $PIDE_COD_ANHO = $lCollection->Get('PIDE_COD_ANHO');
                    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
                    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
                    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
                    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
                    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
                    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
                    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
                    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
                    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');
                    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');
                    $DatosPadre = '<table width="100%">';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td>Código Proyecto:</td>';
                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td>Unidad Ejecutora:</td>';
                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 00%">Intervención:</td>';
                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_INTERVENCION . '</td>';
                    $DatosPadre .= '<td style="width: 00%">Ejecución contractual:</td>';
                    $DatosPadre .= '<td style="width: 50%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . ' (' . $VDIAS_CONTRACTUALES . ' días)' . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 00%">Estado:</td>';
                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_ESTADO . '</td>';
                    $DatosPadre .= '<td style="width: 00%">Cartera:</td>';
                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_CARTERA . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 00%">Componente:</td>';
                    $DatosPadre .= '<td style="width: 50%"><span style="color: #D1542F;"> ' . $VDES_COMPONENTE . '</span></td>';
                    $DatosPadre .= '<td style="width: 00%">Monto de Inversión:</td>';
                    $DatosPadre .= '<td style="width: 50%"> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '</table>';
                    ?>   
                    <div class="box-content">
                        <div id="tabs">
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                            <ul>
                                <li><a href="#tabs-1">Listado de Indicador del Componente del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Indicador del Componente del Proyecto</a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">

                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">
                                    <input type="hidden" name="COD_MES" value="">
                                    <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE; ?>">                                        
                                    <input type="hidden" name="PIDE_INDICADOR" value="<?php echo $PIDE_INDICADOR; ?>">
                                    <input type="hidden" name="PIDE_COD_ANHO" value="<?php echo $PIDE_COD_ANHO; ?>">

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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROY_COMPONENTE=<?php echo $PIDE_PROY_COMPONENTE; ?>&PIDE_INDICADOR=<?php echo $PIDE_INDICADOR; ?>&PIDE_COD_ANHO=<?php echo $PIDE_COD_ANHO; ?>',
                                                                dataType: 'json',
                                                                method: 'POST',
                                                                colModel: [
                                                                    {display: '', name: 'ANHO', width: GetColumnSize(0), sortable: false, align: 'left', hide: true},
                                                                    {display: '', name: 'COD_MES', width: GetColumnSize(0), sortable: false, align: 'left', hide: true},
                                                                    {display: 'Nº', name: 'NUM_MES', width: GetColumnSize(5), sortable: false, align: 'left', hide: false},
                                                                    {display: 'Mes', name: 'PERIODO', width: GetColumnSize(15), sortable: false, align: 'left', hide: false},
                                                                    {display: 'PROGRAMADO', name: 'NUM_VALOR_LINEABASE', width: GetColumnSize(20), sortable: false, align: 'center', hide: false},
                                                                    {display: 'Edit', name: 'Boton1', width: GetColumnSize(7), sortable: false, align: 'center', hide: false},
                                                                    {display: 'EJECUTADO', name: 'NUM_VALOR_EJECUCION', width: GetColumnSize(20), sortable: false, align: 'center', hide: false},
                                                                    {display: 'Edit', name: 'Boton2', width: GetColumnSize(7), sortable: false, align: 'center', hide: false},
                                                                    {display: 'FORECAST', name: 'NUM_VALOR_FORECAST', width: GetColumnSize(20), sortable: false, align: 'center', hide: false},
                                                                    {display: 'Edit', name: 'Boton3', width: GetColumnSize(7), sortable: false, align: 'center', hide: false}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */
                                                                searchitems: [
                                                                    {display: 'Mes', name: 'PERIODO'}
                                                                ],
                                                                sortname: "ANHO",
                                                                sortorder: "ASC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 25,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false
                                                                , title: '<?php echo $DatosPadre; ?>'

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
    $IDE_COMP_INDIC_QUINCENA = $lCollection->Get('IDE_COMP_INDIC_QUINCENA');
    $IDE_COMP_INDIC_MES = $lCollection->Get('IDE_COMP_INDIC_MES');
    $IDE_COMP_ACTIVIDAD = $lCollection->Get('IDE_COMP_ACTIVIDAD');
    $COD_QUINCENA = $lCollection->Get('COD_QUINCENA');
    $NUM_VALOR = $lCollection->Get('NUM_VALOR');
    $EST_COMP_INDIC_QNA = $lCollection->Get('EST_COMP_INDIC_QNA');
    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
    $PIDE_INDICADOR = $lCollection->Get('PIDE_INDICADOR');
    $PIDE_COD_ANHO = $lCollection->Get('PIDE_COD_ANHO');
    //$VIDE_PROY_COMPONENTE = $lCollection->Get('VIDE_PROY_COMPONENTE');
    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');
    $VFEC_INICIO_PLAN = $lCollection->Get('VFEC_INICIO_PLAN');
    $VFEC_TERMINO_PLAN = $lCollection->Get('VFEC_TERMINO_PLAN');
    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');
    $DES_ITEM = $lCollection->Get('DES_ITEM');
    //$DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');
    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');
    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Indicador del Componente del Proyecto"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Indicador del Componente del Proyecto"; //Nombre de la Tabla
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
        });
    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        
        <input type="hidden" name="IDE_COMP_INDIC_QUINCENA" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="IDE_COMP_INDIC_MES" value="<?php echo $IDE_COMP_INDIC_MES ?>">
        <input type="hidden" name="COD_QUINCENA" value="<?php echo $COD_QUINCENA ?>">
        <input type="hidden" name="EST_COMP_INDIC_QNA" value="<?php echo $EST_COMP_INDIC_QNA ?>">
        
        <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">
        <input type="hidden" name="PIDE_INDICADOR" value="<?php echo $PIDE_INDICADOR; ?>">
        <input type="hidden" name="PIDE_COD_ANHO" value="<?php echo $PIDE_COD_ANHO; ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  
        
        <div class="control-group">	
            <label class="control-label" for="IDE_CONVOCATORIA">Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IDE_CONVOCATORIA" id="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_ENTIDAD">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ENTIDAD" id="DES_ENTIDAD" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_INTERVENCION">Intervención: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_INTERVENCION" id="DES_INTERVENCION" value="<?php echo $VDES_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_COMPONENTE">Componente: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_COMPONENTE" id="DES_COMPONENTE" value="<?php echo $VDES_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="FEC_INICIO_CONTRATO">Ejecución Contractual: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" value="<?php echo 'del ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . '(' . $VDIAS_CONTRACTUALES . ' días)'; ?> )" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <div class="control-group">	
            <label class="control-label" for="IMP_COMPONENTE">Monto de Inversión: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COMPONENTE" id="IMP_COMPONENTE" value="<?php echo $VIMP_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        
        <div class="control-group">	
            <label class="control-label" for="QUINCENA">Quincena: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="QUINCENA" id="QUINCENA" value="<?php echo $DES_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        

        <div class="control-group">
            <label class="control-label" for="NUM_VALOR">Valor: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_VALOR" id="NUM_VALOR" value="<?php echo $NUM_VALOR; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el valor del indicador"/>					
            </div>
        </div>								

        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}
/*	*/