<?php
function muestraVista() {
    require_once("mensajes.php");
    require_once(PATH_LIB."/functions.php");
    $lCollection        = Collection::Singleton();
    //$CNoticia           = $lCollection->Get('CNoticia');
    //$FechaPublicM       = $lCollection->Get('FechaPublicM');
    $TituloM            = $lCollection->Get('TituloM');
    $DescripcionM       = $lCollection->Get('DescripcionM');
    $lstNoticias        = $lCollection->Get('lstNoticias');
    $lstImagemes        = $lCollection->Get('lstImagemes');
    ?>
    <!DOCTYPE html>
    <html> 
        <head>
            <meta charset="utf-8">
            <title><?php echo PRONIED; ?></title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width">
            <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/estilos.css" type="text/css"/>
            <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/menu.css" type="text/css" media="screen">
            <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>css/estilosbox.css" type="text/css" />
            <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>css/tinitable.css" type="text/css" />
            <link rel="stylesheet" href="<?php echo RECURSOSPROY;?>/css/jcarousel.connected-carousels.css">
            <link rel="shortcut icon" href="../institucion.ico" />
            <script src="<?php echo RECURSOSPROY;?>/js/jquery.js" type="text/javascript"></script>
            <script src="<?php echo RECURSOSPROY;?>/js/menu.js" type="text/javascript" ></script>
            <script src="<?php echo RECURSOSPROY;?>/js/Intranet.js" language="JavaScript" type="text/javascript"></script>
            <script src="<?php echo RECURSOSPROY;?>/js/Carrousel/jquery.jcarousel.min.js" type="text/javascript"></script>
            <script src="<?php echo RECURSOSPROY;?>/js/Carrousel/jcarousel.connected-carousels.js" type="text/javascript"></script>
        </head>
        <body id="bg">
            <div id="Contenedor">
                <?php headerWebOtros();?>
                <?php menuWeb();?>
                <div id="wrapOtros">
                    <h1 class="textEnlaceNaranja" style="text-align: center; padding: 20px;">Noticias</h1>
                    <div id="content">
                        <div id="MarcoMasNoticias2">
                            <div id="PortadaImg">
                                <center>
                                    <?php
                                    $listaImagenes  = count($lstImagemes) > 0 ? true : false;
                                    if (($listaImagenes == true) || ($listaImagenes > 0))
                                    {
                                    ?>
                                    <div class="connected-carousels">
                                        <div class="stage">
                                            <div class="carousel carousel-stage">
                                                <ul>
                                                    <?php 
                                                        $ContNoticias = 0;
                                                        foreach ($lstImagemes as $ObjImagenes) 
                                                        {
                                                            $ContNoticias++;
                                                            $IImagen          = $ObjImagenes->RutaArchivo;
                                                            $ITitulo          = $ObjImagenes->Titulo;
                                                    ?>
                                                        <li><img src="<?php echo INTRAAPP_FILES."/".$IImagen;?>" width="600" height="400" title="<?php echo $ITitulo;?>"></li>
                                                    <?php 
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="navigation">
                                            <a href="#" class="prev prev-navigation">&lsaquo;</a>
                                            <a href="#" class="next next-navigation">&rsaquo;</a>
                                            <div class="carousel carousel-navigation">
                                                <ul>
                                                    <?php 
                                                        foreach ($lstImagemes as $ObjImagenes) 
                                                        {
                                                            $IImagen          = $ObjImagenes->RutaArchivo;
                                                    ?>
                                                    <li><img src="<?php echo INTRAAPP_FILES."/".$IImagen;?>" width="50" height="50" alt=""></li>
                                                    <?php 
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                    ?>
                                </center>
                            </div>
                        </div>
                        <?php 
                        $ActiveMarco = 0;
                        if (($listaImagenes == true) || ($listaImagenes > 0))
                        {
                            $ActiveMarco = 1;
                        }
                        ?>
                        <div id="MarcoNoticiasContenido" <?php if ($ActiveMarco == 0){?>style="width: 65% !important; margin-left: 40px;"<?php }?>>
                            <h2 style="text-align: center;" class="txtTextoAzul"><?php echo $TituloM;?></h2>
                            <br><br>
                            <div style="text-align: justify;"><?php echo $DescripcionM;?></div>
                            <br><br>
                        </div>
                        <div id="MarcoMasNoticias">
                            <div class="MarcoDerecho">
                                <br><h4 class="textEnlaceNaranja"><center>+ Noticias</center></h4><br>
                                <table class="textContenido" style="width: 90%; margin-left: 6%; margin-right: 4%;">
                                <?php 
                                $iNoti      = 0;
                                $CountNOTI  = 0;
                                $listaNoticias  = count($lstNoticias) > 0 ? true : false;
                                if (($listaNoticias == true) || ($listaNoticias > 0))
                                {
                                    foreach ($lstNoticias as $ObjNoticias) 
                                    {
                                        $CountNOTI++;
                                    }
                                }
                                if (($listaNoticias == true) || ($listaNoticias > 0))
                                {
                                    foreach ($lstNoticias as $ObjNoticias) 
                                    {
                                        $iNoti++;
                                        $CNoticia          = $ObjNoticias->IdNoticia;
                                        $TituloNoticia     = $ObjNoticias->Titulo;
                                ?>
                                <tr>
                                    <td><a class="textEnlace" href="javascript:openNoticias(<?php echo $CNoticia;?>)"><?php echo $TituloNoticia;?></a></td>
                                </tr>
                                <?php
                                        if ($iNoti <> $CountNOTI)
                                        {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><br><hr class="Lineas"><br></td>
                                </tr>
                                <?php 
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><br></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php pieWeb();?>
        </body>
    </html>
    <?php
}
?>