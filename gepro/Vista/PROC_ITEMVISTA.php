<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROC_ITEMVISTA de la tabla PROC_ITEM
  //  Fecha           : jueves, 02 de noviembre de 2017 11:14:26 a.m.
  //  Desde el Modelo : PDM AMSAC
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROC_ITEM.js"></script>    


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
                     //RECUPERANDO LOS DATOS DE LA VARIABLE PARA EL FILTRO
                    $Proceso = $lCollection->Get('Proceso');
                    
                    //RECUPERANDO DATOS DE LOS PROCESOS                    
                    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');    
                    $VDES_OBJETO = $lCollection->Get('VDES_OBJETO');
                    $VIMP_VAL_REFERENCIAL = $lCollection->Get('VIMP_VAL_REFERENCIAL');                    
                    $DatosPadre='<table>';
                    $DatosPadre.='<tr>';
                    $DatosPadre.='<td style="width: 10%">Código del Proceso:</th>';
                    $DatosPadre.='<td style="width: 90%"> '.$VIDE_CONVOCATORIA.'</td>';
                    $DatosPadre.='</tr>';
                    $DatosPadre.='<tr>';
                    $DatosPadre.='<td style="width: 10%">Objeto de Contratación:</th>';
                    $DatosPadre.='<td style="width: 90%">'.$VDES_OBJETO.'</td>';
                    $DatosPadre.='</tr>';
                    $DatosPadre.='<tr>';
                    $DatosPadre.='<td style="width: 10%">Valor Referencial:</th>';
                    $DatosPadre.='<td style="width: 90%">'.$VIMP_VAL_REFERENCIAL.'</td>';
                    $DatosPadre.='</tr>';
                    $DatosPadre.='</table>';  
                    
    /* EDGAR */
                    $crudEliminar = $lCollection->Get('crudEliminar');
    /* EDGAR */
                    ?>
                    <div class="box-content">

                        

                        <div id="tabs">
                            <!-- CAMBIAR ETIQUETAS DE LAS PESTAÑAS-->
                            <ul>
                                <li><a href="#tabs-1">Listado de Items del Proceso</a></li>
                                <li><a href="#tabs-2">Mantenimiento</a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">         
                                    <input type="hidden" name="Proceso" value="<?php echo $Proceso; ?>">
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   
                                        <!--ACTIVA ESTA SECCION CUANDO LA TABLA DEPENDE DE OTRA TABLA Y SE DESEA VER EL DETALLE DE LOS DATOS
                                        <table class="table table-hover table-nomargin table-bordered">
                                            <tr>
                                                <th style="width: 25%">NOMBRE DEL CERRO DE PASCO</th>
                                                <td style="width: 75%"><?php //echo $IdProveedorR;       ?></td>
                                            </tr>
                                        </table>                                
                                        -->
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
                                                                /*Pagina php donde se realiza la consulta sql */
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&Proceso=<?php echo $Proceso; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Código Proyecto', name: 'COD_PROYECTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Objeto de Contratación', name: 'DES_ITEM', width: GetColumnSize(28.2), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Valor Referencial', name: 'IMP_VAL_REFERENCIAL_ITEM', width: GetColumnSize(10), sortable: true, align: 'right', hide: false},
                                                                    {display: 'Públicación', name: 'FEC_PUBLICACION', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Buena Pro', name: 'FEC_BUENA_PRO_FINAL', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Adjudicación', name: 'FEC_ADJUDICACION', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Estado', name: 'EST_PROCESO_ITEM', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Ppto', name: 'Boton4', width: GetColumnSize(6), sortable: false, align: 'center', hide: true},
                                                                    {display: 'Postor', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},                                                                    
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Código Proyecto', name: 'COD_PROYECTO'},
                                                                    {display: 'Objeto de Contratación', name: 'DES_ITEM'}
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
                                                                ,title: '<?php  echo $DatosPadre; ?>'
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
                                                $('#mensaje')
                                                        .text('Debe Seleccionar un registro del listado')
                                                        .addClass('msjalerta')
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


    $IDE_PROC_ITEM = $lCollection->Get('IDE_PROC_ITEM');
    $IDE_CONVOCATORIA = $lCollection->Get('IDE_CONVOCATORIA');
    $COD_ITEM = $lCollection->Get('COD_ITEM');
    $COD_PROYECTO = $lCollection->Get('COD_PROYECTO');
    $DES_DEPTO_ITEM = $lCollection->Get('DES_DEPTO_ITEM');
    $DES_PROV_ITEM = $lCollection->Get('DES_PROV_ITEM');
    $DES_DIST_ITEM = $lCollection->Get('DES_DIST_ITEM');
    $DES_ITEM = $lCollection->Get('DES_ITEM');
    $CNT_PROPUESTAS = $lCollection->Get('CNT_PROPUESTAS');
    $FEC_PUBLICACION = $lCollection->Get('FEC_PUBLICACION');
    $FEC_BUENA_PRO_INICIAL = $lCollection->Get('FEC_BUENA_PRO_INICIAL');
    $FEC_BUENA_PRO_FINAL = $lCollection->Get('FEC_BUENA_PRO_FINAL');
    $FEC_APELACION = $lCollection->Get('FEC_APELACION');
    $FEC_ADJUDICACION = $lCollection->Get('FEC_ADJUDICACION');
    $FEC_INICIO_CONTRATO = $lCollection->Get('FEC_INICIO_CONTRATO');
    $FEC_TERMINO_CONTRATO = $lCollection->Get('FEC_TERMINO_CONTRATO');
    $COD_CONTRATO = $lCollection->Get('COD_CONTRATO');
    $IMP_VAL_REFERENCIAL_ITEM = $lCollection->Get('IMP_VAL_REFERENCIAL_ITEM');
    $IMP_VAL_ADJUDICADO_ITEM = $lCollection->Get('IMP_VAL_ADJUDICADO_ITEM');
    $COD_RUC_POSTOR_GANADOR = $lCollection->Get('COD_RUC_POSTOR_GANADOR');
    $DES_POSTOR_GANADOR = $lCollection->Get('DES_POSTOR_GANADOR');
    $EST_PROCESO_ITEM = $lCollection->Get('EST_PROCESO_ITEM');
    $DES_OBSERVACION = $lCollection->Get('DES_OBSERVACION');
    $IDE_MODO_EJECUCION = $lCollection->Get('IDE_MODO_EJECUCION');
    $IDE_UNIDAD_MEDIDA = $lCollection->Get('IDE_UNIDAD_MEDIDA');
    $CNT_ITEM = $lCollection->Get('CNT_ITEM');
    
    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');    
    $VDES_OBJETO = $lCollection->Get('VDES_OBJETO');
    $VIMP_VAL_REFERENCIAL = $lCollection->Get('VIMP_VAL_REFERENCIAL');
    $Proceso = $lCollection->Get('Proceso');
     
    
    /* EDGAR */
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    



    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_MODO_EJECUCION_1 = $lCollection->Get('DataSet_GEN_MODO_EJECUCION_1');


    $DataSet_PROC_UNIDAD_MEDIDA_1 = $lCollection->Get('DataSet_PROC_UNIDAD_MEDIDA_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Items del Proceso"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Items del Proceso"; //Nombre de la Tabla
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


                        $('#FEC_PUBLICACION').datepicker({
                changeMonth: true,
                        changeYear: true,
                        showOn: 'button',
                        maxDate: '1095',
                        buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                        shortYearCutoff: '+100'
                });
                        $('#FEC_BUENA_PRO_INICIAL').datepicker({
                changeMonth: true,
                        changeYear: true,
                        showOn: 'button',
                        maxDate: '1095',
                        buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                        shortYearCutoff: '+100'
                });
                        $('#FEC_BUENA_PRO_FINAL').datepicker({
                changeMonth: true,
                        changeYear: true,
                        showOn: 'button',
                        maxDate: '1095',
                        buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                        shortYearCutoff: '+100'
                });
                        $('#FEC_APELACION').datepicker({
                changeMonth: true,
                        changeYear: true,
                        showOn: 'button',
                        maxDate: '1095',
                        buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                        shortYearCutoff: '+100'
                });
                        $('#FEC_ADJUDICACION').datepicker({
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
        <input type="hidden" name="Proceso" value="<?php echo $Proceso ?>">
        <input type="hidden" name="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA ?>">
        <input type="hidden" name="IDE_PROC_ITEM" value="<?php echo $SeleccionarID ?>">        
        <legend><?php echo $TitulFormulario; ?></legend>  
         <div class="control-group">
            <label class="control-label" for="IDE_CONVOCATORIA2">Código Proceso: <span class="error">*</span></label>
            <div class="controls">
                <input disabled  name="IDE_CONVOCATORIA2" id="IDE_CONVOCATORIA2" value="<?php echo $VIDE_CONVOCATORIA; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="integer" data-trigger="hover" data-content=""/>
            </div>
        </div>        
        <div class="control-group">
            <label class="control-label" for="VDES_OBJETO">Proceso: <span class="error">*</span></label>
            <div class="controls">
                <input disabled name="VDES_OBJETO" id="PROCESO" value="<?php echo $VDES_OBJETO; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="COD_ITEM">Nº Item: <span class="error">*</span></label>
            <div class="controls">
                <input  name="COD_ITEM" id="COD_ITEM" value="<?php echo $COD_ITEM; ?>" onChange="conMayusculas(this);CódigoProyecto();" maxlength="2" type="text" data-trigger="hover" class="input-xlarge integer required show-popover" data-content="Ingrese el número de item"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="COD_PROYECTO">Cod. Proyecto:</label>
            <div class="controls">
                <input  disabled name="COD_PROYECTO" id="COD_PROYECTO" value="<?php echo $COD_PROYECTO; ?>" maxlength="12" type="text" class="show-popover" data-trigger="hover" data-content="Seleccione el código del proyecto"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_DEPTO_ITEM">Departamento: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_DEPTO_ITEM" id="DES_DEPTO_ITEM" value="<?php echo $DES_DEPTO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del departamento"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_PROV_ITEM">Provincia: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_PROV_ITEM" id="DES_PROV_ITEM" value="<?php echo $DES_PROV_ITEM; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del provincia"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_DIST_ITEM">Distrito: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_DIST_ITEM" id="DES_DIST_ITEM" value="<?php echo $DES_DIST_ITEM; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del distrito"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_ITEM">Objeto de Contratación: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_ITEM" id="DES_ITEM" rows="5" onChange="conMayusculas(this)" maxlength="500" data-trigger="hover" class="input-xlarge alphanumeric required show-popover" data-content="Ingrese el objeto de contratación" ><?php echo $DES_ITEM; ?></textarea>

            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="CNT_PROPUESTAS">Nº Propuestas: <span class="error"></span></label>
            <div class="controls">
                <input  name="CNT_PROPUESTAS" id="CNT_PROPUESTAS" value="<?php echo $CNT_PROPUESTAS; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="input-xlarge integer show-popover" data-trigger="hover" data-content="Ingrese el número de propuestas de proceso item"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="FEC_PUBLICACION">Publicación:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_PUBLICACION" id="FEC_PUBLICACION" style="width: 10%" value="<?php echo $FEC_PUBLICACION; ?>" minlength="1" maxlength="10" type="text"  class="input-xlarge  alphanumeric  show-popover" data-trigger="hover" data-content="Ingrese la fecha de publicación" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="FEC_BUENA_PRO_INICIAL">Buena Pro Inicial:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_BUENA_PRO_INICIAL" id="FEC_BUENA_PRO_INICIAL" style="width: 10%" value="<?php echo $FEC_BUENA_PRO_INICIAL; ?>" minlength="1" maxlength="10" type="text"  class="input-xlarge alphanumeric e show-popover" data-trigger="hover" data-content="Ingrese la fecha de buena pro inicial" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="FEC_BUENA_PRO_FINAL">Buena Pro Final:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_BUENA_PRO_FINAL" id="FEC_BUENA_PRO_FINAL" style="width: 10%" value="<?php echo $FEC_BUENA_PRO_FINAL; ?>" minlength="1" maxlength="10" type="text" class="input-xlarge  alphanumeric  show-popover"  data-trigger="hover" data-content="Ingrese la fecha de buena pro final" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="FEC_APELACION">Fecha de Apelación:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_APELACION" id="FEC_APELACION" style="width: 10%" value="<?php echo $FEC_APELACION; ?>" minlength="1" maxlength="10" type="text"  data-trigger="hover" class="input-xlarge  alphanumeric  show-popover" data-content="Ingrese la fecha de apelación" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="FEC_ADJUDICACION">Fecha de Adjudicación:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_ADJUDICACION" id="FEC_ADJUDICACION" style="width: 10%" value="<?php echo $FEC_ADJUDICACION; ?>" minlength="1" maxlength="10" type="text"  class="input-xlarge  alphanumeric  show-popover" data-trigger="hover" data-content="Ingrese la fecha de adjudicación" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="FEC_INICIO_CONTRATO">Inicio de Contrato:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" style="width: 10%" value="<?php echo $FEC_INICIO_CONTRATO; ?>" minlength="1" maxlength="10" type="text"  class="input-xlarge  alphanumeric  show-popover" data-trigger="hover" data-content="Ingrese la fecha de inicio de contrato" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="FEC_TERMINO_CONTRATO">Término de Contrato:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_TERMINO_CONTRATO" id="FEC_TERMINO_CONTRATO" style="width: 10%" value="<?php echo $FEC_TERMINO_CONTRATO; ?>" minlength="1" maxlength="10" type="text"  class="input-xlarge alphanumeric  show-popover" data-trigger="hover" data-content="Ingrese la fecha de término de contrato" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="COD_CONTRATO">Número de Contrato: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_CONTRATO" id="COD_CONTRATO" value="<?php echo $COD_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="60" type="text" data-trigger="hover" class="input-xlarge alphanumeric show-popover" data-content="Ingrese el número de contrato"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="IMP_VAL_REFERENCIAL_ITEM">Valor Referencial: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IMP_VAL_REFERENCIAL_ITEM" id="IMP_VAL_REFERENCIAL_ITEM" value="<?php echo $IMP_VAL_REFERENCIAL_ITEM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="input-xlarge number required show-popover" data-trigger="hover" data-content="Ingrese el valor referencial"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="IMP_VAL_ADJUDICADO_ITEM">Valor Adjudicado: <span class="error"></span></label>
            <div class="controls">
                <input  name="IMP_VAL_ADJUDICADO_ITEM" id="IMP_VAL_ADJUDICADO_ITEM" value="<?php echo $IMP_VAL_ADJUDICADO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="input-xlarge number show-popover" data-trigger="hover" data-content="Ingrese el valor adjudicado"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="COD_RUC_POSTOR_GANADOR">RUC: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_RUC_POSTOR_GANADOR" id="COD_RUC_POSTOR_GANADOR" value="<?php echo $COD_RUC_POSTOR_GANADOR; ?>" onChange="conMayusculas(this)" maxlength="15" type="text" class="input-xlarge integer show-popover" data-trigger="hover" data-content="Ingrese el RUC del postor ganador"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_POSTOR_GANADOR">Postor Ganador: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_POSTOR_GANADOR" id="DES_POSTOR_GANADOR" value="<?php echo $DES_POSTOR_GANADOR; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" data-trigger="hover" class="input-xlarge alphanumeric  show-popover" data-content="Ingrese la razon social del postor ganador"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="EST_PROCESO_ITEM">Estado : <span class="error">*</span></label>
            <div class="controls">
                <input  name="EST_PROCESO_ITEM" id="EST_PROCESO_ITEM" value="<?php echo $EST_PROCESO_ITEM; ?>" onChange="conMayusculas(this)" maxlength="30" type="text" data-trigger="hover" class="input-xlarge alphanumeric required show-popover" data-content="Seleccione el estado del proceso"/>
            </div>
        </div>								

        <div class="control-group">
            <label class="control-label" for="DES_OBSERVACION">Observación: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_OBSERVACION" id="DES_OBSERVACION" rows="5" onChange="conMayusculas(this)" maxlength="500" data-trigger="hover" class="input-xlarge alphanumeric show-popover" data-content="Ingrese las observaciones del proceso" ><?php echo $DES_OBSERVACION; ?></textarea>

            </div>
        </div>						

        <div class="control-group">
            <label class="control-label" for="IDE_MODO_EJECUCION">Modo de Ejecución:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_MODO_EJECUCION('IDE_MODO_EJECUCION', $DataSet_GEN_MODO_EJECUCION_1, $IDE_MODO_EJECUCION, 1, "") ?>				
            </div>
        </div>  						

        <div class="control-group">
            <label class="control-label" for="IDE_UNIDAD_MEDIDA">Unidad de Medida:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_UNIDAD_MEDIDA('IDE_UNIDAD_MEDIDA', $DataSet_PROC_UNIDAD_MEDIDA_1, $IDE_UNIDAD_MEDIDA, 1, "") ?>				
            </div>
        </div>  						

        <div class="control-group">
            <label class="control-label" for="CNT_ITEM">Cantidad: <span class="error">*</span></label>
            <div class="controls">
                <input  name="CNT_ITEM" id="CNT_ITEM" value="<?php echo $CNT_ITEM; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="input-xlarge number required show-popover" data-trigger="hover" data-content="Ingrese la cantidad de items"/>
            </div>
        </div>								


         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_MODO_EJECUCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el modo de ejecución del proceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_MODO_EJECUCION > 0)) {
                if ($lstDatos[$i]->IDE_MODO_EJECUCION == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_MODO_EJECUCION . "\" selected=\"selected\">" . $lstDatos[$i]->DES_MODO_EJECUCION . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_MODO_EJECUCION . "\">" . $lstDatos[$i]->DES_MODO_EJECUCION . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_UNIDAD_MEDIDA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione la unidad de medida del proceso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_UNIDAD_MEDIDA > 0)) {
                if ($lstDatos[$i]->IDE_UNIDAD_MEDIDA == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_UNIDAD_MEDIDA . "\" selected=\"selected\">" . $lstDatos[$i]->UNIDAD_MEDIDA . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_UNIDAD_MEDIDA . "\">" . $lstDatos[$i]->UNIDAD_MEDIDA . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

/*	*/