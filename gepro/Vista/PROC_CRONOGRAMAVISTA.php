<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROCESOVISTA de la tabla PROC_CRONOGRAMA
  //  Fecha           : jueves, 2 de noviembre de 2017 23:30:03
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROC_CRONOGRAMA.js"></script>    
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
                                <li><a href="#tabs-1">Listado de Cronograma de Proceso</a></li>
                                <li><a href="#tabs-2">Detalle de de Cronograma de Proceso</a></li>
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
                                            <!--
                                            <table class="table table-hover table-nomargin table-bordered">
                                                <tr>
                                                    
                                                    <th style="width: 25%">Código del Proceso</th>
                                                    <td style="width: 75%"><?php echo $VIDE_CONVOCATORIA;     ?></td>
                                                </tr>                                                
                                                <tr>
                                                    <th style="width: 25%">Objeto de Contratación</th>
                                                    <td style="width: 75%"><?php echo $VDES_OBJETO;     ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 25%">Valor Referencial</th>
                                                    <td style="width: 75%"><?php echo $VIMP_VAL_REFERENCIAL;     ?></td>
                                                </tr>                                                
                                            </table>
                                            -->
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&Proceso=<?php echo $Proceso; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Código Proc.', name: 'IDE_CONVOCATORIA', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº Convocatoria', name: 'NUM_CONVOCATORIA', width: GetColumnSize(10), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Orden', name: 'IDE_ORDEN', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Publicación', name: 'FEC_PUBLICACION', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Actividad', name: 'DES_ACTIVIDAD', width: GetColumnSize(39.9), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Inicio', name: 'FEC_INICIO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Finalización', name: 'FEC_TERMINO', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nº', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
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
                                                                    {display: 'Actividad', name: 'DES_ACTIVIDAD'}
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
                                                } else if (com == 'Salir')
                                                {
                                                    cerrarPopup()
                                                } else
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

    //$IDE_CRONOGRAMA = $lCollection->Get('IDE_CRONOGRAMA');
    $IDE_CONVOCATORIA = $lCollection->Get('IDE_CONVOCATORIA');
    $NUM_CONVOCATORIA = $lCollection->Get('NUM_CONVOCATORIA');
    $IDE_ORDEN = $lCollection->Get('IDE_ORDEN');
    $FEC_PUBLICACION = $lCollection->Get('FEC_PUBLICACION');
    $DES_ACTIVIDAD = $lCollection->Get('DES_ACTIVIDAD');
    $FEC_INICIO = $lCollection->Get('FEC_INICIO');
    $FEC_TERMINO = $lCollection->Get('FEC_TERMINO');
    $EST_PROC_CRONOGRAMA = $lCollection->Get('EST_PROC_CRONOGRAMA');
    
    $VIDE_CONVOCATORIA = $lCollection->Get('VIDE_CONVOCATORIA');    
    $VDES_OBJETO = $lCollection->Get('VDES_OBJETO');
    $VIMP_VAL_REFERENCIAL = $lCollection->Get('VIMP_VAL_REFERENCIAL');
    //Paso AGREGADO EN CASO SE USA UN FORMULARIOO PADRE    
    $Proceso = $lCollection->Get('Proceso');
     
    
    /* EDGAR */
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */
    $DataSet_GEN_TABLAS=$lCollection->Get('DataSet_GEN_TABLAS');



    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar PROC_CRONOGRAMA"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de PROC_CRONOGRAMA"; //Nombre de la Tabla
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
            $('#FEC_INICIO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });
            $('#FEC_TERMINO').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                maxDate: '1095',
                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100'
            });

        });
    </script>        
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">        
        <!-- paso -->
        <input type="hidden" name="Proceso" value="<?php echo $Proceso ?>">
        <input type="hidden" name="IDE_CONVOCATORIA" value="<?php echo $VIDE_CONVOCATORIA ?>">
        <legend><?php echo $TitulFormulario; ?></legend>  

        <div class="control-group">
            <label class="control-label" for="IDE_CONVOCATORIA2">Código Proceso: <span class="error">*</span></label>
            <div class="controls">
                <input disabled name="IDE_CONVOCATORIA2" id="IDE_CONVOCATORIA2" value="<?php echo $VIDE_CONVOCATORIA; ?>" onChange="conMayusculas(this)" maxlength="10" type="text" class="integer" data-trigger="hover" data-content=""/>
            </div>
        </div>		
        
        <div class="control-group">
            <label class="control-label" for="VDES_OBJETO">Proceso: <span class="error">*</span></label>
            <div class="controls">
                <input disabled name="VDES_OBJETO" id="PROCESO" value="<?php echo $VDES_OBJETO; ?>" onChange="conMayusculas(this)" maxlength="500" type="text" class="input-xlarge alphanumeric " data-trigger="hover" data-content=""/>
            </div>
        </div>	
        
        <div class="control-group" style="display:none">
            <label class="control-label" for="NUM_CONVOCATORIA">Nº Convocatoria: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_CONVOCATORIA" id="NUM_CONVOCATORIA" value="<?php echo $NUM_CONVOCATORIA; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer " data-trigger="hover" data-content=""/>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="IDE_ORDEN">Nº Orden: <span class="error">*</span></label>
            <div class="controls">
                <input  name="IDE_ORDEN" id="IDE_ORDEN" value="<?php echo $IDE_ORDEN; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer required" data-trigger="hover" data-content=""/>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="FEC_PUBLICACION">Fecha de Publicación:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_PUBLICACION" id="FEC_PUBLICACION" style="width: 10%" value="<?php echo $FEC_PUBLICACION; ?>" minlength="1" maxlength="10" type="text" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="DES_ACTIVIDAD">Actividad: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_ACTIVIDAD" id="DES_ACTIVIDAD" value="<?php echo $DES_ACTIVIDAD; ?>" onChange="conMayusculas(this)" maxlength="40" type="text" class="input-xlarge alphanumeric required" data-trigger="hover" data-content=""/>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="FEC_INICIO">Fecha de Inicio:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_INICIO" id="FEC_INICIO" style="width: 10%" value="<?php echo $FEC_INICIO; ?>" minlength="1" maxlength="10" type="text" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese la Fecha de Inicio de la Actividad" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="FEC_TERMINO">Fecha de Finalización:<span class="error">*</span></label>
            <div class="controls">
                <div class="span12">                        
                    <input name="FEC_TERMINO" id="FEC_TERMINO" style="width: 10%" value="<?php echo $FEC_TERMINO; ?>" minlength="1" maxlength="10" type="text" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese la Fecha de Finalización de la Actividad" placeholder="DD/MM/YYYY"/>
                </div>
            </div>
        </div>		
        <div class="control-group">
            <label class="control-label" for="EST_PROC_CRONOGRAMA">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_PROC_CRONOGRAMA('EST_PROC_CRONOGRAMA', $DataSet_GEN_TABLAS, $EST_PROC_CRONOGRAMA, 1, "") ?>				
            </div>
        </div>  				


         

        <?php echo $crudGrabarCancelar; ?> 

 
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_PROC_CRONOGRAMA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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