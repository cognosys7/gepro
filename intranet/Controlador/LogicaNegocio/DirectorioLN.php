<?php
    require_once(PATH_CONTROLADOR_DAO . "/DirectorioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(PATH_LIB . '/functions.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection        = Collection::Singleton();
        $PaginaFormulario   = "Directorio";
        
        $ActionForm       = isset($_REQUEST['Action'])? $_REQUEST['Action'] : '';
        $TipoBusqueda     = isset($_REQUEST['TipoBusqueda'])? $_REQUEST['TipoBusqueda'] : '';
        
        $objDirectorioDAO = new DirectorioDAO();
        $lstDirectorio    = array();
        $objDirectorioDAO->ListadoDirectorio($lstDirectorio);
        
        if ($ActionForm == "GeneraXLS")
        {
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=DirectorioTelefonico".date("d-m-Y_H:i").".xls");  //File name extension was wrong
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <table style="width: 100%; border: 1px;">
            <tr>
                <td colspan="4" style="background-color: #4C2F11;text-align: center; color: #ffffff;">
                    <b>DIRECTORIO TELEFÓNICO PRONIED</b><br>
                    Jr. Carabaya Nº 341 - Lima - Central Telefónica: 615-5960
                </td>
            </tr>
            <tr>
                <td style="background-color: #8E3D2B; color: #ffffff;font-weight: bold">CARGO</td>
                <td style="background-color: #8E3D2B; color: #ffffff;font-weight: bold">ANEXO</td>
                <td style="background-color: #8E3D2B; color: #ffffff;font-weight: bold">DIRECTO/RPC</td>
                <td style="background-color: #8E3D2B; color: #ffffff;font-weight: bold">NOMBRES Y APELLIDOS</td>
                
            </tr>
        <?php
            $Fcol   = 0;
            $listaDirectorio  = count($lstDirectorio) > 0 ? true : false;
            if (($listaDirectorio == true) || ($listaDirectorio > 0))
            {
                $TitulOficina            = "";
                foreach ($lstDirectorio as $ObjDirectorio) 
                {
                    $uornombre           = $ObjDirectorio->UNIDADORGANICA;
                    $cargo               = $ObjDirectorio->CARGO;
                    $Persona             = $ObjDirectorio->COLABORADOR;
                    $Celular             = $ObjDirectorio->MOVIL;
                    $Anexo               = $ObjDirectorio->ANEXO;
                    //$Permiso = 1;
                    $Permiso             = BuscarCadena($uornombre,$cargo,$TipoBusqueda);

                    if ($Permiso == 1)
                    {
                        $Fcol++;
                        $ColorX          = ColorFilaNaranja($Fcol);
                        if ($TitulOficina <> $uornombre)
                        {
                            $TitulOficina    = $uornombre;
                            
            ?>
                <tr>
                    <td style="background-color: #E3C99F; color: #704A0E;" colspan="4" style="text-align: left;"><?php echo $uornombre; ?></td>
                </tr>
                    <?php 
                        }
//                        else
//                        {
                    ?>
                <tr>
                    <td style="background-color: <?php echo $ColorX?>; text-align: left;"><?php echo $cargo; ?></td>
                    <td style="background-color: <?php echo $ColorX?>; text-align: center;"><?php echo $Anexo; ?></td>
                    <td style="background-color: <?php echo $ColorX?>; text-align: center;"><?php echo $Celular; ?></td>
                    <td style="background-color: <?php echo $ColorX?>; text-align: left;"><?php echo $Persona; ?></td>
                    
                </tr>
                    <?php
//                        }
                    }
                }
            ?>

            <?php
            }
            else
            {
            ?>
                <tr>
                    <td colspan="3"><br><center>NO SE ENCONTRÓ INFORMACIÓN</center></td>
                </tr>
            <?php
            }
        ?>
        </table>
        <?php
        exit;
        }
        
        //var_dump($lstDirectorio);exit;
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('TipoBusqueda', $TipoBusqueda);
        $lCollection->Add('lstDirectorio', $lstDirectorio);
    }
?>