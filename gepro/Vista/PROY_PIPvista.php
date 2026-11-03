<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_PIPVISTA de la tabla PROY_PIP
  //  Fecha           : jueves, 16 de mayo de 2019 15:57:58
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_PIP.js"></script>    


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
                    $nTotal = $lCollection->Get('nTotal');
                    $cuentaResultado = $lCollection->Get('cuentaResultado');
                    //$pAuxiliar = $lCollection->Get('pAuxiliar');
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
                                <li><a href="#tabs-1">Listado de Proyecto de Inversión asociado al Proyecto AMSAC </a></li>
                                <li><a href="#tabs-2">Detalle de Proyecto de Inversión asociado al Proyecto AMSAC </a></li>
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
                                            Seleccione un registro para editar <?php echo '. '.SPRING_msgListaActualizada(); ?>
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
                                                                    {display: 'Cod. SNIP', name: 'COD_SNIP', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cod. Único', name: 'COD_UNICO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Proyecto Inversión ', name: 'DES_PIP', width: GetColumnSize(58.9), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Cod. InfObras', name: 'COD_INFOBRAS', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Cod. Interno', name: 'COD_INTERNO', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'EstadoSNIP', name: 'EstadoSNIP', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Check', name: 'CheckReg', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
                                                                    /*<?php //if( $pAuxiliar=='Anidado' ) {    ?>                              {display: 'Valores', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},   <?php //}    ?>   */
                                                                    /*EDGAR*/
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center', hide: true},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: true }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
        <?php if ($cuentaResultado == 0) { ?>                       {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Cod. SNIP', name: 'COD_SNIP'},
                                                                    {display: 'Cod. Único', name: 'COD_UNICO'},
                                                                    {display: 'Proyecto Inversión ', name: 'DES_PIP'},
                                                                    {display: 'Cod. InfObras', name: 'COD_INFOBRAS'},
                                                                    {display: 'Cod. Interno', name: 'COD_INTERNO'},
                                                                    {display: 'EstadoSNIP', name: 'EstadoSNIP'},
                                                                    {display: 'Check', name: 'CheckReg'},
                                                                    {display: 'Estado', name: 'Estado'}
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

        /*EDGAR*/
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE);  ?>'    <?php } ?>
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


    $IDE_PROY_PIP = $lCollection->Get('IDE_PROY_PIP');
    $IDE_PIP = $lCollection->Get('IDE_PIP');
    $IDE_PROYECTO = $lCollection->Get('IDE_PROYECTO');
    $COD_SNIP = $lCollection->Get('COD_SNIP');
    $COD_UNICO = $lCollection->Get('COD_UNICO');
    $COD_INFOBRAS = $lCollection->Get('COD_INFOBRAS');
    $COD_INTERNO = $lCollection->Get('COD_INTERNO');
    $EST_PROY_SNIP = $lCollection->Get('EST_PROY_SNIP');
    $CHK = $lCollection->Get('CHK');
    $EST_PROY_PIP = $lCollection->Get('EST_PROY_PIP');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $IDE_PROYECTO = $PIDE; //codigo superior autocompleta
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;
    $B_PIP = $lCollection->Get('Bdescripcion');
    
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
        $TitulFormulario = "Actualizar Proyecto de Inversión asociado al Proyecto AMSAC"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Proyecto de Inversión asociado al Proyecto AMSAC"; //Nombre de la Tabla
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

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>">     
        <input type="hidden" name="varBotonInvocador" value="">
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

<!--/*EDGAR*/-->
        <?php if ($PIDE > 0) {  echo Tabla_Proyecto_Datos($PIDE);  } ?>
<!--/*EDGAR*/-->

	<br>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROY_PIP">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PROY_PIP" id="IDE_PROY_PIP" value="<?php echo $IDE_PROY_PIP; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <!--        <div class="control-group">
                    <label class="control-label" for="IDE_PIP">IdePIP: <span class="error">*</span></label>
                    <div class="controls">
                        <input  name="IDE_PIP" id="IDE_PIP" value="<?php // echo $IDE_PIP;   ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="IdePIP"/>					
                    </div>
                </div>								-->
        <?php
        //  $COD_PROYECTO = '';  
        extraerIDEyValor_Area('IDE_PIP', $IDE_PIP, 'PROY_PIP', 'Proyecto Inversión', 'B_PIP', $B_PIP, 'PIP');
        ?>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">IdeProyecto: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="IdeProyecto"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_SNIP">Código SNIP: <span class="error"></span></label>
            <div class="controls">
                <input readonly name="COD_SNIP" id="COD_SNIP" value="<?php echo $COD_SNIP; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código SNIP" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_UNICO">Código Unico: <span class="error">*</span></label>
            <div class="controls">
                <input readonly name="COD_UNICO" id="COD_UNICO" value="<?php echo $COD_UNICO;   ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric  show-popover"  data-trigger="hover" data-content="Ingrese Código Unico" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="COD_INFOBRAS">Código InfoObras: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_INFOBRAS" id="COD_INFOBRAS" value="<?php echo $COD_INFOBRAS; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código InfoObras" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="COD_INTERNO">Código Interno: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_INTERNO" id="COD_INTERNO" value="<?php echo $COD_INTERNO; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Interno" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="EST_PROY_SNIP">Estado SNIP:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboEST_PROY_SNIP('EST_PROY_SNIP', $DataSet_GEN_TABLAS_1, $EST_PROY_SNIP, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none" >
            <label class="control-label" for="CHK">Check:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboCHK('CHK', $DataSet_GEN_TABLAS_2, $CHK, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="EST_PROY_PIP">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROY_PIP('EST_PROY_PIP', $DataSet_GEN_TABLAS_3, $EST_PROY_PIP, 1, "") ?>				
            </div>
        </div>  						


        <?php echo $crudGrabarCancelar; ?>
        
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_PROY_SNIP($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese Estado SNIP" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboCHK($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Check" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_PROY_PIP($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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