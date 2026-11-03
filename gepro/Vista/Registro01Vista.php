<?php
function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK        = $lCollection->Get('PermisoOK');
?>
<!--ESTILOS PARA UTILIZAR-->
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/js/flexigrid/miflexigridgris.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/Perfil.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY?>/js/general.js"></script>
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
               if ($PermisoOK <> 0)
               {
                    $CodigoPerfil   = $lCollection->Get('CPerfil');
                    $NombrePerfilR  = $lCollection->Get('NombrePerfilR');
                    //var_dump($NombrePerfilR, $CodigoPerfil);
               ?>
               <div class="box-content">
                   <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                    <tr>
                        <td style="text-align: left; width: 80%;">
                        </td>
                        <td style="text-align: right; width: 20%;">
                        Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                        </td>
                    </tr>
                   </table>
                   <div id="tabs">
                       <ul>
                           <li><a href="#tabs-1">Listado de Transferencias</a></li>
                           <li><a href="#tabs-2">Mantenimiento</a></li>
                       </ul>
                       <div id="tabs-1">
                            <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                                <input type="hidden" name="ActionForm" value="">
                                <input type="hidden" name="CPerfil" value="<?php echo $CodigoPerfil;?>">
                                <input type="hidden" name="Codigo" value="">
                               <div id="contenedor">        
                                <div id="fila1">
                                    <div class="limpiar"></div>
                                </div>
                                <table class="table table-hover table-nomargin table-bordered">
                                    <tr>
                                        <th style="width: 25%">NOMBRE DEL PERFIL</th>
                                        <td style="width: 75%"><?php echo $NombrePerfilR?></td>
                                    </tr>
                                </table>
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
                                        url: 'mainpage.php?Pagina=<?php echo $PaginaFormulario ?>&AccionLocal=1&Accion=LoadJsonList&CPerfil=<?php echo $CodigoPerfil;?>',
                                        dataType: 'json',
                                        method: 'POST',
                                        colModel: [
                                            {display: 'ID', name: 'ID', width: GetColumnSize(0), sortable: true, align: 'center', hide: true},
                                            {display: 'Departamento', name: 'UbiLocalidad', width: GetColumnSize(40), sortable: true, align: 'left'},
                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(7), sortable: false, align: 'center'},
                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(7), sortable: false, align: 'center'}
                                        ],
                                        buttons: [
                                            {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                            {separator: true}

                                        ],
                                        searchitems: [
                                            {display: 'Departamento', name: 'U1.UbiLocalidad'}
                                        ],
                                        sortname: "UbiLocalidad",
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
                                    if (com=='Nuevo')
                                    {
                                        Nuevo('<?php echo $PaginaFormulario ?>'); 
                                    }
                                    else
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
                       <div id="tabs-2">
                           <div id="FormularioDiv"></div>
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
//FUNCION PARA PROCESAR LOS MENSAJES DE LAS ACCIONES
function ProcesaMensaje()
{
    $lCollection = Collection::Singleton();
    $descmsje           = "";
    $sCodMensaje         = $lCollection->Get('CodMensaje');
    $sMensaje            = $lCollection->Get('Mensaje');
    if ($sCodMensaje <> "") 
    {
        $descmsje = mensajesistema($sCodMensaje,$sMensaje);
    }
    else
    {
        $descmsje = mensajesistema($sMensaje);
    }
    echo $descmsje."<br>";
}
//FUNCION UTILIZADA CUANDO SE REGISTRA O EDITA INFORMACIÓN
function GeneraForm()
{
    $lCollection        = Collection::Singleton();
    $PaginaFormulario   = $lCollection->Get('PaginaFormulario');
    $PermisoOK          = $lCollection->Get('PermisoOK');
    $CodigoPerfil       = $lCollection->Get('CPerfil');
    $NombrePerfilR      = $lCollection->Get('NombrePerfilR');
    
    $lstDepartamento    = $lCollection->Get('lstDepartamento');
    if (($PermisoOK <> 0) and (strlen($CodigoPerfil)>0))
    {
        $Codigo                 = $lCollection->Get('Codigo');
        $IdUbigeoR              = $lCollection->Get('IdUbigeoR');
        
        if (strlen($Codigo) > 0)
        {
            //ACTUALIZAR
            $ActionFormulario   = "ActualizarForm";
            $Btn                = "Actualizar";
            $TitulFormulario    = "Actualizar Departamento";
        }
        else
        {
            //INSERT
            $ActionFormulario   = "RegistraDatos";
            $Btn                = "Registrar";
            $TitulFormulario    = "Registro de Departamentos";
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
                    AjaxRegistraDatos('<?php echo $PaginaFormulario;?>');
              }
            });
        });
    </script>
    <form action="mainpage.php" class="validform fm-form" id="formulario" name="formulario" method="post">
        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
        <input type="hidden" name="ActionForm" value="<?php echo $ActionFormulario;?>">
        <input type="hidden" name="CPerfil" value="<?php echo $CodigoPerfil;?>">
        <input type="hidden" name="Codigo" value="<?php echo $Codigo?>">
        <legend><?php echo $TitulFormulario;?></legend>  
        <div class="control-group">
            <label class="control-label" for="perfil">Perfil: <span class="error">*</span></label>
            <div class="controls">
                <input readonly="" name="perfil" id="perfil" value="<?php echo $NombrePerfilR;?>" onChange="conMayusculas(this)" maxlength="250" type="text" class="input-xlarge alphanumeric required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="cboDepartamento">Departamento: <span class="error">*</span></label>
            <div class="controls">
                <div class="span12">
                    <?php comboUbigeo('cboDepartamento',$lstDepartamento,$IdUbigeoR,1,"")?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn;?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>
<?php
    }
}

?>
