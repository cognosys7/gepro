<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Autores         : Hector Lopez Sanchez
  //  Propósito       : PROY_COMP_SEGUIMIENTOVISTA de la tabla PROY_COMP_SEGUIMIENTO
  //  Fecha           : martes, 15 de mayo de 2018 16:06:22
  //  Desde el Modelo : PDM - AMSACEtiqueta
  //
  //***************************************************************************** */

function muestraVista() {
    $lCollection = Collection::Singleton();
    //INFORMACIÓN DE LN
    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $PermisoOK = $lCollection->Get('PermisoOK');
    ?>
    <!--ESTILOS PARA UTILIZAR-->
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid_searchbar_on_top.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/miflexigridgris.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/css/botones.css"  />
    <link rel="stylesheet" href="<?php echo RECURSOSPROY; ?>/css/jcarousel.responsive.css" type="text/css">
    <link rel="stylesheet" href="<?php echo RECURSOSPROY; ?>/css/jcarousel.basic.css" type="text/css">
    <link rel="stylesheet" href="<?php echo RECURSOSPROY; ?>/css/jcarouselStyle1wrapper.css" type="text/css">

    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/flexigrid/flexigrid.js"></script>       
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSPROY ?>/js/PROY_COMP_SEGUIMIENTO.js"></script>    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/colorbox.css" />    
    <link rel="stylesheet" type="text/css" href="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.css" media="screen"/>    
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/jquery-ui/jquery.ui.datepicker.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo RECURSOSGEN_RECURSOS ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <script src="<?php echo RECURSOSPROY; ?>/js/Carrousel/jquery.jcarousel.min.js" type="text/javascript"></script>
    <script src="<?php echo RECURSOSPROY; ?>/js/Carrousel/jcarousel.responsive.js" type="text/javascript"></script>
    <script src="<?php echo RECURSOSPROY; ?>/js/Carrousel/jcarousel.basic.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        function cerrarPopup()
        {
            parent.$.colorbox.close();
            parent.$('#flex1').flexReload();
        }
        $(function () {
            $("#tabs").tabs({active: 0});
            $("#tabs").tabs({disabled: [1]});
        });

        function CallFlexiGrid()
        {
            $('#flex1').flexReload();
        }

    </script>
    <div id="Mensajes"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <?php
                if ($PermisoOK <> 0) {
                    $pCodigo = $lCollection->Get('pCodigo');
                    $DataSet_PROY_COMP_SEG_IMAGEN = $lCollection->Get('DataSet_PROY_COMP_SEG_IMAGEN');
                    ?>
                    <div class="box-content">    
                         <table style="height: 30px; width: 100%; background-color: #EDEDED;border: solid 1px #CCCCCC;">
                        <tr>
                            <td style="text-align: left; width: 80%;">
                            </td>
                            <td style="text-align: right; width: 20%;">
                            Cerrar <input name="Submit2" type="button" value="" id="salir16" title="Cerrar" onclick="cerrarPopup();">
                            </td>
                        </tr>
                       </table>
                        <!--CONTENIDO DE LA PESTAÑA 1-->                            
                        <form name="formularioGrid" id="formularioGrid" action="mainpage.php" method="post"> 
                            <!-- PASO DE VARIABLES A OTRA PÁGINA -->
                            <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario; ?>">
                            <input type="hidden" name="ActionForm" value="">
                            <input type="hidden" name="pCodigo" value="<?php echo $pCodigo; ?>">
                                    <!-- CARRUSEL DE FOTOGRAFIA -->

                                    <div class="jcarousel-wrapper">
                                        <div class="jcarousel">
                                            <?php
                                            $listaImagenes = count($DataSet_PROY_COMP_SEG_IMAGEN) > 0 ? true : false;
                                            ?>
                                            <ul>
                                                <?php
                                                if (($listaImagenes == true) || ($listaImagenes > 0)) {
                                                    foreach ($DataSet_PROY_COMP_SEG_IMAGEN as $ObjImagenes) {
                                                        $Descripcion = $ObjImagenes->DES_SEGUIMIENTO;
                                                        $MostrarPrincipalComP = '1'; //$ObjImagenes->MostrarPrincipal;
                                                        $Imagen = $ObjImagenes->IMG_PROYECTO;
                                                        $Enlace = $ObjImagenes->IMG_RUTA;
                                                        if ($MostrarPrincipalComP == 1) {
                                                            ?>
                                                            <li><img src="<?php echo $Enlace . $Imagen; ?>" width="600" height="400" alt="<?php echo $Descripcion; ?>"></li>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    echo "NO TIENE REGISTROS FOTOGRÁFICOS";
                                                }
                                                ?>
                                            </ul>
                                        </div>

                                        <p class="photo-credits">
                                            Galeria de Fotos <a href="#">ARCC</a>
                                        </p>

                                        <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                                        <a href="#" class="jcarousel-control-next">&rsaquo;</a>

                                        <p class="jcarousel-pagination">

                                        </p>
                                    </div>


                                    <!-- CARRUSEL DE FOTOGRAFIA -->
                                

                        </form>

                    
                </div>
                <?php
            } else {
                echo "<br><br><center>UD. NO TIENE ACCESO A ESTE MÓDULO</center><br>";
            }
            ?>
        </div>
    </div>
    </div>
    <?php
}
