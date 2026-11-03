<?php

function muestraVista() {
    require_once("mensajes.php");
//    $lCollection = Collection::Singleton();
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
            <!--
            <div id="wrap">
                <div id="content">
                    <form class="formulario" id="formulario" name="formulario">
                        <fieldset>
                            <legend><b> FERIADOS 2016</b></legend>
                            Todas las fechas especiales y feriados de este calendario estan regidos con las politicas nacionales e internacionales que rigen en Peru.
                            <hr style="border: 1; height: 1; border-color: #3B3A33;"/>
                        </fieldset>
                        <br>
                        <hr style="border: 0; height: 0; box-shadow: 0 0 10px 1px dimgray;">
                        <br>
                        <table border="0" id="table" class="tinytable">
                            <thead>
                                <tr>
                                    <th width="5%"><h3>N&ordm;</h3></th>
                                    <th style="text-align: left;" width="15%"><h3>&nbsp;&nbsp;Fecha</h3></th>
                                    <th style="text-align: center;" class="nosort" width="85%"><h3>Motivo</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>1 Enero</td>
                                    <td style="text-align: left;">Año Nuevo</td>
                                </tr>
                                <?php
                                $i = 2;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>24 Marzo</td>
                                    <td style="text-align: left;">Jueves Santo (Semana Santa)</td>
                                </tr>
                                <?php
                                $i = 3;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>25 Marzo</td>
                                    <td style="text-align: left;">Viernes Santo (Semana Santa)</td>
                                </tr>
                                <?php
                                $i = 4;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>1 Mayo</td>
                                    <td style="text-align: left;">Día del Trabajo</td>
                                </tr>
                                <?php
                                $i = 5;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>29 Junio</td>
                                    <td style="text-align: left;">Festividad de San Pedro y San Pablo</td>
                                </tr>
                                <?php
                                $i = 6;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>28 Julio</td>
                                    <td style="text-align: left;">Fiesta de la Independencia Nacional</td>
                                </tr>
                                <?php
                                $i = 7;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>29 Julio</td>
                                    <td style="text-align: left;">Fiesta de la Independencia Nacional(2)</td>
                                </tr>
                                <?php
                                $i = 8;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>30 Agosto</td>
                                    <td style="text-align: left;">Festividad de Santa Rosa de Lima</td>
                                </tr>
                                <?php
                                $i = 9;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>8 Octubre</td>
                                    <td style="text-align: left;">Celebración de la Batalla de Angamos</td>
                                </tr>
                                <?php
                                $i = 10;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>1 Noviembre</td>
                                    <td style="text-align: left;">Día de Todos los Santos</td>
                                </tr>
                                <?php
                                $i = 11;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>8 Diciembre</td>
                                    <td style="text-align: left;">Día de la Inmaculada Concepción</td>
                                </tr>
                                <?php
                                $i = 12;
                                $ColorX = ColorFila($i);
                                ?>
                                <tr bgcolor="<?php echo $ColorX; ?>" onmouseover="this.style.backgroundColor = '#FAF1D4'; this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor='<?php echo $ColorX; ?>';">
                                    <td style="background-color: #3B3A33; color: #ffffff;"><?php echo $i; ?>-</td>
                                    <td>25 Diciembre</td>
                                    <td style="text-align: left;">Navidad</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            -->
            PÁGINA EN CONSTRUCCIÓN
        </body>
    </html>
    <?php
}
?>