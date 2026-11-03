<?php

function muestraNavbar() {
    $lCollection = Collection::Singleton();
    $NombreUser = $lCollection->Get('DatosPersona');
    ?>
    <div id="navbar" class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a href="#" class="brand">
                    <small>
                        <img src="<?php echo RECURSOSGEN_RECURSOS ?>/images/logoX.png" alt="MVCS">
                    </small>
                </a>
                <a href="#" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <i class="icon-reorder"></i>
                </a>
                <ul class="nav flaty-nav pull-right">
                    <!-- BEGIN Button User -->
                    <li class="user-profile">
                        <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                            <span class="hidden-phone" id="user_info">
                                <?php echo $NombreUser; ?>
                            </span>
                            <i class="icon-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                            <li>
                                <a href="<?php echo INTRANET;?>">
                                    <i class="icon-home"></i>
                                    Intranet
                                </a>
                            </li>
                            <li>
                                <a href="Logout.php">
                                    <i class="icon-off"></i>
                                    Salir
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php
}

function muestraMenu() 
{
    //OBTENGO LAS SESIONES DE LAS OPCIONES
    $lCollection  = Collection::Singleton();
    $SOp          = isset($_SESSION['Op'])? $_SESSION['Op'] : "";
    $SOc          = isset($_SESSION['Oc'])? $_SESSION['Oc'] : "";
    $CodigoPerfil = $lCollection->Get('CodigoPerfil');
    $CodigoModulo = $lCollection->Get('CodigoModulo');
    $lstMenu      = GeneraMenus($CodigoModulo,1,0);
    $listamenus   = count($lstMenu) > 0 ? true : false;
?>
    <div id="sidebar" class="nav-collapse">
        <br><br><br>
        <ul class="nav nav-list">
            <li <?php if (($SOp == "") || ($SOp == 0)){ ?>class="active"<?php }?>>
                <a href="AntiRefresh.php?Op=0&&Oc=0">
                    <i class="icon-dashboard"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <?php 
            if (($listamenus == true) || ($listamenus > 0))  
            {
                foreach ($lstMenu as $objMenus) {
                    $CodOpcion  = $objMenus->IdOpcion;
                    $NomOpcion  = $objMenus->OpcDescripcion;
                    $UrlOpcion  = $objMenus->OpcEnlace;
                    $DesOpcion  = $objMenus->OpcDestino;
                    $OpcTipoEnlace = $objMenus->OpcTipoEnlace;
                    if ($DesOpcion == 1)
                    {
                        $target = "_self";
                    }
                    else
                    {
                        $target = "_blank";
                    }
                    $acceso     = VerificaAccesoMenu($CodOpcion,$CodigoPerfil);
                    if ($acceso == 1)
                    {
                        //VERIFICO SI TIENE MAS NIVELES ESTA OPCION
                        $lstMenu2 = GeneraMenus($CodigoModulo,2,$CodOpcion);
                        $listamenus2   = count($lstMenu2) > 0 ? true : false;
                        if (($listamenus2 == true) || ($listamenus2 > 0))  
                        {
                            $NivelN = 1;
                            $UrlOpcion = "#";
                        }
                        else
                        {
                            $NivelN = 0;
                            if ($OpcTipoEnlace == 1)
                            {
                                $UrlOpcion = $UrlOpcion."&&Op=".$CodOpcion;
                            }
                            else
                            {
                                $UrlOpcion = $UrlOpcion;
                            }
                        }
                    ?>
                    <li <?php if ($SOp == $CodOpcion){ ?>class="active"<?php }?>>
                        <a href="<?php echo $UrlOpcion;?>" <?php if ($NivelN == 0){?> target="<?php echo $target;?>" <?php } else{?> class="dropdown-toggle"<?php }?>>
                            <i class="icon-list-alt"></i>
                            <span><?php echo $NomOpcion;?></span>
                            <?php 
                            if ($NivelN == 1)  
                            {
                            ?>
                            <b class="arrow icon-angle-right"></b>
                            <?php
                            }
                            ?>
                        </a>
                        <?php 
                        if ($NivelN == 1) 
                        {
                            ?>
                            <ul class="submenu">
                            <?php
                            foreach ($lstMenu2 as $objMenus2) 
                            {
                                $CodOpcion2  = $objMenus2->IdOpcion;
                                $NomOpcion2  = $objMenus2->OpcDescripcion;
                                $UrlOpcion2  = $objMenus2->OpcEnlace;
                                $DesOpcion2  = $objMenus2->OpcDestino;
                                $OpcTipoEnlace2 = $objMenus2->OpcTipoEnlace;
                                if ($DesOpcion2 == 1)
                                {
                                    $target2 = "_self";
                                }
                                else
                                {
                                    $target2 = "_blank";
                                }
                                $acceso2     = VerificaAccesoMenu($CodOpcion2,$CodigoPerfil);
                                if ($acceso2 == 1)
                                {
                                    if ($OpcTipoEnlace2 == 1)
                                    {
                                        $UrlOpcion2 = $UrlOpcion2."&&Op=".$CodOpcion."&&Oc=".$CodOpcion2;
                                    }
                                    else
                                    {
                                        $UrlOpcion2 = $UrlOpcion2;
                                    }
                                ?>
                                    <li <?php if ($SOc == $CodOpcion2){ ?>class="active"<?php }?>>
                                        <a href="<?php echo $UrlOpcion2?>" target="<?php echo $target2;?>">
                                            <?php echo $NomOpcion2;?>
                                        </a>
                                    </li>
                                <?php
                                }
                            }
                            ?>
                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                    }
                }
            }
            ?>
            <li>
                <a href="<?php echo INTRANET;?>">
                    <i class="icon-dashboard"></i>
                    <span>Ir a Intranet</span>
                </a>
            </li>
        </ul>
        <div id="sidebar-collapse" class="visible-desktop">
            <i class="icon-double-angle-left"></i>
        </div>
    </div>    
    <?php
}

function muestraSistema() {
    ?>
    <div class="page-title">
        <div>
            <h1><i class="icon-file-alt"></i> <?php echo COPYRIGHT;?></h1>
        </div>
    </div>
    <?php
}

function muestraBreadcrumbs() 
{
    $lCollection  = Collection::Singleton();
    $CodigoModulo = $lCollection->Get('CodigoModulo');
    $NomOpcPadre  = "";
    //OBTENGO LAS SESIONES DE LAS OPCIONES
    $SOp        = isset($_SESSION['Op'])? $_SESSION['Op'] : "";
    if ($SOp <> "")
    {
        $lstMenu    = GeneraMenus($CodigoModulo,3,$SOp);
        if (($lstMenu == true) || ($lstMenu > 0))  
        {
            foreach ($lstMenu as $objMenus) 
            {
                $NomOpcPadre = $objMenus->OpcDescripcion;
            }
        }
        else
        {
            $NomOpcPadre = "";
        }
    }
    else
    {
        $NomOpcPadre = "";
    }
    ?>
    <div id="breadcrumbs">
        <ul class="breadcrumb">
    <?php
    if (strlen($NomOpcPadre) == 0) {
        ?>
                <li class="active"> Inicio</li>
                <span class="divider"><i class="icon-angle-right"></i></span>
        <?php
    } else {
        ?>
                <li>
                    <i class="icon-home"></i>
                    <a href="mainpage.php">Inicio</a>
                    <span class="divider"><i class="icon-angle-right"></i></span>
                </li>
                <li class="active"><?php echo $NomOpcPadre; ?></li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php
}

function muestraPie() {
    ?>
    <div id="navbarPie" class="navbarPie">
        <div class="navbar-inner-pie">
            <div class="fluidpie">
                <?php echo PIEPAGINA;?>
            </div>
        </div>
    </div>
    <?php
}
?>