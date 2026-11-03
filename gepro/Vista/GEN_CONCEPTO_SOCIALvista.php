<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_CONCEPTO_SOCIALVISTA de la tabla GEN_CONCEPTO_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 20:51:18
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-GEtiqueta
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/GEN_CONCEPTO_SOCIAL.js"></script>    


    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <!--/*EDGAR*/-->
    <!--<link rel="stylesheet" type="text/css" href="../lib/css/include.css" />-->
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
        $pAuxiliar = $lCollection->Get('pAuxiliar');
        $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');
        $Recursiva_hide = $lCollection->Get('Recursiva_hide');
        //$DatosPadre  =   array(
        //      'Tabla'           =>  $lCollection->Get('VDES_ITEM'),
        //      'Abreviatura'     =>  $lCollection->Get('VDES_ABREVIATURA')
        //  );
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
                                <li><a href="#tabs-1">Listado de Conceptos Sociales </a></li>
                                <li><a href="#tabs-2">Detalle de Conceptos Sociales </a></li>
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
                                    <input type="hidden" name="Recursiva_Nivel_Actual" value="<?php echo $Recursiva_Nivel_Actual; ?>">
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
                                                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&PIDE=<?php echo $PIDE; ?>&Recursiva_Nivel_Actual=<?php echo $Recursiva_Nivel_Actual; ?>&Pedido=<?php echo $Pedido; ?>',
                                                            /* Tipo de datos devuelto json, xml */
                                                            dataType: 'json',
                                                            /* Metodo de Envio de  Datos*/
                                                            method: 'POST',
                                                            /* Lista de campo a mostrar en cada columna */
                                                            colModel: [
                                                            {display: 'Ide', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                            {display: 'Rubro', name: 'RUBRO', width: GetColumnSize(25), sortable: true, align: 'left', hide: false},
                                                            {display: 'Concepto', name: 'DES_CONCEPTO', width: GetColumnSize(25), sortable: true, align: 'left', hide: false},
                                                            {display: 'Abreviatura', name: 'DES_CONCEPTO_ABREVIATURA', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Unidad de Medida', name: 'TIP_UNIDAD_MEDIDA', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                            {display: 'Nivel', name: 'NUM_NIVEL', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Estado', name: 'Estado', width: GetColumnSize(7), sortable: true, align: 'center', hide: false},
                                                            {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                                                    /*EDGAR*/
        <?php if( $pAuxiliar=='Anidado' ) {  ?>             {display: 'Valores', name: 'Anidado', width: GetColumnSize(5), sortable: false, align: 'center' , hide: <?php echo $Recursiva_hide; ?> }, <?php } ?>
        <?php if ($VerSeleccion == 'SI') { ?>               {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(6), sortable: false, align: 'center'}
        <?php } else { ?>                                   {display: 'Editar', name: 'Boton1', width: GetColumnSize(6), sortable: false, align: 'center'},
                                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(6), sortable: false, align: 'center', hide: <?php echo $crudEliminar; ?> }
        <?php } ?>
                                                            /*EDGAR*/
                                                            ],
                                                            /*Botones de Enlace*/
                                                            buttons: [
                                                            {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                            {separator: true}
                                                            ,{name: 'Salir', bclass: 'salir', onpress: test}
                                                            ],
                                                            /*Lista de campo que se podra hacer busqueda */

                                                            searchitems: [
                                                            {display: 'Rubro', name: 'IDE_RUBRO'},
                                                            {display: 'Concepto', name: 'DES_CONCEPTO'},
                                                            {display: 'Abreviatura', name: 'DES_CONCEPTO_ABREVIATURA'},
                                                            {display: 'Unidad de Medida', name: 'TIP_UNIDAD_MEDIDA'},
                                                            {display: 'Nivel', name: 'NUM_NIVEL'},
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
        <?php if ($PIDE > 0) { ?>, title: '<?php //visTabla_DatosPadre($DatosPadre);  ?>'    <?php } ?>
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


                $IDE_CONCEPTO = $lCollection->Get('IDE_CONCEPTO');
                $DES_CONCEPTO = $lCollection->Get('DES_CONCEPTO');
                $DES_CONCEPTO_ABREVIATURA = $lCollection->Get('DES_CONCEPTO_ABREVIATURA');
                $TIP_UNIDAD_MEDIDA = $lCollection->Get('TIP_UNIDAD_MEDIDA');
                $NUM_NIVEL = $lCollection->Get('NUM_NIVEL');
                $EST_CONCEPTO = $lCollection->Get('EST_CONCEPTO');
                $IDE_RUBRO = $lCollection->Get('IDE_RUBRO');


                /* EDGAR */
                $PIDE = $lCollection->Get('PIDE');
                $Recursiva_Nivel_Actual = $lCollection->Get('Recursiva_Nivel_Actual');
                $NUM_NIVEL = $Recursiva_Nivel_Actual;
                $IDE_RUBRO = $PIDE ;// $lCollection->Get('VIDE_RUBRO');
                
                //$DatosPadre  =   array(
                //   'Tabla'           =>  $lCollection->Get('VDES_ITEM'),
                //   'Abreviatura'     =>  $lCollection->Get('VDES_ABREVIATURA')
                //   ,'VCOD_TABLA'     =>  $lCollection->Get('VCOD_TABLA')
                //  );

                /* para la herencia */
                //$IDE_PROYECTO = $PIDE; //codigo superior autocompleta

                /* para la visualizacion de busqueda */
                //$PIDEvisualiza = ( $PIDE>0 ? 'style="display:none"' : '' ) ;

                /* para el padre buscado */
                //$DES_COMUNIDAD=''; =$lCollection->Get('VDES_COMUNIDAD');

                $PIDEbuscado = $lCollection->Get('PIDEbuscado');
                $VIDE_COMUNIDAD = $VDES_COMUNIDAD = "";
                if ($PIDEbuscado > 0) {  //echo 'es un echo';exit;
                    $VIDE_COMUNIDAD = $PIDEbuscado;
                    $VDES_COMUNIDAD = $lCollection->Get('VDES_COMUNIDAD');
                }
                
                $crudGrabarCancelar = $lCollection->Get('crudGrabarCancelar'); 
                /* EDGAR */

                /* LECTURANDO DATOS DE LAS TABLAS AUXILIARES - LISTBOX */


                $DataSet_GEN_TABLAS_1 = $lCollection->Get('DataSet_GEN_TABLAS_1');


                $DataSet_GEN_TABLAS_2 = $lCollection->Get('DataSet_GEN_TABLAS_2');


                $DataSet_GEN_CONCEPTO_SOCIAL_1 = $lCollection->Get('DataSet_GEN_CONCEPTO_SOCIAL_1');




                if (strlen($SeleccionarID) > 0) {
                    //ACTUALIZAR
                    $ActionFormulario = "ActualizarForm";
                    $Btn = "Actualizar";
                    $TitulFormulario = "Actualizar Conceptos Sociales"; //Nombre de la Tabla
                } else {
                    //INSERT
                    $ActionFormulario = "RegistraDatos";
                    $Btn = "Registrar";
                    $TitulFormulario = "Registro de Conceptos Sociales"; //Nombre de la Tabla
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
    //            alert('por a intervenciones'+'<?php // echo $VIDE_COMUNIDAD.'-<br>'.$VDES_COMUNIDAD ; ?>');
    //            f.IDE_COMUNIDAD.value = '<?php echo $VIDE_COMUNIDAD; ?>';
    //            f.DES_COMUNIDAD.value = '<?php echo $VDES_COMUNIDAD; ?>';

                parent.$.colorbox.close();
                }

    <?php if ($PIDEbuscado > 0) { ?>
            CompruebaPaseDatos();
    <?php } ?>

    </script>        
    <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario; ?>">
        <input type="hidden" name="SeleccionarID" value="<?php echo $SeleccionarID ?>">

        <!--/*EDGAR*/-->
        <input type="text" name="PIDE" value="<?php echo $PIDE ?>"> 
        <input type="hidden" name="varBotonInvocador" value="">       
        <!--/*EDGAR*/-->



        <legend><?php echo $TitulFormulario; ?></legend>  

        <!--/*EDGAR*/--> 
    <?php //visTabla_DatosPadre($DatosPadre);  ?>
        <!--/*EDGAR*/-->

    <?php //extraerIDEyValor("COD_UBIGEO", $COD_UBIGEO, 'ESTANDAR', 'UBIGEO', 'DES_UBIGEO', $DES_UBIGEO, 'UBIGEO', '', 'width:50%');  ?>




        <div class="control-group" style="display:none">
            <label class="control-label" for="IDE_CONCEPTO">Ide: <span class="error"></span></label>
            <div class="controls">

                <input  name="IDE_CONCEPTO" id="IDE_CONCEPTO" value="<?php echo $IDE_CONCEPTO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>

            </div>
        </div>		


        

        <div class="control-group"  >
            <label class="control-label" for="IDE_RUBRO">Rubro Superior:<span class="error"></span></label>
            <div class="controls"> 	
    
            <input  name="IDE_RUBRO" id="IDE_RUBRO" value="<?php echo $IDE_RUBRO; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" data-trigger="hover" data-content=""/>
			
            </div>
        </div>  						

        
        
        <div class="control-group">
            <label class="control-label" for="DES_CONCEPTO">Concepto: <span class="error">*</span></label>
            <div class="controls">
                <textarea name="DES_CONCEPTO" id="DES_CONCEPTO" rows="5" onChange="conMayusculas(this)" maxlength="200" class="xlarge alphanumeric required show-popover"  data-trigger="hover" data-content="Ingrese Concepto" ><?php echo $DES_CONCEPTO; ?></textarea>				
            </div>
        </div>						


        <div class="control-group">
            <label class="control-label" for="DES_CONCEPTO_ABREVIATURA">Abreviatura: <span class="error"></span></label>
            <div class="controls">
                <input  name="DES_CONCEPTO_ABREVIATURA" id="DES_CONCEPTO_ABREVIATURA" value="<?php echo $DES_CONCEPTO_ABREVIATURA; ?>" onChange="conMayusculas(this)" maxlength="20" type="text" class="alphanumeric show-popover" data-trigger="hover" data-content="Ingrese Abreviatura" style='width:13%;' />					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="TIP_UNIDAD_MEDIDA">Unidad de Medida:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboTIP_UNIDAD_MEDIDA('TIP_UNIDAD_MEDIDA', $DataSet_GEN_TABLAS_1, $TIP_UNIDAD_MEDIDA, 1, "") ?>				
            </div>
        </div>  						


        <div class="control-group" style="display:none">
            <label class="control-label" for="NUM_NIVEL">Nivel: <span class="error">*</span></label>
            <div class="controls">
                <input  name="NUM_NIVEL" id="NUM_NIVEL" value="<?php echo $NUM_NIVEL; ?>" onChange="conMayusculas(this)" maxlength="25" type="text" class="number required show-popover"  data-trigger="hover" data-content="Ingrese Nivel del Registro"/>					
            </div>
        </div>								


        <div class="control-group">
            <label class="control-label" for="EST_CONCEPTO">Estado:<span class="error">*</span></label>
            <div class="controls"> 
    <?php comboEST_CONCEPTO('EST_CONCEPTO', $DataSet_GEN_TABLAS_2, $EST_CONCEPTO, 1, "") ?>				
            </div>
        </div>  						


         

        <?php echo $crudGrabarCancelar; ?> 

  
    </form>

    <?php
}

/* * *********************************************************************************
 * (OPCIONAL)SECCION DE FUNCIONES AJAX PARA COMBOS QUE DEPENDEN DEL PARAMETRO IDE DE OTRO COMBO     
 * ********************************************************************************* */

function comboTIP_UNIDAD_MEDIDA($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
    ?>    
    <select data-trigger="hover" data-content="Seleccione Unidad de Medida" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> class="required" name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
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

function comboEST_CONCEPTO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
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

    function comboIDE_RUBRO($nombre, $lstDatos, $valorInicial, $habil, $estilo) {
        ?>    
    <select data-trigger="hover" data-content="Seleccione Rubro Superior" id="<?php echo $nombre; ?>" <?php if ($habil == 0) { ?>disabled="disabled"<?php } ?> name="<?php echo $nombre; ?>" <?php echo $estilo; ?> >
        <option value="">Seleccione una Opción</option>        
    <?php
    $lOption = "";
    for ($i = 0; $i < count($lstDatos); $i++) {
        if (strlen($lstDatos[$i]->IDE_CONCEPTO > 0)) {
            if ($lstDatos[$i]->IDE_CONCEPTO == $valorInicial) {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CONCEPTO . "\" selected=\"selected\">" . $lstDatos[$i]->DES_CONCEPTO . "</option>\n\r";
            } else {
                $lOption .= "<option value=\"" . $lstDatos[$i]->IDE_CONCEPTO . "\">" . $lstDatos[$i]->DES_CONCEPTO . "</option>\n\r";
            }
        }
    }
    echo $lOption;
    ?>
    </select>
        <?php
    }

    /*	*/