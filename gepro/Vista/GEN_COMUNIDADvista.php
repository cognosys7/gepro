<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_COMUNIDADVISTA de la tabla GEN_COMUNIDAD
  //  Fecha           : sábado, 18 de mayo de 2019 23:54:06
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-GEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_COMUNIDAD.js"></script>    


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
                    //$DatosPadre  =   array(
                    //      'Tabla'           =>  $lCollection->Get('VDES_ITEM'),
                    //      'Abreviatura'     =>  $lCollection->Get('VDES_ABREVIATURA')
                    //  );
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    /* EDGAR */

                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido') == 'Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if (strlen($Pedido) > 0) {
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI';
                    } else {
                        $Pedido = 'Mantenimiento';
                    }
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
                                <li><a href="#tabs-1">Listado de Comunidad / Centro Poblado </a></li>
                                <li><a href="#tabs-2">Detalle de Comunidad / Centro Poblado </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <!--<input type="hidden" name="ActionForm" value="">-->                                
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
                                            Seleccione un registro para editar  <?php echo ' - '.$Pedido ; ?>
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&Pedido=<?php echo $Pedido; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'UBIGEO', name: 'COD_UBIGEO', width: GetColumnSize(5), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Departamento', name: 'DES_DEPARTAMENTO', width: GetColumnSize(12), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Provincia', name: 'DES_PROVINCIA', width: GetColumnSize(14), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Distrito', name: 'DES_DISTRITO', width: GetColumnSize(16), sortable: true, align: 'center', hide: false},
        //                                                                    {display: 'Ubicación Geográfica', name: 'DES_UBIGEO', width: GetColumnSize(30), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Comunidad / Centro Poblado', name: 'DES_COMUNIDAD', width: GetColumnSize(33.2), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'File', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

<?php if( $VerSeleccion == 'SI' ) {   ?>                            {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'}  
<?php }else {   ?>                                                  {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
<?php }   ?>
                                                                    ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
<?php if( $VerSeleccion <> 'SI' ) {   ?>                            {name: 'Nuevo', bclass: 'nuevo', onpress: test},    <?php }   ?>
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'UBIGEO', name: 'COD_UBIGEO'},
                                                                    {display: 'Departamento', name: 'DES_DEPARTAMENTO'},
                                                                    {display: 'Provincia', name: 'DES_PROVINCIA'},
                                                                    {display: 'Distrito', name: 'DES_DISTRITO'},
        //                                                                    {display: 'Ubicación Geográfica', name: 'DES_UBIGEO'},
                                                                    {display: 'Comunidad / Centro Poblado', name: 'DES_COMUNIDAD'},
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
                                                                        /*<?php //if( $PIDE>0 ) {     ?>                ,title: '<?php //visTabla_DatosPadre($DatosPadre);   ?>'    <?php //}     ?> */
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


    $IDE_COMUNIDAD = $lCollection->Get('IDE_COMUNIDAD');
    $COD_UBIGEO = $lCollection->Get('COD_UBIGEO');
    $DES_COMUNIDAD = $lCollection->Get('DES_COMUNIDAD');
    $EST_COMUNIDAD = $lCollection->Get('EST_COMUNIDAD');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    //$DatosPadre  =   array(
    //   'Tabla'           =>  $lCollection->Get('VDES_ITEM'),
    //   'Abreviatura'     =>  $lCollection->Get('VDES_ABREVIATURA')
    //   ,'VCOD_TABLA'     =>  $lCollection->Get('VCOD_TABLA')
    //  );
    $DES_UBIGEO = $lCollection->Get('DES_UBIGEO'); //codigo superior autocompleta
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;
    
    /////////// para la busqueda
    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
    $BIDE = $Bdescripcion = "";
    if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
        $BIDE = $lCollection->Get('BIDE');;
        $Bdescripcion = $lCollection->Get('Bdescripcion');
    }

    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Comunidad / Centro Poblado"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Comunidad / Centro Poblado"; //Nombre de la Tabla
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
        
        
        function CompruebaPaseDatos()
        {            
            var f = parent.document.formulario;            
//            alert('por a intervenciones'+'<?php // echo $BIDE.'-<br>'.$Bdescripcion ;?>');
            f.IDE_COMUNIDAD.value = '<?php echo $BIDE; ?>';
            f.B_COMUNIDAD.value = '<?php echo $Bdescripcion; ?>';
            
            parent.$.colorbox.close();            
        }
        
<?php   if ($PIDEbuscado>0)  {  ?>
            CompruebaPaseDatos();
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
        <?php //visTabla_DatosPadre($DatosPadre);  ?>
        <!--/*EDGAR*/-->




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_COMUNIDAD">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_COMUNIDAD" id="IDE_COMUNIDAD" value="<?php echo $IDE_COMUNIDAD; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		

        <!--
                <div class="control-group">
                    <label class="control-label" for="COD_UBIGEO">UBIGEO: <span class="error"></span></label>
                    <div class="controls">
                        <input  name="COD_UBIGEO" id="COD_UBIGEO" value="<?php // echo $COD_UBIGEO;  ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione UBIGEO"/>					
                    </div>
                </div>								-->

        <?php extraerIDEyValor_Text("COD_UBIGEO", $COD_UBIGEO, 'ESTANDAR', 'UBIGEO', 'UBIGEO', $DES_UBIGEO, 'UBIGEO', 'width: 50%;' ); ?>
        <input type="hidden" name="GEO_LONGITUD_UBICACION" value="">
        <input type="hidden" name="GEO_LATITUD_UBICACION" value="">
        

        <div class="control-group">
            <label class="control-label" for="DES_COMUNIDAD">Comunidad - CC.PP. : <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_COMUNIDAD" id="DES_COMUNIDAD" value="<?php echo $DES_COMUNIDAD; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Comunidad / Centro Poblado"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_COMUNIDAD">Estado:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboEST_COMUNIDAD('EST_COMUNIDAD', $DataSet_GEN_TABLAS_1, $EST_COMUNIDAD, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_COMUNIDAD($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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