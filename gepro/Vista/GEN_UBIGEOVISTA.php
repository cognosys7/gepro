<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_UBIGEOVISTA de la tabla GEN_UBIGEO
  //  Fecha           : jueves, 20 de junio de 2019 3:07:55
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J4Etiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_UBIGEO.js"></script>    


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
                                <li><a href="#tabs-1">Listado de UBIGEO: Ubicación Geografica Distrital </a></li>
                                <li><a href="#tabs-2">Detalle de UBIGEO: Ubicación Geografica Distrital </a></li>
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
                                                            {display: 'UBIGEO', name: 'UBIGEO', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                            {display: 'Región', name: 'DES_DEPARTAMENTO', width: GetColumnSize(14.8), sortable: true, align: 'left', hide: false},
                                                            {display: 'Provincia', name: 'DES_PROVINCIA', width: GetColumnSize(18), sortable: true, align: 'left', hide: false},
                                                            {display: 'Distrito', name: 'DES_DISTRITO', width: GetColumnSize(23), sortable: true, align: 'left', hide: false},
                                                            {display: 'Longitud', name: 'GEO_LONGITUD', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Latitud', name: 'GEO_LATITUD', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
                                                                            /*<?php //if( $pAuxiliar=='Anidado' ) {      ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'},   <?php //}      ?>   */
                                                                            {display: 'Seleccionar', name: 'Seleccionar', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo ( $VerSeleccion == 'SI' ? 'false' : 'true'); ?>  },
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo ( $VerSeleccion == 'SI' ? 'true' : 'false'); ?>  },
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo ( $VerSeleccion == 'SI' || $crudEliminar=='true' ? 'true' : 'false'); ?>  }
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
                                                                            {display: 'Región', name: 'DES_DEPARTAMENTO'},
                                                                            {display: 'Provincia', name: 'DES_PROVINCIA'},
                                                                            {display: 'Distrito', name: 'DES_DISTRITO'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php //visTabla_DatosPadre($DatosPadre);      ?>'    <?php } ?>
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


    $COD_UBIGEO = $lCollection->Get('COD_UBIGEO');
    $NUM_NIVEL = $lCollection->Get('NUM_NIVEL');
    $COD_UBIGEO_SUP = $lCollection->Get('COD_UBIGEO_SUP');
    $DES_DEPARTAMENTO = $lCollection->Get('DES_DEPARTAMENTO');
    $DES_PROVINCIA = $lCollection->Get('DES_PROVINCIA');
    $DES_DISTRITO = $lCollection->Get('DES_DISTRITO');
    $GEO_LONGITUD = $lCollection->Get('GEO_LONGITUD');
    $GEO_LATITUD = $lCollection->Get('GEO_LATITUD');
    $EST_UBIGEO = $lCollection->Get('EST_UBIGEO');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');

    /* para la herencia */
    //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta

    /* para la visualizacion de busqueda */
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    /* para el padre buscado */
    //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    $BIDE = $Bdescripcion = $BGEO_LONGITUD = $BGEO_LATITUD = "";
    if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
        $BIDE = $lCollection->Get('BIDE');
        ;
        $Bdescripcion = $lCollection->Get('Bdescripcion');
        $BGEO_LONGITUD = $lCollection->Get('BGEO_LONGITUD');
        $BGEO_LATITUD = $lCollection->Get('BGEO_LATITUD');
    }
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar UBIGEO: Ubicación Geografica Distrital"; //Nombre de la Tabla
        $Leer['COD_UBIGEO'] = ' readonly ';
        $Leer['NUM_NIVEL'] = ' style="display:none" ';
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de UBIGEO: Ubicación Geografica Distrital"; //Nombre de la Tabla
        $Leer['COD_UBIGEO'] = '';
        $Leer['NUM_NIVEL'] = '';
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
            var tipo = f.varBotonInvocador.value;
            switch(tipo) {  // alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;      ?>');
                case 'Coordenada':         
                    f.COD_UBIGEO.value = '<?php echo $BIDE; ?>';
                    f.UBIGEO.value = '<?php echo $Bdescripcion; ?>';
                    f.GEO_LONGITUD_UBICACION.value = '<?php echo $BGEO_LONGITUD; ?>';
                    f.GEO_LATITUD_UBICACION.value = '<?php echo $BGEO_LATITUD; ?>';
                    break;
                default :  
                    f.COD_UBIGEO.value = '<?php echo $BIDE; ?>';
                    f.UBIGEO.value = '<?php echo $Bdescripcion; ?>';
                    break;
            }
            parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
                            CompruebaPaseDatos();
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
            //echo Tabla_Proyecto_Datos($PIDE_PROYECTO) . '<hr>' . Tabla_Contrato_Datos($VIDE_CONTRATO) . Tabla_Intervencion_Datos($PINTERVENCION);  
            //echo '<br>'; 
        }
        ?>
        <!--/*EDGAR*/-->

        <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );   ?>




        <div class="control-group">
            <label class="control-label" for="COD_UBIGEO">UBIGEO: <span class="error">*</span></label>
            <div class="controls">
                <input <?php echo $Leer['COD_UBIGEO']; ?>  name="COD_UBIGEO" id="COD_UBIGEO" value="<?php echo $COD_UBIGEO; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese el código de Ubicación Geográfica" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group" <?php echo $Leer['NUM_NIVEL']; ?> >
            <label class="control-label" for="NUM_NIVEL">Nivel:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboNUM_NIVEL('NUM_NIVEL', $DataSet_GEN_TABLAS_1, $NUM_NIVEL, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="COD_UBIGEO_SUP">UBIGEO Superior: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_UBIGEO_SUP" id="COD_UBIGEO_SUP" value="<?php echo $COD_UBIGEO_SUP; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese el Código de UBIGEO superior" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_DEPARTAMENTO">Región: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_DEPARTAMENTO" id="DES_DEPARTAMENTO" value="<?php echo $DES_DEPARTAMENTO; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Región"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_PROVINCIA">Provincia: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_PROVINCIA" id="DES_PROVINCIA" value="<?php echo $DES_PROVINCIA; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Provincia"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_DISTRITO">Distrito: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_DISTRITO" id="DES_DISTRITO" value="<?php echo $DES_DISTRITO; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Distrito"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="GEO_LONGITUD">Longitud Geográfica: <span class="error">*</span></label>
            <div class="controls">
                <input  name="GEO_LONGITUD" id="GEO_LONGITUD" value="<?php echo $GEO_LONGITUD; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la logitud geográfica" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="GEO_LATITUD">Latitud Geográfica: <span class="error">*</span></label>
            <div class="controls">
                <input  name="GEO_LATITUD" id="GEO_LATITUD" value="<?php echo $GEO_LATITUD; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese la latitud geográfica" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_UBIGEO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_UBIGEO('EST_UBIGEO', $DataSet_GEN_TABLAS_2, $EST_UBIGEO, 1, "") ?>				
            </div>
        </div>  						


 

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboNUM_NIVEL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el nivel 1) para Departamento, 2) para Provincia, 3) para Distrito" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_UBIGEO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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