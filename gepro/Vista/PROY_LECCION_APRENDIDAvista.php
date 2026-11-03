<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_LECCION_APRENDIDAVISTA de la tabla PROY_LECCION_APRENDIDA
  //  Fecha           : lunes, 3 de junio de 2019 8:23:58
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-JEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_LECCION_APRENDIDA.js"></script>    


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
                                <li><a href="#tabs-1">Listado de Lecciones Apredidas del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Lecciones Apredidas del Proyecto </a></li>
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
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Fase - Componente', name: 'DES_INTERVENCION', width: GetColumnSize(17), sortable: true, align: 'left', hide: false},
                                                            {display: 'Código de Lección', name: 'COD_LECCION_APRENDIDA', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Tipo Lección', name: 'TIP_LECCION', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Tipo Riesgo', name: 'DES_TIPO_RIESGO', width: GetColumnSize(7), sortable: true, align: 'left', hide: false},
                                                            {display: 'Causa', name: 'DES_LECCION_APRENDIDA', width: GetColumnSize(48.7), sortable: true, align: 'left', hide: false},
                                                            {display: 'Tipo Impacto', name: 'TIP_IMPACTO_SITUACION', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Efecto', name: 'DES_RECOMENDACION', width: GetColumnSize(0), sortable: true, align: 'left', hide: true},
                                                            {display: 'Respuesta Sugerida o Realizada', name: 'DES_ACCION_PROPUESTA', width: GetColumnSize(0), sortable: true, align: 'left', hide: true},
                                                            {display: 'Fecha Lección', name: 'FEC_LECCION', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
                                                                    /*<?php //if( $pAuxiliar=='Anidado' ) {   ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},   <?php //}   ?>   */
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
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
                                                            {display: 'Fase - Componente', name: 'DES_INTERVENCION'},
                                                            {display: 'Causa', name: 'DES_LECCION_APRENDIDA'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE); ?>'    <?php } ?>
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


    $IDE_LECCION_APRENDIDA = $lCollection->Get('IDE_LECCION_APRENDIDA');
    $IDE_PROYECTO = $lCollection->Get('IDE_PROYECTO');
    $IDE_FASE_COMPONENTE = $lCollection->Get('IDE_FASE_COMPONENTE');
    $COD_LECCION_APRENDIDA = $lCollection->Get('COD_LECCION_APRENDIDA');
    $TIP_LECCION = $lCollection->Get('TIP_LECCION');
    $IDE_TIPO_RIESGO = $lCollection->Get('IDE_TIPO_RIESGO');
    $DES_LECCION_APRENDIDA = $lCollection->Get('DES_LECCION_APRENDIDA');
    $DES_RIESGO = $lCollection->Get('DES_RIESGO');
    $TIP_IMPACTO_SITUACION = $lCollection->Get('TIP_IMPACTO_SITUACION');
    $DES_RECOMENDACION = $lCollection->Get('DES_RECOMENDACION');
    $DES_ACCION_PROPUESTA = $lCollection->Get('DES_ACCION_PROPUESTA');
    $FEC_LECCION = $lCollection->Get('FEC_LECCION');
    $EST_LECCION = $lCollection->Get('EST_LECCION');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');

    /* para la herencia */
    $IDE_PROYECTO = $PIDE; //codigo superior autocompleta

    /* para la visualizacion de busqueda */
    //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

    /* para el padre buscado */
    //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');

    $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//        $BIDE = $Bdescripcion = "";
//        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//          $BIDE = $lCollection->Get('BIDE');;
//          $Bdescripcion = $lCollection->Get('Bdescripcion');
//        }
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar');  
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_INTERVENCION_1 = $lCollection->Get('DataSet_GEN_INTERVENCION_1');


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


    $DataSet_GEN_TIPO_RIESGO_1 = $lCollection->Get('DataSet_GEN_TIPO_RIESGO_1');


    $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


    $DataSet_GEN_TABLAS_3 = $lCollection->Get('DataSet_GEN_TABLAS_3');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Lecciones Apredidas"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Lecciones Apredidas"; //Nombre de la Tabla
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


        $('#FEC_LECCION').datepicker({
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
        ////// para extraer datos
        function CompruebaPaseDatos()
        {
        var f = parent.document.formulario;
    //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;   ?>');
    //            f.IDE.value = '<?php //echo $BIDE;   ?>';
    //            f.DES.value = '<?php //echo $Bdescripcion;   ?>';

        parent.$.colorbox.close();
        }

    <?php if ($PIDEbuscado > 0) { ?>
            //CompruebaPaseDatos();
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



        <legend>
            <?php echo $TitulFormulario; ?> 
            <input type=button onclick="abrirArchivo('ProyectoLeccionAprendida_Ejemplo.pdf')" style="background:#d1f5e7;" value="Ver Ejemplo de llenado de Registro">
        </legend>  

        <!--/*EDGAR*/--> 
        <?php
        if ($PIDE > 0) {
            echo Tabla_Proyecto_Datos($PIDE);
            echo '<br>';
        }
        ?>
        <!--/*EDGAR*/-->

        <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_LECCION_APRENDIDA">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_LECCION_APRENDIDA" id="IDE_LECCION_APRENDIDA" value="<?php echo $IDE_LECCION_APRENDIDA; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_PROYECTO">IdeProyecto: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_PROYECTO" id="IDE_PROYECTO" value="<?php echo $IDE_PROYECTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number show-popover" data-trigger="hover" data-content="IdeProyecto"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="IDE_FASE_COMPONENTE">Fase - Componente:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboIDE_FASE_COMPONENTE('IDE_FASE_COMPONENTE', $DataSet_GEN_INTERVENCION_1, $IDE_FASE_COMPONENTE, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="COD_LECCION_APRENDIDA">Código de Leccion: <span class="error"></span></label>
            <div class="controls">
                <input  name="COD_LECCION_APRENDIDA" id="COD_LECCION_APRENDIDA" value="<?php echo $COD_LECCION_APRENDIDA; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Código de Leccion" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="TIP_LECCION">Tipo Lección:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_LECCION('TIP_LECCION', $DataSet_GEN_TABLAS_1, $TIP_LECCION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="IDE_TIPO_RIESGO">Tipo Riesgo :<span class="error"></span></label>
            <div class="controls"> 
                <?php comboIDE_TIPO_RIESGO('IDE_TIPO_RIESGO', $DataSet_GEN_TIPO_RIESGO_1, $IDE_TIPO_RIESGO, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						

        <div class="control-group">
            <label class="control-label" for="DES_RIESGO">Descripción de Riesgos: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_RIESGO" id="DES_RIESGO" rows="4" onChange="conMayusculas(this)" maxlength="2000" class="xlarge   show-popover"  data-trigger="hover" data-content="Ingrese Descripción de Riesgo" ><?php echo $DES_RIESGO; ?></textarea>				
            </div>
        </div>
        
        

        <div class="control-group">
            <label class="control-label" for="DES_LECCION_APRENDIDA">Causa: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_LECCION_APRENDIDA" id="DES_LECCION_APRENDIDA" rows="4" onChange="conMayusculas(this)" maxlength="2000" class="xlarge  required show-popover"  data-trigger="hover" data-content="Ingrese Descripción de Causa" ><?php echo $DES_LECCION_APRENDIDA; ?></textarea>				
            </div>
        </div>						

	

        <div class="control-group">
            <label class="control-label" for="TIP_IMPACTO_SITUACION">Tipo de Impacto:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboTIP_IMPACTO_SITUACION('TIP_IMPACTO_SITUACION', $DataSet_GEN_TABLAS_2, $TIP_IMPACTO_SITUACION, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group">
            <label class="control-label" for="DES_RECOMENDACION">Efecto: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_RECOMENDACION" id="DES_RECOMENDACION" rows="4" onChange="conMayusculas(this)" maxlength="2000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Efecto" ><?php echo $DES_RECOMENDACION; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="DES_ACCION_PROPUESTA">Respuesta Sugerida o Realizada: <span class="error"></span></label>
            <div class="controls">
                <textarea name="DES_ACCION_PROPUESTA" id="DES_ACCION_PROPUESTA" rows="4" onChange="conMayusculas(this)" maxlength="2000" class="xlarge  show-popover"  data-trigger="hover" data-content="Ingrese Respuesta Sugerida o Realizada" ><?php echo $DES_ACCION_PROPUESTA; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="FEC_LECCION">Fecha Lección:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_LECCION" id="FEC_LECCION" style="width: 10%" value="<?php echo $FEC_LECCION; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric required show-popover"  data-trigger="hover" data-content="Seleccione Fecha Lección" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_LECCION">Estado:<span class="error">*</span></label>
            <div class="controls"> 
                <?php comboEST_LECCION('EST_LECCION', $DataSet_GEN_TABLAS_3, $EST_LECCION, 1, "") ?>				
            </div>
        </div>  						


        
        <?php echo $crudGrabarCancelar; ?> 
        
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboIDE_FASE_COMPONENTE($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Fase - Componente" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboTIP_LECCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Lección" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboIDE_TIPO_RIESGO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo Riesgo " id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?>  name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
        <?php
        $lOption = "";
        for ($i = 0; $i < count($lstDatos); $i++) {
            if (strlen($lstDatos[$i]->IDE_TIPO_RIESGO > 0)) {
                if ($lstDatos[$i]->IDE_TIPO_RIESGO == $valorInicial) {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_TIPO_RIESGO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_TIPO_RIESGO . "</option>\n\r";
                } else {
                    $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_TIPO_RIESGO . "\">" . $lstDatos[$i]->DES_TIPO_RIESGO . "</option>\n\r";
                }
            }
        }
        echo $lOption;
        ?>
    </select>
    <?php
}

function comboTIP_IMPACTO_SITUACION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Tipo de Impacto" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_LECCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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