<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PIPVISTA de la tabla GEN_PIP
  //  Fecha           : lunes, 24 de septiembre de 2018 10:38:34
  //  Desde el Modelo : PDM - AMSAC
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_PIP.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>


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
                    
/***EDGAR---**************/                    
//                    $FormularioTipo = '';
                    $FormularioAccion = $FormularioTipo2 = '';
                    $VerSeleccion = 'NO';
                    
                    $Pedido = $lCollection->Get('Pedido');
                    if( strlen($Pedido)>0 ){
//                        $FormularioTipo = $Pedido;
                        $FormularioAccion = 'PasarDatos';
                        $VerSeleccion = 'SI' ;
                    } else { $FormularioTipo2='Mantenimiento'; 
//                        $VerSeleccion = false ;
                    }
                    
/***EDGAR---**************/
                    ?>
                    <div class="box-content">

                        <div id="tabs">
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                            <ul>
                                <li><a href="#tabs-1">Listado de Proyectos de Inversión Pública</a></li>
                                <li><a href="#tabs-2">Detalle del Proyecto de Inversión Pública</a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
<!--/***EDGAR---**************/-->
                                    <!--<input type="hidden" name="ActionForm" value="">-->
                                    <input type="hidden" name="ActionForm" value="<?php echo $FormularioAccion; ?>">
                                    <input type="hidden" name="PIDE_PIP" value="">
<!--/***EDGAR---**************/-->                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            <span style="color: #990000; font-weight:bold;">La Lista es Actualizada por DTIC.</span>
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&Pedido=<?php echo $Pedido; ?>', /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Código SNIP', name: 'CodigoSNIP', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Código Unico', name: 'CodigoUnico', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
//                                                                    {display: 'Código Proyecto', name: 'CodigoProyecto', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Descripción Proyecto', name: 'DescripcionProyecto', width: GetColumnSize(58.9), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Monto Viable', name: 'MontoViable', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'Estado', width: GetColumnSize(11), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true}
/***EDGAR---**************/  
<?php   if ($VerSeleccion=='NO')   {  ?>                            ,{display: 'Ver', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'}         <?php   }   ?>
//                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
                                         
<?php   if ($VerSeleccion=='SI')   {  ?>                            ,{display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(8), sortable: false, align: 'center' }   <?php   }   ?>
/***EDGAR---**************/
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                   // {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    
                                                                    {display: 'Código Unico', name: 'CodigoUnico'},
//                                                                    {display: 'Código Proyecto', name: 'CodigoProyecto'},
                                                                    {display: 'Código SNIP', name: 'CodigoSNIP'},
                                                                    {display: 'Descripción Proyecto', name: 'DescripcionProyecto'}
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


                $IDE_PIP = $lCollection->Get('IDE_PIP');
                $COD_SNIP = $lCollection->Get('COD_SNIP');
                $COD_UNICO = $lCollection->Get('COD_UNICO');
                $COD_PROYECTO = $lCollection->Get('COD_PROYECTO');
                $DES_PIP = $lCollection->Get('DES_PIP');
                $FEC_REGISTRO = $lCollection->Get('FEC_REGISTRO');
                $FEC_VIABILIDAD = $lCollection->Get('FEC_VIABILIDAD');
                $IMP_MONTO_VIABLE = $lCollection->Get('IMP_MONTO_VIABLE');
                $DES_FUNCION = $lCollection->Get('DES_FUNCION');
                $DES_PROGRAMA = $lCollection->Get('DES_PROGRAMA');
                $DES_SUBPROGRAMA = $lCollection->Get('DES_SUBPROGRAMA');
                $DES_NIVEL = $lCollection->Get('DES_NIVEL');
                $DES_SECTOR = $lCollection->Get('DES_SECTOR');
                $DES_PLIEGO = $lCollection->Get('DES_PLIEGO');
                $DES_UNIDAD_EJECUTORA = $lCollection->Get('DES_UNIDAD_EJECUTORA');
                $DES_RESPONSABLE_VIABLE = $lCollection->Get('DES_RESPONSABLE_VIABLE');
                $IMP_MONTO_F15 = $lCollection->Get('IMP_MONTO_F15');
                $IMP_MONTO_F16 = $lCollection->Get('IMP_MONTO_F16');
                $IMP_COSTO_ACTUALIZADO = $lCollection->Get('IMP_COSTO_ACTUALIZADO');
                $NUM_BENEFICIARIOS = $lCollection->Get('NUM_BENEFICIARIOS');
                $EST_INVIERTE = $lCollection->Get('EST_INVIERTE');
                $TIP_PIP = $lCollection->Get('TIP_PIP');
                $TIP_PIP_CODIGO = $lCollection->Get('TIP_PIP_CODIGO');
                $EST_PIP = $lCollection->Get('EST_PIP');
                $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


                $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');


/* EDGAR */
                $VIDE_PIP = $lCollection->Get('VIDE_PIP');
                $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                $VDES_PIP = $lCollection->Get('VDES_PIP');
                $VIMP_MONTO_VIABLE = $lCollection->Get('VIMP_MONTO_VIABLE');
                $VCOD_SNIP = $lCollection->Get('VCOD_SNIP');
                $VCOD_UNICO = $lCollection->Get('VCOD_UNICO');
                $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                
                $SNIP_visible = ' style="display:none" ';
                $Grabar_visible = '';
                $cboReadonly = cboReadonly();
/* EDGAR */

                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = SPRING_msgDatosActualizados(); //Nombre de la Tabla
/* EDGAR */
                    if ( $EST_PIP<>'1' ) { $Grabar_visible = '1' ; }
                    if ( $EST_PIP=='1'  ||  $EST_PIP=='3') { $SNIP_visible = ''; }
/* EDGAR */
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de "; //Nombre de la Tabla
                    $Grabar_visible = '1' ;
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


            $('#FEC_REGISTRO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_VIABILIDAD').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FECHA_INSERT').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FECHA_UPDATE').datepicker({
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
            var tipo = f.varBotonInvocador.value;
            
/***EDGAR---************** DFFINE DATOS ****/        
            switch(tipo) {
                case 'PlanSoliProy_COD_PIP2': 
                    f.IDE_PIP.value = '<?php echo $VIDE_PIP;?>';
                    f.PlanSoliProy_COD_PIP2.value = '<?php echo $VCOD_PROYECTO;?>';
                    f.PlanSolicitudProyecto_DES_PIP.value = '<?php echo $VDES_PIP;?>';
                    f.IMP_MONTO_SNIP.value = '<?php echo $VIMP_MONTO_VIABLE;?>';
                    break;
                case 'PROY_PIP':
//                    alert('VIDE_PIP: <?php // echo $VIDE_PIP;?>' + ' - COD_UNICO:<?php // echo $VCOD_UNICO;?>')
                    f.IDE_PIP.value = '<?php echo $VIDE_PIP;?>';
                    f.B_PIP.value = '<?php echo $VDES_PIP;?>';
                    f.COD_SNIP.value = '<?php echo $VCOD_SNIP;?>';
                    f.COD_UNICO.value = '<?php echo $VCOD_UNICO;?>';
                    break;
                    
            }
/***EDGAR---**************/ 
            parent.$.colorbox.close();            
        }
        
<?php   if ((strlen($VCOD_PROYECTO) > 0) and ($VCOD_PROYECTO <> ""))    {  ?>
            CompruebaPaseDatos();
<?php   }   ?>

    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  





        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PIP">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PIP" id="IDE_PIP" value="<?php echo $IDE_PIP; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		

        
        
        
        
        <div class="control-group" style="display:none">
            <label class="control-label" for="TIP_PIP">Tipo de Proyecto:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_PIP('TIP_PIP', $DataSet_GEN_TABLAS_2, $TIP_PIP, 1, " style='width: 51%; background-color:#f5f5f5; ' ".$cboReadonly ) ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none" >
            <label class="control-label" for="TIP_PIP_CODIGO">Subtipo de Proyecto:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_PIP_CODIGO('TIP_PIP_CODIGO', $DataSet_GEN_TABLAS_3, $TIP_PIP_CODIGO, 1, $cboReadonly ) ?>				
            </div>
        </div> 
        
        
        
        

        <div class="control-group" <?php echo $SNIP_visible; ?> >
            <label class="control-label" for="COD_SNIP">Código SNIP: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="COD_SNIP" id="COD_SNIP" value="<?php echo $COD_SNIP; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código SNIP"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none" >
            <label class="control-label" for="COD_UNICO">Código Unico: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="COD_UNICO" id="COD_UNICO" value="<?php echo $COD_UNICO; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Unico"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_PROYECTO">Código Proyecto: <span class="error">*</span></label>
            <div class="controls">
                <input readonly  name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $COD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Código Proyecto"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_PIP">Denominación de Proyecto: <span class="error">*</span></label>
            <div class="controls">
                <textarea readonly name="DES_PIP" id="DES_PIP" rows="5" onChange="conMayusculas(this)" maxlength="500" class="xlarge required show-popover"  data-trigger="hover" data-content="Ingrese Denominación de Proyecto" ><?php echo $DES_PIP; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_REGISTRO">Fecha de Registro:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input readonly name="FEC_REGISTRO" id="FEC_REGISTRO" style="width: 10%" value="<?php echo $FEC_REGISTRO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Fecha de Regisro" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_VIABILIDAD">Fecha de Viabilidad:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input readonly name="FEC_VIABILIDAD" id="FEC_VIABILIDAD" style="width: 10%" value="<?php echo $FEC_VIABILIDAD; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Fecha de Viabilidad" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="IMP_MONTO_VIABLE">Monto Viable: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_MONTO_VIABLE" id="IMP_MONTO_VIABLE" value="<?php echo $IMP_MONTO_VIABLE; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Viable"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_FUNCION">Función: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_FUNCION" id="DES_FUNCION" value="<?php echo $DES_FUNCION; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Función"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_PROGRAMA">Progama: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_PROGRAMA" id="DES_PROGRAMA" value="<?php echo $DES_PROGRAMA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Progama"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_SUBPROGRAMA">Sub-Programa: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_SUBPROGRAMA" id="DES_SUBPROGRAMA" value="<?php echo $DES_SUBPROGRAMA; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Sub-Programa"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_NIVEL">Nivel: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_NIVEL" id="DES_NIVEL" value="<?php echo $DES_NIVEL; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Nivel"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_SECTOR">Sector: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_SECTOR" id="DES_SECTOR" value="<?php echo $DES_SECTOR; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Sector"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_PLIEGO">Pliego: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_PLIEGO" id="DES_PLIEGO" value="<?php echo $DES_PLIEGO; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Pliego"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_UNIDAD_EJECUTORA">Unidad Ejecutora: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_UNIDAD_EJECUTORA" id="DES_UNIDAD_EJECUTORA" value="<?php echo $DES_UNIDAD_EJECUTORA; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Unidad Ejecutora"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_RESPONSABLE_VIABLE">Responsable de Viabilidad: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="DES_RESPONSABLE_VIABLE" id="DES_RESPONSABLE_VIABLE" value="<?php echo $DES_RESPONSABLE_VIABLE; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Responsable de Viabilidad"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_MONTO_F15">Monto F15: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_MONTO_F15" id="IMP_MONTO_F15" value="<?php echo $IMP_MONTO_F15; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto F15"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_MONTO_F16">Monto F16: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_MONTO_F16" id="IMP_MONTO_F16" value="<?php echo $IMP_MONTO_F16; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto F16"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_COSTO_ACTUALIZADO">Costo Actualizado: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="IMP_COSTO_ACTUALIZADO" id="IMP_COSTO_ACTUALIZADO" value="<?php echo $IMP_COSTO_ACTUALIZADO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Costo Actualizado"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="NUM_BENEFICIARIOS">Número de Beneficiarios: <span class="error"></span></label>
            <div class="controls">
                <input readonly  name="NUM_BENEFICIARIOS" id="NUM_BENEFICIARIOS" value="<?php echo $NUM_BENEFICIARIOS; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Número de Beneficiarios"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_INVIERTE">Estado de Invierte:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboEST_INVIERTE('EST_INVIERTE', $DataSet_GEN_TABLAS_1, $EST_INVIERTE, 1, $cboReadonly ) ?>				
            </div>
        </div>  						

 						


        <div class="control-group"  style="display:none" >
            <label class="control-label" for="EST_PIP">Estado de Proyecto:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_PIP('EST_PIP', $DataSet_GEN_TABLAS_4, $EST_PIP, 1, $cboReadonly ) ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none" >
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="5" onChange="conMayusculas(this)" maxlength="2000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Observación" ><?php echo $DES_OBSERVACION; ?></textarea>				
            </div>
        </div>						














        <div class="form-actions">
            <!--<input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php // echo $Btn; ?>">-->
<?php if($Grabar_visible=='1') { ?> <!--<input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>"--> > <?php } //si funciona solo esta comentado ?>
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_INVIERTE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado de Invierte" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

    function comboTIP_PIP($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo de Proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_PIP_CODIGO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Subtipo de Proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_PIP($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado de Proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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