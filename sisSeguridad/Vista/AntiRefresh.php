<?php 
require_once('../Configuracion.php');
////OBTENGO LAS PAGINAS
$Pagina         = isset($_GET['Pagina'])? htmlspecialchars($_GET['Pagina']) : "";
$Tabs           = isset($_GET['Tabs'])? htmlspecialchars($_GET['Tabs']) : "";
$Mensaje        = isset($_GET['Mensaje'])? htmlspecialchars($_GET['Mensaje']) : "";
$Accion         = isset($_GET['Accion'])? htmlspecialchars($_GET['Accion']) : "";
$AccionLocal    = isset($_GET['AccionLocal'])? htmlspecialchars($_GET['AccionLocal']) : "";
$ActvReg        = isset($_GET['ActvReg'])? htmlspecialchars($_GET['ActvReg']) : "";
$Op             = isset($_GET['Op'])? htmlspecialchars($_GET['Op']) : "";
$Oc             = isset($_GET['Oc'])? htmlspecialchars($_GET['Oc']) : "";
$Cd             = isset($_GET['Cd'])? htmlspecialchars($_GET['Cd']) : "";
$Aform          = isset($_GET['Aform'])? htmlspecialchars($_GET['Aform']) : "";
//USADOS PARA BUSCAR POR RENIEC
$TBusk          = isset($_GET['TBusk'])? htmlspecialchars($_GET['TBusk']) : "";
$TDoc           = isset($_GET['TDoc'])? htmlspecialchars($_GET['TDoc']) : "";
$NDoc           = isset($_GET['NDoc'])? htmlspecialchars($_GET['NDoc']) : "";
//USADOS PARA ACCESO
$IP             = isset($_GET['IP'])? htmlspecialchars($_GET['IP']) : ""; //CODIGO PERFIL
$IM             = isset($_GET['IM'])? htmlspecialchars($_GET['IM']) : ""; //CODIGO MODULO

if (strlen($Op)>0)
{
    $_SESSION["Op"] = $Op;
}
if (strlen($Oc)>0)
{
    $_SESSION["Oc"] = $Oc;
}
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
            <input type="hidden" name="Tabs" value="<?php echo $Tabs;?>"/>
            <input type="hidden" name="Mensaje" value="<?php echo $Mensaje;?>"/>
            <input type="hidden" name="Accion" value="<?php echo $Accion;?>"/>
            <input type="hidden" name="AccionLocal" value="<?php echo $AccionLocal;?>"/>
            <input type="hidden" name="ActvReg" value="<?php echo $ActvReg;?>"/>
            <input type="hidden" name="Codigo" value="<?php echo $Cd;?>"/>
            
            <input type="hidden" name="ActionForm" value="<?php echo $Aform;?>"/>
            <input type="hidden" name="TipBusk" value="<?php echo $TBusk;?>"/>
            <input type="hidden" name="TipDocumBusqueda" value="<?php echo $TDoc;?>"/>
            <input type="hidden" name="DniBusqueda" value="<?php echo $NDoc;?>"/>
            
            <input type="hidden" name="IP" value="<?php echo $IP;?>"/>
            <input type="hidden" name="IM" value="<?php echo $IM;?>"/>
        </form>
    </body>
</html>