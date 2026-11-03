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
        $CodigoS           = $lCollection->Get('CodigoS');
        $CodigoM           = $lCollection->Get('CodigoM');
        if (strlen($CodigoS)== 0)
        {
            $sisnombre      = "";
            $sisurl         = "";
            $sisabreviatura = "";
            $modnombre      = "";
            $ActionForm     = "RegistraSistema";
            $ValorBoton     = "Registrar";
            $ValorTitForm   = "Registrar Sistema (Software)";
        }
        else
        {
            
            $sisnombre      = $lCollection->Get('sisnombre');
            $sisurl         = $lCollection->Get('sisurl');
            $sisabreviatura    = $lCollection->Get('sisabreviatura');
            $modnombre      = $lCollection->Get('modnombre');
            $ActionForm     = "ActualizaSistema";
            $ValorBoton     = "Actualizar";
            $ValorTitForm   = "Actualizar Sistema (Software)";
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
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Sistemas.js"></script>
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
        f.CodigoS.value = "";
        f.CodigoM.value = "";
        f.sistemaNom.value = "";
        f.moduloNom.value = "";
        f.enlace.value = "";
        f.abreviatura.value = "";
        f.btnForm.value="Registrar";
        f.ActionForm.value = Accion;
    }
    function NuevoSistema()
    {
        $("#tabs").tabs({disabled: [0]});
        $("#tabs").tabs({active: 1});   
        LimpiaForm("RegistraSistema");
    }
    function CancelarSistema()
    {
        
        $("#tabs").tabs({disabled: [1]});
        $("#tabs").tabs({active: 0});
        LimpiaForm("RegistraSistema");
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
                           <li><a href="#tabs-1">Listado de Sistemas (Softwares)</a></li>
                           <li><a href="#tabs-2">Mantenimiento de Sistema (Software)</a></li>
                       </ul>
                       <div id="tabs-1">
                           <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                           <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                           <input type="hidden" name="ActionForm" value="">
                           <input type="hidden" name="CodigoS" value="">
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
                                <script type="text/javascript">
                                $("#flex1").flexigrid
                                (
                                        {
                                            url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=2&Accion=LoadJsonList',
                                            dataType: 'json',
                                            method: 'POST',
                                            colModel: [
                                                {display: 'ID', name: 'ID', width: 40, sortable: true, align: 'center', hide: true},
                                                {display: 'IDMODULO', name: 'idmodulo', width: 40, sortable: true, align: 'left', hide: true},
                                                {display: 'Software', name: 'sisnombre', width: GetColumnSize(38), sortable: true, align: 'left'},
                                                {display: 'Abreviatura', name: 'sisabreviatura', width: GetColumnSize(13.4), sortable: true, align: 'left'},
                                                {display: 'Modulo', name: 'modnombre', width: GetColumnSize(35), sortable: true, align: 'left'},
                                                {display: 'Editar', name: 'Boton1', width: GetColumnSize(7), sortable: false, align: 'center', hide: true},
                                                {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(7), sortable: false, align: 'center', hide: true}
                                            ],
                                            buttons: [
//                                                {name: 'Nuevo', bclass: 'nuevo', onpress: test},
//                                                {name: 'Salir', bclass: 'salir', onpress: test},
//                                                {separator: true}

                                            ],
                                            searchitems: [
                                                {display: 'Software', name: 'S1.sisnombre'}
                                                
                                            ],
                                            sortname: "sisnombre",
                                            sortorder: "ASC",
                                            usepager: true,
                                            singleSelect: true,
                                            useRp: true,
                                            rp: 10,
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
                                            NuevoSistema(); 
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
                            <input type="hidden" name="CodigoS" value="<?php echo $CodigoS?>">
                            <input type="hidden" name="CodigoM" value="<?php echo $CodigoM?>">
                            <legend><?php echo $ValorTitForm;?></legend>  
                            <div class="control-group">
                                <label class="control-label" for="sistemaNom">Nombre Sistema:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $sisnombre;?>" onChange="conMayusculas(this)" maxlength="100" type="text" name="sistemaNom" id="sistemaNom" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del Sistema"/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="moduloNom">Nombre Módulo:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $modnombre;?>" onChange="conMayusculas(this)" maxlength="100" type="text" name="moduloNom" id="moduloNom" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre del Módulo"/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="enlace">URL:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $sisurl;?>" maxlength="200" type="text" name="enlace" id="enlace" class="input-xlarge required show-popover" data-trigger="hover" data-content="Ingrese el enlace del Sistema"/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="abreviatura">Abreviatura:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $sisabreviatura;?>" onChange="conMayusculas(this)" maxlength="50" type="text" name="abreviatura" id="abreviatura" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese la abreviatura del Sistema"/>
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