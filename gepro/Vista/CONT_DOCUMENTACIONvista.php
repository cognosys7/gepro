<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_DOCUMENTACIONVISTA de la tabla CONT_DOCUMENTACION
  //  Fecha           : lunes, 3 de junio de 2019 19:00:41
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/CONT_DOCUMENTACION.js"></script>    


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
                    $PIDE2 = $lCollection->Get('PIDE2');
                    $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                    $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
                    
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
                                <li><a href="#tabs-1">Listado de Documentación del Contrato</a></li>
                                <li><a href="#tabs-2">Detalle de Documentación del Contrato </a></li>
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
                                    <input type="hidden" name="PIDE2" value="<?php echo $PIDE2; ?>">
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&PIDE2=<?php echo $PIDE2; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Tipo Documento - Conocimiento del Proceso PMI', name: 'CONOC_PROC', width: GetColumnSize(25), sortable: true, align: 'left', hide: false},
                                                            {display: 'Fecha de Registro', name: 'FEC_DOCUMENTO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Ruta Contenido (SharePoint)', name: 'DES_DOCUMENTO', width: GetColumnSize(38.4), sortable: true, align: 'left', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            /*EDGAR*/
                                                            /*<?php //if( $pAuxiliar=='Anidado' ) {  ?>      {display: 'Valores', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'},   <?php //}  ?>   */
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Ver Contenido', name: 'Adjuntos', width: GetColumnSize(6), sortable: true, align: 'center', hide: false},
                                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
        <?php if ($VerSeleccion <> 'SI') { ?>               {name: 'Nuevo', bclass: 'nuevo', onpress: test}, <?php } ?>
                                                            {separator: true},
                                                            {name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Conocimiento del Proceso PMI', name: 'CONOC_PROC'},
                                                            {display: 'Fecha de Documento', name: 'FEC_DOCUMENTO'},
                                                            {display: 'Documento', name: 'DES_DOCUMENTO'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php echo Tabla_Proyecto_Datos($PIDE2) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ; ?>'    <?php } ?>
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


                $IDE_CONT_DOCUM = $lCollection->Get('IDE_CONT_DOCUM');
                $IDE_CONTRATO = $lCollection->Get('IDE_CONTRATO');
                $IDE_CONOC_PROC = $lCollection->Get('IDE_CONOC_PROC');
                $FEC_DOCUMENTO = $lCollection->Get('FEC_DOCUMENTO');
                $DES_DOCUMENTO = $lCollection->Get('DES_DOCUMENTO');
                $EST_DOCUMENTO = $lCollection->Get('EST_DOCUMENTO');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $PIDE2 = $lCollection->Get('PIDE2');
                $VIDE_CONTRATO = $lCollection->Get('VIDE_CONTRATO');
                $VIDE_INTERVENCION = $lCollection->Get('VIDE_INTERVENCION');
                
                /* para la herencia */
                $IDE_CONTRATO = $PIDE; //codigo superior autocompleta

                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');
//        $B_descripcion = $lCollection->Get('Bdescripcion');
                
                $DES_TIPO_DOCUMENTO = $lCollection->Get('DES_TIPO_DOCUMENTO');

                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
//        $BIDE = $Bdescripcion = "";
//        if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
//          $BIDE = $lCollection->Get('BIDE');;
//          $Bdescripcion = $lCollection->Get('Bdescripcion');
//        }
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                /* EDGAR */

                
                
                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1 = $lCollection->Get('DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1');


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Documentación"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Documentación"; //Nombre de la Tabla
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


        $('#FEC_DOCUMENTO').datepicker({
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
    //            alert('busquedas '+'<?php // echo $BIDE.'-<br>-'.$Bdescripcion ;  ?>');
    //            f.IDE.value = '<?php //echo $BIDE;  ?>';
    //            f.DES.value = '<?php //echo $Bdescripcion;  ?>';

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
        <input type="hidden" name="PIDE2" value="<?php echo $PIDE2; ?>">
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
    <?php
    if ($PIDE > 0) {
        echo Tabla_Proyecto_Datos($PIDE2) .'<hr>'. Tabla_Contrato_Datos($VIDE_CONTRATO). Tabla_Intervencion_Datos($VIDE_INTERVENCION) ;
        echo '<br>';
    }
    ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor_Text("IDE_tablaBUSCADO", $IDE_tablaBUSCADO, 'ESTANDAR', 'BUSCADO', 'B_descripcion', $B_descripcion, 'tablaBUSCADO' );  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONT_DOCUM">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONT_DOCUM" id="IDE_CONT_DOCUM" value="<?php echo $IDE_CONT_DOCUM; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONTRATO">Contrato: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_CONTRATO" id="IDE_CONTRATO" value="<?php echo $IDE_CONTRATO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Contrato"/>					
            </div>
        </div>								


<!--        <div class="control-group">
            <label class="control-label" for="IDE_CONOC_PROC">Conocimiento:<span class="error">*</span></label>
            <div class="controls"> 
    <?php // comboIDE_CONOC_PROC('IDE_CONOC_PROC', $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1, $IDE_CONOC_PROC, 1, " style='width: 51%;' ") ?>				
            </div>
        </div>  						-->


        <?php extraerIDEyValor_Text("IDE_CONOC_PROC", $IDE_CONOC_PROC, 'ESTANDAR', 'Tipo Documento (PMI)', 'DES_TIPO_DOCUMENTO', $DES_TIPO_DOCUMENTO, 'CONT_DOCUMENTACION', 'width:50%','VerValor','','required','readonly' );  ?>



        <div class="control-group">
            <label class="control-label" for="FEC_DOCUMENTO">Fecha:<span class="error"></span></label>
            <div class="controls">
                <div class="span12">    
                    <input name="FEC_DOCUMENTO" id="FEC_DOCUMENTO" style="width: 10%" value="<?php echo $FEC_DOCUMENTO; ?>" minlength="1" maxlength="10" type="text"  class="alphanumeric show-popover" data-trigger="hover" data-content="Seleccione Fecha" placeholder="DD/MM/YYYY"/>					
                </div>
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="DES_DOCUMENTO">Documento: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_DOCUMENTO" id="DES_DOCUMENTO" rows="5" onChange="conMayusculas(this)" maxlength="500"  data-trigger="hover" data-content="Ingrese Documento" ><?php echo $DES_DOCUMENTO; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="EST_DOCUMENTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_DOCUMENTO('EST_DOCUMENTO', $DataSet_GEN_TABLAS_1, $EST_DOCUMENTO, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
        
    </form>

                <?php
            }

            /*             * *********************************************************************************
             * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
             * ********************************************************************************* */

            function comboIDE_CONOC_PROC($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
                ?>    
    <select data-trigger="hover" data-content="Seleccione Conocimiento" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_CONOC_PROC > 0)) {
            if ($lstDatos[$i]->IDE_CONOC_PROC == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CONOC_PROC . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CRUCE_CONOC_PROC . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CONOC_PROC . "\">" . $lstDatos[$i]->DES_CRUCE_CONOC_PROC . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    function comboEST_DOCUMENTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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