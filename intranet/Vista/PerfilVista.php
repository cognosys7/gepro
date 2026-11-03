<?php
function muestraVista() {
    $lCollection = Collection::Singleton();
    require_once("mensajes.php");
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $personaNombre    = $lCollection->Get('personaNombre');
    $centroNombre     = $lCollection->Get('centroNombre');
    $iddirectorio     = $lCollection->Get('iddirectorio');
    $dirtelfdirecto   = $lCollection->Get('dirtelfdirecto');
    $dirtelfanexo     = $lCollection->Get('dirtelfanexo');
    $dircelular       = $lCollection->Get('dircelular');
    $dircorreo        = $lCollection->Get('dircorreo');
    $descmsje         = "";
    if ($descmsje <> "") 
    {
        $descmsje = mensajesistema($descmsje);
    }
    ?>
    <script language="javascript" type="text/javascript">
    function TelfDirecto(Valor)
    {
        var f = document.formulario;
        if (Valor === 1)
        {
            f.DirectoNum.value = "";
            f.DirectoNum.disabled = false;
            f.DirectoNum.focus();
        }
        else
        {
            f.DirectoNum.value = "615-5960";
            f.DirectoNum.disabled = true;
            f.AnexoNum.focus();
        }
    }
    function TelfCelular(Valor)
    {
        var f = document.formulario;
        if (Valor === 1)
        {
            $("#TelfCelular1").show();
            $("#TelfCelular2").show();
            f.CelularNum.value = "";
            f.CelularNum.disabled=false;
            f.CelularNum.focus();
        }
        else
        {
            $("#TelfCelular1").hide(50);
            $("#TelfCelular2").hide(50);
            f.CelularNum.value = "";
            f.CelularNum.disabled=true;
        }
    }
    function Salir()
    {
        var f = document.formulario;
        f.action = "mainpage.php";
        f.submit();
    }
    function ValidaInformacion()
    {
        var f = document.formulario;
        if (document.getElementById('TDirectoSi').checked)
        {
            if (f.DirectoNum.value === "")
            {
                alert("Debe ingresar el número de un teléfono directo"); 
                f.DirectoNum.focus();return;
            }
            if (f.AnexoNum.value === "")
            {
                alert("Debe ingresar un número de anexo"); 
                f.AnexoNum.focus();return;
            }
        }
        else
        {
            if (f.AnexoNum.value === "")
            {
                alert("Debe ingresar un número de anexo"); return;
                f.AnexoNum.focus();
            }
        }
        if (document.getElementById('TCelularSi').checked)
        {
            if (f.CelularNum.value === "")
            {
                alert("Debe ingresar un número de celular"); 
                f.CelularNum.focus();return;
            }
        }
        else
        {
            
        }
        if (f.correoInstitucional.value === "")
        {
            alert("Ingrese su correo institucional");
            f.correoInstitucional.focus();return;
        }
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email = f.correoInstitucional.value;
        if ( !expr.test(email) )
        {
            alert("Error: La dirección de correo " + email + " es incorrecta.");
            f.correoInstitucional.focus();
            return;
        }
        f.submit();
    }
    </script>
<div id="outerwrapper"></div>
<div id="outerwrappermain">
    <div class="container" id="wrapper2">
        <div id="" class="thirteen columns">
            
            <div class="thirteen columns headingmain blackbg">
                <center><img src='../Recursos/images/logox.png' width="150px;"></center>
                <h1>Mi Perfil</h1><hr style="border-color: #D35027;">
                <?php
                if ($descmsje <> "")
                {
                    echo $descmsje;
                }
                ?>
            </div>
                <div id="contactus" class="thirteen columns blackbg">
                    <div style="padding: 20px;">
                    <div class="" id="desctext">
                    	
                    	<div class="quickinquiry">
                            
                            <form class="forms" id="formulario" name="formulario" method="post" name="formulario" action="mainpage.php">
                                <input type="hidden" name="Pagina" id="Pagina" value="<?php echo $PaginaFormulario;?>">
                                <input type="hidden" name="Codigo" id="Codigo" value="<?php echo $iddirectorio;?>">
                                <input type="hidden" name="ActionForm" id="ActionForm" value="RegistraDirectorio">
                                
                                <table style="width: 40%; margin: 0 auto;">
                                    <tr>
                                        <td colspan="2">
                                            <p>
                                                A continuación se solicitará confirmar su información personal a fin de mantener actualizada nuestra base de datos. <br>Si todo es conforme, presione el botón <b>ACTUALIZAR MI INFORMACIÓN</b>.
                                            </p>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height: 25px;"><b>Nombre:</b> <?php echo $personaNombre;?><br><br></td>
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2" style="height: 25px;"><b>Oficina:</b> <?php echo $centroNombre;?> <br><br></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>¿Tiene teléfono directo?</b> 
                                            <input name="Directo" type="radio" id="TDirectoSi" value="1" onclick="TelfDirecto(1)">Si 
                                            <input name="Directo" type="radio" id="TDirectoNo" checked="" value="0" onclick="TelfDirecto(0)">No</td>
                                    </tr>
                                    <tr id="TelfDirecto1">
                                        <td style="width: 30%; height: 25px;"><b>Directo</b></td>
                                        <td style="height: 25px;"><b>Anexo</b></td>
                                    </tr>
                                    <tr id="TelfDirecto2">
                                        <td><input type="text" disabled="" value="<?php echo TELEFDIRECTO; ?>" name="DirectoNum" style="width: 80%" maxlength="9" value="<?php echo $dirtelfdirecto;?>"/></td>
                                        <td><input type="text" name="AnexoNum" onkeypress="return acceptNum(event);" style="width: 80%" maxlength="5" value="<?php echo $dirtelfanexo?>"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height: 35px;"><b>¿Cuenta con celular de la institución?</b> 
                                            <input name="Celular" type="radio" id="TCelularSi" value="1" onclick="TelfCelular(1)">Si 
                                            <input name="Celular" type="radio" id="TCelularNo"  checked="" value="0" onclick="TelfCelular(2)">No</td>
                                    </tr>
                                    <tr id="TelfCelular1" style="display: none">
                                        <td colspan="2" style="height: 25px;"><b>Número de Celular</b></td>
                                    </tr>
                                    <tr id="TelfCelular2" style="display: none">
                                        <td colspan="2"><input style="width: 20%" onkeypress="return acceptNum(event);" maxlength="9" disabled="" name="CelularNum" type="text" value="<?php echo $dircelular?>"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height: 25px;"><b>Correo Institucional</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><input name="correoInstitucional" type="text" value="<?php echo $dircorreo?>"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input style="width: 180px;" type="button" onclick="ValidaInformacion();" value="Actualizar mi Información">
                                            <?php 
                                            if ($iddirectorio <> 0)
                                            {
                                            ?>
                                            <input style="width: 180px;" type="button" onclick="Salir();" value="Salir">
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
    <!--End of styles-->
    <?php echo pieWeb();?>
</div>
<div id="animationwrapp" style="display:none;visibility:hidden;">
    <div id="slidecaption"></div>
    <div id="slidedescription"></div>
</div>
<div id="loadcontent" style="display:none"></div>
<?php
}
?>