<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PLAN_GESTION_TRANS_PROYVISTA de la tabla PLAN_GESTION_TRANS_PROY
  //  Fecha           : lunes, 16 de julio de 2018 01:43:47 p.m.
  //  Desde el Modelo : PDM - AMSACEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PLAN_GESTION_TRANS_PROY.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

<!--/***EDGAR---**************/--> 
    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />
<!--/***EDGAR---**************/--> 

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
                    
/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION *****/                
                    $PIDE = $lCollection->Get('PIDE');
                    
                    $DatosPadre  =   array(
                        'Fecha Formulación'  =>  $lCollection->Get('VFEC_FORMULACION')
                        ,'Código Trámite'     =>  $lCollection->Get('VCOD_TRAMITE')
                        ,'Monto Total'       =>  $lCollection->Get('VIMP_TOTAL')
                        ,'Decreto Supremo'   =>  $lCollection->Get('VCOD_NORMATIVA')
                    );
/***EDGAR---**************/                     
                    
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
                                <li><a href="#tabs-1">LISTA DE PROYECTOS CON OPINION LEGAL, PARA FORMULACION DE DECRETOS SUPREMOS</a></li>
                                <li><a href="#tabs-2">DETALLE DE PROYECTOS CON OPINION LEGAL</a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

<!--/***EDGAR---**************/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
<!--/***EDGAR---**************/--> 
                                    
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
                                                                /*Pagina php donde se realiza la consulta sql */   													//url: 'mainpage.php?Pagina=<?php //echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList', /* Tipo de datos devuelto json, xml */
/***EDGAR---**************/
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>',
/***EDGAR---**************/
    
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Cód. Unico', name: 'CodUnico', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Descripción Proyecto', name: 'DescripcionProyecto', width: GetColumnSize(40), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Monto FFTO', name: 'MontoFFTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Hoja de Ruta', name: 'HojaRuta', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fec. Opinión Legal', name: 'FechaSeguimiento', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado Seguimiento', name: 'EstadoSeguimiento', width: GetColumnSize(13), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Cód. Unico', name: 'CodUnico'},
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

/***EDGAR---**************/
                                                                , title: '<?php  visTabla_DatosPadre($DatosPadre,10); ?>'
/***EDGAR---**************/
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


                $IDE_PLAN_GESTION_TRANS_PROY = $lCollection->Get('IDE_PLAN_GESTION_TRANS_PROY');
                $IDE_PLAN_GESTION_TRANS = $lCollection->Get('IDE_PLAN_GESTION_TRANS');
                $IDE_SOLICITUD_PROYECTO = $lCollection->Get('IDE_SOLICITUD_PROYECTO');
                $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
                $EST_PLAN_GESTION_TRANS_PROY = $lCollection->Get('EST_PLAN_GESTION_TRANS_PROY');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');

/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION ****/                  
                    $PIDE = $lCollection->Get('PIDE');
                    
                    $DatosPadre  =   array(
                        'Fecha Formulación'  =>  $lCollection->Get('VFEC_FORMULACION')
                        ,'Código Trámite'     =>  $lCollection->Get('VCOD_TRAMITE')
                        ,'Monto Total'       =>  $lCollection->Get('VIMP_TOTAL')
                        ,'Decreto Supremo'   =>  $lCollection->Get('VCOD_NORMATIVA')
                    );
                    
                    $IDE_PLAN_GESTION_TRANS = $PIDE ;
                    $PlanTransProy_ProyectoParaGestionTrans = $lCollection->Get('VCOD_UNICO');
/***EDGAR---**************/
                
                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar "; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de "; //Nombre de la Tabla
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
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

<!--/***EDGAR---******************/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
        <input type="text" name="varBotonInvocador" value="">
<!--/***EDGAR---******************/-->
        
        <legend><?php echo $TitulFormulario; ?></legend>  

<!--/***EDGAR---******************/--> 
        <?php visTabla_DatosPadre($DatosPadre,10); ?>
<!--/***EDGAR---**************/-->



        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PLAN_GESTION_TRANS_PROY">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PLAN_GESTION_TRANS_PROY" id="IDE_PLAN_GESTION_TRANS_PROY" value="<?php echo $IDE_PLAN_GESTION_TRANS_PROY; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PLAN_GESTION_TRANS">IdeGestionTransferencia: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_PLAN_GESTION_TRANS" id="IDE_PLAN_GESTION_TRANS" value="<?php echo $IDE_PLAN_GESTION_TRANS; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Seleccione Plan Gestión Transferencia"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_SOLICITUD_PROYECTO">IdeSolicitudProyecto: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_SOLICITUD_PROYECTO" id="IDE_SOLICITUD_PROYECTO" value="<?php echo $IDE_SOLICITUD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Seleccione Proyecto Solicitado"/>					
            </div>
        </div>								

<!--/***EDGAR---**************-->
        <?php visClaseBuscarYverText ('PlanTransProy_ProyectoParaGestionTrans' ,$PlanTransProy_ProyectoParaGestionTrans,'Proyecto para Gestión','ProyectoParaGestionTrans', ''); ?>
<!--/***EDGAR---**************-->



        <div class="control-group">
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="5" onChange="conMayusculas(this)" maxlength="2000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Observación" ><?php echo $DES_OBSERVACION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group" style="display:none">
            <label class="control-label" for="EST_PLAN_GESTION_TRANS_PROY">Estado Registro:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboEST_PLAN_GESTION_TRANS_PROY('EST_PLAN_GESTION_TRANS_PROY', $DataSet_GEN_TABLAS_1, $EST_PLAN_GESTION_TRANS_PROY, 1, "") ?>				
            </div>
        </div>  						














        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_PLAN_GESTION_TRANS_PROY($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado Registro" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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