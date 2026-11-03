<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_PRESUPUESTOVISTA de la tabla PROC_PRESUPUESTO
  //  Fecha           : viernes, 10 de noviembre de 2017 09:53:57 a.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROC_PRESUPUESTO.js"></script>    


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

                    $PIDE_CONVOCATORIA = $lCollection->Get('PIDE_CONVOCATORIA');
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
                                <li><a href="#tabs-1">Listado de Presupuesto Item </a></li>
                                <li><a href="#tabs-2">Detalle de Presupuesto Item </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    


                                    <input type="hidden" name="PIDE_CONVOCATORIA" value="<?php echo $PIDE_CONVOCATORIA; ?>">    
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

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_CONVOCATORIA=<?php echo $PIDE_CONVOCATORIA; ?>&PIDE_PROC_ITEM=<?php echo $PIDE_PROC_ITEM; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Numero del proceso', name: 'IDE_CONVOCATORIA', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cant. de Items', name: 'IDE_PROC_ITEM', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Meta Presup.', name: 'SEC_FUNC', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fuente de Financiamiento', name: 'FTE_FTO', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Especifica de Gasto', name: 'ESPECIFICA_GASTO', width: GetColumnSize(25), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº Certi. Pptal.', name: 'COD_CERTIFICADO_PRES', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Mto. Certificado', name: 'IMP_CERTIFICADO_PRES', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº Exp. SIAF', name: 'COD_EXPEDIENTE_SIAF', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Meta Presup.', name: 'SEC_FUNC'}
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


    $IDE_PRESUPUESTO = $lCollection->Get('IDE_PRESUPUESTO');
    $IDE_CONVOCATORIA = $lCollection->Get('IDE_CONVOCATORIA');
    $IDE_PROC_ITEM = $lCollection->Get('IDE_PROC_ITEM');
    $SEC_FUNC = $lCollection->Get('SEC_FUNC');
    $COD_FTE_FTO = $lCollection->Get('COD_FTE_FTO');
    $DES_FTE_FTO = $lCollection->Get('DES_FTE_FTO');
    $COD_ESPECIFICA_GASTO = $lCollection->Get('COD_ESPECIFICA_GASTO');
    $DES_ESPECIFICA_GASTO = $lCollection->Get('DES_ESPECIFICA_GASTO');
    $COD_CERTIFICADO_PRES = $lCollection->Get('COD_CERTIFICADO_PRES');
    $IMP_CERTIFICADO_PRES = $lCollection->Get('IMP_CERTIFICADO_PRES');
    $COD_EXPEDIENTE_SIAF = $lCollection->Get('COD_EXPEDIENTE_SIAF');
    $EST_PROC_PRESUPUESTO = $lCollection->Get('EST_PROC_PRESUPUESTO');


    $PIDE_CONVOCATORIA = $lCollection->Get('PIDE_CONVOCATORIA');
    $PIDE_PROC_ITEM = $lCollection->Get('PIDE_PROC_ITEM');
    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
    $VDES_ITEM = $lCollection->Get('VDES_ITEM');
    $VIMP_VAL_REFERENCIAL_ITEM = $lCollection->Get('VIMP_VAL_REFERENCIAL_ITEM');


    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Presupuesto Item"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Presupuesto Item"; //Nombre de la Tabla
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
        <input type="hidden" name="PIDE_CONVOCATORIA" value="<?php echo $PIDE_CONVOCATORIA; ?>">    
        <input type="hidden" name="PIDE_PROC_ITEM" value="<?php echo $PIDE_PROC_ITEM ?>">        
        <input  type="hidden" name="IDE_CONVOCATORIA" value="<?php echo $PIDE_CONVOCATORIA; ?>">
        <input  type="hidden" name="IDE_PROC_ITEM" value="<?php echo $IDE_PROC_ITEM; ?>">
        <legend><?php echo $TitulFormulario; ?></legend>  
        <div class="control-group">	
            <label class="control-label" for="COD_PROYECTO">Código Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $VCOD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="DES_ITEM">Item del Proceso: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ITEM" id="DES_ITEM" value="<?php echo $VDES_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group">	
            <label class="control-label" for="IMP_VAL_REFERENCIAL_ITEM">Valor Referencial: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_VAL_REFERENCIAL_ITEM" id="IMP_VAL_REFERENCIAL_ITEM" value="<?php echo $VIMP_VAL_REFERENCIAL_ITEM; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   

        <div class="control-group">
            <label class="control-label" for="SEC_FUNC">Meta Presupuestal: <span class="error">*</span></label>
            <div class="controls">	
                <input  name="SEC_FUNC" id="SEC_FUNC" value="<?php echo $SEC_FUNC; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la Meta Presupuestal o sec_func"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_FTE_FTO">Fuente de Financiamiento: <span class="error">*</span></label>
            <div class="controls">		
                <input  name="COD_FTE_FTO" id="COD_FTE_FTO" value="<?php echo $COD_FTE_FTO; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la fuente de financiamienrto"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_FTE_FTO">Descripción Fte. de Fto.: <span class="error">*</span></label>
            <div class="controls">			
                <input  name="DES_FTE_FTO" id="DES_FTE_FTO" value="<?php echo $DES_FTE_FTO; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la descripción de la fte. de financiamiento"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_ESPECIFICA_GASTO">Específica de Gasto: <span class="error">*</span></label>
            <div class="controls">			
                <input  name="COD_ESPECIFICA_GASTO" id="COD_ESPECIFICA_GASTO" value="<?php echo $COD_ESPECIFICA_GASTO; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la específica de gasto"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ESPECIFICA_GASTO">Descripción de EE.GG.: <span class="error">*</span></label>
            <div class="controls">			
                <input  name="DES_ESPECIFICA_GASTO" id="DES_ESPECIFICA_GASTO" value="<?php echo $DES_ESPECIFICA_GASTO; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la descripción de la específica de gasto"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_CERTIFICADO_PRES">Nº de Certi. Presupuestal: <span class="error">*</span></label>
            <div class="controls">				
                <input  name="COD_CERTIFICADO_PRES" id="COD_CERTIFICADO_PRES" value="<?php echo $COD_CERTIFICADO_PRES; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el número de certificación presupuestal"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_CERTIFICADO_PRES">Monto Certificado: <span class="error">*</span></label>
            <div class="controls">						<input  name="IMP_CERTIFICADO_PRES" id="IMP_CERTIFICADO_PRES" value="<?php echo $IMP_CERTIFICADO_PRES; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese el importe de la certificación presupuestal"/>                </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_EXPEDIENTE_SIAF">Nº Exp. SIAF: <span class="error">*</span></label>
            <div class="controls">				
                <input  name="COD_EXPEDIENTE_SIAF" id="COD_EXPEDIENTE_SIAF" value="<?php echo $COD_EXPEDIENTE_SIAF; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el número de expediente SIAF"/>                </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="EST_PROC_PRESUPUESTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROC_PRESUPUESTO('EST_PROC_PRESUPUESTO', $DataSet_GEN_TABLAS_1, $EST_PROC_PRESUPUESTO, 1, "") ?>				
            </div>
        </div>  						
        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_PROC_PRESUPUESTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione es estado presupuesto del proceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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
