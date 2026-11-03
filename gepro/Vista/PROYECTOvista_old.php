<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROYECTOVISTA de la tabla PROYECTO
  //  Fecha           : lunes, 6 de mayo de 2019 17:39:11
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-DEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROYECTO.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <link rel="stylesheet" type="text/css" href="../lib/css/include.css" />

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
                    $Opcion = $lCollection->Get('Opcion');
                    $BotonVer = Grilla_verBotones($Opcion);
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
                                <li><a href="#tabs-1">Listado de Proyectos <?php echo $BotonVer['Nuevo'] ?></a></li>
                                <li><a href="#tabs-2">Detalle de Proyectos </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">                                
                                    <input type="hidden" name="SeleccionarID" value="">                                    

                                    <!--/*EDGAR*/-->
                                    <input type="hidden" name="PIDE" value="<?php echo $PIDE; ?>">
                                    <!--/*EDGAR*/-->

                                    <div id="contenedor">        
                                        <div id="fila1">
                                            <div class="limpiar"></div>
                                        </div>   

                                        <div class="msjinformacion" id="mensaje">
                                            Seleccione un registro para editar. <?php echo SPRING_msgListaActualizada('AdicionarRegistro'); ?>  
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Opcion=<?php echo $Opcion; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Código SPRING', name: 'COD_INTERNO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Código Único', name: 'COD_UNICO', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Descripción Larga', name: 'DES_LARGA_PROYECTO', width: GetColumnSize(28), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Monto Aprobado', name: 'IMP_APROBADO_LOC', width: GetColumnSize(8), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Fecha Inicio', name: 'FEC_INICIO_PROY', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fecha Término', name: 'FEC_TERMINO_PROY', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},

                                                                    {display: 'Proy.Inver.', name: 'ProyectoInversion', width: GetColumnSize(8), sortable: false, align: 'center', hide:<?php echo $BotonVer['ProyectoInversion']; ?>},
                                                                    {display: 'UBIGEO', name: 'UBIGEO', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $BotonVer['UBIGEO']; ?>},
                                                                    {display: 'Contratos', name: 'Contrato', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato']; ?>},
                                                                    {display: 'Estudios', name: 'Contrato_estudios', width: GetColumnSize(5.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato_estudios']; ?>},
                                                                    {display: 'Obras', name: 'Contrato_obras', width: GetColumnSize(5.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato_obras']; ?>},
                                                                    {display: 'Supervisión', name: 'Contrato_supervision', width: GetColumnSize(5.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato_supervision']; ?>},
                                                                    {display: 'PostCierre', name: 'Contrato_postcierre', width: GetColumnSize(5.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato_postcierre']; ?>},
                                                                    {display: 'Otros', name: 'Contrato_otros', width: GetColumnSize(5.5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Contrato_otros']; ?>},
                                                                    {display: 'Gestión Social', name: 'GestionSocial', width: GetColumnSize(7), sortable: false, align: 'center', hide:<?php echo $BotonVer['GestionSocial']; ?>},
                                                                    {display: 'Lección Aprendida', name: 'Leccion', width: GetColumnSize(8), sortable: false, align: 'center', hide:<?php echo $BotonVer['Leccion']; ?>},
                                                                    {display: 'Comunicaciones', name: 'Comunicacion', width: GetColumnSize(7), sortable: false, align: 'center', hide:<?php echo $BotonVer['Comunicacion']; ?>},
                                                                    {display: 'SIGAM', name: 'SIGAM', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $BotonVer['SIGAM']; ?>},
                                                                    {display: 'Ficha T', name: 'FichaTecnica', width: GetColumnSize(5), sortable: false, align: 'center', hide:<?php echo $BotonVer['FichaTecnica']; ?>},

                                                                    {display: 'Editar', name: 'Editar', width: GetColumnSize(5), sortable: false, align: 'center', hide:<?php echo $BotonVer['Editar']; ?>},
                                                                    {display: 'Eliminar', name: 'Eliminar', width: GetColumnSize(6), sortable: false, align: 'center', hide:<?php echo $BotonVer['Eliminar']; ?>}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
        <?php if ($BotonVer['Nuevo'] == 'true') { ?>                  //  {name: 'Nuevo', bclass: 'nuevo', onpress: test },
                                                                        //  {separator: true},
        <?php } ?>    //                                                  {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Descripción Larga', name: 'DES_LARGA_PROYECTO'},
                                                                    {display: 'Código Único', name: 'COD_UNICO'},
                                                                    {display: 'Código SPRING', name: 'COD_INTERNO'},
                                                                    {display: 'Fecha Inicio', name: 'FEC_INICIO_PROY'},
                                                                    {display: 'Fecha Término', name: 'FEC_TERMINO_PROY'}
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


    $IDE_PROYECTO = $lCollection->Get('IDE_PROYECTO');
    $IDE_PORTAFOLIO = $lCollection->Get('IDE_PORTAFOLIO');
    $IDE_PROGRAMA = $lCollection->Get('IDE_PROGRAMA');
    $IDE_CENCOSTO = $lCollection->Get('IDE_CENCOSTO');
    $IDE_ENTIDAD_EJECUTORA = $lCollection->Get('IDE_ENTIDAD_EJECUTORA');
    $IDE_ETAPA_CONTRATO = $lCollection->Get('IDE_ETAPA_CONTRATO');
    $COD_INTERNO = $lCollection->Get('COD_INTERNO');
    $COD_UNICO = $lCollection->Get('COD_UNICO');
    $COD_SNIP = $lCollection->Get('COD_SNIP');
    $DES_LARGA_PROYECTO = $lCollection->Get('DES_LARGA_PROYECTO');
    $DES_CORTA_PROYECTO = $lCollection->Get('DES_CORTA_PROYECTO');
    $DES_PROYECTO_ENGLISH = $lCollection->Get('DES_PROYECTO_ENGLISH');
    $TIP_MONEDA = $lCollection->Get('TIP_MONEDA');
    $IMP_APROBADO_LOC = $lCollection->Get('IMP_APROBADO_LOC');
    $IMP_APROBADO_EXT = $lCollection->Get('IMP_APROBADO_EXT');
    $FEC_APROBACION = $lCollection->Get('FEC_APROBACION');
    $FEC_INICIO_PROY = $lCollection->Get('FEC_INICIO_PROY');
    $FEC_TERMINO_PROY = $lCollection->Get('FEC_TERMINO_PROY');
    $DES_UBICACION_PROYECTO = $lCollection->Get('DES_UBICACION_PROYECTO');
    $DES_UNIDAD_FORMULADORA = $lCollection->Get('DES_UNIDAD_FORMULADORA');
    $DES_VIABILIDAD = $lCollection->Get('DES_VIABILIDAD');
    $DES_AREA_INTERVENCION = $lCollection->Get('DES_AREA_INTERVENCION');
    $DES_CUENCA_HIDROGRAFICA = $lCollection->Get('DES_CUENCA_HIDROGRAFICA');
    $NUM_PAMS = $lCollection->Get('NUM_PAMS');
    $DES_STAKEHOLDER = $lCollection->Get('DES_STAKEHOLDER');
    $DES_ESTATUS = $lCollection->Get('DES_ESTATUS');
    $DES_ACCION_GESTION = $lCollection->Get('DES_ACCION_GESTION');
    $DES_ACCION_GESTION_SOCIAL = $lCollection->Get('DES_ACCION_GESTION_SOCIAL');
    $DES_ACCION_CORRECTIVA = $lCollection->Get('DES_ACCION_CORRECTIVA');
    $DES_OPORTUNIDAD_MEJORA = $lCollection->Get('DES_OPORTUNIDAD_MEJORA');
    $TIP_PROYECTO = $lCollection->Get('TIP_PROYECTO');
    $TIP_GRUPO_PROYECTO = $lCollection->Get('TIP_GRUPO_PROYECTO');
    $NUM_BENEFICIARIOS = $lCollection->Get('NUM_BENEFICIARIOS');
    $EST_PROYECTO = $lCollection->Get('EST_PROYECTO');



    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    //$DatosPadre  =   array(
    //   'Tabla'           =>  $lCollection->Get('VDES_ITEM'),
    //   'Abreviatura'     =>  $lCollection->Get('VDES_ABREVIATURA')
    //   ,'VCOD_TABLA'     =>  $lCollection->Get('VCOD_TABLA')
    //  );
    //$COD_TABLA = $lCollection->Get('VCOD_TABLA'); //codigo superior autocompleta
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        if ($EST_PROYECTO == 98) {
            $Control_Bloqueo = Control_Bloqueo('');
        } else {
            $Control_Bloqueo = Control_Bloqueo('SPRING1');
        }
    } else {
        //INSERT
        $Control_Bloqueo = Control_Bloqueo('');
        $EST_PROYECTO = 98;
    }

    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_PORTAFOLIO_PROYECTO_1 = $lCollection->Get('DataSet_GEN_PORTAFOLIO_PROYECTO_1');


    $DataSet_GEN_PROGRAMA_PROYECTO_1 = $lCollection->Get('DataSet_GEN_PROGRAMA_PROYECTO_1');


    $DataSet_GEN_CENTRO_COSTO_1 = $lCollection->Get('DataSet_GEN_CENTRO_COSTO_1');


    $DataSet_GEN_ENTIDAD_1 = $lCollection->Get('DataSet_GEN_ENTIDAD_1');


    $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


    $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');


    $DataSet_GEN_TABLAS_4 = $lCollection->Get('DataSet_GEN_TABLAS_4');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Proyectos. " . SPRING_msgDatosActualizados('AdicionarRegistro'); //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Proyectos"; //Nombre de la Tabla
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


            $('#FEC_APROBACION').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '7000',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_INICIO_PROY').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '7000',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO_PROY').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '7000',
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

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>">        
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
        <?php //visTabla_DatosPadre($DatosPadre);   ?>
        <!--/*EDGAR*/-->


        <table>
            <tr>
                <td width="20%" rowspan="2">
                    <!--<img src="../recursos/images/MINEM.png" width="90%" >-->
                    <div class="control-group">
                        <label class="control-label" for="COD_INTERNO">Código de Proyecto: <span class="error"></span></label>
                        <!--<div class="controls">-->
                        <input <?php echo $Control_Bloqueo['COD_INTERNO']; ?>  name="COD_INTERNO" id="COD_INTERNO" value="<?php echo $COD_INTERNO; ?>" onChange="conMayusculas(this)" maxlength="12" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingresa Código Interno" style="width:60%; background:#CCCCCC " />					
                        <!--</div>-->
                    </div>
                </td>
                <td width="35%" align='center'> 
                    <strong>
                        <h4>REGISTRO DEL PROYECTO</h4>
                        INFORME TÉCNICO
                    </strong>
                </td>
                <td rowspan="2"></td>
                <td width="40%"></td>
            </tr>
            <tr>    <td align='center'> <strong>Déscripción Resumida de cada Proyecto y de los Mecanismos de Ejecucción</strong></td>
            </tr>
        </table>


        <legend style="color:#dddddd"></legend>



        <div class="control-group">
            <label class="control-label" for="DES_LARGA_PROYECTO">Descripción Larga: <span class="error">*</span></label>
            <div class="controls">
                <textarea <?php echo $Control_Bloqueo['DES_LARGA_PROYECTO']; ?> rows="2"  name="DES_LARGA_PROYECTO" id="DES_LARGA_PROYECTO" rows="5"  maxlength="500" class="xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese Descripción Larga" ><?php echo $DES_LARGA_PROYECTO; ?></textarea>				
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="IDE_ETAPA_CONTRATO">Fase - Componente:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_ETAPA_CONTRATO('IDE_ETAPA_CONTRATO', $DataSet_GEN_INTERVENCION_1, $IDE_ETAPA_CONTRATO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="DES_VIABILIDAD">Viabilidad: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_VIABILIDAD" id="DES_VIABILIDAD" value="<?php echo $DES_VIABILIDAD; ?>"  maxlength="200" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Viabilidad"/>					
            </div>
        </div>	


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <legend style="color:#dddddd"></legend>


        <table width='100%'>
            <tr>
                <td><strong>I. DESCRIPCION DE PROYECTO</strong> 
                    <br>
                    (Úbicación, Área de Intervención, Cuenca Hidrográfica, Número de PAM's, Stakeholder, etc )
                </td>
            </tr>

            <tr>
                <td>


                    <div class="control-group">
                        <label class="control-label" for="DES_UBICACION_PROYECTO">Ubicación de Proyecto: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_UBICACION_PROYECTO" id="DES_UBICACION_PROYECTO" rows="1"  maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Estatus" ><?php echo $DES_UBICACION_PROYECTO; ?></textarea>				                
            <!--<input  name="DES_UBICACION_PROYECTO" id="DES_UBICACION_PROYECTO" value="<?php echo $DES_UBICACION_PROYECTO; ?>"  maxlength="200" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Ubicación de Proyecto"/>-->					
                        </div>
                    </div>	


                    <div class="control-group">
                        <label class="control-label" for="DES_AREA_INTERVENCION">Área de intervención: <span class="error"></span></label>
                        <div class="controls">
                            <!--<input  name="DES_AREA_INTERVENCION" id="DES_AREA_INTERVENCION" value="<?php echo $DES_AREA_INTERVENCION; ?>"  maxlength="30" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Área de intervención"/>-->					
                            <textarea name="DES_AREA_INTERVENCION" id="DES_AREA_INTERVENCION" rows="1"  maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Estatus" ><?php echo $DES_AREA_INTERVENCION; ?></textarea>				                            
                        </div>
                    </div>								


                    <div class="control-group">
                        <label class="control-label" for="DES_CUENCA_HIDROGRAFICA">Cuenca Hidrográfica: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_CUENCA_HIDROGRAFICA" id="DES_CUENCA_HIDROGRAFICA" rows="1"  maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Estatus" ><?php echo $DES_CUENCA_HIDROGRAFICA; ?></textarea>				                            
                            <!--<input  name="DES_CUENCA_HIDROGRAFICA" id="DES_CUENCA_HIDROGRAFICA" value="<?php echo $DES_CUENCA_HIDROGRAFICA; ?>"  maxlength="80" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Cuenca Hidrográfica"/>-->					
                        </div>
                    </div>								


                    <div class="control-group">
                        <label class="control-label" for="NUM_PAMS">Nº PAMs: <span class="error"></span></label>
                        <div class="controls">
                            <input  name="NUM_PAMS" id="NUM_PAMS" value="<?php echo $NUM_PAMS; ?>"  maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Número de PAMs" style='width:14.5%;' />					
                        </div>
                    </div>								


                    <div class="control-group">
                        <label class="control-label" for="DES_STAKEHOLDER">Stakeholder: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_STAKEHOLDER" id="DES_STAKEHOLDER" rows="1"  maxlength="1000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Estatus" ><?php echo $DES_STAKEHOLDER; ?></textarea>				                            
                            <!--<input  name="DES_STAKEHOLDER" id="DES_STAKEHOLDER" value="<?php echo $DES_STAKEHOLDER; ?>"  maxlength="200" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Stakeholder"/>-->					
                        </div>
                    </div>								


                </td>
            </tr>
        </table>

        <legend style="color:#dddddd ; display:none"></legend>                



        <table width='100%' style="display:none">
            <tr>
                <td><strong>II. DESCRIPCION Y ESTATUS CONTRACTUAL AL CIERRE DEL TRIMESTRE</strong> 
                    <br>
                    ( Rellenar solo si el Proyecto cuenta con un Contrato por la Ejecución de la Consultoria, Obra Supervisión y/o Mantenimiento )
                </td>
            </tr>

            <tr>
                <td>            

                    <div class="control-group">
                        <label class="control-label" for="DES_ESTATUS">Estatus: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_ESTATUS" id="DES_ESTATUS" rows="2"  maxlength="4000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Estatus" ><?php echo $DES_ESTATUS; ?></textarea>				
                        </div>
                    </div>						

                </td>
            </tr>
        </table>                


        <legend style="color:#dddddd ; display:none"></legend>

        <table width='100%' style="display:none">
            <tr>
                <td><strong>III. ACCIONES DE GESTIÓN DEL PROYECTO</strong> 
                    <br>
                    ( Gestión de Consultorias, Ejecución de Consultorias, Ejecución de Obra, Supervisión de Obras, Operación, Mantenimiento y Post Cierre )
                </td>
            </tr>

            <tr>
                <td>
                    <div class="control-group">
                        <label class="control-label" for="DES_ACCION_GESTION">Acción de Gestión: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_ACCION_GESTION" id="DES_ACCION_GESTION" rows="8"  maxlength="4000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Acción de Gestión" ><?php echo $DES_ACCION_GESTION; ?></textarea>				
                        </div>
                    </div>	
                </td>
            </tr>
        </table>     


        <legend style="color:#dddddd "></legend>

        <table width='100%' >
            <tr>
                <td><strong>II. GESTIÓN SOCIAL</strong> 
                    <br>
                    ( Describir los Objetivos, Indicadores, Metas, Acciones y Resultados )
                </td>
            </tr>

            <tr>
                <td>

                    <div class="control-group">
                        <label class="control-label" for="DES_ACCION_GESTION_SOCIAL">Objetivo General de la Gestion Social: <span class="error"></span></label>
                        <div class="controls"> 
                            <textarea name="DES_ACCION_GESTION_SOCIAL" id="DES_ACCION_GESTION_SOCIAL" rows="1"  maxlength="4000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Acción de Gestión Social" ><?php echo $DES_ACCION_GESTION_SOCIAL; ?></textarea>				
                        </div>
                    </div>						

                </td>
            </tr>
        </table>
        
        <br>
        
        <div class="control-group">
            <label class="control-label" for="DES_ACCION_GESTION_SOCIAL"><span class="error"></span></label>
            <div class="controls"> 
                <table width='50%' >
                    <tr>
                        <td><button type=button  onclick="AbrirObjEsp(<?php echo $IDE_PROYECTO ;?>)" title = "boton1" style='width:90%;' >Objetivos Espefíficos</button>
                        </td>

                        <td><button type=button  onclick="AbrirAccGes(<?php echo $IDE_PROYECTO ;?>)" title = "boton2" style='width:90%;' >Principales Acciones de Gestión</button>
                        </td>

                        <td><button type=button  onclick="AbrirAccCor(<?php echo $IDE_PROYECTO ;?>)" title = "boton3" style='width:90%;' >Acciones Correctivas</button>
                        </td>
                    </tr>

                    <tr>
                        <td><button type=button  onclick="AbrirOpoMej(<?php echo $IDE_PROYECTO ;?>)" title = "boton4" style='width:90%;' >Oportunidades de Mejora</button>
                        </td>

                        <td><button type=button  onclick="AbrirCosCom(<?php echo $IDE_PROYECTO ;?>)" title = "boton5" style='width:90%;' >Costos Proy. por Componente</button>
                        </td>

                        <td><button type=button  onclick="AbrirSegPry(<?php echo $IDE_PROYECTO ;?>)" title = "boton6" style='width:90%;' >Seguimiento del Proyecto</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br>
        
        

        <legend style="color:#dddddd ; display:none"></legend>

        <table width='100%' style="display:none">
            <tr>
                <td><strong>V. ACCIONES CORRECTIVAS</strong> 
                    <br>
                    ( Acciones Planteadas en el Proximo Trimestre para atender alguna desviación en el Programa de Remedicación de los PAM's )
                </td>
            </tr>

            <tr>
                <td>

                    <div class="control-group">
                        <label class="control-label" for="DES_ACCION_CORRECTIVA">Acción Correctiva: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_ACCION_CORRECTIVA" id="DES_ACCION_CORRECTIVA" rows="5"  maxlength="4000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Acción Correctiva" ><?php echo $DES_ACCION_CORRECTIVA; ?></textarea>				
                        </div>
                    </div>						

                </td>
            </tr>
        </table> 


        <legend style="color:#dddddd ; display:none"></legend>

        <table width='100%' style="display:none">
            <tr>
                <td><strong>VI. OPORTUNIDADES DE MEJORA Y ANALSIS</strong> 
            </tr>

            <tr>
                <td>

                    <div class="control-group">
                        <label class="control-label" for="DES_OPORTUNIDAD_MEJORA">Oportunidad de Mejora: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_OPORTUNIDAD_MEJORA" id="DES_OPORTUNIDAD_MEJORA" rows="5"  maxlength="4000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Oportunidad de Mejora" ><?php echo $DES_OPORTUNIDAD_MEJORA; ?></textarea>				
                        </div>
                    </div>						


                </td>
            </tr>
        </table>


        <legend></legend>

        <div class="control-group">
            <label class="control-label" for="IDE_PORTAFOLIO">Portafolio:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_PORTAFOLIO('IDE_PORTAFOLIO', $DataSet_GEN_PORTAFOLIO_PROYECTO_1, $IDE_PORTAFOLIO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_PROGRAMA">Programa:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboIDE_PROGRAMA('IDE_PROGRAMA', $DataSet_GEN_PROGRAMA_PROYECTO_1, $IDE_PROGRAMA, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_CENCOSTO">Centro de Costo:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboIDE_CENCOSTO('IDE_CENCOSTO', $DataSet_GEN_CENTRO_COSTO_1, $IDE_CENCOSTO, 1, $Control_Bloqueo['IDE_CENCOSTO']) ?>				
            </div>
        </div>  						


        <legend style="color:#dddddd"></legend>


        <table width='100%'>
            <tr>
                <td><strong>DETALLES DEL PROYECTO DE INVERSIÓN PÚBLICA</strong>
                </td>
            </tr>

            <tr>
                <td>


                    <div class="control-group">
                        <label class="control-label" for="COD_UNICO">Código Único: <span class="error"></span></label>
                        <div class="controls">
                            <input <?php echo $Control_Bloqueo['COD_UNICO']; ?>   name="COD_UNICO" id="COD_UNICO" value="<?php echo $COD_UNICO; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingresa Código Único" style='width:14.5%;' />					
                        </div>
                    </div>								


                    <div class="control-group">
                        <label class="control-label" for="COD_SNIP">Código SNIP: <span class="error"></span></label>
                        <div class="controls">
                            <input <?php echo $Control_Bloqueo['COD_SNIP']; ?>   name="COD_SNIP" id="COD_SNIP" value="<?php echo $COD_SNIP; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código SNIP" style='width:14.5%;' />					
                        </div>
                    </div>								


                    <div class="control-group">
                        <label class="control-label" for="TIP_PROYECTO">Tipo de Proyecto:<span class="error"></span></label>
                        <div class="controls"> 
                            <?php comboTIP_PROYECTO('TIP_PROYECTO', $DataSet_GEN_TABLAS_2, $TIP_PROYECTO, 1, " style='width: 51%;' ") ?>				
                        </div>
                    </div> 


                    <div class="control-group" style="display:none">
                        <label class="control-label" for="DES_UNIDAD_FORMULADORA">Unidad Formuladora: <span class="error"></span></label>
                        <div class="controls">
                            <input <?php echo $Control_Bloqueo['DES_UNIDAD_FORMULADORA']; ?>  name="DES_UNIDAD_FORMULADORA" id="DES_UNIDAD_FORMULADORA" value="<?php echo $DES_UNIDAD_FORMULADORA; ?>"  maxlength="200" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Unidad Formuladora"/>					
                        </div>
                    </div>


                    <div class="control-group" style="display:none">
                        <label class="control-label" for="IDE_ENTIDAD_EJECUTORA">Sede Ejecutora:<span class="error">*</span></label>
                        <div class="controls"> 
                            <?php comboIDE_ENTIDAD_EJECUTORA('IDE_ENTIDAD_EJECUTORA', $DataSet_GEN_ENTIDAD_1, $IDE_ENTIDAD_EJECUTORA, 1, " style='width: 51%;' ") ?>				
                        </div>
                    </div> 



                    <div class="control-group" style="display:none">
                        <label class="control-label" for="TIP_MONEDA">Tipo Moneda:<span class="error"></span></label>
                        <div class="controls"> 
                            <?php comboTIP_MONEDA('TIP_MONEDA', $DataSet_GEN_TABLAS_1, $TIP_MONEDA, 1, $Control_Bloqueo['TIP_MONEDA']) ?>				
                        </div>
                    </div>  						


                    <div class="control-group">
                        <label class="control-label" for="IMP_APROBADO_LOC">Monto Aprobado Local: <span class="error"></span></label>
                        <div class="controls">
                            <input <?php echo $Control_Bloqueo['IMP_APROBADO_LOC']; ?>  name="IMP_APROBADO_LOC" id="IMP_APROBADO_LOC" value="<?php echo FormatoMonedas($IMP_APROBADO_LOC); ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number  show-popover" data-trigger="hover" data-content="Ingrese Monto Aprobado Local" style='width:14.5%;' />					
                        </div>
                    </div>								


                    <div class="control-group" style="display:none">
                        <label class="control-label" for="IMP_APROBADO_EXT">Monto Aprobado (Ext): <span class="error"></span></label>
                        <div class="controls">
                            <input <?php echo $Control_Bloqueo['IMP_APROBADO_EXT']; ?>  name="IMP_APROBADO_EXT" id="IMP_APROBADO_EXT" value="<?php echo FormatoMonedas($IMP_APROBADO_EXT); ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Monto Aprobado Extranjera" style='width:14.5%;' />					
                        </div>
                    </div>								


                    <div class="control-group">
                        <label class="control-label" for="FEC_APROBACION">Fecha Aprobación:<span class="error"></span></label>
                        <div class="controls">
                            <div class="span12">    
                                <input <?php echo $Control_Bloqueo['FEC_APROBACION']; ?> name="FEC_APROBACION" id="FEC_APROBACION" style="width: 10%" value="<?php echo $FEC_APROBACION; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha Aprobación" placeholder="DD/MM/YYYY"/>					
                            </div>
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="FEC_INICIO_PROY">Fecha Inicio:<span class="error"></span></label>
                        <div class="controls">
                            <div class="span12">    
                                <input <?php echo $Control_Bloqueo['FEC_INICIO_PROY']; ?> name="FEC_INICIO_PROY" id="FEC_INICIO_PROY" style="width: 10%" value="<?php echo $FEC_INICIO_PROY; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric  show-popover" data-trigger="hover" data-content="Seleccione Fecha Inicio" placeholder="DD/MM/YYYY"/>					
                            </div>
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="FEC_TERMINO_PROY">Fecha Término:<span class="error"></span></label>
                        <div class="controls">
                            <div class="span12">    
                                <input <?php echo $Control_Bloqueo['FEC_TERMINO_PROY']; ?> name="FEC_TERMINO_PROY" id="FEC_TERMINO_PROY" style="width: 10%" value="<?php echo $FEC_TERMINO_PROY; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric  show-popover" data-trigger="hover" data-content="Seleccione Fecha Término" placeholder="DD/MM/YYYY"/>					
                            </div>
                        </div>
                    </div>						



                    <div class="control-group">
                        <label class="control-label" for="NUM_BENEFICIARIOS">Nº Beneficiarios: <span class="error"></span></label>
                        <div class="controls">
                            <input  name="NUM_BENEFICIARIOS" id="NUM_BENEFICIARIOS" value="<?php echo $NUM_BENEFICIARIOS; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="Ingrese Número de Beneficiarios" style='width:14.5%;' />					
                        </div>
                    </div>							


                    <div class="control-group" style="display:none">
                        <label class="control-label" for="DES_CORTA_PROYECTO">Descripción Corta: <span class="error"></span></label>
                        <div class="controls">
                            <textarea name="DES_CORTA_PROYECTO" id="DES_CORTA_PROYECTO" rows="2"  maxlength="100" class="xlarge   show-popover"  data-trigger="hover" data-content="Descripción Corta" ><?php echo $DES_CORTA_PROYECTO; ?></textarea>				
                        </div>
                    </div>						


                    <div class="control-group">
                        <label class="control-label" for="DES_PROYECTO_ENGLISH">Descripción en Ingles: <span class="error"></span></label>
                        <div class="controls">
                            <textarea <?php echo $Control_Bloqueo['DES_PROYECTO_ENGLISH']; ?> name="DES_PROYECTO_ENGLISH" id="DES_PROYECTO_ENGLISH" rows="2"  maxlength="200" class="xlarge alphanumeric show-popover"  data-trigger="hover" data-content="Descripción en Ingles" ><?php echo $DES_PROYECTO_ENGLISH; ?></textarea>				
                        </div>
                    </div>	


                </td>
            </tr>
        </table>






        <div class="control-group" style="display:none">
            <label class="control-label" for="TIP_GRUPO_PROYECTO">Tipo de Grupo de Proyecto:<span class="error"></span></label>
            <div class="controls"> 
                <?php comboTIP_GRUPO_PROYECTO('TIP_GRUPO_PROYECTO', $DataSet_GEN_TABLAS_3, $TIP_GRUPO_PROYECTO, 1, "") ?>				
            </div>
        </div>  						


        <legend></legend>


        <div class="control-group">
            <label class="control-label" for="EST_PROYECTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_PROYECTO('EST_PROYECTO', $DataSet_GEN_TABLAS_4, $EST_PROYECTO, 1, $Control_Bloqueo['EST_PROYECTO']) ?>				
            </div>
        </div>  						



        <?php echo $crudGrabarCancelar; ?>


    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_PORTAFOLIO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_PORTAFOLIO > 0)) {
                if ($lstDatos[$i]->IDE_PORTAFOLIO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PORTAFOLIO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PORTAFOLIO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PORTAFOLIO . "\">" . $lstDatos[$i]->DES_PORTAFOLIO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_PROGRAMA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_PROGRAMA > 0)) {
                if ($lstDatos[$i]->IDE_PROGRAMA == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROGRAMA . "\" selected=\"selected\">" . $lstDatos[$i]->DES_PROGRAMA . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_PROGRAMA . "\">" . $lstDatos[$i]->DES_PROGRAMA . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_CENCOSTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_CENCOSTO > 0)) {
                if ($lstDatos[$i]->IDE_CENCOSTO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CENCOSTO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CENCOSTO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CENCOSTO . "\">" . $lstDatos[$i]->DES_CENCOSTO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_ENTIDAD_EJECUTORA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_ENTIDAD > 0)) {
                if ($lstDatos[$i]->IDE_ENTIDAD == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ENTIDAD . "\" selected=\"selected\">" . $lstDatos[$i]->DES_ENTIDAD . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_ENTIDAD . "\">" . $lstDatos[$i]->DES_ENTIDAD . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboIDE_ETAPA_CONTRATO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required"  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_MONEDA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Moneda" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_PROYECTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo de Proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_GRUPO_PROYECTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo de Grupo de Proyecto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_PROYECTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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