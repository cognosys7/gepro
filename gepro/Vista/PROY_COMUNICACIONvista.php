<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMUNICACIONVISTA de la tabla PROY_COMUNICACION
  //  Fecha           : viernes, 28 de junio de 2019 20:22:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADOEtiqueta
  //  Modificado      : 29 de Junio 2019
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMUNICACION.js"></script>    


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
                    $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
                    
                    //$pAuxiliar = $lCollection->Get('pAuxiliar');
                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido') == 'Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if (strlen($Pedido) > 0) {
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
                    
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
                                <li><a href="#tabs-1">Listado de Comunciaciones del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Comunciaciones del Proyecto </a></li>
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
                                            Seleccione un registro para editar <?php echo ' - ' . $Pedido; ?>
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
                                                            {display: 'Descripción de la Comunicación', name: 'DES_COMUNICACION', width: GetColumnSize(28), sortable: true, align: 'left', hide: false},
                                                            {display: 'Inicio', name: 'FEC_INICIO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                            {display: 'Término', name: 'FEC_TERMINO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                            {display: 'Frecuencia', name: 'TIP_FRECUENCIA', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Método', name: 'TIP_METODO_COMUNICACION', width: GetColumnSize(11), sortable: true, align: 'center', hide: false},
                                                            {display: 'Medio', name: 'TIP_MEDIO_COMUNICACION', width: GetColumnSize(11), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
        /*<?php //if( $pAuxiliar=='Anidado' ) {  ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'},   <?php //}  ?>   */
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Interesados', name: 'Interesado', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php if ($VerSeleccion <> 'SI') { ?>{name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Descripción de la Comunicación', name: 'DES_COMUNICACION'},
                                                            {display: 'Inicio', name: 'FEC_INICIO'},
                                                            {display: 'Término', name: 'FEC_TERMINO'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php echo $Tabla_DatosPadre;  ?>'    <?php } ?>
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


                $IDE_COMUNICACION = $lCollection->Get('IDE_COMUNICACION');
                $IDE_PROYECTO = $lCollection->Get('IDE_PROYECTO');
                $DES_COMUNICACION = $lCollection->Get('DES_COMUNICACION');
                $FEC_INICIO = $lCollection->Get('FEC_INICIO');
                $FEC_TERMINO = $lCollection->Get('FEC_TERMINO');
                $TIP_DIRECCION_EMISOR_RECEPTOR = $lCollection->Get('TIP_DIRECCION_EMISOR_RECEPTOR');
                $TIP_FRECUENCIA = $lCollection->Get('TIP_FRECUENCIA');
                $TIP_COMPLEJIDAD_COMUNICACION = $lCollection->Get('TIP_COMPLEJIDAD_COMUNICACION');
                $TIP_METODO_COMUNICACION = $lCollection->Get('TIP_METODO_COMUNICACION');
                $TIP_MEDIO_COMUNICACION = $lCollection->Get('TIP_MEDIO_COMUNICACION');
                $DES_GLOSARIO_TERMINOS = $lCollection->Get('DES_GLOSARIO_TERMINOS');
                $EST_COMUNICACION = $lCollection->Get('EST_COMUNICACION');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $Tabla_DatosPadre = $lCollection->Get('Tabla_DatosPadre');
                
                /* para la herencia */
                $IDE_PROYECTO = $PIDE; //codigo superior autocompleta

                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');

                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//        $BIDE = $Bdescripcion = "";
//        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//          $BIDE = $lCollection->Get('BIDE');;
//          $Bdescripcion = $lCollection->Get('Bdescripcion');
//        }
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                /* EDGAR */

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


                $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');


                $DataSet_GEN_TABLAS_5 = $lCollection->Get('DataSet_GEN_TABLAS_5');


                $DataSet_GEN_TABLAS_6 = $lCollection->Get('DataSet_GEN_TABLAS_6');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Comunciaciones del Proyecto"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Comunciaciones del Proyecto"; //Nombre de la Tabla
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
        ////// para extraer datos
        function CompruebaPaseDatos()
        {
        var f = parent.document.formulario;
    //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;  ?>');
    //            f.IDE.value = '<?php //echo $BIDE;  ?>';
    //            f.DES.value = '<?php //echo $Bdescripcion;  ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            //CompruebaPaseDatos();
    <?php } ?>

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
    <?php
    if ($PIDE > 0) {
        echo $Tabla_DatosPadre.'<br>'; 
    }
    ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_COMUNICACION">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_COMUNICACION" id="IDE_COMUNICACION" value="<?php echo $IDE_COMUNICACION; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">IdeProyecto: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="IdeProyecto"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_COMUNICACION">Descripcion de Comunicación: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_COMUNICACION" id="DES_COMUNICACION" rows="3" onChange="conMayusculas(this)" maxlength="400" class="xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese Descripción de Comunicación" ><?php echo $DES_COMUNICACION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_INICIO">Fecha Inicio:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_INICIO" id="FEC_INICIO" style="width: 10%" value="<?php echo $FEC_INICIO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric required show-popover"  data-trigger="hover" data-content="Seleccione Fecha Inicio" placeholder="DD/MM/YYYY"/>					
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


        <div class="control-group">
            <label class="control-label" for="TIP_DIRECCION_EMISOR_RECEPTOR">Dirección de Emisor:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_DIRECCION_EMISOR_RECEPTOR('TIP_DIRECCION_EMISOR_RECEPTOR', $DataSet_GEN_TABLAS_1, $TIP_DIRECCION_EMISOR_RECEPTOR, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_FRECUENCIA">Frecuencia:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_FRECUENCIA('TIP_FRECUENCIA', $DataSet_GEN_TABLAS_2, $TIP_FRECUENCIA, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_COMPLEJIDAD_COMUNICACION">Complejidad:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_COMPLEJIDAD_COMUNICACION('TIP_COMPLEJIDAD_COMUNICACION', $DataSet_GEN_TABLAS_3, $TIP_COMPLEJIDAD_COMUNICACION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_METODO_COMUNICACION">Metodo de Comunicación:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_METODO_COMUNICACION('TIP_METODO_COMUNICACION', $DataSet_GEN_TABLAS_4, $TIP_METODO_COMUNICACION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="TIP_MEDIO_COMUNICACION">Medio de Comunicación:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_MEDIO_COMUNICACION('TIP_MEDIO_COMUNICACION', $DataSet_GEN_TABLAS_5, $TIP_MEDIO_COMUNICACION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_GLOSARIO_TERMINOS">Glosario de Términos: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_GLOSARIO_TERMINOS" id="DES_GLOSARIO_TERMINOS" rows="5" onChange="conMayusculas(this)" maxlength="2000" class="xlarge show-popover"  data-trigger="hover" data-content="Ingrese Glosario de Términos" ><?php echo $DES_GLOSARIO_TERMINOS; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_COMUNICACION">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_COMUNICACION('EST_COMUNICACION', $DataSet_GEN_TABLAS_6, $EST_COMUNICACION, 1, "") ?>				
            </div>
        </div>  						


 

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

                <?php
            }

            /*             * *********************************************************************************
             * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
             * ********************************************************************************* */

            function comboTIP_DIRECCION_EMISOR_RECEPTOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
                ?>    
    <select data-trigger="hover" data-content="Seleccione Dirección de Emisor" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_FRECUENCIA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Frecuencia" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_COMPLEJIDAD_COMUNICACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Complejidad" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_METODO_COMUNICACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Metodo de Comunicación" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_MEDIO_COMUNICACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Medio de Comunicación" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboEST_COMUNICACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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