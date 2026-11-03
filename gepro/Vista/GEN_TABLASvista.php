<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_TABLASVISTA de la tabla GEN_TABLAS
  //  Fecha           : viernes, 3 de mayo de 2019 16:41:52
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-BEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_TABLAS.js"></script>    


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
                    $pAuxiliar = $lCollection->Get('pAuxiliar');
                    $DatosPadre  =   array(
                        'Tabla'           =>  $lCollection->Get('VDES_ITEM')
//                        ,'VCOD_TABLA'     =>  $lCollection->Get('VCOD_TABLA')
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
                                <li><a href="#tabs-1">Listado de Tablas para Selección de Opciones </a></li>
                                <li><a href="#tabs-2">Detalle de Tablas para Selección de Opciones </a></li>
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
                                                                    {display: 'Código Tabla', name: 'COD_TABLA', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Código Item', name: 'COD_ITEM', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Descripción', name: 'DES_ITEM', width: GetColumnSize(37.8), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Abreviatura', name: 'DES_ABREVIATURA', width: GetColumnSize(12.8), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Nº Orden', name: 'COD_ORDEN', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
<?php if( $pAuxiliar=='Anidado' ) {  ?>                              {display: 'Valores', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'},   <?php }  ?>
                                                                    /*EDGAR*/
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true}
                                                                    ,{name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Descripción', name: 'DES_ITEM'},
                                                                    {display: 'Abreviatura', name: 'DES_ABREVIATURA'},
                                                                    {display: 'Código Tabla', name: 'COD_TABLA'},
                                                                    {display: 'Código Item', name: 'COD_ITEM'},
                                                                    
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
<?php if( $PIDE>0 ) {    ?>                                     ,title: '<?php visTabla_DatosPadre($DatosPadre);  ?>'    <?php }    ?> 
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
                                              }
                                                else if (com == 'Salir')
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


    $IDE_TABLA = $lCollection->Get('IDE_TABLA');
    $COD_TABLA = $lCollection->Get('COD_TABLA');
    $COD_ITEM = $lCollection->Get('COD_ITEM');
    $DES_ITEM = $lCollection->Get('DES_ITEM');
    $DES_ABREVIATURA = $lCollection->Get('DES_ABREVIATURA');
    $COD_ORDEN = $lCollection->Get('COD_ORDEN');
    $EST_ITEM = $lCollection->Get('EST_ITEM');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $DatosPadre  =   array(
        'Tabla'           =>  $lCollection->Get('VDES_ITEM')
//        ,'VCOD_ITEM'     =>  $lCollection->Get('VCOD_ITEM')
    );
    $COD_TABLA = $lCollection->Get('VCOD_TABLA'); //codigo superior autocompleta
    
    $PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : 'style="display:none"' ) ;
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Tablas para Selección de Opciones"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Tablas para Selección de Opciones"; //Nombre de la Tabla
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
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
<?php if( $PIDE>0 ) {     visTabla_DatosPadre($DatosPadre); } ?>
        <!--/*EDGAR*/-->


        <br>
        
        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_TABLA">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_TABLA" id="IDE_TABLA" value="<?php echo $IDE_TABLA; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="COD_TABLA">Código Tabla: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_TABLA" id="COD_TABLA" value="<?php echo $COD_TABLA; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el código de la tabla"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_ITEM">Código Item: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_ITEM" id="COD_ITEM" value="<?php echo $COD_ITEM; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class=" number required show-popover"  data-trigger="hover" data-content="Ingrese el código del Item" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ITEM">Descripción Item: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_ITEM" id="DES_ITEM" value="<?php echo $DES_ITEM; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class=" required show-popover"  data-trigger="hover" data-content="Ingrese la descripción del item"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ABREVIATURA">Abreviatura: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_ABREVIATURA" id="DES_ABREVIATURA" value="<?php echo $DES_ABREVIATURA; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class=" show-popover" data-trigger="hover" data-content="Ingrese la abreviatura de la descripción" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_ORDEN"> Orden visualización: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_ORDEN" id="COD_ORDEN" value="<?php echo $COD_ORDEN; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Orden visualización" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_ITEM">Estado Item:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_ITEM('EST_ITEM', $DataSet_GEN_TABLAS_1, $EST_ITEM, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_ITEM($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Ingrese el estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <!--<option value="">Seleccione una Opción</option>-->        
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