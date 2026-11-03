<?php
function muestraVista() {
    require_once("mensajes.php");
    $lCollection = Collection::Singleton();
//    $PaginaFormulario = $lCollection->Get('PaginaFormulario');
    $lstCumples = $lCollection->Get('lstCumples');
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
            <script>
                function pulsar(e) {
                    tecla = (document.all) ? e.keyCode : e.which;
                    return (tecla != 13);
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
                    <form class="formulario" id="formulario" name="formulario">
                        <fieldset>
                            <legend><b> CUMPLEAÑOS DE LA INSTITUCIÓN</b></legend>
                            A continuación se listará los cumpleaños del mes de: <?php echo Mes(date("m"),1);?> y <?php echo Mes(date("m") + 1,1);?>
                            <p>
                                <label>BUSCAR</label> 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="query" onkeyup="sorter.search('query')" size="60" onkeypress="return pulsar(event)"/>
                                <input name="val" type="hidden" id="val" value="0"/>
                                (Personas o por Unidad)
                            </p>
                        </fieldset>
                        <br>
                        <hr style="border: 0; height: 0; box-shadow: 0 0 10px 1px dimgray;">
                        <br>
                        <?php require_once(PATH_LIB . '/paginacion.php'); ?>
                        <?php cabtabla(); ?>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N°&ordm;</h3></th>
                                    <th style="text-align: left;" width="40%"><h3>&nbsp;&nbsp;Colaborador</h3></th>
                                    <th class="nosort" width="40%"><h3>Oficina</h3></th>
                                    <th width="15%"><h3>Cumpleaños</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $listaCumples  = count($lstCumples) > 0 ? true : false;
                                if (($listaCumples == true) || ($listaCumples > 0))
                                {
                                    foreach ($lstCumples as $ObjCumples) 
                                    {
                                        $i++;
                                        $ApellidoP           = $ObjCumples->PerApePaterno;
                                        $ApellidoM           = $ObjCumples->PerApeMaterno;
                                        $Nombre              = $ObjCumples->PerNombres;
                                        $FechaNacimiento     = date_format($ObjCumples->PerFecNacimiento, 'd');
                                        $mesNacimiento       = date_format($ObjCumples->PerFecNacimiento, 'm');
                                        $UnidadOrganica      = $ObjCumples->UorNombre;
                                        $NomPersona          = $Nombre . " " . $ApellidoP . " " . $ApellidoM;
                                        $ColorX = ColorFilaGris($i);
                                ?>
                                    <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '<?php echo $ColorX; ?>';
                                            this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '<?php echo $ColorX; ?>';">
                                        <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                        <td style="text-align: left;"><?php echo $NomPersona; ?></td>
                                        <td style="text-align: left;"><?php echo $UnidadOrganica; ?></td>
                                        <td style="text-align: center;"><?php echo $FechaNacimiento." ".Mes($mesNacimiento,1);?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                    }
                                } else {
                                    echo "<tr><td colspan='6'><br><center>NO SE LOGRÓ ENCONTRAR INFORMACIÓN EN ESTE MOMENTO</center><br></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php downtabla(); ?>
                        <script type="text/javascript" src="<?php echo RECURSOSPROY; ?>js/table.js"></script>
                        <script type="text/javascript" src="<?php echo RECURSOSPROY; ?>js/tableconfig.js"></script>
                    </form>
                </div>
            </div>
        </body>
    </html>
    <?php
}
?>