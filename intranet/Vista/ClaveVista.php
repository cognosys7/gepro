<?php
function muestraVista() {
    $lCollection = Collection::Singleton();
    require_once("mensajes.php");
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $DNIUsuario       = $lCollection->Get('DNIUsuario');
    $personaNombre    = $lCollection->Get('personaNombre');
    $SeguridadPass    = isset($_SESSION['SeguridadPass']) ? $_SESSION['SeguridadPass'] : '';
    $descmsje         = "";
    if ($descmsje <> "") 
    {
        $descmsje = mensajesistema($descmsje);
    }
    ?>
    <script language="javascript" type="text/javascript">
    function ValidaInformacion()
    {
        var f = document.formulario;
        var p1 = f.Clave1.value;
        var p2 = f.Clave2.value;
        if (p1 == "")
        {
            alert("Debe ingresar su contraseña");f.Clave1.focus();return;
        }
        if (p2 == "")
        {
            alert("Debe ingresar su contraseña");f.Clave2.focus();return;
        }
        if ((p1 === p2) && (p1 === '<?php echo $DNIUsuario?>'))
        {
            alert("La contraseña no debe ser igual a su DNI");f.Clave1.focus();return;
        }
        if (p1.length < 6)
        {
            alert("La contraseña debe ser mayor de 6 dígitos");f.Clave1.focus();return;
        }
        if (p1 === p2)
        {
            var a = 0, rdbtn=document.getElementsByName("valsec")
            for(i=0;i<rdbtn.length;i++) 
            {
                if(rdbtn.item(i).checked == false) 
                {
                    a++;
                }
            }
            if(a == rdbtn.length) 
            {
                alert("Porfavor, seleccione su imagen de Seguridad"); return false;
            }
            f.submit();
        }
        else
        {
            alert("Las contraseñas ingresadas no coinciden. Ingrese correctamente esta información");return;
        }
    }
    
    function Salir()
    {
        var f = document.formulario;
        f.action = "mainpage.php";
        f.submit();
    }
    </script>
<div id="outerwrapper"></div>
<div id="outerwrappermain">
    <div class="container" id="wrapper2">
        <div id="" class="thirteen columns">
            <div class="thirteen columns headingmain blackbg">
                <center><img src='../Recursos/images/logox.png' width="120px;"></center>
                <h1>SEGURIDAD DEL SISTEMA</h1><hr style="border-color: #D35027;">
                <?php
                if ($descmsje <> "")
                {
                    echo $descmsje;
                }
                ?>
            </div>
                <div id="contactus" class="thirteen columns blackbg">
                    <div  id="desctext">
                    	
                    	<div class="quickinquiry">
                            
                            <!--<form class="forms" id="formulario" name="formulario" method="post" action="../../rcc/">-->
                            <form class="forms" id="formulario" name="formulario" method="post" action="mainpage.php">
                                <input type="hidden" name="Pagina" id="Pagina" value="<?php echo $PaginaFormulario;?>">
                                <input type="hidden" name="ActionForm" id="ActionForm" value="ActualizaClave">
                                <table style="width: 40%; margin: 0 auto;">
                                    <tr>
                                        <td colspan="2">
                                            <p>
                                                 Por motivos de seguridad, el Sistema de Seguridad MVCS le solicita que actualice su contraseña <br>Si todo es conforme, presione el botón <b>ACTUALIZAR INFORMACIÓN</b>.
                                            </p>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 25px;"><b>Nombre:</b> <?php echo $personaNombre;?><br><br></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 25px;"><b>Cambiar Contraseña</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><input name="Clave1" type="password" value=""/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 25px;"><b>Repita su Contraseña</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><input name="Clave2" type="password" value=""/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="height: 25px;"><b>Seleccione su Imagen de Seguridad</b></td>
                                    </tr>
                                    <?php 
                                    $lstValores = CallImgsAleatorio(0,0);
                                    ?>
                                    <tr>
                                        <td style="text-align: left;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[0]?>.png"></td>
                                        <td style="text-align: left;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[1]?>.png"></td>
                                        <td style="text-align: left;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[2]?>.png"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;"><input type="radio" name="valsec" value="<?php echo $lstValores[0]?>"></td>
                                        <td style="text-align: left;"><input type="radio" name="valsec" value="<?php echo $lstValores[1]?>"></td>
                                        <td style="text-align: left;"><input type="radio" name="valsec" value="<?php echo $lstValores[2]?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[3]?>.png"></td>
                                        <td style="text-align: left;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[4]?>.png"></td>
                                        <td style="text-align: left;"><img src="../recursos/images/icons_security/icon<?php echo $lstValores[5]?>.png"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;"><input type="radio" name="valsec" value="<?php echo $lstValores[3]?>"></td>
                                        <td style="text-align: left;"><input type="radio" name="valsec" value="<?php echo $lstValores[4]?>"></td>
                                        <td style="text-align: left;"><input type="radio" name="valsec" value="<?php echo $lstValores[5]?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <br><br>
                                            <input style="width: 180px;" type="button" onclick="ValidaInformacion();" value="Actualizar Información">
                                            <?php 
                                            if ($SeguridadPass <> 0)
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