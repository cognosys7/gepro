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
            $opcdescripcion = "";
            $opcmodulo      = "";
            $opcenlace      = "";
            $opcdestino     = "";
            $opcnivel       = "";
            $opctipoenlace  = "";
            $opcpadre       = "";
            $opclightbox    = "";
            $ActionForm     = "RegistraOpcion";
            $ValorBoton     = "Registrar";
            $ValorTitForm   = "Registrar Opción";
        }
        else
        {
            
            $opcdescripcion = $lCollection->Get('opcdescripcion');
            $opcmodulo      = $lCollection->Get('opcmodulo');
            $opcenlace      = $lCollection->Get('opcenlace');
            $opcdestino     = $lCollection->Get('opcdestino');
            $opcnivel       = $lCollection->Get('opcnivel');
            $opctipoenlace  = $lCollection->Get('opctipoenlace');
            $opcpadre       = $lCollection->Get('opcpadre');
            $opclightbox    = $lCollection->Get('opclightbox');
            $ActionForm     = "ActualizaOpcion";
            $ValorBoton     = "Actualizar";
            $ValorTitForm   = "Actualizar Opción";
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
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Opcion.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/ajaxOpcion.js"></script>
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
        f.opcionNom.value = "";
        f.enlace.value = "";
        f.btnForm.value="Registrar";
        f.ActionForm.value = Accion;
        document.getElementById("cboModulo").selectedIndex="0";
    }
    function NuevoOpcion()
    {
        $("#tabs").tabs({disabled: [0]});
        $("#tabs").tabs({active: 1});   
        LimpiaForm("RegistraOpcion");
    }
    function CancelarSistema()
    {
        
        $("#tabs").tabs({disabled: [1]});
        $("#tabs").tabs({active: 0});
        LimpiaForm("RegistraOpcion");
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
                           <li><a href="#tabs-1">Listado de Opciones</a></li>
                           <li><a href="#tabs-2">Mantenimiento de Opción</a></li>
                       </ul>
                       <div id="tabs-1">
                           <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                           <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                           <input type="hidden" name="ActionForm" value="">
                           <input type="hidden" name="Codigo" value="">
                           <input type="hidden" name="TipoSubBaj" value="">
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
                                            {display: 'Software', name: 'sisnombre', width: GetColumnSize(36), sortable: true, align: 'left'},
                                            {display: 'Opción', name: 'opcdescripcion', width: GetColumnSize(37), sortable: true, align: 'left'},
                                            {display: 'NIVEL', name: 'opcnivel', width: GetColumnSize(6), sortable: true, align: 'left', hide: true},
                                            {display: 'Subir', name: 'Boton1', width: GetColumnSize(7), sortable: false, align: 'center'},
                                            {display: 'Bajar', name: 'Boton2', width: GetColumnSize(7), sortable: false, align: 'center'},
                                            {display: 'Edtar', name: 'Boton3', width: GetColumnSize(7), sortable: false, align: 'center'},
                                            {display: 'Eliminar', name: 'Boton4', width: GetColumnSize(7), sortable: false, align: 'center'}
                                        ],
                                        buttons: [
                                            {name: 'Nuevo', bclass: 'nuevo', onpress: test},
//                                            {name: 'Salir', bclass: 'salir', onpress: test},
                                            {separator: true}

                                        ],
                                        searchitems: [
                                            {display: 'Software', name: 'S3.sisnombre'},
                                            {display: 'Opción', name: 'S1.opcdescripcion'}
                                        ],
                                        sortname: "sisnombre,opcmodulo,opcorden2,opcnivel,opcorden",
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
                                        var f = document.formularioGrid;
                                        f.action = "mainpage.php";
                                        f.Pagina.value = "";
                                        f.submit();
                                    }
                                    else
                                    {
                                        if (com=='Nuevo')
                                        {
                                            NuevoOpcion(); 
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
                            <input type="hidden" name="ModuloOriginal" value="<?php echo $opcmodulo?>">
                            <legend><?php echo $ValorTitForm;?></legend>  
                            <div class="control-group">
                                <label class="control-label" for="tipoOpcion">Tipo Opción:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input type="radio" name="tipoOpcion" onclick="cambiaEstado(1);" value="1" <?php if (($opcnivel == 1) || ($opcnivel == "")){?>checked=""<?php }?>>Opción Principal
                                        <input type="radio" name="tipoOpcion" onclick="cambiaEstado(0);" value="2" <?php if (($opcnivel == 2)){?>checked=""<?php }?>>Opción Secundaria
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="cboModulo">Sistema:</label>
                                <div class="controls">
                                    <div class="span12">
                                    <?php comboSistemas('cboModulo', $lstSistemas, $opcmodulo, 0, 1, "onchange=\"return AjaxOpcionList('$PaginaFormulario');\"  style='width: 51%;' ");?>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="divOpcionPrincipal">
                                <div class="control-group">
                                    <label class="control-label" for="cboOpcionPadre">Opción Principal: <span class="red">*</span></label>
                                    <div class="controls">
                                        <div class="span12">
                                            <?php 
                                            if (strlen($Codigo)>0)
                                            {
                                                $lstOpciones = GeneraMenus($opcmodulo,1,0);
                                                if ($opcnivel == 1)
                                                {
                                                    $Habil = 1;
                                                }
                                                else
                                                {
                                                    $Habil = 0;
                                                }
                                                comboMenus('cboOpcionPadre', $lstOpciones, $opcpadre, $Habil, 1, " style='width: 51%;' ");
                                            }
                                            else
                                            {
                                            ?>
                                            <select disabled="" name="cboOpcionPadre" id="cboOpcionPadre">
                                                <option>Seleccione una Opción</option>
                                            </select>
                                            <?php 
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="opcionNom">Nombre:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $opcdescripcion;?>" maxlength="100" type="text" name="opcionNom" id="opcionNom" class="input-xlarge required show-popover" data-trigger="hover" data-content="Ingrese el nombre de la Opción" style='width:14.5%;' />
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="enlace">Enlace:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input value="<?php echo $opcenlace;?>" maxlength="1000" type="text" name="enlace" id="enlace" class="input-xlarge show-popover" data-trigger="hover" data-content="Ingrese el enlace de la Opción"/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="destino">Abrir:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <select name="destino" class="required">
                                            <option>Seleccione una Opción</option>
                                            <option value="1" <?php if ($opcdestino == 1){?>selected=""<?php }?>>En la misma página</option>
                                            <option value="2" <?php if ($opcdestino == 2){?>selected=""<?php }?>>En otra página</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="lightbox">Lightbox:</label>
                                <div class="controls">
                                    <div class="span12">
                                        <input type="radio" name="lightbox" value="1" <?php if ($opclightbox == 1){?>checked=""<?php }?>>SI
                                        <input type="radio" name="lightbox" value="0" <?php if (($opclightbox == 0) || ($opclightbox == "")){?>checked=""<?php }?>checked="">NO
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
function LoadOpcionesMainAjax() {
    $lCollection                = Collection::Singleton();
    $lstOpcionAjax              = $lCollection->Get("lstOpcionAjax");
    $TipOpc                     = $lCollection->Get("TipOpc");
    ?>
   <div class="control-group">
        <label class="control-label" for="cboOpcionPadre">Opción Principal: <span class="red">*</span></label>
        <div class="controls">
            <div class="span12">
                <select class="required" name="cboOpcionPadre" id="cboOpcionPadre" <?php if ($TipOpc == 1){?>disabled=""<?php }?>>
                     <option value="">Seleccione una Opción</option>
                     <?php
                    $lOption = "";
                    for ($i=0; $i<count($lstOpcionAjax); $i++) {
                        $lOption .= "<option value=\"".$lstOpcionAjax[$i]->IdOpcion."\">".$lstOpcionAjax[$i]->OpcDescripcion."</option>\n\r";
                    }
                    echo $lOption;
                    ?>
                 </select>
            </div>
        </div>
    </div>
    <?php
}
?>