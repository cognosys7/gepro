<?php

require_once(RECURSOSGEN_LIB."/Exception.php");
function Vista($aPagina='',$aVistaLocal='',$aAjax='') {
    try {
        $lControlador = PATH_CONTROLADOR_LN."/".ucfirst(strtolower($aPagina))."LN.php";
        $lVista = PATH_VISTA."/".ucfirst(strtolower($aPagina))."Vista.php";

		if (file_exists($lControlador))
        {
        }
        else
        {
            header("Location:".MAINPROY."/Vista/mainpage.php");
            exit;
        }
		
        require_once($lControlador);
        EjecutaLN();
        require_once($lVista);	
        require_once(SEG_VISTA.'/ConfigPages.php');
        if (empty($aVistaLocal) and $aVistaLocal === "") 
        {
            require_once("mensajes.php");
        ?>
        <!DOCTYPE html>
        <html> 
            <head>
                <meta charset="utf-8">
                <title><?php echo COGNOSYS;?></title>
                <meta name="description" content="">
                <meta name="viewport" content="width=device-width">
                <link rel="shortcut icon" href="../institucion.ico" />
                <!--ESTILOS POR DEFAULT-->
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/bootstrap/bootstrap.min.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/bootstrap/bootstrap-responsive.min.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/font-awesome/css/font-awesome.min.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/fuentes.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/flaty_rojo.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/dashboard.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/flaty-responsive.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/themes.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/framework/style.css">
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/css/estilos.css"  type="text/css" media="screen" />
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/css/menu.css"  type="text/css" media="screen" />
                
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.core.css"  type="text/css" media="screen"/>
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.theme.css" type="text/css" media="screen"/>
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.tabs.css" type="text/css" media="screen"/>
                <link rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.deshab.css" type="text/css" media="screen"/>
                
                <!--JQUERY POR DEFAULT-->
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery/jquery.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/framework/bootstrap/bootstrap.min.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/framework/nicescroll/jquery.nicescroll.min.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/framework/flaty.js"></script>
                
                
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.core.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.widget.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/jquery-ui/jquery.ui.tabs.js"></script>
                
                <!--VALIDACION-->
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/validacion/jquery.validate.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/validacion/reglas.js"></script>
                
                <!--<script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS?>/js/function.js"></script>-->
            </head>
            <body>
                <?php 
                muestraNavbar();
                ?>
                <div class="container-fluid" id="main-container" >
                    <?php 
                        muestraMenu();
                    ?>
                    <div id="main-content">
                        <?php
                            muestraSistema();
                            muestraBreadcrumbs();
                            muestraVista();
                        ?>
                        <a id="btn-scrollup" class="btn btn-circle btn-large" href="#"><i class="icon-chevron-up"></i></a>
                    </div>
                </div>
                <?php 
                muestraPie();
                ?>
                
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