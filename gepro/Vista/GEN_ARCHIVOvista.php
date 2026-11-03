<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ARCHIVOVISTA de la tabla GEN_ARCHIVO
  //  Fecha           : lunes, 3 de junio de 2019 22:00:44
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-JEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_ARCHIVO.js?v=20261028_01"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />
    <!--/*EDGAR*/-->

    <script type="text/javascript">
        //TECLA ESC EN LA PESTAÑA DE EDICION: VUELVE AL LISTADO (ventana-modal.js)
        window.VentanaCancelar = function () { Cancelar(); };

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

        //COLUMNAS AJUSTADAS AL ANCHO DE LA VENTANA: LOS BOTONES CON ANCHO FIJO Y EL RESTO EN PROPORCION (ventana-modal.js)
        var AdjAjustarColumnas = VentanaColumnasAdaptables("#flex1",
            {DES_ARCHIVO: 50, FEC_CARGA: 30, Estado: 20},
            {Boton3: 76, Boton5: 116, Boton1: 76, Boton2: 76});

        //AL CARGAR LA GRILLA: "VER ARCHIVO" COMO BOTON "DESCARGAR" (ventana-modal.js) Y COLUMNAS AJUSTADAS
        function AdjAlCargarGrilla() {
            GrillaEstilizarAcciones('#flex1');
            AdjAjustarColumnas();
        }

    </script>
    <div id="Mensajes"></div>
    <div class="row-fluid vm-ventana">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {

                    /* EDGAR */
                    $PIDE = $lCollection->Get('PIDE');
                    $Tabla = $lCollection->Get('Tabla');
                    
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
                    $crudArchivoDescargar = $lCollection->Get('crudArchivoDescargar');
                    $VTitulo = $lCollection->Get('VTitulo');
                    /* EDGAR */
                    //SUBTITULO DE LA CABECERA: "Migrar Plan de Avance Mensual" -> "Plan de Avance Mensual"
                    $AdjSubtitulo = trim(preg_replace('/^Migrar\s+/i', '', (string)$VTitulo));
                    ?>
                    <div class="vm-cabecera">
                        <span class="vm-icono"><i class="icon-paper-clip"></i></span>
                        <div class="vm-titulos">
                            <h3>Archivos adjuntos</h3>
                            <?php if ($AdjSubtitulo !== '') { ?><small><?php echo htmlspecialchars($AdjSubtitulo, ENT_QUOTES, 'UTF-8'); ?></small><?php } ?>
                        </div>
                        <button type="button" class="vm-cerrar" title="Cerrar" onclick="cerrarPopup();">&times;</button>
                    </div>
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
                                <li><a href="#tabs-1">Listado de Archivos Adjuntos del Registro </a></li>
                                <li><a href="#tabs-2">Detalle de Archivos Adjuntos del Registro </a></li>
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
                                    <input type="hidden" name="Tabla" value="<?php echo $Tabla; ?>">
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Tabla=<?php echo $Tabla; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Tabla', name: 'IDE_TABLA', width: GetColumnSize(10), sortable: true, align: 'left', hide: true},
                                                            {display: 'Registro', name: 'IDE_REGISTRO', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                            {display: 'Ruta', name: 'DES_RUTA', width: GetColumnSize(42), sortable: true, align: 'left', hide: true},
                                                            {display: 'Archivo', name: 'DES_ARCHIVO', width: GetColumnSize(45.4), sortable: true, align: 'left', hide: false},
                                                            {display: 'Fecha Carga', name: 'FEC_CARGA', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            /*EDGAR*/
                                                            /*<?php //if( $pAuxiliar=='Anidado' ) {  ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},   <?php //}  ?>   */
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(7), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Ver Archivo', name: 'Boton5', width: GetColumnSize(9), sortable: false, align: 'center', hide: <?php echo $crudArchivoDescargar; ?> },
                                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php if ($VerSeleccion <> 'SI') { ?>               {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
//                                                            {display: 'Tabla', name: 'IDE_TABLA'},
                                                            {display: 'Archivo', name: 'DES_ARCHIVO'},
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
                                                            nowrap: false,
                                                            onSuccess: AdjAlCargarGrilla

                                                            /*EDGAR*/
        <?php if ($PIDE > 0) { ?>, title: '<?php //visTabla_DatosPadre($DatosPadre);  ?>'    <?php } ?>
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


                $IDE_ARCHIVO = $lCollection->Get('IDE_ARCHIVO');
                $IDE_TABLA = $lCollection->Get('IDE_TABLA');
                $IDE_REGISTRO = $lCollection->Get('IDE_REGISTRO');
                $DES_RUTA = $lCollection->Get('DES_RUTA');
                $DES_ARCHIVO = $lCollection->Get('DES_ARCHIVO');
                $EST_ARCHIVO = $lCollection->Get('EST_ARCHIVO');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $Tabla = $lCollection->Get('Tabla');
                $DES_RUTA = $lCollection->Get('VRuta');
                $VTitulo = $lCollection->Get('VTitulo');    
                /* para la herencia */
                $IDE_REGISTRO = $PIDE; //codigo superior autocompleta
                $IDE_TABLA = $Tabla ;

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




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Archivos Adjuntos del Registro para ".$VTitulo; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Archivos Adjuntos del Registro para ".$VTitulo; //Nombre de la Tabla
                    $EST_ARCHIVO = 1;
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
    //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;  ?>');
    //            f.IDE.value = '<?php //echo $BIDE;  ?>';
    //            f.DES.value = '<?php //echo $Bdescripcion;  ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            //CompruebaPaseDatos();
    <?php } ?>

    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post" enctype="multipart/form-data">
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
        //Tabla_Proyecto_Datos($PIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($PINTERVENCION);  
        echo '<br>';
    }
    ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_ARCHIVO">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_ARCHIVO" id="IDE_ARCHIVO" value="<?php echo $IDE_ARCHIVO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_TABLA">Tabla: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_TABLA" id="IDE_TABLA" value="<?php echo $IDE_TABLA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class=" required show-popover"  data-trigger="hover" data-content="Tabla"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_REGISTRO">Registro: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_REGISTRO" id="IDE_REGISTRO" value="<?php echo $IDE_REGISTRO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Registro"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="DES_RUTA">Ruta: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_RUTA" id="DES_RUTA" value="<?php echo $DES_RUTA; ?>" onChange="conMayusculas(this)" maxlength="250" type="text" class=" required show-popover"  data-trigger="hover" data-content="Ingrese Ruta"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_ARCHIVO">Archivo : <span class="error">*</span></label>
            <div class="controls">
                <input readonly name="DES_ARCHIVO" id="DES_ARCHIVO" value="<?php echo $DES_ARCHIVO; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="  show-popover"  data-trigger="hover" data-content="Ingrese Archivo" style='width:35%;' />					
                <input  type="file" name="archivo" id="archivo"  data-content="Seleccione un archivo "/>
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_ARCHIVO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_ARCHIVO('EST_ARCHIVO', $DataSet_GEN_TABLAS_1, $EST_ARCHIVO, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

                <?php
            }

            /*             * *********************************************************************************
             * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
             * ********************************************************************************* */

            function comboEST_ARCHIVO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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