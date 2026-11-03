<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : CONTRATOVISTA de la tabla CONTRATO
  //  Fecha           : miércoles, 8 de mayo de 2019 13:16:39
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/CONTRATO.js"></script>    


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
                    $PIDE2 = $lCollection->Get('PIDE2');
                    //$pAuxiliar = $lCollection->Get('pAuxiliar');
                    //// pedido es para escoger el tipo de grilla
                    $FormularioAccion = $FormularioTipo2 = $VerSeleccion = '';
                    $Pedido = ( $lCollection->Get('Pedido')=='Busqueda' ? $lCollection->Get('Pedido') : '' );
                    if( strlen($Pedido)>0 ){
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI' ;
                    } else { 
                        $Pedido='Mantenimiento'; 
                    }
                    
                    $crudEliminar = $lCollection->Get('crudEliminar');
                    /* EDGAR */ //                          'Tabla'           =>  $lCollection->Get('VDES_ITEM'),
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
                                <li><a href="#tabs-1">Listado de Contratos </a></li>
                                <li><a href="#tabs-2">Detalle de Contratos </a></li>
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
                                    <input type="hidden" name="PIDE2" value="<?php echo $PIDE2; ?>">
                                    <input type="hidden" name="PIDEbuscado" value="">
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                    <!--/*EDGAR*/-->

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar <?php echo ' - '.$Pedido ; ?>. <?php echo SPRING_msgListaActualizada('AdicionarRegistro') ; ?>
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&PIDE2=<?php echo $PIDE2; ?>&Pedido=<?php echo $Pedido; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Cod.Orden Det.', name: 'COD_UNICO_ORDEN', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cod.Contrato', name: 'COD_CONTRATO_ENTIDAD', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Contrato', name: 'DES_CONTRATO', width: GetColumnSize(20), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Proveedor', name: 'DES_PROVEEDOR', width: GetColumnSize(10.7), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Inicio', name: 'FEC_INICIO_CONTRATO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Término', name: 'FEC_TERMINO_CONTRATO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cierre', name: 'FEC_CIERRE_CONTRATO', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Monto Total (S/.)', name: 'IMP_TOTAL', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true}
                                                                    /*EDGAR*/
<?php   if ($VerSeleccion=='SI')   {  ?>                            ,{display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center', hide: false } 
                                                                    ,{display: 'Editar', name: 'Boton1', width: GetColumnSize(5), sortable: false, align: 'center'}
                                                                    ,{display: 'Eliminar', name: 'Boton2', width: GetColumnSize(5), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?>  }
<?php   }  else { ?>                                                       
                                                                    ,{display: 'Carta Fianza', name: 'Boton4', width: GetColumnSize(6), sortable: false, align: 'center'}
                                                                    ,{display: 'Gastos', name: 'GastoConsolidado', width: GetColumnSize(5), sortable: false, align: 'center'}
                                                                    ,{display: 'Archivo', name: 'Boton5', width: GetColumnSize(5), sortable: false, align: 'center'}
                                                                    ,{display: 'Editar', name: 'Boton1', width: GetColumnSize(5), sortable: false, align: 'center'}
                                                                    ,{display: 'Eliminar', name: 'Boton2', width: GetColumnSize(5), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?>  }
<?php   }  ?>                                                   
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
         <?php // if ($VerSeleccion <> 'SI') { 
        if ( $PIDE == 0 ) { ?>                                {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php  } //} ?>
                                                                    
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Cod.Contrato', name: 'COD_CONTRATO_ENTIDAD'},
                                                                    {display: 'Cod.Orden Det.', name: 'COD_UNICO_ORDEN'},
                                                                    {display: 'Contrato', name: 'DES_CONTRATO'},
                                                                    {display: 'Proveedor', name: 'DES_PROVEEDOR'},
                                                                    {display: 'Inicio', name: 'FEC_INICIO_CONTRATO'},
                                                                    {display: 'Término', name: 'FEC_TERMINO_CONTRATO'},
                                                                    {display: 'Cierre', name: 'FEC_CIERRE_CONTRATO'}
                                                                    
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
<?php if( $PIDE>0 ) {    ?>                ,title: '<?php echo Tabla_Proyecto_Datos($PIDE2);  ?>'    <?php }    ?> 
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


    $IDE_CONTRATO = $lCollection->Get('IDE_CONTRATO');
    $IDE_PROVEEDOR = $lCollection->Get('IDE_PROVEEDOR');
    $IDE_ADM_CONTRATO = $lCollection->Get('IDE_ADM_CONTRATO');
    $COD_CONTRATO = $lCollection->Get('COD_CONTRATO');
    $COD_CONTRATO_ENTIDAD = $lCollection->Get('COD_CONTRATO_ENTIDAD');
    $COD_CONTRATO_SUP = $lCollection->Get('COD_CONTRATO_SUP');
    $DES_CONTRATO = $lCollection->Get('DES_CONTRATO');
    $TIP_CONTRATO = $lCollection->Get('TIP_CONTRATO');
    $FEC_CONTRATO = $lCollection->Get('FEC_CONTRATO');
    $FEC_INICIO_CONTRATO = $lCollection->Get('FEC_INICIO_CONTRATO');
    $FEC_TERMINO_CONTRATO = $lCollection->Get('FEC_TERMINO_CONTRATO');
    $FEC_CIERRE_CONTRATO = $lCollection->Get('FEC_CIERRE_CONTRATO');
    $IMP_IMPONIBLE = $lCollection->Get('IMP_IMPONIBLE');
    $IMP_IMPUESTOS = $lCollection->Get('IMP_IMPUESTOS');
    $IMP_TOTAL = $lCollection->Get('IMP_TOTAL');
    $IMG_CONTRATO = $lCollection->Get('IMG_CONTRATO');
    $DES_COMENTARIO = $lCollection->Get('DES_COMENTARIO');
    $EST_CONTRATO = $lCollection->Get('EST_CONTRATO');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $PIDE2 = $lCollection->Get('PIDE2');
    //$COD_TABLA = $lCollection->Get('VCOD_TABLA'); //codigo superior autocompleta
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_PROVEEDOR_1 = $lCollection->Get('DataSet_GEN_PROVEEDOR_1');


    $DataSet_GEN_RECURSO_1 = $lCollection->Get('DataSet_GEN_RECURSO_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');



    /*EDGAR*/
    $VIDE_CONTRATO=0;
    $VCOD_UNICO_ORDEN = $VCOD_CONTRATO_ENTIDAD = $VDES_CONTRATO = $VIMP_TOTAL = $VEST_CONTRATO = "";
    if($lCollection->Get('PIDEbuscado')>1) {    
        $VIDE_CONTRATO=$lCollection->Get('VIDE_CONTRATO');
        $VCOD_UNICO_ORDEN=$lCollection->Get('VCOD_UNICO_ORDEN');
        $VCOD_CONTRATO_ENTIDAD=$lCollection->Get('VCOD_CONTRATO_ENTIDAD');
        $VDES_CONTRATO=$lCollection->Get('VDES_CONTRATO');
        $VIMP_TOTAL=$lCollection->Get('VIMP_TOTAL');
        $VEST_CONTRATO=$lCollection->Get('VEST_CONTRATO');
    }

    
    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        if ( $EST_CONTRATO==98 ) {
            $Control_Bloqueo = Control_Bloqueo_CONT('');
        } else {
            $Control_Bloqueo = Control_Bloqueo_CONT('SPRING1');
        }
        
    } else {
        //INSERT
        $Control_Bloqueo = Control_Bloqueo_CONT('');
        $EST_CONTRATO = 98 ;
    }
    /*EDGAR*/    
    

    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Contratos". SPRING_msgDatosActualizados('AdicionarRegistro') ; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Contratos". SPRING_msgDatosActualizados('AdicionarRegistro'); //Nombre de la Tabla
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


            $('#FEC_CONTRATO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_INICIO_CONTRATO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO_CONTRATO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_CIERRE_CONTRATO').datepicker({
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
        
        
        
        function CompruebaPaseDatos()
        {            
            var f = parent.document.formulario;            
//            alert('por a intervenciones'+'<?php // echo $VCOD_UNICO_ORDEN.'-<br>'.$VDES_CONTRATO ;?>');
            f.IDE_CONTRATO.value = '<?php echo $VIDE_CONTRATO;?>';
            f.COD_PROYECTO.value = '<?php echo $VCOD_UNICO_ORDEN;?>';
            f.DES_PROYECTO.value = '<?php echo $VDES_CONTRATO;?>';
            f.IMP_COSTO_ACTUAL.value = '<?php echo $VIMP_TOTAL;?>';
            f.IMP_TRANSFERIDO.value = '<?php echo $VIDE_CONTRATO;?>';
            f.EST_PROYECTO_ACTIVIDAD.value = '<?php echo $VEST_CONTRATO;?>';
            
            parent.$.colorbox.close();            
        }
        
<?php   if ($VIDE_CONTRATO>0)  {  ?>
            CompruebaPaseDatos();
<?php   }   ?>

    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>"> 
        <input type="hidden" name="PIDE2" value="<?php echo $PIDE2 ?>"> 
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
<?php if( $PIDE>0 ) {    echo Tabla_Proyecto_Datos($PIDE2); } ?>
        <!--/*EDGAR*/-->

		<br>


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONTRATO">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONTRATO" id="IDE_CONTRATO" value="<?php echo $IDE_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group">
            <label class="control-label" for="IDE_PROVEEDOR">Proveedor:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboIDE_PROVEEDOR('IDE_PROVEEDOR', $DataSet_GEN_PROVEEDOR_1, $IDE_PROVEEDOR, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group"  style="display:none">
            <label class="control-label" for="IDE_ADM_CONTRATO">Responsable:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIDE_ADM_CONTRATO('IDE_ADM_CONTRATO', $DataSet_GEN_RECURSO_1, $IDE_ADM_CONTRATO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="COD_CONTRATO">Número Contrato: <span class="error"></span></label>
            <div class="controls">
                <input <?php echo $Control_Bloqueo['COD_CONTRATO'] ; ?>  name="COD_CONTRATO" id="COD_CONTRATO" value="<?php echo $COD_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric  show-popover" data-trigger="hover" data-content="Ingrese Número Contrato" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_CONTRATO_ENTIDAD">Documento Interno: <span class="error"></span></label>
            <div class="controls">
                <input <?php echo $Control_Bloqueo['COD_CONTRATO_ENTIDAD'] ; ?>  name="COD_CONTRATO_ENTIDAD" id="COD_CONTRATO_ENTIDAD" value="<?php echo $COD_CONTRATO_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class=" show-popover" data-trigger="hover" data-content="Ingrese Documento Interno" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="COD_CONTRATO_SUP">Contrato Anterior: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_CONTRATO_SUP" id="COD_CONTRATO_SUP" value="<?php echo $COD_CONTRATO_SUP; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Contrato Anterior" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_CONTRATO">Definición: <span class="error"></span></label>
            <div class="controls">
                <textarea <?php echo $Control_Bloqueo['DES_CONTRATO'] ; ?> name="DES_CONTRATO" id="DES_CONTRATO" rows="3" onChange="conMayusculas(this)" maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Definición" ><?php echo $DES_CONTRATO; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="TIP_CONTRATO">Tipo:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_CONTRATO('TIP_CONTRATO', $DataSet_GEN_TABLAS_1, $TIP_CONTRATO, 1, $Control_Bloqueo['TIP_CONTRATO'] ) ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="FEC_CONTRATO">Fecha Contrato:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input <?php echo $Control_Bloqueo['FEC_CONTRATO'] ; ?> name="FEC_CONTRATO" id="FEC_CONTRATO" style="width: 10%" value="<?php echo $FEC_CONTRATO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Contrato" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group" style="display:none">
            <label class="control-label" for="FEC_INICIO_CONTRATO">Inicio Contrato:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input <?php echo $Control_Bloqueo['FEC_INICIO_CONTRATO'] ; ?> name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" style="width: 10%" value="<?php echo $FEC_INICIO_CONTRATO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Inicio Contrato" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group" style="display:none">
            <label class="control-label" for="FEC_TERMINO_CONTRATO">Término Contrato:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input <?php echo $Control_Bloqueo['FEC_TERMINO_CONTRATO'] ; ?> name="FEC_TERMINO_CONTRATO" id="FEC_TERMINO_CONTRATO" style="width: 10%" value="<?php echo $FEC_TERMINO_CONTRATO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Término Contrato" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group" style="display:none">
            <label class="control-label" for="FEC_CIERRE_CONTRATO">Cierre Contrato:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input <?php echo $Control_Bloqueo['FEC_CIERRE_CONTRATO'] ; ?> name="FEC_CIERRE_CONTRATO" id="FEC_CIERRE_CONTRATO" style="width: 10%" value="<?php echo $FEC_CIERRE_CONTRATO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Cierre Contrato" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="IMP_IMPONIBLE">Monto Imponible: <span class="error"></span></label>
            <div class="controls">
                <input <?php echo $Control_Bloqueo['IMP_IMPONIBLE'] ; ?>  name="IMP_IMPONIBLE" id="IMP_IMPONIBLE" value="<?php echo $IMP_IMPONIBLE; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Imponible" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_IMPUESTOS">Monto Impuesto: <span class="error"></span></label>
            <div class="controls">
                <input <?php echo $Control_Bloqueo['IMP_IMPUESTOS'] ; ?>  name="IMP_IMPUESTOS" id="IMP_IMPUESTOS" value="<?php echo $IMP_IMPUESTOS; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Impuesto" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_TOTAL">Monto Total: <span class="error"></span></label>
            <div class="controls">
                <input <?php echo $Control_Bloqueo['IMP_TOTAL'] ; ?>  name="IMP_TOTAL" id="IMP_TOTAL" value="<?php echo $IMP_TOTAL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Total" style='width:14.5%;' />					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="IMG_CONTRATO">Archivo Contrato: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMG_CONTRATO" id="IMG_CONTRATO" value="<?php echo $IMG_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="1000" type="text" class=" show-popover" data-trigger="hover" data-content="Ingrese Archivo Contrato"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="DES_COMENTARIO">Comentario: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_COMENTARIO" id="DES_COMENTARIO" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Comentario" ><?php echo $DES_COMENTARIO; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_CONTRATO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_CONTRATO('EST_CONTRATO', $DataSet_GEN_TABLAS_2, $EST_CONTRATO, 1, $Control_Bloqueo['EST_CONTRATO'] ) ?>				
            </div>
        </div>  						


 

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_PROVEEDOR($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_PROVEEDOR > 0)) {
            if ($lstDatos[$i]->IDE_PROVEEDOR == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROVEEDOR . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PROVEEDOR . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROVEEDOR . "\">" . $lstDatos[$i]->DES_PROVEEDOR . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    function comboIDE_ADM_CONTRATO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_RECURSO > 0)) {
                if ($lstDatos[$i]->IDE_RECURSO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_RECURSO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_RECURSO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_RECURSO . "\">" . $lstDatos[$i]->DES_RECURSO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
        <?php
    }

    function comboTIP_CONTRATO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_CONTRATO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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