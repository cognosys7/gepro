<?php
require_once(PATH_LIB . "/Exception.php");
function Vista($aPagina = '', $aVistaLocal = '', $aAjax = '') 
{
    try 
    {
        $lControlador   = PATH_CONTROLADOR_LN . "/" . ucfirst(strtolower($aPagina)) . "LN.php";
        $lVista         = PATH_VISTA."/".ucfirst(strtolower($aPagina))."Vista.php";
       
        if (file_exists($lControlador)) 
        {
            
        }
        else
        {
            header("Location:".INTRANET."/Vista/mainpage.php");
            exit;
        }
        require_once($lControlador);
        EjecutaLN();
        require_once(PATH_LIB."/functions.php");
        
        if (empty($aVistaLocal) and $aVistaLocal === "") 
        {
            ?>
            <html>
            
            <?php 
            if ($aPagina === "Dashboard")
            {
                $loadWeb = 1;
                $varBody = "";
            }
            else
            {
                $loadWeb = 0;
                $varBody = "login-page";
            }
            if ($loadWeb == 1)
            {
                pluginsWeb();
            }
            else
            {
                pluginsBasic();
            }
            ?>
            <body class="<?php echo $varBody;?>">
                <div id="Contenedor">
                    <?php 
                    if ($aPagina === "Dashboard")
                    {
                    ?>
                    <?php headerWeb();?>
                    <?php menuWeb();?>
                    <?php contentWeb();?>
                    <?php 
                    }
                    else
                    {
                        require_once($lVista);
                        muestraVista();
                    }
                    ?>
                    <?php pieWeb();?>
                </div>
            </body>
            </html>
            <?php
        } 
        else
        {
            require_once($lVista);
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