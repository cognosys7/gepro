<?php
require_once('../Configuracion.php');
////OBTENGO LAS PAGINAS
$Usr         = isset($_GET['Usr'])? htmlspecialchars($_GET['Usr']) : "";
$Act         = isset($_GET['Act'])? htmlspecialchars($_GET['Act']) : "";
$Msj         = isset($_GET['Msj'])? htmlspecialchars($_GET['Msj']) : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>:::MVCS:::</title>
        <script language="javascript" type="text/javascript">
            function init() 
            {
                var f = document.formulario;
                f.submit();
            }
            window.onload = init;
        </script>
    </head>
    <body>
        <form name="formulario" id="formulario" method="post" action="index.php">
            <input type="hidden" name="cUs" value="<?php echo $Usr;?>"/>
            <input type="hidden" name="ActionForm" value="<?php echo $Act;?>"/>
            <input type="hidden" name="Mensaje" value="<?php echo $Msj;?>"/>
        </form>
    </body>
</html>