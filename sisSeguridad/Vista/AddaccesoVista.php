<?php

function muestraVista() {
    require_once("mensajes.php");
    $lCollection = Collection::Singleton();
    $descmsje         = "";
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $Tabs             = $lCollection->Get('Tabs');
    $PermisoOK        = $lCollection->Get('PermisoOK');
    $IdModulo         = $lCollection->Get('IdModulo');
    $IdPerfil         = $lCollection->Get('IdPerfil');
    $pefnombre        = $lCollection->Get('pefnombre');
    $sisnombre        = $lCollection->Get('sisnombre');
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
        <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Acceso.js"></script>
        <script type="text/javascript">
            function cerrarPopup() 
            {
                parent.$.colorbox.close();
            }
        </script>
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs({active: <?php echo $Tabs;?>});
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
                            <td style="text-align: left; width: 80%; color: #770000;"></td>
                            <td style="text-align: right; width: 20%;">
                            Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                            </td>
                        </tr>
                   </table>-->
                   <div id="tabs">
                       <ul>
                           <li><a href="#tabs-1" style="color: #aa0000;">Opciones de Acceso del Perfil <?php echo $pefnombre . " ( ". $sisnombre . " ) " ;?></a></li>
                       </ul>
                       <div id="tabs-1">
                            <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                                <input type="hidden" name="Accion" value="muestraVista"/>
                                <input type="hidden" name="ActionForm" value=""/>
                                <input type="hidden" name="AccionLocal" value="1"/>
                                <input type="hidden" name="Opcion" value="">
                                <input type="hidden" name="IP" value="<?php echo $IdPerfil;?>">
                                <input type="hidden" name="IM" value="<?php echo $IdModulo;?>">
                                <input type="hidden" name="IO" value="">
                                <div id="contenedor">        
                                     <div id="fila1">
                                         <div class="limpiar"></div>
                                     </div>
                                     <div class="msjinformacion" id="mensaje">
                                         Seleccione un registro para editar su Acceso: Otorgando o Denegando
                                     </div>
                                     <div id="datos">
                                         <table id="flex1" style="display:none">
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
                url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonList&IP=<?php echo $IdPerfil?>&IM=<?php echo $IdModulo?>',
                dataType: 'json',
                method: 'POST',
                colModel: [
                    {display: 'ID', name: 'ID', width: 40, sortable: true, align: 'center', hide: true},
                    {display: 'Sistema', name: 'sisnombre', width: GetColumnSize(39), sortable: true, align: 'left'},
                    {display: 'Opción', name: 'opcdescripcion', width: GetColumnSize(29), sortable: true, align: 'left'},
                    {display: 'Nivel', name: 'opcnivel', width: GetColumnSize(10), sortable: true, align: 'left', hide: true},
                    {display: 'Estado de Acceso', name: 'Acceso', width: GetColumnSize(15), sortable: false, align: 'center'},
                    {display: 'Otorgar / Denegar', name: 'Boton1', width: GetColumnSize(15), sortable: false, align: 'center'}
                ],
                buttons: [
                    {name: 'Salir', bclass: 'salir', onpress: test},
                    {separator: true}

                ],
                searchitems: [
                    {display: 'Sistema', name: 'S3.sisnombre'},
                    {display: 'Opción', name: 'S1.opcdescripcion'}
                ],
                sortname: "opcmodulo,opcorden2,opcnivel,opcorden",
                sortorder: " ",
                usepager: true,
                singleSelect: true,
                useRp: true,
                rp: 100,
                height: $("#datos").innerHeight,
                query: ''
            }
        );
        function test(com,grid)
        {
            var nId = $('.trSelected',grid).children('td:eq(0)').text();
            if (com=='Salir')
            {
                cerrarPopup();
            }
            else
            {
                $('#mensaje')
                .text('Debe Seleccionar un registro del listado')
                .addClass('msjalerta'),
                $('#ifrmconstancia').hide();
            }
        }
        </script>                        
    </body>
</html>
<?php
}
?>