<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_SOLPROY_SEGUIMIENTOVISTA de la tabla PLAN_SOLPROY_SEGUIMIENTO
  //  Fecha           : jueves, 05 de julio de 2018 10:46:13 a.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PLAN_SOLPROY_SEGUIMIENTO.js"></script>    


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
                    
/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION *****/                
                    $PIDE = $lCollection->Get('PIDE');
                    
                    $DatosPadre  =   array(
                        'Código Único PIP'           => $lCollection->Get('VCOD_UNICO')
                        ,'Proy. Inverción Pública'   => $lCollection->Get('VDES_PIP')
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
                                <li><a href="#tabs-1">HISTORIAL DE CAMBIOS DE ESTADO DE SEGUIMIENTO, DEL PROYECTO SOLICITADO</a></li>
                                <li><a href="#tabs-2">  </a></li>
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
                                            Seleccione un registro para ver 
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
                                                                    
                                                                    {display: 'Usuario: Rol', name: 'Usuario_Rol', width: GetColumnSize(14), sortable: true, align: 'center', hide: false},                                                                                                            
                                                                    {display: 'Usuario: Persona', name: 'Usuario_Persona', width: GetColumnSize(11), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Usuario: Fecha', name: 'Usuario_Fecha', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    
                                                                    {display: 'PIP: Cód. Único', name: 'PIP_CodigoUnico', width: GetColumnSize(6), sortable: true, align: 'center', hide: true},
                                                                    {display: 'PIP: Proyecto de Inverción Pública', name: 'PIP_Definicion', width: GetColumnSize(22), sortable: true, align: 'left', hide: true},
                                                                    {display: 'Seguimiento: Estado', name: 'Seguimiento_Tipo', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Seguimiento: Fecha', name: 'Seguimiento_Fecha', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Seguimiento: Descripción', name: 'Seguimiento_Descripcion', width: GetColumnSize(40), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Seguimiento: Evaluador Proyecto', name: 'Seguimiento_Evaluador', width: GetColumnSize(13), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Seguimiento: Evaluador-Rol', name: 'Seguimiento_EvaluadorRol', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Ver', name: 'Boton1', width: GetColumnSize(3), sortable: false, align: 'center', hide: true}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Seguimiento: Estado', name: 'Seguimiento_Tipo'},
                                                                    {display: 'Seguimiento: Evaluador', name: 'Seguimiento_Evaluador'}
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

                                                                ,title: '<?php visTabla_DatosPadre($DatosPadre,20); ?>'
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


                $IDE_SOLPROY_SEG = $lCollection->Get('IDE_SOLPROY_SEG');
                $IDE_SOLICITUD_PROYECTO = $lCollection->Get('IDE_SOLICITUD_PROYECTO');
                $IDE_PLAN_RECURSO = $lCollection->Get('IDE_PLAN_RECURSO');
                $TIP_ROL = $lCollection->Get('TIP_ROL');
                $EST_SEGUIMIENTO = $lCollection->Get('EST_SEGUIMIENTO');
                $FEC_SEGUIMIENTO = $lCollection->Get('FEC_SEGUIMIENTO');
                $DES_SEGUIMIENTO = $lCollection->Get('DES_SEGUIMIENTO');
                $EST_SOLPROY_SEG = $lCollection->Get('EST_SOLPROY_SEG');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');


                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */

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


            $('#FEC_SEGUIMIENTO').datepicker({
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
    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  





        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_SOLPROY_SEG">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_SOLPROY_SEG" id="IDE_SOLPROY_SEG" value="<?php echo $IDE_SOLPROY_SEG; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" >
            <label class="control-label" for="IDE_SOLICITUD_PROYECTO">Proyecto Solicitado: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IDE_SOLICITUD_PROYECTO" id="IDE_SOLICITUD_PROYECTO" value="<?php echo $IDE_SOLICITUD_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Solicitud: Hoja de Ruta"/>

            </div>
        </div>												


        <div class="control-group" >
            <label class="control-label" for="IDE_PLAN_RECURSO">Recurso: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IDE_PLAN_RECURSO" id="IDE_PLAN_RECURSO" value="<?php echo $IDE_PLAN_RECURSO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Nombre del Evaluador Tecnico"/>

            </div>
        </div>												


        <div class="control-group" >
            <label class="control-label" for="TIP_ROL">Tipo Rol: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="TIP_ROL" id="TIP_ROL" value="<?php echo $TIP_ROL; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" data-trigger="hover" data-content="Recurso: Tipo de Rol"/>

            </div>
        </div>												


        <div class="control-group" >
            <label class="control-label" for="EST_SEGUIMIENTO">Estado Seguimiento: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="EST_SEGUIMIENTO" id="EST_SEGUIMIENTO" value="<?php echo $EST_SEGUIMIENTO; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" data-trigger="hover" data-content="Estado de Seguimiento"/>

            </div>
        </div>												


        <div class="control-group" >
            <label class="control-label" for="FEC_SEGUIMIENTO">Fecha Seguimiento: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="FEC_SEGUIMIENTO" id="FEC_SEGUIMIENTO" value="<?php echo $FEC_SEGUIMIENTO; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" data-trigger="hover" data-content="Fecha de Seguimiento"/>

            </div>
        </div>												


        <div class="control-group">
            <label class="control-label" for="DES_SEGUIMIENTO">Descripción Seguimiento: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_SEGUIMIENTO" id="DES_SEGUIMIENTO" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Descripción de Seguimiento" ><?php echo $DES_SEGUIMIENTO; ?></textarea>				
            </div>
        </div>						


        <div class="control-group" >
            <label class="control-label" for="EST_SOLPROY_SEG">Estado Registro: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="EST_SOLPROY_SEG" id="EST_SOLPROY_SEG" value="<?php echo $EST_SOLPROY_SEG; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" data-trigger="hover" data-content="Estado de Registro"/>

            </div>
        </div>												














        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn; ?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>

    <?php
}

/***********************************************************************************
    * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
    ***********************************************************************************/  

/*	*/