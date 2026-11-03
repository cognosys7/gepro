<?php
require_once(PATH_LIB . "/Exception.php");
function Vista($aPagina = '', $aVistaLocal = '', $aAjax = '') 
{
    try 
    {
        $lControlador   = PATH_CONTROLADOR_LN . "/" . ucfirst(strtolower($aPagina)) . "LN.php";
        $lMensajes      = PATH_CONTROLADOR_LN . "/" . "MensajesPagesLN.php";
        $lVista         = PATH_VISTA . "/" . ucfirst(strtolower($aPagina)) . "Vista.php";

        if (file_exists($lControlador)) 
        {
            
        }
        else
        {
            header("Location:".INTRANET."/Vista/index.php");
            exit;
        }
        
        require_once($lControlador);
        EjecutaLN();
        require_once($lVista);

        require_once($lMensajes);
        if (empty($aVistaLocal) and $aVistaLocal === "") 
        {
            ?>
            <html lang="es">
                <head>
                    <title>Sistema Seguridad - Login</title>
                    <meta charset="utf-8">
                    <link rel="shortcut icon" href="../institucion.ico" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                    <meta name="description" content="">
                    <meta name="viewport" content="width=device-width">
                    <script language="JavaScript" type="text/javascript" src="../recursos/js/jquery.js"></script>

                    <!--ESTILOS POR DEFAULT-->
                    <link rel="stylesheet" href="../recursos/framework/bootstrap/bootstrap.min.css">
                    <link rel="stylesheet" href="../recursos/framework/bootstrap/bootstrap-responsive.min.css">
                    <link rel="stylesheet" href="../recursos/framework/font-awesome/css/font-awesome.min.css">
                    <link rel="stylesheet" href="../recursos/framework/flaty_rojo.css">
                    <link rel="stylesheet" href="../recursos/framework/flaty-responsive.css">
                    <!--<link rel="stylesheet" href="../Recursos/css/login.css"  type="text/css" media="screen" />-->
                    <link rel="stylesheet" href="../Recursos/css/estilosLoguin.css"  type="text/css" media="screen" />
                    <link rel="stylesheet" href="../Recursos/css/captcha.css"  type="text/css" media="screen" />
                    
                    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
                    <script language="JavaScript" type="text/javascript" src="../recursos/js/Seguridad/captcha.js"></script>
                    <script language="JavaScript" type="text/javascript" src="../recursos/js/function.js"></script>
                </head>
                <body class="login-page">
                    <!--FONDO IMAGEN DETRAS DEL LOGIN-->
                    <div class="login-wrapper"  style="background-image:url('../Recursos/images/fondo.jpg');background-repeat: no-repeat; background-size: cover; ">
                        <!--<img width="40%" src="../Recursos/images/fondo_amsac.png">-->
                        <!-- BEGIN Login Form -->
                        <br>
                        <?php muestraVista(); ?>
                        <!-- END Login Form -->
                        <br><br><br><br>
                        <div id="BarDown" class="barraLoginDown">
                            <div style="padding: 12px;" style="background-color:#A6131B;">
                            <?php echo PIE;?>
                            </div>
                        </div>
                    </div>
                </body>
            </html>
            <?php
        }
        else 
        {
            $aVistaLocal();
        }
    } 
    catch (Exception $lException) 
    {
        HandleException($lException);
        EchoException();
    }
}
?>