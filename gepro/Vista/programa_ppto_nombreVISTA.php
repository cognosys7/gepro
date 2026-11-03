<?php
/* * ******************************************************************************
  //  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA
  //  Propósito       : programa_ppto_nombreVISTA de la tabla programa_ppto_nombre
  //  Fecha           : miércoles, 01 de noviembre de 2017 08:56:06 a.m.
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
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/programa_ppto_nombre.js"></script>    


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
                                <li><a href="#tabs-1">LISTADO DE PROGRAMAS PRESUPUESTALES </a></li>
                                <li><a href="#tabs-2">DETALLE DE PROGRAMA PRESUPUESTAL </a></li>
                            </ul>
                            <!--CONTENIDO DE LA PESTAÑA 1-->
                            <div id="tabs-1">


                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                    <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <!--/************** PARA BUSCAR EL UBIGEO    *************/-->
                                    <input type="hidden" name="ActionForm" value="PasarDatos">
                                    <input type="hidden" name="PIDE" value="">

                                    <input type="hidden" name="SeleccionarID" value="">
                                    

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
                                                                /*Pagina php donde se realiza la consulta sql */   													url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList', /* Tipo de datos devuelto json, xml */
                                                                dataType: 'json',
                                                                /* Metodo de Envio de  Datos*/
                                                                method: 'POST',
                                                                /* Lista de campo a mostrar en cada columna */
                                                                colModel: [
                                                                    {display: 'Programa Presupuestal', name: 'ID', width: GetColumnSize(10), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Anio', name: 'Anio', width: GetColumnSize(15), sortable: true, align: 'center', hide: false},
                                                                    {display: 'Definición Programa Presupuestal', name: 'DefinicionProgramaPTTO', width: GetColumnSize(60), sortable: true, align: 'left', hide: false},
                                                                    
                                                                    {display: 'Fila', name: 'NFILA', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
//                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(4), sortable: false, align: 'center'},
//                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(4), sortable: false, align: 'center'},
                                                                    {display: 'Seleccionar', name: 'Boton3', width: GetColumnSize(5), sortable: false, align: 'center'}
                                                                ],
                                                                /*Botones de Enlace*/
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
                                                                    {name: 'Salir', bclass: 'salir', onpress: test}
                                                                ],
                                                                /*Lista de campo que se podra hacer busqueda */

                                                                searchitems: [
                                                                    {display: 'Programa Presupuestal', name: 'ID'},
                                                                    {display: 'Definición Programa Presupuestal', name: 'DefinicionProgramaPTTO'}
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

function GeneraForm()
{
    
    $lCollection = Collection::Singleton();    
    
    $PANO_EJE = $lCollection->Get('PANO_EJE');
    $PPROGRAMA_PPTO = $lCollection->Get('PPROGRAMA_PPTO');
    $PNOMBRE = $lCollection->Get('PNOMBRE');
    $PDESCRIPCION_PROGRAMA_PPTO = $PANO_EJE." - ".$PPROGRAMA_PPTO." - ".$PNOMBRE ;
//  var_dump($lCollection);
?>
    <script type="text/javascript">    
//    alert("entre-javascript");    
        function CompruebaPaseDatos()
        {            
            var f = parent.document.formulario;            
//            alert("CompruebaPaseDatos");
            switch(f.btnPedido.value) {
                case 'DESCRIPCION_PROGRAMA_PPTO':
                    f.DESCRIPCION_PROGRAMA_PPTO.value = '<?php echo $PDESCRIPCION_PROGRAMA_PPTO ; ?>';
                    f.PROGRAMA_PPTO.value = '<?php echo $PPROGRAMA_PPTO; ?>';
                    break;
            }

            parent.$.colorbox.close();            
        
        }
        <?php         
        if ((strlen($PPROGRAMA_PPTO) > 0) and ($PPROGRAMA_PPTO <> ""))
        {
        ?>
            CompruebaPaseDatos();
        <?php
        }     ?>
    </script>
<?php
}
?>                