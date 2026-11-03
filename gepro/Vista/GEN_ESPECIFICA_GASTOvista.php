<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ESPECIFICA_GASTOVISTA de la tabla GEN_ESPECIFICA_GASTO
  //  Fecha           : domingo, 26 de mayo de 2019 2:36:59
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-IEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_ESPECIFICA_GASTO.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <!--<link rel="stylesheet" type="text/css" href="../lib/css/include.css" />-->
    <!--/*EDGAR*/-->

    <script type="text/javascript">
        function cerrarPopup()
        {
        parent.$.colorbox.close();
        parent.$('#flex1').flexReload();
        }
        $(function(){
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
                    
                    ////// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido') == 'Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if (strlen($Pedido) > 0) {
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
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
                                <li><a href="#tabs-1">Listado de Específicas de Gasto </a></li>
                                <li><a href="#tabs-2">Detalle de Específicas de Gasto </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <!-- <input type="hidden" name="ActionForm" value=""> -->                               
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <!--/*EDGAR*/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                    <input type="hidden" name="PIDEbuscado" value="">
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                    <!--/*EDGAR*/-->

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar <?php echo ' - ' . $Pedido.'. '.SPRING_msgListaActualizada() ; ?>
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Año Fiscal', name: 'NUM_ANHO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Código de Específica', name: 'COD_ESPECIFICA_GASTO', width: GetColumnSize(12), sortable: true, align: 'left', hide: false},
                                                            {display: 'Específica de Gasto', name: 'DES_ESPECIFICA_GASTO', width: GetColumnSize(62.5), sortable: true, align: 'left', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
        /*<?php //if( $pAuxiliar=='Anidado' ) {   ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},   <?php //}   ?>   */
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: true}
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
<?php if( $VerSeleccion <> 'SI' ) {   ?>                  //  {name: 'Nuevo', bclass: 'nuevo', onpress: test},    <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Año Fiscal', name: 'NUM_ANHO'},
                                                            {display: 'Código de Específica', name: 'COD_ESPECIFICA_GASTO'},
                                                            {display: 'Específica de Gasto', name: 'DES_ESPECIFICA_GASTO'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php //visTabla_DatosPadre($DatosPadre);   ?>'    <?php } ?>
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
                                            }
                                            else
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


    $IDE_ESPECIFICA_GASTO = $lCollection->Get('IDE_ESPECIFICA_GASTO');
    $NUM_ANHO = $lCollection->Get('NUM_ANHO');
    $COD_ESPECIFICA_GASTO = $lCollection->Get('COD_ESPECIFICA_GASTO');
    $DES_ESPECIFICA_GASTO = $lCollection->Get('DES_ESPECIFICA_GASTO');
    $COD_GENERICA = $lCollection->Get('COD_GENERICA');
    $DES_GENERICA = $lCollection->Get('DES_GENERICA');
    $COD_SUBGENERICA = $lCollection->Get('COD_SUBGENERICA');
    $DES_SUBGENERICA = $lCollection->Get('DES_SUBGENERICA');
    $COD_SUBGENERICA_DET = $lCollection->Get('COD_SUBGENERICA_DET');
    $DES_SUBGNERICA_DET = $lCollection->Get('DES_SUBGNERICA_DET');
    $COD_ESPECIFICA = $lCollection->Get('COD_ESPECIFICA');
    $DES_ESPECIFICA = $lCollection->Get('DES_ESPECIFICA');
    $COD_ESPECIFICA_DET = $lCollection->Get('COD_ESPECIFICA_DET');
    $DES_ESPECIFICA_DET = $lCollection->Get('DES_ESPECIFICA_DET');
    $EST_ESPECIFICA_GASTO = $lCollection->Get('EST_ESPECIFICA_GASTO');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    
    /* para la herencia */
    //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta

    /* para la visualizacion de busqueda */
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    /* para el padre buscado */
    //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    $BIDE = $Bdescripcion = "";
    if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
      $BIDE = $lCollection->Get('BIDE');;
      $Bdescripcion = $lCollection->Get('Bdescripcion');
    }
    
    $cboReadonly = cboReadonly();
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Específicas de Gasto"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Específicas de Gasto"; //Nombre de la Tabla
    }
    ?>
    <script type="text/javascript">
        $(function(){
        //ACTIVA LOS TOOLTIPS
        $('*[data-content]').hover(function()
        {
        $(this).popover('show');
        });
        //VALIDACION DE FORMULARIO
        $("#BtnForm01").on("click", function() {
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
        ////// para extraer datos
        function CompruebaPaseDatos()
        {
        var f = parent.document.formulario;
//            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ; ?>');
            f.IDE_ESPECIFICA_GASTO.value = '<?php echo $BIDE; ?>';
            f.B_ESPECIFICA_GASTO.value = '<?php echo $Bdescripcion; ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            CompruebaPaseDatos();
    <?php } ?>

    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>"> 
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
        <?php //visTabla_DatosPadre($DatosPadre);  ?>
        <!--/*EDGAR*/-->







        <?php //extraerIDEyValor("COD_UBIGEO", $COD_UBIGEO, 'ESTANDAR', 'UBIGEO', 'DES_UBIGEO', $DES_UBIGEO, 'UBIGEO', '', 'width:50%');  ?>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ESPECIFICA_GASTO">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_ESPECIFICA_GASTO" id="IDE_ESPECIFICA_GASTO" value="<?php echo $IDE_ESPECIFICA_GASTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		





        <?php //extraerIDEyValor("COD_UBIGEO", $COD_UBIGEO, 'ESTANDAR', 'UBIGEO', 'DES_UBIGEO', $DES_UBIGEO, 'UBIGEO', '', 'width:50%');  ?>


        <div class="control-group">
            <label class="control-label" for="NUM_ANHO">Año Fiscal: <span class="error">*</span></label>
            <div class="controls">
                <input readonly  name="NUM_ANHO" id="NUM_ANHO" value="<?php echo $NUM_ANHO; ?>" onChange="conMayusculas(this)" maxlength="4" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Año Fiscal. Actualizado desde el SPRING" style='width:14.5%;' />					
            </div>
        </div>								


        <br>

        
        <div class="control-group">
            <label class="control-label" for="COD_ESPECIFICA_GASTO">Cód. Específica Gasto: <span class="error">*</span></label>
            <div class="controls">
                <input readonly  name="COD_ESPECIFICA_GASTO" id="COD_ESPECIFICA_GASTO" value="<?php echo $COD_ESPECIFICA_GASTO; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Código Específica de Gasto. Actualizado desde el SPRING" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ESPECIFICA_GASTO">Específica de Gasto: <span class="error">*</span></label>
            <div class="controls">
                <input readonly  name="DES_ESPECIFICA_GASTO" id="DES_ESPECIFICA_GASTO" value="<?php echo $DES_ESPECIFICA_GASTO; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Específica de Gasto. Actualizado desde el SPRING"/>					
            </div>
        </div>								


        <br>
        

        <div class="control-group">
            <label class="control-label" for="COD_GENERICA">Cód. Genérica: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_GENERICA" id="COD_GENERICA" value="<?php echo $COD_GENERICA; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Genérica" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_GENERICA">Genérica: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_GENERICA" id="DES_GENERICA" value="<?php echo $DES_GENERICA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Genérica"/>					
            </div>
        </div>								

        
        <br>
        

        <div class="control-group">
            <label class="control-label" for="COD_SUBGENERICA">Cód. Subgenérica: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_SUBGENERICA" id="COD_SUBGENERICA" value="<?php echo $COD_SUBGENERICA; ?>" onChange="conMayusculas(this)" maxlength="15" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Subgenérica" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_SUBGENERICA">Subgenérica: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_SUBGENERICA" id="DES_SUBGENERICA" value="<?php echo $DES_SUBGENERICA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Subgenérica"/>					
            </div>
        </div>								


        <br>


        <div class="control-group">
            <label class="control-label" for="COD_SUBGENERICA_DET">Cód. Subgené. Detalle: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_SUBGENERICA_DET" id="COD_SUBGENERICA_DET" value="<?php echo $COD_SUBGENERICA_DET; ?>" onChange="conMayusculas(this)" maxlength="15" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Subgenérica Detalle" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_SUBGNERICA_DET">Subgenérica Detalle: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_SUBGNERICA_DET" id="DES_SUBGNERICA_DET" value="<?php echo $DES_SUBGNERICA_DET; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Subgenérica Detalle"/>					
            </div>
        </div>								



        <br>


        <div class="control-group">
            <label class="control-label" for="COD_ESPECIFICA">Cód. Específica: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_ESPECIFICA" id="COD_ESPECIFICA" value="<?php echo $COD_ESPECIFICA; ?>" onChange="conMayusculas(this)" maxlength="15" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Específica" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ESPECIFICA">Específica: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_ESPECIFICA" id="DES_ESPECIFICA" value="<?php echo $DES_ESPECIFICA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Específica"/>					
            </div>
        </div>								



        <br>

        
        <div class="control-group">
            <label class="control-label" for="COD_ESPECIFICA_DET">Cód. Específica Detalle: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_ESPECIFICA_DET" id="COD_ESPECIFICA_DET" value="<?php echo $COD_ESPECIFICA_DET; ?>" onChange="conMayusculas(this)" maxlength="15" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Específica Detalle" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ESPECIFICA_DET">Específica Detalle: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_ESPECIFICA_DET" id="DES_ESPECIFICA_DET" value="<?php echo $DES_ESPECIFICA_DET; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Específica Detalle"/>					
            </div>
        </div>								


        
        <br>
        
        
        <div class="control-group">
            <label class="control-label" for="EST_ESPECIFICA_GASTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_ESPECIFICA_GASTO('EST_ESPECIFICA_GASTO', $DataSet_GEN_TABLAS_1, $EST_ESPECIFICA_GASTO, 1, $cboReadonly ) ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_ESPECIFICA_GASTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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