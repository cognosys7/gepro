<?php

function muestraVista() {
    $lCollection = Collection::Singleton();
    $descmsje = "";
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $Tabs = $lCollection->Get('Tabs');
    $mensaje = $lCollection->Get('Mensaje');
    $PermisoOK = $lCollection->Get('PermisoOK');
    $PerFecNacimiento = "";

    if ($PermisoOK <> 0) {
        $modificar = $lCollection->Get('modificar');
        $lstUOrganica = $lCollection->Get('lstUOrganica');
        $EncontradoU = $lCollection->Get('EncontradoU');
        $Buscado = $lCollection->Get('Buscado');
        $Codigo = $lCollection->Get('Codigo');
        $CodigoP = $lCollection->Get('CodigoP');
        $CodigoT = $lCollection->Get('CodigoT');
        $PerApePaterno = $lCollection->Get('PerApePaterno');
        $PerApeMaterno = $lCollection->Get('PerApeMaterno');
        $PerNombres = $lCollection->Get('PerNombres');
        $UorNombre = $lCollection->Get('UorNombre');
        $PerSexo = $lCollection->Get('PerSexo');
        $usuldap = $lCollection->Get('usuldap');
        $PerFecNacimiento = $lCollection->Get('PerFecNacimiento');
        $prhunidadorganica = $lCollection->Get('prhunidadorganica');

        if ((strlen($CodigoP) > 0) and ( $CodigoP <> 0)) {
            $HabilitadoP = 1;
        } else {
            $HabilitadoP = 0;
        }

        if ((strlen($Codigo) > 0) and ( $Codigo <> 0)) {
            $ActionForm = "ActualizaUsuario";
            $Valorbutton = "Actualizar";
            $ValorTitulo = "Actualizar Datos de Usuario";
        } else {
            $ActionForm = "RegistraUsuario";
            $Valorbutton = "Registrar";
            $ValorTitulo = "Verificar DNI del Usuario";
        }


        //LISTADO DE TIPO DE DOCUMENTOS
        $lstTipoDocumentos = $lCollection->Get('lstTipoDocumentos');
        //VALOR DEL DNI
        $DNIVal = $lCollection->Get('DNIVal');
        //OBTENGO LOS DATOS DEL FORM
        $TipBusk = $lCollection->Get('TipBusk');
        $TipDocumBusqueda = $lCollection->Get('TipDocumBusqueda');
        $DniBusqueda = $lCollection->Get('DniBusqueda');

        if ($TipBusk == 0) {
            $TipoDocu = $DNIVal; //VALOR DE CATALOGO DE DNI
        } else {
            $TipoDocu = $TipDocumBusqueda;
        }

        if ($mensaje <> "") {
            $descmsje = mensajesistema($mensaje);
        }
    }
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/Usuario.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#tabs").tabs({active: <?php echo $Tabs; ?>});
    <?php
    if ($Tabs == 1) {
        ?>
                $("#tabs").tabs({disabled: [0]});
        <?php
    } else {
        ?>
                $("#tabs").tabs({disabled: [1]});
        <?php
    }
//    if ((strlen($PerFecNacimiento) > 0)) {
//        
//    } else {
    ?>
            $('#fechaNacimiento').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                buttonImage: '<?php echo RECURSOSPROY ?>/js/jquery-ui/images/calendar.gif',
                shortYearCutoff: '+100',
                maxDate: '0d'
            });
    <?php
//    }
    ?>
        });
        function LimpiaForm(Accion)
        {
            var f = document.formulario;
            f.Codigo.value = "";
            f.CodigoP.value = "";
            f.CodigoT.value = "";
            f.DniBusqueda.value = "";
            f.btnForm.value = "Registrar";
            f.ActionForm.value = Accion;
        }
        function NuevoUsuario()
        {
            $("#tabs").tabs({disabled: [0]});
            $("#tabs").tabs({active: 1});
            LimpiaForm("RegistraUsuario");
        }
        function CancelarUsuario()
        {
            $("#tabs").tabs({disabled: [1]});
            $("#tabs").tabs({active: 0});
            LimpiaForm("");
        }
        function CancelarUsuario2()
        {
            var f = document.formulario;
            f.ActionForm.value = "";
            f.submit();
        }

    </script>
    <?php
    if ($descmsje <> "") {
        echo $descmsje . "<br>";
    }
    ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {
                    ?>
                    <div class="box-content">
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1">Listado de Usuarios</a></li>
                                <li><a href="#tabs-2">Detalle de Usuario</a></li>
                            </ul>
                            <div id="tabs-1">
                                <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post">
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="ActionForm" value="">
                                    <input type="hidden" name="Codigo" value="">
                                    <input type="hidden" name="CodigoUO" value="">
                                    <input type="hidden" name="CodigoP" value="">
                                    <input type="hidden" name="CodigoT" value="">
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
                                                                    {display: 'DNI', name: 'usunombre', width: GetColumnSize(10), sortable: true, align: 'left'},
                                                                    {display: 'Usuario', name: 'usuldap', width: GetColumnSize(16), sortable: true, align: 'left'},
                                                                    {display: 'Persona', name: 'Usuario', width: GetColumnSize(35), sortable: true, align: 'left'},
                                                                    {display: 'Entidad o Ejecutora', name: 'UorNombre', width: GetColumnSize(25), sortable: true, align: 'left', hide: true},
                                                                    {display: 'Resetear Clave', name: 'BotonClave', width: GetColumnSize(10), sortable: false, align: 'center'},
                                                                    {display: 'Editar', name: 'Boton1', width: GetColumnSize(10), sortable: false, align: 'center'},
                                                                    {display: 'Eliminar', name: 'Boton2', width: GetColumnSize(10), sortable: false, align: 'center'},
                                                                    {display: 'Agregar', name: 'BotonAgregar', width: GetColumnSize(10), sortable: false, align: 'center'},
                                                                    {display: 'Agregar UE', name: 'BotonAgregar', width: GetColumnSize(10), sortable: false, align: 'center', hide: true}
                                                                ],
                                                                buttons: [
                                                                    {name: 'Nuevo', bclass: 'nuevo', onpress: test},
                                                                    {separator: true},
        //                                                {name: 'Salir', bclass: 'salir', onpress: test},
        //                                                {separator: true}

                                                                ],
                                                                searchitems: [
                                                                    {display: 'DNI', name: "P1.PerNroDocumento"},
                                                                    {display: 'Apellido Paterno', name: "P1.PerApePaterno"}
        //                                                                    ,{display: 'Oficina', name: "G1.UorNombre"}
                                                                ],
                                                                sortname: "Usuario",
                                                                sortorder: "ASC",
                                                                usepager: true,
                                                                singleSelect: true,
                                                                useRp: true,
                                                                rp: 50,
                                                                height: $("#datos").innerHeight,
                                                                query: ''
                                                            }
                                                    );

                                            function test(com, grid)
                                            {
                                                var nId = $('.trSelected', grid).children('td:eq(0)').text();
                                                if (com == 'Salir')
                                                {
                                                    var f = document.formularioGrid;
                                                    f.action = "mainpage.php";
                                                    f.Pagina.value = "";
                                                    f.submit();
                                                } else
                                                {
                                                    if (com == 'Nuevo')
                                                    {
                                                        NuevoUsuario();
                                                    } else
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
                                    <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                                    <input type="hidden" name="Codigo" value="<?php echo $Codigo; ?>">
                                    <input type="hidden" name="CodigoP" value="<?php echo $CodigoP; ?>">
                                    <input type="hidden" name="CodigoT" value="<?php echo $CodigoT; ?>">
                                    <input type="hidden" name="ActionForm" value="<?php echo $ActionForm; ?>">
                                    <div id="FormBusqueda" <?php if (($Buscado == 1) || ($modificar == 1)) { ?>style="display: none"<?php } ?>>


                                        <legend><?php echo $ValorTitulo; ?></legend> 


                                        <div class="control-group" style="display:none">
                                            <label class="control-label">Tipo de Búsqueda:</label>
                                            <div class="controls">
                                                <select name="TipBusk" onchange="TipoBusqueda(1);"  style='width: 51%;' >
                                                    <option value="0">Seleccione una Opción</option>
                                                    <option selected="selected" value="1">Búsqueda por Documento de Identidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hideDNI" id="BuskDNI">


                                            <div class="control-group" style="display:none">
                                                <label class="control-label">Tipo de Documento:</label>
                                                <div class="controls">
                                                    <?php comboTipoDocumento('TipDocumBusqueda', $lstTipoDocumentos, $TipoDocu, 1, 0, 0, " style='width: 51%;' "); ?>
                                                </div>
                                            </div>


                                            <div class="control-group">
                                                <label class="control-label">Documento de Identidad:</label>
                                                <div class="controls">
                                                    <input value="<?php echo $DniBusqueda; ?>" type="text" name="DniBusqueda" id="DniBusqueda" style="width:15%" onChange="buscarVisitanteUp(1, 1)" data-content="Ingrese Documento de Identidad (DNI) de la Persona"/>

                                                    <br>
                                                    <br>

                                                    <input type="button" value="Verificar" class="btn btn-primary" onclick="buscarVisitante(1, 1);" title="Verifique por Documento de Identidad">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="button" onclick="CancelarUsuario()" class="btn">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (($Buscado == 1) || ($modificar == 1)) {
                                        ?>
                                        <div id="FormBusqueda2">
                                            <br>
                                            <legend>Registro de Usuario</legend>
                                            <div id="Marco1" style="background-color: #FFF9EF">
                                                <br>
                                                <?php
                                                $TipoDocumento = CallCatalogo($TipoDocu, 1);
                                                ?>
                                                <div class="control-group" style="display:none">
                                                    <label class="control-label">Tipo de Documento : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input type="hidden" name="TipoDocumentoRecep" value="<?php echo $TipoDocu; ?>">
                                                            <input value="<?php echo $TipoDocumento; ?>" readonly="" class="required" type="text" name="NomTipoDocumento" id="NomTipoDocumento"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">N° Documento : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input value="<?php echo $DniBusqueda; ?>" readonly="" class="required" type="text" name="NumDocumentoRecep" id="NumDocumentoRecep" style="width:15%" onkeypress="return acceptNum(event);"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">Nombre Usuario : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input value="<?php echo $usuldap; ?>" onChange=""  type="text" name="usuLDAP" id="usuLDAP" class="input-xlarge   show-popover" data-trigger="hover" data-content="Ingrese el nombre del Usuario" style='width:15%;' />
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">Apellido Paterno : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input value="<?php echo $PerApePaterno; ?>" onChange="conMayusculas(this)"  type="text" name="ApellidosPRecep" id="ApellidosPRecep" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el Apellido Paterno de la Persona" style='width:15%;' />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Apellido Materno : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input value="<?php echo $PerApeMaterno; ?>" onChange="conMayusculas(this)"  type="text" name="ApellidosMRecep" id="ApellidosMRecep" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el Apellido Materno de la Persona" style='width:15%;' />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Nombres : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input value="<?php echo $PerNombres; ?>" onChange="conMayusculas(this)"  type="text" name="NombresRecep" id="NombresRecep" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre de la Persona" style='width:15%;' />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Fecha Nacimiento : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input type="text" value="<?php echo $PerFecNacimiento ?>" readonly="" style="width: 10%" name="fechaNacimiento" id="fechaNacimiento" class="input-xlarge required show-popover" data-trigger="hover" data-content="Ingrese la Fecha de Nacimiento del Usuario ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Sexo : <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <input type="radio"  name="sexo" <?php if (($PerSexo == 1) || ($PerSexo == "")) { ?>checked=""<?php } ?> value="1">Hombre
                                                            <input type="radio"  name="sexo" <?php if ($PerSexo == 0) { ?>checked=""<?php } ?> value="0">Mujer
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--
                <div class="control-group"><label class="control-label">LDAP: <span class="error"></span></label>
                    <div class="controls">
                        <div class="span12">
                            <input value="<?php echo $usuldap; ?>" maxlength="20" onChange="conMayusculas(this)" <?php if ($EncontradoU == 1) { ?> disabled=""<?php } ?> type="text" name="usuLDAP" id="usuLDAP" class="input-xlarge alphanumeric show-popover" data-trigger="hover" data-content="Ingrese el usuario LDAP del Usuario"/>
                        </div>
                    </div>
                </div>
                                                -->
                                                <div class="control-group" style="display:none"><label class="control-label">OFICINA: <span class="error">*</span></label>
                                                    <div class="controls">
                                                        <div class="span12">
                                                            <?php
                                                            if ($EncontradoU == 1) {
                                                                ?>
                                                                <input value="<?php echo $UorNombre; ?>" onChange="conMayusculas(this)" disabled="" type="text" name="cboUOrganica" id="cboUOrganica" class="input-xlarge alphanumeric required show-popover" data-trigger="hover" data-content="Ingrese el nombre de la Oficina"/>
                                                                <?php
                                                            } else {
                                                                $prhunidadorganica = 59;
                                                                comboUOrganica('cboUOrganica', $lstUOrganica, $prhunidadorganica, 0, 1, " style='width: 51%;' ");
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                            </div>
                                            <div class="form-actions">
                                                <input type="submit" id="btnForm" <?php if ($EncontradoU == 1) { ?> disabled=""<?php } ?> class="btn btn-primary" value="<?php echo $Valorbutton ?>">
                                                <?php
                                                if ($modificar == 1) {
                                                    ?>
                                                    <button type="button" onclick="CancelarUsuario2()" class="btn">Cancelar</button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button type="button" onclick="CancelarRecepcion()" class="btn">Cancelar</button>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </form>
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
?>