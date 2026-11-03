<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_RECURSOVISTA de la tabla PROY_COMP_RECURSO
  //  Fecha           : martes, 16 de enero de 2018 03:06:22 p.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMP_RECURSO.js"></script>    


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
                    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
                    $PIDE_PLAN_FORECAST = $lCollection->Get('PIDE_PLAN_FORECAST');
                    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
                    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
                    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
                    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
                    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
                    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
                    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
                    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
                    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
                    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
                    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
                    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');
                    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');
//                    $DatosPadre = '<table width="100%">';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Código Proyecto:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td>Unidad Ejecutora:</td>';
//                    $DatosPadre .= '<td style="width: 100%" colspan="3"> ' . $VSEC_EJEC . ' - ' . $VDES_ENTIDAD . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Intervención:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_INTERVENCION . '</td>';
//                    $DatosPadre .= '<td style="width: 00%">Ejecución contractual:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . ' (' . $VDIAS_CONTRACTUALES . ' días)' . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Estado:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_ESTADO . '</td>';
//                    $DatosPadre .= '<td style="width: 00%">Cartera:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . $VDES_CARTERA . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '<tr>';
//                    $DatosPadre .= '<td style="width: 00%">Componente:</td>';
//                    $DatosPadre .= '<td style="width: 50%"><span style="color: #D1542F;"> ' . $VDES_COMPONENTE . '</span></td>';
//                    $DatosPadre .= '<td style="width: 00%">Monto de Inversión:</td>';
//                    $DatosPadre .= '<td style="width: 50%"> ' . FormatoMonedas($VIMP_COMPONENTE) . '</td>';
//                    $DatosPadre .= '</tr>';
//                    $DatosPadre .= '</table>';
                    
                    /* EDGAR */
                    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
                    $VCOD_PROYECTO = $lCollection->Get('VCOD_PROYECTO');
                    
                    $DatosPadre = Tabla_ProyectoComponente_Datos ( $VCOD_PROYECTO.' - '.$VDES_PROYECTO, $VDES_INTERVENCION,$VFEC_INICIO_CONTRATO,$VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE ) ;
                    
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
                                <li><a href="#tabs-1">Listado de Recursos de la Etapa del Contrato </a></li>
                                <li><a href="#tabs-2">Detalle de Recursos de la Etapa </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">
                                    <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE; ?>">    


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
                                                                /*Pagina php donde se realiza la consulta sql */

                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE_PROY_COMPONENTE=<?php echo $PIDE_PROY_COMPONENTE; ?>',

                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(5), sortable: true, align: 'center', hide: false},
                                                                    {display: '', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Nombre o Descripción del Recurso', name: 'DES_RECURSO', width: GetColumnSize(39), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Rol o Función', name: 'ROL', width: GetColumnSize(35), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'EST_PROY_COMP_REC', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},

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
                                                                    {display: 'Nombre o Descripción del Recurso', name: 'DES_RECURSO'}
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

                                                                , title: '<?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) .'<hr>'.$DatosPadre; ?>'


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


    $IDE_PROY_COMPONENTE = $lCollection->Get('IDE_PROY_COMPONENTE');
    $IDE_PROY_COMP_REC = $lCollection->Get('IDE_PROY_COMP_REC');
    $IDE_RECURSO = $lCollection->Get('IDE_RECURSO');
    $DESCRIPCIONRECURSO = $lCollection->Get('DESCRIPCIONRECURSO');
    $IDE_ROL = $lCollection->Get('IDE_ROL');
    $EST_PROY_COMP_REC = $lCollection->Get('EST_PROY_COMP_REC');



    $PIDE_PROY_COMPONENTE = $lCollection->Get('PIDE_PROY_COMPONENTE');
    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');
    $VCOD_ITEM = $lCollection->Get('VCOD_ITEM');
    $VSEC_EJEC = $lCollection->Get('VSEC_EJEC');
    $VDES_ENTIDAD = $lCollection->Get('VDES_ENTIDAD');
    $VDES_INTERVENCION = $lCollection->Get('VDES_INTERVENCION');
    $VDES_PROYECTO = $lCollection->Get('VDES_PROYECTO');
    $VDES_COMPONENTE = $lCollection->Get('VDES_COMPONENTE');
    $VDES_CARTERA = $lCollection->Get('VDES_CARTERA');
    $VDES_ESTADO = $lCollection->Get('VDES_ESTADO');
    $VFEC_INICIO_CONTRATO = $lCollection->Get('VFEC_INICIO_CONTRATO');
    $VFEC_TERMINO_CONTRATO = $lCollection->Get('VFEC_TERMINO_CONTRATO');
    $VIMP_COMPONENTE = $lCollection->Get('VIMP_COMPONENTE');
    $VFEC_INICIO_PLAN = $lCollection->Get('VFEC_INICIO_PLAN');
    $VFEC_TERMINO_PLAN = $lCollection->Get('VFEC_TERMINO_PLAN');
    $VDIAS_CONTRACTUALES = $lCollection->Get('VDIAS_CONTRACTUALES');

    
    /* EDGAR */
    $VIDE_PROYECTO = $lCollection->Get('VIDE_PROYECTO');
    $DatosPadre = Tabla_ProyectoComponente_Datos ( $VDES_PROYECTO, $VDES_INTERVENCION,$VFEC_INICIO_CONTRATO,$VFEC_TERMINO_CONTRATO, $VDES_COMPONENTE, $VDES_CARTERA, $VDES_ESTADO, $VIMP_COMPONENTE ) ;
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */    



    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_RECURSO_1 = $lCollection->Get('DataSet_GEN_RECURSO_1');
    $DataSet_GEN_ROLES_1 = $lCollection->Get('DataSet_GEN_ROLES_1');
    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');

    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Recursos del Componente"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Recursos del Componente"; //Nombre de la Tabla
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
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">
        <input type="hidden" name="PIDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">
        <input type="hidden" name="IDE_PROY_COMPONENTE" value="<?php echo $PIDE_PROY_COMPONENTE ?>">
        <input type="hidden" name="IDE_PROY_COMP_REC" value="<?php echo $SeleccionarID ?>">

        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group" style="display:none" >	
            <label class="control-label" for="IDE_CONVOCATORIA">Proyecto: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IDE_CONVOCATORIA" id="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA . ' - ' . $VCOD_ITEM . ': ' . $VDES_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_ENTIDAD">Unidad Ejecutora: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_ENTIDAD" id="DES_ENTIDAD" value="<?php echo $VSEC_EJEC . ' - ' . $VDES_ENTIDAD; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_INTERVENCION">Intervención: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_INTERVENCION" id="DES_INTERVENCION" value="<?php echo $VDES_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="DES_COMPONENTE">Componente: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="DES_COMPONENTE" id="DES_COMPONENTE" value="<?php echo $VDES_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>			   
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="FEC_INICIO_CONTRATO">Ejecución Contractual: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="FEC_INICIO_CONTRATO" id="FEC_INICIO_CONTRATO" value="<?php echo 'del ' . $VFEC_INICIO_CONTRATO . ' al ' . $VFEC_TERMINO_CONTRATO . '(' . $VDIAS_CONTRACTUALES . ' días)'; ?> )" onChange="conMayusculas(this)" maxlength="150" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>
        <div class="control-group" style="display:none" >	
            <label class="control-label" for="IMP_COMPONENTE">Monto de Inversión: <span class="error">*</span></label>				
            <div class="controls">
                <input disabled name="IMP_COMPONENTE" id="IMP_COMPONENTE" value="<?php echo $VIMP_COMPONENTE; ?>" onChange="conMayusculas(this)" maxlength="50" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>			
        </div>         

        
        <?php echo Tabla_Proyecto_Datos($VIDE_PROYECTO) .'<hr>'.$DatosPadre.'<br>' ; ?>
        
        
        <div class="control-group">
            <label class="control-label" for="IDE_ROL">Rol o Función:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_ROL('IDE_ROL', $DataSet_GEN_ROLES_1, $IDE_ROL, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>
        
<!--        <div class="control-group">
            <label class="control-label" for="IDE_RECURSO">Nombre del Recurso:<span class="error">*</span></label>                                
            <div class="controls"> 
                <input readonly name="DESCRIPCIONRECURSO" id="DESCRIPCIONRECURSO" value="<?php // echo $DESCRIPCIONRECURSO; ?>" onChange="conMayusculas(this)" maxlength="255" type="text" class=" required show-popover"  data-trigger="hover" data-content="Agrege el recurso empleando el el boton agregar(+)"/>
                <input name="Submit2" type="button" value="" id="add16" title="Seleccionar recurso" onclick="AddRecursos()"/>
                <input type="text" name="IDE_RECURSO" id="IDE_RECURSO" value="<?php // echo $IDE_RECURSO; ?>"/>                
            </div>
        </div>-->
<?php extraerIDEyValor_Text2 ("IDE_RECURSO",$IDE_RECURSO,'PROYECTO_ACTIVIDAD','Nombre del Recurso','DESCRIPCIONRECURSO' ,$DESCRIPCIONRECURSO, 'Recursos' , " width:50%;"   ); ?>


        <div class="control-group">
            <label class="control-label" for="EST_PROY_COMP_REC">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROY_COMP_REC('EST_PROY_COMP_REC', $DataSet_GEN_TABLAS_1, $EST_PROY_COMP_REC, 1, "") ?>				
            </div>
        </div>  						


        

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_ROL($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el rol que cumple en el proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_ROL > 0)) {
                if ($lstDatos[$i]->IDE_ROL == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ROL . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ROL . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ROL . "\">" . $lstDatos[$i]->DES_ROL . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboEST_PROY_COMP_REC($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione el estado del recurso" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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