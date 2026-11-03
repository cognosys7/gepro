<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    $descmsje         = "";
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $Tabs             = $lCollection->Get('Tabs');
    $mensaje          = $lCollection->Get('Mensaje');
    $PermisoOK        = $lCollection->Get('PermisoOK');
    
    if ($mensaje <> "") 
    {
        $descmsje = mensajesistema($mensaje);
    }
?>
<!--ESTILOS PARA UTILIZAR-->
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Acceso.js"></script>
<script type="text/javascript">
    $(function(){
        $("#tabs").tabs({active: <?php echo $Tabs;?>});
    });
</script>
<?php
if ($descmsje <> "") 
{
    echo $descmsje . "<br>";
}
?>
<div class="row-fluid">
       <div class="span12">
           <div class="box">
               <?php 
               if ($PermisoOK <> 0)
               {
               ?>
               <div class="box-content">
                   <div id="tabs">
                       <ul>
                           <li><a href="#tabs-1">Listado de Perfiles con Permiso a Acceso</a></li>
                       </ul>
                       <div id="tabs-1">
                           <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                           <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                           <input type="hidden" name="ActionForm" value="">
                           <input type="hidden" name="Codigo" value="">
                           <div id="contenedor">        
                                <div id="fila1">
                                    <div class="limpiar"></div>
                                </div>
                                <div class="msjinformacion" id="mensaje">
                                    Seleccione un registro para editar su Acceso
                                </div>
                                <div id="datos">
                                    <table id="flex1" style="display:none">

                                    </table>
                                </div>
                                <script type="text/javascript">
                                $("#flex1").flexigrid
                                (
                                        {
                                            url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonList',
                                            dataType: 'json',
                                            method: 'POST',
                                            colModel: [
                                                {display: 'ID', name: 'ID', width: 40, sortable: true, align: 'center', hide: true},
                                                {display: 'Software', name: 'sisnombre', width: GetColumnSize(25), sortable: true, align: 'left'},
                                                {display: 'Modulo', name: 'modnombre', width: GetColumnSize(25), sortable: true, align: 'left'},
                                                {display: 'Perfil', name: 'pefnombre', width: GetColumnSize(40.8), sortable: true, align: 'left'},
                                                {display: 'MODIFICAR', name: 'Boton1', width: 70, sortable: false, align: 'center', hide: true},
                                                {display: 'ELIMINAR', name: 'Boton2', width: 70, sortable: false, align: 'center', hide: true},
                                                {display: 'Accesos', name: 'Boton2', width: GetColumnSize(9), sortable: false, align: 'center'}
                                            ],
                                            buttons: [
//                                                {name: 'Salir', bclass: 'salir', onpress: test},
//                                                {separator: true}

                                            ],
                                            searchitems: [
                                                {display: 'Software', name: 'S3.sisnombre'},
                                                {display: 'Modulo', name: 'S2.modnombre'},
                                                {display: 'Perfil', name: 'S1.pefnombre'}
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

                                function test(com,grid)
                                {
                                    var nId = $('.trSelected',grid).children('td:eq(0)').text();
                                    if (com=='Salir')
                                    {
                                        var f = document.formularioGrid;
                                        f.action = "mainpage.php";
                                        f.Pagina.value = "";
                                        f.submit();
                                    }
                                    else
                                    {
                                        if (com=='Nuevo')
                                        {
                                            NuevoPerfil(); 
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
                            </div>
                           </form>
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
   </div>
   <br><br>
<?php
}
?>