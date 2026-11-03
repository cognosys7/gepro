<?php

function muestraVista() {
    require_once("mensajes.php");
    $lCollection = Collection::Singleton();
    $descmsje         = "";
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $Tabs             = $lCollection->Get('Tabs');
    $PermisoOK        = $lCollection->Get('PermisoOK');
    $DatosPersona     = $lCollection->Get('DatosPersona');
    $Codigo           = $lCollection->Get('Codigo');
    $CodigoM          = $lCollection->Get('CodigoM');
    $CargaAsignacion  = $lCollection->Get('CargaAsignacion');
    $mensaje          = $lCollection->Get('Mensaje');
    if ($mensaje <> "") 
    {
        $descmsje = mensajesistema($mensaje);
    }
?>
 <!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <title><?php echo PRONIED;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--ESTILOS POR DEFAULT-->
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/css/estilos.css"  type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/flaty_rojo.css">
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.core.css"  type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.theme.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.tabs.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.deshab.css" type="text/css" media="screen"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/estilos_lightbox.css"  />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/colorbox/colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
        <!--JQUERY POR DEFAULT-->
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery/jquery.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Usuario.js"></script>
        <script type="text/javascript">
            function cerrarPopup() 
            {
                parent.$.colorbox.close();
            }
            function cerrarPerfil()
            {
                $("#tabs").tabs({disabled: [1]});
                $("#tabs").tabs({active: 0});
            }
        </script>
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs({active: <?php echo $Tabs;?>});
                <?php 
                if ($Tabs==1)
                {
                ?>
                $("#tabs").tabs({disabled: [0]});
                <?php
                }
                else
                {
                ?>
                $("#tabs").tabs({disabled: [1]});
                <?php
                }
                ?>
            });
        </script>
    </head>
    <body>
       <div class="row-fluid">
       
       <div class="span12">
            
           <?php 
            if ($PermisoOK <> 0)
            {
            ?>
            <div class="box">
                <?php
                if ($descmsje <> "") {
                    echo $descmsje . "<br>";
                }
                ?>
               <div class="box-content">
<!--                   <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                        <tr>
                            <td style="text-align: left; width: 80%; color: #770000;">&nbsp&nbsp<?php echo $DatosPersona?></td>
                            <td style="text-align: right; width: 20%;">
                            Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                            </td>
                        </tr>
                   </table>-->
                   <div id="tabs">
                       <ul>
                           <li><a href="#tabs-1">Listado de Softwares para <?php echo $DatosPersona?></a></li>
                           <li><a href="#tabs-2">Listado de Perfiles y Asignación Única para <?php echo $DatosPersona?></a></li>
                       </ul>
                       <div id="tabs-1">
                            <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                                <input type="hidden" name="Accion" value="muestraVista"/>
                                <input type="hidden" name="ActionForm" value=""/>
                                <input type="hidden" name="AccionLocal" value="1"/>
                                <input type="hidden" name="Codigo" value="<?php echo $Codigo;?>">
                                <input type="hidden" name="CodigoM" value="">
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
                                 </div>
                            </form>
                       </div>
                       <div id="tabs-2">
                            <form name="formularioGrid2" id="formularioGrid2" action="mainpage.php" method="post">
                                <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                                <input type="hidden" name="Accion" value="muestraVista"/>
                                <input type="hidden" name="ActionForm" value=""/>
                                <input type="hidden" name="AccionLocal" value="1"/>
                                <input type="hidden" name="Codigo" value="<?php echo $Codigo;?>">
                                <input type="hidden" name="CodigoM" value="<?php echo $CodigoM;?>">
                                <input type="hidden" name="CodigoP" value="">
                                <div id="contenedor2">        
                                     <div id="fila2">
                                         <div class="limpiar"></div>
                                     </div>
                                     <div class="msjinformacion" id="mensaje">
                                         Seleccione un registro para editar Asignacion única
                                     </div>
                                     <div id="datos2">
                                         <table id="flex2" style="display:none">
                                         </table>
                                     </div>
                                 </div>
                            </form>
                       </div>
                   </div>
               </div>
            </div>
            <?php 
            }
            else
            {
                echo "<br><br><center>UD. NO TIENE ACCESO A ESTE MÓDULO</center><br>";
            }
            ?>
       </div>
       </div> 
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.core.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.widget.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.tabs.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid.js"></script>
        
        <!--VALIDACION-->
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/validacion/jquery.validate.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/validacion/reglas.js"></script>
        <script type="text/javascript">
        $("#flex1").flexigrid
        (
                {
                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonList',
                    dataType: 'json',
                    method: 'POST',
                    colModel: [
                        {display: 'ID', name: 'ID', width: GetColumnSize(8), sortable: true, align: 'center', hide: true},
                        {display: 'IDMODULO', name: 'idmodulo', width: GetColumnSize(8), sortable: true, align: 'left', hide: true},
                        {display: 'Software', name: 'sisnombre', width: GetColumnSize(37), sortable: true, align: 'left'},
                        {display: 'Abreviatura', name: 'sisabreviatura', width: GetColumnSize(15), sortable: true, align: 'left'},
                        {display: 'Modulo', name: 'modnombre', width: GetColumnSize(33.8), sortable: true, align: 'left'},
                        {display: 'MODIFICAR', name: 'Boton1', width: GetColumnSize(8), sortable: false, align: 'center', hide: true},
                        {display: 'ELIMINAR', name: 'Boton2', width: GetColumnSize(8), sortable: false, align: 'center', hide: true},
                        {display: 'Asignar Perfil', name: 'Boton3', width: GetColumnSize(14), sortable: false, align: 'center'},
                    ],
                    buttons: [
                        {name: 'Salir', bclass: 'salir', onpress: test},
                        {separator: true}

                    ],
                    searchitems: [
                        {display: 'Software', name: 'S1.sisnombre'}
//                        ,{display: 'Abreviatura', name: 'S1.sisabreviatura'}
                    ],
                    sortname: "sisnombre",
                    sortorder: "ASC",
                    usepager: true,
                    singleSelect: true,
                    useRp: true,
                    rp: 50,
                    height: $("#datos").innerHeight,
                    query: ''
                }
        );
        <?php 
        if($CargaAsignacion == 1)
        {
        ?>
        $("#flex2").flexigrid
        (
                {
                    url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonListPerfiles&Codigo=<?php echo $Codigo;?>&CodigoM=<?php echo $CodigoM?>',
                    dataType: 'json',
                    method: 'POST',
                    colModel: [
                        {display: 'ID', name: 'ID', width: 40, sortable: true, align: 'center', hide: true},
                        {display: 'Perfil', name: 'pefnombre', width: GetColumnSize(60.4), sortable: true, align: 'left'},
                        {display: 'Estado de Asignación', name: 'Boton1', width: GetColumnSize(19), sortable: false, align: 'center'},
                        {display: 'Asignar solo un Perfil', name: 'Boton1', width: GetColumnSize(20), sortable: false, align: 'center'}
                    ],
                    buttons: [
                        {name: 'Regresar', bclass: 'salir', onpress: test},
                        {separator: true}

                    ],
                    searchitems: [
                        {display: 'Perfil', name: 'S1.pefnombre'}
                    ],
                    sortname: "pefnombre",
                    sortorder: "ASC",
                    usepager: true,
                    singleSelect: true,
                    useRp: true,
                    rp: 50,
                    height: $("#datos").innerHeight,
                    query: ''
                }
        );
        <?php 
        }
        ?>

        function test(com,grid)
        {
            var nId = $('.trSelected',grid).children('td:eq(0)').text();
            if (com=='Salir')
            {
                cerrarPopup();
            }
            else
            {
                if (com=='Regresar')
                {
                    cerrarPerfil();
                }
                else
                {
                    $('#mensaje')
                    .text('Debe Seleccionar un registro del listado')
                    .addClass('msjalerta'),
                    $('#ifrmconstancia').hide();
                }
            }
        }
            </script>                      
    </body>
</html>
<?php
}
?>