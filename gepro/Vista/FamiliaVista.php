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
<link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
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

    function VerFicha(Codigo){
        var f = document.formularioGrid;
        f.Pagina.value = "FichaFamiliaPDF";
        f.Codigo.value = Codigo;
        f.target = "_blank";
        f.submit();
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
                           <li><a href="#tabs-1">Listado de Familias</a></li>
                           <li><a href="#tabs-2">Mantenimiento</a></li>
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
                                <!--table class="table table-hover table-nomargin table-bordered">
                                    <tr>
                                        <th style="width: 25%">NOMBRE DEL PERFIL</th>
                                        <td style="width: 75%"--><!--?php echo $NombrePerfilR?--><!--/td>
                                    </tr>
                                </table-->
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
                                            {display: 'Familia', name: 'FAMILIA', width: GetColumnSize(40), sortable: true, align: 'left'},
                                            {display: 'Departamento', name: 'UbiLocalidad', width: GetColumnSize(40), sortable: true, align: 'left'},
                                            {display: 'Editar', name: 'Boton1', width: GetColumnSize(7), sortable: false, align: 'center'},
                                            {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(7), sortable: false, align: 'center'},
                                            {display: 'Reporte', name: 'Ficha', width: GetColumnSize(7), sortable: false, align: 'center'}
                                        ],
                                        buttons: [
                                            {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                            {separator: true}

                                        ],
                                        searchitems: [
                                            {display: 'Familia', name: 'FAMILIA'}
                                        ],
                                        sortname: "ID",
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
    //$CodigoPerfil       = $lCollection->Get('CPerfil');
    //$NombrePerfilR      = $lCollection->Get('NombrePerfilR');
    $Familia            = $lCollection->Get('Familia');
    $lstDepartamento    = $lCollection->Get('lstDepartamento');
    if (($PermisoOK <> 0)) // and (strlen($CodigoPerfil)>0))
    {
        $Codigo                 = $lCollection->Get('Codigo');
        $Familia                = $lCollection->Get('Familia');
        $IdUbigeo               = $lCollection->Get('IdUbigeo');
        
        if (strlen($Codigo) > 0)
        {
            //ACTUALIZAR
            $ActionFormulario   = "ActualizarForm";
            $Btn                = "Actualizar";
            $TitulFormulario    = "Actualizar Familia";
        }
        else
        {
            //INSERT
            $ActionFormulario   = "RegistraDatos";
            $Btn                = "Registrar";
            $TitulFormulario    = "Registro de Familia";
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
        <input type="hidden" name="Codigo" value="<?php echo $Codigo?>">
        <legend><?php echo $TitulFormulario;?></legend>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="Familia">Familia: <span class="error">*</span></label>
                <div class="controls">
                    <input name="Familia" id="Familia" value="<?php echo $Familia;?>" onChange="conMayusculas(this)" 
                           maxlength="250" type="text" class="input-xlarge alphanumeric required" 
                           placeholder="Nombre de Familia" data-trigger='hover' data-content='Nombre de la Familia de Bienes'/>
                </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="cboDepartamento">Departamento: <span class="error">*</span></label>
                    <div class="controls">
                        <div class="span12">
                            <?php comboUbigeo('cboDepartamento',$lstDepartamento,$IdUbigeo,1,"data-trigger='hover' data-content='Departamento'")?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- INICIO OTROS CONTROLES -->
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">            
                    <!-- textarea -->
                    <div class="control-group">
                        <label class="control-label" for="textarea">Observaciones: <span class="error">*</span></label>
                        <textarea class="form-control" rows="2" style="width: 72%">Describa aquí las observaciones</textarea>
                    </div>
                </div>
            </div>
            <div class="span6">
                <!-- fechas -->
                <div class="control-group">
                    <label class="col-sm-2 control-label" for="inputSuccess"> Fecha de Ingreso</label>
                <div class="container">
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <!--input type='text' class="form-control" placeholder="Fecha de ingreso (dd/mm/yyyy)" /-->
                                    <input name="Fecha" id="Fecha" style="width: 10%" value="" minlength="1" maxlength="10" type="text" placeholder="dd/mm/yyyy" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese la fecha"/>
                                    <span class="input-group-addon">
                                        <!--span class="glyphicon glyphicon-calendar"></span-->
                                    </span>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#Fecha').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                showOn: 'button',
                                buttonImageOnly: false,
                                buttonText: '...',
                                buttonImage: '<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/images/calendar.png',
                                shortYearCutoff: '+100'
                            });
                            });
                        </script>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <!-- checkbox -->
                <div class="control-group">
                    <label class="col-sm-2 control-label" for="option"> Multiple</label>
                    <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" value="">
                      Este es un checkbox
                    </label>
                    <label>
                      <input type="checkbox" value="" checked>
                      Esta es otra opción checkbox
                    </label>
                    </div>
                </div>
            </div>
            <div class="span6">
                <!-- radiobuton -->
                <div class="control-group">
                    <label class="col-sm-2 control-label" for="option"> Activación</label>
                    <div class="radio-inline">
                    <label>
                      <input type="radio" name="opciones" id="opciones_1" value="opcion_1" checked>
                      Este es un botón de radio
                    </label>
                    <label>
                      <input type="radio" name="opciones" id="opciones_2" value="opcion_2">
                      Este es otro botón de radio
                    </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <!-- static control -->
                <div class="control-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <a href="#" data-toggle="tooltip" title="Solo números y caracteres">Ayuda</a>
                </div>
            </div>
            <div class="span6">
                <!-- estados -->
                <div class="control-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Disabled</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="disabledInput" type="text" disabled >
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <div class="form-group has-success has-feedback">
                        <label class="col-sm-2 control-label" for="inputSuccess"> Success e icono</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputSuccess" style="width: 400px">
                            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <!-- Modal -->
                <div class="control-group">
                    <!--div class="input-group-btn"-->
                        <label class="col-sm-2 control-label" for="search"> Buscar</label>
                        <input type="text" class="form-control" placeholder="Contenido a búscar" >
                        <button class="btn btn-default" type="submit" data-toggle="modal" data-target="#myModal">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    <!--/div-->
                </div>
                <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Desarrollo</h4>
                        </div>
                        <div class="modal-body">
                            <p>En construcción.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- FIN OTROS CTRLS -->
        <div class="form-actions">
            <input type="button" id="BtnForm01" class="btn btn-primary" name="btnForm" value="<?php echo $Btn;?>">
            <button type="button" onclick="Cancelar()" class="btn">Cancelar</button>
        </div>
    </form>
<?php
    }
}

?>
