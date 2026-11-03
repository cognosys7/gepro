<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : CONTRATO_CONCEPTOVISTA de la tabla CONTRATO_CONCEPTO
  //  Fecha           : lunes, 13 de mayo de 2019 21:09:52
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-EEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/CONTRATO_CONCEPTO.js"></script>    


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

                    /* EDGAR */
                    $PIDE = $lCollection->Get('PIDE');
                    //$pAuxiliar = $lCollection->Get('pAuxiliar');
                    $DatosPadre = array(
//                        'Proyecto' => $lCollection->Get('VDES_LARGA_PROYECTO')
//                        , 'Codigo Proyecto' => $lCollection->Get('VCOD_INTERNO')
//                        , 'Fecha Inicio' => $lCollection->Get('VFEC_INICIO_PROY')
//                        , 'Fecha Término' => $lCollection->Get('VFEC_TERMINO_PROY')
                         'Nº Contrato' => $lCollection->Get('VCOD_UNICO_ORDEN')
                        , 'Definición Contrato' => $lCollection->Get('VDES_CONTRATO')
                        , 'Importe' => $lCollection->Get('VIMP_TOTAL')
                    );
                    
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
                                <li><a href="#tabs-1">Listado de Cartas Fianzas del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Carta Fianza del Contrato </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <!--/*EDGAR*/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                    <!--/*EDGAR*/-->

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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Tipo Concepto', name: 'TipoConcepto', width: GetColumnSize(10), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Número', name: 'COD_TIPO_DOCUMENTO', width: GetColumnSize(11), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Tipo Documento', name: 'TipoDocumento', width: GetColumnSize(13), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Banco', name: 'DES_BANCO', width: GetColumnSize(18.8), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Monto', name: 'IMP_CONCEPTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Inicio', name: 'FEC_INICIO', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Término', name: 'FEC_TERMINO', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    
                                                                    {display: 'Archivo', name: 'Boton5', width: GetColumnSize(6), sortable: false, align: 'center'},
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
                                                                    {display: 'Número', name: 'COD_TIPO_DOCUMENTO'},
                                                                    {display: 'Tipo Concepto', name: 'TipoConcepto'},
                                                                    {display: 'Tipo Documento', name: 'TipoDocumento'},
                                                                    {display: 'Banco', name: 'DES_BANCO'},
                                                                    {display: 'Inicio', name: 'FEC_INICIO'},
                                                                    {display: 'Término', name: 'FEC_TERMINO'},
                                                                    {display: 'Estado', name: 'Estado'}
                                                        ],
                                                                sortname: "Estado ASC, FEC_TERMINO",
                                                                sortorder: "DESC", /* ordenaor ascendente o descendente */

                                                                usepager: true, /* activa o descativa paginación */
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 10,
                                                                height: $("#datos").innerHeight,
                                                                query: '',
                                                                nowrap: false

                                                                        /*EDGAR*/
<?php if( $PIDE>0 ) {    ?>                ,title: '<?php visTabla_DatosPadre($DatosPadre);  ?>'    <?php }    ?> 
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


                $IDE_CONT_CONCEPTO = $lCollection->Get('IDE_CONT_CONCEPTO');
                $IDE_CONTRATO = $lCollection->Get('IDE_CONTRATO');
                $IDE_BANCO = $lCollection->Get('IDE_BANCO');
                $TIP_CONCEPTO = $lCollection->Get('TIP_CONCEPTO');
                $TIP_DOCUMENTO = $lCollection->Get('TIP_DOCUMENTO');
                $COD_TIPO_DOCUMENTO = $lCollection->Get('COD_TIPO_DOCUMENTO');
                $IMG_DOCUMENTO = $lCollection->Get('IMG_DOCUMENTO');
                $IMP_CONCEPTO = $lCollection->Get('IMP_CONCEPTO');
                $FEC_EMISION = $lCollection->Get('FEC_EMISION');
                $FEC_INICIO = $lCollection->Get('FEC_INICIO');
                $FEC_TERMINO = $lCollection->Get('FEC_TERMINO');
                $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
                $EST_CONT_CONCEPTO = $lCollection->Get('EST_CONT_CONCEPTO');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $IDE_CONTRATO = $PIDE ;
                $DatosPadre = array(
                         'Nº Contrato' => $lCollection->Get('VCOD_UNICO_ORDEN')
                        , 'Definición Contrato' => $lCollection->Get('VDES_CONTRATO')
                        , 'Importe' => $lCollection->Get('VIMP_TOTAL')
                    );
                //$COD_TABLA = $lCollection->Get('VCOD_TABLA'); //codigo superior autocompleta
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;
                
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                /* EDGAR */

                
                
                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_BANCO_1 = $lCollection->Get('DataSet_GEN_BANCO_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Concepto de Contrato"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Concepto de Contrato"; //Nombre de la Tabla
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


            $('#FEC_EMISION').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_INICIO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO').datepicker({
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

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>">        
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
    <?php visTabla_DatosPadre($DatosPadre);  ?>
        <!--/*EDGAR*/-->

        <br>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_CONCEPTO">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONT_CONCEPTO" id="IDE_CONT_CONCEPTO" value="<?php echo $IDE_CONT_CONCEPTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONTRATO">IdeContrato: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONTRATO" id="IDE_CONTRATO" value="<?php echo $IDE_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="IdeContrato"/>

            </div>
        </div>							


        <div class="control-group">
            <label class="control-label" for="TIP_CONCEPTO">Tipo Concepto:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_CONCEPTO('TIP_CONCEPTO', $DataSet_GEN_TABLAS_1, $TIP_CONCEPTO, 1, "") ?>				
            </div>
        </div>  						

                
        <div class="control-group">
            <label class="control-label" for="COD_TIPO_DOCUMENTO">Número Documento: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_TIPO_DOCUMENTO" id="COD_TIPO_DOCUMENTO" value="<?php echo $COD_TIPO_DOCUMENTO; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class=" required show-popover"  data-trigger="hover" data-content="Ingrese Número Documento" style='width:13%;' />					
            </div>
        </div>	
        

        <div class="control-group">
            <label class="control-label" for="TIP_DOCUMENTO">Tipo Documento:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_DOCUMENTO('TIP_DOCUMENTO', $DataSet_GEN_TABLAS_2, $TIP_DOCUMENTO, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_BANCO">Banco:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_BANCO('IDE_BANCO', $DataSet_GEN_BANCO_1, $IDE_BANCO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  
        
						


        <div class="control-group">
            <label class="control-label" for="IMP_CONCEPTO">Monto por Concepto: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_CONCEPTO" id="IMP_CONCEPTO" value="<?php echo $IMP_CONCEPTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto por Concepto" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="FEC_EMISION">Fecha Emisión:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_EMISION" id="FEC_EMISION" style="width: 10%" value="<?php echo $FEC_EMISION; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Emisión" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_INICIO">Fecha Inicio:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_INICIO" id="FEC_INICIO" style="width: 10%" value="<?php echo $FEC_INICIO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Inicio" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_TERMINO">Fecha Término:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_TERMINO" id="FEC_TERMINO" style="width: 10%" value="<?php echo $FEC_TERMINO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Término" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						



        <div class="control-group" style="display:none">
            <label class="control-label" for="IMG_DOCUMENTO">Archivo adjunto: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMG_DOCUMENTO" id="IMG_DOCUMENTO" value="<?php echo $IMG_DOCUMENTO; ?>" onChange="conMayusculas(this)" maxlength="1000" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Archivo adjunto"/>					
            </div>
        </div>
        
        
        <div class="control-group">
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Observación" ><?php echo $DES_OBSERVACION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_CONT_CONCEPTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_CONT_CONCEPTO('EST_CONT_CONCEPTO', $DataSet_GEN_TABLAS_3, $EST_CONT_CONCEPTO, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_BANCO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Banco" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_BANCO > 0)) {
            if ($lstDatos[$i]->IDE_BANCO == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_BANCO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_BANCO . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_BANCO . "\">" . $lstDatos[$i]->DES_BANCO . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
    <?php
}

function comboTIP_CONCEPTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Concepto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_DOCUMENTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Documento" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_CONT_CONCEPTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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