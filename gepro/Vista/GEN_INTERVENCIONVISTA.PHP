<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com - www.cognosys.com.pe
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_INTERVENCIONVISTA de la tabla GEN_INTERVENCION
  //  Fecha           : viernes, 3 de mayo de 2019 18:53:31
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-CEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_INTERVENCION.js"></script>    


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

                    /* EDGAR */
                    $PIDE = $lCollection->Get('PIDE');
                    $pAuxiliar = $lCollection->Get('pAuxiliar');
                    $DatosPadre  =   array(
//                        'Sector Superior'       =>  $lCollection->Get('VSector'),
//                        'Rubro Superior'        =>  $lCollection->Get('VDES_RUBRO'),
//                        'Intervención Superior' =>  $lCollection->Get('VDES_INTERVENCION'),
//                        'Nivel Superior'        =>  $lCollection->Get('VNUM_NIVEL'),
//                        'Estado'                =>  $lCollection->Get('VEstado')
                        'Registro Superior' =>  'NIVEL '.$lCollection->Get('VNUM_NIVEL').' - '.$lCollection->Get('VDES_INTERVENCION')
                      );
                    
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
                                <li><a href="#tabs-1">Listado de Etapas y Contratos del Proyecto </a></li>
                                <li><a href="#tabs-2">Detalle de Etapas y Contratos </a></li>
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
                                                                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>',
                                                                /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    {display: 'Sector', name: 'DES_SECTOR', width: GetColumnSize(18), sortable: true, align: 'left', hide: true},
                                                                    {display: 'Fase', name: 'INTERVENCION_SUP', width: GetColumnSize(20), sortable: true, align: 'left', hide: true},
                                                                    {display: 'Nº Nivel', name: 'NUM_NIVEL', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Nivel', name: 'DES_RUBRO', width: GetColumnSize(15), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Registro', name: 'DES_INTERVENCION', width: GetColumnSize(52.6), sortable: true, align: 'left', hide: false},
                                                                    {display: 'Estado', name: 'DES_ITEM', width: GetColumnSize(9), sortable: true, align: 'center', hide: false},
                                                                    {display: '', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
<?php if( $pAuxiliar=='Anidado' ) {  ?>                             {display: 'Valores', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'},   <?php }  ?>
                                                                    /*EDGAR*/
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true}
                                                                    ,{name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Sector', name: 'DES_SECTOR'},
                                                                    {display: 'Rubro', name: 'DES_RUBRO'},
                                                                    {display: 'IIntervención', name: 'DES_INTERVENCION'},
                                                                    {display: 'Estado', name: 'DES_ITEM'}
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
<?php if( $PIDE>0 ) {    ?>                                     ,title: '<?php visTabla_DatosPadre($DatosPadre);  ?>'    <?php }    ?> 
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


    $IDE_INTERVENCION = $lCollection->Get('IDE_INTERVENCION');
    $IDE_SECTOR = $lCollection->Get('IDE_SECTOR');
    $DES_INTERVENCION = $lCollection->Get('DES_INTERVENCION');
    $NUM_NIVEL = $lCollection->Get('NUM_NIVEL');
    $IDE_INTERVENCION_SUP = $lCollection->Get('IDE_INTERVENCION_SUP');
    $DES_RUBRO = $lCollection->Get('DES_RUBRO');
    $TIP_SECTOR_PIRCC = $lCollection->Get('TIP_SECTOR_PIRCC');
    $EST_INTERVENCION = $lCollection->Get('EST_INTERVENCION');


    /* EDGAR */
    $PIDE = $lCollection->Get('PIDE');
    $DatosPadre  =   array(
//        'Sector Superior'       =>  $lCollection->Get('VSector'),
//        'Rubro Superior'        =>  $lCollection->Get('VDES_RUBRO'),
//        'Intervención Superior' =>  $lCollection->Get('VDES_INTERVENCION'),
//        'Nivel Superior'        =>  $lCollection->Get('VNUM_NIVEL'),
//        'Estado'                =>  $lCollection->Get('VEstado')
        'Registro Superior' =>  'NIVEL '.$lCollection->Get('VNUM_NIVEL').' - '.$lCollection->Get('VDES_INTERVENCION')
//        ,'VIDE_INTERVENCION_SUP_regActual' =>  $lCollection->Get('VIDE_INTERVENCION_SUP_regActual'),
//        ,'VIDE_SECTOR'                =>  $lCollection->Get('VIDE_SECTOR')
      );
    $IDE_INTERVENCION_SUP = $lCollection->Get('VIDE_INTERVENCION_SUP_regActual'); //codigo superior autocompleta
    $IDE_SECTOR = $lCollection->Get('VIDE_SECTOR'); //codigo superior autocompleta
    $NUM_NIVEL = $lCollection->Get('VNUM_NIVEL') + 1 ; //codigo superior autocompleta
    
    $PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;
    
    $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
    /* EDGAR */

    /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


    $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');




    if (strlen($SeleccionarID) > 0) {
        //ACTUALIZAR
        $ActionFormulario = "ActualizarForm";
        $Btn = "Actualizar";
        $TitulFormulario = "Actualizar Intervenciones"; //Nombre de la Tabla
    } else {
        //INSERT
        $ActionFormulario = "RegistraDatos";
        $Btn = "Registrar";
        $TitulFormulario = "Registro de Intervenciones"; //Nombre de la Tabla
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
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="hidden" name="PIDE" value="<?php echo $PIDE ?>">        
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
<?php if( $PIDE>0 ) {     visTabla_DatosPadre($DatosPadre); echo '<br>'; } ?>
        <!--/*EDGAR*/-->



        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_INTERVENCION">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_INTERVENCION" id="IDE_INTERVENCION" value="<?php echo $IDE_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" data-trigger="hover" data-content="Ide"/>

            </div>
        </div>		


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_SECTOR">IdeSector: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_SECTOR" id="IDE_SECTOR" value="<?php echo $IDE_SECTOR; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer show-popover" data-trigger="hover" data-content="IdeSector"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_INTERVENCION">Intervención: <span class="error">*</span></label>
            <div class="controls">
                <input  name="DES_INTERVENCION" id="DES_INTERVENCION" value="<?php echo $DES_INTERVENCION; ?>" onChange="conMayusculas(this)" maxlength="150" type="text" class="alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Intervención"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="NUM_NIVEL">Nivel: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_NIVEL" id="NUM_NIVEL" value="<?php echo $NUM_NIVEL; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer required show-popover"  data-trigger="hover" data-content="Ingrese Nivel"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_INTERVENCION_SUP">IdeSuperior: <span class="error"></span></label>
            <div class="controls">
                <input  name="IDE_INTERVENCION_SUP" id="IDE_INTERVENCION_SUP" value="<?php echo $IDE_INTERVENCION_SUP; ?>" onChange="conMayusculas(this)" maxlength="8" type="text" class="integer show-popover" data-trigger="hover" data-content="IdeSuperior"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="DES_RUBRO">Rubro: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_RUBRO" id="DES_RUBRO" value="<?php echo $DES_RUBRO; ?>" onChange="conMayusculas(this)" maxlength="200" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Rubro"/>					
            </div>
        </div>								


        <div class="control-group" style="display:none">
            <label class="control-label" for="TIP_SECTOR_PIRCC">Tipo Sector: <span class="error"></span></label>
            <div class="controls">
                <input  name="TIP_SECTOR_PIRCC" id="TIP_SECTOR_PIRCC" value="<?php echo $TIP_SECTOR_PIRCC; ?>" onChange="conMayusculas(this)" maxlength="100" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Tipo Sector"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_INTERVENCION">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_INTERVENCION('EST_INTERVENCION', $DataSet_GEN_TABLAS_1, $EST_INTERVENCION, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboEST_INTERVENCION($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Estado" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <!--<option value="">Seleccione una Opción</option>-->        
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