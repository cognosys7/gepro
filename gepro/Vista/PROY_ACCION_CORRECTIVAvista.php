<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    	  : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. julio C�sar Meza Yangali                      
//  Prop�sito       : PROY_ACCION_CORRECTIVAvista de la tabla PROY_ACCION_CORRECTIVA
//  Fecha           : s�bado, 3 de julio de 2021 2:15:12
//  Desde el Modelo : PDM - Modelo F�sico de Datos - SGPAM
//  Modificado      : s�bado, 3 de julio de 2021 2:15:12
//

//******************************************************************************/

function muestraVista()
{
    $lCollection = Collection::Singleton();
    //INFORMACI�N DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK        = $lCollection->Get('PermisoOK');
?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css" />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_ACCION_CORRECTIVA.js"></script>


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen" />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <link rel="stylesheet" type="text/css" href="../recursos/css/include.css" />
    <!--/*EDGAR*/-->

    <script type="text/javascript">
        function cerrarPopup() {
            parent.$.colorbox.close();
            parent.$('#flex1').flexReload();
        }
        $(function() {
            $("#tabs").tabs({
                active: 0
            });
            $("#tabs").tabs({
                disabled: [1]
            });
        });

        function CallFlexiGrid() {
            $('#flex1').flexReload();
        }
    </script>
    <div id="Mensajes"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {

                    /*EDGAR*/
                    /* Inicializaci�n de variables auxiliares */
                    $PIDE = $lCollection->Get('PIDE');   // identificador de la tabla padre
                    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
                    $Recursiva_hide = $lCollection->Get('Recursiva_hide');
                    $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');

                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = '';
                    $Pedido = $lCollection->Get('Pedido');
                    if ($Pedido == 'Busqueda') {
                        $FormularioAccion = 'PasarDatos';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
                    /* Obtiene el comportamiento de acceso CRUD segun el rol del usuario */
                    $crud = $lCollection->Get('crud');
                    /*EDGAR*/
                ?>
                    <!--<div class="box-content">-->
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
                        <!-- CAMBIAR ETIQUETAS DE LAS PESTA�AS-->
                        <ul>
                            <li><a href="#tabs-1">Listado de Acciones Correctivas </a></li>
                            <li><a href="#tabs-2">Detalle de Acción Correctiva </a></li>
                        </ul>
                        <!--CONTENIDO DE LA PESTA�A 1-->
                        <div id="tabs-1">


                            <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                <!-- PASO DE VARIABLES A OTRA P�GINA -->
                                <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                <!-- <input type="hidden" name="ActionForm" value=""> -->
                                <input type="hidden" name="SeleccionarID" value="">

                                <!--/*EDGAR*/-->
                                <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                <input type="hidden" name="PIDEbuscado" value="">
                                <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                <input type="hidden" name="Recursiva_Nivel_Actual" value="<?php echo $Recursiva_Nivel_Actual; ?>">

                                <!--/*EDGAR*/-->

                                <div id="contenedor">
                                    <div id="fila1">
                                        <div class="limpiar"></div>
                                    </div>

                                    <div class="msjListado" id="mensaje">
                                        Seleccione un registro para editar <?php echo ' - ' . $Pedido; ?>
                                    </div>
                                    <div id="datos">
                                        <table id="flex1" style="display:none">
                                        </table>
                                    </div>

                                    <script type="text/javascript">
                                        $("#flex1").flexigrid({
                                            /*Pagina php donde se realiza la consulta sql */
                                            url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>&Recursiva_Nivel_Actual=<?php echo $Recursiva_Nivel_Actual; ?>',
                                            /* Tipo de datos devuelto json, xml */
                                            dataType: 'json',
                                            /* Metodo de Envio de  Datos*/
                                            method: 'POST',
                                            /* Lista de campo a mostrar en cada columna */
                                            colModel: [{
                                                    display: 'Ide',
                                                    name: 'ID',
                                                    width: GetColumnSize(0),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: true
                                                },
                                                {
                                                    display: 'Fec. Acción',
                                                    name: 'FecAccionCorrectiva',
                                                    width: GetColumnSize(8),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Componente',
                                                    name: 'Componente',
                                                    width: GetColumnSize(8),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Desviación Identificada',
                                                    name: 'DesviacionIdentificada',
                                                    width: GetColumnSize(30),
                                                    sortable: true,
                                                    align: 'left',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Acción Correctiva',
                                                    name: 'AccionCorrectiva',
                                                    width: GetColumnSize(30),
                                                    sortable: true,
                                                    align: 'left',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Estado',
                                                    name: 'Estado',
                                                    width: GetColumnSize(8),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: false
                                                },
                                                {
                                                    display: 'Fila',
                                                    name: 'NFILA',
                                                    width: GetColumnSize(0),
                                                    sortable: true,
                                                    align: 'center',
                                                    hide: true
                                                },


                                                /*EDGAR*/
                                                {
                                                    display: 'Ver',
                                                    name: 'Recursiva',
                                                    width: GetColumnSize(7),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $Recursiva_hide; ?>
                                                },
                                                {
                                                    display: 'Seleccionar',
                                                    name: 'Seleccionar',
                                                    width: GetColumnSize(6),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $crud['Seleccion']; ?>
                                                },
                                                {
                                                    display: 'Editar',
                                                    name: 'Boton1',
                                                    width: GetColumnSize(6),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $crud['Modificar']; ?>
                                                },
                                                {
                                                    display: 'Eliminar',
                                                    name: 'Boton2',
                                                    width: GetColumnSize(6),
                                                    sortable: false,
                                                    align: 'center',
                                                    hide: <?php echo $crud['Eliminar']; ?>
                                                }
                                                /*EDGAR*/
                                            ],
                                            /*Botones de Enlace*/
                                            buttons: [
                                                <?php if ($crud['Nuevo'] == 'true') { ?> {
                                                        name: 'Nuevo',
                                                        bclass: 'nuevo',
                                                        onpress: test
                                                    },
                                                <?php } ?> {
                                                    separator: true
                                                },
                                                {
                                                    name: 'Salir',
                                                    bclass: 'salir',
                                                    onpress: test
                                                }
                                            ],
                                            /*Lista de campo que se podra hacer busqueda */

                                            searchitems: [{
                                                    display: 'Desviacion Identificada',
                                                    name: 'DesviacionIdentificada'
                                                },
                                                {
                                                    display: 'Accion Correctiva',
                                                    name: 'AccionCorrectiva'
                                                }
                                            ],


                                            sortname: "Id",
                                            sortorder: "ASC",
                                            /* ordenaor ascendente o descendente */

                                            usepager: true,
                                            /* activa o descativa paginaci�n */
                                            singleSelect: true,
                                            useRp: true,
                                            rp: 10,
                                            height: $("#datos").innerHeight,
                                            query: '',
                                            nowrap: false

                                                /*EDGAR*/
                                                ,
                                            title: '<?php echo $Tabla_DatosPadre;  ?>'
                                            /*EDGAR*/
                                            //,showTableToggleBtn: true

                                        });
                                        /* Debe seleccionar una fila antes de pulsar el boton */
                                        function test(com, grid) {
                                            var nId = $('.trSelected', grid).children('td:eq(0)').text();
                                            if (com == 'Nuevo') {
                                                Nuevo('<?php echo $PaginaFormulario ?>');
                                            } else if (com == 'Salir') {
                                                cerrarPopup()
                                            } else {
                                                $('#mensaje').text('Debe Seleccionar un registro del listado').addClass('msjalerta')
                                            }
                                        }
                                    </script>
                                </div>
                            </form>
                        </div>
                        <!--PESTA�A 2-->
                        <div id="tabs-2">
                            <div id="FormularioDiv">
                                <!-- En esta seccion se muestra todos los datos recuperados del foumulario -->
                            </div>
                        </div>
                    </div>
                    <!--</div>-->
                <?php
                } else {
                    echo "<br><br><center>UD. NO TIENE ACCESO A ESTE M�DULO</center><br>";
                }
                ?>
            </div>
        </div>
    </div>
    <br><br>
<?php
}
//FUNCION PARA PROCESAR LOS MENSAJES DE LAS ACCIONES
function ProcesaMensaje()
{
    $lCollection = Collection::Singleton();
    $descmsje           = "";
    $sCodMensaje         = $lCollection->Get('CodMensaje');
    $sMensaje            = $lCollection->Get('Mensaje');
    if ($sCodMensaje <> "") {
        $descmsje = mensajesistema($sCodMensaje, $sMensaje);
    } else {
        $descmsje = mensajesistema($sMensaje);
    }
    echo $descmsje . "<br>";
}
//FUNCION UTILIZADA CUANDO SE REGISTRA O EDITA INFORMACI�N
function GeneraForm()
{
    $lCollection        = Collection::Singleton();
    $PaginaFormulario   = $lCollection->Get('PaginaFormulario');
    $PermisoOK          = $lCollection->Get('PermisoOK');

    //Recuperando valores para Mostrar en el Formulario
    $SeleccionarID    = $lCollection->Get('SeleccionarID');
    //$IdPersona        = $lCollection->Get('Id');


    $IDE_PROY_ACCION_CORRECTIVA     = $lCollection->Get('IDE_PROY_ACCION_CORRECTIVA');
    $IDE_PROYECTO     = $lCollection->Get('IDE_PROYECTO');
    $FEC_ACCION     = $lCollection->Get('FEC_ACCION');
    $DES_DESVIACION_IDENTIFICADA     = $lCollection->Get('DES_DESVIACION_IDENTIFICADA');
    $DES_ACCION_CORRECTIVA     = $lCollection->Get('DES_ACCION_CORRECTIVA');
    $EST_ACCION     = $lCollection->Get('EST_ACCION');
    $TIP_COMPONENTE     = $lCollection->Get('TIP_COMPONENTE');


    /*EDGAR*/
    $PIDE = $lCollection->Get('PIDE');
    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');

    /* para la herencia */
    $IDE_PROYECTO = $PIDE; //codigo superior autocompleta	

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    //        $BIDE = $Bdescripcion = "";
    //        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
    //          $BIDE = $lCollection->Get('BIDE');;
    //          $Bdescripcion = $lCollection->Get('Bdescripcion');
    //        }
    $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');
    //$NUM_NIVEL = intval($Recursiva_Nivel_Actual) ;                
    $crud = $lCollection->Get('crud');
    /*EDGAR*/

    /*LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX*/


    $DataSet_GEN_TABLAS_1    = $lCollection->Get('DataSet_GEN_TABLAS_1');

    $DataSet_GEN_TABLAS_2    = $lCollection->Get('DataSet_GEN_TABLAS_2');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario   = "ActualizarForm";
        $Btn                = "Actualizar";
        $TitulFormulario    = "Actualizar Acciones Correctivas"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario   = "RegistraDatos";
        $Btn                = "Registrar";
        $TitulFormulario    = "Registro de Acciones Correctivas"; //Nombre de la Tabla
    }
?>
    <script type="text/javascript">
        $(function() {
            //ACTIVA LOS TOOLTIPS
            $('*[data-content]').hover(function() {
                $(this).popover('show');
            });
            //VALIDACION DE FORMULARIO
            $("#BtnForm01").on("click", function() {
                if ($("#formulario").valid()) {
                    AjaxRegistraDatos('<?php echo $PaginaFormulario; ?>');
                }
            });
            //ACTIVAR PARA TRABAJAR CON FECHAS


            $('#FEC_ACCION').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });



        });


        // Permite obtener los datos del formulario actual en modo modal y asignar al formulario que lo invoc�
        // La nomenclatura de las variables deben tomar el valor del formulario que invoc�
        function CompruebaPaseDatos() {
            var f = parent.document.formulario;
            //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ; 
                                                ?>');
            //            f.IDE.value = '<?php //echo $BIDE; 
                                            ?>';
            //            f.DES.value = '<?php //echo $Bdescripcion; 
                                            ?>';

            parent.$.colorbox.close();
        }

        <?php if ($PIDEbuscado > 0) {  ?>
            //CompruebaPaseDatos();
        <?php   }   ?>
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
        <?php if ($PIDE > 0) {
            echo $Tabla_DatosPadre . '<br>';
        }
        ?>
        <!--/*EDGAR*/-->

        <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' ); 
        ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROY_ACCION_CORRECTIVA">Ide: <span class="error"></span></label>
            <div class="controls">

                <input name="IDE_PROY_ACCION_CORRECTIVA" id="IDE_PROY_ACCION_CORRECTIVA" value="<?php echo $IDE_PROY_ACCION_CORRECTIVA; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide" />

            </div>
        </div>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">IdeProyecto: <span class="error"></span></label>
            <div class="controls">
                <input name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="IdeProyecto" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="FEC_ACCION">Fecha de Acción:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">
                    <input name="FEC_ACCION" id="FEC_ACCION" style="width: 10%" value="<?php echo $FEC_ACCION; ?>" minlength="1" maxlength="10" type="text" class="alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese la fecha de acci�n" placeholder="DD/MM/YYYY" />
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="TIP_COMPONENTE">Componente:<span class="error">*</span></label>
            <div class="controls">
                <?php comboTIP_COMPONENTE('TIP_COMPONENTE', $DataSet_GEN_TABLAS_2, $TIP_COMPONENTE, 1, "") ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="DES_DESVIACION_IDENTIFICADA">Desviación Identificada: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_DESVIACION_IDENTIFICADA" id="DES_DESVIACION_IDENTIFICADA" rows="5" maxlength="1000" class="xlarge  required show-popover" data-trigger="hover" data-content="Ingrese la desviacion identificada"><?php echo $DES_DESVIACION_IDENTIFICADA; ?></textarea>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="DES_ACCION_CORRECTIVA">Acción Correctiva: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_ACCION_CORRECTIVA" id="DES_ACCION_CORRECTIVA" rows="5" maxlength="1000" class="xlarge  required show-popover" data-trigger="hover" data-content="Ingrese la acci�n correctiva"><?php echo $DES_ACCION_CORRECTIVA; ?></textarea>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="EST_ACCION">Estado:<span class="error">*</span></label>
            <div class="controls">
                <?php comboEST_ACCION('EST_ACCION', $DataSet_GEN_TABLAS_1, $EST_ACCION, 1, "") ?>
            </div>
        </div>



        <?php echo $crud['Grabar']; ?>

        <!--
            <div class="form-actions">
                <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
            </div>
      -->

    </form>

<?php
}
/***********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 ***********************************************************************************/



function comboEST_ACCION($nombre, $lstDatos, $valorInicial, $habil, $estilo)
{
?>
    <select data-trigger="hover" data-content="Seleccion el estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled" <?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
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

function comboTIP_COMPONENTE($nombre, $lstDatos, $valorInicial, $habil, $estilo)
{
?>
    <select data-trigger="hover" data-content="Seleccion el Componente" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled" <?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?>>
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
