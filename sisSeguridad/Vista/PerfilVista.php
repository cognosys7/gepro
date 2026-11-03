<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    $descmsje         = "";
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $Tabs             = $lCollection->Get('Tabs');
    $mensaje          = $lCollection->Get('Mensaje');
    $PermisoOK        = $lCollection->Get('PermisoOK');
    
    if ($PermisoOK <> 0)
    {
        //RECIBO VALORES PARA EL FORMULARIO
        $lstSistemas      = $lCollection->Get('lstSistemas');
        $Codigo           = $lCollection->Get('Codigo');
        if (strlen($Codigo)== 0)
        {
            $pefnombre      = "";
            $sisnombre      = "";
            $modnombre      = "";
            $idmodulo       = "";
            $ActionForm     = "RegistraPerfil";
            $ValorBoton     = "Registrar";
            $ValorTitForm   = "Registrar Perfil";
        }
        else
        {
            
            $pefnombre      = $lCollection->Get('pefnombre');
            $sisnombre      = $lCollection->Get('sisnombre');
            $modnombre      = $lCollection->Get('modnombre');
            $idmodulo       = $lCollection->Get('idmodulo');
            $ActionForm     = "ActualizaPerfil";
            $ValorBoton     = "Actualizar";
            $ValorTitForm   = "Actualizar Perfil";
        }

        if ($mensaje <> "") 
        {
            $descmsje = mensajesistema($mensaje);
        }
    }
?>
<!--ESTILOS PARA UTILIZAR-->
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Perfil.js"></script>
<script type="text/javascript">
    $(function(){
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
    function LimpiaForm(Accion)
    {
        var f = document.formulario;
        f.Codigo.value = "";
        f.sistemaNom.value = "";
        f.moduloNom.value = "";
        f.perfilNom.value = "";
        f.btnForm.value="Registrar";
        f.ActionForm.value = Accion;
    }
    function NuevoPerfil()
    {
        $("#tabs").tabs({disabled: [0]});
        $("#tabs").tabs({active: 1});   
        LimpiaForm("RegistraPerfil");
    }
    function CancelarSistema()
    {
        
        $("#tabs").tabs({disabled: [1]});
        $("#tabs").tabs({active: 0});
        LimpiaForm("RegistraPerfil");
    }
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
                           <li><a href="#tabs-1">Listado de Perfiles</a></li>
                           <li><a href="#tabs-2">Mantenimiento de Perfil</a></li>
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
                                            url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonList',
                                            dataType: 'json',
                                            method: 'POST',
                                            colModel: [
                                                {display: 'ID', name: 'ID', width: 40, sortable: true, align: 'center', hide: true},
                                                {display: 'Software', name: 'sisnombre', width: GetColumnSize(30), sortable: true, align: 'left'},
                                                {display: 'Modulo', name: 'modnombre', width: GetColumnSize(15), sortable: true, align: 'left'},
                                                {display: 'Perfil', name: 'pefnombre', width: GetColumnSize(41.5), sortable: true, align: 'left'},
                                                {display: 'Editar', name: 'Boton1', width: GetColumnSize(7), sortable: false, align: 'center'},
                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(7), sortable: false, align: 'center'}
                                            ],
                                            buttons: [
                                                {name: 'Nuevo', bclass: 'nuevo', onpress: test},
//                                                {name: 'Salir', bclass: 'salir', onpress: test},
                                                {separator: true}

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
                       <div id="tabs-2">
                        <form action="mainpage.php" class="validform form-horizontal" id="formulario" name="formulario" method="post">
                            <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                            <input type="hidden" name="ActionForm" value="<?php echo $ActionForm?>">
                            <input type="hidden" name="Codigo" value="<?php echo $Codigo?>">
                            <legend><?php echo $ValorTitForm;?></legend>  
                            <?php 
                            if (strlen($Codigo)>0)
                            {
                            ?>
                            <div class="control-group">
                                <label class="control-label" for="sistemaNom">Sistema:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $sisnombre;?>" readonly="" onChange="conMayusculas(this)" maxlength="100" type="text" name="sistemaNom" id="sistemaNom" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del Sistema"/>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            }
                            ?>
                            <div class="control-group">
                                <label class="control-label" for="nomModulo">Módulo:</label>
                                <div class="controls">
                                    <div class="span12">
                                    <?php 
                                    if (strlen($Codigo)>0)
                                    {
                                    ?>
                                        <input value="<?php echo $modnombre;?>" readonly="" onChange="conMayusculas(this)" maxlength="100" type="text" name="nomModulo" id="nomModulo" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del Módulo"/>
                                        <input type="hidden" name="cboModulo" value="<?php echo $idmodulo;?>">
                                    <?php 
                                    }
                                    else
                                    {
                                        comboSistemas('cboModulo', $lstSistemas, 0, 0, 0, 1, ""); 
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="perfilNom">Perfil:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $pefnombre;?>" onChange="conMayusculas(this)" maxlength="100" type="text" name="perfilNom" id="perfilNom" class="input-xlarge required show-popover" data-trigger="hover" data-content="Ingrese el enlace del Sistema"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" class="btn btn-primary" name="btnForm" value="<?php echo $ValorBoton;?>">
                                <button type="button" onclick="CancelarSistema()" class="btn">Cancelar</button>
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