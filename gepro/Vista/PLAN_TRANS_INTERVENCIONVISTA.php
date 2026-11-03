<?php
/* * ******************************************************************************
  //  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA
  //  Propósito       : PLAN_TRANS_INTERVENCIONVISTA de la tabla PLAN_TRANS_INTERVENCION
  //  Fecha           : viernes, 26 de octubre de 2018 13:10:56
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PLAN_TRANS_INTERVENCION.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>


<!--/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION *****/--> 
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/include/Comun.js"></script>
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
                    
                    $PIDE = $lCollection->Get('PIDE');
                    
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
                                <li><a href="#tabs-1">LISTA DE TRANSFERENCIAS DE LA INTERVENCION</a></li>
                                <li><a href="#tabs-2">DETALLE DE TRANSFERENCIA DE LA INTERVENCION</a></li>
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
                                                                /*Pagina php donde se realiza la consulta sql */   												//	url: 'mainpage.php?Pagina=<?php //echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList', /* Tipo de datos devuelto json, xml */
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>',                                                            
                                                                
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Cod.Trans.', name: 'ID', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Ejecutora', name: 'Ejecutora', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Departamento', name: 'Departamento', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Provincia', name: 'Provincia', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Distrito', name: 'Distrito', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cod.ARCC', name: 'CodARCC_Lista', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},                                                                                                                     
                                                                    {display: 'Tipo Intervencion', name: 'TipoIntervencion', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Cod.Unificado', name: 'CodigoUnico', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                                    
                                                                    {display: 'Nombre de Transferencia', name: 'NombreCorto', width: GetColumnSize(13.1), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Decreto', name: 'Decreto', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado SSAP', name: 'Estado_SSAP', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Mto.Transfer.Interv.', name: 'MtoTransferIntervencion', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
//                                                                    {display: 'IdePIP', name: 'IDE_PIP', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    
                                                                    {display: 'Inversión', name: 'Boton4', width: GetColumnSize(4), sortable: false, align: 'center'},

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
                                                                    {display: 'Decreto Supremo', name: 'Decreto'},
                                                                    {display: 'Codigo Unico', name: 'CodigoUnico'},
                                                                    {display: 'Unidad Ejecutora', name: 'Ejecutora'},
                                                                    {display: 'Departamento', name: 'Departamento'},
                                                                    {display: 'Provincia', name: 'Provincia'},
                                                                    {display: 'Distrito', name: 'Distrito'},
                                                                    {display: 'Nombre Transferencia', name: 'NombreCorto'},
                                                                    {display: 'Tipo Intervencion', name: 'TipoIntervencion'}
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


                $IDE_TRANS_INTERVENCION = $lCollection->Get('IDE_TRANS_INTERVENCION');
                $IDE_TRANSFERENCIA = $lCollection->Get('IDE_TRANSFERENCIA');
                $TIPO_TRANSFERENCIA = $lCollection->Get('TIPO_TRANSFERENCIA');
                $TIPO_TRANSACCION = $lCollection->Get('TIPO_TRANSACCION');
                $AMBITO = $lCollection->Get('AMBITO');
                $PROGRAMA_PPTO = $lCollection->Get('PROGRAMA_PPTO');
                $FUENTE_FINANC = $lCollection->Get('FUENTE_FINANC');
                $GENERICA = $lCollection->Get('GENERICA');
                $COMPONENTE = $lCollection->Get('COMPONENTE');
                $COD_PRODUCTO_PROYECTO = $lCollection->Get('COD_PRODUCTO_PROYECTO');
                $IMP_TRANSFERENCIA = $lCollection->Get('IMP_TRANSFERENCIA');
                $DES_INTERVENCION = $lCollection->Get('DES_INTERVENCION');
                $DES_INTERVENCION_CORTO = $lCollection->Get('DES_INTERVENCION_CORTO');
                $EST_TRANS_INTERVENCION = $lCollection->Get('EST_TRANS_INTERVENCION');
                $TIP_GRUPO_INTERVENCION = $lCollection->Get('TIP_GRUPO_INTERVENCION');
                $COD_SNIP = $lCollection->Get('COD_SNIP');
                $COD_UNICO = $lCollection->Get('COD_UNICO');
                $COD_UBIGEO = $lCollection->Get('COD_UBIGEO');
                $IDE_ENTIDAD = $lCollection->Get('IDE_ENTIDAD');
                $TIP_TIPOLOGIA_INTERVENCION = $lCollection->Get('TIP_TIPOLOGIA_INTERVENCION');
                $IDE_INTERVENCION = $lCollection->Get('IDE_INTERVENCION');
                $IDE_PIP = $lCollection->Get('IDE_PIP');
                $TIP_PRODUCTO_PROYECTO = $lCollection->Get('TIP_PRODUCTO_PROYECTO');
                $USER_INSERT = $lCollection->Get('USER_INSERT');
                $FECHA_INSERT = $lCollection->Get('FECHA_INSERT');
                $USER_UPDATE = $lCollection->Get('USER_UPDATE');
                $FECHA_UPDATE = $lCollection->Get('FECHA_UPDATE');
                
/**********************************************************/
                $PIDE = $lCollection->Get('PIDE');
                $TIPO_TRANSACCION = 2 ;
/**********************************************************/

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


                $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');


                $DataSet_GEN_TABLAS_5 = $lCollection->Get('DataSet_GEN_TABLAS_5');


                $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


                $DataSet_GEN_TABLAS_6 = $lCollection->Get('DataSet_GEN_TABLAS_6');
                
                
                $DataSet_generica = $lCollection->Get('DataSet_generica');
                
                $DataSet_fuente_financ = $lCollection->Get('DataSet_fuente_financ');

/***EDGAR---**************/
                $DESCRIPCION_ENTIDAD_UNIDAD_EJECUTORA = $lCollection->Get('DESCRIPCION_ENTIDAD_UNIDAD_EJECUTORA');
                $DESCRIPCION_UBIGEO = $lCollection->Get('DESCRIPCION_UBIGEO');
                $DESCRIPCION_COMPONENTE = $lCollection->Get('DESCRIPCION_COMPONENTE');
                $DESCRIPCION_PROGRAMA_PPTO = $lCollection->Get('DESCRIPCION_PROGRAMA_PPTO');
/***EDGAR---**************/

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
/***---******************/
                    $IDE_TRANSFERENCIA = $PIDE ;
/***---******************/
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
        <!--<input type="hidden" name="PIDE_SOLICITUD" value="<?php echo $PIDE_SOLICITUD ?>">-->
        <input type="hidden" name="btnUnidadEjecutora" value="">
        <input type="hidden" name="btnPedido" value="">
        <input type="hidden" name="varBotonInvocador" value="">
<!--/***EDGAR---************** **/--> 
        
        
        
        <legend><?php echo $TitulFormulario; ?></legend>  





        <div class="control-group"  style="display:none" >
            <label class="control-label" for="IDE_TRANS_INTERVENCION">Ide: <span class="error"></span></label>
            <div class="controls">

                <input <?php echo (strlen($SeleccionarID) > 0) ? "readonly" : ""; ?> name="IDE_TRANS_INTERVENCION" id="IDE_TRANS_INTERVENCION" value="<?php echo $SeleccionarID; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>												


        <div class="control-group" style="display:none" >
            <label class="control-label" for="IDE_TRANSFERENCIA">IdeTransferencia: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_TRANSFERENCIA" id="IDE_TRANSFERENCIA" value="<?php echo $IDE_TRANSFERENCIA; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer show-popover" data-trigger="hover" data-content="IdeTransferencia"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="TIPO_TRANSFERENCIA">Tipo Transferencia:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIPO_TRANSFERENCIA('TIPO_TRANSFERENCIA', $DataSet_GEN_TABLAS_1, $TIPO_TRANSFERENCIA, 1, "") ?>				
            </div>
        </div>  						


        							


        <div class="control-group">
            <label class="control-label" for="AMBITO">Tipo Ambito:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboAMBITO('AMBITO', $DataSet_GEN_TABLAS_2, $AMBITO, 1, "") ?>				
            </div>
        </div>  						


<!--        <div class="control-group">
            <label class="control-label" for="PROGRAMA_PPTO">Programa Presupuestal : <span class="error"></span></label>
            <div class="controls">
                <input  name="PROGRAMA_PPTO" id="PROGRAMA_PPTO" value="<?php // echo $PROGRAMA_PPTO; ?>" onChange="conMayusculas(this)" maxlength="4" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Programa Presupuestal"/>					
            </div>
        </div>								-->

<!--/***EDGAR---**************-->
            <?php visClaseBuscarIDE ('PROGRAMA_PPTO',$PROGRAMA_PPTO,'DESCRIPCION_PROGRAMA_PPTO',$DESCRIPCION_PROGRAMA_PPTO,'Programa Presupuestal',"ProgramaPresupuestal"); ?>
<!--/***EDGAR---**************-->      



<!--        <div class="control-group">
            <label class="control-label" for="FUENTE_FINANC">Fuente Financiamiento: <span class="error"></span></label>
            <div class="controls">
                <input  name="FUENTE_FINANC" id="FUENTE_FINANC" value="<?php // echo $FUENTE_FINANC; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fuente Financiamiento"/>					
            </div>
        </div>								-->

        <div class="control-group">
            <label class="control-label" for="FUENTE_FINANC">Fuente Financiamiento :<span class="error"></span></label>
            <div class="controls"> 
    <?php comboFUENTE_FINANC('FUENTE_FINANC', $DataSet_fuente_financ, $FUENTE_FINANC, 1, "") ?>				
            </div>
        </div>


        <div class="control-group" style="display:none"  >
            <label class="control-label" for="TIPO_TRANSACCION">Tipo Transaccion : <span class="error"></span></label>
            <div class="controls">
                <input  name="TIPO_TRANSACCION" id="TIPO_TRANSACCION" value="<?php echo $TIPO_TRANSACCION; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Tipo Transaccion"/>					
            </div>
        </div>	

<!--        <div class="control-group">
            <label class="control-label" for="GENERICA">Generica: <span class="error"></span></label>
            <div class="controls">
                <input  name="GENERICA" id="GENERICA" value="<?php // echo $GENERICA; ?>" onChange="conMayusculas(this)" maxlength="3" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Generica"/>					
            </div>
        </div>	
-->


        <div class="control-group">
            <label class="control-label" for="GENERICA">Genérica:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboGENERICA('GENERICA', $DataSet_generica, $GENERICA, 1, "") ?>				
            </div>
        </div>


<!--        <div class="control-group">
            <label class="control-label" for="COMPONENTE">Componente: <span class="error"></span></label>
            <div class="controls">
                <input  name="COMPONENTE" id="COMPONENTE" value="<?php // echo $COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="7" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Componente"/>					
            </div>
        </div>								-->
<!--/***EDGAR---**************-->
            <?php visClaseBuscarIDE ('COMPONENTE',$COMPONENTE,'DESCRIPCION_COMPONENTE',$DESCRIPCION_COMPONENTE,'Componente',"Componente"); ?>
<!--/***EDGAR---**************--> 

        <div class="control-group">
            <label class="control-label" for="COD_PRODUCTO_PROYECTO">Producto/Proyecto (SOSEM): <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_PRODUCTO_PROYECTO" id="COD_PRODUCTO_PROYECTO" value="<?php echo $COD_PRODUCTO_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Codigo Producto/Proyecto" style="width:10%" />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IMP_TRANSFERENCIA">MontoTransferencia: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_TRANSFERENCIA" id="IMP_TRANSFERENCIA" value="<?php echo $IMP_TRANSFERENCIA; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese MontoTransferencia" style="width:10%" />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_INTERVENCION">Descripcion Intervención: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_INTERVENCION" id="DES_INTERVENCION" rows="5" onChange="conMayusculas(this)" maxlength="1000" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Descripcion Intervención" ><?php echo $DES_INTERVENCION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="DES_INTERVENCION_CORTO">Descripcion Intervención Corta: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_INTERVENCION_CORTO" id="DES_INTERVENCION_CORTO" rows="3" onChange="conMayusculas(this)" maxlength="500" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Ingrese Descripcion Intervención Corta" ><?php echo $DES_INTERVENCION_CORTO; ?></textarea>				
            </div>
        </div>						


        <div class="control-group" style="display:none"  >
            <label class="control-label" for="EST_TRANS_INTERVENCION">Estado de Trasferencia:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboEST_TRANS_INTERVENCION('EST_TRANS_INTERVENCION', $DataSet_GEN_TABLAS_3, $EST_TRANS_INTERVENCION, 1, "") ?>				
            </div>
        </div>  						


        						



<!--        <div class="control-group">
            <label class="control-label" for="COD_UBIGEO">UBIGEO: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_UBIGEO" id="COD_UBIGEO" value="<?php echo $COD_UBIGEO; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese UBIGEO"/>					
            </div>
        </div>								-->


<!--        <div class="control-group">
            <label class="control-label" for="IDE_ENTIDAD">IdeEntidad: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_ENTIDAD" id="IDE_ENTIDAD" value="<?php echo $IDE_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer show-popover" data-trigger="hover" data-content="Ingrese Entidad (Unidad Ejecutora)"/>					
            </div>
        </div>								-->

<hr>
<!--        <div class="control-group">
            <label class="control-label" for="IDE_PIP">IdePIP: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_PIP" id="IDE_PIP" value="<?php // echo $IDE_PIP; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Código Unico"/>					
            </div>
        </div>								-->


        <div class="control-group">
            <label class="control-label" for="COD_SNIP">Código SNIP: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_SNIP" id="COD_SNIP" value="<?php echo $COD_SNIP; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código SNIP"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="COD_UNICO">Código Unico: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_UNICO" id="COD_UNICO" value="<?php echo $COD_UNICO; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código Unico"/>					
            </div>
        </div>	

<!--/***EDGAR---**************-->
            <?php visClaseBuscarIDE ('IDE_ENTIDAD',$IDE_ENTIDAD,'ENTIDAD_UNIDAD_EJECUTORA',$DESCRIPCION_ENTIDAD_UNIDAD_EJECUTORA,'Entidad Uni.Ejecutora','UnidadEjecutora_c'); ?>

            <?php visClaseBuscarIDE ('COD_UBIGEO',$COD_UBIGEO,'Descripcion_UBIGEO',$DESCRIPCION_UBIGEO,'Lugar Inversión (UBIGEO)','UBIGEO_c'); ?>
<!--/***EDGAR---**************--> 
        
        <div class="control-group">
            <label class="control-label" for="TIP_PRODUCTO_PROYECTO">Tipo Producto/Proyecto:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_PRODUCTO_PROYECTO('TIP_PRODUCTO_PROYECTO', $DataSet_GEN_TABLAS_6, $TIP_PRODUCTO_PROYECTO, 1, "") ?>				
            </div>
        </div> 

        <div class="control-group">
            <label class="control-label" for="TIP_TIPOLOGIA_INTERVENCION">Tipologia de Intervención:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_TIPOLOGIA_INTERVENCION('TIP_TIPOLOGIA_INTERVENCION', $DataSet_GEN_TABLAS_5, $TIP_TIPOLOGIA_INTERVENCION, 1, "") ?>				
            </div>
        </div>  						

<div class="control-group">
            <label class="control-label" for="TIP_GRUPO_INTERVENCION">Tipo Grupo Intervención:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboTIP_GRUPO_INTERVENCION('TIP_GRUPO_INTERVENCION', $DataSet_GEN_TABLAS_4, $TIP_GRUPO_INTERVENCION, 1, "") ?>				
            </div>
        </div>  


        <div class="control-group">
            <label class="control-label" for="IDE_INTERVENCION">Tipo de Intervención:<span class="error"></span></label>
            <div class="controls"> 
    <?php comboIDE_INTERVENCION('IDE_INTERVENCION', $DataSet_GEN_INTERVENCION_1, $IDE_INTERVENCION, 1, "") ?>				
            </div>
        </div>  
<hr>

 						














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

function comboTIPO_TRANSFERENCIA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Transferencia" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 25%" >
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

    function comboAMBITO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Ambito" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 25%" >
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

function comboEST_TRANS_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado de Trasferencia" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_GRUPO_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Grupo Intervención" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 25%" >
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

    function comboTIP_TIPOLOGIA_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipologia de Intervención" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 40%" >
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

    function comboIDE_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo de Intervención" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 40%" >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_INTERVENCION > 0)) {
            if ($lstDatos[$i]->IDE_INTERVENCION == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_INTERVENCION . "\" selected=\"selected\">" . $lstDatos[$i]->DES_INTERVENCION . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_INTERVENCION . "\">" . $lstDatos[$i]->DES_INTERVENCION . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    function comboTIP_PRODUCTO_PROYECTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Producto/Proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 25%" >
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
    
    
    
    
    
    
    function comboGENERICA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Genérica" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 25%" >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->GENERICA > 0)) {
                if ($lstDatos[$i]->GENERICA == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->GENERICA . "\" selected=\"selected\">" . $lstDatos[$i]->DESCRIPCIO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->GENERICA . "\">" . $lstDatos[$i]->DESCRIPCIO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
        <?php
    }
    
    
    
    function comboFUENTE_FINANC($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Fuente Financiamiento" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> style="width: 25%" >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->FUENTE_FINANC > 0)) {
                if ($lstDatos[$i]->FUENTE_FINANC == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->FUENTE_FINANC . "\" selected=\"selected\">" . $lstDatos[$i]->NOMBRE . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->FUENTE_FINANC . "\">" . $lstDatos[$i]->NOMBRE . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
        <?php
    }

    /*	*/