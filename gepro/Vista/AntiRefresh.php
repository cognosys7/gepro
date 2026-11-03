<?php 
require_once('../Configuracion.php');
////OBTENGO LAS PAGINAS
$Pagina         = isset($_GET['Pagina'])? htmlspecialchars($_GET['Pagina']) : "";
$Tabs           = isset($_GET['Tabs'])? htmlspecialchars($_GET['Tabs']) : "";
$Mensaje        = isset($_GET['Mensaje'])? htmlspecialchars($_GET['Mensaje']) : "";
$CodMensaje     = isset($_GET['CodMensaje'])? htmlspecialchars($_GET['CodMensaje']) : "";

$Accion         = isset($_GET['Accion'])? htmlspecialchars($_GET['Accion']) : "";
$AccionLocal    = isset($_GET['AccionLocal'])? htmlspecialchars($_GET['AccionLocal']) : "";

//Opcion Creado para mostrar las herramientas de los registros de la grilla
$Opcion         = isset($_GET['Opcion'])? htmlspecialchars($_GET['Opcion']) : "";

//GENERA OPCIONES
$Op             = isset($_GET['Op'])? htmlspecialchars($_GET['Op']) : "";
$Oc             = isset($_GET['Oc'])? htmlspecialchars($_GET['Oc']) : "";
//USADOS PARA DOCUMENTOS
$CDocumento     = isset($_GET['CDocumento'])? htmlspecialchars($_GET['CDocumento']) : "";
$CAlbum         = isset($_GET['CAlbum'])? htmlspecialchars($_GET['CAlbum']) : "";
$CLibreta       = isset($_GET['CLibreta'])? htmlspecialchars($_GET['CLibreta']) : "";

//Cerrar Formulario
$CerrarForm = isset($_GET['CerrarForm'])? htmlspecialchars($_GET['CerrarForm']) : "";

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
        <title>:::PCM - RCC:::</title>
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
            <input type="hidden" name="CodMensaje" value="<?php echo $CodMensaje;?>"/>
            <input type="hidden" name="Mensaje" value="<?php echo $Mensaje;?>"/>
            <input type="hidden" name="CDocumento" value="<?php echo $CDocumento;?>"/>
            <input type="hidden" name="CerrarForm" value="<?php echo $CerrarForm;?>"/>
            <input type="hidden" name="CAlbum" value="<?php echo $CAlbum;?>"/>
            <input type="hidden" name="CLibreta" value="<?php echo $CLibreta;?>"/>
            <input type="hidden" name="Accion" value="<?php echo $Accion;?>"/>
            <input type="hidden" name="AccionLocal" value="<?php echo $AccionLocal;?>"/>
            <input type="hidden" name="Opcion" value="<?php echo $Opcion;?>"/>
        </form>
    </body>
</html>
