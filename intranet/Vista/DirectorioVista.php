<?php
function muestraVista() {
    require_once("mensajes.php");
    $lCollection        = Collection::Singleton();
    $lstDirectorio      = $lCollection->Get('lstDirectorio');
    $PaginaFormulario   = $lCollection->Get('PaginaFormulario');
    $TipoBusqueda       = $lCollection->Get('TipoBusqueda');
    ?>
    <!DOCTYPE html>
    <html> 
        <head>
            <meta charset="utf-8">
            <title><?php echo PRONIED; ?></title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width">
            <link type="text/css" rel="stylesheet" href="<?php echo RECURSOSPROY; ?>css/estilosbox.css"/>
            <link type="text/css" rel="stylesheet" href="<?php echo RECURSOSPROY; ?>css/tinitable.css" />
            <link type="text/css" rel="stylesheet" href="<?php echo RECURSOSGEN_RECURSOS?>/css/botones.css"  />
            <style>
                .buttonAct 
                {
                    background-color: #E20A19;
                    color: #ffffff;
                    display: inline-block;
                    margin: 0 10px 0 0;
                    padding: 15px 25px;
                    border: 1px solid rgb(171,129,3);
                    font-size: 14px;
                    /*font-family: serif;*/
                    line-height: 0.9;
                    box-shadow: none;
                    border-radius: 0;
                    
                }
                .buttonDes 
                {
                    background-color: #e7e7e7;
                    color: #2B2B2C;
                    display: inline-block;
                    margin: 0 10px 0 0;
                    padding: 15px 25px;
                    border: 1px solid rgb(163,163,163);
                    font-size: 14px;
                    /*font-family: serif;*/
                    line-height: 0.9;
                    box-shadow: none;
                    border-radius: 0;
                }
            </style>
            <script>
                function VerDatos(Valor)
                {
                    var f = document.formulario;
                    f.Action.value = "";
                    f.TipoBusqueda.value = Valor;
                    f.submit();
                }
                function GeneraDescarga()
                {
                    var f = document.formulario;
                    if(f.FormatoDescarga.value === "1")
                    {
                        f.Action.value = "GeneraXLS";
                        f.submit();
                    }
                    else
                    {
                        if(f.FormatoDescarga.value === "2")
                        {
                            var f = document.formularioPDF;
                            f.Pagina.value = "DirectorioPDF";
                            f.Action.value = "Generar";
                            f.target = "_blank";
                            f.submit();
                        }
                        else
                        {
                            return false;
                        }
                    }
                }
                function cerrarPopup()
                {
                    parent.$.colorbox.close();
                }
            </script>
        </head>
        <body id="bg">
            <br>
            <div id="wrap">
                <div id="content">
                    <form id="formularioPDF" name="formularioPDF" action="mainpage.php">
                        <input type="hidden" name="Pagina" value="">
                        <input type="hidden" name="Action" value="">
                        <input type="hidden" name="TipoBusqueda" value="<?php echo $TipoBusqueda;?>">
                        <input type="hidden" name="Accion" value="muestraVista">
                        <input type="hidden" name="AccionLocal" value="1">
                    </form>
                    <form class="formulario" id="formulario" name="formulario" action="mainpage.php">
                        <input type="hidden" name="Pagina" value="<?php echo $PaginaFormulario;?>">
                        <input type="hidden" name="Action" value="">
                        <input type="hidden" name="TipoBusqueda" value="<?php echo $TipoBusqueda;?>">
                        <input type="hidden" name="Accion" value="muestraVista">
                        <input type="hidden" name="AccionLocal" value="1">
                        <fieldset>
                            <center>
                                <legend style="text-align: center;"><b> DIRECTORIO TELEFONICO - PRONIED</b><br>Jr. Carabaya Nº 341 - Lima - Central Telefónica: 615-5960</legend>
                                <br>A continuación se listará el directorio del Personal Institucional
                            </center>
                        </fieldset>
                        <?php 
                        if ($TipoBusqueda == 1)
                        {
                            $btn1 = 1;
                            $btn2 = 0;
                        }
                        else
                        {
                            if ($TipoBusqueda == 2)
                            {
                                $btn1 = 0;
                                $btn2 = 1;
                            }
                            else
                            {
                                $TipoBusqueda = 1;
                                $btn1 = 1;
                                $btn2 = 0;
                            }
                        }
                        ?>
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    <input class="<?php if ($btn1 == 1){ echo "buttonAct";}else{ echo "buttonDes";}?>" type="button" value="Genérico" onclick="VerDatos(1);">
                                    <input class="<?php if ($btn2 == 1){ echo "buttonAct";}else{ echo "buttonDes";}?>" type="button" value="Detallado" onclick="VerDatos(2);">
                                </td>
                                <td style="text-align: right; width: 50%; height: 20px;">
                                    <select name="FormatoDescarga" id="FormatoDescarga" onchange="GeneraDescarga();">
                                        <option value="">Descargar en ...</option>
                                        <option value="1">Excel</option>
                                        <option value="2">PDF</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="15%"><h3>CARGO</h3></th>
                                    <th width="15%"><h3 align="center">ANEXO</h3></th>
                                    <th width="15%"><h3 align="center">DIRECTO/RPC</h3></th>
                                    <th width="20%"><h3>NOMBRES Y APELLIDOS</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i      = 1;
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
                                        <td colspan="4" style="text-align: left; background-color: #E3C99F; color: #704A0E;"><b><?php echo "OFICINA: ". $uornombre; ?></b></td>
                                    </tr>
                                        <?php 
                                            }
//                                            else
//                                            {
                                                //$Fcol++;
                                        ?>
                                    <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '<?php echo $ColorX; ?>';">
                                        <td style="text-align: left;"><?php echo $cargo; ?></td>
                                        <td style="text-align: center;"><?php echo $Anexo; ?></td>
                                        <td style="text-align: center;"><?php echo $Celular; ?></td>
                                        <td style="text-align: left;"><?php echo $Persona; ?></td>
                                    </tr>
                                        <?php
//                                            }
                                        $i++;
                                        }
                                        //$Permiso = 0;
                                        
                                    }
                                ?>
                                    
                                <?php
                                }
                                else
                                {
                                    echo "<tr><td colspan='6'><br><center>NO SE LOGRÓ ENCONTRAR INFORMACIÓN EN ESTE MOMENTO</center><br></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </body>
    </html>
    <?php
}
?>