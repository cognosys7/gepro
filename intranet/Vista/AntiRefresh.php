<?php
require_once('../Configuracion.php');
////OBTENGO LAS PAGINAS
$Pagina         = isset($_GET['Pagina'])? htmlspecialchars($_GET['Pagina']) : "";
$Accion         = isset($_GET['Accion'])? htmlspecialchars($_GET['Accion']) : "";
$AccionLocal    = isset($_GET['AccionLocal'])? htmlspecialchars($_GET['AccionLocal']) : "";
$Mensaje        = isset($_GET['Msj'])? htmlspecialchars($_GET['Msj']) : "";
$CNoticia       = isset($_GET['CNoticia'])? htmlspecialchars($_GET['CNoticia']) : "";
if ($Pagina <> "")
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>:::PRONIED:::</title>
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
        <form name="formulario" id="formulario" method="post" action="mainpage.php">
            <input type="hidden" name="Pagina" value="<?php echo $Pagina;?>"/>
            <input type="hidden" name="Accion" value="<?php echo $Accion;?>"/>
            <input type="hidden" name="AccionLocal" value="<?php echo $AccionLocal;?>"/>
            <input type="hidden" name="Mensaje" value="<?php echo $Mensaje;?>"/>
            <input type="hidden" name="CNoticia" value="<?php echo $CNoticia;?>"/>
        </form>
    </body>
</html>

<?php 
}
else
{
    header("Location:".INTRANET."/Vista/mainpage.php");
    exit;
}
?>
