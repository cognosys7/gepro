<?php
function muestraVista() {
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
                            <legend><b> DIRECTORIO TELEFÓNICO DE EMERGENCIAS</b></legend>
                            A continuación se listará el directorio del Personal Institucional
                            <br/>
                            <hr style="border: 1; height: 1; border-color: #0A437A"/>
                            <br/>
                            
                        </fieldset>
                        <br>
                        <hr style="border: 0; height: 0; box-shadow: 0 0 10px 1px dimgray;">
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th class="nosort" style="text-align: left;" width="5%"><h3>&nbsp;&nbsp;N°</h3></th>
                                    <th class="nosort" style="text-align: left;" width="65%"><h3>&nbsp;&nbsp;Institución</h3></th>
                                    <th class="nosort" width="30%"><h3>Teléfono</h3></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFilaNaranja($i);?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '<?php echo $ColorX; ?>';">
                                    <td><?php echo $i;?></td>
                                    <td>PNP Emergencias</td>
                                    <td style="text-align: left;">105</td>
                                </tr>
                                <?php 
                                $i = 2;
                                $ColorX = ColorFilaNaranja($i);?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '<?php echo $ColorX; ?>';">
                                    <td><?php echo $i;?></td>
                                    <td>Bomberos Central</td>
                                    <td style="text-align: left;">116 ó 222-0222</td>
                                </tr>
                                <?php 
                                $i = 3;
                                $ColorX = ColorFilaNaranja($i);?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '<?php echo $ColorX; ?>';">
                                    <td><?php echo $i;?></td>
                                    <td>SEDAPAL</td>
                                    <td style="text-align: left;">317-8000</td>
                                </tr>
                                <?php 
                                $i = 4;
                                $ColorX = ColorFilaNaranja($i);?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FBE7A7'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '<?php echo $ColorX; ?>';">
                                    <td><?php echo $i;?></td>
                                    <td>EDELNOR</td>
                                    <td style="text-align: left;">517-1717</td>
                                </tr>
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