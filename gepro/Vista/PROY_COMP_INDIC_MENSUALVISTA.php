<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_INDIC_MENSUALVISTA de la tabla PROY_COMP_INDIC_MENSUAL
  //  Fecha           : sábado, 6 de enero de 2018 22:17:28
  //  Desde el Modelo : PDM - AMSACEtiqueta
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMP_INDIC_MENSUAL.js"></script>    
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
            $("#tabs").tabs({readonly: [1]});
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
                    $DatosPadre = '<table width="100%" class="tbDatoPadre" >';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 10%">Contrato:</td>';
                    $DatosPadre .= '<td style="width: 90%" colspan="3"> ' .  $VDES_PROYECTO . '</td>';  //$VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' .
                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Unidad Ejecutora:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td style="width: 10%">Intervención:</td>';
                    $DatosPadre .= '<td style="width: 40%"> ' . $VDES_INTERVENCION . '</td>';
                    $DatosPadre .= '<td style="width: 10%">Ejecución contractual:</td>';
                    $DatosPadre .= '<td style="width: 40%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . ' (' . $VDIAS_CONTRACTUALES . ' días)' . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td>Etapa de Componente:</td>';
                    $DatosPadre .= '<td><span style="color: #aa0000;"> ' . $VDES_COMPONENTE . '</span></td>';
                    $DatosPadre .= '<td>Detalle de la Etapa:</td>';
                    $DatosPadre .= '<td><span style="color: #aa0000;"> ' . $VDES_CARTERA . '</span></td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '<tr>';
                    $DatosPadre .= '<td>Estado:</td>';
                    $DatosPadre .= '<td> ' . $VDES_ESTADO . '</td>';
                    $DatosPadre .= '<td>Monto de Inversión:</td>';
                    $DatosPadre .= '<td> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
                    $DatosPadre .= '</tr>';
                    $DatosPadre .= '</table>';
                    ?>   
                    <div class="box-content">
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1">Listado de Indicador del Componente del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Indicador del Componente del Proyecto</a></li>
                            </ul>
                            <div id="tabs-1">
                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    
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
                                                                buttons: [
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                searchitems: [
                                                                    {display: 'Mes', name: 'PERIODO'}
                                                                ],
                                                                sortname: "ANHO",
                                                                sortorder: "ASC",
                                                                usepager: true,
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 13,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false
                                                                , title: '<?php echo $DatosPadre; ?>'
                                                            }
                                                    );
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
    $IDE_COMP_INDIC_MES = $lCollection->Get('IDE_COMP_INDIC_MES');
    $IDE_COMP_INDIC_ANUAL = $lCollection->Get('IDE_COMP_INDIC_ANUAL');
    $COD_MES = $lCollection->Get('COD_MES');
    $NUM_VALOR = $lCollection->Get('NUM_VALOR');
    $EST_COMP_INDIC_MENSUAL = $lCollection->Get('EST_COMP_INDIC_MENSUAL');
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
    $VFEC_INICIO_PLAN = $lCollection->Get('VFEC_INICIO_PLAN');
    $VFEC_TERMINO_PLAN = $lCollection->Get('VFEC_TERMINO_PLAN');
    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');
    $DES_ITEM = $lCollection->Get('DES_ITEM');
    
     
    
/* EDGAR */
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
/* EDGAR */

    
    
    
    $DatosPadre = '<table width="100%" class="tbDatoPadre" >';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width: 10%">Contrato:</td>';
    $DatosPadre .= '<td style="width: 90%" colspan="3"> ' .  $VDES_PROYECTO . '</td>';  //$VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' .
    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Unidad Ejecutora:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width: 10%">Intervención:</td>';
    $DatosPadre .= '<td style="width: 40%"> ' . $VDES_INTERVENCION . '</td>';
    $DatosPadre .= '<td style="width: 10%">Ejecución contractual:</td>';
    $DatosPadre .= '<td style="width: 40%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . ' (' . $VDIAS_CONTRACTUALES . ' días)' . '</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td>Etapa de Componente:</td>';
    $DatosPadre .= '<td><span style="color: #aa0000;"> ' . $VDES_COMPONENTE . '</span></td>';
    $DatosPadre .= '<td>Detalle de la Etapa:</td>';
    $DatosPadre .= '<td><span style="color: #aa0000;"> ' . $VDES_CARTERA . '</span></td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td>Estado:</td>';
    $DatosPadre .= '<td> ' . $VDES_ESTADO . '</td>';
    $DatosPadre .= '<td>Monto de Inversión:</td>';
    $DatosPadre .= '<td> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '</table>';
    
    
    
    
    
    
    
    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');
    if (strlen($SeleccionarID) > 0) {
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Indicador del Componente del Proyecto"; //Nombre de la Tabla
    } else {
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Indicador del Componente del Proyecto"; //Nombre de la Tabla
    }
    ?>
    <script type="text/javascript">
        $(function () {
            $('*[data-content]').hover(function ()
            {
                $(this).popover('show');
            });
            $("#BtnForm01").on("click", function () {
                if ($("#formulario").valid()) {
                    AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                }
            });
        });
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="IDE_COMP_INDIC_MES" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="IDE_COMP_INDIC_ANUAL" value="<?php echo $IDE_COMP_INDIC_ANUAL ?>">
        <input type="hidden" name="COD_MES" value="<?php echo $COD_MES ?>">
        <input type="hidden" name="EST_COMP_INDIC_MENSUAL" value="<?php echo $EST_COMP_INDIC_MENSUAL ?>">
                
        <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">
        <input type="hidden" name="PIDE_INDICADOR" value="<?php echo $PIDE_INDICADOR; ?>">
        <input type="hidden" name="PIDE_COD_ANHO" value="<?php echo $PIDE_COD_ANHO; ?>">

        <legend><?php echo $TitulFormulario; ?></legend>
        
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="IDE_CONVOCATORIA">Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IDE_CONVOCATORIA" id="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_ENTIDAD">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ENTIDAD" id="DES_ENTIDAD" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_INTERVENCION">Intervención: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_INTERVENCION" id="DES_INTERVENCION" value="<?php echo $VDES_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_COMPONENTE">Componente: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_COMPONENTE" id="DES_COMPONENTE" value="<?php echo $VDES_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="FEC_INICIO_CONTRATO">Ejecución Contractual: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" value="<?php echo 'del ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . '(' . $VDIAS_CONTRACTUALES . ' días)'; ?> )" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="IMP_COMPONENTE">Monto de Inversión: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COMPONENTE" id="IMP_COMPONENTE" value="<?php echo $VIMP_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        
        <?php echo $DatosPadre; ?>
        
        <br>
        
        
        <div class="control-group">	
            <label class="control-label" for="MES">Mes: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="MES" id="MES" value="<?php echo $DES_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content="" style='width:14.5%;' />
            </div>			
        </div>
        
                
        <div class="control-group">
            <label class="control-label" for="NUM_VALOR">Valor: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_VALOR" id="NUM_VALOR" value="<?php echo FormatoMonedas($NUM_VALOR); ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el valor del indicador" style='width:14.5%;' />					
            </div>
        </div>
        
         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>
    <?php
}
function comboCOD_MES($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select disabled data-trigger="hover" data-content="Selecciones el mes" id="<?php echo $nombre; ?>1" class="required" name="<?php echo $nombre; ?>1" <?php echo $estilo; ?> >
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
